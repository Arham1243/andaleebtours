@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.hotel-bookings.show', $booking) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.hotel-bookings.update', $booking->id) }}" method="POST" id="validation-form">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-wrapper">


                            {{-- Booking Summary --}}
                            <div class="form-box mb-4">
                                <div class="form-box__header">
                                    <div class="title">Booking Summary</div>
                                </div>
                                <div class="form-box__body table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Hotel Name:</strong></td>
                                                <td class="text-end">{{ $booking->hotel_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Booking Number:</strong></td>
                                                <td class="text-end">{{ $booking->booking_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Booking Date:</strong></td>
                                                <td class="text-end">{{ formatDate($booking->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Check In / Out:</strong></td>
                                                <td class="text-end">{{ formatDate($booking->check_in_date) }} -
                                                    {{ formatDate($booking->check_out_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Nights:</strong></td>
                                                <td class="text-end">{{ $booking->nights }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td class="text-end">{{ strtoupper($booking->payment_method) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($booking->payment_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Booking Status:</strong></td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $booking->booking_status == 'confirmed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($booking->booking_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Amount:</strong></td>
                                                <td class="text-end"><strong>{!! formatPrice($booking->total_amount) !!}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Rooms --}}
                            @php $rooms = $booking->selected_rooms; @endphp
                            @foreach ($rooms as $index => $room)
                                <div class="form-box mb-4">
                                    <div class="form-box__header">
                                        <div class="title">Room #{{ $index + 1 }}: {{ $room['room_name'] }}</div>
                                    </div>
                                    <div class="form-box__body">
                                        <div class="row mb-2 form-fields">
                                            <div class="col-md-4">
                                                <label class="title">Board Type:</label>
                                                <input type="text" class="field" value="{{ $room['board_title'] }}"
                                                    readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="title">Price:</label>
                                                <input type="text" class="field"
                                                    value="{{ number_format($room['price'], 2) }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            {{-- Lead Details --}}
                            <div class="form-box mb-4">
                                <div class="form-box__header">
                                    <div class="title">Lead Details</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row form-fields">
                                        <div class="col-md-6 mt-4">
                                            <label class="title">Name:</label>
                                            <input type="text" class="field"
                                                value="{{ $booking->lead_title }} {{ $booking->lead_first_name }} {{ $booking->lead_last_name }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="title">Email:</label>
                                            <input type="text" class="field" value="{{ $booking->lead_email }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="title">Phone:</label>
                                            <input type="text" class="field" value="{{ $booking->lead_phone }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="title">Address:</label>
                                            <input type="text" class="field" value="{{ $booking->lead_address }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Guest Details --}}
                            @php $guests = $booking->guests_data; @endphp
                            @if (!empty($guests))
                                <div class="form-box mb-4">
                                    <div class="form-box__header">
                                        <div class="title">Guest Details</div>
                                    </div>
                                    <div class="form-box__body table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Age</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($guests as $guest)
                                                    <tr>
                                                        <td>{{ $guest['title'] }} {{ $guest['first_name'] }}
                                                            {{ $guest['last_name'] }}</td>
                                                        <td>{{ $guest['age'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            {{-- Extras --}}
                            @php $extras = $booking->extras_data; @endphp
                            @if (!empty($extras))
                                <div class="form-box mb-4">
                                    <div class="form-box__header">
                                        <div class="title">Extras</div>
                                    </div>
                                    <div class="form-box__body table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($extras as $extra)
                                                    <tr>
                                                        <td>{{ $extra['title'] }}</td>
                                                        <td>{!! formatPrice($extra['price']) !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            {{-- Flight Details --}}
                            @php
                                $flight = $booking->flight_details;

                                // Flatten both outbound and inbound arrays and check if any value is not null
                                $hasFlight = collect($flight)->flatten()->filter()->isNotEmpty();
                            @endphp

                            @if ($hasFlight)
                                <div class="form-box mb-4">
                                    <div class="form-box__header">
                                        <div class="title">Flight Details</div>
                                    </div>
                                    <div class="form-box__body table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Outbound Flight:</strong></td>
                                                    <td>Flight #: {{ $flight['outbound']['flight_number'] ?? 'N/A' }},
                                                        Arrival:
                                                        {{ $flight['outbound']['arrival_hour'] ?? '' }}:{{ $flight['outbound']['arrival_minute'] ?? '' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Inbound Flight:</strong></td>
                                                    <td>Flight #: {{ $flight['inbound']['flight_number'] ?? 'N/A' }},
                                                        Departure:
                                                        {{ $flight['inbound']['departure_hour'] ?? '' }}:{{ $flight['inbound']['departure_minute'] ?? '' }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="seo-wrapper">
                            <div class="form-box">
                                <div class="form-box__header d-flex align-items-center justify-content-between">
                                    <div class="title">Payment Status</div>
                                    <span
                                        class="badge rounded-pill bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'pending' ? 'warning' : ($booking->payment_status == 'refunded' ? 'info' : 'danger')) }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </div>
                                <div class="form-box__body">
                                    @if ($booking->booking_status !== 'cancelled')
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_status"
                                                id="paid" value="paid"
                                                {{ old('payment_status', $booking->payment_status ?? '') == 'paid' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paid">
                                                Paid
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="payment_status"
                                                id="payment_pending" value="pending"
                                                {{ old('payment_status', $booking->payment_status ?? '') == 'pending' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="payment_pending">
                                                Pending
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="payment_status"
                                                id="payment_failed" value="failed"
                                                {{ old('payment_status', $booking->payment_status ?? '') == 'failed' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="payment_failed">
                                                Failed
                                            </label>
                                        </div>
                                    @endif
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="payment_status"
                                            id="payment_refunded" value="refunded"
                                            {{ old('payment_status', $booking->payment_status ?? '') == 'refunded' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="payment_refunded">
                                            Refunded
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-box mt-3">
                                <div class="form-box__header d-flex align-items-center justify-content-between">
                                    <div class="title">Order Status</div>
                                    <span
                                        class="badge rounded-pill bg-{{ $booking->booking_status == 'confirmed' ? 'success' : ($booking->booking_status == 'pending' ? 'warning' : ($booking->booking_status == 'refunded' ? 'info' : 'danger')) }}">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>
                                <div class="form-box__body">
                                    @if ($booking->booking_status !== 'cancelled')
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="booking_status"
                                                id="confirmed" value="confirmed"
                                                {{ old('booking_status', $booking->booking_status ?? '') == 'confirmed' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="confirmed">
                                                Confirmed
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="booking_status"
                                                id="pending" value="pending"
                                                {{ old('booking_status', $booking->booking_status ?? '') == 'pending' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pending">
                                                Pending
                                            </label>
                                        </div>
                                    @endif
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="radio" name="booking_status"
                                            id="refunded" value="refunded"
                                            {{ old('booking_status', $booking->booking_status ?? '') == 'refunded' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="refunded">
                                            Refunded
                                        </label>
                                    </div>
                                    @if ($booking->booking_status !== 'cancelled')
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="booking_status"
                                                id="completed" value="completed"
                                                {{ old('booking_status', $booking->booking_status ?? '') == 'completed' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="completed">
                                                Completed
                                            </label>
                                        </div>
                                    @endif
                                    <button class="themeBtn ms-auto mt-4">Update Booking</button>
                                </div>
                            </div>

                            @if ($booking->booking_status === 'confirmed' && $booking->payment_status === 'paid')
                                <div class="form-box mt-3">
                                    <div class="form-box__header">
                                        <div class="title">Cancel Booking</div>
                                    </div>
                                    <div class="form-box__body">
                                        <p style="margin-bottom: 15px; color: #666;">
                                            <strong>Note:</strong> The amount will be refunded in 10-15 working days if the
                                            booking is refundable.
                                            In case of Non-Refundable Booking or Booking within Cancellation Deadline, there
                                            will be no refund.
                                        </p>
                                        <button type="button" class="themeBtn cancel-booking-btn"
                                            data-booking-id="{{ $booking->id }}">
                                            Cancel Booking
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="cancelBookingModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancellation Charges</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="cancelBookingModalBody">
                    <div class="text-center py-5">
                        Loading cancellation policy...
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).on('click', '.cancel-booking-btn', function() {
            const bookingId = $(this).data('booking-id');

            const modal = new bootstrap.Modal(
                document.getElementById('cancelBookingModal')
            );

            $('#cancelBookingModalBody').html(
                '<div class="text-center py-5">Loading cancellation policy...</div>'
            );

            modal.show();

            $.post(
                    "{{ route('admin.hotels.cancellation.charges') }}", {
                        booking_id: bookingId,
                        _token: "{{ csrf_token() }}"
                    }
                )
                .done(function(html) {
                    $('#cancelBookingModalBody').html(html);
                })
                .fail(function() {
                    $('#cancelBookingModalBody').html(
                        '<p class="text-danger">Failed to load cancellation policy.</p>'
                    );
                });
        });
    </script>
@endpush
