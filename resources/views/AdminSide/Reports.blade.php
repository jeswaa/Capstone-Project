<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reports</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- Side Navbar -->
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
        <div  class="col-md-9 col-lg-10 py-4 px-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-semibold fs-1" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">REPORTS</h1>
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

            <!-- CONTENT -->
            <div>
                <h1 class="text-uppercase mt-5 ms-3" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em; font-size: 3rem;" >Reservation Summary</h1>
                <!-- Total Bookings Section -->
                <div class="card shadow-sm mb-4 mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0 font-paragraph fw-semibold pt-2 pb-2">Reports Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('reports') }}" method="GET" id="monthYearForm">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div style="flex: 0 0 300px;">
                                            <label for="bookingMonth" class="form-label font-paragraph mb-2">Select Month & Year</label>
                                            <input type="month" class="form-control font-paragraph" id="bookingMonth" name="month_year" 
                                                value="{{ request('month_year', date('Y-m')) }}">
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" style="height: 38px; width: 120px;">Apply Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body text-center d-flex flex-column justify-content-center py-3">
                                                <h1 class="display-3 fw-bold text-color-2" id="totalBookingsCount">
                                                    {{ $confirmedBookings ?? 0 }}
                                                </h1>
                                                <p class="mb-0 font-paragraph fw-semibold">Total Paid Bookings</p>
                                                <p class="text-muted small">
                                                    {{ isset($selectedMonth) && isset($selectedYear) 
                                                        ? date('F Y', mktime(0, 0, 0, (int)$selectedMonth, 1, (int)$selectedYear)) 
                                                        : 'Select a date and apply filter' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body text-center d-flex flex-column justify-content-center py-3">
                                                <h1 class="display-3 fw-bold text-color-2">
                                                {{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}
                                                </h1>
                                                <p class="mb-0 font-paragraph fw-semibold">Total Adults & Children</p>
                                                <p class="text-muted small">
                                                {{ date('F Y', strtotime(request('month_year', date('Y-m')))) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card shadow-sm">
                                            <div class="card-body py-3">
                                                <canvas id="bookingsTrendChart" style="max-height: 200px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0 font-paragraph fw-semibold">Guest Age Distribution</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="guestsDistributionChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header">
                                    <h6 class="card-title mb-0 font-paragraph fw-semibold p-2">Most Booked Room Type</h6>
                                </div>
                                <div class="card-body">
                                    @if(isset($mostBookedRoomType) && $mostBookedRoomType > 0)
                                        <div class="text-center">
                                            <h2 class="display-5 fw-bold text-color-2">{{ $mostBookedRoomType }}</h2>
                                            <p class="mb-0 font-paragraph">Bookings for this room type in</p>
                                            <p class="text-muted">
                                                {{ isset($selectedMonth) && isset($selectedYear) 
                                                    ? date('F Y', mktime(0, 0, 0, (int)$selectedMonth, 1, (int)$selectedYear)) 
                                                    : 'Select a date and apply filter' }}
                                            </p>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <p>No booking data available for the selected period</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <!-- Add Cancelled Bookings Card -->
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-header">
                                    <h6 class="card-title mb-0 font-paragraph fw-semibold p-2">Cancelled Bookings</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <h2 class="display-5 fw-bold text-danger">
                                            {{ $cancelledBookings ?? 0 }}
                                        </h2>
                                        <p class="mb-0 font-paragraph">Cancelled Bookings</p>
                                        <p class="text-muted mb-2">
                                            {{ isset($selectedMonth) && isset($selectedYear) 
                                                ? date('F Y', mktime(0, 0, 0, (int)$selectedMonth, 1, (int)$selectedYear)) 
                                                : 'Select a date and apply filter' }}
                                        </p>
                                        <div class="badge bg-secondary">
                                            {{ number_format($cancellationPercentage ?? 0, 1) }}% Cancellation Rate
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Additional Reports Section (Initially Hidden) -->
            <div class="mt-5">
                <h1 class="text-uppercase ms-3" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em; font-size: 3rem;">Revenue Reports</h1>
                <div class="row mt-4">
                    <!-- Add your additional report cards here -->
                    <div class="col-md-8 mt-1 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0 font-paragraph fw-semibold p-2">Monthly Income</h6>
                            </div>
                            <div class="card-body">
                                <div style="height: 400px; position: relative;">
                                    <canvas id="monthlyIncomeChart"></canvas>
                                </div>
                                @if(!isset($dates) || empty($dates))
                                    <div class="text-center text-muted mt-3">
                                        <p>No income data available for the selected period</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0 font-paragraph fw-semibold p-2">Payment Status Breakdown</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="paymentStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Add Chart.js library -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let bookingsChart = null;
                let guestsChart = null;
                
                function initializeBookingsChart() {
                    const chartCanvas = document.getElementById('bookingsTrendChart');
                    
                    // If we already have a chart, destroy it
                    if (bookingsChart) {
                        bookingsChart.destroy();
                    }
                    
                    @if(isset($selectedYear) && isset($selectedMonth))
                        const daysInMonth = new Date({{ (int)$selectedYear }}, {{ (int)$selectedMonth }}, 0).getDate();
                        const labels = Array.from({length: daysInMonth}, (_, i) => i + 1);
                        const bookingData = @json($dailyBookings ?? []);
                        const counts = Array(daysInMonth).fill(0);
                        
                        // Fill in the actual counts
                        for (let i = 1; i <= daysInMonth; i++) {
                            counts[i-1] = bookingData[i] || 0;
                        }
                        
                        bookingsChart = new Chart(chartCanvas, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Daily Bookings',
                                    data: counts,
                                    borderColor: '#0b573d',
                                    backgroundColor: 'rgba(11, 87, 61, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    @else
                        const ctx = chartCanvas.getContext('2d');
                        ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
                        ctx.font = '15px Arial';
                        ctx.fillStyle = '#666';
                        ctx.textAlign = 'center';
                        ctx.fillText('Select a date and apply filter to view chart data', chartCanvas.width/2, chartCanvas.height/2);
                    @endif
                }

                function initializeGuestsChart() {
                    const chartCanvas = document.getElementById('guestsDistributionChart');
                    
                    // If we already have a chart, destroy it
                    if (guestsChart) {
                        guestsChart.destroy();
                    }

                    @if(isset($adultGuests) || isset($childGuests))
                        guestsChart = new Chart(chartCanvas, {
                            type: 'pie',
                            data: {
                                labels: ['Adults(18 + age)', 'Children (3 - 17 age)'],
                                datasets: [{
                                    data: [{{ $adultGuests ?? 0 }}, {{ $childGuests ?? 0 }}],
                                    backgroundColor: [
                                        'rgba(11, 87, 61, 0.8)',
                                        'rgba(11, 87, 61, 0.4)'
                                    ],
                                    borderColor: '#ffffff',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    @else
                        const ctx = chartCanvas.getContext('2d');
                        ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
                        ctx.font = '15px Arial';
                        ctx.fillStyle = '#666';
                        ctx.textAlign = 'center';
                        ctx.fillText('Select a date and apply filter to view chart data', chartCanvas.width/2, chartCanvas.height/2);
                    @endif
                }

                // Initialize both charts
                initializeBookingsChart();
                initializeGuestsChart();

                // Handle form submission
                document.getElementById('monthYearForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    this.submit();
                });
            });
        </script>
    <!-- Script for MonthlyIncome Chart -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let monthlyIncomeChart = null;
        
        function initializeMonthlyIncomeChart() {
            const chartCanvas = document.getElementById('monthlyIncomeChart');
            
            if (monthlyIncomeChart) {
                monthlyIncomeChart.destroy();
            }
            
            @if(isset($dates) && !empty($dates))
                const monthsWithYear = @json($dates).map(date => {
                    const d = new Date(date);
                    return d.toLocaleString('default', { month: 'long', year: 'numeric' });
                });

                monthlyIncomeChart = new Chart(chartCanvas, {
                    type: 'line',
                    data: {
                        labels: monthsWithYear,
                        datasets: [{
                            label: 'Monthly Income',
                            data: @json($income),
                            borderColor: '#0b573d',
                            backgroundColor: 'rgba(11, 87, 61, 0.2)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointBackgroundColor: '#0b573d'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: '#666666',
                                    maxRotation: 0,
                                    minRotation: 0,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                },
                                ticks: {
                                    color: '#666666',
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString();
                                    },
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#666666'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                callbacks: {
                                    label: function(context) {
                                        return '₱' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            @endif
        }

        // Initialize the chart
        initializeMonthlyIncomeChart();
    });
</script>
<!-- Chart for Payment Status -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
            let paymentStatusChart = null;
            
            function initializePaymentStatusChart() {
                const chartCanvas = document.getElementById('paymentStatusChart');
                
                if (paymentStatusChart) {
                    paymentStatusChart.destroy();
                }

                @if(isset($paymentStatusData))
                    paymentStatusChart = new Chart(chartCanvas, {
                        type: 'pie',
                        data: {
                            labels: ['Fully Paid', 'Partial Payment', 'Pending', 'Cancelled'],
                            datasets: [{
                                data: [
                                    {{ $paymentStatusData['paid'] }}, 
                                    {{ $paymentStatusData['partial'] }}, 
                                    {{ $paymentStatusData['pending'] }},
                                    {{ $paymentStatusData['cancelled'] }}
                                ],
                                backgroundColor: [
                                    'rgba(40, 167, 69, 0.8)',  // Success green
                                    'rgba(255, 140, 0, 0.8)',  // Dark orange for partial payment
                                    'rgba(255, 255, 0, 0.8)',   // Yellow
                                    'rgba(220, 53, 69, 0.8)'
                                ],
                                borderColor: '#ffffff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const value = context.raw;
                                            const percentage = ((value / total) * 100).toFixed(1);
                                            return `${context.label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                @else
                    const ctx = chartCanvas.getContext('2d');
                    ctx.clearRect(0, 0, chartCanvas.width, chartCanvas.height);
                    ctx.font = '15px Arial';
                    ctx.fillStyle = '#666';
                    ctx.textAlign = 'center';
                    ctx.fillText('Select a date and apply filter to view payment status data', chartCanvas.width/2, chartCanvas.height/2);
                @endif
            }

            // Initialize the payment status chart
            initializePaymentStatusChart();
        });
    </script>
    </body>
</html>



 
