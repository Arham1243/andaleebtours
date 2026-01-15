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

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('notify_error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    /**
     * Get cancellation charges for a booking (Admin)
     */
    public function getCancellationCharges(
        Request $request,
        HotelService $hotelService
    ) {
        $request->validate([
            'booking_id' => 'required|integer',
        ]);

        $booking = HotelBooking::findOrFail($request->booking_id);

        $charges = $hotelService->getCancellationCharges($booking);

        return view(
            'frontend.partials.cancellation-charges',
            compact('booking', 'charges')
        );
    }

    public function cancel($id, HotelService $hotelService)
    {
        $booking = HotelBooking::where(function ($q) {
            $user = auth()->user();
            $q->where('user_id', $user->id)
                ->orWhere('lead_email', $user->email);
        })->findOrFail($id);

        if ($booking->booking_status === 'cancelled') {
            return back()->with('notify_error', 'Booking already cancelled');
        }

        DB::beginTransaction();

        try {
            $charges = $hotelService->getCancellationCharges($booking);

            $response = $hotelService->cancelYalagoBooking($booking, $charges);

            $booking->update([
                'booking_status' => 'cancelled',
                'cancelled_at'   => now(),
                'cancelled_by'   => 'user',
                'cancel_response' => $response,
            ]);

            DB::commit();

            $this->sendCancellationEmails($booking);

            return redirect()
                ->route('user.hotels.show', $booking->id)
                ->with('notify_success', 'Booking cancelled successfully');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Hotel cancellation failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with(
                'notify_error',
                'Unable to cancel booking. Please contact support.'
            );
        }
    }

    protected function sendCancellationEmails(HotelBooking $booking)
    {
        try {
            Mail::send(
                'emails.hotel-booking-cancelled-user',
                ['booking' => $booking],
                function ($message) use ($booking) {
                    $message->to($booking->lead_email)
                        ->subject('Booking Cancelled - ' . $booking->booking_number);
                }
            );

            Mail::send(
                'emails.hotel-booking-cancelled-admin',
                ['booking' => $booking],
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
