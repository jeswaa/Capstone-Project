<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .fancy-link {
    text-decoration: none;
    font-weight: 600;
    position: relative;
    transition: color 0.3s ease;
}

.fancy-link::after {
    content: "";
    position: absolute;
    width: 0;
    height: 2px;
    left: 0;
    bottom: -2px;
    background-color: #0b573d;
    transition: width 0.3s ease;
}

.fancy-link:hover {
    color: #0b573d;
}

.fancy-link:hover::after {
    width: 100%;
}
.fancy-link.active::after {
    width: 100% !important;
}
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    <div class="container-fluid min-vh-100 d-flex p-0">

        <!-- Side NavBar -->
        <div class="col-md-3 col-lg-2 color-background8 text-white py-5 position-sticky" style="top: 0; height: 100vh;">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3 border border-5 border-white">
                <p class="font-heading sidebar-text" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;">Edit Profile</p>
            </div>

            <div class="d-flex flex-column px-4 mt-4">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-tachometer-alt me-2 fs-5"></i> Dashboard
                </a>
                <a href="{{ route('reservations') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-calendar-alt me-2 fs-5"></i> Reservations
                </a>
                <a href="{{ route('guests') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-users me-2 fs-5"></i> Guests
                </a>
                <a href="{{ route('transactions') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-credit-card me-2 fs-5"></i> Transactions
                </a>

                <div class="dropdown py-2 mt-4">
                    <a class="text-white text-decoration-none d-flex align-items-center dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-line me-2 fs-5 text-underline-left-to-right"></i> Reports
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                        <li><a class="dropdown-item" href="{{ route('reports') }}">Summary Report</a></li>
                        <li><a class="dropdown-item" href="#">Activity Logs</a></li>
                    </ul>
                </div>

                <a href="{{ route('logout') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-sign-out-alt me-2 fs-5"></i> Logout
                </a>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 py-4 px-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-semibold fs-1" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">ROOM</h1>
                <form class="d-flex w-50 ms-5" role="search">
                    <div class="input-group">
                        <input type="search" class="form-control rounded-start-5 border-3 border-secondary" style="background-color: transparent; height: 40px;" placeholder="Search" aria-label="Search">
                        <button class="btn btn-secondary h-75 rounded-end-5" style="color: #e9ffcc;" type="submit">
                            <i class="fa-solid fa-magnifying-glass" ></i>
                        </button>
                    </div>
                </form>
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
            </div>

            <hr class="border-5">
            <!-- Links -->
            <div class="d-flex justify-content-center">
                <a href="{{ route('reservations') }}" class="text-color-2 text-decoration-none me-5 fancy-link " style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Reservation</h1></a>
                <a href="{{ route('rooms') }}" class="text-color-2 me-5 text-decoration-none fancy-link active" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Room </h1></a>
                <a href="{{ route('packages') }}" class="text-color-2 text-decoration-none fancy-link" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Packages</h1></a>
            </div>

            <div>
                <h1 class="text-color-2 fw-bold mt-3 ms-5" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">Overview</h1>

                
                <!-- Cards Container -->
                <div class="container my-5">
                    <div class="row g-4">

                        <!-- Total Rooms Card -->
                        <div class="col-md-4">
                            <div class="card text-white rounded-4 shadow p-4" style="background-color: #0b573d;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-uppercase mb-1" style="font-family: Anton; letter-spacing: 0.1em;">Total Rooms</h5>
                                        <h2 class="fw-bold font-paragraph">{{$count ?? 0}}</h2>
                                    </div>
                                    <i class="bi bi-building" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Available Rooms Card -->
                        <div class="col-md-4">
                            <div class="card text-white rounded-4 shadow p-4" style="background-color: #0b573d;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-uppercase mb-1" style="font-family: Anton; letter-spacing: 0.1em;">Available Rooms</h5>
                                        <h2 class="fw-bold font-paragraph">{{$countAvailableRoom}}</h2>
                                    </div>
                                    <i class="bi bi-door-open" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Reserved Rooms Card -->
                        <div class="col-md-4">
                            <div class="card text-white rounded-4 shadow p-4" style="background-color: #0b573d;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="text-uppercase mb-1" style="font-family: Anton; letter-spacing: 0.1em;">Reserved Rooms</h5>
                                        <h2 class="fw-bold font-paragraph">13</h2>
                                    </div>
                                    <i class="bi bi-calendar-check" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>

</body>
</html>