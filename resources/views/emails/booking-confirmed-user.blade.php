<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Confirmed - {{ $order->order_number }}</title>
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
            border: 2px solid #28a745;
            background-color: #f0fff4;
            color: #28a745;
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

        .btn-view {
            display: inline-block;
            background-color: #e91e63;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 4px;
            margin-top: 20px;
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
                            alt="Andaleeb Travel Agency" width="200"
                            style="display: block; border: 0; max-width: 200px;" />
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
                        <h1>Booking Confirmed: {{ $order->order_number }}</h1>
                        <p style="font-size: 15px; color: #666666; line-height: 1.6; margin-bottom: 20px;">
                            Great news! Your booking has been successfully confirmed with our provider. Your tickets are
                            ready and waiting for you!
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Booking Cards -->
            @php
                $prioOrderResponse = is_string($order->prio_order_response)
                    ? json_decode($order->prio_order_response, true)
                    : $order->prio_order_response;
                $prioOrderResponse = is_array($prioOrderResponse) ? $prioOrderResponse : [];
            @endphp

            @foreach ($prioOrderResponse as $prioOrder)
                @php
                    $orderData = $prioOrder['data']['order'] ?? [];
                    $bookings = $orderData['order_bookings'] ?? [];
                @endphp

                @foreach ($bookings as $booking)
                    <div class="booking-card"
                        style="background-color: #ffffff; border: 1px solid #eeeeee; border-radius: 8px; margin-bottom: 25px; overflow: hidden;">
                        <!-- Card Header -->
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="background-color: #fafafa; border-bottom: 1px solid #eeeeee; padding: 12px 20px;">
                            <tr>
                                <td align="left"><span class="label"
                                        style="font-size: 12px; font-weight: 700; color: #000; text-transform: uppercase;">
                                        Booking Ref: {{ $booking['booking_reference'] ?? 'N/A' }}</span></td>
                                <td align="right">
                                    <span class="status-badge">
                                        {{ str_replace('_', ' ', $booking['booking_status'] ?? 'CONFIRMED') }}
                                    </span>
                                </td>

                                </td>
                            </tr>
                        </table>

                        <!-- Card Body -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
                            <tr>
                                <td align="left" valign="top">
                                    <!-- Tour Title & Date -->
                                    <div style="font-size: 16px; font-weight: 700; color: #111111; margin-bottom: 6px;">
                                        {{ $booking['product_title'] ?? 'Tour' }}</div>
                                    <div style="font-size: 13px; color: #666666; margin-bottom: 20px;">
                                        {{ isset($booking['booking_travel_date']) ? \Carbon\Carbon::parse($booking['booking_travel_date'])->format('d M Y') : 'N/A' }}
                                        @php
                                            $from = $booking['product_availability_from_date_time'] ?? null;
                                            $to = $booking['product_availability_to_date_time'] ?? null;
                                        @endphp

                                        @if ($from && $to)
                                            ({{ \Carbon\Carbon::parse($from)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($to)->format('h:i A') }})
                                        @endif
                                    </div>

                                    <!-- Pax Details -->
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="font-size: 13px; color: #555555; margin-bottom: 15px;">
                                        @foreach ($booking['product_type_details'] ?? [] as $typeDetail)
                                            <tr>
                                                <td style="padding-bottom: 8px;">
                                                    {{ $typeDetail['product_type_label'] ?? 'Guest' }}
                                                    ({{ $typeDetail['product_type_count'] ?? 1 }} &times;
                                                    {{ formatPrice($typeDetail['product_type_pricing']['price_subtotal'] ?? 0) }})
                                                </td>
                                                <td align="right" style="padding-bottom: 8px; color: #111111;">
                                                    {{ formatPrice($typeDetail['product_type_pricing']['price_total'] ?? 0) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                    <!-- Booking Total -->
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="border-top: 2px solid #f4f4f4; padding-top: 12px;">
                                        <tr>
                                            <td style="font-size: 14px; font-weight: 700; color: #111111;">
                                                Booking Total</td>
                                            <td align="right"
                                                style="font-size: 18px; font-weight: 800; color: #e91e63;">
                                                {{ formatPrice($booking['booking_pricing']['price_total'] ?? 0) }}
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- View Booking Button -->
                                    @if (!empty($booking['booking_customer_url']))
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                                            <tr>
                                                <td align="center">
                                                    <a href="{{ $booking['booking_customer_url'] }}" class="btn-view"
                                                        target="_blank">
                                                        View Your Tickets
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @endforeach

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
