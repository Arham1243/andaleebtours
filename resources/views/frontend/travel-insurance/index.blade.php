@extends('frontend.layouts.main')
@section('content')
    <section class="section-plans mar-y">
        <div class="container">
            <h4 class="fw-bold mb-3">Select Passenger</h4>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="main-page-search">
                        @include('frontend.vue.main', [
                            'appId' => 'insurance-search',
                            'appComponent' => 'insurance-search',
                            'appJs' => 'insurance-search',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-plans mar-y">
        <div class="container">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="text-center">
                        <h4 class="fw-bold mb-1">Select Insurance Plan</h4>
                        <p class="text-muted small">Choose the coverage that suits you best.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="plans-list-wrapper">

                        <label class="plan-card-item">
                            <input type="radio" name="insurance_plan" class="plan-radio-input">
                            <div class="plan-card-inner">

                                <div class="plan-info">
                                    <h6 class="plan-title">Travel Assurance - Silver Plan</h6>
                                    <a href="javascript:void(0)" data-popup-trigger
                                        data-popup-title="Travel Assurance - Silver Plan" data-popup-id="popup-1"
                                        class="plan-link">More Benefits <i class="bx bx-chevron-right"></i></a>
                                    <div id="popup-1" class="d-none">Travel Assurance - Silver Plan
                                    </div>
                                </div>


                                <div class="plan-cost">
                                    <div class="price-tag">85.00 <small>AED</small></div>
                                    <span class="tax-note">Including Tax</span>
                                </div>


                                <div class="plan-check-icon">
                                    <i class='bx bx-check'></i>
                                </div>
                            </div>
                        </label>


                        <label class="plan-card-item">
                            <input type="radio" name="insurance_plan" class="plan-radio-input" checked>
                            <div class="plan-card-inner">

                                <div class="plan-info">
                                    <h6 class="plan-title">Travel Assurance - Gold Covid Plus Plan</h6>
                                    <a href="javascript:void(0)" data-popup-trigger
                                        data-popup-title="Travel Assurance - Gold Covid Plus Plan" data-popup-id="popup-2"
                                        class="plan-link">More Benefits <i class="bx bx-chevron-right"></i></a>
                                    <div id="popup-2" class="d-none">Travel Assurance - Gold Covid Plus Plan
                                    </div>
                                </div>


                                <div class="plan-cost">
                                    <div class="price-tag">119.35 <small>AED</small></div>
                                    <span class="tax-note">Including Tax</span>
                                </div>


                                <div class="plan-check-icon">
                                    <i class='bx bx-check'></i>
                                </div>
                            </div>
                        </label>


                        <label class="plan-card-item">
                            <input type="radio" name="insurance_plan" class="plan-radio-input">
                            <div class="plan-card-inner">

                                <div class="plan-info">
                                    <h6 class="plan-title">Travel Assurance - Platinum Shield</h6>
                                    <a href="javascript:void(0)" data-popup-trigger
                                        data-popup-title="Travel Assurance - Platinum Shield" data-popup-id="popup-3"
                                        class="plan-link">More Benefits <i class="bx bx-chevron-right"></i></a>
                                    <div id="popup-3" class="d-none">Travel Assurance - Platinum Shield
                                    </div>
                                </div>


                                <div class="plan-cost">
                                    <div class="price-tag">155.00 <small>AED</small></div>
                                    <span class="tax-note">Including Tax</span>
                                </div>

                                <div class="plan-check-icon">
                                    <i class='bx bx-check'></i>
                                </div>
                            </div>
                        </label>
                    </div>
                    <a href="{{ route('frontend.travel-insurance.details') }}" class="btn-primary-custom"> Continue <i
                            class='bx bx-right-arrow-alt'></i></a>
                </div>
            </div>
        </div>
    </section>


    <div class="custom-popup-wrapper" data-popup-wrapper="">
        <div class="custom-popup">
            <div class="custom-popup__header">
                <div class="title" data-popup-title="">
                </div>
                <div class="close-icon" data-popup-close="">
                    <i class="bx bx-x"></i>
                </div>
            </div>
            <div class="custom-popup__content">
                <div data-popup-text=""> </div>
            </div>
        </div>
    </div>
@endsection
