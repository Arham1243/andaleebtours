@extends('frontend.layouts.main')
@section('content')
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

                        <!-- Cart Item Loop -->
                        <div class="cart-item">
                            <a href="#" class="cart-thumb">
                                <img src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                    alt="Activity Image" class="imgFluid">
                            </a>

                            <div class="cart-details">
                                <h5 class="cart-title">Dubai Butterfly Garden - General Admission</h5>
                                <div class="cart-meta">
                                    <i class='bx bx-calendar'></i> Date: 12 Dec 2025
                                </div>
                                <div class="cart-meta">
                                    <i class='bx bx-group'></i> Guests: 3 Adults
                                </div>
                            </div>

                            <div class="qty-control">
                                <button class="qty-btn" type="button"><i class='bx bx-minus'></i></button>
                                <input type="text" class="qty-input" value="3" readonly>
                                <button class="qty-btn" type="button"><i class='bx bx-plus'></i></button>
                            </div>

                            <div class="cart-price-area">
                                <span class="item-calculation">3 x AED 56.00</span>
                                <span class="item-total">AED 168.00</span>
                            </div>

                            <button class="btn-remove" title="Remove Item">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                        <!-- End Cart Item -->

                        <!-- Example of another item -->
                        <div class="cart-item">
                            <a href="#" class="cart-thumb">
                                <img src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                    alt="Activity Image" class="imgFluid">
                            </a>

                            <div class="cart-details">
                                <h5 class="cart-title">Burj Khalifa At The Top</h5>
                                <div class="cart-meta">
                                    <i class='bx bx-calendar'></i> Date: 14 Dec 2025
                                </div>
                                <div class="cart-meta">
                                    <i class='bx bx-group'></i> Guests: 2 Adults
                                </div>
                            </div>

                            <div class="qty-control">
                                <button class="qty-btn" type="button"><i class='bx bx-minus'></i></button>
                                <input type="text" class="qty-input" value="3" readonly>
                                <button class="qty-btn" type="button"><i class='bx bx-plus'></i></button>
                            </div>
                            <div class="cart-price-area">
                                <span class="item-calculation">2 x AED 150.00</span>
                                <span class="item-total">AED 300.00</span>
                            </div>

                            <button class="btn-remove" title="Remove Item">
                                <i class='bx bx-trash'></i>
                            </button>
                            </a>

                        </div>

                        <a href="#" class="btn-outline">
                            <i class='bx bx-left-arrow-alt'></i> Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Right Side: Order Summary -->
                <div class="col-lg-4">
                    <div class="modern-card">
                        <div class="card-title">
                            <i class='bx bx-receipt'></i> Order Summary
                        </div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>AED 468.00</span>
                        </div>

                        <!-- Coupon Code -->
                        <div class="coupon-wrapper">
                            <input type="text" class="coupon-input" placeholder="Enter discount code">
                            <button class="btn-apply-overlay">Apply</button>
                        </div>

                        <div class="summary-row">
                            <span>Tax (0%)</span>
                            <span>AED 0.00</span>
                        </div>

                        <div class="summary-row total">
                            <span>Total Payable</span>
                            <span style="color: var(--color-primary)">AED 468.00</span>
                        </div>

                        <a href="{{ route('frontend.checkout.index') }}" class="btn-primary-custom mt-3">Proceed to
                            Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-gap pt-0">
        <div class="container">
            <div class="empty-cart-state text-center">
                <div class="empty-cart-img">
                    <img src="{{ asset('frontend/assets/images/empty-cart.webp') }}" alt="Empty Cart" class="img-fluid">
                </div>

                <h2 class="empty-title">Your cart is empty</h2>
                <h4 class="empty-subtitle">You don't have any booking</h4>

                <p class="empty-description">
                    Discover exciting deals, earn rewards, and enjoy exclusive offers. Start
                    shopping now and make the most of your experience!
                </p>

                <a href="{{ url('/') }}" style="width:fit-content;" class="btn-primary-custom">
                    Continue Shopping
                </a>
            </div>
        </div>
    </section>
@endsection
