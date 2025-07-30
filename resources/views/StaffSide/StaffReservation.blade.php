<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .nav-link {
        position: relative;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background: #ffffff;
        left: 0;
        bottom: 0;
        transition: width 0.3s ease-in-out;
    }
    
    .nav-link:hover::after {
        width: 100%;
    }
    .fancy-link {
    text-decoration: none;
    font-weight: 600;
    position: relative;
    transition: color 0.3s ease;
}

.fancy-link::after {
    content: "";
    position: absolute;
    width: 0;
    height: 2px;
    left: 0;
    bottom: -2px;
    background-color: #0b573d;
    transition: width 0.3s ease;
}

.fancy-link:hover {
    color: #0b573d;
}

.fancy-link:hover::after {
    width: 100%;
}
.fancy-link.active::after {
    width: 100% !important;
}
.filter-btn {
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
    .transition-width {
        transition: all 0.3s ease;
    }
    #mainContent.full-width {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
.table td,
.table th {
  font-size: 0.8rem;
}
</style>

<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.errorLogin')
    @include('Alert.loginSuccessUser')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
         @include('Navbar.sidenavbarStaff')
        <!-- Main Content  -->
         <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-end align-items-end mb-2">
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
            </div>

            <hr class="border-5">
            <!-- Reservation Statistics -->
            <div class="d-flex gap-4 mb-4">
                <!-- Total Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $totalCount ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Total<br>Reservations
                            </p>
                        </div>
                        <i class="fas fa-calendar-check fs-1 text-white ms-auto"></i>
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $pendingCount ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Pending<br>Reservations
                            </p>
                        </div>
                        <i class="fas fa-clock fs-1 text-white ms-auto"></i>
                    </div>
                </div>

                <!-- Reserved Accomodations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $reservedCount ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Reserved<br>Reservations
                            </p>
                        </div>
                        <i class="fas fa-bookmark fs-1 text-white ms-auto"></i>
                    </div>
                </div>

                <!-- Checked-in Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $checkedInCount ?? 0}}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Checked-in<br>Reservations
                            </p>
                        </div>
                        <i class="fas fa-user-check fs-1 text-white ms-auto"></i>
                    </div>
                </div>

                <!-- Checked-out Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $checkedOutCount ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Checked-out<br>Reservations
                            </p>
                        </div>
                        <i class="fas fa-sign-out-alt fs-1 text-white ms-auto"></i>
                    </div>
                </div>
            </div>
            
            <!-- Search Bar -->
            <div class="d-flex gap-3">
                <div class="flex-grow-1">
                    <form action="{{ route('staff.reservation') }}" method="GET" class="mb-3">
                        <div class="input-group" style="height: 40px;">
                            <input type="text" 
                                id="searchInput"
                                name="search"
                                class="form-control border-start-0" 
                                placeholder="Search by name or email..."
                                style="border-color: #0b573d; height: 40px;"
                                value="{{ request('search') }}">

                            <span type="submit" class="input-group-text bg-white border-end-0" style="height: 40px;">
                                <button type="submit" class="btn btn-link text-dark p-0">
                                    <i class="fas fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                @if(request('search'))
                <a href="{{ route('staff.reservation') }}" class="btn btn-outline-secondary" style="height: 40px;">
                    Clear
                </a>
                @endif
            </div>
            <div id="noResultsMessage" class="alert alert-info text-center" style="display: none;">
                No reservations found
            </div>
            <!-- QR Scanner Modal -->
            <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px; border: none;">
                        <div class="modal-header" style="background-color: #0b573d; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <h5 class="modal-title" id="qrScannerModalLabel">
                                <i class="fas fa-qrcode me-2"></i>QR Code Scanner
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-4">
                            <div class="card mx-auto border-0 shadow-sm">
                                <div class="card-body">
                                    <video id="preview" class="img-fluid mb-4 rounded" width="100%" height="auto" style="border: 2px solid #0b573d;"></video>
                                    <div class="alert alert-info mb-3" style="background-color: #e8f5e9; border-color: #0b573d; color: #0b573d;">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Scanned QR Code: <span id="qrResult" class="fw-bold">None</span>
                                    </div>
                                    <button id="toggleCamera" class="btn mb-3 w-100" 
                                        style="background-color: #0b573d; color: white; transition: all 0.3s ease;"
                                        onmouseover="this.style.backgroundColor='#083d2a'" 
                                        onmouseout="this.style.backgroundColor='#0b573d'"
                                        onclick="toggleCamera()">
                                        <i class="fas fa-camera me-2"></i>Toggle Camera
                                    </button>
                                    <button id="stopScanner" class="btn w-100" 
                                        style="background-color: #dc3545; color: white; display: none; transition: all 0.3s ease;"
                                        onmouseover="this.style.backgroundColor='#bb2d3b'" 
                                        onmouseout="this.style.backgroundColor='#dc3545'"
                                        onclick="stopScanner()">
                                        <i class="fas fa-stop-circle me-2"></i>Stop Scanner
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                let isCameraOn = false;

                scanner.addListener('scan', function (content) {
                    try {
                        // Extract email from the QR content
                        const email = content.split('\n')
                            .find(line => line.toLowerCase().includes('email:'))
                            ?.replace('Email:', '')
                            ?.trim();
                        
                        if (email) {
                            // Update QR result display
                            document.getElementById("qrResult").innerText = email;
                            
                            // Set the email in search input
                            document.getElementById("searchInput").value = email;
                            
                            // Submit the form
                            document.querySelector('form').submit();
                            
                            // Stop scanner and close modal
                            stopScanner();
                            $('#qrScannerModal').modal('hide');
                            
                            // Show success message
                            swal("Success!", "Email found: " + email, "success");
                        } else {
                            swal("Error", "No email found in QR code", "error");
                        }
                    } catch (e) {
                        console.error('Error processing QR code:', e);
                        swal("Error", "Failed to process QR code", "error");
                    }
                });

                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        // Toggle camera on and off
                        document.getElementById("toggleCamera").addEventListener("click", function() {
                            if (isCameraOn) {
                                stopScanner();
                            } else {
                                scanner.start(cameras[0]);
                                isCameraOn = true;
                                document.getElementById("toggleCamera").style.display = 'none';
                                document.getElementById("stopScanner").style.display = 'block';
                            }
                        });
                    } else {
                        swal("Error", "No cameras found.", "error");
                    }
                }).catch(function (e) {
                    console.error(e);
                    swal("Error", "An error occurred while accessing the cameras.", "error");
                });

                // Stop scanner
                function stopScanner() {
                    scanner.stop();
                    isCameraOn = false;
                    document.getElementById("toggleCamera").style.display = 'block';
                    document.getElementById("stopScanner").style.display = 'none';
                }
            </script>
            
            <!-- Checked-out Guest -->
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Status Filter Dropdown -->
            <div class="d-flex gap-2">
                <form action="{{ route('staff.reservation') }}" method="GET" class="d-flex gap-2">
                    <select class="form-select" 
                            name="status" 
                            onchange="this.form.submit()"
                            style="border-color: #0b573d; font-weight: 500; width: 140%">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Reservation</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>Checked-in</option>
                        <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>Checked-out</option>
                        <option value="early-checked-out" {{ request('status') == 'early-checked-out' ? 'selected' : '' }}>Early Out</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    <!-- Stay Type Dropdown -->
                    <select name="stay_type" 
                            class="form-select" 
                            onchange="this.form.submit()"
                            style="border-color: #0b573d; font-weight: 500;">
                        <option value="">Stay Type</option>
                        <option value="overnight" {{ request('stay_type') == 'overnight' ? 'selected' : '' }}>Overnight</option>
                        <option value="one_day" {{ request('stay_type') == 'one_day' ? 'selected' : '' }}>Day Stay</option>
                    </select>
                </form>
            </div>

                <!-- QR Scanner Button -->
                <div style="width: 25%;">
                    <button type="button" id="qrScannerBtn" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#qrScannerModal" style="background-color: #0b573d">
                        <i class="fas fa-qrcode me-2"></i>Open QR Scanner
                    </button>

                    <!-- QR Scanner Modal -->
                    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 15px; border: none;">
                                <div class="modal-header" style="background-color: #0b573d; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                                    <h5 class="modal-title" id="qrScannerModalLabel">
                                        <i class="fas fa-qrcode me-2"></i>QR Code Scanner
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center p-4">
                                    <div class="card mx-auto border-0 shadow-sm">
                                        <div class="card-body">
                                            <video id="preview" class="img-fluid mb-4 rounded" width="100%" height="auto" style="border: 2px solid #0b573d;"></video>
                                            <div class="alert alert-info mb-3" style="background-color: #e8f5e9; border-color: #0b573d; color: #0b573d;">
                                                <i class="fas fa-info-circle me-2"></i>
                                                Scanned QR Code: <span id="qrResult" class="fw-bold">None</span>
                                            </div>
                                            <button id="toggleCamera" class="btn mb-3 w-100" 
                                                style="background-color: #0b573d; color: white; transition: all 0.3s ease;"
                                                onmouseover="this.style.backgroundColor='#083d2a'" 
                                                onmouseout="this.style.backgroundColor='#0b573d'"
                                                onclick="toggleCamera()">
                                                <i class="fas fa-camera me-2"></i>Toggle Camera
                                            </button>
                                            <button id="stopScanner" class="btn w-100" 
                                                style="background-color: #dc3545; color: white; display: none; transition: all 0.3s ease;"
                                                onmouseover="this.style.backgroundColor='#bb2d3b'" 
                                                onmouseout="this.style.backgroundColor='#dc3545'"
                                                onclick="stopScanner()">
                                                <i class="fas fa-stop-circle me-2"></i>Stop Scanner
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div class="card shadow-sm border-0 rounded-4 mb-4 mt-4 p-2">
                <table class="table table-hover table-striped table-responsive ">
                    <thead>
                    <tr>
                        <th class="text-center align-middle">Name</th>
                        <th class="text-center align-middle">Email</th>
                        <th class="text-center align-middle">Phone Number</th>
                        <th class="text-center align-middle">Date</th>
                        <th class="text-center align-middle">Check In-Out</th>
                        <th class="text-center align-middle">Room</th>
                        <th class="text-center align-middle">Room Qty</th>
                        <th class="text-center align-middle">Ref Num</th>
                        <th class="text-center align-middle">Amount</th>
                        <th class="text-center align-middle">Balance</th>
                        <th class="text-center align-middle">Stay Type</th>
                        <th class="text-center align-middle">Reservation Status</th>
                        <th class="text-center align-middle">Payment Status</th>
                        <th class="text-center align-middle">Proof of Payment</th>
                        <th class="text-center align-middle">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            @if(in_array($reservation->reservation_status, ['pending', 'reserved', 'checked-in','checked-out','early-checked-out','cancelled']))
                            <tr>
                                <td class="text-center align-middle">{{ $reservation->name }}</td>
                                <td class="text-center align-middle">{{ $reservation->email }}</td>
                                <td class="text-center align-middle">{{ $reservation->mobileNo }}</td>
                                <td class="text-center align-middle">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('M j, Y') }}</td>
                                <td class="text-center align-middle">{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('g:i A') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('g:i A') }}</td>
                                <td class="text-center align-middle">
                                @php
                                    $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                                @endphp
                                {{ implode(', ', $accommodationNames) }}
                                </td>
                                <td class="text-center align-middle">{{$reservation->quantity}}</td>
                                <td class="text-center align-middle">{{ $reservation->reference_num }}</td>
                                <td class="text-center align-middle">₱{{ number_format($reservation->amount ?? 0, 2)  }}</td>
                                <td class="text-center align-middle">₱{{ number_format($reservation->balance ?? 0, 2)  }}</td>
                                <td class="text-center align-middle">{{ $reservation->stay_type ?? "Unknown" }}</td>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let amountStr = "{{ $reservation->amount }}".replace(/[^\d.]/g, '');
                                        let amount = parseFloat(amountStr);
                                        let isPaid = "{{ $reservation->payment_status }}" === "paid";

                                        let balanceElement = document.getElementById("balance-{{ $reservation->id }}");

                                        if (!isNaN(amount)) {
                                            let balance = isPaid ? 0 : amount - (amount * 0.15);
                                            balanceElement.innerText = "₱ " + balance.toLocaleString('en-PH', { minimumFractionDigits: 2 });
                                        } else {
                                            balanceElement.innerText = "₱ 0.00";
                                        }
                                    });
                                </script>

                                <td class="text-center align-middle">
                                    <span class="badge rounded-pill py-2 px-1.5
                                        {{ $reservation->reservation_status == 'reserved' ? 'bg-warning-emphasis' : 
                                        ( $reservation->reservation_status == 'reserved' ? 'bg-primary' : 
                                        ($reservation->reservation_status == 'checked-in' ? 'bg-success' : 
                                        ($reservation->reservation_status == 'checked-out' ? 'bg-danger' : 
                                        ($reservation->reservation_status == 'cancelled' ? 'bg-danger' : 'bg-warning')))) }}" style="font-size: .7rem;">
                                        {{ ucfirst($reservation->reservation_status) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge rounded-pill py-2 px-3
                                        {{ $reservation->payment_status == 'pending' ? 'bg-warning-emphasis' : 
                                        ($reservation->payment_status == 'paid' ? 'bg-success' : 
                                        ($reservation->payment_status == 'partial' ? 'bg-warning' :
                                        ($reservation->payment_status == 'booked' ? 'bg-primary' : 'bg-danger'))) }}" style="font-size: .7rem;">
                                        {{ ucfirst($reservation->payment_status) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    @if ($reservation->upload_payment)
                                        <a href="{{ route('payment.proof', ['filename' => basename($reservation->upload_payment)]) }}" target="_blank">
                                            <p style="font-size: x-small;">View Proof</p>
                                        </a>
                                    @else
                                        <span class="text-muted">No proof uploaded</span>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center gap-2" style="height: 100px;">
                                    <button type="button" 
                                        class="btn btn-sm"
                                        style="background-color: #0b573d; color: white; transition: all 0.3s ease; height: 30px; width: 30px; padding: 0;"
                                        onmouseover="this.style.backgroundColor='#083d2a'; this.style.transform='scale(1.05)'" 
                                        onmouseout="this.style.backgroundColor='#0b573d'; this.style.transform='scale(1)'"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateReservationStatusModal{{ $reservation->id }}">
                                        <i class="fa-pencil fa-solid fa-xs"></i>
                                    </button>
                                    <button type="button" 
                                        class="btn btn-sm"
                                        style="background-color: #0b573d; color: white; transition: all 0.3s ease; height: 30px; width: 30px; padding: 0; border: none;"
                                        onmouseover="this.style.backgroundColor='#083d2a'; this.style.transform='scale(1.05)'" 
                                        onmouseout="this.style.backgroundColor='#0b573d'; this.style.transform='scale(1)'"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewReservationModal{{ $reservation->id }}">
                                        <i class="fas fa-eye fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="updateReservationStatusModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="updateReservationStatusModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-success text-white" style="background-color: #0b573d !important;">
                                            <h5 class="modal-title fw-bold" id="updateReservationStatusModalLabel">
                                                <i class="fas fa-edit me-2"></i>Update Status
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="{{ route('staff.updateStatus', $reservation->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label for="payment_status" class="form-label fw-semibold text-muted">
                                                        <i class="fas fa-money-bill me-2"></i>Payment Status
                                                    </label>
                                                    <select class="form-select form-select-lg border-2" name="payment_status" id="payment_status" style="border-color: #0b573d">
                                                        <option value="" disabled selected hidden>Choose payment status</option>
                                                        <option value="paid" {{ old('payment_status', $reservation->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                                        <option value="partial" {{ old('payment_status', $reservation->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                                        <option value="unpaid" {{ old('payment_status', $reservation->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="reservation_status" class="form-label fw-semibold text-muted">
                                                        <i class="fas fa-calendar-check me-2"></i>Reservation Status
                                                    </label>
                                                <select class="form-select form-select-lg border-2" name="reservation_status" id="reservation_status" style="border-color: #0b573d">
                                                    <option value="" disabled selected hidden>Choose reservation status</option>
                                                    <option value="reserved" {{ $reservation->reservation_status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                                    <option value="checked-in" {{ $reservation->reservation_status == 'checked-in' ? 'selected' : '' }}>Checked-In</option>
                                                    <option value="early-checked-out" {{ $reservation->reservation_status == 'early-checked-out' ? 'selected' : '' }}>Early Checked-Out</option>
                                                    <option value="checked-out" {{ $reservation->reservation_status == 'checked-out' ? 'selected' : '' }}>Checked-Out</option>
                                                    <option value="cancelled" {{ $reservation->reservation_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="custom_message" class="form-label fw-semibold text-muted">
                                                        <i class="fas fa-comment-alt me-2"></i>Custom Message
                                                    </label>
                                                    <textarea class="form-control border-2" name="custom_message" id="custom_message" rows="3" style="border-color: #0b573d" placeholder="Enter additional notes or message..."></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-success w-100 py-3 fw-bold text-uppercase" style="background-color: #0b573d">
                                                    <i class="fas fa-check-circle me-2"></i>Update Status
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- View Reservation Details Modal -->
                                <div class="modal fade" id="viewReservationModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0">
                                            <div class="modal-header" style="background-color: #0b573d; color: white;">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-calendar-plus me-2"></i>Extend Reservation Stay
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('staff.extendReservation', $reservation->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                                                    <input type="hidden" name="additional_payment" id="additional_payment" value="0">
                                                    <div class="row g-3">
                                                        <!-- Current Reservation Details -->
                                                        <div class="col-md-6">
                                                            <div class="card h-100 shadow-sm border-0">
                                                                <div class="card-header" style="background-color: #0b573d; color: white;">
                                                                    <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Current Reservation</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="mb-2"><strong>Guest Name:</strong> {{ $reservation->name }}</p>
                                                                    <p class="mb-2"><strong>Email:</strong> {{ $reservation->email }}</p>
                                                                    <p class="mb-2"><strong>Room Name:</strong> {{ $reservation->accomodation_name }}</p>
                                                                    <p class="mb-2"><strong>Current Check-in:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</p>
                                                                    <p class="mb-2"><strong>Current Check-out:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Extension Form -->
                                                        <div class="col-md-6">
                                                            <div class="card h-100 shadow-sm border-0">
                                                                <div class="card-header" style="background-color: #0b573d; color: white;">
                                                                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-plus me-2"></i>Extend Stay</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">New Check-out Date</label>
                                                                        <input type="date" class="form-control"         name="new_checkout_date" 
                                                                            min="{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->addDay()->format('Y-m-d') }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Additional Charges Card -->
                                                        <div class="col-12">
                                                            <div class="card shadow-sm border-0">
                                                                <div class="card-header" style="background-color: #0b573d; color: white;">
                                                                    <h6 class="fw-bold mb-0"><i class="fas fa-money-bill me-2"></i>Extension Charges</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <p class="mb-2"><strong>Current Total:</strong> ₱{{ number_format($reservation->amount, 2) }}</p>
                                                                            <p class="mb-2"><strong>Extension Fee (per night):</strong> ₱<span id="extension_fee">{{ number_format($reservation->accomodation_price, 2) ?? '0.00' }}</span></p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p class="mb-2"><strong>Additional Nights:</strong> <span id="additional_nights">0</span></p>
                                                                            <p class="mb-2"><strong>Total Extension Cost:</strong> ₱<span id="total_extension_cost" name="additional_payment">0.00</span></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer" style="background-color: #f8f9fa;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn text-white" style="background-color: #0b573d;">
                                                        <i class="fas fa-check me-2"></i>Confirm Extension
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{ $reservations->links('pagination::bootstrap-4') }}
                        </ul>
                    </nav>
                </div>
                </div>
         </div>
    </div>
    

    <script>
        function openModal(id) {
            document.getElementById('id').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }

        function closeModal() {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.hide();
        }
        function openReservationStatusModal(id) {
            document.getElementById('reservation_id').value = id;
            var myModal = new bootstrap.Modal(document.getElementById('reservationStatusModal'));
            myModal.show();
        }

        function closeReservationStatusModal() {
            var myModal = new bootstrap.Modal(document.getElementById('reservationStatusModal'));
            myModal.hide();
        }
        
    </script>
    <script>
        @if(isset($reservation))
        document.querySelector('input[name="new_checkout_date"]')?.addEventListener('change', function() {
            const currentCheckOut = new Date('{{ $reservation->reservation_check_out_date }}');
            const newCheckOut = new Date(this.value);
            
            const diffTime = newCheckOut - currentCheckOut;
            const diffDays = Math.max(0, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
            
            const extensionFee = {{ $reservation->accomodation_price ?? 0 }};
            const totalExtensionCost = extensionFee * diffDays;
            
            document.getElementById('additional_nights').textContent = diffDays;
            document.getElementById('total_extension_cost').textContent = totalExtensionCost.toFixed(2);
            
            // Calculate new total amount by adding original amount and extension cost
            const originalAmount = {{ $reservation->amount ?? 0 }};
            const newTotalAmount = originalAmount + totalExtensionCost;
            
            // Update the hidden input field for form submission
            document.getElementById('additional_payment').value = totalExtensionCost.toFixed(2);
        });
        @endif
    </script>
</body>
</html>
