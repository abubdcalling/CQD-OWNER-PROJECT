<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Application Received - Admin Notification</title>
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
        .customer-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
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
        <h1>New Application Received</h1>
    </header>
    <main class="email-body">
        <p>Hello Admin,</p>
        <p>A new cleaning service application has been received. Here are the details:</p>

        <div class="customer-details">
            <h3>Customer Information</h3>
            <table>
                <tr>
                    <th>Company Name</th>
                    <td>{{ $customer->company_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $customer->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $customer->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $customer->address }}</td>
                </tr>
            </table>
        </div>

        <h3>Selected Package Details</h3>
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
            <tr>
                <th>Current Group Size</th>
                <td>{{ $current_group_size }}</td>
            </tr>
            <tr>
                <th>Application Date</th>
                <td>{{ $application_date }}</td>
            </tr>
        </table>

        <p>Please review this application and take appropriate action.</p>
    </main>
    <footer class="email-footer">
        <p>This is an automated admin notification from {{$settings['title'] ?? 'COD'}}.</p>
        <p>&copy; {{ date('Y') }} {{$settings['title'] ?? 'COD'}}. All rights reserved.</p>
    </footer>
</div>
</body>
</html>