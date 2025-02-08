<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- SIDEBAR -->
            <div class="col-md-3 col-12 sidebar" id="sidebar">
                <div class="d-flex flex-column ms-5 mt-5">
                    <h1 class="text-color-1 font-heading sidebar-text" id="resort-name"><span>LELO'S RESORT</span></h1>
                    
                    <!-- Collapsible Sidebar Links -->
                    <a href="#" class="fw-semibold p-4  mt-3 mt-2 color-3 hover:color-background3 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="dashboard-link">
                        <i class="fas fa-tachometer-alt pe-3 fs-4"></i> <!-- Icon for Dashboard -->
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    <a href="#" class="fw-semibold p-4 mt-3 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover transition duration-300 ease-in-out text-decoration-none d-flex align-items-center" id="reservations-link">
                        <i class="fas fa-calendar-alt pe-3 fs-4"></i> <!-- Icon for Reservations -->
                        <span class="sidebar-text">Reservations</span>
                    </a>
                    <a href="#" class="fw-semibold p-4 mt-3 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="guests-link">
                        <i class="fas fa-users pe-3 fs-4"></i> <!-- Icon for Guests -->
                        <span class="sidebar-text">Guests</span>
                    </a>
                    <a href="#" class="fw-semibold p-4 mt-3 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="transactions-link">
                        <i class="fas fa-credit-card pe-3 fs-4"></i> <!-- Icon for Transactions -->
                        <span class="sidebar-text">Transactions</span>
                    </a>
                    <a href="#" class="fw-semibold p-4 mt-3 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="reports-link">
                        <i class="fas fa-chart-line pe-3 fs-4"></i> <!-- Icon for Reports -->
                        <span class="sidebar-text">Reports</span>
                    </a>
                    <a href="#" class="fw-semibold p-4 mt-3 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="logout-link">
                        <i class="fas fa-sign-out-alt pe-3 fs-4"></i> <!-- Icon for Logout -->
                        <span class="sidebar-text">Logout</span>
                    </a>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4" id="main-content">
                <!-- TOP SECTION -->
                <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success rounded-end-5" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin's Profile">
                            <a href="#"><i class="fa-regular fa-circle-user fs-1 text-decoration-none text-color-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- MAIN SECTION -->
                <div class="overflow-y-auto h-100 p-5">
                    <div class="p-5 position-relative ">
                        <!-- Box -->
                        <div class="color-background4 p-5 rounded-5">
                            <h1 class="text-color-1 font-heading fw-bold">Welcome, Admin</h1>
                            <p class="text-color-1 font-paragraph mt-1">This is your dashboard</p>
                        </div>

                        <!-- Image (Outside the box but aligned) -->
                        <div class="position-absolute top-0 end-0 translate-middle-y me-4" style="margin-right: -100px; margin-top: 130px;">
                            <img src="{{ asset('images/welcomeImg.png') }}" class="img-fluid" style="max-width: 220px; height: auto;" alt="Profile">
                        </div>
                    </div>

                    <div class="ps-5 pe-5 pt-2">
                        <div class="color-background1 p-4 mt-1 rounded-5 overflow-x-auto">
                            <div class="d-flex gap-4 w-max">
                                <!-- TOTAL BOOKINGS -->
                                <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                    <i class="fas fa-calendar-check fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Total Bookings</h1>
                                        <p class="text-color-1 font-paragraph mt-1">10,000</p>
                                    </div>
                                </div>

                                <!-- TOTAL GUESTS -->
                                <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                    <i class="fa-solid fa-users fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Total Guests</h1>
                                        <p class="text-color-1 font-paragraph mt-1">10,000</p>
                                    </div>
                                </div>

                                <!-- TOTAL GUESTS -->
                                <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                    <i class="fa-solid fa-money-bill-trend-up fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Total Revenue</h1>
                                        <p class="text-color-1 font-paragraph mt-1">10,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        const sidebar = document.getElementById("sidebar");
        const resortName = document.getElementById("resort-name");
        const toggleSidebarButton = document.getElementById("toggle-sidebar");
        const mainContent = document.getElementById("main-content");

        const toggleSidebar = () => {
            sidebar.classList.toggle("collapsed");
            resortName.classList.toggle("hidden");
            mainContent.classList.toggle("expanded");
        };
    </script>
</body>
</html>
