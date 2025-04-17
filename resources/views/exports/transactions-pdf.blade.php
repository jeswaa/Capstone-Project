<!DOCTYPE html>
<html>
<head>
    <title>Transactions Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Lelo's Resort Transactions Report</h2>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Guest Name</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->reservation_check_in_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->reservation_check_out_date)->format('Y-m-d') }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->payment_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Transactions: {{ count($transactions) }}
    </div>
</body>
</html>