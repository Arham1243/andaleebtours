@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">

            {{-- Breadcrumbs --}}
            {{ Breadcrumbs::render('user.hotels.show', $booking) }}

            {{-- Header --}}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header d-flex justify-content-between align-items-center">
                    <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    @if (in_array($booking->payment_status, ['failed', 'pending']))
                        <a href="{{ route('user.hotels.pay-again', $booking->id) }}" class="themeBtn">Pay Now</a>
                    @endif
                </div>
            </div>

            {{-- Booking Summary --}}
            <div class="row mt-3">
                <div class="col-md-12">
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
                                        <input type="text" class="field" value="{{ $booking->lead_email }}" readonly>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="title">Phone:</label>
                                        <input type="text" class="field" value="{{ $booking->lead_phone }}" readonly>
                                    </div>
                                    <div class="col-md-6 mt-4">
                                        <label class="title">Address:</label>
                                        <input type="text" class="field" value="{{ $booking->lead_address }}" readonly>
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
                                                <td>Flight #: {{ $flight['outbound']['flight_number'] ?? 'N/A' }}, Arrival:
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

                        {{-- Cancel Booking --}}
                        @if ($booking->booking_status === 'confirmed' && $booking->payment_status === 'paid')
                            <div class="form-box mb-4">
                                <div class="form-box__header">
                                    <div class="title">Cancel Booking</div>
                                </div>
                                <div class="form-box__body">
                                    <p><strong>Note:</strong> Refunds may take 10-15 working days if the booking is
                                        refundable. Non-refundable bookings or bookings within cancellation deadline have no
                                        refund.</p>
                                    <button type="button" class="themeBtn cancel-booking-btn" data-booking-id="{{ $booking->id }}">
                                        Cancel Booking
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
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
                    "{{ route('user.hotels.cancellation.charges') }}", {
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
