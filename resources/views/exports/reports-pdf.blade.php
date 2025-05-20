<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Report - {{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .metric {
            margin: 10px 0;
        }
        .metric-label {
            font-weight: bold;
            display: inline-block;
            width: 200px;
        }
        .metric-value {
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Monthly Report</h1>
        <h2>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</h2>
    </div>

    <div class="section">
        <div class="section-title">Monthly Overview</div>
        <div class="metric">
            <span class="metric-label">Total Bookings:</span>
            <span class="metric-value">{{ $totalBookings }}</span>
        </div>
        <div class="metric">
            <span class="metric-label">Confirmed Bookings:</span>
            <span class="metric-value">{{ $confirmedBookings }}</span>
        </div>
        <div class="metric">
            <span class="metric-label">Adult Guests:</span>
            <span class="metric-value">{{ $adultGuests }}</span>
        </div>
        <div class="metric">
            <span class="metric-label">Child Guests:</span>
            <span class="metric-value">{{ $childGuests }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Booking Statistics</div>
        <div class="metric">
            <span class="metric-label">Most Booked Room Type:</span>
            <span class="metric-value">{{ $mostBookedRoomType ?? 'N/A' }}</span>
        </div>
        <div class="metric">
            <span class="metric-label">Cancelled Bookings:</span>
            <span class="metric-value">{{ $cancelledBookings }}</span>
        </div>
        <div class="metric">
            <span class="metric-label">Cancellation Rate:</span>
            <span class="metric-value">{{ $cancellationPercentage }}%</span>
        </div>
        <div class="metric">
            <span class="metric-label">Total Checked Out:</span>
            <span class="metric-value">{{ $checkedOutCount }}</span>
        </div>
        <div class="metric">
            <span class="metric-label">Early Checked Out:</span>
            <span class="metric-value">{{ $earlyCheckedOutCount }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Payment Status Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentStatusData as $status => $count)
                <tr>
                    <td>{{ ucfirst($status) }}</td>
                    <td>{{ $count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>