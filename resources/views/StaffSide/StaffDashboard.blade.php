<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
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
    .chart-container {
        position: relative;
        height: 400px; /* Adjusted height */
        width: 1000px; /* Adjusted width */
    }
</style>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            @include('Alert.loginSucess')
            <!-- SIDEBAR -->
            @include('Navbar.sidenavbarStaff')

            <!-- MAIN CONTENT -->
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 mt-4 flex-column align-items-end ms-auto" id="main-content">
                <!-- TOP SECTION -->
                <div class="color-background4 w-100 p-3 rounded-topright-50 " id="main-content">
                        <div class="d-flex justify-content-end" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin's Profile">
                            <a href="#"><i class="fa-regular fa-circle-user fs-1 text-decoration-none text-color-1"></i></a>
                        </div>
                </div>

                <!-- MAIN SECTION -->
                <div class="overflow-y-auto h-100 p-5">
                    <div class="p-5 position-relative ">
                        <!-- Box -->
                        <div class="color-background4 p-5 rounded-5">
                            <h1 class="text-color-2 font-heading fw-bold">Hello, {{ $staffCredentials->username }}</h1>
                            <p class="text-color-1 font-paragraph position-absolute fst-italic" id="quote" style="max-height: 220px;"></p>
                            <script>
                                const quotes = [
                                    `"Success is not the key to happiness. Happiness is the key to success."`,
                                    "Hard work beats talent when talent doesn’t work hard.",
                                    "Strive not to be a success, but rather to be of value.",
                                    "Efficiency is doing things right; effectiveness is doing the right things.",
                                    "Hard work beats talent when talent doesn’t work hard"
                                ];
                                let index = 0;
                                let charIndex = 0;
                                let currentQuote = '';
                                let isDeleting = false;

                                function typeQuote() {
                                    const quoteElement = document.getElementById("quote");
                                    
                                    if (!isDeleting && charIndex < quotes[index].length) {
                                        currentQuote += quotes[index].charAt(charIndex);
                                        charIndex++;
                                        quoteElement.textContent = currentQuote;
                                        setTimeout(typeQuote, 100);
                                    } else if (isDeleting) {
                                        currentQuote = currentQuote.substring(0, charIndex - 1);
                                        charIndex--;
                                        quoteElement.textContent = currentQuote;
                                        setTimeout(typeQuote, 50);
                                        
                                        if (charIndex === 0) {
                                            isDeleting = false;
                                            index = (index + 1) % quotes.length;
                                        }
                                    } else {
                                        isDeleting = true;
                                        setTimeout(typeQuote, 2000);
                                    }
                                }

                                typeQuote();
                            </script>
                        </div>

                        <!-- Image (Outside the box but aligned) -->
                        <div class="position-absolute top-0 end-0 translate-middle-y me-4" style="margin-right: -100px; margin-top: 90px;">
                            <img src="{{ asset('images/welcomeImg.png') }}" class="img-fluid" style="max-width: 220px; height: auto;" alt="Profile">
                        </div>
                    </div>

                    <div class="ps-5 pe-5 pt-2 mb-5 d-flex justify-content-center">
                        <div class="color-background1 p-4 mt-1 rounded-5 overflow-hidden">
                            <div class="slider-container position-relative">
                                <div class="slider d-flex gap-4 justify-content-start">
                                    <!-- TOTAL BOOKINGS -->
                                    <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                        <i class="fas fa-calendar-check fs-1"></i>
                                        <div>
                                            <h1 class="text-color-1 font-heading fw-bold fs-5">Total Reservations</h1>
                                            <p class="text-color-1 font-paragraph mt-1">{{$totalReservations}}</p>
                                        </div>
                                    </div>

                                    <!-- TOTAL GUESTS -->
                                    <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                        <i class="fa-solid fa-clock fs-1"></i>
                                        <div>
                                            <h1 class="text-color-1 font-heading fw-bold fs-5">Pending Payments</h1>
                                            <p class="text-color-1 font-paragraph mt-1">{{ $totalPendingTransactions }}</p>
                                        </div>
                                    </div>

                                    <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                        <i class="fa-solid fa-user-check fs-1"></i>
                                        <div>
                                            <h1 class="text-color-1 font-heading fw-bold fs-5">Checked-in Guests</h1>
                                            <p class="text-color-1 font-paragraph mt-1">{{ $totalCheckedInGuests }}</p>
                                        </div>
                                    </div>
                                    <div class="color-background4 p-4 w-auto h-auto d-flex align-items-center gap-3 rounded-4">
                                        <i class="fa-solid fa-bed fs-1"></i>
                                        <div>
                                            <h1 class="text-color-1 font-heading fw-bold fs-5">Available Accommodations</h1>
                                            <p class="text-color-1 font-paragraph mt-1">{{ $vacantRooms }}</p>
                                        </div>
                                    </div>
                                    
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pending Bookings -->
                        <div class="ps-5 pe-5">
                            <!-- Pending Bookings Section -->
                            <div class="color-background1 p-4 mt-2 rounded-5">
                                <h2 class="text-color-2 font-heading fw-bold mb-3">Pending Bookings</h2>

                                <div class="list-group">
                                    @if(count($pendingBookings) > 0)
                                        @foreach($pendingBookings as $booking)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ $booking->name }} - {{ \Carbon\Carbon::parse($booking->reservation_check_in_date)->format('M d, Y') }}</span>
                                                <a href="{{ route('staff.reservation', ['id' => $booking->id]) }}" class="btn btn-primary btn-sm w-25">View</a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="list-group-item text-center">
                                            No pending reservations
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Charts and Graphs -->
                        <div class="p-3"> 
                        <div class="p-3">
                            <div class="color-background1 p-4 mt-1 rounded-5 overflow-hidden">
                                <h1 class="font-heading fw-bold text-color-1 fs-3">Reservations</h1>
                                
                                <!-- Display Today's Total Revenue -->
                                <div class="text-center mb-3">
                                    <h4 class="text-color-1">Today's Total Revenue: {{ $formattedRevenue }}</h4>
                                </div>
                                
                                <div class="chart-container">
                                    <canvas id="reservationChart"></canvas>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const ctx = document.getElementById('reservationChart').getContext('2d');
                                            const reservationChart = new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: ['Today', 'This Week', 'This Month'],  // Labels for each data point
                                                    datasets: [{
                                                        label: 'Total Revenue',
                                                        data: [
                                                            @json([$totalRevenue]), // Revenue for today
                                                            @json([$weeklyRevenue]), // Revenue for this week
                                                            @json([$monthlyRevenue]) // Revenue for this month
                                                        ],
                                                        backgroundColor: [
                                                            'rgba(54, 162, 235, 0.6)',  // Color for Today
                                                            'rgba(75, 192, 192, 0.6)',  // Color for Week
                                                            'rgba(153, 102, 255, 0.6)'  // Color for Month
                                                        ],
                                                        borderColor: [
                                                            'rgba(54, 162, 235, 1)',  // Border color for Today
                                                            'rgba(75, 192, 192, 1)',  // Border color for Week
                                                            'rgba(153, 102, 255, 1)'  // Border color for Month
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            ticks: {
                                                                callback: function(value) {
                                                                    return '₱ ' + value.toLocaleString(); // Format the Y-axis to show currency
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
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
document.addEventListener("DOMContentLoaded", function () {
    const sliderContainer = document.querySelector(".slider-container");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    prevBtn.addEventListener("click", function () {
        sliderContainer.scrollBy({ left: -300, behavior: "smooth" });
    });

    nextBtn.addEventListener("click", function () {
        sliderContainer.scrollBy({ left: 300, behavior: "smooth" });
    });
});
</script>
</body>
</html>

