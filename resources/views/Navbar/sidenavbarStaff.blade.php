<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
     #sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
    }
</style>
<body>
    <!-- SIDEBAR -->
    <div class="col-12 col-md-3 sidebar" id="sidebar">
                <div class="d-flex flex-column ms-5 mt-5">
                    <h1 class="text-color-1 font-heading sidebar-text" id="resort-name"><span>LELO'S RESORT</span></h1>
                    
                    <!-- Collapsible Sidebar Links -->
                    <a href="{{ route('staff.dashboard') }}" class="color-3 d-flex align-items-center p-4 rounded-md text-decoration-none text-hoverStaff font-paragraph fw-semibold hover:color-background3 mt-2" id="dashboard-link">
                        <i class="fa-tachometer-alt fas fs-4 pe-3"></i> <!-- Icon for Dashboard -->
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    <div class="dropdown w-full">
                        <a href="#" class="color-3 d-flex align-items-center p-4 rounded-md text-decoration-none text-hoverStaff w-full duration-300 ease-in-out font-paragraph fw-semibold hover:color-background1 mt-2 transition" id="reservations-link" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-calendar-alt fas fs-4 pe-3"></i> <!-- Icon for Reservations -->
                            <span class="sidebar-text">Reservations</span>
                        </a>
                        <ul class="dropdown-menu w-100" aria-labelledby="reservations-link">
                            <li><a class="dropdown-item w-100" href="{{ route('staff.reservation') }}">Reservations</a></li>
                            <li><a class="dropdown-item w-100" href="{{ route('staff.accomodations')}}">Room Availability</a></li>
                        </ul>
                    </div>
                    <a href="{{ route ('staff.guests')}}" class="color-3 d-flex align-items-center p-4 rounded-md text-decoration-none text-hoverStaff font-paragraph fw-semibold hover:color-background1 mt-2" id="guests-link">
                        <i class="fa-users fas fs-4 pe-3"></i> <!-- Icon for Guests -->
                        <span class="sidebar-text">Guests</span>
                    </a>
                    <a href="{{ route('staff.transactions') }}" class="color-3 d-flex align-items-center p-4 rounded-md text-decoration-none text-hoverStaff font-paragraph fw-semibold hover:color-background1 mt-2" id="transactions-link">
                        <i class="fa-credit-card fas fs-4 pe-3"></i> <!-- Icon for Transactions -->
                        <span class="sidebar-text">Transactions</span>
                    </a>
                    </a>
                    <a href="{{ route('staff.logout')}}" class="color-3 d-flex align-items-center p-4 rounded-md text-decoration-none text-hoverStaff font-paragraph fw-semibold hover:color-background1 mt-2" id="logout-link">
                        <i class="fa-sign-out-alt fas fs-4 pe-3"></i> <!-- Icon for Logout -->
                        <span class="sidebar-text">Logout</span>
                    </a>
                </div>
            </div>
</body>
</html>
