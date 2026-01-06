<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Country;
use App\Services\PrioTicketService;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $adminEmail;
    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->adminEmail = $config['ADMINEMAIL'] ?? 'info@andaleebtours.com';
    }

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

    public function cancel($id)
    {
        try {
            $order = Order::with('orderItems.tour')->findOrFail($id);

            if ($order->status === 'cancelled') {
                return redirect()->back()->with('notify_error', 'This order is already cancelled.');
            }

            if ($order->payment_status !== 'paid') {
                return redirect()->back()->with('notify_error', 'Only paid orders can be cancelled.');
            }

            $prioService = new PrioTicketService();
            $result = $prioService->cancelOrder($order);

            if (!$result['success']) {
                return redirect()->back()->with('notify_error', 'Failed to cancel order: ' . ($result['error'] ?? 'Unknown error'));
            }

            $order->update([
                'status' => 'cancelled',
                'prio_cancel_response' => json_encode($result['cancel_responses'] ?? []),
                'cancelled_at' => now(),
                'cancelled_by' => 'admin'
            ]);

            $order->orderItems()->update([
                'status' => 'cancelled'
            ]);

            $this->sendCancellationEmailToUser($order);

            Log::info('Order cancelled by admin', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'cancelled_by' => auth()->user()->name ?? 'Admin'
            ]);

            return redirect()->route('admin.orders.show', $id)->with('notify_success', 'Order cancelled successfully.');

        } catch (\Exception $e) {
            Log::error('Order cancellation failed', [
                'order_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('notify_error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    protected function sendCancellationEmailToUser(Order $order)
    {
        try {
            $order->load('orderItems');

            Mail::send('emails.booking-cancelled-user', ['order' => $order], function ($message) use ($order) {
                $message->to($order->passenger_email)
                    ->subject('Booking Cancelled - ' . $order->order_number);
            });

            Log::info('Cancellation email sent to customer', [
                'order_id' => $order->id,
                'customer_email' => $order->passenger_email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send cancellation email to customer', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
