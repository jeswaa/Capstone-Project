<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .nav-link {
        position: relative;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background: #ffffff;
        left: 0;
        bottom: 0;
        transition: width 0.3s ease-in-out;
    }
    
    .nav-link:hover::after {
        width: 100%;
    }
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.loginSucess')
    
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 color-background8 text-white position-sticky" id="sidebar" style="top: 0; height: 100vh; background-color: #0b573d background-color: #0b573d ">
            <div class="d-flex flex-column h-100">
                <!-- Logo Section -->
                <div class="d-flex flex-column align-items-center mt-5">
                    <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3 border border-5 border-white nav-link">
                    <p class="font-heading sidebar-text text-white" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;">Edit Profile</p>
                </div>
                
                <!-- Navigation Links -->
                <div class="d-flex flex-column gap-3 px-2 mt-4">
                    <a href="{{ route('staff.dashboard') }}" class="nav-link text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.dashboard') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                        <i class="fas fa-tachometer-alt fs-5"></i>
                        <span class="ms-3 font-paragraph">Dashboard</span>
                    </a>
                
                    <div class="dropdown w-100">
                        <a href="#" class="text-white nav-link text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar-alt fs-5 icon-center"></i>
                            <span class="nav-text ms-3 font-paragraph">Reservations</span>
                            <i class="fas fa-chevron-down nav-text ms-auto"></i>
                        </a>
                        <ul class="dropdown-menu w-100 border-0 shadow" style="background-color: #0d6e4c !important;">
                            <li><a class="nav-link text-white nav-link p-2 font-paragraph" href="{{ route('staff.reservation') }}">Reservations</a></li>
                            <li><a class="nav-link text-white nav-link p-2 font-paragraph" href="{{ route('staff.accomodations')}}">Room Availability</a></li>
                        </ul>
                    </div>
                
                    <a href="{{ route ('staff.guests')}}" class="text-white nav-link text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.guests') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                        <i class="fas fa-users fs-5 icon-center"></i>
                        <span class="nav-text ms-3 font-paragraph">Guests</span>
                    </a>
                </div>
            
                <div class="mt-auto mb-4 px-2">
                    <a href="{{ route('staff.logout')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link justify-content-end">
                        <span class="nav-text me-3 font-paragraph">Log Out</span>
                        <i class="fas fa-sign-out-alt fs-5 icon-center"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
         <div class="col-md-10 col-lg-10 py-4 px-4">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-end align-items-end mb-2">
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
            </div>

            <hr class="border-5">
            
            <!-- Welcome Message -->
            <div class="d-flex align-items-center">
                <p class="text-color-1 me-3" style="font-family: 'Anton', sans-serif;  font-size: 5rem;">Hello</p>
                <h1 class="fw-semibold text-capitalize" style="font-family: 'Anton', sans-serif;  font-size: 5rem; color: #0b573d;">{{ $staffCredentials->username }}!</h1>
            </div>

            <!-- Dashboard Cards -->
            <div class="row g-4 mt-2">
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
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('M d, Y') }}</small>
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
                                                <td>{{ $reservation->reservation_status }}</td>
                                                <td>
                                                    @if($reservation->reservation_status !== 'checked-in')
                                                        <a href="{{ route('staff.reservation') }}" 
                                                           class="text-decoration-none p-2 text-semibold color-background8 rounded text-white font-paragraph text-capitalize btn-sm"
                                                           style="transition: all 0.3s ease; display: inline-block;"
                                                           onmouseover="this.style.transform='scale(1.1)'; this.style.backgroundColor='#0d6e4c';"
                                                           onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='';">
                                                            View
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
            
            @push('scripts')
            <script>
                // Check-in functionality
                $('.check-in-btn').click(function() {
                    const reservationId = $(this).data('reservation-id');
                    $.ajax({
                        url: `/staff/reservation/${reservationId}/update-status`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            reservation_status: 'checked-in',
                            payment_status: 'paid'
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                });
            
                // Cancel functionality
                $('.confirm-cancel').click(function() {
                    const reservationId = $(this).data('reservation-id');
                    const formData = new FormData($(`#cancelForm${reservationId}`)[0]);
                    
                    $.ajax({
                        url: `/staff/reservation/${reservationId}/cancel-with-reason`,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                });
            </script>
            @endpush
        </div>
    </div>
    
    
</body>
</html>

