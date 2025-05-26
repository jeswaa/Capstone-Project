<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservations - Lelo's Resort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="text-start ms-5 mt-4">
        <a href="{{ route('homepage') }}" class="btn btn-success" style="background-color: #0b573d;">
            <i class="bi bi-arrow-left"></i> Back to Homepage
        </a>
    </div>
    <div class="container py-5">
        <h1 class="text-center mb-4" style="color: #0b573d;">Your Reservations</h1>

        @if($reservations->isEmpty())
            <div class="text-center">
                <p class="lead">You don't have any previous reservations.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($reservations as $reservation)
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0" style="border-radius: 15px;">
                            <div class="card-header bg-success text-white" style="background-color: #0b573d !important; border-radius: 15px 15px 0 0;">
                                <h5 class="mb-0">Reservation #{{ $reservation->id }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Check-in Date:</h6>
                                        <p class="mb-0">{{ date('F d, Y', strtotime($reservation->reservation_check_in_date)) }}</p>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Check-in Time:</h6>
                                        <p class="mb-0">{{ date('h:i A', strtotime($reservation->reservation_check_in)) }}</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Check-out Date:</h6>
                                        <p class="mb-0">{{ $reservation->reservation_check_out_date ? date('F d, Y', strtotime($reservation->reservation_check_out_date)) : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Check-out Time:</h6>
                                        <p class="mb-0">{{ date('h:i A', strtotime($reservation->reservation_check_out)) }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="mb-1">Rooms:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($reservation->accommodations as $accommodation)
                                            <li>{{ $accommodation }} x {{ $reservation->quantity }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="mb-3">
                                    <h6 class="mb-1">Guests:</h6>
                                    <p class="mb-0">Adults: {{ $reservation->number_of_adults }} | Children: {{ $reservation->number_of_children }}</p>
                                </div>

                                <div class="mb-3">
                                    <h6 class="mb-1">Status:</h6>
                                    <span class="badge bg-{{ $reservation->reservation_status === 'pending' ? 'warning' : ($reservation->reservation_status === 'confirmed' ? 'success' : 'danger') }}">
                                        {{ ucfirst($reservation->reservation_status) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Total Amount:</h6>
                                    <span class="badge bg-success fs-6" style="background-color: #0b573d !important;">
                                        ₱{{ number_format($reservation->amount, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>