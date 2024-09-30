<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Order Confirmation</title>
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
    <h1>Pre-Order Confirmation</h1>
</div>

<div class="content">
    <p>Dear {{  data_get($data, 'customer_name') }},</p>
    <p>Thank you for your pre-order! We are excited to inform you that your pre order has been successfully received.</p>

    <div class="order-details">
        <h3>Your Pre-Order Details</h3>
        <p><strong>Order ID:</strong> {{ data_get($data, 'id') }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format(data_get($data, 'total'), 2) }}</p>
        <p><strong>Order Date:</strong> {{ data_get($data, 'created_at')->format('Y-m-d H:i:s') }}</p>
    </div>

    <p>If you have any questions regarding your pre-order, please feel free to reach out to us.</p>
    <p>Thank you for choosing us!</p>
</div>

<div class="footer">
    <p>&copy; {{ date('Y') }} Axilweb. All rights reserved.</p>
</div>

</body>
</html>
