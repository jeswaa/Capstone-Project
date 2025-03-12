<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>

    <style>
        body {
            background-color: #c3d6a4;
        }
        .container {
            margin-top: 70px;
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
            margin-top: 20px;
            font-size: 16px;
            width: 120%;
        }
        #qr-code {
            display: block;
            margin: 50px auto;
            margin-left: 75px;
            padding: 50px;
        }

    </style>
</head>
<body>
    <div class="position-absolute top-0 start-0 mt-4 ms-5">
        <a href="{{ url()->previous() }}"><i class="fa-solid fa-circle-left fa-2x icon" style="color: black;"></i></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="summary-card">
                        <h4 class="text-center">SUMMARY</h4>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(isset($reservationDetails))
                            <p><strong>Reservation ID:</strong> {{ $reservationDetails->id }}</p>
                            <p><strong>Name:</strong> {{ $reservationDetails->name }}</p>
                            <p><strong>Email:</strong> {{ $reservationDetails->email }}</p>
                            <p><strong>Mobile No:</strong> {{ $reservationDetails->mobileNo }}</p>
                            <p><strong>Guests:</strong> {{ $reservationDetails->number_of_guests }}</p>
                            <p><strong>Room Preference:</strong> {{ $reservationDetails->room_preference }}</p>
                            <p><strong>Activities:</strong> {{ $reservationDetails->activities }}</p>
                            <p><strong>Reservation Date:</strong> {{ $reservationDetails->reservation_date }}</p>
                            <p><strong>Check-in Time:</strong> {{ $reservationDetails->reservation_check_in }}</p>
                            <p><strong>Check-out Time:</strong> {{ $reservationDetails->reservation_check_out }}</p>
                            <p><strong>Special Request:</strong> {{ $reservationDetails->special_request }}</p>
                            <p><strong>Payment Method:</strong> {{ $reservationDetails->payment_method }}</p>
                            <p><strong>Amount:</strong> {{ $reservationDetails->amount }}</p>
                            <p><strong>Reference Number:</strong> {{ $reservationDetails->reference_num }}</p>
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
        <div class="d-flex align-items-center p-2 ms-5">
            <p class="mb-1"><strong>STATUS:</strong> <span class="status-text">{{ $reservationDetails->payment_status }}</span></p>
        </div>
        <!-- Icon Container -->
<div class="justify-content-end ms-auto p-1" style="display: flex; justify-content: flex-end; align-items: center;">
    <i class="fa-solid fa-circle-user fs-1"></i>
</div>
    </div>

    <!-- QR Code Section -->
    <div class="text-center mt-3">
        <button class="generate-btn btn btn-dark" onclick="generateQRCode()">GENERATE QR</button>
        <canvas id="qr-code"></canvas>
        <button id="download-qr" class="btn btn-dark mb-5" style="display: none; margin-left: 75px;" onclick="downloadQRCode()">
            DOWNLOAD QR
        </button>
    </div>
</div>

<script>
    function generateQRCode() {
        let reservationId = '{{ $reservationDetails->id ?? '' }}';
        if (!reservationId) {
            alert('No reservation available!');
            return;
        }

        // Use Laravel-generated URL
        let summaryUrl = '{{ route("reservation.summary", ":id") }}'.replace(':id', reservationId);

        // Generate QR Code
        let qr = new QRious({
            element: document.getElementById('qr-code'),
            value: summaryUrl,
            size: 250
        });

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

