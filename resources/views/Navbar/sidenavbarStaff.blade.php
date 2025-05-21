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

<body>
    <!-- SIDEBAR -->
    <div class="position-fixed h-100" id="sidebar" style="width: 260px; background-color: #0b573d !important; transition: all 0.3s ease;">
        <div class="d-flex flex-column h-100">
            <!-- Logo Section -->
            <div class="d-flex flex-column align-items-center mt-5">
                <img src="{{ asset('images/appicon.png') }}" alt="Profile Picture" class="rounded-circle w-75 mb-">
            </div>
            
            <div class="d-flex flex-column gap-3 px-2 mt-4">
                <a href="{{ route('staff.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.dashboard') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-tachometer-alt fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Dashboard</span>
                </a>
            
                <div class="dropdown w-100">
                    <a href="#" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-alt fs-5 icon-center"></i>
                        <span class="nav-text ms-3 font-paragraph">Reservations</span>
                        <i class="fas fa-chevron-down nav-text ms-auto"></i>
                    </a>
                    <ul class="dropdown-menu w-100 border-0 shadow" style="background-color: #0d6e4c !important;">
                        <li><a class="nav-link text-white p-2 font-paragraph" href="{{ route('staff.reservation') }}">Online Reservations</a></li>
                        <li><a class="nav-link text-white p-2 font-paragraph" href="{{ route('staff.walkIn')}}">Walk In Reservations</a></li>
                        <li><a class="nav-link text-white p-2 font-paragraph" href="{{ route('staff.accomodations')}}">Room Availability</a></li>
                    </ul>
                </div>
            
                <a href="{{ route ('staff.guests')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.guests') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-users fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Guests</span>
                </a>
                <a href="{{ route ('staff.damageReport')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.guests') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-clipboard-list fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Damage Report</span>
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
</body>
</html>
