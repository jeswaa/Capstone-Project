<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Transactions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Add Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- Main Content -->
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 mt-4 flex-column align-items-end ms-auto">
                <!-- TOP SECTION -->
                <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control mb-0 rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
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
                
                    <!-- Chart for Revenue (Daily, Weekly, Monthly) -->
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <h3 class="font-heading mb-4 text-center">Revenue Overview</h3>
                            <div style="height: 400px;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Editing Entrance Fee -->
                    <div class="modal fade" id="editEntranceFeeModal" tabindex="-1" aria-labelledby="editEntranceFeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEntranceFeeModalLabel">Edit Entrance Fee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('updatePrice') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="entranceFee" class="form-label">Entrance Fee</label>
                                            <input type="number" class="form-control" id="entranceFee" name="entrance_fee" value="{{ isset($entranceFee) ? $entranceFee : 'N/A' }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-5">
                        <div class="col-12">
                            <h3 class="font-heading mb-4">Pending Payments</h3>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @foreach ($totalPendingPayment as $user)
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $user->name }}</h5>
                                                <p class="card-text">{{ $user->email }}</p>
                                                <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->format('F j, Y, g:i a') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4">
                    <!-- Display here the Filterazation of the Transactions -->

                    <form method="GET" action="{{ route('transactions') }}" class="mb-4">
                        <div class="row g-2">
                            <!-- Date Filter -->
                            <div class="col-md-4">
                                <label for="dateFilter" class="form-label">Filter by Date:</label>
                                <input type="date" class="form-control" id="dateFilter" name="date" value="{{ request('date') }}">
                            </div>

                            <!-- Payment Status Filter -->
                            <div class="col-md-4">
                                <label for="paymentStatus" class="form-label">Payment Status:</label>
                                <select class="form-select" id="paymentStatus" name="payment_status">
                                    <option value="">All</option>
                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="canceled" {{ request('payment_status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('transactions') }}" class="btn btn-light border px-4 py-2 rounded-pill shadow-sm mt-3">
                                    Reset <i class="fa-solid fa-arrow-rotate-left ms-1"></i>
                                </a>
                            </div>

                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Guest Name</th>
                                    <th>Check-in Date</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Reservation Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaction->reservation_check_in_date)->format('F j, Y') }}</td>
                                        <td>{{($transaction->amount) }}</td>
                                        <td class="{{ $transaction->payment_status == 'paid' ? 'text-success' : ($transaction->payment_status == 'pending' ? 'text-warning' : 'text-danger') }}">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </td>
                                        <td class="{{ $transaction->reservation_status == 'checked_out' ? 'text-primary' : ($transaction->reservation_status == 'reserved' ? 'text-secondary' : 'text-danger') }}">
                                            {{ ucfirst(str_replace('_', ' ', $transaction->reservation_status)) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $filteredTransactions->links() }}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- SIDE NAV BAR -->
    @include('Navbar.sidenavbar')

    <script>
        // Add Chart.js script for daily, weekly, and monthly revenue
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Daily', 'Weekly', 'Monthly'],  // Labels for daily, weekly, and monthly
                    datasets: [{
                        label: 'Revenue',
                        data: [@json($dailyRevenue), @json($weeklyRevenue), @json($monthlyRevenue)],  // Data for daily, weekly, and monthly revenues
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
