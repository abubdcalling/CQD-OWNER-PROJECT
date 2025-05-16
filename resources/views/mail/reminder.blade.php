<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Please Complete Your Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #002f45; /* Match your website's primary color */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #666666;
        }
        .email-footer a {
            color: #002f45;
            text-decoration: none;
        }
        .email-footer .contact-info {
            margin-top: 10px;
        }
        .email-footer .contact-info p {
            margin: 5px 0;
        }
        .cta-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #002f45;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <header class="email-header">
        <h1>Please Complete Your Application</h1>
    </header>
    <main class="email-body">
        <p>Hello there,</p>
        <p>We noticed that you started an application for the <strong>{{ $package?->title }}</strong> package but haven't completed it yet. Don't miss out on the opportunity to join our service group!</p>

        <p>Completing your application only takes a few minutes. Click the button below to pick up where you left off:</p>

        <a href="{{env('FRONTEND_APP_URL').'/'.'customer-buy-journey/'.$package?->id}}?client={{$client_id}}" class="cta-button">Complete Your Application</a>

        <p>If you have any questions or need assistance, feel free to reach out to our support team at <a href="mailto:{{$settings['email'] ?? 'support@mail.com'}}">{{$settings['email'] ?? 'support@mail.com'}}</a>.</p>

        <p>We look forward to having you on board!</p>
        <p>Best regards,</p>
        <p>The {{$settings['title'] ?? 'COD'}} Team</p>
    </main>
    <footer class="email-footer">
        <p>&copy; {{ date('Y') }} {{$settings['title'] ?? 'COD'}}. All rights reserved.</p>
        <div class="contact-info">
            <p>Address: {{$settings['address'] ?? '123 Business Street, City, Country'}}</p>
            <p>Contact Number: {{$settings['contact_number'] ?? '+1-234-567-890'}}</p>
        </div>
        <p>
            <a href="{{  $privacy_url  }}">Privacy Policy</a> |
            <a href="mailto:{{$settings['email'] ?? 'support@mail.com'}}">Contact Support</a>
        </p>
    </footer>
</div>
</body>
</html>