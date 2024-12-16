<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('id_user', Auth::user()->id_user)->get();
        return view('view.property.detail.orders', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('view.property.create_order');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $request->validate([
            'orderNumber' => ['required', 'integer', 'unique:orders,orderNumber'],
        ]);

        $order = Order::create([
            'orderNumber' => $request->orderNumber,
            'id_user' => Auth::user()->id_user,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        if ($order->id_user != Auth::user()->id_user) {
            abort(403, 'Unauthorized action.');
        }
        return view('view.property.show_order', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($orderNumber): View
    {
        $order = Order::findOrFail($orderNumber);

        if ($order->id_user != Auth::user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        return view('view.property.edit_order', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $orderNumber)
    {
        $request->validate([
            'orderNumber' => ['required', 'integer', 'unique:orders,orderNumber,' . $orderNumber . ',orderNumber'],
        ]);

        $order = Order::findOrFail($orderNumber);

        if (Auth::user()->id_user != $order->id_user) {
            return response()->json([
                'message' => 'Unauthorized access'
            ], 403);
        }

        $order->orderNumber = $request->orderNumber;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($orderNumber)
    {
        $order = Order::findOrFail($orderNumber);

        if (Auth::user()->id_user != $order->id_user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
