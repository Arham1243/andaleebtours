<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Services\HotelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HotelBookingController extends Controller
{

    public function index()
    {
        $bookings = HotelBooking::orderBy('created_at', 'desc')
            ->get();

        return view('admin.hotel-bookings.list', compact('bookings'))->with('title', 'Hotel Bookings');
    }

    public function show($id)
    {
        // Get order only if it belongs to this user (by user_id or email)
        $booking = HotelBooking::findOrFail($id);

        return view('admin.hotel-bookings.show', compact('booking'))->with('title', 'Booking ' . $booking->booking_number);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled,refunded,completed',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $booking = HotelBooking::findOrFail($id);
        $booking->update($validatedData);

        return redirect()->route('admin.hotel-bookings.show', $id)->with('notify_success', 'Booking updated successfully.');
    }

    /**
     * Get cancellation charges for a booking (Admin)
     */
    public function getCancellationCharges(Request $request, HotelService $hotelService)
    {
        $request->validate([
            'booking_id' => 'required|integer'
        ]);

        $booking = HotelBooking::findOrFail($request->booking_id);

        // Call service to get cancellation charges
        $response = $hotelService->getCancellationCharges($booking);

        return view(
            'frontend.partials.cancellation-charges',
            compact('booking', 'response')
        );
    }

    /**
     * Cancel a booking (Admin)
     */
    public function cancel($id, HotelService $hotelService)
    {
        try {
            $booking = HotelBooking::findOrFail($id);

            if ($booking->booking_status === 'cancelled') {
                return back()->with('notify_error', 'This booking is already cancelled.');
            }

            if ($booking->payment_status !== 'paid') {
                return back()->with('notify_error', 'Only paid bookings can be cancelled.');
            }

            DB::beginTransaction();

            // 1️⃣ Fetch latest cancellation charges
            $charges = $hotelService->getCancellationCharges($booking);

            // 2️⃣ Cancel at supplier with ExpectedCharge
            $cancelResponse = $hotelService->cancelYalagoBooking(
                $booking,
                $charges
            );

            // 3️⃣ Update local booking
            $booking->update([
                'booking_status'  => 'cancelled',
                'cancelled_at'    => now(),
                'cancelled_by'    => 'admin',
                'cancel_response' => $cancelResponse,
            ]);

            DB::commit();

            // 4️⃣ Email user only
            $this->sendCancellationEmailToUser($booking);

            Log::info('Hotel booking cancelled by admin', [
                'booking_id'     => $booking->id,
                'booking_number' => $booking->booking_number,
            ]);

            return redirect()
                ->route('admin.hotel-bookings.show', $booking->id)
                ->with('notify_success', 'Booking cancelled successfully.');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Admin hotel booking cancellation failed', [
                'booking_id' => $id,
                'error'      => $e->getMessage(),
            ]);

            return back()->with(
                'notify_error',
                'Failed to cancel booking. Please contact support.'
            );
        }
    }

    /**
     * Send cancellation email to user only (Admin)
     */
    protected function sendCancellationEmailToUser(HotelBooking $booking): void
    {
        try {
            Mail::send(
                'emails.hotel-booking-cancelled-user',
                ['booking' => $booking],
                function ($message) use ($booking) {
                    $message->to($booking->lead_email)
                        ->subject(
                            'Booking Cancelled by Admin - ' . $booking->booking_number
                        );
                }
            );

            Log::info('Admin cancellation email sent', [
                'booking_id' => $booking->id,
                'user_email' => $booking->lead_email,
            ]);
        } catch (\Throwable $e) {

            Log::error('Failed to send admin cancellation email', [
                'booking_id' => $booking->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
