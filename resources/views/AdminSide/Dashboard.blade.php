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
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .color-background8{
        background-color: #0b573d;
    }
    .transition-width {
        transition: all 0.3s ease;
    }
    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
            @include('Alert.loginSucess')

    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout">
            @include('Navbar.sidenavbar')
            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <!-- Heading and Search Bar -->
                <div class="d-flex justify-content-end  mb-2">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
                </div>

                <hr class="border-5">
                <!-- Add your additional main content here -->
                <div class="d-flex align-items-center">
                    <p class="text-color-1 fs-1 ms-4 mb-0" style="font-family: 'Anton', sans-serif; letter-spacing: 0.2em;">Hello</p>
                    <h1 class="fw-semibold text-capitalize ms-3 mb-0 fs-1" style="letter-spacing: 1px; color: #0b573d; font-family: 'Anton', sans-serif; letter-spacing: 0.2em;">{{ $adminCredentials->username }}!</h1>
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
                                            <small class="font-paragraph fs-5 fw-semibold">Total Reservation Today</small>
                                        </div>
                                        <i class="fas fa-calendar-alt fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{$totalGuests ?? 0 }}</h3>
                                            <small class="font-paragraph fs-5 fw-semibold">Total Guests</small>
                                        </div>
                                        <i class="fas fa-users fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $checkInReservations->total ?? 0 }}</h3>
                                            <small class="font-paragraph fs-5 fw-semibold">Total Check-Ins Today</small>
                                        </div>
                                        <i class="fas fa-door-open fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $checkOutReservations->total ?? 0 }}</h3>
                                            <small class="font-paragraph fs-5 fw-semibold">Total Check-outs Today</small>
                                        </div>
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">{{ $guestsOnSite->total ?? 0 }}</h3>
                                            <small class="font-paragraph fs-5 fw-semibold">Total Guests On-site</small>
                                        </div>
                                        <i class="fas fa-person-booth fs-4"></i>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="color-background8 text-white rounded-4 p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="fw-bold mb-0">₱{{ number_format($todayIncome ?? 0, 2) }}</h3>
                                            <small class="font-paragraph fs-5 fw-semibold">Total Income Today</small>
                                        </div>
                                        <i class="fas fa-money-bill fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Latest Reservations Sidebar -->
                        <div class="col-lg-4 mt-3 mt-lg-0">
                            <!-- Latest Reservations Card (with reduced height) -->
                            <div class="bg-white rounded-4 shadow p-3 border border-success border-4">
                                <h5 class="fw-bold">Pending Reservations</h5>

                                <ul class="list-group list-group-flush">
                                    @if(count($latestReservations) > 0)
                                        @foreach ($latestReservations as $reservation)
                                            <li class="list-group-item d-flex justify-content-between mt-1">
                                                <span>{{ $reservation->name }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M d') }}</small>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item text-center">
                                            No pending reservations
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- New Card Above Latest Reservations -->
                           <div class="color-background8 text-white rounded-4 p-3 mb-3 mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-0">{{$cancelledReservations->total ?? 0}}</h3>
                                        <small class="font-paragraph fs-5 fw-semibold">Cancelled Reservations</small>
                                    </div>
                                    <i class="fas fa-times-circle fs-4"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Remove navigation buttons section and keep Chart Section 1 -->
                        <div id="chartSection1" class="chart-section">
                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <h1 class="text-color-1 font-paragraph fw-bold" style="font-size: 50px;">Reservation Overview</h1>

                                <!-- Filter Dropdowns: labels beside select -->
                                <div class="d-flex align-items-center">
                                    <!-- Filter By -->
                                    <div class="me-3 d-flex align-items-center gap-2">
                                        <label for="timeFilter" class="form-label font-paragraph fw-semibold mb-0" style="white-space: nowrap;">Filter By:</label>
                                        <select id="timeFilter" class="form-control" style="min-width: 100px; height: 50px;">
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
                                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart Container with Floating Effect and Side-by-Side Layout -->
                            <div class="row g-0 mt-4">
                                <div class="col-md-6 p-0 w-25">
                                    <div class="shadow-lg rounded-4 p-3 bg-white floating-effect h-100 d-flex justify-content-center align-items-center">
                                        <canvas id="statusChart" width="350" style="max-width: 500px;"></canvas>
                                    </div>
                                </div>

                                <div class="col-md-6 p-0 d-flex flex-column justify-content-start ms-3" style="width: 73%;">
                                    <div class="shadow-lg rounded-4 p-3 bg-white floating-effect" style="height: 100%;">
                                        <canvas id="reservationChart" class="w-100" height="100" style="height: 100%;"></canvas>
                                    </div>
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

    console.log("Initial Data Loaded:", {
        dailyData: dailyData,
        weeklyData: weeklyData,
        monthlyData: monthlyData
    });

    // Build Chart Function
    function buildChart(data, label, labelKey) {
        if (chart) chart.destroy();
    
        if (data.labels.length === 0) {
            data = {
                labels: ['No Data Available'],
                data: [0],
                rooms: ['No Rooms']
            };
        }
    
        // Format the labels based on the type of view
        const formattedLabels = data.labels.map(dateStr => {
            if (labelKey === 'date') {
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', { weekday: 'long' });
            } else if (labelKey === 'week') {
                return `Week ${dateStr}`;
            }
            return dateStr;
        });
    
        const datasets = [];
        
        // Dataset para sa total reservations
        datasets.push({
            label: 'Total Reservations',
            data: data.data,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            order: 1
        });
    
        // Datasets para sa bawat uri ng room
        if (data.rooms && data.rooms.length > 0) {
            const roomTypes = [...new Set(data.rooms.flat().filter(room => room !== 'No room information'))];
            const roomColors = @json($roomColors);
        
            roomTypes.forEach(roomType => {
                const roomData = data.labels.map((_, index) => {
                    const rooms = data.rooms[index];
                    return Array.isArray(rooms) ? 
                        rooms.filter(room => room === roomType).length : 
                        0;
                });
        
                datasets.push({
                    label: roomType,
                    data: roomData,
                    backgroundColor: roomColors[roomType] || 'rgba(201, 203, 207, 0.5)',
                    borderColor: roomColors[roomType]?.replace('0.5', '1') || 'rgba(201, 203, 207, 1)',
                    borderWidth: 1,
                    order: 2
                });
            });
        }
    
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: formattedLabels,
                datasets: datasets
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
                            text: labelKey === 'date' ? 'Date' : labelKey === 'week' ? 'Week' : 'Months'
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
                                if (context.label === 'No Data Available') {
                                    return 'Walang reservations sa napiling panahon';
                                }
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Monthly Data Generator
    function generateAllMonthsData(selectedYear) {
        const allMonths = [];
        const allMonthLabels = [];
        const allRooms = [];

        for (let month = 0; month < 12; month++) {
            const monthDate = new Date(selectedYear, month, 1);
            const monthLabel = monthDate.toLocaleString('default', { month: 'short' });
            allMonthLabels.push(monthLabel);

            const foundMonth = monthlyData.find(item => {
                try {
                    const dataDate = new Date(item.month + '-01');
                    return dataDate.getFullYear() === parseInt(selectedYear) && dataDate.getMonth() === month;
                } catch (e) {
                    console.error("Error parsing month:", item.month, e);
                    return false;
                }
            });

            allMonths.push(foundMonth ? foundMonth.total : 0);
            allRooms.push(foundMonth ? foundMonth.rooms : []);
        }

        return {
            labels: allMonthLabels,
            data: allMonths,
            rooms: allRooms
        };
    }

    // Weekly Data Generator
    function generateAllWeeksData(selectedYear, filteredData) {
        const allWeeks = Array.from({ length: 52 }, (_, i) => i + 1);
        const weekDataMap = {};
        const weekRoomsMap = {};

        // Store totals and rooms in maps by week number
        filteredData.forEach(item => {
            const weekNum = parseInt(String(item.week).slice(-2));
            weekDataMap[weekNum] = item.total;
            weekRoomsMap[weekNum] = item.rooms || [];
        });

        const allWeekData = [];
        const allWeekLabels = [];
        const allRooms = [];

        allWeeks.forEach(week => {
            const firstDayOfYear = new Date(selectedYear, 0, 1);
            const day = firstDayOfYear.getDay();
            const diff = (day <= 4 ? day - 1 : day - 8);
            const monday = new Date(firstDayOfYear.setDate(firstDayOfYear.getDate() - diff + (week - 1) * 7));

            const label = monday.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });

            allWeekLabels.push(label);
            allWeekData.push(weekDataMap[week] || 0);
            allRooms.push(weekRoomsMap[week] || []);
        });

        return {
            labels: allWeekLabels,
            data: allWeekData,
            rooms: allRooms
        };
    }


    // Main Filter Function
    function filterData(selectedTimeFilter, selectedYear) {
        selectedYear = parseInt(selectedYear);

        if (selectedTimeFilter === 'daily') {
            const filteredData = dailyData.filter(item => {
                try {
                    const itemDate = new Date(item.date);
                    return itemDate.getFullYear() === selectedYear;
                } catch (e) {
                    console.error("Error parsing date:", item.date, e);
                    return false;
                }
            });

            filteredData.sort((a, b) => new Date(a.date) - new Date(b.date));

            return {
                labels: filteredData.map(item => new Date(item.date).toLocaleDateString()),
                data: filteredData.map(item => item.total),
                rooms: filteredData.map(item => item.rooms || 'No room information')
            };
        } 
        
        else if (selectedTimeFilter === 'weekly') {
            const filteredData = weeklyData.filter(item => {
                try {
                    const weekStr = String(item.week);
                    let yearFromWeek;

                    if (weekStr.includes('-')) {
                        yearFromWeek = parseInt(weekStr.split('-')[0]);
                    } else if (weekStr.length === 6) {
                        yearFromWeek = parseInt(weekStr.substring(0, 4));
                    } else {
                        console.warn("Unrecognized week format:", item.week);
                        return false;
                    }

                    return yearFromWeek === selectedYear;
                } catch (e) {
                    console.error("Error parsing week:", item.week, e);
                    return false;
                }
            });

            filteredData.sort((a, b) => {
                const weekA = parseInt(String(a.week).slice(-2));
                const weekB = parseInt(String(b.week).slice(-2));
                return weekA - weekB;
            });

            return generateAllWeeksData(selectedYear, filteredData);
        } 
        
        else if (selectedTimeFilter === 'monthly') {
            return generateAllMonthsData(selectedYear);
        }
    }

    // Time Filter Event
    document.getElementById('timeFilter').addEventListener('change', function () {
        const selectedTimeFilter = this.value;
        const selectedYear = document.getElementById('yearFilter').value;

        const chartData = filterData(selectedTimeFilter, selectedYear);
        const label = selectedTimeFilter === 'daily' ? 'Daily Reservations' :
                    selectedTimeFilter === 'weekly' ? 'Weekly Reservations' : 'Monthly Reservations';

        buildChart(chartData, label, selectedTimeFilter.slice(0, -2));
    });

    // Year Filter Event
    document.getElementById('yearFilter').addEventListener('change', function () {
        const selectedYear = this.value;
        const selectedTimeFilter = document.getElementById('timeFilter').value;
        window.location.href = `?year=${selectedYear}&timeFilter=${selectedTimeFilter}`;
    });

    // Initial Load
    const currentYear = new Date().getFullYear();
    const urlParams = new URLSearchParams(window.location.search);
    const yearParam = urlParams.get('year') || currentYear;
    const timeFilterParam = urlParams.get('timeFilter') || 'daily';

    document.getElementById('yearFilter').value = yearParam;
    document.getElementById('timeFilter').value = timeFilterParam;

    const initialData = filterData(timeFilterParam, yearParam);
    const initialLabel = timeFilterParam === 'daily' ? 'Daily Reservations' :
                        timeFilterParam === 'weekly' ? 'Weekly Reservations' : 'Monthly Reservations';

    buildChart(initialData, initialLabel, timeFilterParam.slice(0, -2));
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
                    text: 'Payment Status Breakdown'
                }
            }
        }
    });
</script>
<!-- For Booking Trends -->
<script>
const bookingTrendsData = @json($bookingTrends);
let bookingTrendsChart;

function buildBookingTrendsChart(data) {
    if (bookingTrendsChart) bookingTrendsChart.destroy();

    const ctx = document.getElementById('bookingTrendsChart').getContext('2d');

    // Gradient for futuristic vibe
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(138, 43, 226, 0.4)'); // Neon purple
    gradient.addColorStop(1, 'rgba(138, 43, 226, 0)');

    bookingTrendsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(item => item.date),
            datasets: [{
                label: 'Reservation',
                data: data.map(item => item.total),
                fill: true,
                backgroundColor: gradient,
                borderColor: 'rgba(138, 43, 226, 1)', // Electric purple
                borderWidth: 2,
                tension: 0.4,
                pointRadius: 3,
                pointHoverRadius: 6,
                pointBackgroundColor: 'rgba(255, 255, 255, 0.9)',
                pointBorderColor: 'rgba(138, 43, 226, 1)',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e1e2f',
                    titleColor: '#fff',
                    bodyColor: '#ddd',
                    borderColor: 'rgba(138, 43, 226, 0.2)',
                    borderWidth: 1,
                    titleFont: {
                        weight: 'bold',
                        size: 13
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 10,
                    cornerRadius: 6
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#ccc',
                        padding: 10
                    },
                    grid: {
                        color: 'rgba(138, 43, 226, 0.05)'
                    },
                    title: {
                        display: true,
                        text: 'Bookings',
                        color: '#bbb',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    ticks: {
                        color: '#ccc',
                        padding: 5
                    },
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Date',
                        color: '#bbb',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
}

buildBookingTrendsChart(bookingTrendsData);
</script>
<!-- For Most Booked Rooms  -->
<script>
    const roomTypeLabels = @json($roomTypeUtilization->keys());
    const roomTypeData = @json($roomTypeUtilization->values());

    console.log("Room Type Labels:", roomTypeLabels);
    console.log("Room Type Data:", roomTypeData);

    const roomCtx = document.getElementById('roomTypeChart').getContext('2d');
    new Chart(roomCtx, {
        type: 'bar',
        data: {
            labels: roomTypeLabels,
            datasets: [{
                label: 'Number of Bookings',
                data: roomTypeData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
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
                        text: 'Bookings'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Room Type'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
</script>
<!-- Calendar Widget Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get calendar data from PHP
        const calendarData = @json($calendarData);
        console.log('Initial calendar data:', calendarData);
        
        // Get the selected year from the filter
        const yearFilter = document.getElementById('calendarYearFilter');
        let selectedYear = yearFilter.value;
        console.log('Initial selected year:', selectedYear);

        function filterEventsByYear(events, year) {
            const filtered = events.filter(event => {
                const eventYear = new Date(event.start).getFullYear();
                return eventYear.toString() === year.toString();
            });
            console.log(`Filtered events for year ${year}:`, filtered);
            return filtered;
        }

        // Convert calendar data to FullCalendar events
        const allEvents = calendarData.map(data => {
            try {
                const eventDate = new Date(data.date);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                // Check if date is in the past
                const isPastDate = eventDate < today;

                return {
                    title: isPastDate ? 'Past Date' : 
                           data.status === 'available' ? 'Available' :
                           data.status === 'booked' ? 'Fully Booked' :
                           `${Math.round((data.booked / (data.available + data.booked)) * 100)}% Booked`,
                    start: data.date,
                    backgroundColor: isPastDate ? '#808080' : data.color,
                    borderColor: isPastDate ? '#808080' : data.color,
                    textColor: '#fff',
                    extendedProps: {
                        available: isPastDate ? 0 : data.available,
                        booked: data.booked,
                        status: isPastDate ? 'past' : data.status,
                        isPastDate: isPastDate
                    }
                };
            } catch (error) {
                console.error('Error processing calendar data:', error);
                return null;
            }
        }).filter(event => event !== null);

        console.log('All events after mapping:', allEvents);

        // Filter events for initial year
        let filteredEvents = filterEventsByYear(allEvents, selectedYear);
        
        if (filteredEvents.length === 0) {
            // Display message when no data is available for selected year
            const calendarEl = document.getElementById('calendar');
            calendarEl.innerHTML = `
                <div class="alert alert-info text-center my-3">
                    <i class="fas fa-info-circle me-2"></i>
                    No reservation data available for year ${selectedYear}. 
                </div>
            `;
            return;
        }
        
        // Get current date for initial calendar view
        const currentDate = new Date();
        
        // Initialize FullCalendar
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: currentDate,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: filteredEvents,
            eventClick: function(info) {
                const props = info.event.extendedProps;
                if (props.isPastDate) {
                    alert(`Date: ${info.event.startStr}\nThis date has passed`);
                } else {
                    alert(`Date: ${info.event.startStr}\nAvailable Rooms: ${props.available}\nBooked Rooms: ${props.booked}`);
                }
            },
            eventContent: function(arg) {
                const props = arg.event.extendedProps;
                let icon = props.isPastDate ? '⏰' :
                          props.status === 'available' ? '✅' :
                          props.status === 'booked' ? '❌' : '🟡';
                          
                return {
                    html: `<div class="fc-event-title">${icon} ${arg.event.title}</div>`
                };
            },
            dayCellDidMount: function(info) {
                const dateStr = info.date.toISOString().split('T')[0];
                const eventForDate = filteredEvents.find(e => e.start === dateStr);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (info.date < today) {
                    info.el.style.backgroundColor = 'rgba(128, 128, 128, 0.1)';
                } else if (!eventForDate) {
                    info.el.style.backgroundColor = 'rgba(40, 167, 69, 0.1)';
                }
            },
            validRange: function() {
                return {
                    start: `${selectedYear}-01-01`,
                    end: `${selectedYear}-12-31`
                };
            }
        });
        
        calendar.render();

        // Update calendar when year changes
        yearFilter.addEventListener('change', function() {
            try {
                selectedYear = this.value;
                console.log('Year changed to:', selectedYear);
                
                // Get current time filter value
                const timeFilter = document.getElementById('timeFilter').value;
                
                // Update URL with new year and maintain existing time filter
                window.location.href = `/admin/dashboard?year=${selectedYear}&timeFilter=${timeFilter}`;
                
                filteredEvents = filterEventsByYear(allEvents, selectedYear);
                console.log('New filtered events:', filteredEvents);
                
                if (filteredEvents.length === 0) {
                    calendarEl.innerHTML = `
                        <div class="alert alert-info text-center my-3">
                            <i class="fas fa-info-circle me-2"></i>
                            No reservation data available for year ${selectedYear}. 
                            <br>
                            This could be because:
                            <ul class="list-unstyled mt-2">
                                <li>- No reservations have been made for this year</li>
                                <li>- The data hasn't been loaded properly</li>
                                <li>- There might be an error in the data format</li>
                            </ul>
                        </div>
                    `;
                    return;
                }

                calendar.removeAllEvents();
                calendar.addEventSource(filteredEvents);
                
                const currentView = calendar.view;
                const currentMonth = currentView.currentStart.getMonth();
                calendar.gotoDate(new Date(selectedYear, currentMonth, 1));
            } catch (error) {
                console.error('Error updating calendar:', error);
                calendarEl.innerHTML = `
                    <div class="alert alert-danger text-center my-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        An error occurred while updating the calendar. Please try again or contact support.
                    </div>
                `;
            }
        });
    });
</script>
</body>
</html>
