<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Country;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.tour', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.list', compact('orders'))->with('title', 'Orders');
    }

    public function show($id)
    {
        $order = Order::with('orderItems.tour', 'user')->findOrFail($id);
        
        // Get country name from country ID
        $country = null;
        if ($order->passenger_country) {
            $country = Country::find($order->passenger_country);
        }

        // Get config for tax percentages
        $config = \Illuminate\Support\Facades\View::shared('config', []);

        return view('admin.orders.show', compact('order', 'country', 'config'))->with('title', 'Order ' . $order->order_number);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,refunded,completed',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order = Order::findOrFail($id);
        $order->update($validatedData);

        return redirect()->route('admin.orders.show', $id)->with('notify_success', 'Order updated successfully.');
    }
}
