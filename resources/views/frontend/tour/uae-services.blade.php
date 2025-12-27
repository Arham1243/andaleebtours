@extends('frontend.layouts.main')
@section('content')
    @if (isset($banner) && $banner)
        <section class="page-header py-5 d-flex align-items-center"
            style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset($banner->image) }}'); background-size: cover; background-position: center; height:288px;">
        @else
            <section class="page-header py-5 d-flex align-items-center"
                style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset('frontend/assets/images/banners/1.jpg') }}'); background-size: cover; background-position: center; height:288px;">
    @endif
    <div class="container">
        <div class="row justify-content-center mt-5 pt-5">
            <div class="col-md-6">
                <form action="{{ route('frontend.uae-services') }}#tours"
                    class="holidays-search-form holidays-search-form--normal" method="GET">
                    <input type="text" name="search" class="holidays-search-form__input" placeholder="Search Activities"
                        value="{{ request('search') }}">
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
            <div class="row g-3 g-xl-4 category-slider2">
                @foreach ($categories as $category)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="{{ route('frontend.tour-category.details', $category->slug) }}" class="cat-card">
                            <div class="cat-bg" style="background-image: url('{{ asset($category->image) }}');">
                            </div>
                            <div class="cat-overlay"></div>
                            <div class="cat-content">
                                <h5 class="cat-title">{{ $category->name }}</h5>
                                <div class="cat-action">
                                    <span class="cat-count">{{ $category->tours->count() }}
                                        {{ Str::plural('Activity', $category->tours->count()) }}</span>
                                    <span class="btn-icon"><i class='bx bx-right-arrow-alt'></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <div class="expandable-wrapper mar-y" data-collapsed-height="50" data-more-text="Read More" data-less-text="Read Less">
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

    <section class="activities mar-y" id="tours">
        <div class="container">
            @if ($tours->count() > 0)
                <div class="section-header">
                    <div class="section-content">
                        <h3 class="heading mb-0">Best Activities in Dubai</h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($tours as $tour)
                        <div class="col-md-3">
                            <x-frontend.tour-card :tour="$tour" style="style1" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-results" aria-labelledby="no-results-title">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <!-- Visual Cue -->
                            <div class="mb-3">
                                <i class='bx bx-search-alt empty-icon' aria-hidden="true"></i>
                            </div>

                            @if (request('search'))
                                <!-- Content -->
                                <h2 id="no-results-title" class="h4 fw-bold mb-2">
                                    No tours found matching "{{ request('search') }}"
                                </h2>
                            @else
                                <h2 id="no-results-title" class="h4 fw-bold mb-2">
                                    No Tours available at the moment
                                </h2>
                            @endif

                            <p class="text-muted mb-4">
                                Please check back later or explore other categories.
                            </p>

                            <!-- Actions -->
                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                @if (request('search'))
                                    <a href="{{ route('frontend.uae-services') }}#tours" type="button" class="themeBtn">
                                        Reset Search
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- <section class="categories mar-y">
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
                            <div class="desc line-clamp-1">from: <span class="fw-bold text-black"><span
                                        class="dirham">D</span> 393</span></div>
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
    </section> --}}


    @php
        $tabs = [];
        foreach ($packageCategories as $category) {
            $tabs[] = [
                'id' => 'category-' . $category->id,
                'label' => $category->name,
                'links' => $category->packages
                    ->map(function ($pkg) {
                        return [
                            'label' => $pkg->name,
                            'url' => route('frontend.packages.details', $pkg->slug),
                        ];
                    })
                    ->toArray(),
            ];
        }
    @endphp
    @if ($packageCategories->isNotEmpty())
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
@push('js')
    @if ($packageCategories->isNotEmpty())
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
