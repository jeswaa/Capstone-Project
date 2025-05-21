<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Report - {{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</title>
    <style>
        /* Remove media query to ensure styles apply both on screen and print */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background: white !important;
            color: #333;
        }
        .no-print {
            display: none !important;
        }
        .page-break {
            page-break-before: always;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0b573d;
            padding-bottom: 10px;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 15px;
        }
        .header h1 {
            color: #0b573d;
            font-size: 28px;
            margin: 10px 0;
        }
        .header h2 {
            color: #666;
            font-size: 20px;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #0b573d;
            border-bottom: 1px solid #0b573d;
            padding-bottom: 5px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-box {
            border: 1px solid #0b573d;
            padding: 15px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #0b573d;
            margin: 10px 0;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background-color: white;
        }
        th, td {
            border: 1px solid #0b573d;
            padding: 12px 8px;
            text-align: left;
        }
        th {
            background-color: #0b573d;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #0b573d;
            padding-top: 15px;
        }
        .footer p {
            margin: 5px 0;
        }
        
        /* Print-specific styles */
        @page {
            size: A4;
            margin: 2cm;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" class="logo">
        <h1>Monthly Report</h1>
        <h2>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</h2>
    </div>

    <div class="section">
        <div class="section-title">Monthly Overview</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">{{ $confirmedBookings }}</div>
                <div class="stat-label">Total Paid Bookings</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}</div>
                <div class="stat-label">Total Guests</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $adultGuests }}</div>
                <div class="stat-label">Adult Guests</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $childGuests }}</div>
                <div class="stat-label">Child Guests</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Booking Statistics</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">{{ $mostBookedRoomType ?? 'N/A' }}</div>
                <div class="stat-label">Most Booked Room Type</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $cancelledBookings }}</div>
                <div class="stat-label">Cancelled Bookings ({{ $cancellationPercentage }}%)</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $checkedOutCount }}</div>
                <div class="stat-label">Total Checked Out</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $earlyCheckedOutCount }}</div>
                <div class="stat-label">Early Checked Out</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Payment Status Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentStatusData as $status => $count)
                <tr>
                    <td>{{ ucfirst($status) }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ array_sum($paymentStatusData) > 0 ? number_format(($count / array_sum($paymentStatusData)) * 100, 1) : '0' }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generated on {{ date('F d, Y h:i A') }}</p>
        <p>Lelo's Resort Reservation and Management System</p>
    </div>
</body>
</html>