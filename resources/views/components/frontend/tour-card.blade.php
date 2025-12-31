@switch($style)
    @case('style1')
        <div class="activity-card">
            <div class="act-img-box">
                <a href="{{ route('frontend.tour.details', $tour->slug) }}">
                    <img class="imgFluid lazyload" data-src="{{ $tour->image }}" alt="{{ $tour->name }}">
                </a>
                @if ($tour->is_recommended)
                    <div class="card-badge"> <i class="bx bxs-hot"></i>Recommended</div>
                @endif
            </div>
            <div class="act-details">
                <a href="{{ route('frontend.tour.details', $tour->slug) }}" class="act-title line-clamp-2">{{ $tour->name }}</a>
                <div class="act-rating">
                    <i class='bx bxs-star star-icon'></i>
                        <span class="rating-num">{{ round($tour->approvedReviews->avg('rating'), 1) == 0 ? '' : round($tour->approvedReviews->avg('rating'), 1) }}</span>
                        <span class="review-count">({{ $tour->approvedReviews->count() }} Reviews)</span>
                </div>
                <div class="act-price">
                    @if ($tour->discount_price != $tour->price)
                        <span class="delete-price">{{ formatPrice($tour->discount_price) }}</span>
                    @endif
                    {{ formatPrice($tour->price) }}
                </div>
            </div>
        </div>
    @break

@endswitch
