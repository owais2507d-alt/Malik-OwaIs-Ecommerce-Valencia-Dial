<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Account</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #0b0b0c; padding: 40px 20px; color: #ffffff; margin: 0;">
    <div style="max-width: 500px; margin: 0 auto; background-color: #121214; padding: 40px; border: 1px solid #242427; text-align: center;">
        
        <h1 style="font-family: 'Playfair Display', serif; color: #d4af37; font-size: 24px; letter-spacing: 0.3em; margin-bottom: 5px; font-weight: bold; text-transform: uppercase;">VALENCIA DIAL</h1>
        <div style="width: 50px; height: 1px; background-color: rgba(212, 175, 55, 0.4); margin: 0 auto 30px auto;"></div>
        
        <h2 style="color: #ffffff; font-size: 14px; text-transform: uppercase; letter-spacing: 0.15em; font-weight: 300; margin-bottom: 20px;">Security Verification Code</h2>
        
        <p style="color: #a8a29e; font-size: 13px; font-weight: 300; line-height: 1.6; margin-bottom: 30px;">
            Hello {{ $user->name }},<br>
            Thank you for registering. Please use the following One-Time Password (OTP) to verify and activate your premium account:
        </p>
        
        <div style="font-size: 32px; font-weight: 300; letter-spacing: 0.4em; color: #d4af37; margin: 30px 0; background-color: #18181b; padding: 15px; border: 1px solid #2e2e33; text-indent: 0.4em;">
            {{ $otp }}
        </div>
        
        <p style="color: #78716c; font-size: 11px; tracking-wide: 0.1em; margin-top: 30px; text-transform: uppercase;">
            This code is confidential and valid for a limited time.
        </p>
        
        <div style="margin-top: 40px; border-top: 1px solid #242427; padding-top: 20px;">
            <p style="color: #57534e; font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; margin: 0;">Excellence In Time & Technology</p>
        </div>
    </div>
</body>
</html>