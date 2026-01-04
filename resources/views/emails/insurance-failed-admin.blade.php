<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Insurance Payment Failed - {{ $insurance->insurance_number }}</title>
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
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 2px;
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
                        <h1>Insurance Payment Failed</h1>
                        <p style="font-size: 15px; color: #666666; line-height: 1.6; margin-bottom: 20px;">
                            A travel insurance payment attempt has failed. Customer may retry the payment.
                        </p>
                        <span class="status-badge">PAYMENT: FAILED</span>
                    </td>
                </tr>
            </table>

            <!-- Insurance Details -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                <tr>
                    <td style="padding: 20px; background-color: #fafafa; border: 1px solid #eeeeee; border-radius: 4px;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2" style="padding-bottom: 15px; border-bottom: 2px solid #eeeeee;">
                                    <span class="label">Insurance Number</span><br>
                                    <span class="data-text" style="font-size: 16px; font-weight: 700;">{{ $insurance->insurance_number }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0; width: 50%;">
                                    <span class="label">Customer Name</span><br>
                                    <span class="data-text">{{ $insurance->lead_name }}</span>
                                </td>
                                <td style="padding: 8px 0; width: 50%;">
                                    <span class="label">Email</span><br>
                                    <span class="data-text">{{ $insurance->lead_email }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;">
                                    <span class="label">Phone</span><br>
                                    <span class="data-text">{{ $insurance->lead_phone }}</span>
                                </td>
                                <td style="padding: 8px 0;">
                                    <span class="label">Payment Method</span><br>
                                    <span class="data-text">{{ strtoupper($insurance->payment_method) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px 0; border-top: 1px solid #eeeeee; padding-top: 15px;">
                                    <span class="label">Plan</span><br>
                                    <span class="data-text">{{ $insurance->plan_title }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px 0;">
                                    <span class="label">Travel Dates</span><br>
                                    <span class="data-text">{{ formatDate($insurance->start_date) }} to {{ formatDate($insurance->return_date) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px 0;">
                                    <span class="label">Destination</span><br>
                                    <span class="data-text">{{ $insurance->origin }} → {{ $insurance->destination }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px 0;">
                                    <span class="label">Total Passengers</span><br>
                                    <span class="data-text">
                                        {{ $insurance->total_adults }} Adult(s)
                                        @if($insurance->total_children > 0), {{ $insurance->total_children }} Child(ren)@endif
                                        @if($insurance->total_infants > 0), {{ $insurance->total_infants }} Infant(s)@endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 8px 0; border-top: 2px solid #dc3545; padding-top: 15px; margin-top: 10px;">
                                    <span class="label">Failed Amount</span><br>
                                    <span class="data-text" style="font-size: 18px; font-weight: 700; color: #dc3545;">
                                        {{ number_format($insurance->total_premium + ($insurance->total_premium * $commissionPercentage), 2) }} {{ $insurance->currency }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- View Details Button -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 25px;">
                <tr>
                    <td align="center">
                        <a href="{{ route('admin.travel-insurances.show', $insurance->id) }}"
                            style="display: inline-block; background-color: #111111; color: #ffffff; padding: 12px 30px; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 4px;">
                            View Full Details
                        </a>
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
