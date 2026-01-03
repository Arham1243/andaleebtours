@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.orders.index') }}
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
                                    <th>Tours</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('user.orders.show', $order->id) }}"
                                                class="link">{{ $order->order_number }}</a>
                                        </td>
                                        <td>
                                            @foreach ($order->orderItems as $item)
                                                <div>{{ $item->tour_name }}</div>
                                            @endforeach
                                        </td>
                                        <td>{!! formatPrice($order->total) !!}</td>
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
                                            <div class="dropstart">
                                                <button type="button" class="recent-act__icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class='bx bx-dots-vertical-rounded'></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('user.orders.show', $order->id) }}"
                                                            class="dropdown-item">
                                                            <i class="bx bxs-show"></i>
                                                            View Details
                                                        </a>
                                                    </li>
                                                    @if ($order->status === 'failed')
                                                        <li>
                                                            <a href="{{ route('user.orders.pay-again', $order->id) }}"
                                                                class="dropdown-item">
                                                                <i class="bx bx-credit-card"></i>

                                                                Pay Now
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if ($order->status === 'pending')
                                                        <li>
                                                            <form action="{{ route('user.orders.destroy', $order->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bx bx-trash"></i>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
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
