<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>New Inquiry Notification</title>
    <style>
        :root {
            color-scheme: light;
            supported-color-schemes: light;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff !important;
            color: #1e293b !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
            min-width: 100%;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        .email-wrapper {
            width: 100% !important;
            background-color: #ffffff !important;
            margin: 0;
            padding: 0;
        }

        .email-header {
            background-color: #ffffff !important;
            color: #1e293b !important;
            padding: 20px 32px;
            border-bottom: 2px solid #e2e8f0;
        }

        .email-header img {
            max-height: 46px;
            width: auto;
            display: block;
        }

        .header-title {
            font-size: 13px;
            font-weight: 600;
            color: #64748b !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: right;
        }

        .email-body {
            padding: 28px 32px;
            width: 100% !important;
            box-sizing: border-box;
            background-color: #ffffff !important;
        }

        .info-table {
            width: 100% !important;
            border-collapse: collapse;
            margin-bottom: 24px;
            background-color: #ffffff !important;
        }

        .info-table th {
            text-align: left;
            background-color: #f8fafc !important;
            color: #334155 !important;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
        }

        .info-table td {
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            color: #0f172a !important;
            background-color: #ffffff !important;
            vertical-align: top;
        }

        .info-table td.label-col {
            width: 220px;
            font-weight: 600;
            background-color: #f8fafc !important;
            color: #475569 !important;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .badge-package {
            background-color: #dbeafe !important;
            color: #1e40af !important;
        }

        .badge-contact {
            background-color: #fef3c7 !important;
            color: #92400e !important;
        }

        .message-box {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0284c7;
            padding: 16px 20px;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.6;
            color: #334155 !important;
            margin-bottom: 24px;
            white-space: pre-line;
        }

        .btn-container {
            margin: 28px 0 16px 0;
        }

        .btn {
            display: inline-block;
            background-color: #0284c7 !important;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
        }

        .email-footer {
            background-color: #f8fafc !important;
            padding: 24px 32px;
            font-size: 12px;
            color: #64748b !important;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .powered-by {
            margin-top: 12px !important;
            font-size: 11px !important;
            color: #94a3b8 !important;
            letter-spacing: 0.3px;
        }

        .powered-by strong {
            color: #64748b !important;
            font-weight: 600;
        }

        /* Prevent Dark Mode Color Inversion on Supported Clients */
        @media (prefers-color-scheme: dark) {
            body, .email-wrapper, .email-body {
                background-color: #ffffff !important;
                color: #1e293b !important;
            }
            .email-header {
                background-color: #ffffff !important;
            }
            .info-table {
                background-color: #ffffff !important;
            }
            .info-table th {
                background-color: #f8fafc !important;
                color: #334155 !important;
            }
            .info-table td {
                background-color: #ffffff !important;
                color: #0f172a !important;
            }
            .info-table td.label-col {
                background-color: #f8fafc !important;
                color: #475569 !important;
            }
            .message-box {
                background-color: #f8fafc !important;
                color: #334155 !important;
                border-color: #e2e8f0 !important;
                border-left-color: #0284c7 !important;
            }
            .btn {
                background-color: #0284c7 !important;
                color: #ffffff !important;
            }
            .email-footer {
                background-color: #f8fafc !important;
                color: #64748b !important;
            }
        }

        /* Outlook / Gmail Dark Mode Attributes */
        [data-ogsc] body, [data-ogsc] .email-wrapper, [data-ogsc] .email-body {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }
        [data-ogsc] .info-table td {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }

        /* Mobile Responsive Styles */
        @media only screen and (max-width: 600px) {
            .email-header {
                padding: 16px 14px !important;
            }
            .email-header-table td {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
            }
            .header-title {
                text-align: left !important;
                margin-top: 10px !important;
                font-size: 12px !important;
            }
            .email-header img {
                max-height: 38px !important;
            }
            .email-body {
                padding: 16px 14px !important;
            }
            .info-table {
                display: block !important;
                width: 100% !important;
                margin-bottom: 18px !important;
            }
            .info-table thead, .info-table tbody {
                display: block !important;
                width: 100% !important;
            }
            .info-table th {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box !important;
                padding: 8px 12px !important;
                font-size: 12px !important;
            }
            .info-table tr {
                display: block !important;
                width: 100% !important;
                border: 1px solid #e2e8f0 !important;
                border-top: none !important;
                box-sizing: border-box !important;
            }
            .info-table tr:first-child {
                border-top: 1px solid #e2e8f0 !important;
            }
            .info-table td.label-col {
                display: block !important;
                width: 100% !important;
                border: none !important;
                padding: 8px 12px 2px 12px !important;
                font-size: 12px !important;
                font-weight: 700 !important;
                color: #64748b !important;
                background-color: #ffffff !important;
                box-sizing: border-box !important;
            }
            .info-table td:not(.label-col) {
                display: block !important;
                width: 100% !important;
                border: none !important;
                padding: 2px 12px 10px 12px !important;
                font-size: 14px !important;
                box-sizing: border-box !important;
                background-color: #ffffff !important;
            }
            .message-box {
                padding: 12px 14px !important;
                font-size: 13px !important;
                margin-bottom: 20px !important;
            }
            .btn {
                display: block !important;
                width: 100% !important;
                text-align: center !important;
                box-sizing: border-box !important;
                padding: 12px 16px !important;
            }
            .email-footer {
                padding: 18px 14px !important;
                font-size: 11px !important;
            }
        }
    </style>
</head>
<body bgcolor="#ffffff" style="background-color: #ffffff; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: 100%;">
    <div class="email-wrapper" style="background-color: #ffffff; width: 100%;">
        <!-- Header with Branding Logo -->
        <div class="email-header" style="background-color: #ffffff; padding: 20px 32px; border-bottom: 2px solid #e2e8f0;">
            <table class="email-header-table" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="background-color: #ffffff; width: 100%;">
                <tr>
                    <td valign="middle" align="left">
                        @if(file_exists(public_path('images/Logo/worldine.png')))
                            <img src="{{ $message->embed(public_path('images/Logo/worldine.png')) }}" alt="Worldine Destinations" style="max-height: 46px; height: 46px; width: auto; display: block; border: 0;" height="46" />
                        @else
                            <span style="font-size: 20px; font-weight: 700; color: #0284c7; text-transform: uppercase;">Worldine Destinations</span>
                        @endif
                    </td>
                    <td valign="middle" align="right" class="header-title" style="text-align: right; font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        New Inquiry Notification
                    </td>
                </tr>
            </table>
        </div>

        <!-- Body Content -->
        <div class="email-body" style="background-color: #ffffff; padding: 28px 32px;">
            <!-- Overview Table -->
            <table class="info-table" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="background-color: #ffffff; width: 100%; border-collapse: collapse; margin-bottom: 24px;">
                <thead>
                    <tr>
                        <th colspan="2" bgcolor="#f8fafc" style="background-color: #f8fafc; color: #334155; font-size: 13px; font-weight: 700; text-transform: uppercase; padding: 10px 16px; border: 1px solid #e2e8f0; text-align: left;">Overview</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Reference ID</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;"><strong>{{ $inquiry->reference_id ?? 'WRD-NEW' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Inquiry Category</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;">
                            @if($inquiry->type === 'package_inquiry')
                                <span class="status-badge badge-package" style="display: inline-block; padding: 4px 10px; font-size: 12px; font-weight: 700; border-radius: 4px; text-transform: uppercase; background-color: #dbeafe; color: #1e40af;">Tour Package Booking</span>
                            @else
                                <span class="status-badge badge-contact" style="display: inline-block; padding: 4px 10px; font-size: 12px; font-weight: 700; border-radius: 4px; text-transform: uppercase; background-color: #fef3c7; color: #92400e;">Contact Form Lead</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Submitted At</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;">{{ $inquiry->created_at ? $inquiry->created_at->format('F j, Y, g:i a T') : date('F j, Y, g:i a') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Customer Details Table -->
            <table class="info-table" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="background-color: #ffffff; width: 100%; border-collapse: collapse; margin-bottom: 24px;">
                <thead>
                    <tr>
                        <th colspan="2" bgcolor="#f8fafc" style="background-color: #f8fafc; color: #334155; font-size: 13px; font-weight: 700; text-transform: uppercase; padding: 10px 16px; border: 1px solid #e2e8f0; text-align: left;">Customer Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Full Name</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;"><strong>{{ $inquiry->customer_name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Email Address</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;"><a href="mailto:{{ $inquiry->email }}" style="color: #0284c7; text-decoration: none;">{{ $inquiry->email }}</a></td>
                    </tr>
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Phone Number</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;"><a href="tel:{{ $inquiry->phone }}" style="color: #0f172a; text-decoration: none;">{{ $inquiry->phone }}</a></td>
                    </tr>
                </tbody>
            </table>

            <!-- Inquiry Details Table -->
            <table class="info-table" cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff" style="background-color: #ffffff; width: 100%; border-collapse: collapse; margin-bottom: 24px;">
                <thead>
                    <tr>
                        <th colspan="2" bgcolor="#f8fafc" style="background-color: #f8fafc; color: #334155; font-size: 13px; font-weight: 700; text-transform: uppercase; padding: 10px 16px; border: 1px solid #e2e8f0; text-align: left;">Inquiry Specifications</th>
                    </tr>
                </thead>
                <tbody>
                    @if($inquiry->package_title)
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Package Title</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;"><strong>{{ $inquiry->package_title }}</strong></td>
                    </tr>
                    @endif
                    @if($inquiry->destination_name)
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Destination</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;">{{ $inquiry->destination_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Inquiry Type</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;">{{ $inquiry->inquiry_type ?? 'General Inquiry' }}</td>
                    </tr>
                    @if($inquiry->travel_date)
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Travel Date(s)</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;">{{ $inquiry->travel_date }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="label-col" bgcolor="#f8fafc" style="width: 220px; font-weight: 600; background-color: #f8fafc; color: #475569; padding: 12px 16px; border: 1px solid #e2e8f0;">Guests / Travelers</td>
                        <td bgcolor="#ffffff" style="background-color: #ffffff; color: #0f172a; padding: 12px 16px; border: 1px solid #e2e8f0;">{{ $inquiry->guests ?? 1 }} Person(s)</td>
                    </tr>
                </tbody>
            </table>

            <!-- Customer Message -->
            @if($inquiry->message)
                <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #475569; margin-bottom: 8px;">Customer Message:</div>
                <div class="message-box" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #0284c7; padding: 16px 20px; border-radius: 4px; font-size: 14px; line-height: 1.6; color: #334155; margin-bottom: 24px; white-space: pre-line;">{{ $inquiry->message }}</div>
            @endif

            <!-- Admin CTA Button -->
            <div class="btn-container" style="margin: 28px 0 16px 0;">
                <a href="{{ config('app.url') }}/admin/bookings" class="btn" target="_blank" style="display: inline-block; background-color: #0284c7; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; font-weight: 600;">Open Admin Dashboard &rarr;</a>
            </div>
        </div>

        <!-- Footer with Powered By Credit -->
        <div class="email-footer" style="background-color: #f8fafc; padding: 24px 32px; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; text-align: center;">
            <p style="margin: 0 0 6px 0; color: #475569;">
                <strong style="color: #475569;">Please do not reply directly to this email.</strong> This is an automated notification from a system-monitored address.
            </p>
            <p style="margin: 0 0 6px 0; font-size: 11px; color: #94a3b8;">
                &copy; {{ date('Y') }} Worldine Destinations (Pvt) Ltd. All rights reserved.
            </p>
            <p class="powered-by" style="margin: 10px 0 0 0; font-size: 11px; color: #94a3b8; letter-spacing: 0.3px;">
                Powered by <strong style="color: #64748b; font-weight: 600;">Hoomans Digital</strong>
            </p>
        </div>
    </div>
</body>
</html>
