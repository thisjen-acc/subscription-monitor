<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .header {
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 25px 30px;
        }
        .header .company {
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.8;
            margin: 0 0 6px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .body {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .details {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 8px 0;
            font-size: 14px;
        }
        .details td.label {
            color: #6b7280;
            width: 40%;
        }
        .details td.value {
            color: #111827;
            font-weight: 600;
        }
        .footer {
            padding: 20px 30px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            border-top: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="company">Pentagon Unlimited Technologies Inc.</p>
            <h1>⚠️ Subscription Expiring Soon ({{ $label }})</h1>
        </div>
        <div class="body">
            <p>Hello,</p>
            <p>This is a reminder that the following subscription is expiring soon:</p>

            <div class="details">
                <table>
                    <tr>
                        <td class="label">Client</td>
                        <td class="value">{{ $subscription->client_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Subscription</td>
                        <td class="value">{{ $subscription->subscription_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Expiry Date</td>
                        <td class="value">{{ \Carbon\Carbon::parse($subscription->end_date)->format('F j, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">PO Number</td>
                        <td class="value">{{ $subscription->po_number ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kit Number</td>
                        <td class="value">{{ $subscription->kit_number ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Monthly Cost</td>
                        <td class="value">₱{{ number_format($subscription->monthly_cost, 2) }}</td>
                    </tr>
                </table>
            </div>

            <p style="margin-top: 25px;">Please take the necessary action to renew or review this subscription before it expires.</p>
        </div>
        <div class="footer">
            This is an automated notification from Pentagon Unlimited Technologies Inc. Subscription Monitor.
        </div>
    </div>
</body>
</html>