<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$mail_subject}}</title>
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
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 10px 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
        }
        .email-body h2 {
            color: #002f45;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-body .cta {
            text-align: center;
            margin: 20px 0;
        }
        .email-body .cta a {
            display: inline-block;
            background-color: #00a550; /* Match your website's secondary color */
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
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
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <img src="{{$logo}}" alt="Logo test">
    </div>
    <!-- Body -->
    <div class="email-body">
        <h2>Dear {{ $user->full_name() }},</h2>
        <p>
            {!! $content !!}
        </p>
    </div>
    <!-- Footer -->
    <div class="email-footer">
        <p>Thank you for being with us!</p>
        <p>
            <a href="{{  $privacy_url  }}">Privacy Policy</a> |
            <a href="mailto:{{$settings['email'] ?? 'support@mail.com'  }}">Contact Support</a>
        </p>
        <div class="contact-info">
            <p>Address: {{$settings['address'] ?? '123 Business Street, City, Country'}}</p>
            <p>Contact Number: {{$settings['contact_number'] ?? '+93433434 3433'}}</p>
        </div>
        <p>&copy; {{ date('Y') }} COD. All rights reserved.</p>
    </div>
</div>
</body>
</html>
