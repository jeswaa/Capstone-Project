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
</head>
<body class="bg-light font-paragraph" style="background: url('{{ asset('images/newbg.png') }}') no-repeat center center fixed; background-size: cover;">
    <div class="container mt-5 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('calendar') }}" class="text-decoration-none">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-home text-white fs-4"></i>
                </div>
            </a>
            <h1 class="me-auto ms-3 font-paragraph fw-bold" style="color: #e9ffcc; font-size: 2.5rem;">RESERVATION SUMMARY</h1>
            <a href="#">
                <img src="{{ asset('images/appicon.png') }}" alt="Logo" style="width: 80px; height: 80px;" class="rounded-circle">
            </a>
        </div>
    </div>

    <div class="container-sm mt-4 p-4 bg-white rounded shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="flex-grow-1 text-center">
                <h2 class="text-success">RESERVATION DETAILS</h2>
            </div>
            <a href="{{ route('profile') }}" class="text-decoration-none ms-3">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-user text-white fs-4"></i>
                </div>
            </a>
        </div>
        <hr class="mx-auto mb-4" style="border-top: 3px solid green; width: 75%;">

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-md-8 order-md-1 order-1">
                <div class="p-4 border rounded">
                    @if(isset($reservationDetails))
                    <div class="mb-3">
                        <!-- Each row for label-value pair -->
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Name:</div>
                            <div class="col-8">{{ $reservationDetails->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Email:</div>
                            <div class="col-8">{{ $reservationDetails->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Mobile No:</div>
                            <div class="col-8">{{ $reservationDetails->mobileNo }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Guests:</div>
                            <div class="col-8">{{ $reservationDetails->total_guest ?? $reservationDetails->package_max_guests }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Room:</div>
                            <div class="col-8">
                                @if(!empty($reservationDetails->package_room_type))
                                    {{ implode(', ', $roomNames) }}
                                @else
                                    {{ implode(', ', $accommodations) }}
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Activities:</div>
                            <div class="col-8">{{ $reservationDetails->package_activities ?? implode(', ', $activities) }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Date:</div>
                            <div class="col-8">{{ \Carbon\Carbon::parse($reservationDetails->reservation_check_in_date)->format('l, F jS, Y') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Check-in:</div>
                            <div class="col-8">{{ $reservationDetails->reservation_check_in }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Check-out:</div>
                            <div class="col-8">{{ $reservationDetails->reservation_check_out }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Special Request:</div>
                            <div class="col-8">{{ $reservationDetails->special_request ?? 'None' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Payment Method:</div>
                            <div class="col-8">{{ $reservationDetails->payment_method }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Amount:</div>
                            <div class="col-8">₱{{ number_format($reservationDetails->amount, 2) }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Reference No:</div>
                            <div class="col-8">{{ $reservationDetails->reference_num }}</div>
                        </div>
                        @if (!empty($reservationDetails->upload_payment))
                        <div class="row mb-2">
                            <div class="col-4 fw-bold text-success">Payment Proof:</div>
                            <div class="col-8">
                                <a href="{{ route('payment.proof', ['filename' => basename($reservationDetails->upload_payment)]) }}" 
                                   target="_blank" 
                                   class="text-decoration-none text-success">
                                    View Proof
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="alert alert-warning">No reservations found</div>
                    @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4 order-md-2 order-2">
                <div class="p-4 border rounded">
                    <!-- Status Section -->
                    <div class="d-flex align-items-center mb-4">
                        <h5 class="mb-0">Status:</h5>
                        <span class="badge 
                            @if($reservationDetails->payment_status == 'paid') bg-success 
                            @elseif($reservationDetails->payment_status == 'pending') bg-warning
                            @elseif($reservationDetails->payment_status == 'booked') bg-primary
                            @else bg-danger 
                            @endif text-white">
                            {{ ucfirst($reservationDetails->payment_status) }}
                        </span>
                    </div>

                    <!-- Instructions Section -->
                    <div class="mb-3">
                        <h6 class="text-success mb-2">Instructions:</h6>
                        <div class="alert alert-info p-2" style="font-size: 0.9rem;">
                            <ol class="mb-0 ps-2">
                                <li class="mb-1">Download your QR code by clicking the button below</li>
                                <li class="mb-1">Present this QR code upon check-in at our resort</li>
                            </ol>
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <div class="text-center">
                        <canvas id="qr-code" class="mb-3"></canvas>
                        <button id="download-qr" class="btn btn-success w-100" onclick="downloadQRCode()">
                            <i class="fa-solid fa-download me-2"></i>DOWNLOAD QR
                        </button>
                    </div>
                </div>
            </div>

            <!-- Thank You Message - Will move to bottom on mobile -->
            <div class="col-12 order-md-3 order-3 mt-n3">
                <div class="p-4 bg-success text-white text-center rounded">
                    <h3 class="mb-2">Thank You for Choosing Lelo's Resort!</h3>
                    <p class="mb-0">We look forward to providing you with an exceptional experience during your stay.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-5"></div> <!-- Add padding at the bottom -->
<script>
    // Generate QR code on page load
    window.onload = function() {
        let email = '{{ $reservationDetails->email ?? '' }}';
        if (email) {
            let qr = new QRious({
                element: document.getElementById('qr-code'),
                value: `Email: ${email}`,
                size: 200  // Reduced size from 300 to 200
            });

            // Center the QR code
            let qrCodeContainer = document.getElementById('qr-code').parentElement;
            qrCodeContainer.style.display = 'flex';
            qrCodeContainer.style.flexDirection = 'column';
            qrCodeContainer.style.justifyContent = 'center';
            qrCodeContainer.style.alignItems = 'center';

            // Show download button
            document.getElementById('download-qr').style.display = 'inline-block';
        }
    };

    function generateQRCode() {
        let email = '{{ $reservationDetails->email ?? '' }}';

        if (!email) {
            alert('No email available!');
            return;
        }

        let qr = new QRious({
            element: document.getElementById('qr-code'),
            value: `Email: ${email}`,
            size: 300  // Reduced size from 300 to 200
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