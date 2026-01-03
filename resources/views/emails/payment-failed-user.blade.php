<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Failed - {{ $order->order_number }}</title>
    <style>
        @font-face {
            font-family: "UAEDirham";
            src: url("{{ asset('frontend/assets/fonts/UAE-dirham/aed-Regular.otf') }}");
        }

        body :is(.dirham.dirham) {
            font-family: "UAEDirham" !important;
            font-weight: 400 !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: inherit !important;
            color: inherit !important;
            opacity: 1 !important;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8f9fa;
            padding: 40px 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            padding: 25px;
        }

        h1 {
            font-size: 22px;
            font-weight: 600;
            color: #111111;
            letter-spacing: 0;
            margin: 0;
        }

        .label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #999999;
        }

        .data-text {
            font-size: 14px;
            color: #111111;
            font-weight: 500;
        }

        .section-padding {
            padding: 30px 0;
        }

        .border-bottom {
            border-bottom: 1px solid #eeeeee;
        }

        .status-badge {
            display: inline-block;
            border: 2px solid #dc3545;
            background-color: #fff5f5;
            color: #dc3545;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .booking-card {
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .reason-box {
            background-color: #fff5f5;
            border: 1px solid #dc3545;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .reason-title {
            font-size: 14px;
            font-weight: 700;
            color: #dc3545;
            margin-bottom: 8px;
        }

        .reason-text {
            font-size: 13px;
            color: #666666;
            line-height: 1.5;
        }

        .resolution-box {
            background-color: #f0f9ff;
            border: 1px solid #0284c7;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .resolution-title {
            font-size: 14px;
            font-weight: 700;
            color: #0284c7;
            margin-bottom: 8px;
        }

        .resolution-text {
            font-size: 13px;
            color: #666666;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .footer {
            padding-top: 40px;
            text-align: center;
            border-top: 1px solid #f4f4f4;
        }

        .footer-text {
            font-size: 12px;
            color: #111111;
            letter-spacing: 0.5px;
        }

        .footer-text a {
            font-weight: 600;
            color: #111111;
            text-decoration: none;
        }

        .grand-total-text {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #111111 !important;
        }

        /* Responsive Styles */
        @media only screen and (max-width: 600px) {
            .wrapper {
                padding: 20px 0 !important;
            }

            .container {
                padding: 15px !important;
                border: none !important;
            }

            h1 {
                font-size: 18px !important;
            }

            .section-padding {
                padding: 20px 0 !important;
            }

            .btn-view {
                display: block !important;
                width: fit-content !important;
                text-align: center !important;
                padding: 14px 20px !important;
                font-size: 14px !important;
            }

            .booking-card {
                border-radius: 4px !important;
                margin-bottom: 15px !important;
            }

            table[width="50%"] {
                width: 100% !important;
            }

            .data-text {
                font-size: 13px !important;
            }

            .footer {
                padding-top: 30px !important;
            }

            .footer-text {
                font-size: 11px !important;
            }

            .grand-total-text {
                font-size: 16px !important;
            }

            table[style*="margin-top: 30px"] td[width="50%"]:first-child {
                display: none !important;
            }

            table[style*="margin-top: 30px"] td[width="50%"]:last-child {
                width: 100% !important;
            }

            table[style*="background-color: #f9f9f9"] {
                padding: 8px 12px !important;
                font-size: 12px !important;
            }

            table[style*="background-color: #f9f9f9"] td {
                font-size: 12px !important;
                padding: 8px 0 !important;
                word-break: break-word !important;
            }

            table[style*="background-color: #fafafa"] {
                padding: 10px 12px !important;
            }

            table[style*="background-color: #fafafa"] .label {
                font-size: 10px !important;
                display: block !important;
                word-break: break-word !important;
            }

            table[style*="background-color: #fafafa"] .status-badge {
                font-size: 8px !important;
                padding: 2px 6px !important;
                display: inline-block !important;
                white-space: nowrap !important;
            }

            .reason-box,
            .resolution-box {
                padding: 12px !important;
                margin-bottom: 15px !important;
            }

            .reason-title,
            .resolution-title {
                font-size: 13px !important;
            }

            .reason-text,
            .resolution-text {
                font-size: 12px !important;
            }
        }

        @media only screen and (max-width: 480px) {
            h1 {
                font-size: 16px !important;
            }

            .container {
                padding: 10px !important;
            }

            .status-badge {
                font-size: 9px !important;
                padding: 3px 8px !important;
            }

            .label {
                font-size: 10px !important;
            }
        }
    </style>
</head>

<body>
    <center class="wrapper">
        <div class="container">

            <!-- Logo Header -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <img src="{{ asset('frontend/assets/images/email-template-logo.png') }}"
                            alt="Andaleeb Travel Agency" width="100%" style="display: block; border: 0;" />
                    </td>
                </tr>
            </table>

            <!-- Greeting & Main Status -->
            <table width="100%" cellpadding="0" cellspacing="0" class="border-bottom">
                <tr>
                    <td class="section-padding" align="left">
                        <p style="font-size: 15px; color: #666666; margin-bottom: 10px;">Dear
                            {{ $order->passenger_title }} {{ $order->passenger_first_name }}
                            {{ $order->passenger_last_name }},</p>
                        <h1>Payment Failed: {{ $order->order_number }}</h1>
                        <p style="font-size: 15px; color: #666666; line-height: 1.6; margin-bottom: 20px;">
                            Unfortunately, your payment could not be processed. Please review the details below and try
                            again or contact our support team at <a href="mailto:support@andaleebtravel.com"
                                style="color: #EB3176; text-decoration: underline;">support@andaleebtravel.com</a>.
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Booking Card -->
            <div class="booking-card"
                style="background-color: #ffffff; border: 1px solid #eeeeee; border-radius: 8px; margin-bottom: 25px; overflow: hidden;">
                <!-- Card Header -->
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #fafafa; border-bottom: 1px solid #eeeeee; padding: 12px 20px;">
                    <tr>
                        <td align="left"><span class="label"
                                style="font-size: 12px; font-weight: 700; color: #000; text-transform: uppercase;">Order
                                {{ $order->order_number }}</span></td>
                        <td align="right"><span class="status-badge">Payment: {{ $order->payment_status }}</span>
                        </td>
                    </tr>
                </table>

                <!-- Card Body -->
                <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
                    <tr>
                        <td align="left" valign="top">
                            @foreach ($order->orderItems as $index => $item)
                                @if ($index === 0)
                                    <!-- Tour Title & Date -->
                                    <div style="font-size: 16px; font-weight: 700; color: #111111; margin-bottom: 6px;">
                                        {{ $item->tour_name }}</div>
                                    <div style="font-size: 13px; color: #666666; margin-bottom: 20px;">
                                        {{ formatDate($item->booking_date) }} &bull; {{ $item->time_slot }}</div>

                                    <!-- Financial Breakdown Table -->
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="font-size: 13px; color: #555555;">
                                @endif
                                <!-- Pax Rows -->
                                @php
                                    $paxDetails = is_array($item->pax_details) ? $item->pax_details : [];
                                    $lastKey = array_key_last($paxDetails);
                                @endphp
                                @foreach ($paxDetails as $key => $pax)
                    <tr>
                        <td
                            style="padding-bottom: {{ $key === $lastKey ? '12px' : '8px' }}; {{ $key === $lastKey ? 'border-bottom: 1px solid #f4f4f4;' : '' }}">
                            {{ $pax['label'] ?? ucfirst($key) }} ({{ $pax['qty'] }} &times;
                            {{ formatPrice($pax['price']) }})</td>
                        <td align="right"
                            style="padding-bottom: {{ $key === $lastKey ? '12px' : '8px' }}; color: #111111; {{ $key === $lastKey ? 'border-bottom: 1px solid #f4f4f4;' : '' }}">
                            {{ formatPrice($pax['subtotal']) }}</td>
                    </tr>
                    @endforeach
                    @if ($index === 0)
                        <!-- Total Row -->
                        <tr>
                            <td
                                style="border-top: 1px solid #f4f4f4;padding-top: 10px; font-size: 14px; font-weight: 700; color: #111111;">
                                Total</td>
                            <td align="right"
                                style="padding-top: 10px; font-size: 20px; font-weight: 800; color: #e91e63;">
                                {{ formatPrice($order->subtotal) }}
                            </td>
                        </tr>
                </table>
                @endif
                @endforeach
                </td>
                </tr>
                </table>
            </div>

            <!-- Order Summary (Taxes & Totals) -->
            @php
                $vatPercentage = $order->subtotal > 0 ? ($order->vat / $order->subtotal) * 100 : 0;
                $serviceTaxPercentage = $order->subtotal > 0 ? ($order->service_tax / $order->subtotal) * 100 : 0;
            @endphp

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                <tr>
                    <td width="50%"></td>
                    <td width="50%"
                        style="background-color: #f9f9f9; border: 1px solid #eeeeee; padding: 10px 18px; border-radius: 4px;">
                        <table width="100%" cellpadding="0" cellspacing="0" class="total-row">
                            <tr>
                                <td align="left"
                                    style="padding: 10px 0; border-bottom: 1px solid #eeeeee; color: #666666;">Subtotal
                                </td>
                                <td align="right"
                                    style="padding: 10px 0; border-bottom: 1px solid #eeeeee; color: #111111; font-weight: 500;">
                                    {{ formatPrice($order->subtotal) }}
                                </td>
                            </tr>
                            <tr>
                                <td align="left"
                                    style="padding: 10px 0; border-bottom: 1px solid #eeeeee; color: #666666;">VAT
                                    ({{ number_format($vatPercentage, 2) }}%)
                                </td>
                                <td align="right"
                                    style="padding: 10px 0; border-bottom: 1px solid #eeeeee; color: #111111; font-weight: 500;">
                                    {{ formatPrice($order->vat) }}
                                </td>
                            </tr>
                            <tr>
                                <td align="left"
                                    style="padding: 10px 0; border-bottom: 1px solid #eeeeee; color: #666666;">Service
                                    Tax ({{ number_format($serviceTaxPercentage, 2) }}%)</td>
                                <td align="right"
                                    style="padding: 10px 0; border-bottom: 1px solid #eeeeee; color: #111111; font-weight: 500;">
                                    {{ formatPrice($order->service_tax) }}
                                </td>
                            </tr>
                            <tr>
                                <td align="left"
                                    style="padding-top: 15px; font-weight: bold; color: #111111; font-size: 15px;">
                                    Total Amount</td>
                                <td align="right" style="padding-top: 15px;" class="grand-total-text">
                                    {{ formatPrice($order->total) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Minimal Footer -->
            <div class="footer">
                <p class="footer-text">
                    &copy; {{ date('Y') }} Andaleeb Travel Agency <a
                        href="https://andaleebtours.com">www.andaleebtours.com</a>
                </p>
            </div>

        </div>
    </center>
</body>

</html>
