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

                    <!-- Right Column: Summary (Sticky) -->
                    <div class="col-lg-4">
                        <div class="modern-card sticky-sidebar">
                            <div class="card-title">
                                <i class='bx bx-cart'></i> Your Order
                            </div>

                            <!-- Mini Items List -->
                            <div class="order-item-mini">
                                <div>
                                    <h6>Dubai Butterfly Garden</h6>
                                    <span class="text-muted small">12 Dec 2025 | 3 Pax</span>
                                </div>
                                <span class='fw-bold'>AED 168.00</span>
                            </div>
                            <div class="order-item-mini">
                                <div>
                                    <h6>Burj Khalifa Top</h6>
                                    <span class="text-muted small">14 Dec 2025 | 2 Pax</span>
                                </div>
                                <span class='fw-bold'>AED 300.00</span>
                            </div>

                            <!-- Totals -->
                            <div class="mt-3">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>AED 468.00</span>
                                </div>
                                <div class="summary-row">
                                    <span>Taxes</span>
                                    <span>AED 0.00</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total Amount</span>
                                    <span style="color: var(--color-primary)">AED 468.00</span>
                                </div>
                            </div>

                            <button type="submit" class="btn-primary-custom mt-4">
                                 Pay Now  <i class='bx bx-lock-alt'></i>
                            </button>

                            <div class="text-center mt-3">
                                <small class="text-muted secure-checkout"><i class='bx bx-check-shield' ></i>Secure
                                    Checkout</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection