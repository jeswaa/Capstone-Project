<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
@include('Alert.loginSucess')
    @if (session('error'))
    <div class="alert alert-success  fade show position-absolute top-0 end-0 m-3 z-3 w-auto font-paragraph text-uppercase" role="alert">
        <strong>{{ session('error') }}</strong>
        <script>
            setTimeout(function() {
                document.querySelector('.alert').classList.remove('show');
            }, 5000);
        </script>
    </div>
    @endif
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
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $totalWalkInGuests ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Total Walk-In<br>Reservations
                            </p>
                        </div>
                        <i class="fas fa-calendar-check fs-1 text-white ms-auto"></i>
                    </div>
                </div>
                <!-- Checked-in Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $totalCheckedInGuests ?? 0}}</h2>
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
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $totalCheckedOutGuests ?? 0 }}</h2>
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
                    <!-- Button to trigger checked out guests modal -->
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#checkedOutGuestsModal">
                        <i class="fas fa-history me-2"></i>View Checked Out Guests
                    </button>

                    <!-- Button to add walk-in guest -->
                    <button type="button" class="btn btn-primary ms-auto" style="width: 200px;" data-bs-toggle="modal" data-bs-target="#addWalkInModal">
                        <i class="fas fa-user-plus me-2"></i>Add Walk-in Guest
                    </button>
                </div>
            </div>
            <!-- Modal for adding walkin guest -->
            <div class="modal fade" id="addWalkInModal" tabindex="-1" aria-labelledby="addWalkInModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #0b573d; color: white;">
                            <h5 class="modal-title" id="addWalkInModalLabel">Walk-in Guest</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('staff.walkin.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <!-- Left Side - Personal Information -->
                                    <div class="col-md-6 pe-4 border-end">
                                        <h6 class="mb-3 text-muted">Personal Information</h6>
                                        
                                        <!-- Personal Info Card -->
                                        <div class="card mb-4 border-success">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label fw-bold">Full Name</label>
                                                    <input type="text" class="form-control border-success" id="name" name="name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="address" class="form-label fw-bold">Address</label>
                                                    <input type="text" class="form-control border-success" id="address" name="address" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label fw-bold">Phone Number</label>
                                                    <input type="tel" class="form-control border-success" id="phone" name="mobileNo" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Guest Count Card -->
                                        <div class="card mb-4 border-success">
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="number_of_adult" class="form-label fw-bold">Number of Adults</label>
                                                    <input type="number" class="form-control border-success" id="number_of_adult" name="number_of_adult" min="0" value="0" required onchange="calculateTotalGuests()">
                                                    <small class="text-muted" id="adult_entrance_fee">Entrance Fee: ₱<span id="adult_fee">{{ $adultTransaction->entrance_fee ?? '0.00' }}</span></small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="number_of_children" class="form-label fw-bold">Number of Children</label>
                                                    <input type="number" class="form-control border-success" id="number_of_children" name="number_of_children" min="0" value="0" required onchange="calculateTotalGuests()">
                                                        <small class="text-muted" id="child_entrance_fee">Entrance Fee: ₱<span id="child_fee">{{ $kidTransaction->entrance_fee ?? '0.00' }}</span></small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="num_guests" class="form-label fw-bold">Total Guests</label>
                                                    <input type="number" class="form-control border-success" id="num_guests" name="total_guest" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="total_fee" class="form-label fw-bold">Total Entrance Fee</label>
                                                    <input type="text" class="form-control border-success" id="total_fee" name="total_fee" value="₱0.00" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Side - Reservation Details -->
                                    <div class="col-md-6 ps-4">
                                        <h6 class="mb-3 text-muted">Reservation Details</h6>
                                        <div class="mb-3">
                                            <label for="check_in_date" class="form-label fw-bold">Check-in Date</label>
                                            <input type="date" class="form-control border-success" id="check_in_date" name="check_in_date" 
                                                value="{{ date('Y-m-d') }}"
                                                min="{{ date('Y-m-d') }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="check_out_date" class="form-label fw-bold">Check-out Date</label>
                                            <input type="date" class="form-control border-success" id="check_out_date" name="check_out_date"
                                                value="{{ date('Y-m-d') }}"
                                                min="{{ date('Y-m-d') }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="session" class="form-label fw-bold">Session</label>
                                            <select class="form-select border-success" id="session" name="session" required onchange="updateTimes()">
                                                <option value="">Select Session</option>
                                                @if($morningSession = $transactions->firstWhere('session', 'Morning'))
                                                <option value="{{ $morningSession->session }}" 
                                                        data-start="{{ date('H:i:s', strtotime($morningSession->start_time)) }}" 
                                                        data-end="{{ date('H:i:s', strtotime($morningSession->end_time)) }}">
                                                    Morning
                                                </option>
                                                @endif
                                                @if($eveningSession = $transactions->firstWhere('session', 'Evening'))
                                                <option value="{{ $eveningSession->session }}" 
                                                        data-start="{{ date('H:i:s', strtotime($eveningSession->start_time)) }}" 
                                                        data-end="{{ date('H:i:s', strtotime($eveningSession->end_time)) }}">
                                                    Evening
                                                </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="check_in_time" class="form-label fw-bold">Check-in Time</label>
                                            <input type="time" class="form-control border-success" id="check_in_time" name="check_in_time" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="check_out_time" class="form-label fw-bold">Check-out Time</label>
                                            <input type="time" class="form-control border-success" id="check_out_time" name="check_out_time" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="room_type" class="form-label fw-bold">Room Type</label>
                                            <select class="form-select border-success" id="room_type" name="accomodation_id" required onchange="updateAmountAndTotal()">
                                                <option value="">Select Room Type</option>
                                                @foreach($accomodations as $accomodation)
                                                    @if($accomodation->accomodation_status === 'available')
                                                        <option value="{{ $accomodation->accomodation_id }}" data-price="{{ $accomodation->accomodation_price }}">
                                                            {{ $accomodation->accomodation_name }} - ₱{{ number_format($accomodation->accomodation_price, 2) }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a room type.
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="session" class="form-label fw-bold">Session</label>
                                            <select class="form-select border-success" id="session" name="session" required onchange="calculateTotalGuests(); updateAmountAndTotal();">
                                                <option value="Morning">Morning</option>
                                                <option value="Evening">Evening</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amount_paid" class="form-label fw-bold">Amount Paid</label>
                                            <input type="number" class="form-control border-success" id="amount_paid" name="amount" step="0.01" required>
                                        </div>
                                        <script>
                                            function updateAmountAndTotal() {
                                                // Kunin ang presyo ng room
                                                var roomSelect = document.getElementById('room_type');
                                                var amountInput = document.getElementById('amount_paid');
                                                var selectedOption = roomSelect.options[roomSelect.selectedIndex];
                                                var roomPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                                                
                                                // Kunin ang total entrance fee
                                                var totalFeeInput = document.getElementById('total_fee');
                                                var totalEntranceFee = parseFloat(totalFeeInput.value.replace(/[^\d.]/g, '')) || 0;
                                                
                                                // I-add ang room price at entrance fee
                                                var totalAmount = roomPrice + totalEntranceFee;
                                                amountInput.value = totalAmount.toFixed(2);
                                            }
                                            
                                            // Update amount kapag nagbago ang session, room, o guest count
                                            document.getElementById('session').addEventListener('change', function() {
                                                calculateTotalGuests();
                                                updateAmountAndTotal();
                                            });
                                            document.getElementById('number_of_adult').addEventListener('change', function() {
                                                calculateTotalGuests();
                                                updateAmountAndTotal();
                                            });
                                            document.getElementById('number_of_children').addEventListener('change', function() {
                                                calculateTotalGuests();
                                                updateAmountAndTotal();
                                            });
                                            document.getElementById('room_type').addEventListener('change', function() {
                                                updateAmountAndTotal();
                                            });
                                        
                                            // I-update din sa unang load
                                            document.addEventListener('DOMContentLoaded', function() {
                                                updateAmountAndTotal();
                                            });
                                        </script>
                                        <div class="mb-3">
                                            <label for="payment_method" class="form-label fw-bold">Payment Method</label>
                                            <select class="form-select border-success" id="payment_method" name="payment_method" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="cash">Cash</option>
                                                <option value="gcash">GCash</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="amount_paid" class="form-label fw-bold">Amount Paid</label>
                                            <input type="number" class="form-control border-success" id="amount_paid" name="amount" step="0.01" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="payment_status" class="form-label fw-bold">Payment Status</label>
                                            <select class="form-select border-success" id="payment_status" name="payment_status" required>
                                                <option value="">Select Payment Status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Partially paid">Partially Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reservation_status" class="form-label fw-bold">Reservation Status</label>
                                            <select class="form-select border-success" id="reservation_status" name="reservation_status" required>
                                                <option value="">Select Reservation Status</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Checked in">Checked In</option>
                                                <option value="Checked_out">Checked Out</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer mt-4">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn text-white" style="background-color: #0b573d;">Add Reservation</button>
                                </div>
                            </form>
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
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Address</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Phone Number</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Date</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Check In-Out</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Room</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Total Guest</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Amount</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Payment Method</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Reservation Status</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Payment Status</th>
                        <th class="text-center align-middle" style="font-size: 0.85rem;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($walkinGuest as $guest)
                            <tr>
                                <td>{{ $guest->name }}</td>
                                <td>{{ $guest->address }}</td>
                                <td>{{ $guest->mobileNo }}</td>
                                <td>{{ date('M d, Y', strtotime($guest->reservation_check_in_date)) }}</td>
                                <td>{{ date('h:i A', strtotime($guest->check_in_time)) }} - {{ date('h:i A', strtotime($guest->check_out_time)) }}</td>
                                <td>{{ $guest->accomodation_name }}</td>
                                <td>{{ $guest->total_guests }}</td>
                                <td>₱{{ number_format($guest->amount, 2) }}</td>
                                <td>{{ $guest->payment_method }}</td>
                                <td>
                                    @if($guest->reservation_status == 'Checked In')
                                        <span class="badge bg-success">{{ $guest->reservation_status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $guest->reservation_status }}</span>
                                    @endif
                                </td>
                                <td class="text-capitalize">
                                    @if($guest->payment_status == 'Paid')
                                        <span class="badge bg-success ">{{ $guest->payment_status }}</span>
                                    @elseif($guest->payment_status == 'Partially Paid')
                                        <span class="badge bg-warning">{{ $guest->payment_status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $guest->payment_status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm" style="background-color: #0b573d; color: white;" onclick="openEditModal({{ $guest->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $guest->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $guest->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #0b573d; color: white;">
                                                    <h5 class="modal-title" id="editModalLabel{{ $guest->id }}">Update Status</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('staff.updateWalkInStatus', $guest->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="payment_status{{ $guest->id }}" class="form-label fw-bold">Payment Status</label>
                                                            <select class="form-select border-success" id="payment_status{{ $guest->id }}" name="payment_status" required>
                                                                <option value="Paid" {{ old('payment_status', $guest->payment_status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                                                <option value="Partially Paid" {{ old('payment_status', $guest->payment_status) == 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="reservation_status{{ $guest->id }}" class="form-label fw-bold">Reservation Status</label>
                                                            <select class="form-select border-success" id="reservation_status{{ $guest->id }}" name="reservation_status" required>
                                                                <option value="Checked In" {{ old('reservation_status', $guest->reservation_status) == 'Checked In' ? 'selected' : '' }}>Checked In</option>
                                                                <option value="Checked Out" {{ old('reservation_status', $guest->reservation_status) == 'Checked Out' ? 'selected' : '' }}>Checked Out</option>
                                                                <option value="Cancelled" {{ old('reservation_status', $guest->reservation_status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn text-white" style="background-color: #0b573d;">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <script>
                                function openEditModal(id) {
                                    $('#editModal' + id).modal('show');
                                }
                                </script>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($walkinGuest->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $walkinGuest->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($walkinGuest->getUrlRange(1, $walkinGuest->lastPage()) as $page => $url)
                                @if ($page == $walkinGuest->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($walkinGuest->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $walkinGuest->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
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
    function updateTimes() {
        const sessionSelect = document.getElementById('session');
        const selectedOption = sessionSelect.options[sessionSelect.selectedIndex];
        
        if (selectedOption.value) {
            const startTime = selectedOption.getAttribute('data-start');
            const endTime = selectedOption.getAttribute('data-end');
            
            document.getElementById('check_in_time').value = startTime;
            document.getElementById('check_out_time').value = endTime;
        } else {
            document.getElementById('check_in_time').value = '';
            document.getElementById('check_out_time').value = '';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTimes();
    });
</script>
<script>
    function updateAmount() {
        var roomSelect = document.getElementById('room_type');
        var amountInput = document.getElementById('amount_paid');
        var selectedOption = roomSelect.options[roomSelect.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        if (price) {
            amountInput.value = price;
        } else {
            amountInput.value = '';
        }
    }
</script>
<script>
function calculateTotalGuests() {
    const adults = parseInt(document.getElementById('number_of_adult').value) || 0;
    const children = parseInt(document.getElementById('number_of_children').value) || 0;
    
    const sessionSelect = document.getElementById('session');
    if (!sessionSelect || !sessionSelect.value) {
        document.getElementById('adult_fee').textContent = '0.00';
        document.getElementById('child_fee').textContent = '0.00';
        document.getElementById('total_fee').value = '₱0.00';
        return;
    }

    const selectedSession = sessionSelect.value;

    // AJAX request to fetch updated fees
    $.ajax({
        url: "{{ route('session.fees') }}", // <-- Make sure this matches the route name
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            session: selectedSession
        },
        success: function(response) {
            try {
                const adultFee = parseFloat(response.adult_fee) || 0;
                const childFee = parseFloat(response.child_fee) || 0;

                document.getElementById('adult_fee').textContent = adultFee.toFixed(2);
                document.getElementById('child_fee').textContent = childFee.toFixed(2);

                const totalGuests = adults + children;
                const totalFee = (adults * adultFee) + (children * childFee);

                document.getElementById('num_guests').value = totalGuests;
                document.getElementById('total_fee').value = '₱' + totalFee.toFixed(2);
            } catch (error) {
                console.error('Error processing response:', error);
                document.getElementById('adult_fee').textContent = '0.00';
                document.getElementById('child_fee').textContent = '0.00';
                document.getElementById('total_fee').value = '₱0.00';
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            document.getElementById('adult_fee').textContent = '0.00';
            document.getElementById('child_fee').textContent = '0.00';
            document.getElementById('total_fee').value = '₱0.00';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const sessionSelect = document.getElementById('session');
    const adultInput = document.getElementById('number_of_adult');
    const childrenInput = document.getElementById('number_of_children');

    if (sessionSelect) sessionSelect.addEventListener('change', calculateTotalGuests);
    if (adultInput) adultInput.addEventListener('input', calculateTotalGuests);
    if (childrenInput) childrenInput.addEventListener('input', calculateTotalGuests);
});
</script>

</body>
</html>



