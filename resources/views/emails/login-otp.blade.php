<!DOCTYPE html>
<html>
<head>
    <title>Login OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .otp-code {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }
        .warning {
            color: #721c24;
            font-size: 14px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login OTP Verification</h1>
        </div>
        
        <p>Hello!</p>
        
        <p>You have requested to verify your login. Please use the following OTP code:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <p>This OTP will expire in <strong>10 minutes</strong>.</p>
        
        <p class="warning">If you did not request this OTP, please ignore this email and ensure your account security.</p>
        
        <div class="footer">
            <p>Thank you for choosing Lelo's Resort</p>
            <p>- Lelo's Resort Team -</p>
        </div>
    </div>
</body>
</html>