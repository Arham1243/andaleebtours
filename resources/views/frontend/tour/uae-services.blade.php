@extends('frontend.layouts.main')
@section('content')
    @if(isset($banner) && $banner)
    <section class="page-header py-5 d-flex align-items-center"
        style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset($banner->image) }}'); background-size: cover; background-position: center; height:288px;">
    @else
    <section class="page-header py-5 d-flex align-items-center"
        style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset('frontend/assets/images/banners/1.jpg') }}'); background-size: cover; background-position: center; height:288px;">
    @endif
        <div class="container">
            <div class="row justify-content-center mt-5 pt-5">
                <div class="col-md-6">
                    <form class="holidays-search-form holidays-search-form--normal" method="GET">
                        <input type="text" name="destination" class="holidays-search-form__input"
                            placeholder="Search Activities">
                        <div class="search-button">
                            <button type="submit" class="themeBtn themeBtn--primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <section class="section-categories bg-light padd-y">
        <div class="container">
            <!-- Header -->
            <div class="section-content mb-4 pb-4">
                <h3 class="heading mb-0">Explore by Category</h3>
                <p class="text-muted my-1">Discover the best experiences in the UAE</p>
            </div>

            <!-- Categories Grid -->
            <div class="row g-3 g-xl-4 category-slider2 justify-content-center">


                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20434/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Abu-Dhabi-City-Tour-49/1760092545059_3_2.jpg?_a=BAVAZGE70');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Garden & Parks</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Adventure (Jebel Jais/Mountains) -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://images.unsplash.com/photo-1604537466573-5e94508fd243?q=80&w=600&auto=format&fit=crop');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Jebel Jais Zip Line</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Waterparks (Atlantis/Palm) -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://images.unsplash.com/photo-1549880338-65ddcdfd017b?q=80&w=600&auto=format&fit=crop');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Atlantis Waterpark</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 4: Ski Dubai (Snow/Indoor Ski) -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=600&auto=format&fit=crop');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Ski Dubai</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 5: Desert Safari (Dunes) -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20434/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Desert-Safari-with-Quad-Biking-145/1725285432348_S.jpg?_a=BAVAZGE70');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Desert Safari</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 6: Ain Dubai (Ferris Wheel) -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20434/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Hot-Air-Balloon-Dubai-19390/1759919351565_S.jpg?_a=BAVAZGE70');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Ain Dubai</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 7: Dubai Aquarium -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://images.unsplash.com/photo-1545259741-2ea3ebf61fa3?q=80&w=600&auto=format&fit=crop');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">Dubai Aquarium</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card 8: New Year Eve (Fireworks) -->
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="#" class="cat-card">
                        <div class="cat-bg"
                            style="background-image: url('https://images.unsplash.com/photo-1550136513-548af4445338?q=80&w=600&auto=format&fit=crop');">
                        </div>
                        <div class="cat-overlay"></div>
                        <div class="cat-content">
                            <h5 class="cat-title">New Year Eve</h5>
                            <div class="cat-action">
                                <span class="cat-count">5 Activities</span>
                                <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>


    <div class="expandable-wrapper mar-y" data-collapsed-height="50" data-more-text="Read More"
        data-less-text="Read Less">
        <div class="container">
            <div class="expandable-card">
                <h3 class="expandable-title">Best Tours and Activities in Dubai</h3>

                <div class="expandable-content">
                    <div class="expandable-content-inner text-document">
                        <p>Dubai is a dream that transformed into a magnificent reality in no time. Not long ago, when it
                            was
                            nothing but a small Bedouin village, it was an impossible thought to portray Dubai as a place
                            where
                            the world comes to shop and have fun.</p>

                        <p>A city once known solely for its oil reserves is now a global tourism benchmark. City sightseeing
                            today is one of the most popular activities.</p>

                        <h4>Why visit?</h4>
                        <ul>
                            <li><a href="#">Burj Khalifa</a> views</li>
                            <li>Desert Safaris and BBQ dinners</li>
                            <li>Luxury Shopping experiences</li>
                        </ul>

                        <p>From the architecture to the cultural heritage, every corner tells a story waiting to be
                            explored.
                        </p>
                    </div>
                </div>

                <button class="expand-btn">Read More</button>
            </div>
        </div>
    </div>

    <section class="activities mar-y">
        <div class="container">
            <div class="section-header">
                <div class="section-content">
                    <h3 class="heading mb-0">Best Activities in Dubai</h3>
                </div>
                <div class="custom-slider-arrows">
                    <div class="slick-arrow-btn activity-prev-slide"><i class='bx bx-chevron-left'></i></div>
                    <div class="slick-arrow-btn activity-next-slide"><i class='bx bx-chevron-right'></i></div>
                </div>
            </div>

            <div class="row activity-slider">
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <img class="imgFluid lazyload"
                                data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/false-87/dhow-cruise-front.jpg?_a=BAVAZGE70"
                                alt="Burj Khalifa">
                            <div class="card-badge"> <i class="bx bxs-hot"></i>Recommended</div>
                            
                        </div>
                        <div class="act-details">
                            <div class="act-title line-clamp-1">Burj Khalifa At The Top Tickets</div>
                            <div class="act-rating">
                                <i class='bx bxs-star star-icon'></i>
                                <span class="rating-num">4.9</span>
                                <span class="review-count">(374 Reviews)</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 199</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <img class="imgFluid lazyload"
                                data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Atlantis-Aquaventure-Waterpark-3625/1760013634626_3_2.jpg?_a=BAVAZGE70"
                                alt="Burj Khalifa">
                            <div class="card-badge"> <i class="bx bxs-hot"></i>Recommended</div>
                            
                        </div>
                        <div class="act-details">
                            <div class="act-title line-clamp-1">Burj Khalifa At The Top Tickets</div>
                            <div class="act-rating">
                                <i class='bx bxs-star star-icon'></i>
                                <span class="rating-num">4.9</span>
                                <span class="review-count">(374 Reviews)</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 199</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <img class="imgFluid lazyload"
                                data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Ski-Dubai-Tickets-172/1760080772245_3_2.jpg?_a=BAVAZGE70"
                                alt="Burj Khalifa">
                            
                        </div>
                        <div class="act-details">
                            <div class="act-title line-clamp-1">Burj Khalifa At The Top Tickets</div>
                            <div class="act-rating">
                                <i class='bx bxs-star star-icon'></i>
                                <span class="rating-num">4.9</span>
                                <span class="review-count">(374 Reviews)</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 199</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <img class="imgFluid lazyload"
                                data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Dubai-Aquarium-and-Underwater-Zoo-3636/1759917679577_3_2.jpg?_a=BAVAZGE70"
                                alt="Burj Khalifa">
                            
                        </div>
                        <div class="act-details">
                            <div class="act-title line-clamp-1">Burj Khalifa At The Top Tickets</div>
                            <div class="act-rating">
                                <i class='bx bxs-star star-icon'></i>
                                <span class="rating-num">4.9</span>
                                <span class="review-count">(374 Reviews)</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 199</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <img class="imgFluid lazyload"
                                data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Burj-Khalifa-At-The-Top-Tickets-18/1759833985818_3_2.jpg?_a=BAVAZGE70"
                                alt="Burj Khalifa">
                            
                        </div>
                        <div class="act-details">
                            <div class="act-title line-clamp-1">Burj Khalifa At The Top Tickets</div>
                            <div class="act-rating">
                                <i class='bx bxs-star star-icon'></i>
                                <span class="rating-num">4.9</span>
                                <span class="review-count">(374 Reviews)</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 199</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <img class="imgFluid lazyload"
                                data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/false-87/dhow-cruise-front.jpg?_a=BAVAZGE70"
                                alt="Burj Khalifa">
                            
                        </div>
                        <div class="act-details">
                            <div class="act-title line-clamp-1">Burj Khalifa At The Top Tickets</div>
                            <div class="act-rating">
                                <i class='bx bxs-star star-icon'></i>
                                <span class="rating-num">4.9</span>
                                <span class="review-count">(374 Reviews)</span>
                            </div>
                            <div class="act-price"><span class="dirham">D</span> 199</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="categories mar-y">
        <div class="container">
            <div class="section-header mb-4 pb-2">
                <div class="section-content">
                    <h3 class="heading mb-0">Things to do in Dubai</h3>
                </div>
                <div class="custom-slider-arrows">
                    <div class="slick-arrow-btn category-prev-slide"><i class='bx bx-chevron-left'></i></div>
                    <div class="slick-arrow-btn category-next-slide"><i class='bx bx-chevron-right'></i></div>
                </div>
            </div>
            <div class="row category-slider g-0">
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Abu Dhabi City Tour With Ferrari
                                World</div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13236/abu-dhabi.jpg?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Burj Khalifa At The Top Tickets
                            </div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/14644/ras-al-khaimah-city.png?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Desert Safari with Quad Biking</div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/23726/singapore-city.png?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Desert Buggy Driving Experience
                            </div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13236/abu-dhabi.jpg?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Burj Khalifa At The Top Tickets
                            </div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Hot Air Balloon Dubai</div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="category-card">
                        <div class="category-card__img">
                            <img data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/City-Images/13668/dubai-city.png?_a=BAVAZGE70"
                                alt="Dubai" class="imgFluid lazyload">
                        </div>
                        <div class="category-card__content">
                            <div class="title line-clamp-2 mb-1" style="height:43px;">Breakfast in the sky with Balloon
                                flights</div>
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span class="dirham">D</span> 393</span></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-section mar-y">
        <div class="container">
            <div class="section-content mb-2">
                <h3 class="heading mb-0">Frequently Asked Question</h3>
            </div>

            <div class="faq-wrapper">
                <div class="faq-item active">
                    <div class="faq-header">
                        <span class="faq-question">1. What are the top attractions to visit in Dubai?</span>
                        <i class='bx bx-chevron-down faq-icon'></i>
                    </div>
                    <div class="faq-body">
                        <div class="faq-content text-document">
                            <p>Dubai is famous for the Burj Khalifa, Dubai Mall, and the Palm Jumeirah.</p>
                            <ul>
                                <li><a href="#">Burj Khalifa Tickets</a></li>
                                <li><a href="#">The Dubai Fountain</a></li>
                                <li><a href="#">Desert Safari</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-header">
                        <span class="faq-question">2. Which are the best theme parks to explore in Dubai?</span>
                        <i class='bx bx-chevron-down faq-icon'></i>
                    </div>
                    <div class="faq-body">
                        <div class="faq-content text-document">
                            <p>Dubai has world-class theme parks such as:</p>
                            <ul>
                                <li><a href="#">Ski Dubai Tickets</a></li>
                                <li><a href="#">IMG Worlds of Adventure</a></li>
                                <li><a href="#">Dubai Aquarium and Underwater Zoo</a></li>
                                <li><a href="#">Motiongate Dubai</a></li>
                                <li><a href="#">Legoland Dubai</a></li>
                                <li><a href="#">AYA Universe Dubai</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
@push('js')
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
@endpush
