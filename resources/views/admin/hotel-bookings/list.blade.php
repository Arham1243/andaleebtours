@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.hotel-bookings.index') }}
            <div class="table-container universal-table">
                <div class="custom-sec">
                    <div class="custom-sec__header">
                        <div class="section-content">
                            <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Booking Number</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Booking Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.hotel-bookings.show', $booking->id) }}"
                                                class="link">{{ $booking->booking_number }}</a>
                                        </td>
                                        <td>{{ $booking->lead_first_name }} {{ $booking->lead_last_name }}</td>
                                        <td>{{ $booking->lead_email }}</td>
                                        <td>{{ $booking->lead_phone }}</td>
                                        <td>{{ formatPrice($booking->total_amount) }}</td>
                                        <td>
                                            {{ strtoupper($booking->payment_method) }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-{{ $booking->payment_status == 'paid' ? 'success' : ($booking->payment_status == 'pending' ? 'warning' : ($booking->payment_status == 'refunded' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-{{ $booking->booking_status == 'confirmed' ? 'success' : ($booking->booking_status == 'pending' ? 'warning' : ($booking->booking_status == 'refunded' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($booking->booking_status) }}
                                            </span>
                                        </td>
                                        <td>{{ formatDateTime($booking->created_at) }}</td>
                                        <td>
                                            <a style="white-space: nowrap;"
                                                href="{{ route('admin.hotel-bookings.show', $booking->id) }}" class="themeBtn"><i
                                                    class='bx bxs-show'></i>View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
