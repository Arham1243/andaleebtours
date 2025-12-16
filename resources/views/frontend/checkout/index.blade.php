@extends('frontend.layouts.main')
@section('content')
    @php
        $countries = config('countries');
    @endphp
    <section class="section-gap">
        <div class="container">
            <h1 class="page-title">Checkout</h1>

            <form action="#">
                <div class="row">
                    <!-- Left Column: Forms -->
                    <div class="col-lg-8">

                        <!-- Passenger Details -->
                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-user'></i> Lead Passenger Details
                            </div>

                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Title</label>
                                    <select class="custom-select">
                                        <option>Mr.</option>
                                        <option>Mrs.</option>
                                        <option>Ms.</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="custom-input" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="custom-input" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="custom-input"required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Country</label>
                                    <select class="custom-select" name="country" id="country-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ ucwords($country) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address *</label>
                                    <input type="text" class="custom-input">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Special Request</label>
                                    <textarea class="custom-textarea" placeholder="Any specific requirements?"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-credit-card'></i> Choose Payment Method
                            </div>

                            <!-- Option 1: Card -->
                            <label class="payment-option">
                                <div class="payment-header">
                                    <input type="radio" name="payment_method" class="payment-radio" checked>
                                    <span class="payment-label">Credit / Debit Card</span>
                                </div>
                                <div class="payment-desc">
                                    Note: You will be redirected to the secure payment gateway to complete your purchase.
                                </div>
                            </label>

                            <!-- Option 2: Tabby -->
                            <label class="payment-option">
                                <div class="payment-header">
                                    <input type="radio" name="payment_method" class="payment-radio">
                                    <span class="payment-label">Tabby - Buy Now Pay Later</span>
                                </div>
                                <div class="payment-desc">
                                    Pay in 4 interest-free installments. No fees, no hidden costs.
                                </div>
                            </label>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="sticky-sidebar">
                            <div class="dsc-card p-3">
                                <div class="d-flex align-items-center">

                                    <a href="#" class="dsc-img-container">
                                        <img src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20437/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Dubai-Desert-Safari-with-Dune-Bashing-5962/1737620054021_S.jpg?_a=BAVAZGE70"
                                            alt="Desert Safari" class="dsc-thumb">
                                    </a>

                                    <div class="flex-grow-1 ms-3">
                                        <a href="" class="dsc-title">Desert Safari</a>

                                        <div class="dsc-meta-text">
                                            <i class='bx bx-calendar dsc-icon'></i>
                                            <span>16 Dec 2025</span>
                                        </div>

                                        <div class="dsc-meta-text mt-1">
                                            <i class='bx bx-map dsc-icon'></i>
                                            <span class="dsc-location-link">
                                                United Arab Emirates
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="dsc-divider"></div>

                                <div class="dsc-details">
                                    <div class="dsc-meta-text mb-2">
                                        <i class='bx bx-time-five dsc-icon'></i>
                                        <span>08:00 : 21:00</span>
                                    </div>
                                    <div class="dsc-meta-text">
                                        <i class='bx bx-group dsc-icon'></i>
                                        <span>2 Adults 1 Child 1 Infant</span>
                                    </div>
                                </div>

                                <div class="dsc-price">
                                    <span class="dirham">D</span> 645
                                </div>

                            </div>

                            <div class="modern-card">
                                <div class="card-title">Payment Details
                                </div>

                                <div class="order-item-mini">
                                    <div>
                                        <h6>Activities <i class='bx bx-x'></i> 1</h6>
                                    </div>
                                    <span class='fw-bold'><span class="dirham">D</span> 168.00</span>
                                </div>

                                <div class="mt-3">
                                    <div class="summary-row">
                                        <span>All Taxes</span>
                                        <span><span class="dirham">D</span> 0.00</span>
                                    </div>
                                    <div class="summary-row total">
                                        <span>Total Payable</span>
                                        <span style="color: var(--color-primary)"><span class="dirham">D</span> 468.00</span>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <span class="text-muted small">
                                        Your card will be charged in AED
                                    </span>

                                    <button type="submit" class="btn-primary-custom mt-2">
                                        Pay Now <i class='bx bx-lock-alt'></i>
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <small
                                        class="text-muted secure-checkout d-flex align-items-center gap-1 justify-content-center"><i
                                            class='bx bx-check-shield'></i>Secure
                                        Checkout</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
