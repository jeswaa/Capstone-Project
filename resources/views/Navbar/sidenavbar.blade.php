<style>
    #sidebar {
        transition: all 0.3s ease;
        overflow-x: hidden;
        height: 100vh;
        background-color: #0b573d;
    }

    .sidebar-expanded {
        width: 250px;
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

    /* Smooth layout resize */
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
</style>


<!-- Sidebar -->
<div id="sidebar" class="color-background8 text-white py-3 position-sticky sidebar-expanded" style="top: 0; height: 100vh; background-color: #0b573d">
    <!-- Toggle Button (Always Visible) -->
    <button id="toggleSidebar" class="btn btn-link text-white d-block " type="button">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Content (Toggle Visibility) -->
    <div id="sidebarContent" class="sidebar-content px-2">
        <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('images/appicon.png') }}" alt="Profile Picture" class="rounded-circle w-50">
        </div>

        <div class="d-flex flex-column px-4 mt-4">
            <a href="{{ route('dashboard') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2 fs-5"></i> Dashboard
            </a>
            <a href="{{ route('reservations') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right {{ request()->routeIs('reservations') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt me-2 fs-5"></i> Reservations
            </a>
            <a href="{{ route('guests') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right {{ request()->routeIs('guests') ? 'active' : '' }}">
                <i class="fas fa-users me-2 fs-5"></i> Guests
            </a>
            <a href="{{ route('transactions') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right {{ request()->routeIs('transactions') ? 'active' : '' }}">
                <i class="fas fa-credit-card me-2 fs-5"></i> Transactions
            </a>

            <div class="dropdown py-2 mt-4">
                <a class="text-white text-decoration-none d-flex align-items-center dropdown-toggle {{ request()->routeIs('reports') || request()->routeIs('activityLogs') ? 'active' : '' }}" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chart-line me-2 fs-5"></i> Reports
                </a>
                <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                    <li><a class="dropdown-item {{ request()->routeIs('reports') ? 'active' : '' }}" href="{{ route('reports') }}">Summary Report</a></li>
                    <li><a class="dropdown-item {{ request()->routeIs('DamageReport') ? 'active' : '' }}" href="{{ route('DamageReport') }}">Damage Report</a></li>
                    <li><a class="dropdown-item {{ request()->routeIs('activityLogs') ? 'active' : '' }}" href="{{ route('activityLogs') }}">Activity Logs</a></li>
                </ul>
            </div>

            <a href="{{ route('logout') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right {{ request()->routeIs('logout') ? 'active' : '' }}">
                <i class="fas fa-sign-out-alt me-2 fs-5"></i> Logout
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


