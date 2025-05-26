<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservations - Lelo's Resort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        h1, h5 { font-family: 'Anton', sans-serif; }
        body, p, h6, li, span { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body style="background-image: url('{{ asset('images/logosheesh.png') }}'); 
    background-size: cover; 
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    min-height: 100vh;
    width: 100%;
    overflow-x: hidden;">

    <div class="w-100 d-flex justify-content-between align-items-center p-3">
        <!-- Back Button -->
        <a href="{{ route('homepage') }}" class="d-flex align-items-center justify-content-center rounded-circle shadow ms-3"
           style="width: 50px; height: 50px; background-color: #0B5D3B; text-decoration: none;">
            <i class="fa-solid fa-arrow-left text-white"></i>
        </a>

        <!-- Logo -->
        <a class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" class="rounded-pill" style="width: 100px; height: auto;">
        </a>
    </div>


<div class="container py-5" style="background-color: rgba(255, 255, 255, 0.95); border-radius: 2px;">
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