@extends('admin.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('admin.orders.index') }}
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
                                    <th>Order Number</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="link">{{ $order->order_number }}</a>
                                        </td>
                                        <td>{{ $order->passenger_first_name }} {{ $order->passenger_last_name }}</td>
                                        <td>{{ $order->passenger_email }}</td>
                                        <td>{{ $order->passenger_phone }}</td>
                                        <td>{{ formatPrice($order->total) }}</td>
                                        <td>
                                            {{ strtoupper($order->payment_method) }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : ($order->payment_status == 'refunded' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-{{ $order->status == 'confirmed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'refunded' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ formatDateTime($order->created_at) }}</td>
                                        <td>
                                            <a style="white-space: nowrap;"
                                                href="{{ route('admin.orders.show', $order->id) }}" class="themeBtn"><i
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
