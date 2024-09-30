<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Pre-Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            background: #5bff97;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            font-size: 0.9em;
            text-align: center;
            color: #777;
            padding: 20px;
        }
        .order-details {
            margin-top: 20px;
            border: 1px solid #5bff97;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>New Pre-Order Notification</h1>
</div>

<div class="content">
    <p>Dear Admin,</p>
    <p>You have received a new pre-order. Here are the details:</p>

    <div class="order-details">
        <h3>Pre-Order Details</h3>
        <p><strong>Order ID:</strong> {{ data_get($data, 'id') }}</p>
        <p><strong>Customer Name:</strong> {{ data_get($data, 'customer_name') }}</p>
        <p><strong>Email:</strong> {{ data_get($data, 'customer_email') }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format(data_get($data, 'total'), 2) }}</p>
        <p><strong>Order Date:</strong> {{ data_get($data, 'created_at')->format('Y-m-d H:i:s') }}</p>
    </div>

    <p>Thank you for your attention!</p>
</div>

<div class="footer">
    <p>&copy; {{ date('Y') }} Axilweb. All rights reserved.</p>
</div>

</body>
</html>
