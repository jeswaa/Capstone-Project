<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation Alert</title>
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
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 30px;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 15px;
        }
        .highlight {
            font-weight: 600;
            color: #059669;
        }
        .btn {
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
        <h2>New Reservation at Lelo's Resort</h2>
    </div>

    <div class="content">
        <p><span class="highlight">Guest Name:</span> {{ $reservation->name }}</p>
        <p><span class="highlight">Email:</span> {{ $reservation->email }}</p>
        <p><span class="highlight">Check-in Date:</span> {{ $reservation->reservation_check_in_date }}</p>
        <p><span class="highlight">Check-out Date:</span> {{ $reservation->reservation_check_out_date }}</p>
        <p><span class="highlight">Number of Guests:</span> {{ $reservation->total_guest }}</p>
        <p><span class="highlight">Payment Method:</span> {{ ucfirst($reservation->payment_method) }}</p>
        <p><span class="highlight">Amount Paid:</span> {{($reservation->amount) }}</p>
        <p><span class="highlight">Payment Status:</span> {{ ucfirst($reservation->payment_status) }}</p>
        
        <div class="divider"></div>
        
        <a href="{{ url('/staff/reservation-details') }}" class="btn">View Reservation</a>
    </div>

    <div class="footer">
        <p>Thank you,</p>
        <p><strong>Lelo's Resort</strong></p>
    </div>
</div>

</body>
</html>
