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
                                    <a href="{{ route('frontend.index') }}" class="breadcrumb-link">Home</a>
                                    <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                </li>

                                <li class="breadcrumb-item">
                                    <a href="{{ route('frontend.uae-services') }}" class="breadcrumb-link">Tour
                                        Packages</a>
                                    <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                </li>

                                @if ($tour->categories->count() > 0)
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('frontend.tour-category.details', $tour->categories[0]->slug) }}"
                                            class="breadcrumb-link">
                                            {{ $tour->categories[0]->name }}
                                        </a>
                                        <i class='bx bx-chevron-right breadcrumb-separator'></i>
                                    </li>
                                @endif
                                <li class="breadcrumb-item active">
                                    {{ $tour->name }}
                                </li>
                            </ul>
                        </nav>

                        @php
                            $bannerImages = collect($tour->content['product_images'] ?? [])
                                ->where('image_type', 'BANNER')
                                ->values();
                        @endphp

                        <div class="gallery-grid">
                            {{-- Main image --}}
                            @if ($bannerImages->count())
                                <a href="{{ $bannerImages[0]['image_url'] }}" class="gallery-item item-main"
                                    data-fancybox="gallery">
                                    <img data-src="{{ $bannerImages[0]['image_url'] }}" alt="Main Image" class="lazyload">
                                </a>
                            @endif

                            {{-- Next 3 small images --}}
                            @foreach ($bannerImages->slice(1, 3) as $image)
                                <a href="{{ $image['image_url'] }}" class="gallery-item d-none d-lg-block"
                                    data-fancybox="gallery">
                                    <img data-src="{{ $image['image_url'] }}" alt="Gallery Image" class="lazyload">
                                </a>
                            @endforeach

                            {{-- Last visible tile with overlay --}}
                            @if ($bannerImages->count() > 4)
                                <a href="{{ $bannerImages[4]['image_url'] }}" class="gallery-item item-last"
                                    data-fancybox="gallery">
                                    <img data-src="{{ $bannerImages[4]['image_url'] }}" alt="More Images" class="lazyload">
                                    @if ($bannerImages->count() - 5 > 0)
                                        <div class="gallery-overlay">
                                            <span class="more-text fw-bold mb-2">
                                                + {{ $bannerImages->count() - 5 }} Images
                                            </span>
                                            <button class="btn btn-light btn-sm rounded-pill px-3 fw-bold">
                                                <i class="bx bx-images me-1"></i> View Gallery
                                            </button>
                                        </div>
                                    @endif
                                </a>
                            @endif

                            {{-- Hidden remaining images for Fancybox --}}
                            @foreach ($bannerImages->slice(5) as $image)
                                <a href="{{ $image['image_url'] }}" data-fancybox="gallery" class="d-none"></a>
                            @endforeach
                        </div>

                    </div>

                </div>
                <div class="col-md-8">
                    <div class="py-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <h1 class="tour-header-title">{{ $tour->name }}</h1>

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

                                    <div class="feature-item">
                                        <div class="icon-box theme-green">
                                            <i class='bx bx-time-five'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Duration</h5>
                                            <p class="feat-desc">{{ $tour->duration }}</p>
                                        </div>
                                    </div>

                                    <div class="feature-item">
                                        <div class="icon-box theme-blue">
                                            <i class='bx bx-mobile'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Mobile Voucher Accepted</h5>
                                            <p class="feat-desc">Use your phone or print your voucher</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-lg-6 col-md-12">

                                    <div class="feature-item">
                                        <div class="icon-box theme-red">
                                            <i class='bx bx-bolt-circle'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Instant Confirmation</h5>
                                            <p class="feat-desc">Instant Tour Confirmation will be Provided.</p>
                                        </div>
                                    </div>

                                    <div class="feature-item">
                                        <div class="icon-box theme-green">
                                            <i class='bx bx-refresh'></i>
                                        </div>
                                        <div class="text-content">
                                            <h5 class="feat-title">Free Cancellation</h5>
                                            <p class="feat-desc">Cancel up to 24 hours in advance for a full refund.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="faq-wrapper">
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question"> Overview</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        <p>
                                            {{ $tour->long_description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if (count($tour->content['product_highlights'] ?? []) > 0)
                                <div class="faq-item">
                                    <div class="faq-header">
                                        <span class="faq-question"> Highlights</span>
                                        <i class='bx bx-chevron-down faq-icon'></i>
                                    </div>
                                    <div class="faq-body">
                                        <div class="faq-content text-document">
                                            <ul>
                                                @foreach ($tour->content['product_highlights'] as $highlight)
                                                    <li>
                                                        {{ $highlight['highlight_description'] }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (count($tour->includes) > 0)
                                <div class="faq-item">
                                    <div class="faq-header">
                                        <span class="faq-question"> Inclusions</span>
                                        <i class='bx bx-chevron-down faq-icon'></i>
                                    </div>
                                    <div class="faq-body">
                                        <div class="faq-content text-document">
                                            <ul>
                                                @foreach ($tour->includes as $include)
                                                    <li>{{ $include['include_description'] ?? '' }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (count($tour->excludes) > 0)
                                <div class="faq-item">
                                    <div class="faq-header">
                                        <span class="faq-question"> Exclusions</span>
                                        <i class='bx bx-chevron-down faq-icon'></i>
                                    </div>
                                    <div class="faq-body">
                                        <div class="faq-content text-document">
                                            <ul>
                                                @foreach ($tour->excludes as $exclude)
                                                    <li>{{ $exclude['exclude_description'] ?? '' }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question"> Cancellation policy</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        {!! sanitizeBulletText($tour->cancellation_policies) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question"> Additional Information</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        {!! sanitizeBulletText($tour->additional_information) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-header">
                                    <span class="faq-question"> Important Information</span>
                                    <i class='bx bx-chevron-down faq-icon'></i>
                                </div>
                                <div class="faq-body">
                                    <div class="faq-content text-document">
                                        <p>{{ $tour->content['product_entry_notes'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $location = $tour->locations[0] ?? null;

                            $address = $location['location_address'] ?? null;
                            $fullAddress = $address ? $address['name'] ?? '' : '';
                        @endphp

                        @if ($location && $address)
                            <div class="py-4">
                                <h3 class="tour-details-title mb-4">Location</h3>

                                <div class="d-flex align-items-start mb-4">
                                    <div class="location-icon-box me-3">
                                        <i class='bx bx-map'></i>
                                    </div>

                                    <div>
                                        <h6 class="location-title mb-1">
                                            {{ $location['location_name'] ?? 'Tour Location' }}
                                        </h6>

                                        <p class="location-subtitle mb-0">
                                            {{ $fullAddress }}
                                        </p>
                                    </div>
                                </div>

                                <div class="map-wrapper">
                                    <iframe src="https://www.google.com/maps?q={{ $fullAddress }}&output=embed"
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                        class="img-fluid w-100" style="border:0;"></iframe>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="py-4">
                        <div class="booking-widget">
                            <!-- 1. Price Header -->
                            <div class="booking-header">
                                <span class="booking-label">From:</span>
                                <div class="booking-price">
                                    {{ formatPrice($tour->price) }}
                                </div>
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
                                            <span class="pax-age">Ages 18 to 99</span>
                                        </div>
                                        <div class="pax-action">
                                            <span class="pax-price"> {{ formatPrice($tour->price) }}</span>
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
                                            <span class="pax-age">Ages 3 to 17</span>
                                        </div>
                                        <div class="pax-action">
                                            <span class="pax-price">{{ formatPrice($tour->price) }}</span>
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
                                    <a target="_blank"
                                        href="https://api.whatsapp.com/send?phone={{ $config['WHATSAPP'] }}&text=I%20have%20an%20inquiry%20about%20{{ $tour->name }}"
                                        class="btn btn-whatsapp">
                                        <i class='bx bxl-whatsapp'></i> Book via WhatsApp
                                    </a>
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
                                            <span class="reviews__label">Very Good</span>
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
        $tabs = [];
        foreach ($tourCategories as $category) {
            $tabs[] = [
                'id' => 'category-' . $category->id,
                'label' => $category->name,
                'links' => $category->tours
                    ->map(function ($tour) {
                        return [
                            'label' => $tour->name,
                            'url' => route('frontend.tour.details', $tour->slug),
                        ];
                    })
                    ->toArray(),
            ];
        }
    @endphp
    @if ($tourCategories->isNotEmpty())
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
                    <ul class="d-flex overflow-auto flex-nowrap scroll-smooth no-scrollbar explore-scroller"
                        role="tablist">
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
                                    <a href="{{ $link['url'] }}" class="explore-link-item">
                                        <span>{{ $link['label'] }}</span>
                                        <i class="bx bx-right-arrow-alt"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
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

    @if ($tourCategories->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.explore-wrapper')?.forEach(wrapper => {
                    const scroller = wrapper.querySelector('.explore-scroller');
                    const arrowLeft = wrapper.querySelector('.explore-arrow-left');
                    const arrowRight = wrapper.querySelector('.explore-arrow-right');

                    if (!scroller) return;

                    const updateArrows = () => {
                        // Tolerance of 1px for high-DPI screens
                        const maxScrollLeft = scroller.scrollWidth - scroller.clientWidth;

                        // Show left arrow if scrolled more than 0
                        arrowLeft.style.display = scroller.scrollLeft > 5 ? 'flex' : 'none';

                        // Show right arrow if not at the end
                        arrowRight.style.display = scroller.scrollLeft >= maxScrollLeft - 5 ? 'none' :
                            'flex';
                    };

                    arrowLeft.addEventListener('click', () => {
                        scroller.scrollBy({
                            left: -200,
                            behavior: 'smooth'
                        });
                    });

                    arrowRight.addEventListener('click', () => {
                        scroller.scrollBy({
                            left: 200,
                            behavior: 'smooth'
                        });
                    });

                    scroller.addEventListener('scroll', updateArrows);
                    window.addEventListener('resize', updateArrows);

                    // Initial check
                    updateArrows();
                });
            });
        </script>
    @endif
@endpush
