<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
            @include('Alert.loginSucess')

            <div class="container-fluid min-vh-100 d-flex p-0">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 color-background8 text-white py-5 position-sticky" style="top: 0; height: 100vh;">
                    <div class="d-flex flex-column align-items-center">
                        <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3">
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
                    <h1 class="fw-semibold" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">DASHBOARD</h1>
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
                <!-- Add your additional main content here -->
                <div>
                    <p class="text-color-1 fs-1 ms-4" style="font-family: 'Anton', sans-serif; letter-spacing: 0.2em;">Hello</p>
                    <h1 class="fw-semibold text-capitalize ms-3" style="font-size: 100px; letter-spacing: 1px; color: #0b573d; margin-top: -30px; font-family: 'Anton', sans-serif; letter-spacing: .1em;">{{ $adminCredentials->username }}!</h1>
                </div>
                <!-- Container -->
                <div class="container my-4">
                    <div class="row">
                        <!-- Stat Boxes Column -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <!-- Stat Cards (same as before) -->
                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{$totalBookings ?? 0 }}</h3>
                                            <small class="font-paragraph">Total Bookings</small>
                                        </div>
                                        <i class="fas fa-calendar-alt fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{$totalGuests ?? 0 }}</h3>
                                            <small class="font-paragraph">Total Guests</small>
                                        </div>
                                        <i class="fas fa-users fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $paidReservations->total ?? 0 }}</h3>
                                            <small class="font-paragraph">Paid Reservations</small>
                                        </div>
                                        <i class="fas fa-cash-register fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $pendingReservations->total ?? 0 }}</h3>
                                            <small class="font-paragraph">Pending Reservations</small>
                                        </div>
                                        <i class="fas fa-file-invoice fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $bookReservations->total ?? 0 }}</h3>
                                            <small class="font-paragraph">Book Reservations</small>
                                        </div>
                                        <i class="fas fa-book fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{$cancelledReservations->total ?? 0}}</h3>
                                            <small class="font-paragraph">Cancelled Reservations</small>
                                        </div>
                                        <i class="fas fa-times-circle fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Reservations Sidebar -->
                        <div class="col-lg-4 mt-3 mt-lg-0">
                            <div class="bg-white rounded-4 shadow p-3 border border-success border-4" style="height: 100%;">
                                <h5 class="fw-bold mb-3">📌 Latest Reservations</h5>

                                <ul class="list-group list-group-flush">
                                    @foreach ($latestReservations as $reservation)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>{{ $reservation->name }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M d') }}</small>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="text-end mt-2">
                                    <a href="#" class="btn btn-sm btn-outline-success">View All</a>
                                </div>
                            </div>
                        </div>

                        <!-- Charts -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <h1 class="text-color-1 font-paragraph fw-bold" style="font-size: 50px;">Reservation Overview</h1>

                                <!-- Filter Dropdowns: labels beside select -->
                                <div class="d-flex align-items-center">
                                    <!-- Filter By -->
                                    <div class="me-3 d-flex align-items-center">
                                        <label for="timeFilter" class="form-label mb-0 me-2 font-paragraph fw-semibold">Filter By:</label>
                                        <select id="timeFilter" class="form-control" style="min-width: 150px; height: 50px;">
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>

                                    <!-- Year -->
                                    <div class="d-flex align-items-center">
                                        <label for="yearFilter" class="form-label mb-0 me-2 font-paragraph fw-semibold">Year:</label>
                                        <select id="yearFilter" class="form-control" style="min-width: 150px; height: 50px;">
                                            @foreach($availableYears as $year)
                                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart Container with Floating Effect and Side-by-Side Layout -->
                            <div class="row g-0 mt-4">
                                <!-- Status Chart -->
                                <div class="col-md-6 p-0 w-25">
                                    <div class="shadow-lg rounded-4 p-3 bg-white floating-effect h-100 d-flex justify-content-center align-items-center">
                                        <canvas id="statusChart" width="350" style="max-width: 500px;"></canvas>
                                    </div>
                                </div>

                                <!-- Reservation Chart -->
                                <div class="col-md-6 p-0 d-flex flex-column justify-content-start ms-3" style="width: 73%;">
                                    <div class="shadow-lg rounded-4 p-3 bg-white floating-effect" style="height: 100%;">
                                        <canvas id="reservationChart" class="w-100" height="100" style="height: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5">
                            <div class="col-12">
                                <h1 class="text-color-1 font-paragraph fw-bold">Reservation Activity</h1>
                            </div>

                            <div class="col-md-8 mt-4 w-100">
                                <div class="shadow-lg rounded-4 p-3 bg-white">
                                    <canvas id="bookingTrendsChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <script>
    const dailyData = @json($dailyReservations);
    const weeklyData = @json($weeklyReservations);
    const monthlyData = @json($monthlyReservations);

    const ctx = document.getElementById('reservationChart').getContext('2d');
    let chart;

    // Log the data to check if it is passed correctly
    console.log("Daily Data:", dailyData);
    console.log("Weekly Data:", weeklyData);
    console.log("Monthly Data:", monthlyData); // Check if this is logged correctly

    // Function to build the chart
    function buildChart(data, label, labelKey) {
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels, // Ensure labels are passed properly
                datasets: [{
                    label: label,
                    data: data.data,  // Ensure data array is passed properly
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Reservations'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: labelKey === 'date' ? 'Date' : labelKey === 'week' ? 'Week # (YearWeek)' : 'Month'
                        }
                    }
                }
            }
        });
    }

    // Function to generate all months for the x-axis (including zero reservations)
    function generateAllMonthsData(monthlyData) {
        const allMonths = [];
        const allMonthLabels = [];
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        
        // Generate all months of current year in order
        for (let month = 0; month < 12; month++) {
            const monthDate = new Date(currentYear, month, 1);
            const monthLabel = monthDate.toLocaleString('default', { month: 'short', year: 'numeric' });
            allMonthLabels.push(monthLabel);
            
            // Find matching month in the data
            const foundMonth = monthlyData.find(item => {
                const dataDate = new Date(item.month + '-01'); // Convert "Jan 2023" to date
                return dataDate.getFullYear() === currentYear && 
                    dataDate.getMonth() === month;
            });
            
            allMonths.push(foundMonth ? foundMonth.total : 0);
        }

        return {
            labels: allMonthLabels,
            data: allMonths
        };
    }

    // Handle the filter change for time
    document.getElementById('timeFilter').addEventListener('change', function () {
        const selected = this.value;
        const selectedYear = document.getElementById('yearFilter').value; // Get the selected year

        if (selected === 'daily') {
            buildChart({ labels: dailyData.map(item => item.date), data: dailyData.map(item => item.total) }, 'Daily Reservations', 'date');
        } else if (selected === 'weekly') {
            buildChart({ labels: weeklyData.map(item => item.week), data: weeklyData.map(item => item.total) }, 'Weekly Reservations', 'week');
        } else if (selected === 'monthly') {
            const fullMonthlyData = generateAllMonthsData(monthlyData); // Get all months with 0 if no data
            buildChart(fullMonthlyData, 'Monthly Reservations', 'month'); // Use the new data structure
        }
    });

    // Handle the filter change for year
    document.getElementById('yearFilter').addEventListener('change', function () {
        const selectedYear = this.value;
        const selectedTimeFilter = document.getElementById('timeFilter').value; // Get the selected time filter

        if (selectedTimeFilter === 'daily') {
            // Filter daily data by year
            const filteredDailyData = dailyData.filter(item => new Date(item.date).getFullYear() == selectedYear);
            buildChart({ labels: filteredDailyData.map(item => item.date), data: filteredDailyData.map(item => item.total) }, 'Daily Reservations', 'date');
        } else if (selectedTimeFilter === 'weekly') {
            // Filter weekly data by year
            const filteredWeeklyData = weeklyData.filter(item => new Date(item.week).getFullYear() == selectedYear);
            buildChart({ labels: filteredWeeklyData.map(item => item.week), data: filteredWeeklyData.map(item => item.total) }, 'Weekly Reservations', 'week');
        } else if (selectedTimeFilter === 'monthly') {
            // Filter monthly data by year
            const filteredMonthlyData = generateAllMonthsData(monthlyData.filter(item => new Date(item.month).getFullYear() == selectedYear));
            buildChart(filteredMonthlyData, 'Monthly Reservations', 'month');
        }
    });

    // Initial Load (Default: Daily)
    buildChart({ labels: dailyData.map(item => item.date), data: dailyData.map(item => item.total) }, 'Daily Reservations', 'date');
</script>


    <script>
        const statusCounts = @json($reservationStatusCounts);

        const statusLabels = Object.keys(statusCounts);
        const statusTotals = Object.values(statusCounts);

        const statusColors = [
            'rgba(75, 192, 192, 1)',  // Blue - Boooked
            'rgba(255, 205, 86, 1)',  // Yellow - Pending
            'rgba(255, 99, 132, 1)',  // Red - Cancelled
            'rgba(153, 102, 255, 1)' // Purple - Checked-out
        ];

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'pie', // You can change to 'bar' if preferred
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Reservation Status',
                    data: statusTotals,
                    backgroundColor: statusColors,
                    borderColor: statusColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: (context) => statusColors[context.index]
                        }
                    },
                    title: {
                        display: true,
                        text: 'Reservation Status Breakdown'
                    }
                }
            }
        });
    </script>
    <script>
        const bookingTrendsData = @json($bookingTrends);
        let bookingTrendsChart;

        function buildBookingTrendsChart(data) {
            if (bookingTrendsChart) bookingTrendsChart.destroy();

            const ctx = document.getElementById('bookingTrendsChart').getContext('2d');
            bookingTrendsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => item.date),
                    datasets: [{
                        label: 'Booking Trends',
                        data: data.map(item => item.total),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Bookings'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        }

        buildBookingTrendsChart(bookingTrendsData);
    </script>

</body>
</html>
