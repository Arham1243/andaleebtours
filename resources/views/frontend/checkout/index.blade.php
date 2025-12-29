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
                                    <select class="custom-select" name="passenger[title]" required>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="custom-input" name="passenger[first_name]" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="custom-input" name="passenger[last_name]" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="custom-input" name="passenger[email]" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="custom-input" name="passenger[phone]" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Country</label>
                                    <select class="custom-select" name="passenger[country]" id="country-select" required>
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ ucwords($country) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address *</label>
                                    <input type="text" class="custom-input" name="passenger[address]" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Special Request</label>
                                    <textarea class="custom-textarea" name="passenger[special_request]" placeholder="Any specific requirements?"></textarea>
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
                                    <input type="radio" name="payment_method" class="payment-radio" value="card" checked
                                        required>
                                    <span class="payment-label">Credit / Debit Card</span>
                                </div>
                                <div class="payment-desc">
                                    Note: You will be redirected to the secure payment gateway to complete your purchase.
                                </div>
                            </label>

                            <!-- Option 2: Tabby -->
                            <label class="payment-option">
                                <div class="payment-header">
                                    <input type="radio" name="payment_method" class="payment-radio" value="tabby"
                                        required>
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
                            @foreach ($tours as $tour)
                                @php
                                    $item = $cartData['tours'][$tour->id];
                                @endphp
                                <div class="dsc-card p-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('frontend.tour.details', $tour->slug) }}"
                                            class="dsc-img-container">
                                            <img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="dsc-thumb">
                                        </a>

                                        <div class="flex-grow-1 ms-3">
                                            <a href="{{ route('frontend.tour.details', $tour->slug) }}"
                                                class="dsc-title">{{ $tour->name }}</a>

                                            <div class="dsc-meta-text">
                                                <i class='bx bx-calendar dsc-icon'></i>
                                                <span>{{ formatDate($item['date']) }}</span>
                                            </div>

                                            <div class="dsc-meta-text mt-1">
                                                <i class='bx bx-map dsc-icon'></i>
                                                <span class="dsc-location-link">
                                                    {{ $tour->location ?? 'United Arab Emirates' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dsc-divider"></div>

                                    <div class="dsc-details">
                                        <div class="dsc-meta-text mb-2">
                                            <i class='bx bx-time-five dsc-icon'></i>
                                            <span>{{ $item['time_slot'] }}</span>
                                        </div>
                                        <div class="dsc-meta-text">
                                            <i class='bx bx-group dsc-icon'></i>
                                            <span>
                                                @foreach ($item['pax'] as $paxType => $pax)
                                                    {{ $pax['qty'] }} {{ Str::plural($pax['label'], $pax['qty']) }}
                                                    @if (!$loop->last)
                                                        &bull;
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>

                                    <div class="dsc-price">
                                        {{ formatPrice($item['total_price']) }}
                                    </div>
                                </div>
                            @endforeach

                            <div class="modern-card">
                                <div class="card-title">Payment Details
                                </div>

                                <div class="order-item-mini">
                                    <div>
                                        <h6>Activities <i class='bx bx-x'></i> {{ count($cartData['tours']) }}</h6>
                                    </div>
                                    <span class='fw-bold'>{{ formatPrice($cartData['total']['subtotal']) }}</span>
                                </div>

                                @if (!empty($cartData['applied_coupons']))
                                    <div class="mt-3">
                                        @foreach ($cartData['applied_coupons'] as $coupon)
                                            <div class="summary-row">
                                                <span>Coupon: {{ $coupon['code'] }}
                                                    ({{ $coupon['type'] === 'percentage' ? $coupon['rate'] . '%' : formatPrice($coupon['rate']) }})
                                                </span>
                                                <span style="color: red;">-{{ formatPrice($coupon['discount']) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-3">

                                    <div class="summary-row">
                                        <span>Tax ({{ $config['VAT_PERCENTAGE'] ?? 0 }}%)</span>
                                        <span>{{ formatPrice($cartData['total']['vat']) }}</span>
                                    </div>

                                    <div class="summary-row">
                                        <span>Service Tax ({{ $config['SERVICE_TAX_PERCENTAGE'] ?? 0 }}%)</span>
                                        <span>{{ formatPrice($cartData['total']['service_tax']) }}</span>
                                    </div>

                                    <div class="summary-row total">
                                        <span>Total Payable</span>
                                        <span
                                            style="color: var(--color-primary)">{{ formatPrice($cartData['total']['grand_total']) }}</span>
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
