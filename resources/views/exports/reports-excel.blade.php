
<table>
    <thead>
        <tr>
            <th colspan="4" style="font-size: 18px; font-weight: bold; text-align: center;">
                Lelo's Resort Monthly Report
            </th>
        </tr>
        <tr>
            <th colspan="4" style="font-size: 16px; text-align: center;">
                {{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}
            </th>
        </tr>
        <tr>
            <th colspan="4"></th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #0b573d; color: white;">Category</th>
            <th style="font-weight: bold; background-color: #0b573d; color: white;">Count</th>
            <th style="font-weight: bold; background-color: #0b573d; color: white;">Details</th>
            <th style="font-weight: bold; background-color: #0b573d; color: white;">Period</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Total Paid Bookings</td>
            <td>{{ $confirmedBookings }}</td>
            <td>Confirmed and paid reservations</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
        <tr>
            <td>Total Guests</td>
            <td>{{ ($adultGuests ?? 0) + ($childGuests ?? 0) }}</td>
            <td>Combined adult and child guests</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
        <tr>
            <td>Adult Guests</td>
            <td>{{ $adultGuests }}</td>
            <td>Total number of adult guests</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
        <tr>
            <td>Child Guests</td>
            <td>{{ $childGuests }}</td>
            <td>Total number of child guests</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
        <tr>
            <td>Cancelled Bookings</td>
            <td>{{ $cancelledBookings }}</td>
            <td>Cancellation Rate: {{ number_format($cancellationPercentage ?? 0, 1) }}%</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
        <tr>
            <td>Total Checked Out</td>
            <td>{{ $checkedOutCount }}</td>
            <td>Total number of completed check-outs</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
        <tr>
            <td>Early Checked Out</td>
            <td>{{ $earlyCheckedOutCount }}</td>
            <td>Guests who checked out before scheduled date</td>
            <td>{{ date('F Y', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)) }}</td>
        </tr>
    </tbody>
</table>