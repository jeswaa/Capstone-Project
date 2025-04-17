<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Transactions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Add Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
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
                <!-- Heading and Search Bar -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="fw-semibold" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">TRANSACTION</h1>
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
                <!-- Content Bar Graph -->
                <div>
                    <h1 class="fw-semibold text-capitalize ms-3 mt-5" style="font-size: 50px; letter-spacing: 1px; color: #0b573d;  font-family: 'Anton', sans-serif; letter-spacing: .1em;">Income Overview</h1>
                    <!-- Filterization by Year -->
                    <div class="d-flex justify-content-end mb-4">
                        <form action="{{ route('transactions') }}" method="GET" class="d-flex align-items-center">
                            <label for="year" class="me-2">Filter by Year:</label>
                            <select name="year" id="year" class="form-select" style="width: 150px;" onchange="this.form.submit()">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <!-- Bar Graph for the Income -->
                    <div class="container mt-4 shadow-lg rounded-4 p-3 bg-white">
                        <canvas id="incomeChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Pending Payments -->
                <div class="mt-5">
                    <h1 class="fw-semibold text-uppercase ms-3" style="font-size: 40px; color: #0b573d; font-family: 'Anton', sans-serif; letter-spacing: 0.2em;">PENDING PAYMENTS</h1>
                    
                    <div class="row mt-4">
                        @if(isset($pendingPayments) && count($pendingPayments) > 0)
                            @foreach($pendingPayments as $payment)
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 rounded-4 shadow" style="background-color: #0b573d;">
                                        <div class="card-body text-white p-4">
                                            <h3 class="fs-2 fw-bold">{{ $payment->name ?? 'Guest' }}</h3>
                                            <p class="mb-1 fst-italic">
                                                <i class="fas fa-envelope me-2"></i>
                                                {{ $payment->email ?? 'No email provided' }}
                                            </p>
                                            <p class="mb-0">
                                                <i class="fas fa-calendar me-2"></i>
                                                {{ \Carbon\Carbon::parse($payment->reservation_check_in_date)->format('F j, Y') }}, {{ \Carbon\Carbon::parse($payment->reservation_check_in)->format('h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-info">
                                    No pending payments found.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Table -->
                <div>
                    
                    <h1 class="fw-semibold text-uppercase ms-3 mt-5" style="font-size: 40px; color: #0b573d; font-family: 'Anton', sans-serif; letter-spacing: 0.2em;">Transactions Management</h1>
                    <!-- Export Buttons -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group">
                            <a href="{{ route('transactions.export.excel') }}" class="btn btn-success btn-sm me-2" style="font-size: 14px;">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                            <a href="{{ route('transactions.export.pdf') }}" class="btn btn-danger btn-sm me-2" style="font-size: 14px;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                            <button onclick="printContent()" class="btn btn-primary btn-sm" style="font-size: 14px;">
                                <i class="fas fa-print"></i> Print
                            </button>

                            <script>
                                function printContent() {
                                    // Create a new window for printing
                                    var printWindow = window.open('', '_blank');
                                    
                                    // Get the content to print
                                    var contentToPrint = document.querySelector('.table-responsive').innerHTML;
                                    
                                    // Add some basic styling
                                    var styles = `
                                        <style>
                                            table { 
                                                width: 100%;
                                                border-collapse: collapse;
                                            }
                                            th, td {
                                                border: 1px solid #ddd;
                                                padding: 8px;
                                                text-align: left;
                                            }
                                            th {
                                                background-color: #198754;
                                                color: white;
                                            }
                                            .badge {
                                                padding: 5px 10px;
                                                border-radius: 20px;
                                                color: white;
                                            }
                                            .bg-success { background-color: #198754; }
                                            .bg-warning { background-color: #ffc107; }
                                            .bg-primary { background-color: #0d6efd; }
                                            .bg-danger { background-color: #dc3545; }
                                            @media print {
                                                body { print-color-adjust: exact; }
                                            }
                                        </style>
                                    `;
                                    
                                    // Write the content to the new window
                                    printWindow.document.write('<html><head><title>Lelo\'s Resort - Transactions</title>' + styles + '</head><body>');
                                    printWindow.document.write('<h2 style="text-align: center; margin-bottom: 20px;">Lelo\'s Resort - Transactions Report</h2>');
                                    printWindow.document.write(contentToPrint);
                                    printWindow.document.write('</body></html>');
                                    
                                    // Wait for content to load then print
                                    printWindow.document.close();
                                    printWindow.onload = function() {
                                        printWindow.focus();
                                        printWindow.print();
                                        printWindow.close();
                                    };
                                }
                            </script>
                        </div>
                    </div>
                    <!-- Filter -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card shadow-lg border-0 rounded-4 p-4 bg-white bg-opacity-90">
                                
                                <div class="d-flex align-items-center mb-4">
                                    <i class="fas fa-filter me-2 text-success fs-4"></i>
                                    <h5 class="mb-0 fw-bold" style="color: #0b573d;">Filter Transactions</h5>
                                </div>

                                <form action="{{ route('transactions') }}" method="GET" class="mt-3">
                                    <div class="row g-4">
                                        <!-- Date Range Filter -->
                                        <div class="col-md-3">
                                            <label for="start_date" class="form-label fw-semibold">Start Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="far fa-calendar-alt text-muted"></i>
                                                </span>
                                                <input type="date" class="form-control border-start-0" id="start_date" name="start_date" value="{{ request('start_date') }}" style="height: 45px;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="far fa-calendar-alt text-muted"></i>
                                                </span>
                                                <input type="date" class="form-control border-start-0" id="end_date" name="end_date" value="{{ request('end_date') }}" style="height: 45px;">
                                            </div>
                                        </div>

                                        <!-- Guest Name Filter -->
                                        <div class="col-md-3">
                                            <label for="guest_name" class="form-label fw-semibold">Guest Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="far fa-user text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" id="guest_name" name="guest_name" placeholder="Enter guest name" value="{{ request('guest_name') }}" style="height: 45px;">
                                            </div>
                                        </div>

                                        <!-- Payment Status Filter -->
                                        <div class="col-md-3">
                                            <label for="payment_status" class="form-label fw-semibold">Payment Status</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="fas fa-money-check-alt text-muted"></i>
                                                </span>
                                                <select class="form-select border-start-0" id="payment_status" name="payment_status" style="height: 45px;">
                                                    <option value="">All</option>
                                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Filter Buttons -->
                                        <div class="col-12 d-flex justify-content-end mt-4">
                                            <a href="{{ route('transactions') }}" class="btn btn-outline-secondary px-4 py-2 me-2" style="width: 120px;">
                                                <i class="fas fa-undo-alt me-2"></i>Reset
                                            </a>
                                            <button type="submit" class="btn btn-success px-4 py-2" style="width: 120px;">
                                                <i class="fas fa-filter me-2"></i>Apply
                                            </button>
                                        </div>
                                    </div>
                                    @if(request('year'))
                                        <input type="hidden" name="year" value="{{ request('year') }}">
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover bg-white shadow-lg rounded-4">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col" class="py-3">Guest Name</th>
                                    <th scope="col" class="py-3">Amount Paid</th>
                                    <th scope="col" class="py-3">Remaining Balance</th>
                                    <th scope="col" class="py-3">Payment Mode</th>
                                    <th scope="col" class="py-3">Date</th>
                                    <th scope="col" class="py-3">Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservationDetails as $transaction)
                                    <tr>
                                        <td class="py-3">{{ $transaction->name }}</td>
                                        <td class="py-3">₱{{ number_format($transaction->amount, 2) }}</td>
                                        <td class="py-3">₱{{ in_array($transaction->payment_status, ['paid', 'cancelled', 'checked-out']) ? '0.00' : number_format($transaction->balance, 2) }}</td>
                                        <td class="py-3">{{ $transaction->payment_method }}</td>
                                        <td class="py-3">{{ \Carbon\Carbon::parse($transaction->reservation_check_in_date)->format('M d, Y') }}</td>
                                        <td class="py-3">
                                            <span class="badge rounded-pill {{ $transaction->payment_status === 'paid' ? 'bg-success' : ($transaction->payment_status === 'pending' ? 'bg-warning' : ($transaction->payment_status === 'booked' ? 'bg-primary' : 'bg-danger')) }}">
                                                {{ ucfirst($transaction->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3">No transactions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class="d-flex justify-content-end mt-3">
                            {{ $reservationDetails->links() }}
                        </div>
                    </div>
                </div>
         </div>
    </div>

    <!-- Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('incomeChart').getContext('2d');
        
        // Use data from backend
        const chartLabels = {!! $chartLabels !!};
        const chartValues = {!! $chartValues !!};
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Monthly Income',
                    data: chartValues,
                    backgroundColor: 'rgba(11, 87, 61, 0.7)', // Matching your theme color
                    borderColor: 'rgba(11, 87, 61, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
        <!-- Add this before the closing </body> tag -->
        <script>
        // Date range validation
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            startDate.addEventListener('change', function() {
                endDate.min = this.value;
                if (endDate.value && endDate.value < this.value) {
                    endDate.value = this.value;
                }
            });

            endDate.addEventListener('change', function() {
                startDate.max = this.value;
                if (startDate.value && startDate.value > this.value) {
                    startDate.value = this.value;
                }
            });
        });
    </script>
</body>
</html>
