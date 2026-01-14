<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\Config;
use App\Services\HotelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HotelController extends Controller
{
    protected $adminEmail;
    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->adminEmail = $config['ADMINEMAIL'] ?? 'info@andaleebtours.com';
    }

    public function index()
    {
        $user = auth()->user();

        // Get hotels for this user (both authenticated and guest hotels by email)
        $hotels = HotelBooking::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('lead_email', $user->email);
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.hotels.list', compact('hotels'))->with('title', 'My Hotel Bookings');
    }

    public function show($id)
    {
        $user = auth()->user();

        // Get order only if it belongs to this user (by user_id or email)
        $booking = HotelBooking::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('lead_email', $user->email);
        })
            ->findOrFail($id);

        return view('user.hotels.show', compact('booking'))->with('title', 'Booking ' . $booking->booking_number);
    }

    public function destroy($id)
    {
        $booking = HotelBooking::where('id', $id)->firstOrFail();
        $booking->delete();
        return redirect()->route('user.hotels.index')->with('notify_success', 'Order deleted successfully!');
    }

    public function payAgain($id)
    {
        $booking = HotelBooking::where('id', $id)->firstOrFail();
        return view('user.hotels.pay-again', compact('booking'))->with('title', 'Pay Again');
    }

    public function proceedPayAgain(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:payby,tabby',
        ]);

        $booking = HotelBooking::where('id', $id)
            ->where(function ($query) {
                $query->where('payment_status', 'pending')
                    ->orWhere('payment_status', 'failed');
            })
            ->firstOrFail();

        // Update payment method and set status to pending
        $booking->update([
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        try {
            // Use your HotelService to get redirect URL
            $hotelService = app(\App\Services\HotelService::class);
            $redirectUrl = $hotelService->getRedirectUrl($booking, $request->payment_method);
            dd($redirectUrl);

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('notify_error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    public function getCancellationCharges(Request $request, HotelService $hotelService)
    {
        $request->validate([
            'booking_id' => 'required|integer'
        ]);

        $user = auth()->user();

        $booking = HotelBooking::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('lead_email', $user->email);
        })->findOrFail($request->booking_id);

        $response = $hotelService->getCancellationCharges($booking);

        return view(
            'frontend.partials.cancellation-charges',
            compact('booking', 'response')
        );
    }

    public function cancel($id, HotelService $hotelService)
    {
        $user = auth()->user();

        try {
            $booking = HotelBooking::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('lead_email', $user->email);
            })->findOrFail($id);

            if ($booking->booking_status === 'cancelled') {
                return back()->with('notify_error', 'This booking is already cancelled.');
            }

            if ($booking->payment_status !== 'paid') {
                return back()->with('notify_error', 'Only paid bookings can be cancelled.');
            }

            DB::beginTransaction();

            // 🔥 Cancel booking at supplier
            $hotelService->cancelYalagoBooking($booking);

            // 🔄 Update local booking
            $booking->update([
                'booking_status' => 'cancelled',
                'cancelled_at'   => now(),
                'cancelled_by'   => 'user',
            ]);

            DB::commit();

            $this->sendCancellationEmails($booking);

            Log::info('Hotel booking cancelled by user', [
                'booking_id'     => $booking->id,
                'booking_number' => $booking->booking_number,
                'user_id'        => $user->id,
            ]);

            return redirect()
                ->route('user.hotels.show', $booking->id)
                ->with('notify_success', 'Booking cancelled successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Hotel booking cancellation failed', [
                'booking_id' => $id,
                'error'      => $e->getMessage(),
            ]);

            return back()->with(
                'notify_error',
                'Failed to cancel booking. Please contact support.'
            );
        }
    }

    protected function sendCancellationEmails(HotelBooking $booking)
    {
        try {
            $booking->loadMissing('orderItems');

            Mail::send(
                'emails.hotel-booking-cancelled-user',
                ['order' => $booking],
                function ($message) use ($booking) {
                    $message->to($booking->lead_email)
                        ->subject('Booking Cancelled - ' . $booking->booking_number);
                }
            );

            Mail::send(
                'emails.hotel-booking-cancelled-admin',
                ['order' => $booking],
                function ($message) use ($booking) {
                    $message->to($this->adminEmail)
                        ->subject('Booking Cancelled by User - ' . $booking->booking_number);
                }
            );

            Log::info('Hotel cancellation emails sent', [
                'booking_id' => $booking->id,
                'user_email' => $booking->lead_email,
            ]);
        } catch (\Throwable $e) {

            Log::error('Hotel cancellation email failed', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
