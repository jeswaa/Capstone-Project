<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <title>Staff Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .transition-width {
        transition: all 0.3s ease;
    }
    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.loginSucess')
    @include('Alert.notification')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
        @include('Navbar.sidenavbarStaff')
        <!-- Main Content -->
        <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="ms-auto">
                    <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill">
                </div>
            </div>
            

            <hr class="border-5">
            
            <!-- Welcome Message -->
            <div class="d-flex align-items-center">
                <p class="text-color-1 me-3" style="font-family: 'Anton', sans-serif;  font-size: 5rem; letter-spacing: 10px;">Hello</p>
                <h1 class="text-capitalize" style="font-family: 'Anton', sans-serif; font-size: 5rem; color: #0b573d; letter-spacing: 15px;">{{ $staffCredentials->username }}!</h1>
            </div>

            <!-- Dashboard Cards -->
            <div class="row g-4">
                <!-- Column 1: Total Reservations and Checked-in Guests -->
                <div class="col-md-4">
                    <!-- Total Reservations -->
                    <div class="p-3 rounded-4 d-flex align-items-center gap-3 mb-4" style="background-color: #0b573d;">
                        <div class="d-flex flex-column">
                            <h1 class="fs-1 fw-bold text-white mb-0">{{$pendingReservations ?? 0}}</h1>
                            <p class="text-white mb-0 font-paragraph">Pending<br>Reservations</p>
                        </div>
                        <i class="fas fa-clock fs-1 text-white ms-auto"></i>
                    </div>
                
                    <!-- Checked-in Guests -->
                    <div class="p-3 rounded-4 d-flex align-items-center gap-3" style="background-color: #0b573d;">
                        <div class="d-flex flex-column">
                            <h1 class="fs-1 fw-bold text-white mb-0">{{ $checkedInGuests ?? 0}}</h1>
                            <p class="text-white mb-0 font-paragraph">Checked-in<br>Guests</p>
                        </div>
                        <i class="fas fa-user-check fs-1 text-white ms-auto"></i>
                    </div>
                </div>
            
                <!-- Column 2: Pending Payments and Available Accommodations -->
                <div class="col-md-4">
                    <!-- Pending Payments -->
                    <div class="p-3 rounded-4 d-flex align-items-center gap-3 mb-4" style="background-color: #0b573d;">
                        <div class="d-flex flex-column">
                            <h1 class="fs-1 fw-bold text-white mb-0">{{ $availableAccommodations ?? 0 }}</h1>
                            <p class="text-white mb-0 font-paragraph">Total Rooms<br>Availble</p>
                        </div>
                        <i class="fas fa-bed fs-1 text-white ms-auto"></i>
                    </div>
            
                    <!-- Available Accommodations -->
                    <div class="p-3 rounded-4 d-flex align-items-center gap-3" style="background-color: #0b573d;">
                        <div class="d-flex flex-column">
                            <h1 class="fs-1 fw-bold text-white mb-0">{{ $checkedOutGuests ?? 0 }}</h1>
                            <p class="text-white mb-0 font-paragraph">Check-outs<br>Today</p>
                        </div>
                        <i class="fas fa-sign-out-alt fs-1 text-white ms-auto"></i>
                    </div>
                </div>
            
                <!-- Column 3: Pending Bookings -->
                <div class="col-md-4">
                    <div class="p-4 rounded-4 border border-4" style="border-color: #0b573d !important;  background-color: white; height:280px;">
                        <h2 class="font-heading mb-1" style="color: #0b573d;">Pending Bookings</h2>
                        @if($pendingReservationsList && count($pendingReservationsList) > 0)
                            <div class="overflow-auto" style="max-height: 300px;">
                                @foreach($pendingReservationsList as $reservation)
                                    <div class="d-flex align-items-center justify-content-between mb-1 p-1 border-bottom">
                                        <div>
                                            <p class="mb-0 font-paragraph fw-bold">{{ $reservation->guest_name }}</p>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}</small>
                                        </div>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-secondary font-paragraph fst-italic">No pending reservations.</p>
                        @endif
                    </div>
                </div>
            <!-- After the Pending Bookings Section -->
            <div class="mt-4">
                <div class="card border-2" style="border-color: #0b573d !important;">
                    <div class="card-header bg-white">
                        <h2 class="font-heading mb-0" style="color: #0b573d;">Today's Reservations</h2>
                    </div>
                    <div class="card-body">
                        @if($todayReservations->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Room</th>
                                            <th>Room Type</th>
                                            <th>Guest Name</th>
                                            <th>Arrival Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($todayReservations as $reservation)
                                            <tr>
                                                <td>{{ $reservation->room_numbers }}</td>
                                                <td>{{ $reservation->accomodation_name}}</td>
                                                <td>{{ $reservation->guest_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('h:i A') }}</td>
                                                <td class="text-capitalize badge mt-2" style="background-color: {{ $reservation->reservation_status === 'checked-in' ? '#0b573d' : ($reservation->reservation_status === 'pending' ? '#ffc107' : '#dc3545') }}">{{ $reservation->reservation_status }}</td>
                                                <td>
                                                    @if($reservation->reservation_status !== 'checked-in')
                                                        <a href="{{ route('staff.reservation') }}" 
                                                           class="text-decoration-none p-2 text-semibold color-background8 rounded text-white font-paragraph text-capitalize btn-sm"
                                                           style="transition: all 0.3s ease; display: inline-block;"
                                                           onmouseover="this.style.transform='scale(1.1)'; this.style.backgroundColor='#0d6e4c';"
                                                           onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='';">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-secondary font-paragraph fst-italic">No reservations for today.</p>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    </div>
    
    
</body>
</html>
