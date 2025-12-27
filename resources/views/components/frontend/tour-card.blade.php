@php
    $img = $tour->content['product_images'][0]['image_url'] ?? asset('frontend/assets/images/placeholder.png');
@endphp
@switch($style)
    @case('style1')
        <div class="activity-card">
            <div class="act-img-box">
                <a href="#">
                    <img class="imgFluid lazyload" data-src="{{ $img }}" alt="{{ $img }}">
                </a>
                @if ($tour->is_recommended)
                    <div class="card-badge"> <i class="bx bxs-hot"></i>Recommended</div>
                @endif
            </div>
            <div class="act-details">
                <div class="act-title line-clamp-2">{{ $tour->name }}</div>
                <div class="act-rating">
                    <i class='bx bxs-star star-icon'></i>
                    <span class="rating-num">4.9</span>
                    <span class="review-count">(2 Reviews)</span>
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
