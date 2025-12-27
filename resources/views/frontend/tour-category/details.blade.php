@extends('frontend.layouts.main')
@section('content')
    @if (isset($banner) && $banner)
        <section class="page-header py-5 d-flex align-items-center"
            style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset($banner->image) }}'); background-size: cover; background-position: center; height:288px;">
            <div class="container text-center text-white">
                <h1 class="fw-bold display-4">{{ $category->name ?? 'Top Rated Tours' }}</h1>
            </div>
        </section>
    @else
        <section class="page-header py-5 d-flex align-items-center"
            style="background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('{{ asset('frontend/assets/images/banners/4.jpg') }}'); background-size: cover; background-position: center; height:288px;">
            <div class="container text-center text-white">
                <h1 class="fw-bold display-4">Garden & Parks</h1>
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
                        <input type="text" name="search" class="holidays-search-form__input"
                            placeholder="Search Activities" value="{{ request('search') }}">
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
            @if ($tours->count() > 0)
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
                                    No Tours available in this category at the moment
                                </h2>
                            @endif

                            <p class="text-muted mb-4">
                                Please check back later or explore other categories.
                            </p>

                            <!-- Actions -->
                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                <a href="{{ route('frontend.uae-services') }}" type="button"
                                    class="themeBtn themeBtn--primary">
                                    Browse All Categories
                                </a>
                                @if (request('search'))
                                    <a href="{{ route('frontend.tour-category.details', $category->slug) }}" type="button"
                                        class="themeBtn">
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
@endsection
