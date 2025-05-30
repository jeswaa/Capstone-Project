<!DOCTYPE html>
<html>
<head>
    <title>Login OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #1a472a;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #e8f5e9;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(76, 175, 80, 0.2);
        }
        .header {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 30px;
        }
        .otp-code {
            background-color: #c8e6c9;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #1b5e20;
            margin: 20px 0;
        }
        .warning {
            color: #33691e;
            font-size: 14px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #81c784;
            text-align: center;
            font-size: 14px;
            color: #388e3c;
        }
        .message-container {
            background-color: #f1f8e9;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            border: 1px solid #c5e1a5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="background: linear-gradient(135deg, #059669, #047857); padding: 20px; border-radius: 8px; margin-bottom: 25px;">
            <h1 style="color: #ffffff; margin: 0; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Login OTP Verification</h1>
        </div>
        <p>Hello!</p>
        
        <p>You have requested to verify your login. Please use the following OTP code:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <div class="message-container">
            <p>This OTP will expire in <strong>10 minutes</strong>.</p>
        </div>
        
        <p class="warning">If you did not request this OTP, please ignore this email and ensure your account security.</p>
        
        <div class="footer">
            <p>Thank you for choosing Lelo's Resort</p>
            <p>- Lelo's Resort Team -</p>
        </div>
    </div>
</body>
</html>