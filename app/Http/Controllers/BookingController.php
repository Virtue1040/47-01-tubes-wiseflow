<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Midtrans;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Rent;
use App\Models\Order;
use App\Models\orderdetails;
use App\Models\payments;
use App\Models\Resident;
use DateTime;

class BookingController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('view.booking');
    }

    public function index2()
    {
        return view('view.all-booking');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebookingRequest $request)
    {
        $request->validate([
            "id_rent" => ['required', 'exists:rents,id_rent'],
            "checkin_date" => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            "checkin_time" => ['required', 'date_format:H:i'],
            "checkout_date" => [
                'required',
                'date',
                'after_or_equal:checkin_date', 
            ],
            "checkout_time" => ['required', 'date_format:H:i'],
        ]);

        $getRent = Rent::find($request->id_rent);
        if ($getRent->availability === 0) {
            return response()->json([
                "success" => false,
                "message" => "Rumah tidak tersedia",
            ], 200);
        }
        $getResident = Resident::where('id_rent', $request->id_rent)->count();
        if ($getResident >= $getRent->stock) {
            return response()->json([
                "success" => false,
                "message" => "Stock sudah penuh",
            ], 200);
        }

        $checkIn = new DateTime($request->checkin_date);
        $checkOut = new DateTime($request->checkout_date);
        $getTotalDay = $checkIn->diff($checkOut)->days;
        $price = $getRent->rent_price * $getTotalDay;

        $makeOrder = "ORDER-BOOK-" . uniqid() . time();
        $order = Order::create([
            'orderNumber' => $makeOrder,
            'id_user' => Auth::user()->id_user,
        ]);

        $orderdetails = orderdetails::create([
            'orderNumber' => $makeOrder,
            'checkNumber' => 'PAYMENT-' . time(),
            'status' => 'pending',
            'type_order' => 'booking',
            'id_item' => $getRent->id_rent,
            'quantity' => 1,
            'total_order' => $price,
        ]);

        $booking = Booking::create([
            'id_user' => Auth::user()->id_user,
            'id_property' => $getRent->id_property,
            'id_rent' => $getRent->id_rent,
            'checkin' => $request->checkin_date . ' ' . $request->checkin_time,
            'checkout' => $request->checkout_date . ' ' . $request->checkout_time,
            'orderNumber' => $makeOrder,
            'status' => 'unpaid',
        ]);

        $transaction_details = array(
            'order_id'    => $makeOrder,
            'gross_amount'  => $price,
          );

        $items = array(
            array(
                'id'       => $getRent->id_rent,
                'price'    => $price,
                'quantity' => 1,
                'name'     => 'Booking Rent ' . $getRent->rent_name 
            ),
        );

        $token = Snap::getSnapToken([
            'transaction_details' => $transaction_details,
            'item_details'        => $items,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Berhasil membuat data Booking",
            "data" => $booking,
            "token" => $token,
        ], 200);
    }

    public function callback(Request $request) {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        
    }

    public function get(Booking $book, Request $request)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $bookings = $book::select(
            'id_booking',
            'orderNumber',
            'bookings.id_user',
            'bookings.id_property',
            'bookings.id_rent',
            'property_name',
            'rent_name',
            'checkin',
            'checkout',
            'isRated',
            'status',
        )
        ->join('property', 'bookings.id_property', '=', 'property.id_property')
        ->join('rents', 'bookings.id_rent', '=', 'rents.id_rent')
        ->where('id_user', Auth::user()->id_user)
        ->when($filter, function ($query, $search) {
            $query->where('status', 'like', "%{$search}%")
                  ->orWhere('id_booking', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Booking",
            "data" => $bookings,
        ], 200);
    }

    public function getAll(Booking $book, Request $request)
    {
        $limit = $request->maxPage;
        $filter = $request->search;
        $page = $request->page;
        $groupBy = $request->groupBy;
        $bookings = $book::select(
            'id_booking',
            'orderNumber',
            'bookings.id_user',
            'bookings.id_property',
            'bookings.id_rent',
            'property_name',
            'rent_name',
            'checkin',
            'checkout',
            'isRated',
            'status',
        )
        ->join('property', 'bookings.id_property', '=', 'property.id_property')
        ->join('rents', 'bookings.id_rent', '=', 'rents.id_rent')
        ->when($filter, function ($query, $search) {
            $query->where('status', 'like', "%{$search}%")
                  ->orWhere('id_booking', 'like', "%{$search}%");
        })->when($request->orderBy, function ($query) use ($request) {
            $orderBy = $request->orderBy;
            $query->orderBy($orderBy, 'desc'); 
        })->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data Booking",
            "data" => $bookings,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking, $id, Request $request)
    {
        $booking = $booking::where("id_booking", $id)->where("id_user", Auth::user()->id_user)->where("status", "unpaid")->first();
        $booking->delete();
        if ($request->header('Accept') === 'application/json') {
            return response()->json([
                "success" => true,
                "message" => "Berhasil menghapus data Booking",
            ], 200);
        } else {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'Booking Deleted',
            ]);
            return redirect()->back();
        }
    }
}
