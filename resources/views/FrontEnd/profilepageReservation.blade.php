<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        h1,
        h5 {
            font-family: 'Anton', sans-serif;
        }

        body,
        p,
        h6,
        li,
        span {
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            font-size: 1.1rem;
            color: #555;
        }

        .no-reservations {
            font-size: 1.2rem;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Reservation Summary</h5>
                        @if ($reservations->count() > 0)
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-text"><strong>Name:</strong> {{ $reservations->first()->name }}</p>
                                    <p class="card-text"><strong>Email:</strong> {{ $reservations->first()->email }}</p>
                                    <p class="card-text"><strong>Phone:</strong>
                                        {{ $reservations->first()->mobileNo ?? 'N/A' }}</p>

                                    @if ($reservations->first()->package_name)
                                        <p class="card-text"><strong>Package:</strong>
                                            {{ $reservations->first()->package_name }}</p>
                                    @endif
                                    <p class="card-text"><strong>Check-in:</strong>
                                        {{ $reservations->first()->reservation_check_in }}</p>
                                    <p class="card-text"><strong>Check-out:</strong>
                                        {{ $reservations->first()->reservation_check_out }}</p>
                                    <p class="card-text"><strong>Room Type:</strong>
                                        {{ $reservations->first()->room_preference ?? $reservations->first()->package_room_type ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text"><strong>Number of Guests:</strong>
                                        {{ $reservations->first()->total_guest }}</p>
                                    <p class="card-text"><strong>Special Request:</strong>
                                        {{ $reservations->first()->special_request ?? 'No special request' }}</p>
                                    <p class="card-text"><strong>Payment Status:</strong>
                                        {{ $reservations->first()->payment_status }}</p>
                                </div>
                            </div>
                        @else
                            <p class="no-reservations text-center">No reservations found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>