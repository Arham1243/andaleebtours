@extends('user.layouts.main')
@section('content')
    <div class="col-md-12">
        <div class="dashboard-content">
            {{ Breadcrumbs::render('user.orders.show', $order) }}
            <div class="custom-sec custom-sec--form">
                <div class="custom-sec__header">
                    <div class="section-content">
                        <h3 class="heading">{{ isset($title) ? $title : '' }}</h3>
                    </div>
                    @if ($order->payment_status === 'failed' || $order->payment_status === 'pending')
                        <a href="{{ route('user.orders.pay-again', $order->id) }}" class="themeBtn">
                            Pay Now
                        </a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-wrapper">

                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Order Summary</div>
                            </div>
                            <div class="form-box__body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <!-- Order Info -->
                                            <tr>
                                                <td><strong>Order Number:</strong></td>
                                                <td class="text-end">{{ $order->order_number }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Date:</strong></td>
                                                <td class="text-end">{{ formatDate($order->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Method:</strong></td>
                                                <td class="text-end">{{ strtoupper($order->payment_method) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Status:</strong></td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : ($order->payment_status == 'refunded' ? 'info' : 'danger')) }}">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Status:</strong></td>
                                                <td class="text-end">
                                                    <span
                                                        class="badge rounded-pill bg-{{ $order->status == 'confirmed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'refunded' ? 'info' : 'danger')) }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Order Totals -->
                                            <tr>
                                                <td><strong>Subtotal (Items Total):</strong></td>
                                                <td class="text-end">{!! formatPrice($order->subtotal) !!}</td>
                                            </tr>

                                            @if ($order->discount > 0)
                                                <tr>
                                                    <td><strong>Discount:</strong></td>
                                                    <td class="text-end text-danger">- {!! formatPrice($order->discount) !!}</td>
                                                </tr>
                                            @endif

                                            @php
                                                $vatPercent =
                                                    $order->subtotal > 0 ? ($order->vat / $order->subtotal) * 100 : 0;
                                                $serviceTaxPercent =
                                                    $order->subtotal > 0
                                                        ? ($order->service_tax / $order->subtotal) * 100
                                                        : 0;
                                            @endphp

                                            <tr>
                                                <td><strong>VAT ({{ round($vatPercent, 2) }}%):</strong></td>
                                                <td class="text-end">{!! formatPrice($order->vat) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Service Tax ({{ round($serviceTaxPercent, 2) }}%):</strong>
                                                </td>
                                                <td class="text-end">{!! formatPrice($order->service_tax) !!}</td>
                                            </tr>

                                            @if ($order->tabby_fee > 0)
                                                <tr>
                                                    <td><strong>Tabby Fee:</strong></td>
                                                    <td class="text-end">{!! formatPrice($order->tabby_fee) !!}</td>
                                                </tr>
                                            @endif

                                            <tr class="table-success">
                                                <td><strong>Grand Total:</strong></td>
                                                <td class="text-end"><strong
                                                        style="font-size: 1.2em;">{!! formatPrice($order->total) !!}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        @if (!empty($order->applied_coupons))
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Applied Coupons</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Coupon Code</th>
                                                    <th>Type</th>
                                                    <th>Rate</th>
                                                    <th>Discount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->applied_coupons as $coupon)
                                                    <tr>
                                                        <td>{{ $coupon['code'] ?? 'N/A' }}</td>
                                                        <td>{{ ucfirst($coupon['type'] ?? 'N/A') }}</td>
                                                        <td>{!! $coupon['type'] == 'percentage' ? $coupon['rate'] . '%' : formatPrice($coupon['rate'] ?? 0) !!}</td>
                                                        <td>{!! formatPrice($coupon['discount'] ?? 0) !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @foreach ($order->orderItems as $index => $item)
                            <div class="form-box">
                                <div class="form-box__header">
                                    <div class="title">Order Item #{{ $index + 1 }}: {{ $item->tour_name }}</div>
                                </div>
                                <div class="form-box__body">
                                    <div class="row mb-3">
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Booking Date:</label>
                                                <input type="text" class="field"
                                                    value="{{ formatDate($item->booking_date) }}" readonly>
                                            </div>
                                        </div>
                                        @if ($item->time_slot)
                                            <div class="col-md-4 col-12 mb-3">
                                                <div class="form-fields">
                                                    <label class="title">Time Slot:</label>
                                                    <input type="text" class="field" value="{{ $item->time_slot }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-4 col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Total Pax:</label>
                                                <input type="text" class="field" value="{{ $item->quantity }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    @if (!empty($item->pax_details))
                                        <div class="mt-3">
                                            <h6 class="mb-3"><strong>Passenger Details & Pricing:</strong></h6>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Pax Type</th>
                                                            <th>Quantity</th>
                                                            <th>Price per Person</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($item->pax_details as $paxType => $paxData)
                                                            @if (isset($paxData['qty']) && $paxData['qty'] > 0)
                                                                <tr>
                                                                    <td>{{ $paxData['label'] ?? ucfirst($paxType) }}
                                                                    </td>
                                                                    <td>{{ $paxData['qty'] }}</td>
                                                                    <td>{!! formatPrice($paxData['price'] ?? 0) !!}</td>
                                                                    <td>{!! formatPrice($paxData['subtotal'] ?? 0) !!}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        <tr class="table-active">
                                                            <td colspan="3" class="text-end"><strong>Item
                                                                    Total:</strong></td>
                                                            <td><strong>{!! formatPrice($item->subtotal) !!}</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-fields">
                                                    <label class="title">Item Total:</label>
                                                    <input type="text" class="field" value="{!! formatPrice($item->subtotal) !!}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="form-box">
                            <div class="form-box__header">
                                <div class="title">Billing Details</div>
                            </div>
                            <div class="form-box__body">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Name:</label>
                                            <input type="text" class="field"
                                                value="{{ $order->passenger_title }} {{ $order->passenger_first_name }} {{ $order->passenger_last_name }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Email:</label>
                                            <input type="text" class="field" value="{{ $order->passenger_email }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Phone:</label>
                                            <input type="text" class="field" value="{{ $order->passenger_phone }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Country:</label>
                                            <input type="text" class="field"
                                                value="{{ $country ? $country->name : 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-fields">
                                            <label class="title">Address:</label>
                                            <textarea class="field" rows="2" readonly>{{ $order->passenger_address }}</textarea>
                                        </div>
                                    </div>
                                    @if ($order->passenger_special_request)
                                        <div class="col-12 mb-3">
                                            <div class="form-fields">
                                                <label class="title">Special Request:</label>
                                                <textarea class="field" rows="3" readonly>{{ $order->passenger_special_request }}</textarea>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($order->status === 'confirmed' && $order->payment_status === 'paid')
                            <div class="form-box mt-3">
                                <div class="form-box__header">
                                    <div class="title">Cancel Booking</div>
                                </div>
                                <div class="form-box__body">
                                    <p style="margin-bottom: 15px; color: #666;">
                                        <strong>Note:</strong> The amount will be refunded in 10-15 working days if the
                                        booking is refundable.
                                        In case of Non-Refundable Booking or Booking within Cancellation Deadline, there
                                        will be no refund.
                                    </p>
                                    <a href="{{ route('user.orders.cancel', $order->id) }}"
                                        onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.');"
                                        class="themeBtn">Cancel Booking</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
