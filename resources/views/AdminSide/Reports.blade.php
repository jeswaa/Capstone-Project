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
<style>
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
    
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            @include('Navbar.sidenavbar')
            <!-- Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <!-- Header -->
                <div class="d-flex justify-content-end align-items-center mb-2">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
                </div>

                <hr class="border-5">

                <!-- CONTENT -->
                <div>
                    <h1 class="text-uppercase mt-5 ms-3" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em; font-size: 3rem;" >Reservation Summary</h1>
                    <!-- Total Bookings Section -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download me-2"></i>Export
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.excel', ['month_year' => request('month_year', date('Y-m'))]) }}">
                                        <i class="fas fa-file-excel me-2"></i>Excel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('export.pdf', ['month_year' => request('month_year', date('Y-m'))]) }}">
                                        <i class="fas fa-file-pdf me-2"></i>PDF
                                    </a>
                                </li>
                                <li>
                                <a class="dropdown-item" href="#" onclick="printReport()">
                                    <i class="fas fa-print me-2"></i>Print
                                </a>
                                <script>
                                function printReport() {
                                    // Get the current month/year from the input
                                    const monthYearInput = document.getElementById('bookingMonth');
                                    const monthYear = monthYearInput.value;
                                    
                                    // Open print view in new window with parameters
                                    const printWindow = window.open(`/admin/reports/print?month_year=${monthYear}`, '_blank');
                                    
                                    // Automatically trigger print when loaded
                                    printWindow.onload = function() {
                                        printWindow.print();
                                    };
                                }
                                </script>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0 font-paragraph fw-semibold p-2">Checked-out Bookings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <h2 class="display-5 fw-bold text-danger">
                                                {{ $checkedOutCount ?? 0 }}
                                            </h2>
                                            <p class="mb-0 font-paragraph">Checked-out</p>
                                            <p class="text-muted mb-2">
                                                {{ isset($selectedMonth) && isset($selectedYear) 
                                                    ? date('F Y', mktime(0, 0, 0, (int)$selectedMonth, 1, (int)$selectedYear)) 
                                                    : 'Select a date and apply filter' }}
                                            </p>
                                            <div class="badge bg-secondary">
                                                {{ number_format($checkedOutCount ?? 0, 1) }}% Check-out Rate
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card shadow-sm h-100">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0 font-paragraph fw-semibold p-2">Early Checked-out Bookings</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <h2 class="display-5 fw-bold text-danger">
                                                {{ $earlyCheckedOutCount ?? 0 }}
                                            </h2>
                                            <p class="mb-0 font-paragraph">Early Checked-out Bookings</p>
                                            <p class="text-muted mb-2">
                                                {{ isset($selectedMonth) && isset($selectedYear) 
                                                    ? date('F Y', mktime(0, 0, 0, (int)$selectedMonth, 1, (int)$selectedYear)) 
                                                    : 'Select a date and apply filter' }}
                                            </p>
                                            <div class="badge bg-secondary">
                                                {{ number_format(($earlyCheckedOutCount / ($confirmedBookings ?: 1)) * 100, 1) }}% Early Check-out Rate
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
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
    </body>
</html>



 
