<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

    <style>
        body {
            background-color: #c3d6a4;
        }
        .container {
            margin-top: 20px;
        }
        .summary-card {
            background-color: #a0b482;
            padding: 10px;
            border-radius: 10px;
        }
        .status-section {
            text-align: right;
            margin-top: 20px;
        }
        .status-text {
            font-weight: bold;
            font-size: 18px;
        }
        .generate-btn {
            background-color: #555;
            color: white;
            padding: 15px 25px;
            border: 2px solid #333;
            border-radius: 20px;
            font-size: 16px;
            width: 100%;
        }
        #qr-code {
            display: block;
            padding: 50px;
        }

    </style>
</head>
<body class="color-background4">
    <div class="d-flex align-items-center ms-5">
        <a href="{{ route('calendar') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="To Calendar"><i class="fa-solid fa-circle-left fa-2x icon me-3 mt-5 icon-hover text-color-1"></i></a>
        <h1 class="text-center font-paragraph mt-5 ms-3">Reservation Summary</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="summary-card p-4 mb-3">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(isset($reservationDetails))
                            <p><strong>Name:</strong> {{ $reservationDetails->name }}</p>
                            <p><strong>Email:</strong> {{ $reservationDetails->email }}</p>
                            <p><strong>Mobile No:</strong> {{ $reservationDetails->mobileNo }}</p>
                            <p><strong>Number of Guests:</strong> 
                                @if(!empty($reservationDetails->total_guest))
                                    {{ $reservationDetails->total_guest }}
                                @endif
                                @if(!empty($reservationDetails->package_max_guests))
                                    {{ $reservationDetails->package_max_guests }}
                                @endif
                            </p>
                            <p><strong>Package:</strong> 
                                @if(!empty($reservationDetails->package_name))
                                    {{ $reservationDetails->package_name }}
                                @else
                                    No package
                                @endif
                            </p>
                            
                            <p><strong>Room:</strong>
                                @if(!empty($reservationDetails->package_room_type))
                                    @php
                                        $roomTypeIds = json_decode($reservationDetails->package_room_type, true);
                                        $roomNames = DB::table('accomodations')
                                            ->whereIn('accomodation_id', $roomTypeIds)
                                            ->pluck('accomodation_name')
                                            ->toArray();
                                    @endphp
                                    {{ implode(', ', $roomNames) }}
                                @else
                                    {{ implode(', ', $accommodations) }}
                                @endif
                            </p>

                            <p><strong>Activities:</strong> 
                                @if(!empty($reservationDetails->package_activities))
                                    {{ $reservationDetails->package_activities }}
                                @endif
                                @foreach($activities as $activity)
                                    {{ $activity }}
                                @endforeach
                            </p>
                            <p><strong>Reservation Date:</strong> {{ $reservationDetails->reservation_check_in_date }}</p>
                            <p><strong>Check-in Time:</strong> {{ $reservationDetails->reservation_check_in }}</p>
                            <p><strong>Check-out Time:</strong> {{ $reservationDetails->reservation_check_out }}</p>
                            <p><strong>Special Request:</strong> {{ $reservationDetails->special_request ?? 'No special request' }}</p>
                            <p><strong>Payment Method:</strong> {{ $reservationDetails->payment_method }}</p>
                            <p><strong>Amount:</strong> {{ $reservationDetails->amount }}</p>
                            <p><strong>Reference Number:</strong> {{ $reservationDetails->reference_num }}</p>
                            @if (!empty($reservationDetails->upload_payment))
                                <p><strong>Payment Proof:</strong> 
                                    <a class="text-decoration-none text-color-1 font-paragraph text-underline-left-to-right" href="{{ route('payment.proof', ['filename' => basename($reservationDetails->upload_payment)]) }}" target="_blank">
                                        View Proof
                                    </a>
                                </p>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                No reservations found.
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 ms-0">
                <div class="d-flex">
        <!-- Status Container -->
            <div class="d-flex justify-content-between align-items-center p-2 w-100 ms-4">
                <p class="mb-0">
                    <strong class="font-paragraph">Status:</strong> 
                    <span class="badge 
                        @if($reservationDetails->payment_status == 'paid') bg-success 
                        @elseif($reservationDetails->payment_status == 'pending') bg-warning
                        @elseif($reservationDetails->payment_status == 'booked') bg-primary
                        @else bg-danger 
                        @endif">
                        {{ ucfirst($reservationDetails->payment_status) }}
                    </span>
                </p>
                <!-- Icon Container -->
                <div class="ms-auto">
                    <a href="{{ route ('profile') }}"><i class="fa-solid fa-circle-user fs-1 text-color-1 icon-hover"></i></a>
                </div>
            </div>

        
    </div>
    <!-- QR Code Section -->
    <div class="text-center mt-3 ms-4">
        <button class="generate-btn btn btn-dark" onclick="generateQRCode()">GENERATE QR</button>
        <canvas id="qr-code"></canvas>
        <button id="download-qr" class="btn btn-dark mb-5" style="display: none;" onclick="downloadQRCode()">
            DOWNLOAD QR
        </button>
    </div>
</div>

<script>
    function generateQRCode() {
        let reservationId = '{{ $reservationDetails->id ?? '' }}'; // Get email instead of ID
        let name = '{{ $reservationDetails->name ?? '' }}';
        let email = '{{ $reservationDetails->email ?? '' }}';
        let totalGuest = '{{ !empty($reservationDetails->total_guest) ? $reservationDetails->total_guest : $reservationDetails->package_max_guest ?? '' }}';
        let package = '{{ $reservationDetails->package_name ?? 'N/A' }}';
        let roomType = '';

        @if(!empty($reservationDetails->package_room_type))
            roomType = '{{ DB::table('accomodations')->where('accomodation_id', $reservationDetails->package_room_type)->value('accomodation_name') }}';
        @else
            roomType = '{{ implode(", ", $accommodations) }}';
        @endif
        let reservationCheckInDate = '{{ $reservationDetails->reservation_check_in_date ?? '' }}';
        let reservationCheckIn = '{{ $reservationDetails->reservation_check_in ?? '' }}';
        let reservationCheckOut = '{{ $reservationDetails->reservation_check_out ?? '' }}';
        let specialRequest = '{{ $reservationDetails->special_request ?? '' }}';
        let paymentMethod = '{{ $reservationDetails->payment_method ?? '' }}';
        let amount = '{{ $reservationDetails->amount ?? '' }}';

        if (!reservationId) {
            alert('No reservation ID available!');
            return;
        }

        // Use Laravel-generated URL with email
        let summaryUrl = '{{ route("reservation.summary", ":id") }}'.replace(':id', encodeURIComponent(reservationId));

        // Generate QR Code
        let qr = new QRious({
            element: document.getElementById('qr-code'),
            value: `
                Name: ${name}
                Email: ${email}
                Total Guest: ${totalGuest}
                Package: ${package}
                Room Type: ${roomType}
                Reservation Date: ${reservationCheckInDate}
                Check-in Time: ${reservationCheckIn}
                Check-out Time: ${reservationCheckOut}
                Amount: ${amount}
            `,
            size: 300
        });

        // Center the QR code
        let qrCodeContainer = document.getElementById('qr-code').parentElement;
        qrCodeContainer.style.display = 'flex';
        qrCodeContainer.style.flexDirection = 'column';
        qrCodeContainer.style.justifyContent = 'center';
        qrCodeContainer.style.alignItems = 'center';

        // Show the download button
        document.getElementById('download-qr').style.display = 'inline-block';
    }
    function downloadQRCode() {
        let canvas = document.getElementById('qr-code');
        let link = document.createElement('a');
        link.href = canvas.toDataURL("image/png"); // Convert QR code to image
        link.download = "reservation_qr.png"; // File name
        link.click(); // Trigger download
    }
</script>

</body>
</html>

