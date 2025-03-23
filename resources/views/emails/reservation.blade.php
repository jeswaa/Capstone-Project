<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
<body>
    <p>{{ $messageContent }}</p>

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
        <p>Date: {{ $reservationDetails->reservation_check_in_date }}</p>
        <p>Check-in: {{ $reservationDetails->reservation_check_in }}</p>
    @endif
</body>
</html>
