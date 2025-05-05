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
    <title>Activity Logs</title>
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
    @include('Alert.loginSucess')

    <div class="container-fluid min-vh-100 d-flex p-0">
                <!-- Sidebar -->
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
                                <i class="fas fa-chart-line me-2 fs-5"></i> Reports
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="reportsDropdown">
                                <li><a class="dropdown-item" href="{{ route('reports') }}">Summary Report</a></li>
                                <li><a class="dropdown-item" href="{{ route('activityLogs') }}">Activity Logs</a></li>
                            </ul>
                        </div>

                        <a href="{{ route('logout') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                            <i class="fas fa-sign-out-alt me-2 fs-5"></i> Logout
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                 <div class="col-md-9 col-lg-10 py-4 px-4">
                    <!-- Heading and Search Bar -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h1 class="fw-semibold" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">ACTIVITY LOGS</h1>
                        <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
                    </div>

                    <hr class="border-5">
                    <!-- Links -->
                    <div class="d-flex justify-content-center mb-5">
                        <a href="{{ route('activityLogs') }}" class="text-color-2 text-decoration-none me-5 fancy-link active" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Activity Logs</h1></a>
                        <a href="{{ route('userAccountRoles') }}" class="text-color-2 me-5 text-decoration-none fancy-link" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Account Creation</h1></a>
                    </div>
                    <!-- Filter Form -->
                    <form action="{{ route('activityLogs') }}" method="GET" class="d-flex justify-content-center align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="width: 150px; height: 38px;">
                                <span class="input-group-text" style="height: 38px;">to</span>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" style="width: 150px; height: 38px;">
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <select name="role" class="form-select" style="width: 120px; height: 38px;">
                                <option value="">All Roles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                        {{ ucfirst($role) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="Search activity..." value="{{ request('search') }}" style="width: 200px; height: 38px;">
                                <button class="btn btn-secondary" type="submit" style="height: 38px;">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    
                        @if(request()->hasAny(['start_date', 'end_date', 'role', 'search']))
                            <div class="d-flex align-items-center">
                                <a href="{{ route('activityLogs') }}" class="btn btn-outline-secondary" style="height: 38px;">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        @endif
                    </form>
                    <!-- Table -->
                    <div>
                        <div class="container-fluid">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="py-3 text-secondary" style="width: 200px;">
                                                        <i class="fas fa-calendar-alt me-2"></i>Date & Time
                                                    </th>
                                                    <th class="py-3 text-secondary" style="width: 150px;">
                                                        <i class="fas fa-user me-2"></i>User
                                                    </th>
                                                    <th class="py-3 text-secondary" style="width: 100px;">
                                                        <i class="fas fa-user-tag me-2"></i>Role
                                                    </th>
                                                    <th class="py-3 text-secondary" style="width: 400px;">
                                                        <i class="fas fa-clipboard-list me-2"></i>Activity
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($activityLogs as $log)
                                                <tr class="border-bottom">
                                                    <td class="py-3" style="width: 200px;">
                                                        {{ \Carbon\Carbon::parse($log->date . ' ' . $log->time)->format('F j, Y g:i A') }}
                                                    </td>
                                                    <td class="py-3" style="width: 150px;">{{ $log->user }}</td>
                                                    <td class="py-3" style="width: 100px;">
                                                        <span class="badge bg-success rounded-pill px-3">{{ $log->role }}</span>
                                                    </td>
                                                    <td class="py-3" style="width: 400px;">{{ $log->activity }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        <nav aria-label="Activity logs pagination">
                                            <div class="pagination pagination-sm">
                                                {{ $activityLogs->links('pagination::bootstrap-5') }}
                                            </div>
                                        </nav>
                                    </div>
                                    <style>
                                        .pagination .page-item.active .page-link {
                                            background-color: #0b573d;
                                            border-color: #0b573d;
                                        }
                                        .pagination .page-link {
                                            color: #0b573d;
                                            padding: 0.5rem 1rem;
                                            border-radius: 0.25rem;
                                            margin: 0 2px;
                                        }
                                        .pagination .page-link:hover {
                                            background-color: #e9ecef;
                                            border-color: #dee2e6;
                                            color: #0b573d;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
    </div>
</body>
</html>