<style>
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
    }
</style>

<!-- SIDEBAR -->
<div class="col-md-3 col-12 sidebar" id="sidebar">
    <div class="d-flex flex-column ms-5 mt-5">
        <h1 class="text-color-1 font-heading sidebar-text" id="resort-name"><span>LELO'S RESORT</span></h1>
        
        <!-- Collapsible Sidebar Links -->
        <a href="{{ route('dashboard') }}" class="fw-semibold p-4   mt-2 color-3 hover:color-background3 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="dashboard-link">
            <i class="fas fa-tachometer-alt pe-3 fs-4"></i> <!-- Icon for Dashboard -->
            <span class="sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('reservations') }}" class="fw-semibold p-4  mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover transition duration-300 ease-in-out text-decoration-none d-flex align-items-center" id="reservations-link">
            <i class="fas fa-calendar-alt pe-3 fs-4"></i> <!-- Icon for Reservations -->
            <span class="sidebar-text">Reservations</span>
        </a>
        <a href="{{ route('guests') }}" class="fw-semibold p-4  mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="guests-link">
            <i class="fas fa-users pe-3 fs-4"></i> <!-- Icon for Guests -->
            <span class="sidebar-text">Guests</span>
        </a>
        <a href="{{ route('transactions') }}" class="fw-semibold p-4 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="transactions-link">
            <i class="fas fa-credit-card pe-3 fs-4"></i> <!-- Icon for Transactions -->
            <span class="sidebar-text">Transactions</span>
        </a>
        <div class="dropdown">
            <a href="#" class="fw-semibold p-4 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center dropdown-toggle" id="reports-link" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-chart-line pe-3 fs-4"></i>
                <span class="sidebar-text">Reports</span>
            </a>
            <ul class="dropdown-menu rounded-md w-100 border" aria-labelledby="reports-link">
                <li><a class="dropdown-item" href="{{ route('reports') }}">Summary Report</a></li>
                <li><a class="dropdown-item" href="#">Transaction Report</a></li>
                <li><a class="dropdown-item" href="#">Reservation Report</a></li>
                <li><a class="dropdown-item" href="#">Activity Logs</a></li>
            </ul>
        </div>
        <a href="{{ route('logout') }}" class="fw-semibold p-4 mt-2 color-3 hover:color-background1 font-paragraph rounded-md text-hover text-decoration-none d-flex align-items-center" id="logout-link">
            <i class="fas fa-sign-out-alt pe-3 fs-4"></i> <!-- Icon for Logout -->
            <span class="sidebar-text">Logout</span>
        </a>
    </div>
</div>
