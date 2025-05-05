<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
@include('Alert.loginSucess')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 color-background8 text-white position-sticky" id="sidebar" style="top: 0; height: 100vh; background-color: #0b573d background-color: #0b573d ">
            <div class="d-flex flex-column h-100">
                <!-- Logo Section -->
                <div class="d-flex flex-column align-items-center mt-5">
                    <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3 border border-5 border-white nav-link">
                    <p class="font-heading sidebar-text text-white" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;">Edit Profile</p>
                </div>
                
                <!-- Navigation Links -->
                <div class="d-flex flex-column gap-3 px-2 mt-4">
                    <a href="{{ route('staff.dashboard') }}" class="nav-link text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.dashboard') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                        <i class="fas fa-tachometer-alt fs-5"></i>
                        <span class="ms-3 font-paragraph">Dashboard</span>
                    </a>
                
                    <div class="dropdown w-100">
                        <a href="#" class="text-white nav-link text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar-alt fs-5 icon-center"></i>
                            <span class="nav-text ms-3 font-paragraph">Reservations</span>
                            <i class="fas fa-chevron-down nav-text ms-auto"></i>
                        </a>
                        <ul class="dropdown-menu w-100 border-0 shadow" style="background-color: #0d6e4c !important;">
                            <li><a class="nav-link text-white nav-link p-2 font-paragraph" href="{{ route('staff.reservation') }}">Reservations</a></li>
                            <li><a class="nav-link text-white nav-link p-2 font-paragraph" href="{{ route('staff.accomodations')}}">Room Availability</a></li>
                        </ul>
                    </div>
                
                    <a href="{{ route ('staff.guests')}}" class="text-white nav-link text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.guests') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                        <i class="fas fa-users fs-5 icon-center"></i>
                        <span class="nav-text ms-3 font-paragraph">Guests</span>
                    </a>
                </div>
            
                <div class="mt-auto mb-4 px-2">
                    <a href="{{ route('staff.logout')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link justify-content-end">
                        <span class="nav-text me-3 font-paragraph">Log Out</span>
                        <i class="fas fa-sign-out-alt fs-5 icon-center"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content  -->
         <div class="col-md-10 col-lg-10 py-4 px-4">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-semibold" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">RESERVATIONS</h1>
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
            <div class="card shadow-sm border-0 rounded-3 mb-4" style="height: 70px;">
                <div class="card-body">
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
                        </div>
                        @if(request('search'))
                        <a href="{{ route('staff.reservation') }}" class="btn btn-outline-secondary" style="height: 40px;">
                                Clear
                        </a>
                        @endif
                    </div>
                    </form>     
                </div>
            </div>

            <div id="noResultsMessage" class="alert alert-info text-center" style="display: none;">
                No reservations found
            </div>
            <!-- QR Scanner Modal -->
            <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrScannerModalLabel">QR Code Scanner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="card mx-auto border-0">
                                <div class="card-body">
                                <video id="preview" class="img-fluid mb-4" width="100%" height="auto"></video>
                                <p class="font-weight-bold">Scanned QR Code: <span id="qrResult" class="text-muted">None</span></p>
                                <button id="toggleCamera" class="btn btn-primary mb-3 w-100" onclick="toggleCamera()">Toggle Camera</button>
                                <!-- Stop Scanner button -->
                                <button id="stopScanner" class="btn btn-danger w-100" style="display: none;" onclick="stopScanner()">Stop Scanner</button>
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
                <!-- Modal for Checked Out Guests -->
                <div class="modal fade" id="checkedOutGuestsModal" tabindex="-1" aria-labelledby="checkedOutGuestsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="checkedOutGuestsModalLabel">Checked Out Guests</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Check-in Date</th>
                                                <th>Check-out Date</th>
                                                <th>Room</th>
                                                <th>Total Amount</th>
                                                <th>Reservation Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reservations as $reservation)
                                                @if($reservation->reservation_status == 'checked-out' || $reservation->reservation_status == 'cancelled')
                                                <tr>
                                                    <td>{{ $reservation->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('F j, Y') }}</td>
                                                    <td>
                                                    @php
                                                        $roomTypeIds = json_decode($reservation->package_room_type, true);
                                                        $roomNames = is_array($roomTypeIds) ? DB::table('accomodations')
                                                            ->whereIn('accomodation_id', $roomTypeIds)
                                                            ->pluck('accomodation_name')
                                                            ->toArray() : [];
                                                        $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                                                    @endphp
                                                    {{ count($roomNames) > 0 ? implode(', ', $roomNames) : '' }}
                                                    {{ count($accommodationNames) > 0 ? ', ' . implode(', ', $accommodationNames) : '' }}
                                                    </td>
                                                    <td>₱{{ number_format($reservation->amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-secondary">Checked Out</span>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons Container -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#checkedOutGuestsModal">
                        <i class="fas fa-history me-2"></i>View Checked Out Guests
                    </button>
                    
                    <!-- QR Scanner Button -->
                    <div class="ms-auto" style="width: 25%;">
                    <button type="button" id="qrScannerBtn" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#qrScannerModal" style="background-color: #0b573d">
                        <i class="fas fa-qrcode me-2"></i>Open QR Scanner
                    </button>

                    <!-- QR Scanner Modal -->
                    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="qrScannerModalLabel">QR Code Scanner</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="card mx-auto border-0">
                                        <div class="card-body">
                                            <video id="preview" class="img-fluid mb-4" width="100%" height="auto"></video>
                                            <p class="font-weight-bold">Scanned QR Code: <span id="qrResult" class="text-muted">None</span></p>
                                            <button id="toggleCamera" class="btn btn-primary mb-3 w-100" onclick="toggleCamera()">
                                                <i class="fas fa-camera me-2"></i>Toggle Camera
                                            </button>
                                            <button id="stopScanner" class="btn btn-danger w-100" style="display: none;" onclick="stopScanner()">
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
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Reservation Status</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Payment Status</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Proof of Payment</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            @if(in_array($reservation->reservation_status, ['pending', 'reserved', 'checked-in']))
                            <tr>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->name }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->email }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->mobileNo }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('F j, Y') }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ \Carbon\Carbon::parse($reservation->reservation_check_in)->format('g:i A') }}-{{ \Carbon\Carbon::parse($reservation->reservation_check_out)->format('g:i A') }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">
                                    @php
                                        $roomTypeIds = json_decode($reservation->package_room_type, true);
                                        $roomNames = is_array($roomTypeIds) ? DB::table('accomodations')
                                            ->whereIn('accomodation_id', $roomTypeIds)
                                            ->pluck('accomodation_name')
                                            ->toArray() : [];
                                        $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                                    @endphp
                                    {{ count($roomNames) > 0 ? implode(', ', $roomNames) : '' }}
                                    {{ count($accommodationNames) > 0 ? ', ' . implode(', ', $accommodationNames) : '' }}
                                </td>
                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->reference_num }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;">₱{{ number_format($reservation->amount ?? 0, 2)  }}</td>
                                <td class="text-center align-middle" style="font-size: x-small;" id="balance-{{ $reservation->id }}"></td>
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

                                <td class="text-center align-middle" style="font-size: x-small;">{{ $reservation->reservation_status }}</td>
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
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateReservationStatusModal{{ $reservation->id }}">
                                        <i class="fa-pencil fa-solid"></i>
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="updateReservationStatusModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="updateReservationStatusModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateReservationStatusModalLabel">Update Reservation Status</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('staff.updateStatus', $reservation->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount Paid</label>
                                                    <input type="number" class="form-control" name="amount" id="amount" step="0.01" min="0" value="{{ $reservation->amount }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="accomodation_type" class="form-label">Accommodation Name</label>
                                                    <select class="form-select" name="accomodation_type" id="accomodation_type" aria-label="Accommodation Type">
                                                        <option value="" disabled selected hidden>
                                                        @php
                                                            $roomTypeIds = json_decode($reservation->package_room_type, true);
                                                            $roomNames = is_array($roomTypeIds) ? DB::table('accomodations')
                                                                ->whereIn('accomodation_id', $roomTypeIds)
                                                                ->pluck('accomodation_name')
                                                                ->toArray() : [];
                                                            $accommodationNames = is_array($reservation->accommodations) ? $reservation->accommodations : [];
                                                        @endphp
                                                        {{ count($roomNames) > 0 ? implode(', ', $roomNames) : '' }}
                                                        {{ count($accommodationNames) > 0 ? ', ' . implode(', ', $accommodationNames) : '' }}
                                                        </option>
                                                        @foreach($accommodationTypes as $type)
                                                            <option value="{{ $type->accomodation_id }}" {{ $reservation->package_room_type == $type->accomodation_id ? 'selected' : '' }}>
                                                                {{ $type->accomodation_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="reservation_status" class="form-label">Reservation Status</label>
                                                    <select class="form-select" name="reservation_status" id="reservation_status" aria-label="Reservation Status">
                                                        <option value="" disabled selected hidden>Choose reservation status</option>
                                                        <option value="reserved" {{ $reservation->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                                        <option value="checked-in" {{ $reservation->status == 'checked-in' ? 'selected' : '' }}>Checked-In</option>
                                                        <option value="checked-out" {{ $reservation->status == 'checked-out' ? 'selected' : '' }}>Checked-Out</option>
                                                        <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </div>
                                                </select>
                                                <div class="mb-3 mt-2">
                                                    <label for="custom_message" class="form-label">Custom Message</label>
                                                    <textarea class="form-control" name="custom_message" id="custom_message" rows="3"></textarea>
                                                </div>
                                        </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary w-100">Update</button>
                                            </div>
                                            </form>
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

