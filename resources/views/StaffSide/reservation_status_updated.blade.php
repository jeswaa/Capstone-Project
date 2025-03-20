<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status Updated</title>
</head>
<body>
    <h2>Hello {{ $reservation->name }},</h2>
    <p>Mobile No: {{ $reservation->mobileNo }}</p>
    <p>Address: {{ $reservation->address }}</p>
    <h5>Message from Lelo's Resort:</h5>
    <p><strong>Status:</strong> {{ $reservation->payment_status }}</p>
    <p><strong>Amount:</strong> {{ ($reservation->amount) }}</p>
    <p><strong>Balance:</strong> ₱ {{ number_format($balance, 2) }}</p> <!-- Use computed balance -->
    @if($reservationDetails)
        <p><strong>Reservation Details:</strong></p>
        @if(isset($reservationDetails->package_name))
            <p>Package: {{ $reservationDetails->package_name }}</p>
        @endif
        @if(isset($reservationDetails->room_preference))
            <p>Room: {{ $reservationDetails->room_preference }}</p>
        @endif
        @if(isset($reservationDetails->activities) && is_array($reservationDetails->activities))
            <p>Activities: {{ implode(', ', $reservationDetails->activities) }}</p>
        @endif
        <p><strong>Date:</strong> {{ $reservationDetails->reservation_check_in_date }}</p>
        <p><strong>Check-in:</strong> {{ $reservationDetails->reservation_check_in }}</p>
    @endif

    
    <p>{{ $customMessage }}</p>

    <p>Thank you for choosing Lelo's Resort!</p>
</body>
</html>
