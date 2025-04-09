<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reservation Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-top: 20px;
            font-size: 16px;
        }
        .content p {
            line-height: 1.6;
        }
        .content .highlight {
            font-weight: bold;
            color: #007bff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
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
        
        <p><a href="{{ url('/staff/reservation-details') }}" class="btn">View Reservation</a></p>
    </div>

    <div class="footer">
        <p>Thank you,</p>
        <p><strong>Lelo's Resort</strong></p>
    </div>
</div>

</body>
</html>