<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans;
use Midtrans\Config;
use Midtrans\CoreApi;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index()
    {
        return view('payment');
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
