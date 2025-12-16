@extends('frontend.layouts.main')
@section('content')
    <div class="tour-details py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="gallery-section">
                        <nav class="breadcrumb-nav">
                            <ul class="breadcrumb-list">

                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">Home</a>
                                    <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                </li>


                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">Activities</a>
                                    <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                </li>


                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">Dubai City</a>
                                    <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                </li>


                                <li class="breadcrumb-item">
                                    <a href="#" class="breadcrumb-link">Dhow Cruise</a>
                                    <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                </li>


                                <li class="breadcrumb-item active">
                                    Dhow Cruise Dinner - Marina
                                </li>
                            </ul>
                        </nav>

                        <div class="gallery-grid">

                            <!-- Large Left Image -->
                            <a href="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                class="gallery-item item-main" data-fancybox="gallery" data-caption="Burj Khalifa View">
                                <img src="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                    alt="Main View">
                            </a>

                            <!-- Small Top Middle -->
                            <a href="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                class="gallery-item d-none d-lg-block" data-fancybox="gallery" data-caption="Sunset Horizon">
                                <img src="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                    alt="Sunset">
                            </a>

                            <!-- Small Top Right -->
                            <a href="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                class="gallery-item d-none d-lg-block" data-fancybox="gallery" data-caption="City Skyline">
                                <img src="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                    alt="Skyline">
                            </a>

                            <!-- Small Bottom Middle -->
                            <a href="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                class="gallery-item d-none d-lg-block" data-fancybox="gallery" data-caption="Interior View">
                                <img src="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                    alt="Interior">
                            </a>

                            <!-- Small Bottom Right (View Gallery Trigger)-->
                            <a href="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                class="gallery-item item-last" data-fancybox="gallery" data-caption="Observation Deck">
                                <img src="https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?q=80&w=1000&auto=format&fit=crop"
                                    alt="Observation Deck">

                                <!-- Overlay content -->
                                <div class="gallery-overlay">
                                    <span class="more-text fw-bold mb-2">+ 4 Images</span>
                                    <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold">
                                        <i class='bx bx-images me-1'></i> View Gallery
                                    </button>
                                </div>
                            </a>

                            <!-- Hidden items for gallery loop -->
                            <a href="https://images.unsplash.com/photo-1512453979798-5ea90b7705bb" data-fancybox="gallery"
                                class="d-none"></a>
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="py-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <h1 class="tour-header-title">Burj Khalifa At The Top Tickets</h1>

                            <div class="tour-header-rating">
                                <i class='bx bxs-star text-warning'></i>
                                <span class="rating-value">4.9</span>
                                <span class="rating-count">(5 Reviews)</span>
                            </div>
                        </div>
                        <div class="tour-features py-4">
                            <div class="row g-0">

                                <!-- Column 1 -->
                                <div class="col-lg-6 col-md-12">

                                    <!-- Item: Operating Hours -->
                                    <div class="feature-item">
                                        <div class="icon-box theme-green">
                                            <i class='bx bx-time-five'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Operating Hours</h5>
                                            <p class="feat-desc">Approx 9.00 pm to 10:30 pm</p>
                                        </div>
                                    </div>

                                    <!-- Item: Mobile Voucher -->
                                    <div class="feature-item">
                                        <div class="icon-box theme-blue">
                                            <i class='bx bx-mobile'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Mobile Voucher Accepted</h5>
                                            <p class="feat-desc">Use your phone or print your voucher</p>
                                        </div>
                                    </div>

                                    <!-- Item: Language -->
                                    <div class="feature-item">
                                        <div class="icon-box theme-purple">
                                            <i class='bx bx-globe'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">English</h5>
                                        </div>
                                    </div>

                                </div>

                                <!-- Column 2 -->
                                <div class="col-lg-6 col-md-12">

                                    <!-- Item: Instant Confirmation -->
                                    <div class="feature-item">
                                        <div class="icon-box theme-red">
                                            <i class='bx bx-bolt-circle'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Instant Confirmation</h5>
                                            <p class="feat-desc">Instant Tour Confirmation will be Provided.</p>
                                        </div>
                                    </div>

                                    <!-- Item: Free Cancellation -->
                                    <div class="feature-item">
                                        <div class="icon-box theme-green">
                                            <i class='bx bx-time'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Free Cancellation 24 hours Prior</h5>
                                        </div>
                                    </div>

                                    <!-- Item: Google Map -->
                                    <div class="feature-item">
                                        <div class="icon-box theme-orange">
                                            <i class='bx bx-map'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Google Map</h5>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="faq-wrapper">
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question">Dhow Cruise Dinner - Marina Overview</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">

                                        <p>
                                            Our Marina Dhow Cruise combines magical sightseeing, delectable dining, and
                                            striking
                                            traditional entertainment shows in an elegant setting. Lasting for about 90
                                            minutes,
                                            this
                                            Marina Dhow Cruise Dubai experience allows you to absorb the modern city’s
                                            unrivaled
                                            architecture, opulent yachts, and breathtaking waterfront sights at their best.
                                        </p>

                                        <p><strong>WHAT TO EXPECT?</strong></p>

                                        <p>Out-of-the-Box Sightseeing Experience</p>

                                        <p>This traditional Dubai Marina Dhow Cruise will sail you down the uber-classy
                                            Dubai
                                            Marina,
                                            modeled to resemble a Venetian-style canal. Leaving the Dubai Marina Yacht Club,
                                            our
                                            traditional wooden dhow offers fascinatingly unique views of modern Dubai. So
                                            what
                                            better
                                            way to take in the glorious views of the lavish architecture of residences,
                                            resorts,
                                            and
                                            shopping facilities that abound in the region?</p>

                                        <p>Enjoy a Welcome Drink and Buffet Dinner</p>

                                        <p>The first that awaits you on your Dhow Cruise Dinner in Dubai Marina experience
                                            is a
                                            complimentary welcome drink. After that, you will settle in the dhow’s lower
                                            air-conditioned
                                            deck or head up to the partly open upper deck. This unique Marina Dubai Cruise
                                            offers
                                            breathtaking views of the surroundings while you dine on delectable
                                            international
                                            cuisines
                                            (including a four-star menu) in a sophisticated setting that exudes traditional
                                            charm.
                                        </p>

                                        <p>Take in Extraordinary Entertainment</p>

                                        <p>This Dhow Cruise Dubai Marina price also includes mind-blowing entertainment
                                            performances
                                            (such as the Tanura show) aboard our dhow, bounded by dazzling illumination and
                                            their
                                            multi-hued manifestation on Dubai Marina’s water. Precisely, with unlimited
                                            refreshments,
                                            great food, stunning views, and revitalizing entertainment activities, it is
                                            easy to
                                            see
                                            why
                                            our Marina Dhow Cruise with Dinner is a highly sought-after trip.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question">Dhow Cruise Dinner - Marina Highlights</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        <ul>
                                            <li>
                                                Admire Dubai’s uber-contemporary cityscape from a subdued yet magical
                                                ambiance
                                                on this Dhow Cruise Dubai Marina.
                                            </li>
                                            <li>
                                                Take in the attractions and structures across Dubai Marina from the dhow’s
                                                air-conditioned lower deck or partly open upper deck.
                                            </li>
                                            <li>
                                                Feel the layers of Dubai’s fascinating culture and past as you sail down one
                                                of
                                                Dubai’s most stylish neighborhoods in our traditional dhow that was once
                                                used
                                                for fishing and pearl farming during the pre-oil era.
                                            </li>
                                        </ul>

                                        <p>While you choose to enamour yourself with the mesmerising skyline of Dubai at
                                            night,
                                            don’t forget to experience the region’s serene landscape with <a
                                                href="#">Musandam Dibba tour</a>. Also try our Dubai Water canal
                                            cruise,
                                            sign up for the brand-new Ain Dubai tours, and of course the world famous <a
                                                href="#">Dubai Desert Safari</a>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question">Dhow Cruise Dinner - Marina Inclusions</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        <ul>
                                            <li>90 minutes Cruising in Dubai Marina, Yacht Club, Marina Towers. </li>
                                            <li>International 4-Star buffet with Veg & Non-Veg dishes.</li>
                                            <li>Welcome drinks, Water, Tea & Coffee</li>
                                            <li>Tanura show and soft background music</li>
                                            <li>Transfers (If Selected)</li>
                                        </ul>

                                        <p><strong>Note: Please check Option wise inclusions for every product before
                                                booking
                                            </strong></p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question">Dhow Cruise Dinner - Marina Exclusions</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        <ul>
                                            <li>All personal expenses spend for shopping, drinks and dining etc on-site
                                                during
                                                the tour. </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-4">
                            <div class="container">
                                <h3 class="tour-details-title mb-4">Location</h3>

                                <div class="d-flex align-items-start mb-4">
                                    <div class="location-icon-box me-3">
                                        <i class='bx bx-map'></i>
                                    </div>
                                    <div>
                                        <h6 class="location-title mb-1">Burj Khalifa - Sheikh Mohammed bin Rashid Boulevard
                                            -
                                            Dubai - United Arab Emirates</h6>
                                        <p class="location-subtitle mb-0">1 Sheikh Mohammed bin Rashid Blvd - Downtown
                                            Dubai -
                                            Dubai - United Arab Emirates</p>
                                    </div>
                                </div>

                                <div class="map-wrapper">
                                    <iframe src="https://www.google.com/maps?q=United Arab Emirates&output=embed"
                                        alt="Google Map Location" class="img-fluid w-100"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="py-4">
                        <div class="booking-widget">
                            <!-- 1. Price Header -->
                            <div class="booking-header">
                                <span class="booking-label">From:</span>
                                <div class="booking-price">AED 159.00</div>
                            </div>

                            <!-- 2. Date & Time Selection -->
                            <div class="booking-form">
                                <div class="form-group mb-3">
                                    <label class="form-label">Select Date</label>
                                    <div class="input-icon-wrap">
                                        <i class='bx bx-calendar'></i>
                                        <input type="text" name="start_date" class="form-control custom-select-input"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label">Select Time</label>
                                    <div class="input-icon-wrap">
                                        <i class='bx bx-time-five'></i>
                                        <select class="form-select custom-select-input">
                                            <option selected>Choose time...</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="divider">

                                <!-- 3. Passengers (PAX) -->
                                <div class="pax-section mb-4">
                                    <label class="form-label mb-3">Select Pax</label>

                                    <!-- Adult Row -->
                                    <div class="pax-row">
                                        <div class="pax-info">
                                            <span class="pax-type">Adult</span>
                                            <span class="pax-age">Ages 12 to 99</span>
                                        </div>
                                        <div class="pax-action">
                                            <span class="pax-price">AED 52.50</span>
                                            <div class="qty-control">
                                                <button
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="qty-btn" type="button"><i class="bx bx-minus"></i></button>
                                                <input type="number" class="counter-input qty-input" value="1"
                                                    readonly="" min="0">
                                                <button
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="qty-btn" type="button"><i class="bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Child Row -->
                                    <div class="pax-row">
                                        <div class="pax-info">
                                            <span class="pax-type">Child</span>
                                            <span class="pax-age">Ages 3 to 11</span>
                                        </div>
                                        <div class="pax-action">
                                            <span class="pax-price">AED 21.00</span>
                                            <div class="qty-control">
                                                <button
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                                    class="qty-btn" type="button"><i class="bx bx-minus"></i></button>
                                                <input type="number" class="counter-input qty-input" value="1"
                                                    readonly="" min="0">
                                                <button
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                                    class="qty-btn" type="button"><i class="bx bx-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Actions -->
                                <div class="booking-actions">
                                    <button class="btn btn-add-cart mb-2">
                                        Add to Cart
                                    </button>
                                    <button class="btn btn-whatsapp">
                                        <i class='bx bxl-whatsapp'></i> Book via WhatsApp
                                    </button>
                                </div>

                                <div class="text-center mt-3">
                                    <span class="small text-muted"><i class='bx  bx-shield-quarter'></i> Secure
                                        Booking</span>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 choose-andaleeb-card">
                            <div class="card-body p-4">
                                <!-- Section Header -->
                                <h6 class="choose-card-title">Why choose Andaleeb?</h6>

                                <div class="mt-4">
                                    <!-- Item 1 -->
                                    <div class="choose-item">
                                        <div class="choose-icon icon-gold">
                                            <i class='bx bxs-badge-dollar'></i>
                                        </div>
                                        <div class="choose-text">
                                            <span class="choose-label">Best Price Guarantee</span>
                                            <p class="choose-sub">Always the best deal—book with confidence.</p>
                                        </div>
                                    </div>

                                    <!-- Item 2 -->
                                    <div class="choose-item">
                                        <div class="choose-icon icon-teal">
                                            <i class='bx bxs-lock-alt'></i>
                                        </div>
                                        <div class="choose-text">
                                            <span class="choose-label">Secure Online Transaction</span>
                                            <p class="choose-sub">Protected with advanced encryption.</p>
                                        </div>
                                    </div>

                                    <!-- Item 3 -->
                                    <div class="choose-item">
                                        <div class="choose-icon icon-blue">
                                            <i class='bx bxs-message-rounded-dots'></i>
                                        </div>
                                        <div class="choose-text">
                                            <span class="choose-label">24X7 Live Chat Support</span>
                                            <p class="choose-sub">Real humans, ready to help anytime.</p>
                                        </div>
                                    </div>

                                    <!-- Item 4 -->
                                    <div class="choose-item">
                                        <div class="choose-icon icon-orange">
                                            <i class='bx bxs-smile'></i>
                                        </div>
                                        <div class="choose-text">
                                            <span class="choose-label">Happy Travelers Worldwide</span>
                                            <p class="choose-sub">Trusted by millions of happy travelers.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <div class="reviews">

                        <!-- Header with Toggle Button -->
                        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
                            <div class="tour-header-title">Customer Reviews</div>
                            <button class="themeBtn themeBtn--primary btn-review-toggle" type="button"
                                data-bs-toggle="collapse" data-bs-target="#writeReviewForm" aria-expanded="false">
                                Write a Review
                            </button>
                        </div>

                        <!-- Hidden Review Form -->
                        <div class="collapse mb-5" id="writeReviewForm">
                            <div class="review-form-card">
                                <h6 class="mb-4 fw-bold">Share your experience</h6>
                                <form>
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="form-group">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="custom-input form-control"
                                                    placeholder="Summarize your visit" required>
                                            </div>
                                        </div>
                                        <div class="col-12 ">
                                            <div class="form-group">
                                                <label class="form-label">Message</label>
                                                <textarea class="custom-textarea form-control" rows="4" placeholder="What did you like or dislike?"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label class="form-label">Rating</label>
                                                <div class="working-rating">
                                                    <input type="radio" id="star5" name="rating"
                                                        value="5"><label class="star" for="star5"
                                                        title="Awesome"></label>
                                                    <input type="radio" id="star4" name="rating"
                                                        value="4"><label class="star" for="star4"
                                                        title="Great"></label>
                                                    <input type="radio" id="star3" name="rating"
                                                        value="3"><label class="star" for="star3"
                                                        title="Very good"></label>
                                                    <input type="radio" id="star2" name="rating"
                                                        value="2"><label class="star" for="star2"
                                                        title="Good"></label>
                                                    <input type="radio" id="star1" name="rating"
                                                        value="1"><label class="star" for="star1"
                                                        title="Bad"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="themeBtn">Submit Review</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="row g-4">
                            <div class="col-lg-4 col-md-12">
                                <div class="reviews__card reviews__card--summary">
                                    <div class="reviews__header">
                                        <div class="reviews__score-wrap">
                                            <i class='bx bxs-star reviews__star-icon'></i>
                                            <span class="reviews__score">4.9</span>
                                        </div>
                                        <span class="reviews__total">374 Ratings</span>
                                    </div>

                                    <div class="reviews__bars">
                                        <!-- Excellent -->
                                        <div class="reviews__bar-row">
                                            <span class="reviews__label">Excellent</span>
                                            <div class="reviews__track">
                                                <div class="reviews__fill" style="width: 98%;"></div>
                                            </div>
                                            <span class="reviews__count">369</span>
                                        </div>
                                        <!-- Very Good -->
                                        <div class="reviews__bar-row">
                                            <span class="reviews__label">VeryGood</span>
                                            <div class="reviews__track">
                                                <div class="reviews__fill" style="width: 5%;"></div>
                                            </div>
                                            <span class="reviews__count">4</span>
                                        </div>
                                        <!-- Average -->
                                        <div class="reviews__bar-row">
                                            <span class="reviews__label">Average</span>
                                            <div class="reviews__track">
                                                <div class="reviews__fill" style="width: 2%;"></div>
                                            </div>
                                            <span class="reviews__count">1</span>
                                        </div>
                                        <!-- Poor -->
                                        <div class="reviews__bar-row">
                                            <span class="reviews__label">Poor</span>
                                            <div class="reviews__track">
                                                <div class="reviews__fill" style="width: 0%;"></div>
                                            </div>
                                            <span class="reviews__count">0</span>
                                        </div>
                                        <!-- Terrible -->
                                        <div class="reviews__bar-row">
                                            <span class="reviews__label">Terrible</span>
                                            <div class="reviews__track">
                                                <div class="reviews__fill" style="width: 0%;"></div>
                                            </div>
                                            <span class="reviews__count">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row reviews-slider mt-0 g-4">
                                    <div class="col-md-6">
                                        <div class="reviews__card reviews__card--user">
                                            <div class="reviews__user-header">
                                                <div class="reviews__avatar">
                                                    <i class='bx bx-user'></i>
                                                </div>
                                                <div class="reviews__meta">
                                                    <h6 class="reviews__username">Purjit</h6>
                                                    <span class="reviews__date">May 2025</span>
                                                </div>
                                            </div>

                                            <div class="reviews__body">
                                                <h5 class="reviews__product-title">Burj Khalifa At The Top Tickets</h5>

                                                <div class="reviews__rating-row">
                                                    <i class='bx bxs-star reviews__star-icon--small'></i>
                                                    <span class="reviews__rating-text">4 (Rating)</span>
                                                </div>

                                                <div class="reviews__tag">
                                                    <span>Burj Khalifa At The Top Tickets</span>
                                                </div>

                                                <p class="reviews__comment">
                                                    I was with my family in Dubai and visited Burj Khalifa. So, An
                                                    incredible
                                                    view and a smooth experience overall. The elevator ride was surprisingly
                                                    fast...
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="reviews__card reviews__card--user">
                                            <div class="reviews__user-header">
                                                <div class="reviews__avatar">
                                                    <i class='bx bx-user'></i>
                                                </div>
                                                <div class="reviews__meta">
                                                    <h6 class="reviews__username">Stefan</h6>
                                                    <span class="reviews__date">June 2025</span>
                                                </div>
                                            </div>

                                            <div class="reviews__body">
                                                <h5 class="reviews__product-title">Burj Khalifa At The Top Tickets</h5>

                                                <div class="reviews__rating-row">
                                                    <i class='bx bxs-star reviews__star-icon--small'></i>
                                                    <span class="reviews__rating-text">5 (Rating)</span>
                                                </div>

                                                <div class="reviews__tag">
                                                    <span>Outstanding Customer Service</span>
                                                </div>

                                                <p class="reviews__comment">
                                                    Hi Khin, Hi Khin, we have seen a lot incl. Top of Burj Khalifa and the
                                                    Nighttour and we have a lot of pictures now. Everything was perfect.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="reviews__card reviews__card--user">
                                            <div class="reviews__user-header">
                                                <div class="reviews__avatar">
                                                    <i class='bx bx-user'></i>
                                                </div>
                                                <div class="reviews__meta">
                                                    <h6 class="reviews__username">Stefan</h6>
                                                    <span class="reviews__date">June 2025</span>
                                                </div>
                                            </div>

                                            <div class="reviews__body">
                                                <h5 class="reviews__product-title">Burj Khalifa At The Top Tickets</h5>

                                                <div class="reviews__rating-row">
                                                    <i class='bx bxs-star reviews__star-icon--small'></i>
                                                    <span class="reviews__rating-text">5 (Rating)</span>
                                                </div>

                                                <div class="reviews__tag">
                                                    <span>Outstanding Customer Service</span>
                                                </div>

                                                <p class="reviews__comment">
                                                    Hi Khin, Hi Khin, we have seen a lot incl. Top of Burj Khalifa and the
                                                    Nighttour and we have a lot of pictures now. Everything was perfect.
                                                </p>
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
    </div>

    @php
        $tabs = [
            [
                'id' => 'cruises-from-dubai',
                'label' => 'Cruises from Dubai',
                'links' => [
                    '4N Gulf Discovery Cruise to Dubai - Doha - Bahrain - Abu Dhabi',
                    '4N MSC Euribia Arabian Voyage - Dubai - Doha - Bahrain - Abu Dhabi',
                    'ON Gulf Horizons Escape Dubai - Doha - Bahrain - Abu Dhabi',
                    '4N Middle East Getaway Dubai - Bahrain - Abu Dhabi',
                ],
            ],
            [
                'id' => 'dubai-tour-packages',
                'label' => 'Dubai Tour Packages',
                'links' => [
                    'Dubai Budget Explorer with Dubai Mall Attractions',
                    'Dubai Jain Signature Experience',
                    'Dubai New Year Celebration with Gala Dinner',
                    'Dubai Sky High Thrills Holiday',
                    'Dubai Stopover Delight',
                    'Magical Dubai Christmas Family Holiday',
                    'Royal Dubai Signature Experience',
                    'Super Saver Dubai Holiday',
                ],
            ],
            [
                'id' => 'abu-dhabi-holidays',
                'label' => 'Abu Dhabi Holidays',
                'links' => [
                    'Abu Dhabi Cultural Discovery Tour',
                    'Ferrari World Adventure with Yas Island Stay',
                    'Luxury Abu Dhabi City Escape',
                    'Abu Dhabi Grand Prix Experience',
                ],
            ],
            [
                'id' => 'middle-east-cruises',
                'label' => 'Middle East Cruises',
                'links' => [
                    'Arabian Peninsula Cruise Experience',
                    'Red Sea and Arabian Coast Voyage',
                    'Persian Gulf Highlights Cruise',
                    'Luxury Middle East Cruise Escape',
                ],
            ],
            [
                'id' => 'honeymoon-specials',
                'label' => 'Honeymoon Specials',
                'links' => [
                    'Romantic Dubai Honeymoon Escape',
                    'Luxury Desert and City Honeymoon Experience',
                    'Dubai Marina Romance Getaway',
                    'Beachside Dubai Honeymoon Retreat',
                ],
            ],
            [
                'id' => 'family-holidays',
                'label' => 'Family Holidays',
                'links' => [
                    'Dubai Family Fun with Theme Parks',
                    'Abu Dhabi Family Adventure Package',
                    'Middle East Family Cruise Escape',
                    'Kids Special Dubai Holiday',
                ],
            ],
            [
                'id' => 'luxury-escapes',
                'label' => 'Luxury Escapes',
                'links' => [
                    'Ultra Luxury Dubai Experience',
                    'Private Yacht Staycation Dubai',
                    'Seven Star Dubai Signature Holiday',
                    'Elite Middle East Luxury Cruise',
                ],
            ],
            [
                'id' => 'festive-specials',
                'label' => 'Festive Specials',
                'links' => [
                    'Dubai Christmas and New Year Extravaganza',
                    'Eid Special Dubai Celebration Package',
                    'New Year Fireworks Dubai Holiday',
                    'Festive Family Dubai Escape',
                ],
            ],
            [
                'id' => 'short-breaks',
                'label' => 'Short Breaks',
                'links' => [
                    'Dubai Weekend Escape',
                    'Abu Dhabi Quick Getaway',
                    'Luxury 3N Dubai City Break',
                    'Dubai Stopover Short Holiday',
                ],
            ],
            [
                'id' => 'adventure-trips',
                'label' => 'Adventure Trips',
                'links' => [
                    'Dubai Desert Safari Adventure',
                    'Sky Diving and Luxury Stay Dubai',
                    'Middle East Adventure Cruise',
                    'Thrill Seeker Dubai Holiday',
                ],
            ],
        ];

    @endphp

    <section class="mar-y section-explore">
        <div class="container">

            <div class="section-content mb-4">
                <h3 class="heading mb-0">Explore more with us</h3>
            </div>

            <!-- Tabs Navigation Wrapper -->
            <div class="position-relative explore-wrapper mb-4">
                <!-- Left Arrow -->
                <button class="explore-arrow-btn explore-arrow-left" aria-label="Scroll Left">
                    <i class="bx bx-chevron-left"></i>
                </button>

                <!-- Tabs List -->
                <ul class="d-flex overflow-auto flex-nowrap scroll-smooth no-scrollbar explore-scroller" role="tablist">
                    @foreach ($tabs as $index => $tab)
                        <li role="presentation" class="flex-shrink-0">
                            <button class="explore-tab-btn {{ $index === 0 ? 'active' : '' }}"
                                id="{{ $tab['id'] }}-tab" data-bs-toggle="tab"
                                data-bs-target="#{{ $tab['id'] }}-pane" type="button" role="tab"
                                aria-controls="{{ $tab['id'] }}-pane"
                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $tab['label'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Right Arrow -->
                <button class="explore-arrow-btn explore-arrow-right" aria-label="Scroll Right">
                    <i class="bx bx-chevron-right"></i>
                </button>
            </div>

            <!-- Tabs Content -->
            <div class="tab-content">
                @foreach ($tabs as $index => $tab)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="{{ $tab['id'] }}-pane"
                        role="tabpanel" aria-labelledby="{{ $tab['id'] }}-tab" tabindex="0">

                        <!-- Grid Layout for Links -->
                        <div class="explore-link-grid">
                            @foreach ($tab['links'] as $link)
                                <a href="#" class="explore-link-item">
                                    <span>{{ $link }}</span>
                                    <i class="bx bx-right-arrow-alt"></i> <!-- Long Arrow Icon -->
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/daterangepicker.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"
        integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
        integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('frontend/assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/daterangepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const format = "MMM D, YYYY";

            $("input[name='start_date']").daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                showDropdowns: true,
                minDate: moment(),
                locale: {
                    format: format
                }
            });
        });
    </script>
@endpush
