@extends('frontend.layouts.main')
@section('content')
    <section class="section-gap">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-lg-8">

                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-user'></i> Lead guest details
                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="custom-info-alert my-2">
                                        <div class="icon"><i class="bx bx-info-circle"></i></div>
                                        <div class="content">All names of those travelling must exactly match their
                                            passport as
                                            charges may apply to change a name. If you have autofill enabled on your
                                            browser or
                                            device, please check all names and details are correct.</div>
                                    </div>
                                    <p class="text-muted fw-bold pt-3 mb-1">The main contact for this booking</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">First Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Main Contact Email </label>
                                    <input type="text" class="custom-input" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Mobile No. </label>
                                    <input type="email" class="custom-input" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Country Of Residence</label>
                                    <select class="custom-select" name="country" id="country-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-user'></i> #1 Adult Details
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">First Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date Of Birth </label>
                                    <input type="date" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gender</label>
                                    <select required class='custom-select'>
                                        <option value="" selected disabled>Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Passport No.</label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nationality</label>
                                    <select required class='custom-select'>
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $nationality)
                                            <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Country Of Residence</label>
                                    <select class="custom-select" name="country" id="country-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-user'></i> #1 Child Details
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">First Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date Of Birth </label>
                                    <input type="date" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gender</label>
                                    <select required class='custom-select'>
                                        <option value="" selected disabled>Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Passport No.</label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nationality</label>
                                    <select required class='custom-select'>
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $nationality)
                                            <option value="{{ $nationality }}">{{ ucwords($nationality) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Country Of Residence</label>
                                    <select class="custom-select" name="country" id="country-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ ucwords($country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-user'></i> #1 Infant Details
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">First Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name </label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Date Of Birth </label>
                                    <input type="date" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Gender</label>
                                    <select required class='custom-select'>
                                        <option value="" selected disabled>Select</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Passport No.</label>
                                    <input type="text" class="custom-input" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nationality</label>
                                    <select required class='custom-select'>
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $nationality)
                                            <option value="{{ $nationality }}">{{ ucwords($nationality) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Country Of Residence</label>
                                    <select class="custom-select" name="country" id="country-select">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}">{{ ucwords($country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="sticky-sidebar">
                            <label class="plan-card-item plan-card-item--single">
                                <input type="radio" name="insurance_plan" class="plan-radio-input" checked="">
                                <div class="plan-card-inner">

                                    <div class="plan-info">
                                        <h6 class="plan-title">Travel Assurance - Gold Covid Plus Plan</h6>
                                        <a href="javascript:void(0)" data-popup-trigger
                                            data-popup-title="Travel Assurance- Platinum Covid Plus Plan"
                                            data-popup-id="popup-1" class="plan-link">More Benefits <i
                                                class="bx bx-chevron-right"></i></a>
                                        <div id="popup-1" class="d-none">Travel Assurance- Platinum Covid Plus Plan
                                        </div>
                                    </div>


                                    <div class="plan-cost">
                                        <div class="price-tag">119.35 <small>AED</small></div>
                                        <span class="tax-note">Including Tax</span>
                                    </div>
                                </div>
                            </label>

                            <button type="submit" class="btn-primary-custom mt-2">
                                <i class='bx bx-lock-alt'></i> Proceed to Payment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
