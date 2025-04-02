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
                            <h3 class="font-heading mb-4 text-center">Pending Payments</h3>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                @foreach ($totalPendingPayment as $user)
                                    <div class="col">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $user->name }}</h5>
                                                <p class="card-text">{{ $user->email }}</p>
                                                <p class="card-text"><small class="text-muted">{{ $user->created_at->format('F j, Y, g:i a') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
