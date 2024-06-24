<?php

namespace App\Http\Controllers;

use App\Jobs\MonitorOrder;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate only the necessary fields
        $request->validate([
            'shipping_fullname' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:15',
            'payment_method' => 'required|string',
        ]);

        $order = new Order();

        $order->order_number = uniqid('OrderNumber-');
        $order->shipping_fullname = $request->input('shipping_fullname');
        $order->shipping_address = $request->input('shipping_address');
        $order->shipping_phone = $request->input('shipping_phone');
        $order->shipping_state = $request->input('shipping_state') ?? 'default_state'; // Default value if not provided
        $order->shipping_city = $request->input('shipping_city') ?? 'default_city'; // Default value if not provided
        $order->shipping_zipcode = $request->input('shipping_zipcode') ?? 'default_zipcode'; // Default value if not provided

        if (!$request->has('billing_fullname')) {
            $order->billing_fullname = $request->input('shipping_fullname');
            $order->billing_state = $order->shipping_state;
            $order->billing_city = $order->shipping_city;
            $order->billing_address = $order->shipping_address;
            $order->billing_phone = $order->shipping_phone;
            $order->billing_zipcode = $order->shipping_zipcode;
        } else {
            $order->billing_fullname = $request->input('billing_fullname');
            $order->billing_state = $request->input('billing_state') ?? 'default_state';
            $order->billing_city = $request->input('billing_city') ?? 'default_city';
            $order->billing_address = $request->input('billing_address');
            $order->billing_phone = $request->input('billing_phone');
            $order->billing_zipcode = $request->input('billing_zipcode') ?? 'default_zipcode';
        }

        $order->grand_total = \Cart::session(Auth::id())->getTotal();
        $order->item_count = \Cart::session(Auth::id())->getContent()->count();
        $order->user_id = Auth::id();

        if ($request->input('payment_method') == 'paypal') {
            $order->payment_method = 'paypal';
        }

        $order->save();

        $cartItems = \Cart::session(Auth::id())->getContent();

        foreach ($cartItems as $item) {
            $order->items()->attach($item->id, ['price' => $item->price, 'quantity' => $item->quantity]);
        }

        $order->generateSubOrders();

        if ($request->input('payment_method') == 'paypal') {
            MonitorOrder::dispatch($order)->delay(now()->addMinutes(1));
            return redirect()->route('paypal.checkout', $order->id);
        }

        \Cart::session(Auth::id())->clear();

        return redirect()->route('home')->with('message', 'Order has been placed');
    }
}
