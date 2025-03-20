<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reports</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- Main Content -->
            <div class="col-md-3"></div>
            <div class="col-md-9 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4">
                <div class="container p-4">
                    <h2 class="text-center font-heading text-color-1 fs-2 mt-4 mb-2">Reservation Summary Report</h2>

                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="rounded-3 color-background5 text-white p-3">
                                <h4 class="font-paragraph fs-5 text-color-1 fw-semibold">Total Reservations</h4>
                                <p class="fs-2 font-paragraph color-3">{{ number_format($totalReservations) }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rounded-3 color-background5 text-white p-3">
                                <h4 class="font-paragraph fs-5 text-color-1 fw-semibold">Cancelled Reservations</h4>
                                <p class="fs-2 font-paragraph color-3">{{ number_format($totalCancelled) }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rounded-3 color-background5 text-white p-3">
                                <h4 class="font-paragraph fs-5 text-color-1 fw-semibold">Confirmed Reservations</h4>
                                <p class="fs-2 font-paragraph color-3">{{ number_format($totalConfirmed) }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rounded-3 color-background5 text-white p-3">
                                <h4 class="font-paragraph fs-5 text-color-1 fw-semibold">Pending Reservations</h4>
                                <p class="fs-2 font-paragraph color-3">{{ number_format($totalPending) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Time-based Reservations -->
                    <h3 class="mt-4">Reservations</h3>
                    <canvas id="reservationsChart"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var ctx = document.getElementById("reservationsChart").getContext("2d");
                            var reservationsChart = new Chart(ctx, {
                                type: "bar", // Bar Chart
                                data: {
                                    labels: ["Daily", "Weekly", "Monthly", "Yearly"],
                                    datasets: [{
                                        label: "Reservations",
                                        data: [{{ $dailyReservations }}, {{ $weeklyReservations }}, {{ $monthlyReservations }}, {{ $yearlyReservations }}],
                                        backgroundColor: ["#718355", "#718355", "#718355", "#718355"],
                                        borderColor: "#333",
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>


                    <h3 class="mt-4 fs-2 text-color-1 font-heading fw-bold">Most Booked Package</h3>
                    @if($mostBooked)
                        <p class="font-paragraph fs-4 text-color-1"><strong class="font-paragraph fs-4 text-color-1">{{ $mostBooked->package_room_type }}</strong> ({{ number_format($mostBooked->count) }} bookings)</p>
                    @else
                        <p>No bookings yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- SIDE NAV BAR -->
    @include('Navbar.sidenavbar')
</body>
</html>
