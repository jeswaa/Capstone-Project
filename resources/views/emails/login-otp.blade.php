<!DOCTYPE html>
<html>
<head>
    <title>Login OTP Verification</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #1a5f7a;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 600;
            margin: 0;
        }
        .otp-code {
            background: linear-gradient(135deg, #86B6F6, #176B87);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #ffffff;
            margin: 25px 0;
            letter-spacing: 5px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .warning {
            color: #dc3545;
            font-size: 14px;
            margin-top: 25px;
            padding: 15px;
            background-color: #fff3f3;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eef2f7;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }
        p {
            color: #475569;
            font-size: 16px;
        }
        strong {
            color: #1a5f7a;
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
            <p style="color: #1a5f7a; font-weight: 600;">- Lelo's Resort Team -</p>
        </div>
    </div>
</body>
</html>