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
<body>
    <!-- SIDEBAR -->
    <div class="col-md-3 col-12 sidebar" id="sidebar">
                <div class="d-flex flex-column ms-5 mt-5">
                    <h1 class="text-color-1 font-heading sidebar-text" id="resort-name"><span>LELO'S RESORT</span></h1>
                    
                    <!-- Collapsible Sidebar Links -->
                    <a href="{{ route('staff.dashboard') }}" class="fw-semibold p-4 mt-2 color-3 hover:color-background3 font-paragraph rounded-md text-hoverStaff text-decoration-none d-flex align-items-center" id="dashboard-link">
                        <i class="fas fa-tachometer-alt pe-3 fs-4"></i> <!-- Icon for Dashboard -->
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    <a href="{{ route('staff.reservation') }}" class="fw-semibold p-4 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hoverStaff transition duration-300 ease-in-out text-decoration-none d-flex align-items-center" id="reservations-link">
                        <i class="fas fa-calendar-alt pe-3 fs-4"></i> <!-- Icon for Reservations -->
                        <span class="sidebar-text">Reservations</span>
                    </a>
                    <a href="{{ route ('staff.guests')}}" class="fw-semibold p-4  mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hoverStaff text-decoration-none d-flex align-items-center" id="guests-link">
                        <i class="fas fa-users pe-3 fs-4"></i> <!-- Icon for Guests -->
                        <span class="sidebar-text">Guests</span>
                    </a>
                    <a href="{{ route('staff.transactions') }}" class="fw-semibold p-4  mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hoverStaff text-decoration-none d-flex align-items-center" id="transactions-link">
                        <i class="fas fa-credit-card pe-3 fs-4"></i> <!-- Icon for Transactions -->
                        <span class="sidebar-text">Transactions</span>
                    </a>
                    </a>
                    <a href="#" class="fw-semibold p-4  mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hoverStaff text-decoration-none d-flex align-items-center" id="logout-link">
                        <i class="fas fa-sign-out-alt pe-3 fs-4"></i> <!-- Icon for Logout -->
                        <span class="sidebar-text">Logout</span>
                    </a>
                </div>
            </div>
</body>
</html>