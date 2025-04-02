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
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-bottom: 20px;
        }
        
        .header-title {
            flex-grow: 1;
            text-align: center;
            margin: 0 30px; /* Increased horizontal spacing */
            color: #e9ffcc;
            font-size: 2rem;
            font-weight: bold;
        }
        
        .nav-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0B5D3B;
            border-radius: 50%;
            color: white;
            flex-shrink: 0;
        }
        
        .logo-img {
            width: 70px;
            height: 70px;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
        }
        @media (max-width: 768px) {
            .header-title {
                font-size: 1.8rem !important;
            }
            .mobile-logo {
                width: 60px !important;
                height: 60px !important;
            }
            .mobile-stack {
                flex-direction: column;
                gap: 1rem;
            }
            .qr-canvas {
                max-width: 250px !important;
                height: auto !important;
            }
            .font-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body class="bg-light font-paragraph" style="background: url('{{ asset('images/newbg.png') }}') no-repeat center center fixed; background-size: cover;">
    <div class="container mt-3 mt-md-5 px-2">
        <div class="d-flex justify-content-between align-items-center mobile-stack">
            <a href="{{ route('calendar') }}" class="text-decoration-none">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-home text-white fs-5"></i>
                </div>
            </a>
            <h1 class="text-center font-paragraph fw-bold header-title" style="color: #e9ffcc;">RESERVATION SUMMARY</h1>
            <a href="#">
                <img src="{{ asset('images/appicon.png') }}" alt="Logo" style="width: 60px; height: 60px;" class="rounded-circle mobile-logo">
            </a>
        </div>
    </div>

    <div class="container-sm mt-3 p-3 p-md-4 bg-white rounded shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
            <div class="flex-grow-1 text-center">
                <h2 class="text-success h4 h-md-3">RESERVATION DETAILS</h2>
            </div>
            <a href="{{ route('profile') }}" class="text-decoration-none ms-2 ms-md-3">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fa-solid fa-user text-white fs-5"></i>
                </div>
            </a>
        </div>
        <hr class="mx-auto mb-3 mb-md-4" style="border-top: 3px solid green; width: 85%;">

        <div class="row g-3">
            <!-- Left Column -->
            <div class="col-12 col-md-8">
                <div class="p-3 border rounded font-responsive">
                    @if(isset($reservationDetails))
                    <div class="mb-3">
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Name:</div>
                            <div class="col-7 col-md-8 text-wrap">{{ $reservationDetails->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Email:</div>
                            <div class="col-7 col-md-8 text-break">{{ $reservationDetails->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Mobile No:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->mobileNo }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Guests:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->total_guest ?? $reservationDetails->package_max_guests }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Room:</div>
                            <div class="col-7 col-md-8">
                                @if(!empty($reservationDetails->package_room_type))
                                    {{ implode(', ', $roomNames) }}
                                @else
                                    {{ implode(', ', $accommodations) }}
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Activities:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->package_activities ?? implode(', ', $activities) }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Date:</div>
                            <div class="col-7 col-md-8">{{ \Carbon\Carbon::parse($reservationDetails->reservation_check_in_date)->format('l, F jS, Y') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Check-in:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->reservation_check_in }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Check-out:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->reservation_check_out }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Special Request:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->special_request ?? 'None' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Payment Method:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->payment_method }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Amount:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->amount }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Reference No:</div>
                            <div class="col-7 col-md-8">{{ $reservationDetails->reference_num }}</div>
                        </div>
                        @if (!empty($reservationDetails->upload_payment))
                        <div class="row mb-2">
                            <div class="col-5 col-md-4 fw-bold text-success">Payment Proof:</div>
                            <div class="col-7 col-md-8">
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
            <div class="col-12 col-md-4 mt-3 mt-md-0">
                <div class="p-3 border rounded">
                    <div class="d-flex flex-column align-items-center mb-3">
                        <h5 class="mb-2">Status:</h5>
                        <span class="badge 
                            @if($reservationDetails->payment_status == 'paid') bg-success 
                            @elseif($reservationDetails->payment_status == 'pending') bg-warning
                            @elseif($reservationDetails->payment_status == 'booked') bg-primary
                            @else bg-danger 
                            @endif text-white">
                            {{ ucfirst($reservationDetails->payment_status) }}
                        </span>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-dark w-100 mb-3 py-2" onclick="generateQRCode()">
                            <i class="fa-solid fa-qrcode me-2"></i>GENERATE QR
                        </button>
                        <canvas id="qr-code" class="qr-canvas mb-3"></canvas>
                        <button id="download-qr" class="btn btn-success w-100 py-2" style="display: none;" onclick="downloadQRCode()">
                            <i class="fa-solid fa-download me-2"></i>DOWNLOAD QR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-4"></div>

    <script>
    function generateQRCode() {
        const container = document.querySelector('.col-md-4');
        const qrSize = Math.min(container.offsetWidth * 0.8, 300);

        let reservationData = {
            name: '{{ $reservationDetails->name }}',
            email: '{{ $reservationDetails->email }}',
            guests: '{{ !empty($reservationDetails->total_guest) ? $reservationDetails->total_guest : $reservationDetails->package_max_guests }}',
            package: '{{ $reservationDetails->package_name ?? "N/A" }}',
            room: `@if(!empty($reservationDetails->package_room_type))
                      {{ implode(", ", $roomNames) }}
                    @else
                      {{ implode(", ", $accommodations) }}
                    @endif`,
            date: '{{ $reservationDetails->reservation_check_in_date }}',
            checkIn: '{{ $reservationDetails->reservation_check_in }}',
            checkOut: '{{ $reservationDetails->reservation_check_out }}',
            amount: '{{ $reservationDetails->amount }}'
        };

        let qrContent = `
            Name: ${reservationData.name}
            Email: ${reservationData.email}
            Guests: ${reservationData.guests}
            Package: ${reservationData.package}
            Room: ${reservationData.room}
            Date: ${reservationData.date}
            Check-in: ${reservationData.checkIn}
            Check-out: ${reservationData.checkOut}
            Amount: ${reservationData.amount}
        `;

        let qr = new QRious({
            element: document.getElementById('qr-code'),
            value: qrContent,
            size: qrSize,
            background: 'white',
            foreground: 'black',
            level: 'H'
        });

        document.getElementById('download-qr').style.display = 'block';
        document.getElementById('qr-code').scrollIntoView({ behavior: 'smooth' });
    }

    function downloadQRCode() {
        let canvas = document.getElementById('qr-code');
        let link = document.createElement('a');
        link.download = 'reservation_qr.png';
        link.href = canvas.toDataURL();
        link.click();
    }
    </script>
</body>
</html>