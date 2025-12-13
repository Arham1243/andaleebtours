@extends('frontend.layouts.main')
@section('content')
    <!-- Page Header / Hero -->
<section class="page-header py-5 d-flex align-items-center" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('frontend/assets/images/about-banner.jpeg') }}');">
    <div class="container text-center text-white">
        <h1 class="fw-bold display-4">ABOUT US</h1>
        <p class="lead mb-0">Your trusted travel partner since 2021</p>
    </div>
</section>

<!-- Who We Are Section -->
<section class="section-about py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset('frontend/assets/images/about.jpeg') }}" class="img-fluid rounded-4 shadow-lg" alt="Our Team">
                    <!-- Experience Badge -->
                    <div class="experience-badge">
                        <span class="fw-bold display-6">18+</span>
                        <span class="small d-block text-uppercase ls-1">Years of<br>Exp.</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <span class="text-uppercase fw-bold letter-spacing-2" style="color: var(--color-primary);">Who We Are</span>
                <h2 class="fw-bold mb-4 mt-2">Crafting Unforgettable Journeys Since 2021</h2>
                <p class="text-muted">
                    Welcome to <strong>Andaleeb Travel Agency</strong>. We are a professionally managed travel and tourism company dedicated to creating world-class travel services for individuals, families, and corporate clients.
                </p>
                <p class="text-muted">
                    Our mission is to simplify travel planning by offering seamless, affordable, and customized travel solutions. We pride ourselves on transparency, professionalism, and a commitment to excellence.
                </p>
                
                <div class="alert alert-light border-start border-4 mt-4" style="border-color: var(--color-primary) !important;">
                    <p class="small mb-0 text-dark">
                        <i class='bx bx-info-circle me-1' style="color: var(--color-primary);"></i> 
                        <strong>Note:</strong> We operate as a licensed travel agency and are not affiliated with any government or embassy.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section-vision bg-light py-5">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="vision-card h-100 bg-white p-4 rounded-4 shadow-sm">
                    <div class="icon-box mb-3">
                        <i class='bx bx-target-lock'></i>
                    </div>
                    <h4 class="fw-bold">Our Mission</h4>
                    <p class="text-muted mb-0">To provide reliable, affordable, and personalized travel experiences that exceed customer expectations and create lifelong memories.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="vision-card h-100 bg-white p-4 rounded-4 shadow-sm">
                    <div class="icon-box mb-3">
                        <i class='bx bx-show'></i>
                    </div>
                    <h4 class="fw-bold">Our Vision</h4>
                    <p class="text-muted mb-0">To become a leading travel agency in the region, recognized for our innovation, integrity, and exceptional service quality.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="section-values py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Our Core Values</h3>
            <div class="about-divider mx-auto"></div>
        </div>
        <div class="row g-4 justify-content-center text-center">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="value-item">
                    <i class='bx bx-heart-circle text-muted fs-1 mb-2'></i>
                    <h6 class="fw-bold value-title">Customer Satisfaction</h6>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="value-item">
                    <i class='bx bx-shield-quarter text-muted fs-1 mb-2'></i>
                    <h6 class="fw-bold value-title">Integrity</h6>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="value-item">
                    <i class='bx bx-star text-muted fs-1 mb-2'></i>
                    <h6 class="fw-bold value-title">Excellence</h6>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="value-item">
                    <i class='bx bx-bulb text-muted fs-1 mb-2'></i>
                    <h6 class="fw-bold value-title">Innovation</h6>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="value-item">
                    <i class='bx bx-group text-muted fs-1 mb-2'></i>
                    <h6 class="fw-bold value-title">Teamwork</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="section-services bg-light py-5">
    <div class="container py-4">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h3 class="fw-bold">Our Services</h3>
                <p class="text-muted">A complete range of travel and tourism services designed for you.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Service 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="service-box p-4 bg-white rounded-3 h-100">
                    <i class='bx bxs-plane service-icon'></i>
                    <h5 class="fw-bold mt-3">Flight Bookings</h5>
                    <p class="text-muted small mb-0">Domestic and international ticketing with top airlines.</p>
                </div>
            </div>
            <!-- Service 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="service-box p-4 bg-white rounded-3 h-100">
                    <i class='bx bx-building-house service-icon'></i>
                    <h5 class="fw-bold mt-3">Hotel Reservations</h5>
                    <p class="text-muted small mb-0">Comfortable stays at the best rates worldwide.</p>
                </div>
            </div>
            <!-- Service 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="service-box p-4 bg-white rounded-3 h-100">
                    <i class='bx bx-map-alt service-icon'></i>
                    <h5 class="fw-bold mt-3">Tour Packages</h5>
                    <p class="text-muted small mb-0">Tailor-made holiday packages for families and groups.</p>
                </div>
            </div>
            <!-- Service 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="service-box p-4 bg-white rounded-3 h-100">
                    <i class='bx bx-moon service-icon'></i>
                    <h5 class="fw-bold mt-3">Umrah & Hajj</h5>
                    <p class="text-muted small mb-0">Organized and spiritually fulfilling pilgrimage services.</p>
                </div>
            </div>
            <!-- Service 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="service-box p-4 bg-white rounded-3 h-100">
                    <i class='bx bx-car service-icon'></i>
                    <h5 class="fw-bold mt-3">Transportation</h5>
                    <p class="text-muted small mb-0">Airport transfers, car rentals, and local transport.</p>
                </div>
            </div>
            <!-- Service 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="service-box p-4 bg-white rounded-3 h-100">
                    <i class='bx bx-briefcase-alt service-icon'></i>
                    <h5 class="fw-bold mt-3">Corporate Travel</h5>
                    <p class="text-muted small mb-0">Efficient and cost-effective business travel planning.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Team Intro -->
<section class="section-team py-5">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Our Dedicated Team</h3>
                <p class="text-muted">
                    Our greatest strength lies in our people. With over <strong>18 years of combined experience</strong>, 
                    our team of travel professionals and language experts is passionate about crafting personalized 
                    experiences. We don't just plan trips - we create experiences that inspire.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us & CTA -->
<section class="section-cta py-5" style="background-color: #fcfcfc;">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3 class="fw-bold mb-4">Why Choose Andaleeb?</h3>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center">
                        <i class='bx bxs-check-circle me-2 fs-4' style="color: var(--color-primary);"></i>
                        <span style="font-weight: 500" class="text-secondary">Trusted by hundreds of satisfied travelers since 2021</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class='bx bxs-check-circle me-2 fs-4' style="color: var(--color-primary);"></i>
                        <span style="font-weight: 500" class="text-secondary">Competitive rates and exclusive travel deals</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class='bx bxs-check-circle me-2 fs-4' style="color: var(--color-primary);"></i>
                        <span style="font-weight: 500" class="text-secondary">24/7 customer support for peace of mind</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class='bx bxs-check-circle me-2 fs-4' style="color: var(--color-primary);"></i>
                        <span style="font-weight: 500" class="text-secondary">Expert guidance from experienced consultants</span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 text-center">
                <div class="p-5 rounded-4 text-white position-relative overflow-hidden" style="background-color: var(--color-primary);">
                    <div class="position-relative z-1">
                        <h3 class="fw-bold">Let’s Plan Your Next Journey</h3>
                        <p class="mb-4 fw-bold">Every trip is a story worth telling.</p>
                        <a href="#" class="btn btn-light rounded-pill px-4 fw-bold text-dark">Contact Us Today</a>
                    </div>
                    <!-- Decorative Circle -->
                    <div class="position-absolute top-0 end-0 p-5 rounded-circle bg-white opacity-10" style="margin: -50px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
