@extends('frontend.layouts.main')
@section('content')
    @if ($tours->count() > 0 && !empty($cart))
        <section class="section-gap pb-0">
            <div class="container">
                <h1 class="page-title">Shopping Cart</h1>
                <div class="row">
                    <!-- Left Side: Cart Items -->
                    <div class="col-lg-8">
                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-shopping-bag'></i> Selected Activities
                            </div>

                            @foreach ($tours as $tour)
                                @php
                                    $item = $cart[$tour->id];
                                @endphp

                                @foreach ($item['pax'] as $pax)
                                    <div class="cart-item">
                                        <a href="{{ route('frontend.tour.details', $tour->slug) }}" class="cart-thumb">
                                            <img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="imgFluid">
                                        </a>

                                        <div class="cart-details">
                                            <h5 class="cart-title">
                                                {{ $tour->name }}
                                            </h5>

                                            <div class="cart-meta">
                                                <i class='bx bx-calendar'></i>
                                                Start Date: {{ formatDate($item['date']) }}
                                            </div>

                                            <div class="cart-meta">
                                                <i class='bx bx-time-five'></i>
                                                Time: {{ $item['time_slot'] }}
                                            </div>
                                            <div class="cart-meta">
                                                <i class='bx bx-group'></i>
                                                Guests: {{ $pax['qty'] }} {{ $pax['label'] }}
                                            </div>
                                        </div>

                                        <div class="qty-control">
                                            <button class="qty-btn" type="button"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                <i class="bx bx-minus"></i>
                                            </button>

                                            <input type="number" class="counter-input qty-input"
                                                value="{{ $pax['qty'] }}" readonly>

                                            <button class="qty-btn" type="button"
                                                onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>

                                        <div class="cart-price-area">
                                            <div class="item-calculation">
                                                {{ $pax['qty'] }} <i class='bx bx-x'></i>
                                                {{ formatPrice($pax['price']) }}
                                            </div>

                                            <span class="item-total">
                                                {{ formatPrice($pax['subtotal']) }}
                                            </span>
                                        </div>

                                        <form method="POST" action="{{ route('frontend.cart.remove', $tour->slug) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="pax_type" value="{{ strtolower($pax['label']) }}">
                                            <button type="submit" class="btn-remove"
                                                onclick="return confirm('Are you sure you want to remove?')">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            @endforeach

                            <a href="{{ route('frontend.uae-services') }}" class="btn-outline">
                                <i class='bx bx-left-arrow-alt'></i> Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Right Side: Order Summary -->
                    <div class="col-lg-4">
                        <div class="sticky-sidebar">
                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bx-receipt'></i> Order Summary
                                </div>

                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>{{ formatPrice($subtotal) }}</span>
                                </div>

                                <!-- Coupon Code -->
                                <div class="coupon-wrapper">
                                    <input type="text" class="coupon-input" placeholder="Enter discount code">
                                    <button class="btn-apply-overlay">Apply</button>
                                </div>

                                <div class="summary-row">
                                    <span>Tax (0%)</span>
                                    <span>{{ formatPrice(0) }}</span>
                                </div>

                                <div class="summary-row total">
                                    <span>Total Payable</span>
                                    <span style="color: var(--color-primary)">{{ formatPrice($subtotal) }}</span>
                                </div>

                                <a href="{{ route('frontend.checkout.index') }}" class="btn-primary-custom mt-3">Proceed to
                                    Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="section-gap pt-0">
            <div class="container">
                <div class="empty-cart-state text-center">
                    <div class="empty-cart-img">
                        <img src="{{ asset('frontend/assets/images/empty-cart.webp') }}" alt="Empty Cart"
                            class="img-fluid">
                    </div>

                    <h2 class="empty-title">Your cart is empty</h2>
                    <h4 class="empty-subtitle">You don't have any booking</h4>

                    <p class="empty-description">
                        Discover exciting deals, earn rewards, and enjoy exclusive offers. Start
                        shopping now and make the most of your experience!
                    </p>

                    <a href="{{ route('frontend.uae-services') }}" style="width:fit-content;" class="btn-primary-custom">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
