@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.orders.pay-again', $order) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">Pay for Order: {{ $order->order_number ?? '' }}</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('user.orders.pay-again.proceed', $order->id) }}" method="POST" enctype="multipart/form-data"
                id="validation-form">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wrapper">
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Select Payment Method</div>
                                </div>
                                <div class="form-box__body">

                                    <!-- Option 1: Card -->
                                    <label class="payment-option">
                                        <div class="payment-header">
                                            <input type="radio" name="payment_method" class="payment-radio" value="payby"
                                                checked required>
                                            <span class="payment-label">Credit / Debit Card</span>
                                        </div>
                                        <div class="payment-desc">
                                            Note: You will be redirected to the secure payment gateway to complete your
                                            purchase.
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

                                    <button class="themeBtn ms-auto mt-4">Proceed to Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
