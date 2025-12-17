@extends('frontend.layouts.main')
@section('content')
    <div class="py-2">
        <div class="container">
            <nav class="breadcrumb-nav">
                <ul class="breadcrumb-list">

                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.index') }}" class="breadcrumb-link">Home</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>


                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.hotels.index') }}" class="breadcrumb-link">Hotels</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.hotels.details') }}" class="breadcrumb-link">Le Meridien Dubai Hotel &
                            Conference Centre</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>

                    <li class="breadcrumb-item active">
                        Guest info
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <section class="section-gap">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-lg-8">
                        <div id="extras" class="{{ $is_extras ? 'd-block' : 'd-none' }}">
                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bx-receipt'></i> Return Transfer | Deluxe Bungalow | Bed and Breakfast
                                </div>

                                <div class="transfers-list">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="transfers-item">
                                                <input class="transfers-item__radio" id="transfer-1" type="radio"
                                                    name="extras-item"
                                                    value="Return Speedboat Transfer (Shared, from Velana International Airport, MLE)"
                                                    data-price="472.56" data-option-id="94" data-extra-type-id="2"
                                                    data-extra-id="71" required data-required='true'>
                                                <label class="transfers-item__box" for="transfer-1">
                                                    <p
                                                        style="font-weight: 500;"class="content text-danger text-center mb-1">
                                                        Selection Required
                                                    </p>
                                                    <div class="transfer-header">
                                                        <i class='bx bxs-check-circle'></i>
                                                        <div class="title">Selected</div>
                                                    </div>
                                                    <div class="transfer-body">
                                                        <div class="content">Return Speedboat Transfer (Shared, from
                                                            Velana International Airport, MLE)</div>
                                                        <div class="bottom-price">
                                                            <div class="price-details">
                                                                <span>Per person return</span>
                                                                <div class="price"><span class="dirham">D</span> 472.56
                                                                </div>
                                                                <span>Total <span class="dirham">D</span> 472.56</span>
                                                            </div>
                                                            <div class="selected-btn" selected-text="Selected"
                                                                select-text="Select"></div>
                                                        </div>
                                                    </div>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="transfers-item">
                                                <input class="transfers-item__radio" id="transfer-2" type="radio"
                                                    name="extras-item"
                                                    value="Return Speedboat Transfer (Shared, from Velana International Airport, MLE)"
                                                    data-price="472.56" data-option-id="94" data-extra-type-id="2"
                                                    data-extra-id="71" required data-required='true'>
                                                <label class="transfers-item__box" for="transfer-2">
                                                    <p style="font-weight: 500;"
                                                        class="content text-danger text-center mb-1">Selection Required
                                                    </p>
                                                    <div class="transfer-header">
                                                        <i class='bx bxs-check-circle'></i>
                                                        <div class="title">Selected</div>
                                                    </div>
                                                    <div class="transfer-body">
                                                        <div class="content">Return Speedboat Transfer (Shared, from
                                                            Velana International Airport, MLE)</div>
                                                        <div class="bottom-price">
                                                            <div class="price-details">
                                                                <span>Per person return</span>
                                                                <div class="price"><span class="dirham">D</span> 472.56
                                                                </div>
                                                                <span>Total <span class="dirham">D</span> 472.56</span>
                                                            </div>
                                                            <div class="selected-btn" selected-text="Selected"
                                                                select-text="Select"></div>
                                                        </div>
                                                    </div>
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bxs-plane-alt'></i> Flight Details
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="custom-info-alert my-2">
                                            <div class="icon"><i class="bx bx-info-circle"></i></div>
                                            <div class="content">To proceed with your booking, we also need your flight
                                                details to arrange transfers for you.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-title mb-0">Outbound Flight</div>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label">Flight number *</label>
                                        <input type="text" class="custom-input" required>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-label">Arrival time *</label>
                                        <div class="flight-fields">
                                            <select class="custom-select" id="flight_outbound_hr"
                                                name="out_flight_arrival_time_h">
                                                <option value="">hh</option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-label">&nbsp;</label>
                                        <select class="custom-select" id="flight_outbound_min"
                                            name="out_flight_arrival_time_m">
                                            <option value="">mm</option>
                                            <option value="00">00</option>
                                            <option value="05">05</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                            <option value="35">35</option>
                                            <option value="40">40</option>
                                            <option value="45">45</option>
                                            <option value="50">50</option>
                                            <option value="55">55</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-title mb-0">Inbound Flight</div>
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label">Flight number *</label>
                                        <input type="text" class="custom-input" required>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-label">Departure time *</label>
                                        <div class="flight-fields">
                                            <select class="custom-select" id="flight_outbound_hr"
                                                name="in_flight_arrival_time_h">
                                                <option value="">hh</option>
                                                <option value="00">00</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label class="form-label">&nbsp;</label>
                                        <select class="custom-select" id="flight_outbound_min"
                                            name="in_flight_arrival_time_m">
                                            <option value="">mm</option>
                                            <option value="00">00</option>
                                            <option value="05">05</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="25">25</option>
                                            <option value="30">30</option>
                                            <option value="35">35</option>
                                            <option value="40">40</option>
                                            <option value="45">45</option>
                                            <option value="50">50</option>
                                            <option value="55">55</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="guest-info" class="{{ $is_extras ? 'd-none' : 'd-block' }}">
                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bx-user'></i> Guest information
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
                                    </div>
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
                                        <label class="form-label">Address *</label>
                                        <input type="text" class="custom-input">
                                    </div>
                                </div>
                            </div>

                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bx-user'></i> #1 Guest Details
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
                                        <label class="form-label">Age *</label>
                                        <input type="number" class="custom-input" required>
                                    </div>
                                </div>
                            </div>

                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bx-info-circle'></i> Important information
                                </div>

                                <p class="text-muted fw-bold pt-3 mb-1">Hotel Information</p>
                                <p>For health and safety reasons, children under 8 years are not allowed in any over water
                                    or
                                    over ocean categories.WOW INCLUSIVE- YOUR 24-HOUR PREMIUM ALL INCLUSIVE BENEFITS -
                                    Breakfast
                                </p>
                                <a data-info-popup-open="Privacy Policy" href="javascript:void(0)"
                                    class="custom-link">Show
                                    more</a>
                            </div>

                            <div class="modern-card">
                                <button type="submit" class="btn-primary-custom mt-2">
                                    Pay Now <i class='bx bx-lock-alt'></i>
                                </button>

                                <div class="text-center mt-3">
                                    <small
                                        class="text-muted secure-checkout d-flex align-items-center gap-1 justify-content-center"><i
                                            class='bx bx-check-shield'></i>Secure
                                        Checkout</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="event-card event-card--details">
                            <div class="event-card__img">
                                <img data-src="https://images.dnatatravel.com/ei/1/1/1/7/6/0/0.jpg"
                                    class="imgFluid lazyload" alt="Image">
                            </div>
                            <div class="event-card__content">
                                <div class="title title--sm">Le Meridien Dubai Hotel &amp; Conference Centre </div>
                                <div class="rating pb-1">
                                    <div class="stars">
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                    </div>
                                    <div class="rating-average">
                                        <div class="rating-average-blob">5.0</div>
                                        <div class="info">Spectacular</div>
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="icon"><i class="bx bxs-calendar-alt"></i></div>
                                    <div class="content">12 Jan 2026 - 1 nights at hotel</div>
                                </div>
                                <div class="details">
                                    <div class="icon"><i class="bx bx-map"></i></div>
                                    <div class="content">Airport Road, P.O. Box 10001, Dubai, United Arab Emirates
                                    </div>
                                </div>
                                <div class="details">
                                    <div class="icon"><i class="bx bxs-group"></i></div>
                                    <div class="content">1 Adults, 0 Child, 1 Rooms </div>
                                </div>
                                <div class="details">
                                    <div class="icon"><i class="bx bxs-bed"></i></div>
                                    <div class="content showroomtype">Deluxe Room</div>
                                </div>
                                <div class="details details--border">
                                    <div class="content">Rooms total</div>
                                    <div class="content roomstotal"><span class="dirham">D</span>1068.18</div>
                                </div>
                            </div>
                        </div>

                        <div class="modern-card">
                            <div class="card-title">Transfers / Extras
                            </div>

                            <div class="order-item-mini" id="extras-summary-item" style="display: none;">
                                <div>
                                    <h6>
                                        <span id="extras-pkg-title">pkg title here</span>
                                        <i class='bx bx-x'></i> AED
                                        <span id="extras-pkg-amount">amount here</span>
                                    </h6>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <span style="color: var(--color-primary)"><span class="dirham">D</span>
                                        <span id="extras-total-amount">0.00</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="modern-card">

                            <div class="order-item-mini">
                                <div>
                                    <h6>Rooms Total</h6>
                                </div>
                                <span class="fw-bold"><span class="dirham">D</span> 1068.18</span>
                            </div>

                            <div class="mt-3">
                                <div class="summary-row">
                                    <span>Extras total</span>
                                    <span><span class="dirham">D</span> <span id="summary-extras-total">0.00</span></span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total Price</span>
                                    <span style="color: var(--color-primary)"><span class="dirham">D</span>
                                        <span id="summary-net-total">1068.18</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @if ($is_extras)
        <div class="continue-bar">
            <div class="container">
                <div class="continue-bar-padding">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-12 col-md-6">
                            <div class="details-wrapper">
                                <div class="details">
                                    <div class="total">Total</div>
                                    <div><span class="dirham">D</span><span class="total-price"
                                            id="total-price">1068.18</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="details-btn-wrapper">
                                <button type="button" id="continue-btn" class="btn-primary-custom">
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="custom-popup-wrapper" data-info-popup-wrapper="Privacy Policy">
        <div class="custom-popup" data-info-popup>
            <div class="custom-popup__header">
                <div class="title"> Privacy Policy</div>
                <div data-info-popup-close class="close-icon"><i class='bx bx-x'></i></div>
            </div>
            <div class="custom-popup__content custom-popup__content--full">
                <h6>Information collection and use</h6>
                <p>andaleeb World Travel and its subsidiaries and associated companies (in this policy, together “andaleeb”,
                    or “we”) are responsible for the processing of any personal information you provide to this Web Site.
                </p>
                <p>We take our responsibilities regarding the protection of personal information very seriously. This policy
                    explains how we use personal information that we may obtain about you.</p>
                <h6>Why do we need your personal information?</h6>
                <p>When you use services provided on this web site you will be asked to provide certain information such as
                    your name, contact details, and/or debit/credit card details. We will store this information and hold it
                    on computers or otherwise. We will use this information in the following ways:</p>
                <ul>
                    <li>To fulfil our agreement with you, including processing your booking, sending you your itinerary, or
                        contacting you if we become aware that there is a problem with any part of your trip;</li>
                    <li>To administer any contest or other promotional offer you may enter and notify winners;</li>
                    <li>To answer any queries which you may send to us by email;</li>
                    <li>In order to conduct customer satisfaction surveys;</li>
                    <li>To meet our legal compliance obligations;</li>
                    <li>For crime prevention and detection;</li>
                    <li>For direct marketing purposes, as set out in detail below.</li>
                </ul>
                <p>Where you are booking a flight, and in certain other circumstances we need to know the names of all
                    passengers travelling. If you are booking a flight or other service on behalf of someone else, you must
                    obtain their consent to use their personal information. We proceed on the basis that you have obtained
                    this consent.</p>
                <h6>How do we use your personal information?</h6>
                <p>Information you provide or that is obtained by us will be used by us to enable us to review, develop and
                    improve the services which we offer and provide you and other customers (via mail, email telephone or
                    otherwise) with information about new products and services and special offers we think you will find
                    valuable. We may also inform you about new products and services and special offers of selected third
                    parties.</p>
                <h6>To whom do we disclose your personal information?</h6>
                <p>andaleeb does not sell, or trade your personal information to third parties.</p>
                <p>We may give information about you as follows:</p>
                <ul>
                    <li>andaleeb will pass your personal information, and the personal information you supply relating to
                        any other travellers, to third parties whose services you are purchasing, such as airlines, hotels,
                        and car hire companies. We will transfer such information only when required for operational
                        purposes and not for marketing purposes. We are not responsible for the use such companies may make
                        of your personal information</li>
                    <li>andaleeb may provide its third party service providers and processors with access to your personal
                        information. These services providers may include: credit card verification providers, our data
                        warehouse and customer relationship management centre, marketing organizations, who may provide
                        support marketing and promotional communications; internet service providers who administer our web
                        page and provide internet services and host our facilities; and consumer research companies that
                        assist andaleeb with understanding consumer interests by conducting surveys. andaleeb only shares
                        your personal information to the extent required for the performance of such services. andaleeb has
                        implemented safeguards to ensure that our service providers treat personal information in a way that
                        is consistent with the terms of this Privacy Statement and that it is never used except to fulfill
                        services to andaleeb</li>
                    <li>andaleeb may also disclose your personal information as permitted or required by law. For example,
                        andaleeb will disclose personal information to those governmental bodies who have authority to
                        obtain it, in order to comply with a warrant or subpoena issued by a court of competent
                        jurisdiction, and to comply with record production requirements</li>
                    <li>In the event of a sale of all or substantially all of the assets of andaleeb, andaleeb may transfer
                        personal information in its control to a third party purchaser that agrees to use personal
                        information for the same reasons identified in this Privacy Statement</li>
                    <li>if we have a duty to do so or if the law allows us to do so;</li>
                    <li>to our employees and agents to do any of the above on our behalf, now or in the future.</li>
                </ul>
                <p>If you choose not to provide certain personal information we request, you will still be able to visit our
                    web site but you may be unable to access certain options or services.</p>
                <h6>Consent</h6>
                <p>By choosing to provide andaleeb with your personal information you are consenting to its use in
                    accordance with the principles outlined in this Privacy Statement and as outlined at the time you are
                    asked to provide any personal information. andaleeb may contact you by phone or email in order to
                    provide you with updates pertaining to its services as well as information about additional offers,
                    products or events that andaleeb believes may be of interest to you. You can choose to unsubscribe to
                    these updates or from having your personal information used for market research purposes.</p>
                <h6>Withdrawing your consent</h6>
                <p>All marketing communications andaleeb sends to you will provide you with a way to withdraw your consent.
                    If you no longer wish to receive promotional materials you may opt-out of receiving these communications
                    by clicking here, this will remove you from andaleeb mail lists.</p>
                <h6>Security</h6>
                <p>We will take appropriate steps to protect the personal information you share with us. We have implemented
                    technology and security features to safeguard the privacy of your personal information.</p>
                <h6>Aggregate data</h6>
                <p>We may aggregate personal information and remove any identifying elements in order to analyze patterns
                    and improve our marketing and promotional efforts, to analyze website use, to improve our content and
                    product offerings, and to customize our site’s content, layout and services.</p>
                <p>We gather certain usage information like the number and frequency of visitors to this site. This
                    information may include which URL you just came from, which URL you next go to, what browser you are
                    using, and your IP address. We only use such data in the aggregate. This collective data helps us to
                    determine how much our customers use parts of the site, and do internal research on our users’
                    demographics, interests, and behaviour to better understand and serve you.</p>
                <h6>Cookies</h6>
                <p>A “cookie” is a small bit of text used by a browser to store information. When you visit a site that uses
                    cookies, the Web server will request permission to pass a cookie to your browser. If accepted, it will
                    occupy only a few bytes on your hard drive and can improve your Web surfing experience. andaleeb uses
                    cookies to track customer visits through our site. This information enables us to save you time when
                    returning to the site by saving your password so you do not have to re-enter it each time you visit.
                    Cookies cannot profile your system or collect information from your hard drive. And although you may
                    receive cookies from many different sites, each cookie can only be read by the Web server that
                    originally issued it. Most browsers are initially set up to accept cookies, but you can set your
                    browsers to refuse cookies</p>
                <h6>Links</h6>
                <p>Our web site may contain links to other web sites. Please be aware that we are not responsible for the
                    privacy practices of web sites not operated by us. We encourage you to read the privacy statements of
                    each and every web site that collects personally identifiable information. This privacy statement
                    applies solely to information collected by our web site.</p>
                <h6>Correction / updating of personal information</h6>
                <p>If your personally identifiable information changes, or if you no longer desire our service, we will
                    provide a way to correct, update or remove your personal information provided to us.</p>
                <h6>Access to your personal information</h6>
                <p>You have the right to see personal information we keep about you. We will endeavour to provide the
                    information you require within a reasonable time. There may be a small monetary charge for some
                    requests, depending on the information requested. If you are concerned that any of the information we
                    hold on you is incorrect please contact us.</p>
                <h6>Transfer of your personal information</h6>
                <p>Some parties that process or store personal information may be located in jurisdictions outside your
                    country of residence. Therefore, your information may be processed and stored in these jurisdictions
                    and, as a result, foreign governments, courts, or law enforcement or regulatory agencies may be able to
                    obtain disclosure of your information through the laws in these countries.</p>
                <h6>Notification of changes</h6>
                <p>If we decide to change our Privacy Statement, we will post those changes on our web site so you are
                    always aware of what information we collect, how we use it, and under circumstances, if any, we disclose
                    it. If at any point we decide to use personally identifiable information in a manner different from that
                    stated at the time it was collected, we will notify you by way of an email. You will have a choice as to
                    whether or not we use your information in this different manner. We will use information in accordance
                    with the Privacy Statement under which the information was collected.</p>
                <h6>Online bookings</h6>
                <p>If you have a query regarding your online booking or encountered any problems whilst making your booking,
                    please email <a href="mailto:info@andaleebtours.com">info@andaleebtours.com</a></p>
                <p>Non-booking related queries</p>
                <p>If you experience any technical problems during your interaction with this website, please contact us on
                    <a href="tel:+971 52 574 8986">+971 52 574 8986</a> or email us on <a
                        href="mailto:info@andaleebtours.com">info@andaleebtours.com</a>.
                </p>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const popupWrapper = document.querySelector("[data-info-popup-wrapper]");
            const popup = document.querySelector("[data-info-popup]");
            if (!popupWrapper) return;

            document.querySelectorAll("[data-info-popup-open]").forEach((button) => {
                button.addEventListener("click", () => popupWrapper.classList.add("open"));
            });

            document
                .querySelector("[data-info-popup-close]")
                ?.addEventListener("click", () => {
                    popupWrapper.classList.remove("open");
                });

            document.addEventListener("click", (event) => {
                if (
                    popupWrapper.classList.contains("open") &&
                    !popup.contains(event.target) &&
                    !event.target.closest("[data-info-popup-open]")
                ) {
                    popupWrapper.classList.remove("open");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const roomsTotal = 1068.18;
            const transferRadios = document.querySelectorAll('.transfers-item__radio');

            transferRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const packageTitle = this.value;
                        const packagePrice = parseFloat(this.getAttribute('data-price'));

                        const extrasSummaryItem = document.getElementById('extras-summary-item');
                        const extrasPkgTitle = document.getElementById('extras-pkg-title');
                        const extrasPkgAmount = document.getElementById('extras-pkg-amount');
                        const extrasTotalAmount = document.getElementById('extras-total-amount');
                        const summaryExtrasTotal = document.getElementById('summary-extras-total');
                        const summaryNetTotal = document.getElementById('summary-net-total');
                        const continueBarTotal = document.getElementById('total-price');

                        extrasPkgTitle.textContent = packageTitle;
                        extrasPkgAmount.textContent = packagePrice.toFixed(2);
                        extrasTotalAmount.textContent = packagePrice.toFixed(2);
                        extrasSummaryItem.style.display = 'block';

                        summaryExtrasTotal.textContent = packagePrice.toFixed(2);

                        const netTotal = roomsTotal + packagePrice;
                        summaryNetTotal.textContent = netTotal.toFixed(2);
                        continueBarTotal.textContent = netTotal.toFixed(2);
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const continueBtn = document.getElementById('continue-btn');
            const extrasSection = document.getElementById('extras');
            const guestInfoSection = document.getElementById('guest-info');
            const continueBar = document.querySelector('.continue-bar');

            if (continueBtn && extrasSection) {
                continueBtn.addEventListener('click', function() {
                    if (extrasSection.classList.contains('d-block')) {
                        let isValid = true;

                        const transferRadio = document.querySelector('input[name="extras-item"]:checked');
                        if (!transferRadio) {
                            isValid = false;
                            showMessage("Please select a transfer package before continuing.", "error");
                            return;
                        }

                        const requiredFields = extrasSection.querySelectorAll('[required]');
                        requiredFields.forEach(field => {
                            if (field.type === 'radio') {
                                const radioGroup = extrasSection.querySelectorAll(
                                    `input[name="${field.name}"]`);
                                const isChecked = Array.from(radioGroup).some(radio => radio
                                    .checked);
                                if (!isChecked) {
                                    isValid = false;
                                }
                            } else if (!field.value.trim()) {
                                isValid = false;
                            }
                        });

                        if (!isValid) {
                            showMessage("Please fill all required fields before continuing.", "error");
                            return;
                        }

                        extrasSection.classList.remove('d-block');
                        extrasSection.classList.add('d-none');
                        guestInfoSection.classList.remove('d-none');
                        guestInfoSection.classList.add('d-block');
                        continueBar.style.display = 'none';

                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            }
        });
    </script>
@endpush
