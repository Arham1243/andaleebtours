<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Prio Order Confirmation Failed - {{ $order->order_number }}</title>
    <style>
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
            margin: 0 0 10px 0;
        }

        .alert-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }

        .alert-text {
            font-size: 14px;
            color: #856404;
            line-height: 1.6;
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

        .btn-view {
            display: inline-block;
            background-color: #dc3545;
            color: #ffffff !important;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border-radius: 4px;
            margin-top: 15px;
        }

        .info-table {
            width: 100%;
            background-color: #f9f9f9;
            border: 1px solid #eeeeee;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .info-row {
            padding: 8px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .footer {
            padding-top: 30px;
            text-align: center;
            border-top: 1px solid #f4f4f4;
        }

        .footer-text {
            font-size: 12px;
            color: #111111;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 15px !important;
            }

            h1 {
                font-size: 18px !important;
            }

            .btn-view {
                display: block !important;
                text-align: center !important;
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
                            alt="Andaleeb Travel Agency" width="200" style="display: block; border: 0; max-width: 200px;" />
                    </td>
                </tr>
            </table>

            <!-- Alert Header -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                <tr>
                    <td>
                        <p style="font-size: 13px; color: #dc3545; font-weight: bold; margin-bottom: 5px; text-transform: uppercase;">
                            ⚠️ Action Required</p>
                        <h1>Prio Order Confirmation Failed</h1>
                        <p style="font-size: 15px; color: #666666; line-height: 1.6; margin-bottom: 0;">
                            Order <strong>{{ $order->order_number }}</strong> - Payment was successful but Prio order confirmation failed.
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Alert Box -->
            <div class="alert-box">
                <p class="alert-text">
                    <strong>Payment Status:</strong> ✓ Paid<br>
                    <strong>Prio Confirmation:</strong> ✗ Failed<br><br>
                    The customer has successfully paid, but the booking could not be confirmed with PrioTicket. 
                    Please manually process this order immediately.
                </p>
            </div>

            <!-- Order Information -->
            <table class="info-table" cellpadding="0" cellspacing="0">
                <tr class="info-row">
                    <td width="40%">
                        <span class="label">Order Number</span>
                    </td>
                    <td width="60%">
                        <span class="data-text">{{ $order->order_number }}</span>
                    </td>
                </tr>
                <tr class="info-row">
                    <td>
                        <span class="label">Customer Name</span>
                    </td>
                    <td>
                        <span class="data-text">{{ $order->passenger_title }} {{ $order->passenger_first_name }} {{ $order->passenger_last_name }}</span>
                    </td>
                </tr>
                <tr class="info-row">
                    <td>
                        <span class="label">Email</span>
                    </td>
                    <td>
                        <span class="data-text">{{ $order->passenger_email }}</span>
                    </td>
                </tr>
                <tr class="info-row">
                    <td>
                        <span class="label">Phone</span>
                    </td>
                    <td>
                        <span class="data-text">{{ $order->passenger_phone }}</span>
                    </td>
                </tr>
                <tr class="info-row">
                    <td>
                        <span class="label">Total Paid</span>
                    </td>
                    <td>
                        <span class="data-text" style="color: #28a745; font-weight: 700;">{{ formatPrice($order->total) }}</span>
                    </td>
                </tr>
                <tr class="info-row">
                    <td>
                        <span class="label">Payment Method</span>
                    </td>
                    <td>
                        <span class="data-text">{{ strtoupper($order->payment_method) }}</span>
                    </td>
                </tr>
            </table>

            <!-- Booking Details -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                <tr>
                    <td>
                        <span class="label" style="font-size: 12px; display: block; margin-bottom: 10px;">BOOKING DETAILS</span>
                        @foreach ($order->orderItems as $item)
                        <div style="background-color: #f9f9f9; border: 1px solid #eeeeee; padding: 12px; border-radius: 4px; margin-bottom: 10px;">
                            <div style="font-size: 14px; font-weight: 600; color: #111111; margin-bottom: 5px;">
                                {{ $item->tour_name }}
                            </div>
                            <div style="font-size: 12px; color: #666666;">
                                {{ formatDate($item->booking_date) }} • {{ $item->time_slot }} • {{ $item->quantity }} pax
                            </div>
                        </div>
                        @endforeach
                    </td>
                </tr>
            </table>

            <!-- Action Button -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                <tr>
                    <td align="center">
                        <a target="_blank" href="{{ route('admin.orders.show', $order->id) }}" class="btn-view">
                            View Order
                        </a>
                    </td>
                </tr>
            </table>

            <!-- Error Details (if available) -->
            @if(isset($errorDetails) && !empty($errorDetails))
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                <tr>
                    <td style="background-color: #fff5f5; border: 1px solid #fee; padding: 12px; border-radius: 4px;">
                        <span class="label" style="color: #dc3545;">ERROR DETAILS</span>
                        <p style="font-size: 12px; color: #721c24; margin: 8px 0 0 0; font-family: monospace;">
                            {{ $errorDetails }}
                        </p>
                    </td>
                </tr>
            </table>
            @endif

            <!-- Footer -->
            <div class="footer">
                <p class="footer-text">
                    &copy; {{ date('Y') }} Andaleeb Travel Agency
                </p>
            </div>

        </div>
    </center>
</body>

</html>
