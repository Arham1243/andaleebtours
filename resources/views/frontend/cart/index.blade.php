@extends('frontend.layouts.main')
@section('content')
    @if ($tours->count() > 0 && !empty($cartData['tours']))
        <section class="section-gap">
            <div class="container">
                <h1 class="page-title">Shopping Cart</h1>
                <div class="row">
                    <!-- Left Side: Cart Items -->
                    <div class="col-lg-8">
                        <div class="modern-card">
                            <div class="card-title">
                                <i class='bx bx-shopping-bag'></i> Selected Activities
                            </div>

                            @foreach ($tours as $tour)
                                @php
                                    $item = $cartData['tours'][$tour->id];
                                @endphp

                                @foreach ($item['pax'] as $paxType => $pax)
                                    <div class="cart-item" data-tour-slug="{{ $tour->slug }}"
                                        data-pax-type="{{ $paxType }}">
                                        <a href="{{ route('frontend.tour.details', $tour->slug) }}" class="cart-thumb">
                                            <img src="{{ $tour->image }}" alt="{{ $tour->name }}" class="imgFluid">
                                        </a>

                                        <div class="cart-details">
                                            <h5 class="cart-title">
                                                {{ $tour->name }}
                                            </h5>

                                            <div class="cart-meta">
                                                <i class='bx bx-calendar'></i>
                                                Start Date: {{ formatDate($item['date']) }}
                                            </div>

                                            <div class="cart-meta">
                                                <i class='bx bx-time-five'></i>
                                                Time: {{ $item['time_slot'] }}
                                            </div>
                                            <div class="cart-meta">
                                                <i class='bx bx-group'></i>
                                                Guests: <span class="guest-qty">{{ $pax['qty'] }}</span>
                                                {{ Str::plural($pax['label'], $pax['qty']) }}
                                            </div>
                                        </div>

                                        <div class="qty-control">
                                            <button class="qty-btn qty-decrease" type="button">
                                                <i class="bx bx-minus"></i>
                                            </button>

                                            <input type="number" class="counter-input qty-input"
                                                value="{{ $pax['qty'] }}"min="{{ $tour->min_qty }}"
                                                max="{{ $tour->max_qty }}" readonly>

                                            <button class="qty-btn qty-increase" type="button">
                                                <i class="bx bx-plus"></i>
                                            </button>
                                        </div>

                                        <div class="cart-price-area">
                                            <div class="item-calculation">
                                                <span class="calc-qty">{{ $pax['qty'] }}</span> <i class='bx bx-x'></i>
                                                {{ formatPrice($pax['price']) }}
                                            </div>

                                            <span class="item-total">
                                                {{ formatPrice($pax['subtotal']) }}
                                            </span>
                                        </div>

                                        <form method="POST" action="{{ route('frontend.cart.remove', $tour->slug) }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="pax_type" value="{{ $paxType }}">
                                            <button type="submit" class="btn-remove"
                                                onclick="return confirm('Are you sure you want to remove?')">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            @endforeach

                            <a href="{{ route('frontend.uae-services') }}" class="btn-outline">
                                <i class='bx bx-left-arrow-alt'></i> Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Right Side: Order Summary -->
                    <div class="col-lg-4">
                        <div class="sticky-sidebar">
                            <div class="modern-card">
                                <div class="card-title">
                                    <i class='bx bx-receipt'></i> Order Summary
                                </div>

                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="cart-subtotal">{{ formatPrice($cartData['total']['subtotal']) }}</span>
                                </div>

                                <!-- Coupon Input -->
                                <form action="{{ route('frontend.cart.apply-coupon') }}" method="POST"
                                    class="coupon-wrapper">
                                    @csrf
                                    <input type="text" name="coupon_code" class="coupon-input"
                                        placeholder="Enter discount code" required>
                                    <button class="btn-apply-overlay">Apply</button>
                                </form>

                                <!-- Applied Coupons -->
                                @if (!empty($cartData['applied_coupons']))
                                    @foreach ($cartData['applied_coupons'] as $coupon)
                                        <div class="summary-row coupon-applied">
                                            <span>Coupon: {{ $coupon['code'] }}
                                                ({{ $coupon['type'] === 'percentage' ? $coupon['rate'] . '%' : formatPrice($coupon['rate']) }})</span>
                                            <span style="color: red;">-{{ formatPrice($coupon['discount']) }}</span>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="summary-row">
                                    <span>Tax ({{ $cartData['total']['tax'] }}%)</span>
                                    <span>{{ formatPrice($cartData['total']['tax']) }}</span>
                                </div>

                                <div class="summary-row total">
                                    <span>Total Payable</span>
                                    <span id="cart-total"
                                        style="color: var(--color-primary)">{{ formatPrice($cartData['total']['grand_total']) }}</span>
                                </div>

                                <a href="{{ route('frontend.checkout.index') }}" class="btn-primary-custom mt-3">Proceed to
                                    Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="section-gap pt-0">
            <div class="container">
                <div class="empty-cart-state text-center">
                    <div class="empty-cart-img">
                        <img src="{{ asset('frontend/assets/images/empty-cart.webp') }}" alt="Empty Cart"
                            class="img-fluid">
                    </div>

                    <h2 class="empty-title">Your cart is empty</h2>
                    <h4 class="empty-subtitle">You don't have any booking</h4>

                    <p class="empty-description">
                        Discover exciting deals, earn rewards, and enjoy exclusive offers. Start
                        shopping now and make the most of your experience!
                    </p>

                    <a href="{{ route('frontend.uae-services') }}" style="width:fit-content;" class="btn-primary-custom">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartItems = document.querySelectorAll('.cart-item');

            function formatPrice(amount) {
                const formatted = parseFloat(amount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                return '<span class="dirham">D</span>' + formatted;
            }

            cartItems.forEach(item => {
                const tourSlug = item.dataset.tourSlug;
                const paxType = item.dataset.paxType;
                const qtyInput = item.querySelector('.qty-input');
                const decreaseBtn = item.querySelector('.qty-decrease');
                const increaseBtn = item.querySelector('.qty-increase');
                const itemTotal = item.querySelector('.item-total');
                const calcQty = item.querySelector('.calc-qty');
                const guestQty = item.querySelector('.guest-qty');
                const minQty = parseInt(qtyInput.getAttribute('min')) || 1;
                const maxQty = parseInt(qtyInput.getAttribute('max')) || Infinity;

                function updateButtonStates() {
                    const currentQty = parseInt(qtyInput.value);

                    if (currentQty <= minQty) {
                        decreaseBtn.disabled = true;
                        decreaseBtn.style.cursor = 'not-allowed';
                        decreaseBtn.style.opacity = '0.5';
                    } else {
                        decreaseBtn.disabled = false;
                        decreaseBtn.style.cursor = 'pointer';
                        decreaseBtn.style.opacity = '1';
                    }

                    if (currentQty >= maxQty) {
                        increaseBtn.disabled = true;
                        increaseBtn.style.cursor = 'not-allowed';
                        increaseBtn.style.opacity = '0.5';
                    } else {
                        increaseBtn.disabled = false;
                        increaseBtn.style.cursor = 'pointer';
                        increaseBtn.style.opacity = '1';
                    }
                }

                function updateCart(newQty) {
                    if (newQty < minQty || newQty > maxQty) return;

                    fetch(`{{ url('/cart/update') }}/${tourSlug}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                pax_type: paxType,
                                qty: newQty
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                calcQty.textContent = data.data.qty;
                                guestQty.textContent = data.data.qty;
                                itemTotal.innerHTML = formatPrice(data.data.item_subtotal);
                                document.getElementById('cart-subtotal').innerHTML = formatPrice(data
                                    .data.cart_subtotal);
                                document.getElementById('cart-total').innerHTML = formatPrice(data
                                    .data.cart_grand_total);
                                updateButtonStates();
                            } else {
                                showMessage(data.message || 'Failed to update quantity');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('An error occurred while updating the cart');
                        });
                }

                decreaseBtn.addEventListener('click', function() {
                    if (this.disabled) return;
                    qtyInput.stepDown();
                    const newQty = parseInt(qtyInput.value);
                    if (newQty >= minQty) {
                        updateCart(newQty);
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    if (this.disabled) return;
                    qtyInput.stepUp();
                    const newQty = parseInt(qtyInput.value);
                    if (newQty <= maxQty) {
                        updateCart(newQty);
                    }
                });

                updateButtonStates();
            });
        });
    </script>
@endpush
