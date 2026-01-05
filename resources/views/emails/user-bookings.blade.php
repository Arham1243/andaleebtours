<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Booking History - Andaleeb Travel</title>
    <style>
        @font-face {
            font-family: "UAEDirham";
            src: url("{{ asset('frontend/assets/fonts/UAE-dirham/aed-Regular.otf') }}");
        }

        body :is(.dirham.dirham) {
            font-family: "UAEDirham" !important;
            font-weight: 400 !important;
            font-size: inherit !important;
            color: inherit !important;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            /* Slightly different bg to distinguish internal mail */
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


        /* Header */
        h1 {
            font-size: 24px;
            font-weight: 600;
            color: #111111;
            margin: 0;
        }

        .label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #999999;
            letter-spacing: 1px;
        }

        /* Booking Card */
        .booking-card {
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-header {
            padding: 15px 20px;
            background-color: #fafafa;
            border-bottom: 1px solid #eeeeee;
        }

        .card-body {
            padding: 20px;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .badge-confirmed {
            color: #28a745;
            border: 1px solid #28a745;
            background-color: #f0fff4;
        }

        .badge-pending {
            color: #facc15;
            border: 1px solid #facc15;
            background-color: #fffbeb;
        }

        .badge-cancelled {
            color: #dc3545;
            border: 1px solid #dc3545;
            background-color: #fff5f5;
        }


        /* Footer */
        .footer {
            padding-top: 20px;
            text-align: center;
        }

        .footer-text {
            font-size: 12px;
            color: #666666;
            letter-spacing: 0.5px;
        }

        .footer-text a {
            font-weight: 600;
            color: #111111;
            text-decoration: none;
        }

        .card-header .label {
            color: #000;
            font-weight: 600;
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

            .booking-card {
                border-radius: 4px !important;
                margin-bottom: 15px !important;
            }

            table[width="50%"] {
                width: 100% !important;
            }

            .footer {
                padding-top: 30px !important;
            }

            .footer-text {
                font-size: 11px !important;
            }

            /* Fix booking card header overflow */
            table[style*="background-color: #fafafa"] {
                padding: 10px 12px !important;
            }

            table[style*="background-color: #fafafa"] .label {
                font-size: 10px !important;
                display: block !important;
                word-break: break-word !important;
            }

            table[style*="background-color: #fafafa"] .badge {
                font-size: 8px !important;
                padding: 2px 6px !important;
                display: inline-block !important;
                white-space: nowrap !important;
            }

            /* Card body padding */
            table[style*="padding: 20px"] {
                padding: 15px !important;
            }

            /* Tour title and details */
            div[style*="font-size: 16px"] {
                font-size: 14px !important;
            }

            div[style*="font-size: 13px"] {
                font-size: 12px !important;
            }

            /* Financial breakdown table */
            table[style*="font-size: 13px"] {
                font-size: 12px !important;
            }

            table[style*="font-size: 13px"] td {
                font-size: 12px !important;
                word-break: break-word !important;
            }

            /* Total price */
            td[style*="font-size: 20px"] {
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

            .badge {
                font-size: 9px !important;
                padding: 3px 8px !important;
            }

            .label {
                font-size: 10px !important;
            }

            /* Further reduce font sizes on very small screens */
            div[style*="font-size: 16px"] {
                font-size: 13px !important;
            }

            div[style*="font-size: 13px"] {
                font-size: 11px !important;
            }

            table[style*="font-size: 13px"] {
                font-size: 11px !important;
            }

            table[style*="font-size: 13px"] td {
                font-size: 11px !important;
            }

            td[style*="font-size: 20px"] {
                font-size: 14px !important;
            }
        }
    </style>
</head>

<body>
    <center class="wrapper">
        <div class="container">

            <!-- Logo -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 40px;">
                <tr>
                    <td align="center">
                        <img src="{{ asset('frontend/assets/images/email-template-logo.png') }}"
                            alt="Andaleeb Travel Agency" width="200"
                            style="display: block; border: 0; max-width: 200px;" />
                    </td>
                </tr>
            </table>

            <!-- Intro -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px; padding: 0 10px;">
                <tr>
                    <td align="left">
                        @if ($orders->isNotEmpty())
                            <p style="font-size: 15px; color: #666666; margin-bottom: 5px;">Hello
                                {{ $orders->first()->passenger_title }} {{ $orders->first()->passenger_first_name }}
                                {{ $orders->first()->passenger_last_name }},</p>
                        @endif
                        <h1>Your Booking History</h1>
                        <p style="font-size: 14px; color: #999999; line-height: 1.5;">
                            As requested, here is a summary of all your reservations with Andaleeb Travel Agency.
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Loop through all orders -->
            @foreach ($orders as $order)
                @foreach ($order->orderItems as $item)
                    <div class="booking-card"
                        style="background-color: #ffffff; border: 1px solid #eeeeee; border-radius: 8px; margin-bottom: 25px; overflow: hidden;">
                        <!-- Card Header -->
                        <table width="100%" cellpadding="0" cellspacing="0"
                            style="background-color: #fafafa; border-bottom: 1px solid #eeeeee; padding: 12px 20px;">
                            <tr>
                                <td align="left"><span class="label"
                                        style="font-size: 12px; font-weight: 700; color: #000; text-transform: uppercase;">Order
                                        {{ $order->order_number }}</span></td>
                                <td align="right">
                                    @php
                                        $statusClass = 'badge-pending';
                                        $statusText = ucfirst($order->payment_status);
                                        if ($order->payment_status === 'paid') {
                                            $statusClass = 'badge-confirmed';
                                            $statusText = 'Paid';
                                        } elseif ($order->payment_status === 'failed') {
                                            $statusClass = 'badge-cancelled';
                                            $statusText = 'Failed';
                                        } else {
                                            $statusText = $order->payment_status;
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }}"
                                        style="padding: 4px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase; border-radius: 2px;">Payment:
                                        {{ $statusText }}</span>
                                </td>
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
                                        {{ formatDate($item->booking_date) }} &bull; {{ $item->time_slot }}</div>

                                    <!-- Financial Breakdown Table -->
                                    <table width="100%" cellpadding="0" cellspacing="0"
                                        style="font-size: 13px; color: #555555;">
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
                                                    {!! formatPrice($pax['price']) !!})</td>
                                                <td align="right"
                                                    style="padding-bottom: {{ $key === $lastKey ? '12px' : '8px' }}; color: #111111; {{ $key === $lastKey ? 'border-bottom: 1px solid #f4f4f4;' : '' }}">
                                                    {!! formatPrice($pax['subtotal']) !!}</td>
                                            </tr>
                                        @endforeach

                                        <!-- Total Row -->
                                        <tr>
                                            <td
                                                style="border-top: 1px solid #f4f4f4;padding-top: 10px; font-size: 14px; font-weight: 700; color: #111111;">
                                                Total</td>
                                            <td align="right"
                                                style="padding-top: 10px; font-size: 20px; font-weight: 800; color: #e91e63;">
                                                {!! formatPrice($item->subtotal) !!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @endforeach

            <!-- Minimal Footer -->
            <div class="footer">
                <p class="footer-text">
                    &copy; 2026 Andaleeb Travel Agency <a href="https://andaleebtours.com">www.andaleebtours.com</a>
                </p>
            </div>


        </div>
    </center>
</body>

</html>
