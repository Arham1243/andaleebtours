<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Cancelled - {{ $order->order_number }}</title>
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
                        <h1>Booking Cancelled: {{ $order->order_number }}</h1>
                        <p style="font-size: 15px; color: #666666; line-height: 1.6; margin-bottom: 20px;">
                            Your booking has been cancelled as requested. The cancellation was processed on
                            <strong>{{ $order->cancelled_at ? \Carbon\Carbon::parse($order->cancelled_at)->format('d M Y, h:i A') : 'N/A' }}</strong>.
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Cancelled Tours -->
            @foreach ($order->orderItems as $item)
                <div class="booking-card"
                    style="background-color: #ffffff; border: 1px solid #eeeeee; border-radius: 8px; margin-bottom: 25px; overflow: hidden;">
                    <!-- Card Header -->
                    <table width="100%" cellpadding="0" cellspacing="0"
                        style="background-color: #fafafa; border-bottom: 1px solid #eeeeee; padding: 12px 20px;">
                        <tr>
                            <td align="left"><span class="label"
                                    style="font-size: 12px; font-weight: 700; color: #000; text-transform: uppercase;">
                                    Order {{ $order->order_number }}</span></td>
                            <td align="right"><span class="status-badge">CANCELLED</span></td>
                        </tr>
                    </table>

                    <!-- Card Body -->
                    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
                        <tr>
                            <td align="left" valign="top">
                                <!-- Tour Title & Date -->
                                <div style="font-size: 16px; font-weight: 700; color: #111111; margin-bottom: 6px;">
                                    {{ $item->tour_name }}</div>
                                <div style="font-size: 13px; color: #666666; margin-bottom: 20px;">
                                    <strong>Original Booking Date:</strong>
                                    {{ formatDate($item->booking_date) }} &bull; {{ $item->time_slot }}
                                </div>

                                <!-- Pax Details -->
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="font-size: 13px; color: #555555; margin-bottom: 15px;">
                                    @php
                                        $paxDetails = is_array($item->pax_details) ? $item->pax_details : [];
                                    @endphp
                                    @foreach ($paxDetails as $key => $pax)
                                        @if (isset($pax['qty']) && $pax['qty'] > 0)
                                            <tr>
                                                <td style="padding-bottom: 8px;">
                                                    {{ $pax['label'] ?? ucfirst($key) }}
                                                    ({{ $pax['qty'] }} &times; {{ formatPrice($pax['price']) }})
                                                </td>
                                                <td align="right" style="padding-bottom: 8px; color: #111111;">
                                                    {{ formatPrice($pax['subtotal']) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>

                                <!-- Item Total -->
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="border-top: 2px solid #f4f4f4; padding-top: 12px;">
                                    <tr>
                                        <td style="font-size: 14px; font-weight: 700; color: #111111;">
                                            Item Total</td>
                                        <td align="right" style="font-size: 18px; font-weight: 800; color: #dc3545;">
                                            {{ formatPrice($item->subtotal) }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach

            <!-- Refund Information -->
            <table width="100%" cellpadding="0" cellspacing="0"
                style="margin-top: 30px; background-color: #fff8e1; border: 1px solid #ffd54f; border-radius: 4px; padding: 15px;">
                <tr>
                    <td>
                        <p style="font-size: 13px; color: #111111; margin: 0 0 10px 0; line-height: 1.6;">
                            <strong>Refund Information:</strong>
                        </p>
                        <p style="font-size: 13px; color: #666666; margin: 0; line-height: 1.6;">
                            The refund amount will be processed according to the cancellation policy. If eligible, the
                            refund will be credited to your original payment method within 10-15 working days. For
                            non-refundable bookings or cancellations within the deadline, no refund will be issued.
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Order Summary -->
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

            <!-- Contact Information -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                <tr>
                    <td>
                        <p style="font-size: 13px; color: #666666; margin: 0; line-height: 1.6; text-align: center;">
                            If you have any questions about this cancellation, please contact us at
                            <a href="mailto:{{ config('app.ADMINEMAIL') }}"
                                style="color: #e91e63; text-decoration: none;">{{ config('app.ADMINEMAIL') }}</a>
                        </p>
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
