<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reservation Summary</h2>

        <!-- Display error message if no reservations are found -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Display reservation details if available -->
        @if(isset($reservationDetails))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reservation ID: {{ $reservationDetails->id }}</h5>
                            <p><strong>Name:</strong> {{ $reservationDetails->name }}</p>
                            <p><strong>Email:</strong> {{ $reservationDetails->email }}</p>
                            <p><strong>Mobile No:</strong> {{ $reservationDetails->mobileNo }}</p>
                            <p><strong>Number of Guests:</strong> {{ $reservationDetails->number_of_guests }}</p>
                            <p><strong>Address:</strong> {{ $reservationDetails->address }}</p>
                            <p><strong>Room Preference:</strong> {{ $reservationDetails->room_preference }}</p>
                            <p><strong>Activities:</strong> {{ $reservationDetails->activities }}</p>
                            <p><strong>Reservation Date:</strong> {{ $reservationDetails->reservation_date }}</p>
                            <p><strong>Reservation Time:</strong> {{ $reservationDetails->reservation_check_in }}</p>
                            <p><strong>Check-out Time:</strong> {{ $reservationDetails->reservation_check_out }}</p>
                            <p><strong>Special Request:</strong> {{ $reservationDetails->special_request }}</p>
                            <p><strong>Payment Method:</strong> {{ $reservationDetails->payment_method }}</p>
                            <p><strong>Amount:</strong> {{ $reservationDetails->amount }}</p>
                            <p><strong>Reference Number:</strong> {{ $reservationDetails->reference_num }}</p>
                            @if ($reservationDetails->upload_payment)
                                <p><strong>Payment Proof:</strong> 
                                    <a href="{{ route('payment.proof', ['filename' => basename($reservationDetails->upload_payment)]) }}" target="_blank">
                                        View Proof
                                    </a>
                                </p>
                            @endif
                            <p><strong>Status:</strong> 
                                {{ $reservationDetails->payment_status }} 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Display a message if no reservations exist -->
            <div class="alert alert-warning">
                It looks like you don't have any reservations yet.
            </div>
        @endif
    </div>
</body>
</html>
