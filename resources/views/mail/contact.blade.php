<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Request</title>
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
    </style>
</head>
<body>
<div class="email-container">
    <header class="email-header">
        <h1>New Contact Request</h1>
    </header>
    <main class="email-body">
        <p>Hello there,</p>
        <p>You have received a new contact request from your website({{env('FRONTEND_APP_URL')}}). Here are the details:</p>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $user['name'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user['phone'] }}</td>
            </tr>
            <tr>
                <th>Organisation</th>
                <td>{{$user['organisation']}}</td>
            </tr>
            <tr>
                <th>Message</th>
                <td>{{ $user['message'] }}</td>
            </tr>
        </table>
        <p>Please respond to the inquiry at your earliest convenience.</p>
    </main>
    <footer class="email-footer">
        <p>
            <a href="{{ $privacy_url }}">Privacy Policy</a> |
            <a href="mailto:{{$settings['email'] ?? 'support@mail.com'}}">Contact Support</a>
        </p>
        <div class="contact-info">
            <p>Address: {{$settings['address'] ?? '123 Business Street, City, Country'}}</p>
            <p>Contact Number: {{$settings['contact_number'] ?? '+1234567890'}}</p>
        </div>
        <p>&copy; {{ date('Y') }} {{$settings['title'] ?? 'Your Company'}}. All rights reserved.</p>
    </footer>
</div>
</body>
</html>
