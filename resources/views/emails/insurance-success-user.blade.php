<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Travel Insurance Confirmed - {{ $insurance->insurance_number }}</title>
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

        .info-box {
            background-color: #f0f8ff;
            border: 1px solid #0066cc;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
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
                            alt="Andaleeb Travel Agency" width="200" style="display: block; border: 0; max-width: 200px;" />
                    </td>
                </tr>
            </table>

            <!-- Greeting & Main Status -->
            <table width="100%" cellpadding="0" cellspacing="0" class="border-bottom">
                <tr>
                    <td class="section-padding" align="left">
                        <p style="font-size: 15px; color: #666666; margin-bottom: 10px;">Dear {{ $insurance->lead_name }},</p>
                        <h1>Travel Insurance Confirmed: {{ $insurance->insurance_number }}</h1>
                        <p style="font-size: 15px; color: #666666; line-height: 1.6; margin-bottom: 20px;">
                            Your travel insurance has been successfully purchased and confirmed. Your policy documents are attached to this email.
                        </p>
                        <span class="status-badge">CONFIRMED</span>
                    </td>
                </tr>
            </table>

            <!-- Insurance Details -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                <tr>
                    <td style="padding: 20px; background-color: #fafafa; border: 1px solid #eeeeee; border-radius: 4px;">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding: 8px 0;">
                                    <span class="label">Plan</span><br>
                                    <span class="data-text">{{ $insurance->plan_title }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;">
                                    <span class="label">Travel Dates</span><br>
                                    <span class="data-text">{{ formatDate($insurance->start_date) }} to {{ formatDate($insurance->return_date) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;">
                                    <span class="label">Destination</span><br>
                                    <span class="data-text">{{ $insurance->origin }} → {{ $insurance->destination }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 0;">
                                    <span class="label">Passengers</span><br>
                                    <span class="data-text">
                                        {{ $insurance->total_adults }} Adult(s)
                                        @if($insurance->total_children > 0), {{ $insurance->total_children }} Child(ren)@endif
                                        @if($insurance->total_infants > 0), {{ $insurance->total_infants }} Infant(s)@endif
                                    </span>
                                </td>
                            </tr>
                            @if($insurance->policy_numbers)
                            <tr>
                                <td style="padding: 8px 0;">
                                    <span class="label">Policy Numbers</span><br>
                                    <span class="data-text">{{ $insurance->policy_numbers }}</span>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding: 8px 0; border-top: 2px solid #28a745; padding-top: 15px; margin-top: 10px;">
                                    <span class="label">Total Premium Paid</span><br>
                                    <span class="data-text" style="font-size: 18px; font-weight: 700; color: #28a745;">
                                        {{ number_format($insurance->total_premium + ($insurance->total_premium * $commissionPercentage), 2) }} {{ $insurance->currency }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Info Box -->
            <div class="info-box">
                <p style="margin: 0; font-size: 13px; color: #0066cc; line-height: 1.6;">
                    <strong>Important:</strong> Your policy documents are attached to this email. Please keep them safe and carry them during your travel. 
                    You can also access your insurance details anytime from your dashboard.
                </p>
            </div>

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
