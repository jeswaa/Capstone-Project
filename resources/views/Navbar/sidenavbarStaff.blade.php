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
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f4f6f8;
    margin: 0;
}

/* Sidebar Base */
#sidebar {
    transition: all 0.3s ease;
    overflow-x: hidden;
    height: 100vh;
    background: linear-gradient(180deg, #1c2e2a, #0d5c4d);
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
}

/* Expanded/Collapsed Width */
.sidebar-expanded {
    width: 260px;
}
.sidebar-collapsed {
    width: 70px;
}

/* Sidebar Content Animation */
#sidebar .sidebar-content {
    transition: opacity 0.3s ease, transform 0.3s ease;
    opacity: 1;
}
#sidebar.sidebar-collapsed .sidebar-content {
    opacity: 0;
    transform: translateX(-20px);
    pointer-events: none;
}

/* Toggle Button */
#toggleSidebar {
    font-size: 1.3rem;
    margin-left: auto;
    margin-right: 15px;
    display: block;
    background: rgba(255, 255, 255, 0.08);
    border: none;
    padding: 8px 10px;
    border-radius: 8px;
    backdrop-filter: blur(8px);
    transition: background 0.3s ease, transform 0.2s ease;
}
#toggleSidebar:hover {
    background: rgba(255, 255, 255, 0.15);
}
#toggleSidebar i {
    transition: transform 0.3s ease;
}
#toggleSidebar:hover i:not(.fa-arrow-right) {
    transform: rotate(90deg);
}

/* Logo Image */
#sidebar img {
    border: 3px solid rgba(255, 255, 255, 0.2);
    padding: 3px;
    border-radius: 50%;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s ease;
}
#sidebar img:hover {
    transform: scale(1.05);
}

/* Navigation Links */
.nav-link {
    position: relative;
    display: flex;
    align-items: center;
    padding: 12px 15px;
    border-radius: 10px;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    gap: 12px;
    color: white;
}
.nav-link i {
    min-width: 20px;
    text-align: center;
    font-size: 1.1rem;
}
.nav-link span {
    white-space: nowrap;
}

/* Hover/Active Styles */
.nav-link:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateX(5px);
}
.nav-link.active {
    background: rgba(255, 255, 255, 0.25);
    font-weight: 600;
    box-shadow: inset 0 0 6px rgba(255,255,255,0.2);
}

/* Underline Animation */
.nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: #ffffff;
    left: 0;
    bottom: 6px;
    transition: width 0.3s ease-in-out;
}
.nav-link:hover::after {
    width: 100%;
}

/* Dropdown Menu */
.dropdown-menu {
    background: rgba(18, 76, 66, 0.95) !important;
    border-radius: 8px;
    overflow: hidden;
    animation: fadeIn 0.3s ease;
    backdrop-filter: blur(6px);
}
.dropdown-menu .dropdown-item {
    color: white !important;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
}
.dropdown-menu .dropdown-item:hover {
    background-color: rgba(255, 255, 255, 0.15);
}
.dropdown-menu .dropdown-item.active {
    background-color: rgba(255, 255, 255, 0.25);
}

/* Logout Styling */
.nav-link.logout {
    margin-top: auto;
    background-color: rgba(255, 255, 255, 0.08);
}
.nav-link.logout:hover {
    background-color: rgba(255, 255, 255, 0.18);
}

/* Animation for Dropdown */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>


<body>
    <!-- SIDEBAR -->
    <div id="sidebar" class="color-background8 text-white py-3 position-sticky sidebar-expanded" style="top: 0; height: 100vh;">
        <!-- Toggle Button (Always Visible) -->
        <div class="d-flex justify-content-end">
            <button id="toggleSidebar" class="btn btn-link text-white" type="button">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div id="sidebarContent" class="sidebar-content px-2">
            <!-- Logo Section -->
            <div class="d-flex flex-column align-items-center mt-5">
                <img src="{{ asset('images/logo2.png') }}" alt="Profile Picture" class="rounded-circle" width="120px">
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
                        <i class="fas fa-chevron-down nav-text ms-auto" style="font-size:10px;"></i>
                    </a>
                    <ul class="dropdown-menu w-100 border-0 shadow">
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

                <a href="{{ route('staff.logout')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link">
                    <i class="fas fa-sign-out-alt fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Log Out</span>
                </a>

            </div>
        </div>
    </div>
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const icon = toggleBtn.querySelector('i');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('sidebarContent');

    // Sidebar toggle click
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar-collapsed');

        if (sidebar.classList.contains('sidebar-collapsed')) {
            content.style.display = 'none';
        } else {
            content.style.display = 'block';
        }
    });

    // Hover effect with condition
    toggleBtn.addEventListener('mouseenter', () => {
        if (sidebar.classList.contains('sidebar-collapsed')) {
            icon.classList.remove('fa-bars', 'fa-times');
            icon.classList.add('fa-arrow-right');
        } else {
            icon.classList.remove('fa-bars', 'fa-arrow-right');
            icon.classList.add('fa-times');
        }
    });

    toggleBtn.addEventListener('mouseleave', () => {
        if (!sidebar.classList.contains('sidebar-collapsed')) {
            icon.classList.remove('fa-times', 'fa-arrow-right');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-times', 'fa-arrow-right');
            icon.classList.add('fa-bars');
        }
    });
</script>


</body>
</html>
