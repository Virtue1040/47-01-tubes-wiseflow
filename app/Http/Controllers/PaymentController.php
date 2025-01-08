<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans;
use Midtrans\Config;
use Midtrans\CoreApi;
use App\Models\Rent;
use App\Models\Order;
use App\Models\orderdetails;
use App\Models\payments;
use App\Models\Resident;
use App\Models\Booking;
use App\Models\Property;
use App\Models\iuran_pay;
use App\Services\StreamChatService;

class PaymentController extends Controller
{
    protected $streamChatService;
    public function __construct(StreamChatService $streamChatService)
    {
        $this->streamChatService = $streamChatService;
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index()
    {
        return view('view.all-transaction');
    }

    public function get(Request $request) {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $payments = payments::select(
            'checkNumber',
            'id_transaction',
            'nominal',
            'status_payment',
            'type_payment',
            'payment_date',
        )
        ->when($filter, function ($query, $search) {
            $query->where('nominal', 'like', "%{$search}%")
                  ->orWhere('type_payment', 'like', "%{$search}%")
                  ->orWhere('id_transaction', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Payments",
            "data" => $payments,
        ], 200);
    }

    public function returnStatus($transaction_status) {
        switch ($transaction_status) {
            case "capture":
                    return true;
                break;
            case "settlement":
                    return true;
                break;   
        } 
        return false;
    }

    public function callback(Request $request) {

        $order_id = $request->input('order_id');
        $transaction_id = $request->input("transaction_id");
        $status_code = $request->input('status_code');
        $gross_amount = $request->input('gross_amount');
        $transaction_status = $request->input('transaction_status');
        $signature_key = $request->input('signature_key');
        if (isset($signature_key)) {
            $ServerKey = Config::$serverKey;

            $getSignature = hash('sha512', ($order_id . $status_code . $gross_amount . $ServerKey));
            if ($signature_key === $getSignature) {
                $order = Order::where('orderNumber', $order_id)->first();

                if ($order === null) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Order not found'
                    ]);
                }

                $orderdetails = orderdetails::where('orderNumber', $order_id)->first();

                if ($this->returnStatus($transaction_status)) {
                    $orderdetails->status = 'success';
                    $orderdetails->save();

                    switch ($orderdetails->type_order) {
                        case "booking":
                            $booking = Booking::where('orderNumber', $order_id)->first();
                            $booking->status = 'paid';
                            $booking->save();

                            $resident = Resident::create([
                                'id_user' => $booking->id_user,
                                'id_property' => $booking->id_property,
                                'id_rent' => $booking->id_rent,
                                'checkin' => $booking->checkin,
                                'checkout' => $booking->checkout,
                                'id_booking' => $booking->id_booking,
                            ]);

                            $booking->property->property_bank = $booking->property->property_bank + $gross_amount;
                            $booking->property->save();

                            $channel = $this->streamChatService->createChannel(
                                'team',
                                [strval($booking->id_user)],
                                $booking->property->property_name
                            );
                            break;
                        case "iuran":
                            $iuran_pay = iuran_pay::create([
                                'id_user' => $order->id_user,
                                'id_iuran' => $orderdetails->id_item,
                                'orderNumber' => $order->orderNumber,
                                'nominal' => $gross_amount,
                            ]);
                            break;
                    }
                } else {
                    $orderdetails->status = 'failed';
                    $order->status = 'failed';
                    $orderdetails->save();
                    $order->save();

                    switch ($orderdetails->type_order) {
                        case "booking":
                            $booking = Booking::where('orderNumber', $order_id)->first();
                            $booking->delete();
                            break;
                        case "iuran":

                            break;
                    }
                }
                $payment = payments::create([
                    'checkNumber' => "CHECK-" . uniqid(),
                    'id_transaction' => $transaction_id,
                    'nominal' => $gross_amount,
                    'status_payment' => $transaction_status,
                    'type_payment' => 'midtrans',
                    'payment_date' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        $transaction_details = array(
            'order_id'    => time(),
            'gross_amount'  => 200000
          );

          $items = array(
            array(
                'id'       => 'item1',
                'price'    => 100000,
                'quantity' => 1,
                'name'     => 'Adidas f50'
            ),
            array(
                'id'       => 'item2',
                'price'    => 50000,
                'quantity' => 2,
                'name'     => 'Nike N90'
            )
        );
        $billing_address = array(
            'first_name'   => "Andri",
            'last_name'    => "Setiawan",
            'address'      => "Karet Belakang 15A, Setiabudi.",
            'city'         => "Jakarta",
            'postal_code'  => "51161",
            'phone'        => "081322311801",
            'country_code' => 'IDN'
        );

        $customer_details = array(
            'first_name'       => "Andri",
            'last_name'        => "Setiawan",
            'email'            => "test@test.com",
            'phone'            => "081322311801",
            'billing_address'  => $billing_address,

        );

        $transaction_data = array(
            'payment_type' => 'gopay',
            'transaction_details' => $transaction_details,
            'item_details'        => $items,
            'customer_details'    => $customer_details
        );
        $response = CoreApi::charge($transaction_data);
        return $response;
    }
}
