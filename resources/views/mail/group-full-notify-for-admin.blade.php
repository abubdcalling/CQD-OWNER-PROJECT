<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Group Ready to Start - Admin Notification</title>
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
            background-color: #002f45;
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
        .action-buttons {
            text-align: center;
            margin: 20px 0;
        }
        .action-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #002f45;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
<div class="email-container">
    <header class="email-header">
        <h1>New Service Group Ready! 🎉</h1>
    </header>
    <main class="email-body">
        <p>Hello Admin,</p>
        <p>Great news! A cleaning service group has reached its minimum required clients and is ready to begin. Here are the details:</p>

        <h3>Package Details:</h3>
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
                <th>Total Clients</th>
                <td>{{ $package->number_of_client }}</td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td>{{ $group->created_at->format('Y-m-d') }}</td>
            </tr>
        </table>

        <h3>Client Group Information:</h3>
        <table>
            @foreach($customers as $customer)
                <tr>
                    <th>Customer {{ $loop->iteration }}</th>
                    <td>
                        Name: {{ $customer->company_name }}<br>
                        Email: {{ $customer->email }}<br>
                        Phone: {{ $customer->phone }}<br>
                        Address: {{ $customer->address }}
                    </td>
                </tr>
            @endforeach
        </table>

        <p>Please review the group details and initiate the service scheduling process.</p>

        <p>Best regards,</p>
        <p>The {{$settings['title'] ?? 'COD'}} Team</p>
    </main>
    <footer class="email-footer">
        <p>&copy; {{ date('Y') }} {{$settings['title'] ?? 'COD'}}. All rights reserved.</p>
        <div class="contact-info">
            <p>Address: {{$settings['address'] ?? '123 Business Street, City, Country'}}</p>
            <p>Contact Number: {{$settings['contact_number'] ?? '+1-234-567-890'}}</p>
        </div>
    </footer>
</div>
</body>
</html>