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
    #mainContent {
        transition: margin-left 0.3s ease;
        width: 100%;
    }
    .sidebar-text.active,
    .d-flex.align-items-center.text-underline-left-to-right.active {
        background-color: rgba(255, 255, 255, 0.1); /* Light background color */
        border-radius: 5px; /* Optional: Add rounded corners */
        padding: 10px;
    }
    .dropdown-menu .dropdown-item.active {
        background-color: #0b573d; /* Darker background color for active dropdown item */
        color: white !important; /* Ensure text color is white */
    }
    #sidebar.sidebar-collapsed {
        width: 40px !important;
    }

    #sidebar.sidebar-collapsed .sidebar-content {
        display: none;
    }
    #sidebar {
        transition: all 0.3s ease;
        overflow-x: hidden;
        height: 100vh;
        background-color: #0b573d;
    }

    .sidebar-expanded {
        width: 290px;
    }

    .sidebar-collapsed {
        width: 60px;
    }

    #sidebar .sidebar-content {
        transition: opacity 0.3s ease;
        opacity: 1;
    }

    #sidebar.sidebar-collapsed .sidebar-content {
        opacity: 0;
        pointer-events: none;
    }
</style>

<body>
    <!-- SIDEBAR -->
    <div id="sidebar" class="color-background8 text-white py-3 position-sticky sidebar-expanded" style="top: 0; height: 100vh; background-color: #0b573d">
        <!-- Toggle Button (Always Visible) -->
        <button id="toggleSidebar" class="btn btn-link text-white d-block " type="button">
            <i class="fas fa-bars"></i>
        </button>
        <div id="sidebarContent" class="sidebar-content px-2">
            <!-- Logo Section -->
            <div class="d-flex flex-column align-items-center mt-5">
                <img src="{{ asset('images/appicon.png') }}" alt="Profile Picture" class="rounded-circle" width="120px">
            </div>
            
            <div class="d-flex flex-column gap-3 px-2 mt-4 mb-5">
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
            
                <a href="{{ route('staff.guests') }}"
                class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.guests') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-users fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Guests</span>
                </a>

                <a href="{{ route('staff.damageReport') }}"
                class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.damageReport') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-clipboard-list fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Damage Report</span>
                </a>

            </div>
        
            <div class="mt-5">
                <a href="{{ route('staff.logout')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link justify-content-end">
                    <span class="nav-text me-3 font-paragraph">Log Out</span>
                    <i class="fas fa-sign-out-alt fs-5 icon-center"></i>
                </a>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('sidebarContent');

        sidebar.classList.toggle('sidebar-collapsed');

        if (sidebar.classList.contains('sidebar-collapsed')) {
            content.style.display = 'none';
        } else {
            content.style.display = 'block';
        }
    });
</script>
</body>
</html>
