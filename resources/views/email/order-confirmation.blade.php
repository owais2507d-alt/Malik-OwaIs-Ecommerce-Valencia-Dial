<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Valencia Dial</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #0b0b0c; padding: 40px 20px; color: #ffffff; margin: 0;">
    <div style="max-width: 500px; margin: 0 auto; background-color: #121214; padding: 40px; border: 1px solid #242427; text-align: center;">
        
        <h1 style="font-family: 'Playfair Display', serif; color: #d4af37; font-size: 24px; letter-spacing: 0.3em; margin-bottom: 5px; font-weight: bold; text-transform: uppercase;">VALENCIA DIAL</h1>
        <div style="width: 50px; height: 1px; background-color: rgba(212, 175, 55, 0.4); margin: 0 auto 30px auto;"></div>
        
        <h2 style="color: #ffffff; font-size: 14px; text-transform: uppercase; letter-spacing: 0.15em; font-weight: 300; margin-bottom: 20px;">Order Confirmed</h2>
        
        <p style="color: #a8a29e; font-size: 13px; font-weight: 300; line-height: 1.6; margin-bottom: 30px;">
            Thank you for your purchase, {{ $order->user->name ?? 'Valued Client' }}.<br>
            Your order <strong style="color: #d4af37;">#{{ $order->id }}</strong> has been placed successfully.
        </p>

        <div style="background-color: #18181b; border: 1px solid #2e2e33; padding: 20px; margin: 20px 0; text-align: left;">
            <p style="color: #a8a29e; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; margin: 0 0 10px 0;">Order Summary</p>
            <p style="color: #ffffff; font-size: 13px; margin: 5px 0;">Total: <strong style="color: #d4af37;">${{ number_format($order->total, 2) }}</strong></p>
            <p style="color: #a8a29e; font-size: 12px; margin: 5px 0;">Status: {{ ucfirst($order->order_status) }}</p>
            <p style="color: #a8a29e; font-size: 12px; margin: 5px 0;">Payment: {{ ucfirst($order->payment_method) }}</p>
        </div>
        
        <div style="margin-top: 40px; border-top: 1px solid #242427; padding-top: 20px;">
            <p style="color: #57534e; font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; margin: 0;">Excellence In Time & Technology</p>
        </div>
    </div>
</body>
</html>