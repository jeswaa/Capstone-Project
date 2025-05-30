<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f0fff4;
            margin: 0;
            padding: 0;
            color: #334155;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 128, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #059669, #047857);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 30px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-height: 50px;
        }
        p {
            margin-bottom: 20px;
            font-size: 15px;
        }
        .otp-container {
            margin: 30px 0;
            text-align: center;
        }
        .otp {
            display: inline-block;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 5px;
            color: #059669;
            background-color: #ecfdf5;
            padding: 15px 25px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .note {
            font-size: 14px;
            color: #047857;
            text-align: center;
            margin: 25px 0;
        }
        .button {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 12px 0;
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
        }
        .footer {
            background-color: #ecfdf5;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #047857;
        }
        .social-icons {
            margin: 15px 0;
        }
        .social-icons a {
            margin: 0 8px;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #d1fae5;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verification</h1>
        </div>
        
        <div class="content">
            
            <p>Hello,</p>
            <p>Please use the following One-Time Password (OTP) to verify your identity:</p>
            
            <div class="otp-container">
                <div class="otp">{{ $otp }}</div>
            </div>
            
            <p class="note">This OTP is valid for 5 minutes. Do not share this code with anyone.</p>
            
            <div class="divider"></div>
            
            <p>If you didn't request this OTP, please ignore this email or contact our support team immediately.</p>
            
            <p>Thank you!</p>
        </div>
        
        <div class="footer">
            <p>© 2025 Lelo's Resort. All rights reserved.</p>
            <p>Laur, Nueva Ecija</p>
        </div>
    </div>
</body>
</html>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background-color: #f0fff4;
        margin: 0;
        padding: 0;
        color: #334155;
        line-height: 1.6;
    }
    .container {
        width: 100%;
        max-width: 600px;
        margin: 30px auto;
        background-color: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 128, 0, 0.08);
    }
    .header {
        background: linear-gradient(135deg, #059669, #047857);
        padding: 30px 20px;
        text-align: center;
        color: white;
    }
    h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .content {
        padding: 30px;
    }
    .logo {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo img {
        max-height: 50px;
    }
    p {
        margin-bottom: 20px;
        font-size: 15px;
    }
    .otp-container {
        margin: 30px 0;
        text-align: center;
    }
    .otp {
        display: inline-block;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: 5px;
        color: #059669;
        background-color: #ecfdf5;
        padding: 15px 25px;
        border-radius: 8px;
        margin: 10px 0;
    }
    .note {
        font-size: 14px;
        color: #047857;
        text-align: center;
        margin: 25px 0;
    }
    .button {
        display: block;
        width: 200px;
        margin: 30px auto;
        padding: 12px 0;
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
    }
    .footer {
        background-color: #ecfdf5;
        padding: 20px;
        text-align: center;
        font-size: 13px;
        color: #047857;
    }
    .social-icons {
        margin: 15px 0;
    }
    .social-icons a {
        margin: 0 8px;
        text-decoration: none;
    }
    .divider {
        height: 1px;
        background-color: #d1fae5;
        margin: 20px 0;
    }
</style>