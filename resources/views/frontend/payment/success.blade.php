@extends('frontend.layouts.main')
@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">

                    <div class="card status-card p-4 p-md-5 text-center">

                        <!-- Success Icon -->
                        <div>
                            <div class="status-icon-wrapper success">
                                <i class='bx bxs-check-circle'></i>
                            </div>
                        </div>

                        <!-- Headline -->
                        <h1 class="h3 fw-bold mb-2">Payment Successful!</h1>
                        <p class="text-muted mb-4">
                            Thank you for your booking. A confirmation email has been sent to your inbox.
                        </p>

                        @if($order)
                            <!-- Transaction Details (The "Receipt") -->
                            <div class="transaction-details mb-4">
                                <div class="detail-row">
                                    <span class="text-muted">Order Number</span>
                                    <span class="fw-medium">{{ $order->order_number }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="text-muted">Date</span>
                                    <span class="fw-medium">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="text-muted">Payment Method</span>
                                    <span class="fw-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                                </div>
                                @if($order->orderItems && $order->orderItems->count() > 0)
                                    <div class="detail-row">
                                        <span class="text-muted">Tours Booked</span>
                                        <span class="fw-medium">{{ $order->orderItems->count() }}</span>
                                    </div>
                                @endif
                                @if(!empty($order->applied_coupons))
                                    <div class="detail-row">
                                        <span class="text-muted">Discount Applied</span>
                                        <span class="fw-medium text-success">-{{ formatPrice($order->discount) }}</span>
                                    </div>
                                @endif
                                <div class="detail-row total">
                                    <span>Amount Paid</span>
                                    <span>{{ formatPrice($order->total) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-4">
                                <p class="mb-0 small">Order details not available. Please check your email for confirmation.</p>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            @auth
                                <a href="{{ route('user.dashboard') }}" class="btn btn-primary-theme btn-lg">View My Bookings</a>
                            @endauth
                            <a href="{{ route('frontend.index') }}" class="btn btn-link text-decoration-none text-muted">Return to Home</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
