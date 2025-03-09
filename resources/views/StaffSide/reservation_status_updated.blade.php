<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status Updated</title>
</head>
<body>
    <h2>Hello {{ $reservation->name }},</h2>
    <p>Your reservation status has been updated.</p>
    <p><strong>Status:</strong> {{ $reservation->payment_status }}</p>
    
    <h3>Message from Lelo's Resort:</h3>
    <p>{{ $customMessage }}</p>

    <p>Thank you for choosing Lelo's Resort!</p>
</body>
</html>
