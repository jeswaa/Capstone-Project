<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
     .slider-container {
        overflow-x: auto;
        scroll-behavior: smooth;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        padding: 10px;
        border-radius: 10px;
    }
    .slider::-webkit-scrollbar {
        display: none;
    }
    .slider {
        display: flex;
        gap: 20px;
    }
    .slider-item {
        color: white;
        padding: 20px;
        border-radius: 10px;
    }
    #chart-container {
        height: 1000px;
        width: 100%;
        display: block;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
    #bookingChart{
        height: 500px !important;
    }
    .chart-wrapper {
        display: none;
    }
    .chart-wrapper.active-chart {
        display: block;
    }
</style>

<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            @include('Alert.loginSucess')

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 mt-4 flex-column align-items-end ms-auto" id="main-content">
                <!-- TOP SECTION -->
                <div class="color-background4 w-100 p-3 rounded-topright-50 mb-4">
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

                <!-- Main Section -->
                <div class="overflow-y-auto p-2 ms-3 mb-3">
                    <div class="me-3 color-background5 border-secondary rounded-3 mt-5 pt-4 ps-4 pb-5">
                        <h1 class="text-color-1 font-heading fw-semibold p-3">Hello, {{ $adminCredentials->username }}</h1>
                        <p class="color-3 font-paragraph ps-3 position-absolute fst-italic" id="quote">...</p>
                    </div>
                </div>

                <!-- Image -->
                <div class="position-absolute top-0 end-0 translate-middle-y me-4" style="margin-right: -100px; margin-top: 235px;">
                    <img src="{{ asset('images/welcomeImg.png') }}" class="img-fluid" style="max-width: 220px; height: auto;" alt="Profile">
                </div>

                <div class="ps-5 pe-5 pt-2 mb-5 d-flex justify-content-center">
                    <div class="color-background1 p-4 mt-1 rounded-5 overflow-hidden">
                        <div class="slider-container position-relative">
                            <div class="slider d-flex gap-4 justify-content-start">
                                <!-- TOTAL BOOKINGS -->
                                <div class="color-background4 p-4 d-flex align-items-center gap-3 rounded-4" style="min-width: 200px; flex-shrink: 0;">
                                    <i class="fas fa-calendar-check fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Total Bookings</h1>
                                        <p class="text-color-1 font-paragraph mt-1">{{ $totalReservations }}</p>
                                    </div>
                                </div>

                                <!-- TOTAL GUESTS -->
                                <div class="color-background4 p-4 d-flex align-items-center gap-3 rounded-4" style="min-width: 200px; flex-shrink: 0;">
                                    <i class="fa-solid fa-users fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Total Guests</h1>
                                        <p class="text-color-1 font-paragraph mt-1">{{ number_format($totalUsers) }}</p>
                                    </div>
                                </div>

                                <!-- Paid Reservation -->
                                <div class="color-background4 p-4 d-flex align-items-center gap-3 rounded-4" style="min-width: 200px; flex-shrink: 0;">
                                    <i class="fa-solid fa-money-bill-trend-up fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Paid Reservations</h1>
                                        <p class="text-color-1 font-paragraph mt-1">{{ $totalTransactions }}</p>
                                    </div>
                                </div>

                                <!-- Pending Reservation -->
                                <div class="color-background4 p-4 d-flex align-items-center gap-3 rounded-4" style="min-width: 200px; flex-shrink: 0;">
                                    <i class="fa-solid fa-receipt fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Pending Reservations</h1>
                                        <p class="text-color-1 font-paragraph mt-1">{{ $pendingReservations }}</p>
                                    </div>
                                </div>

                                <!-- Booked Reservation -->
                                <div class="color-background4 p-4 d-flex align-items-center gap-3 rounded-4" style="min-width: 200px; flex-shrink: 0;">
                                    <i class="fa-solid fa-receipt fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Booked Reservations</h1>
                                        <p class="text-color-1 font-paragraph mt-1">{{ $bookedReservations }}</p>
                                    </div>
                                </div>

                                <!-- Cancelled Reservation -->
                                <div class="color-background4 p-4 d-flex align-items-center gap-3 rounded-4" style="min-width: 200px; flex-shrink: 0;">
                                    <i class="fa-solid fa-receipt fs-1"></i>
                                    <div>
                                        <h1 class="text-color-1 font-heading fw-bold fs-5">Cancelled Reservations</h1>
                                        <p class="text-color-1 font-paragraph mt-1">{{ $cancelledReservations }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="p-3 m-3">
                    <div class="color-background4 p-4 rounded-5 overflow-hidden">
                        <h1 class="text-color-1 font-heading fw-bold fs-5">Latest Reservation</h1>
                        <div class="mt-3">
                            @if ($latestReservations->isNotEmpty())
                                @foreach ($latestReservations as $reservation)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p class="text-end">
                                                <strong>Status:</strong>
                                                <span class="badge 
                                                    @if($reservation->payment_status == 'paid') bg-success 
                                                    @elseif($reservation->payment_status == 'pending') bg-warning 
                                                    @else bg-danger 
                                                    @endif"
                                                    style="text-transform: capitalize;">    
                                                    {{ $reservation->payment_status }}
                                                </span>
                                            </p>
                                            <p><strong>Room Types:</strong> {{ $reservation->room_types }}</p>
                                            <p><strong>Check-in:</strong> {{ $reservation->reservation_check_in }}</p>
                                            <p><strong>Check-out:</strong> {{ $reservation->reservation_check_out }}</p>
                                            <p><strong>Guests:</strong> {{ $reservation->package_max_guests }}</p>
                                            <p><strong>Special Request:</strong> {{ $reservation->special_request ?? 'None' }}</p>
                                            <p><strong>Amount:</strong> {{ $reservation->amount }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center">No reservations at the moment.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="p-3 m-3">
                    <div class="chart-container p-5 rounded-5 overflow-hidden" id="chart-container">
                        <h1 class="text-color-1 font-heading fw-bold fs-5 mb-4">Select Chart</h1>
                        <select id="chartSelector" onchange="switchChart()">
                            <option value="bookingChartWrapper">Reservations</option>
                            <option value="usersChartWrapper">Users</option>
                            <option value="revenueChartWrapper">Revenue</option>
                        </select>

                        <div class="chart-wrapper active-chart" id="bookingChartWrapper">
                            <canvas id="bookingChart"></canvas>
                        </div>
                        <div class="chart-wrapper" id="usersChartWrapper">
                            <canvas id="usersChart"></canvas>
                        </div>
                        <div class="chart-wrapper" id="revenueChartWrapper">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('Navbar.sidenavbar')

    <!-- SCRIPTS -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let bookingChartCtx = document.getElementById('bookingChart').getContext('2d');
        let usersChartCtx = document.getElementById('usersChart').getContext('2d');
        let revenueChartCtx = document.getElementById('revenueChart').getContext('2d');

        let monthlyBookingsData = @json($monthlyBookingsData); // Bookings per month
        let years = @json($availableYears); // Available years
        let selectedYear = years[0]; // Default selected year
        let dailyBookings = @json($dailyBookings);
        let weeklyBookings = @json($weeklyBookings);
        let yearlyBookings = @json($yearlyBookings);
        let latestUserDaysAgo = @json($latestUserDaysAgo); 
        let totalUsers = @json($totalUsers);
        let monthlyRevenueData = @json($revenueData);

        // Reservations Chart
        let bookingChart = new Chart(bookingChartCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
            label: 'Reservations',
            data: [
                ...['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'].map(month => {
                    let monthData = monthlyBookingsData.find(data => data.month_name === month); // Change 'month' to 'month_name'
                    return monthData ? monthData.count : 0;
                }),
            ],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
            x: {
                beginAtZero: true
            }
            }
        }
        });


        // Users Growth Chart
        let usersChart = new Chart(usersChartCtx, {
            type: 'line',
            data: {
                labels: ['Daily', 'Weekly', 'Monthly', 'Yearly'],
                datasets: [{
                    label: 'Users Count',
                    data: [latestUserDaysAgo, totalUsers, totalUsers, totalUsers], 
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
        // Revenue Chart
        let revenueChart = new Chart(revenueChartCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Use the same month names as labels
                datasets: [{
                    label: 'Revenue',
                    data: [
                        ...['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'].map(month => {
                            // Find the revenue for the corresponding month
                            let monthData = monthlyRevenueData.find(data => data.month_name === month);
                            return monthData ? monthData.total_revenue : 0; // Return revenue or 0 if not found
                        }),
                    ],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Red background color
                    borderColor: 'rgba(255, 99, 132, 1)', // Red border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    }
                }
            }
        });
        // Quote typing effect
        const quotes = [
            "Success is not the key to happiness. Happiness is the key to success.",
            "Hard work beats talent when talent doesn’t work hard.",
            "Strive not to be a success, but rather to be of value."
        ];
        let index = 0, charIndex = 0, currentQuote = "", isDeleting = false;

        function typeQuote() {
            const quoteElement = document.getElementById("quote");
            if (!isDeleting && charIndex < quotes[index].length) {
                currentQuote += quotes[index].charAt(charIndex++);
            } else {
                isDeleting = true;
                currentQuote = currentQuote.substring(0, charIndex--);
            }
            quoteElement.textContent = currentQuote;
            setTimeout(typeQuote, isDeleting ? 50 : 100);
            if (charIndex < 0) {
                isDeleting = false;
                index = (index + 1) % quotes.length;
            }
        }
        typeQuote();
    });

    function switchChart() {
    let selectedChart = document.getElementById("chartSelector").value;
    document.querySelectorAll(".chart-wrapper").forEach(chart => chart.classList.remove("active-chart"));
    document.getElementById(selectedChart).classList.add("active-chart");
}
</script>

</script>
</body>
</html>
