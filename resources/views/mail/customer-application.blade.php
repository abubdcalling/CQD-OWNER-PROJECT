<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
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
        .email-body table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .email-body table th, .email-body table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
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
    <header class="email-header">
        <h1>Thank You for Applying!</h1>
    </header>
    <main class="email-body">
        <p>Hello There,</p>
        <p>Thank you for applying for our cleaning services. We have received your application, and below are the details of your selected package:</p>
        <table>
            <tr>
                <th>Package</th>
                <td>{{ $package->title }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>£{{ number_format($package->price, 2) }} (Ex VAT)</td>
            </tr>
            <tr>
                <th>Minimum Clients</th>
                <td>{{ $package->number_of_client }}</td>
            </tr>
        </table>
        <p>Once enough clients are grouped for this package, we will notify you and start the service. If you have any questions or would like to modify your application, feel free to contact us at <a href="mailto:{{$settings['email'] ?? 'support@mail.com'  }}">{{$settings['email'] ?? 'support@mail.com'  }}</a>.</p>
        <p>Thank you for choosing {{$settings['title'] ?? 'COD'}}. We look forward to serving you!</p>
        <p>Best regards,</p>
        <p>The {{$settings['title'] ?? 'COD'}} Team</p>
    </main>
    <footer class="email-footer">
        <p>
            <a href="{{  $privacy_url  }}">Privacy Policy</a> |
            <a href="mailto:{{$settings['email'] ?? 'support@mail.com'  }}">Contact Support</a>
        </p>
        <div class="contact-info">
            <p>Address: {{$settings['address'] ?? '123 Business Street, City, Country'}}</p>
            <p>Contact Number: {{$settings['contact_number'] ?? '+93433434 3433'}}</p>
        </div>
        <p>&copy; {{ date('Y') }} {{$settings['title'] ?? 'COD'}}. All rights reserved.</p>
    </footer>
</div>
</body>
</html>


