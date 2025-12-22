@extends('frontend.layouts.main')
@section('content')
    @if(isset($banner) && $banner)
    <section class="page-header py-5 d-flex align-items-center"
        style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset($banner->image) }}'); background-size: cover; background-position: center; height:288px;">
        <div class="container text-center text-white">
            <h1 class="fw-bold display-4">{{ $banner->heading ?? 'Garden & Parks' }}</h1>
            @if($banner->paragraph)
                <p class="lead fw-bold mb-0">{{ $banner->paragraph }}</p>
            @else
                <p class="lead fw-bold mb-0">Top Rated Tours</p>
            @endif
        </div>
    </section>
    @else
    <section class="page-header py-5 d-flex align-items-center"
        style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset('frontend/assets/images/banners/4.jpg') }}'); background-size: cover; background-position: center; height:288px;">
        <div class="container text-center text-white">
            <h1 class="fw-bold display-4">Garden & Parks</h1>
            <p class="lead fw-bold mb-0">Top Rated Tours</p>
        </div>
    </section>
    @endif

    <section class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="section-content text-center mb-4">
                        <h1 class="heading ">Where is your next holiday?
                        </h1>
                    </div>
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



    <section class="activities mar-y">
        <div class="container">

            <div class="row">
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Atlantis-Aquaventure-Waterpark-3625/1760013634626_3_2.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Ski-Dubai-Tickets-172/1760080772245_3_2.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/false-87/dhow-cruise-front.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Atlantis-Aquaventure-Waterpark-3625/1760013634626_3_2.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Ski-Dubai-Tickets-172/1760080772245_3_2.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Dubai-Aquarium-and-Underwater-Zoo-3636/1759917679577_3_2.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/Final/Burj-Khalifa-At-The-Top-Tickets-18/1759833985818_3_2.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
                <div class="col-md-3">
                    <div class="activity-card">
                        <div class="act-img-box">
                            <a href="#">
                                <img class="imgFluid lazyload"
                                    data-src="https://res.cloudinary.com/dzsl8v8yw/image/fetch/e_vibrance:100/c_limit,w_1920/f_auto/q_auto/v20428/https://d31sl6cu4pqx6g.cloudfront.net/Tour-Images/false-87/dhow-cruise-front.jpg?_a=BAVAZGE70"
                                    alt="Burj Khalifa">
                            </a>
                            
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
@endsection
