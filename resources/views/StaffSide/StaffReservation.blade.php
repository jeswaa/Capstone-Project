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
</style>

<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
@include('Alert.loginSucess')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 color-background8 text-white position-sticky" id="sidebar" style="top: 0; height: 100vh; background-color: #0b573d background-color: #0b573d ">
            <div class="d-flex flex-column h-100">
            @include('Navbar.sidenavbarStaff')
            </div>
        </div>

        <!-- Main Content  -->
         <div class="col-md-10 col-lg-10 py-4 px-4">
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
                        <!-- Stay Type Dropdown Filter -->
                        <div class="mt-2" style="width: 200px;">
                            <select name="stay_type" class="form-select" onchange="this.form.submit()">
                                <option value="">All Stay Types</option>
                                <option value="overnight" {{ request('stay_type') == 'overnight' ? 'selected' : '' }}>Overnight</option>
                                <option value="one_day" {{ request('stay_type') == 'one_day' ? 'selected' : '' }}>One Day Stay</option>
                            </select>
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
            <div>
                <!-- Buttons Container -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- QR Scanner Button -->
                    <div class="ms-auto" style="width: 25%;">
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
            </div>

            <div class="mb-4 w-100">
                <div class="btn-group w-100" role="group" aria-label="Reservation Status Filters">
                    <a href="{{ route('staff.reservation', ['status' => 'all']) }}" 
                    class="btn w-100 filter-btn fw-semibold"
                    style="{{ request('status') == 'all' || !request('status') ? 'background-color: #0b573d; border: 1px solid #0b573d; color: white;' : 'background-color: transparent; border: 1px solid #0b573d; color: black;' }}">
                        All
                    </a>
                    <a href="{{ route('staff.reservation', ['status' => 'pending']) }}" 
                    class="btn w-100 filter-btn fw-semibold"
                    style="{{ request('status') == 'pending' ? 'background-color: #0b573d; border: 1px solid #0b573d; color: white;' : 'background-color: transparent; border: 1px solid #0b573d; color: black;' }}">
                        Pending
                    </a>
                    <a href="{{ route('staff.reservation', ['status' => 'reserved']) }}" 
                    class="btn w-100 filter-btn fw-semibold"
                    style="{{ request('status') == 'reserved' ? 'background-color: #0b573d; border: 1px solid #0b573d; color: white;' : 'background-color: transparent; border: 1px solid #0b573d; color: black;' }}">
                        Reserved
                    </a>
                    <a href="{{ route('staff.reservation', ['status' => 'checked-in']) }}" 
                    class="btn w-100 filter-btn fw-semibold"
                    style="{{ request('status') == 'checked-in' ? 'background-color: #0b573d; border: 1px solid #0b573d; color: white;' : 'background-color: transparent; border: 1px solid #0b573d; color: black;' }}">
                        Checked-in
                    </a>
                    {{-- Add Checked-out filter button --}}
                    <a href="{{ route('staff.reservation', ['status' => 'checked-out']) }}"
                    class="btn w-100 filter-btn fw-semibold"
                    style="{{ request('status') == 'checked-out' ? 'background-color: #0b573d; border: 1px solid #0b573d; color: white;' : 'background-color: transparent; border: 1px solid #0b573d; color: black;' }}">
                        Checked-out
                    </a>
                    {{-- Add Early Checked-out filter button --}}
                    <a href="{{ route('staff.reservation', ['status' => 'early-checked-out']) }}"
                    class="btn w-100 filter-btn fw-semibold"
                    style="{{ request('status') == 'early-checked-out' ? 'background-color: #0b573d; border: 1px solid #0b573d; color: white;' : 'background-color: transparent; border: 1px solid #0b573d; color: black;' }}">
                        Early Checked-out
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="card shadow-sm border-0 rounded-4 mb-4 mt-4 p-2">
                <table class="table table-hover table-striped ">
                    <thead>
                    <tr>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Name</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Email</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Phone Number</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Check in Date</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Check In-Out</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Room</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Ref Num</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Amount</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Balance</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Stay Type</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Reservation Status</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Payment Status</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Proof of Payment</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            @if(in_array($reservation->reservation_status, ['pending', 'reserved', 'checked-in','checked-out','early-checked-out']))
                            <tr>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->name }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->email }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->mobileNo }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('g:i A') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('g:i A') }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">
                                @php
                                    $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                                @endphp
                                {{ implode(', ', $accommodationNames) }}
                                </td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->reference_num }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">₱{{ number_format($reservation->amount ?? 0, 2)  }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;" id="balance-{{ $reservation->id }}"></td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->stay_type ?? "Unknown" }}</td>
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
                                    <span class="badge rounded-pill 
                                        {{ $reservation->reservation_status == 'reserved' ? 'bg-primary' : 
                                        ($reservation->reservation_status == 'checked-in' ? 'bg-success' : 
                                        ($reservation->reservation_status == 'checked-out' ? 'bg-secondary' : 
                                        ($reservation->reservation_status == 'cancelled' ? 'bg-danger' : 'bg-warning'))) }}">
                                        {{ ucfirst($reservation->reservation_status) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge rounded-pill 
                                        {{ $reservation->payment_status == 'pending' ? 'bg-warning' : 
                                        ($reservation->payment_status == 'paid' ? 'bg-success' : 
                                        ($reservation->payment_status == 'booked' ? 'bg-primary' : 'bg-danger')) }}">
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
                                <td class="d-flex align-items-center gap-2">
                                    <button type="button" 
                                        class="btn" 
                                        style="background-color: #0b573d; color: white; transition: all 0.3s ease;"
                                        onmouseover="this.style.backgroundColor='#083d2a'; this.style.transform='scale(1.05)'" 
                                        onmouseout="this.style.backgroundColor='#0b573d'; this.style.transform='scale(1)'"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateReservationStatusModal{{ $reservation->id }}">
                                        <i class="fa-pencil fa-solid"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-info"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewReservationModal{{ $reservation->id }}"
                                            style="background-color: #0b573d; color: white; border: none;">
                                        <i class="fas fa-eye"></i>
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
                                                        <option value="paid" {{ $reservation->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                        <option value="partial" {{ $reservation->status == 'partial' ? 'selected' : '' }}>Partial</option>
                                                        <option value="unpaid" {{ $reservation->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="reservation_status" class="form-label fw-semibold text-muted">
                                                        <i class="fas fa-calendar-check me-2"></i>Reservation Status
                                                    </label>
                                                    <select class="form-select form-select-lg border-2" name="reservation_status" id="reservation_status" style="border-color: #0b573d">
                                                        <option value="" disabled selected hidden>Choose reservation status</option>
                                                        <option value="reserved" {{ $reservation->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                                        <option value="checked-in" {{ $reservation->status == 'checked-in' ? 'selected' : '' }}>Checked-In</option>
                                                        <option value="early-checked-out" {{ $reservation->status == 'early-checked-out' ? 'selected' : '' }}>Early Checked-Out</option>
                                                        <option value="checked-out" {{ $reservation->status == 'checked-out' ? 'selected' : '' }}>Checked-Out</option>
                                                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                    <i class="fas fa-info-circle me-2"></i>Reservation Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Guest Information Card -->
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0"><i class="fas fa-user me-2"></i>Guest Information</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Name:</strong> {{ $reservation->name }}</p>
                                    <p class="mb-1"><strong>Email:</strong> {{ $reservation->email }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $reservation->mobileNo }}</p>
                                    <div class="form-group mt-3">
                                        <label for="total_guest" class="form-label">Total Guests:</label>
                                        <input type="number" class="form-control" id="total_guest" name="total_guest" 
                                            value="{{ $reservation->total_guest }}" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reservation Dates Card -->
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2"></i>Reservation Dates</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</p>
                                    <p class="mb-1"><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Accommodation Details Card -->
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0"><i class="fas fa-bed me-2"></i>Accommodation Details</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Room Type:</strong>
                                    @php
                                                        $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                                                    @endphp
                                                    {{ implode(', ', $accommodationNames) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Card -->
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0"><i class="fas fa-money-bill me-2"></i>Payment Information</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Total Amount:</strong> ₱{{ number_format($reservation->amount, 2) }}</p>
                                    <p class="mb-1"><strong>Payment Status:</strong>
                                        <span class="badge {{ $reservation->payment_status == 'paid' ? 'bg-success' : ($reservation->payment_status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($reservation->payment_status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>


                        <!-- Reservation Status Card -->
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Status</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Reservation Status:</strong>
                                        <span class="badge {{ $reservation->reservation_status == 'checked-in' ? 'bg-success' : ($reservation->reservation_status == 'reserved' ? 'bg-primary' : 'bg-secondary') }}">
                                            {{ ucfirst($reservation->reservation_status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="background-color: #0b573d;">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
</body>
</html>
