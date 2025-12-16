@extends('frontend.layouts.main')
@section('content')
    <section class="page-header py-5 d-flex align-items-center"
        style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('frontend/assets/images/about-banner.jpeg') }}');">
        <div class="container text-center text-white">
            <h1 class="fw-bold display-4">ENCHANTING MALDIVES</h1>
        </div>
    </section>


    <section class="section-about text-center py-5 bg-light">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10">
                    <span class="text-uppercase fw-bold letter-spacing-2" style="color: var(--color-primary);">Andaleeb
                        Travel Agency</span>
                    <h2 class="fw-bold mb-4 mt-2">ENCHANTING MALDIVES</h2>
                    <p>
                        The Maldives is a tropical paradise in the Indian Ocean, comprising 26 atolls and over 1,000 coral
                        islands. Known for its stunning white-sand beaches, crystal-clear turquoise waters, and vibrant
                        coral reefs, it is a top destination for luxury resorts and underwater adventures like snorkeling
                        and diving. The capital city is Malé, a bustling hub with modern and traditional influences. The
                        Maldives has a rich marine biodiversity, making it a haven for marine life enthusiasts. The climate
                        is warm year-round, with a monsoon season from May to November. Tourism is the primary industry,
                        contributing significantly to the economy. The Maldives also faces environmental challenges, such as
                        rising sea levels due to climate change. The culture blends South Asian, Arab, and African
                        influences, reflected in its language, cuisine, and customs.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="activities mar-y">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid"
                                    src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
                        </div>
                        <div class="act-details">
                            <div style="font-size: 1.25rem;" class="act-title line-clamp-1">Romentic Maldives</div>
                            <div class="act-rating">
                                <span style="height: 61px" class="review-count line-clamp-3">Discover romance at the
                                    Sheraton Maldives Full Moon Resort & Spa, where couples can indulge in luxury and
                                    seclusion. This exclusive package offers a beachfront villa stay with stunning ocean
                                    views, private dinners under the stars, and rejuvenating couples' spa treatments. Enjoy
                                    sunset cruises, intimate beach picnics, and personalized experiences designed to create
                                    unforgettable memories in a tropical paradise. Perfect for honeymooners or romantic
                                    getaways.</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 1,655.00</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid"
                                    src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
                        </div>
                        <div class="act-details">
                            <div style="font-size: 1.25rem;" class="act-title line-clamp-1">Romentic Maldives</div>
                            <div class="act-rating">
                                <span style="height: 61px" class="review-count line-clamp-3">Discover romance at the
                                    Sheraton Maldives Full Moon Resort & Spa, where couples can indulge in luxury and
                                    seclusion. This exclusive package offers a beachfront villa stay with stunning ocean
                                    views, private dinners under the stars, and rejuvenating couples' spa treatments. Enjoy
                                    sunset cruises, intimate beach picnics, and personalized experiences designed to create
                                    unforgettable memories in a tropical paradise. Perfect for honeymooners or romantic
                                    getaways.</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 1,655.00</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid"
                                    src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
                        </div>
                        <div class="act-details">
                            <div style="font-size: 1.25rem;" class="act-title line-clamp-1">Romentic Maldives</div>
                            <div class="act-rating">
                                <span style="height: 61px" class="review-count line-clamp-3">Discover romance at the
                                    Sheraton Maldives Full Moon Resort & Spa, where couples can indulge in luxury and
                                    seclusion. This exclusive package offers a beachfront villa stay with stunning ocean
                                    views, private dinners under the stars, and rejuvenating couples' spa treatments. Enjoy
                                    sunset cruises, intimate beach picnics, and personalized experiences designed to create
                                    unforgettable memories in a tropical paradise. Perfect for honeymooners or romantic
                                    getaways.</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 1,655.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
