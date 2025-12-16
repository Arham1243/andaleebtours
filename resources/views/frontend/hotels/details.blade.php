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
                        <a href="{{ route('frontend.hotels.search') }}" class="breadcrumb-link">Listing</a>
                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                    </li>

                    <li class="breadcrumb-item active">
                        Le Meridien Dubai Hotel & Conference Centre
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <div class="container">
        <div class="hotel-detail">
            <div class="hotel-info">
                <div class="row">
                    <div class="col-md-8">
                        <div class="hotels-lg-img-wrapper">
                            <div class="hotels-lg-img-list">
                                <div class="hotels-lg-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/0.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                                <div class="hotels-lg-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/1.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                                <div class="hotels-lg-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/2.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                                <div class="hotels-lg-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/3.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                                <div class="hotels-lg-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/4.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                                <div class="hotels-lg-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/5.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                            </div>
                            <div class="action-btns">
                                <div class="event-slider-actions">
                                    <button type="button" class="event-slider-actions__arrow event-slider-prev">
                                        <i class="bx bx-chevron-left"></i>
                                    </button>
                                    <div class="event-slider-actions__progress"></div>
                                    <button type="button" class="event-slider-actions__arrow event-slider-next">
                                        <i class="bx bx-chevron-right"></i>
                                    </button>
                                </div>
                                <button class="full-screen"><i class='bx bx-fullscreen'></i>Full screen</button>
                            </div>
                        </div>
                        <div class="hotels-sm-img-list hotels-sm-img-list-slider">
                            <div class="hotels-sm-img-item">
                                <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/0.jpg"
                                    class="imgFluid lazyload" alt="Image" />
                            </div>
                            <div class="hotels-sm-img-item">
                                <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/1.jpg"
                                    class="imgFluid lazyload" alt="Image" />
                            </div>
                            <div class="hotels-sm-img-item">
                                <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/2.jpg"
                                    class="imgFluid lazyload" alt="Image" />
                            </div>
                            <div class="hotels-sm-img-item">
                                <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/3.jpg"
                                    class="imgFluid lazyload" alt="Image" />
                            </div>
                            <div class="hotels-sm-img-item">
                                <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/4.jpg"
                                    class="imgFluid lazyload" alt="Image" />
                                <div class="hotels-sm-img-item">
                                    <img data-src="https://images.dnatatravel.com/ei/2/0/4/1/8/8/7/4.jpg"
                                        class="imgFluid lazyload" alt="Image" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="event-card event-card--details">
                            <div class="event-card__content">
                                <div class="title">Marriott Executive Apartments Dubai Creek</div>
                                <div class="details">
                                    <div class="icon"><i class="bx bx-map"></i></div>
                                    <div class="content">Riggat Albuteen Str, Po Box 81148, Dubai</div>
                                </div>
                                <div class="rating mb-0">
                                    <div class="stars">
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                        <i class="bx bxs-star" style="color: #f2ac06"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="event-card event-card--details">
                            <div class="event-card__content">
                                <span class="subtitle">Price from</span>
                                <div class="price"><span class="dirham">D</span>1431.42</div>
                                <span class="subtitle d-block mb-2">(Per person)</span>
                                <div class="details">
                                    <div class="icon"><i class="bx bxs-moon"></i></div>
                                    <div class="content">13 Jan 2026 - 15 Jan 2026 | 2 nights at hotel</div>
                                </div>
                                <div class="details">
                                    <div class="icon"><i class='bx bxs-group'></i></div>
                                    <div class="content">1 Adults, 0 Child, 1 Rooms </div>
                                </div>

                            </div>
                        </div>
                        <div class="event-card">
                            <div class="event-card__content">
                                <div class="hotel-detail__reviews m-0 p-0">
                                    <div class="review-header mb-0">
                                        <div class="rating">
                                            5.0 </div>
                                        <div class="details">
                                            <div class="client-name">Spectacular</div>
                                            <div class="checkin-time">Based on customer reviews</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="hotel-detail__tabs">
            <ul class="nav nav-pills details-tabs" id="pills-tab" role="tablist">
                <li role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Overview</button>
                </li>
                <li role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Rooms</button>
                </li>
                <li role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                        aria-selected="false">Information Items</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                    tabindex="0">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="hotel-detail-box text-document">
                                <h3 class="heading mt-0">Hotel Information</h3>
                                <p>Cheval Maison, The Palm Dubai is an all-apartment boutique property providing the ideal
                                    base from
                                    which to explore all that Dubai has to offer. Located on the iconic Palm Jumeirah, 131
                                    contemporary apartments provide the freedom, flexibility and space to create your own
                                    personal
                                    sanctuary, but still with easy access to the vibrant sights and sounds of this unique
                                    city.<br><br>The combination of 1-, 2- and 3-bedroom apartments, plus a stunning
                                    3-bedroom
                                    penthouse, provide all the facilities needed for an indulgent sunshine getaway, or a
                                    longer-
                                    term stay. Each apartment is stylishly designed, with the attention to detail and
                                    quality you
                                    would expect from Cheval. Fully equipped kitchens can be found in all, and most feature
                                    their
                                    own terrace or balcony, providing the perfect place to unwind with a long, cool drink
                                    and watch
                                    the sun set over the iconic Dubai Skyline. A 24-hour gym and rooftop pool provide an
                                    alternative
                                    for guests looking for something more active in their downtime.<br><br>The apartments
                                    are part
                                    of the Golden Mile residential complex, situated on the western trunk of Palm Jumeirah
                                    and
                                    ideally located to explore the city. Underground parking is available to guests. The
                                    Palm
                                    Monorail, just one minutes walk from the apartments, connects the key landmarks of the
                                    Palm
                                    Jumeirah and is easily accessible from Nakheel Mall. It also provides easy access to the
                                    metro
                                    system for those looking to connect with the rest of the city. For those looking to stay
                                    closer
                                    to home, the Nakheel Mall, with 300 retail outlets, is just next door, and top visitor
                                    attractions such as AquaVenture Waterpark and Pointe Palm are all close by.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="hotel-map">
                                <iframe
                                    src="https://maps.google.com/maps?q='+The Walk, Jumeirah Beach Residence, P.O. Box 2431, Dubai, United Arab Emirates+'&amp;output=embed"
                                    width="100%" height="490" frameborder="0" style="border:0;"
                                    allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                    tabindex="0">

                    <div class="row g-3 g-lg-4">

                        <!-- Card 1: Deluxe Room -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="Deluxe Room">
                                <div class="room-card__box">

                                    <!-- Header -->
                                    <div class="room-card__header">
                                        <h3 class="room-card__title">Deluxe Room</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <!-- Tags -->
                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-home'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <!-- Policy Info -->
                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,189.05</span>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,307.96</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 2: King Accessible -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="King Accessible Deluxe Room W/ Balcony">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">King Accessible Deluxe Room W/ Balcony</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-home'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,189.05</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,307.96</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 3: Two Queens Accessible -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="Two Queens Accessible Deluxe Room W/ Balcony">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">Two Queens Accessible Deluxe Room W/ Balcony</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-home'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,189.05</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,307.96</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 4: King Deluxe Partial Sea View -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="King Deluxe Room W/ Partial Sea View">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">King Deluxe Room W/ Partial Sea View</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-water'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,259.30</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,385.23</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 5: Two Queens Deluxe Partial Sea View -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="Two Queens Deluxe Room W/ Partial Sea View">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">Two Queens Deluxe Room W/ Partial Sea View</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-water'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,259.30</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,385.23</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 6: King Deluxe Sea View -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,407.96" name="room_selection"
                                    class="room-card__input" value="King Deluxe Room W/ Sea View - Balcony">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">King Deluxe Room W/ Sea View - Balcony</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-water'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,297.14</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,426.85</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 7: Two Queens Sea View -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="Two Queens Deluxe Room W/ Sea View - Balcony">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">Two Queens Deluxe Room W/ Sea View - Balcony</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag"><i class='bx bx-water'></i> Room Only</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,297.14</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,426.85</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                        <!-- Card 8: Breakfast -->
                        <div class="col-12 col-lg-6">
                            <label class="room-card">
                                <input type="radio" data-price="1,307.96" name="room_selection"
                                    class="room-card__input" value="Two Queens Accessible Deluxe Room W/ Balcony">
                                <div class="room-card__box">

                                    <div class="room-card__header">
                                        <h3 class="room-card__title">Two Queens Accessible Deluxe Room W/ Balcony</h3>
                                        <div class="room-card__radio"></div>
                                    </div>

                                    <div class="room-card__tags">
                                        <span class="room-card__tag room-card__tag--gold"><i class='bx bx-coffee'></i> Bed
                                            And Breakfast</span>
                                        <span class="room-card__tag room-card__tag--green"><i
                                                class='bx bx-check-shield'></i> Refundable</span>
                                    </div>

                                    <div class="room-card__policy">
                                        <div class="room-card__policy-row room-card__policy-row--free">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-check-circle room-card__icon'></i>
                                                <span>Free cancellation until <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__badge room-card__badge--free">FREE</span>
                                        </div>
                                        <div class="room-card__policy-row room-card__policy-row--fee">
                                            <div class="room-card__policy-content">
                                                <i class='bx bxs-info-circle room-card__icon'></i>
                                                <span>Cancellation after <strong>14 Jan 2026</strong></span>
                                            </div>
                                            <span class="room-card__price-text">AED 1,330.98</span>
                                        </div>
                                    </div>

                                    <div class="room-card__footer">
                                        <span class="room-card__label">Total Price</span>
                                        <span class="room-card__total">AED 1,464.08</span>
                                    </div>

                                </div>
                            </label>
                        </div>

                    </div>

                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                    tabindex="0">
                    <div class="hotel-detail-box editorial-section">
                        <div class="notice-wrapper">

                            <!-- Item 1 -->
                            <div class="notice-item">
                                <div class="notice-number">01</div>
                                <div class="notice-text">
                                    <p>Please be informed that there will be an all-day dining cafe serving hot
                                        breakfast daily and a selection of snacks, drinks, and light bites during the
                                        day.</p>
                                </div>
                            </div>

                            <!-- Item 2 -->
                            <div class="notice-item">
                                <div class="notice-number">02</div>
                                <div class="notice-text">
                                    <p>Please note that as Dubai continues to enhance itself as a holiday destination,
                                        there are many exciting hotel and leisure infrastructure developments currently
                                        underway. Areas including Dubai Marina, Downtown Dubai, Habtoor City, JBR, and
                                        The Palm are part of an evolving landscape.</p>
                                </div>
                            </div>

                            <!-- Item 3 -->
                            <div class="notice-item">
                                <div class="notice-number">03</div>
                                <div class="notice-text">
                                    <p>Children under the age of 5 are only allowed to use main swimming pools with the
                                        mandatory presence of an adult guardian inside the pool. Children must wear
                                        swimming vests.</p>
                                </div>
                            </div>

                            <!-- Item 4 -->
                            <div class="notice-item">
                                <div class="notice-number">04</div>
                                <div class="notice-text">
                                    <p>Please be advised that there will be a Tourism Tax payable per room, per night at
                                        the hotel.</p>
                                </div>
                            </div>

                            <!-- Item 5 -->
                            <div class="notice-item">
                                <div class="notice-number">05</div>
                                <div class="notice-text">
                                    <p>Please ensure you select the room type and board basis you wish to avail for the
                                        duration of your stay.</p>
                                </div>
                            </div>

                            <!-- Item 6 -->
                            <div class="notice-item">
                                <div class="notice-number">06</div>
                                <div class="notice-text">
                                    <p>Travelling during Ramadan: Ramadan is a culturally wonderful time to visit.
                                        Visitors are advised to respect those fasting by refraining from eating,
                                        drinking, or smoking in public during daylight hours.</p>
                                </div>
                            </div>

                            <!-- Item 7 -->
                            <div class="notice-item">
                                <div class="notice-number">07</div>
                                <div class="notice-text">
                                    <p>Please be informed that in the event of cancellation of existing bookings, there
                                        will be no reconfirmation under the same guest’s name.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="continue-bar">
        <div class="container">
            <div class="continue-bar-padding">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-md-6">
                        <div class="details-wrapper">
                            <div class="details">
                                <div class="total">Total</div>
                                <div><span class="dirham">D</span><span class="total-price" id="total-room-price">0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="details-btn-wrapper">
                            <a id="continueBtn"
                                href="{{ route('frontend.hotels.checkout') . '?' . http_build_query(request()->query()) }}"
                                class="btn-primary-custom">
                                Continue
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const priceEl = document.getElementById('total-room-price');
        const radios = document.querySelectorAll('input[name="room_selection"]');
        const continueBtn = document.getElementById('continueBtn');
        const baseUrl = "{{ route('frontend.hotels.checkout') . '?' . http_build_query(request()->query()) }}";

        // Set initial price from checked radio
        const checkedRadio = document.querySelector('input[name="room_selection"]:checked');
        if (checkedRadio) {
            priceEl.textContent = checkedRadio.dataset.price;
            updateContinueUrl(checkedRadio.value);
        }

        // Update price and URL on change
        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                priceEl.textContent = radio.dataset.price;
                updateContinueUrl(radio.value);
            });
        });

        // Update continue button URL with selected room
        function updateContinueUrl(roomValue) {
            const separator = baseUrl.includes('?') ? '&' : '?';
            continueBtn.href = baseUrl + separator + 'selected_room=' + encodeURIComponent(roomValue);
        }

        // Validate room selection on continue button click
        continueBtn.addEventListener('click', (e) => {
            const selectedRadio = document.querySelector('input[name="room_selection"]:checked');
            if (!selectedRadio) {
                e.preventDefault();
                showMessage("Please select a room before continuing.", "error");
                
                // Activate the Rooms tab
                const roomsTab = document.getElementById('pills-profile-tab');
                if (roomsTab) {
                    roomsTab.click();
                }
                
                // Scroll to the tabs section
                setTimeout(() => {
                    const tabsSection = document.querySelector('.hotel-detail__tabs');
                    if (tabsSection) {
                        tabsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 100);
            }
        });
    </script>
@endpush
