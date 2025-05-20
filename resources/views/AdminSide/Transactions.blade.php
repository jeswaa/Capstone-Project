<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Transactions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .fee-list::-webkit-scrollbar {
        width: 8px;
    }
    
    .fee-list::-webkit-scrollbar-track {
        background: #e9ecef;
        border-radius: 4px;
    }
    
    .fee-list::-webkit-scrollbar-thumb {
        background: #0b573d;
        border-radius: 4px;
    }

    .fee-list::-webkit-scrollbar-thumb:hover {
        background: #083d2a;
    }

    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    margin-top: 20px;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #fff;
    color: #0b573d;
    border: 2px solid #0b573d;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.pagination .page-link:hover {
    background-color: #0b573d;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(11, 87, 61, 0.2);
}

.pagination .page-item.active .page-link {
    background-color: #0b573d;
    color: #fff;
    border-color: #0b573d;
}

.pagination .page-item.disabled .page-link {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #6c757d;
    cursor: not-allowed;
    pointer-events: none;
}

/* Navigation arrows styling */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    font-size: 1.2rem;
    font-weight: bold;
}
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.loginSucess')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- Sidebar -->
        @include('Navbar.sidenavbar')
        <!-- Main Content -->
         <div class="col-md-9 col-lg-10 py-4 px-4">
                <!-- Heading and Search Bar -->
                <div class="d-flex justify-content-end align-items-center mb-2">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
                </div>

                <hr class="border-5">
                <!-- Payment Table -->
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-semibold text-uppercase mb-0" style="font-size: 40px; color: #0b573d; font-family: 'Anton', sans-serif; letter-spacing: 0.2em;">Transactions Management</h1>
                        
                        <div class="btn-group">
                            <a href="{{ route('transactions.export.excel') }}" class="btn btn-success btn-sm me-2 rounded-2" style="font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-file-excel"></i> Excel
                            </a>
                            <a href="{{ route('transactions.export.pdf') }}" class="btn btn-danger btn-sm me-2 rounded-2" style="font-size: 14px; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                            <button onclick="printContent()" class="btn btn-primary btn-sm rounded-2" style="font-size: 14px; background-color: #0b573d; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <!-- Export Buttons -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="btn-group">

                            <script>
                                function printContent() {
                                    // Create a new window for printing
                                    var printWindow = window.open('', '_blank');
                                    
                                    // Get the content to print
                                    var contentToPrint = document.querySelector('.table-responsive').innerHTML;
                                    
                                    // Add some basic styling
                                    var styles = `
                                        <style>
                                            table { 
                                                width: 100%;
                                                border-collapse: collapse;
                                            }
                                            th, td {
                                                border: 1px solid #ddd;
                                                padding: 8px;
                                                text-align: left;
                                            }
                                            th {
                                                background-color: #0b573d;
                                                color: white;
                                            }
                                            .badge {
                                                padding: 5px 10px;
                                                border-radius: 20px;
                                                color: white;
                                            }
                                            .bg-success { background-color: #198754; }
                                            .bg-warning { background-color: #ffc107; }
                                            .bg-primary { background-color: #0d6efd; }
                                            .bg-danger { background-color: #dc3545; }
                                            /* Hide pagination when printing */
                                            .pagination, nav[aria-label="Page navigation"] {
                                                display: none !important;
                                            }
                                            @media print {
                                                body { print-color-adjust: exact; }
                                            }
                                        </style>
                                    `;
                                    
                                    // Write the content to the new window
                                    printWindow.document.write('<html><head><title>Lelo\'s Resort - Transactions</title>' + styles + '</head><body>');
                                    printWindow.document.write('<h2 style="text-align: center; margin-bottom: 20px;">Lelo\'s Resort - Transactions Report</h2>');
                                    printWindow.document.write(contentToPrint);
                                    printWindow.document.write('</body></html>');
                                    
                                    // Wait for content to load then print
                                    printWindow.document.close();
                                    printWindow.onload = function() {
                                        printWindow.focus();
                                        printWindow.print();
                                        printWindow.close();
                                    };
                                }
                            </script>
                        </div>
                    </div>
                    <!-- Filter and Entrance Fee Section -->
                    <div class="row mb-4">
                        <div class="col-md-7">
                            <div class="card shadow-lg border-0 rounded-4 p-4 bg-white bg-opacity-90 h-100">
                                <div class="d-flex align-items-center mb-4">
                                    <i class="fas fa-filter me-2 text-success fs-4"></i>
                                    <h5 class="mb-0 fw-bold" style="color: #0b573d;">Filter Transactions</h5>
                                </div>

                                <form action="{{ route('transactions') }}" method="GET" class="mt-3">
                                    <div class="row g-4">
                                        <!-- Date Range Filter -->
                                        <div class="col-md-3">
                                            <label for="start_date" class="form-label fw-semibold">Start Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="far fa-calendar-alt text-muted"></i>
                                                </span>
                                                <input type="date" class="form-control border-start-0" id="start_date" name="start_date" value="{{ request('start_date') }}" style="height: 45px;">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="far fa-calendar-alt text-muted"></i>
                                                </span>
                                                <input type="date" class="form-control border-start-0" id="end_date" name="end_date" value="{{ request('end_date') }}" style="height: 45px;">
                                            </div>
                                        </div>

                                        <!-- Guest Name Filter -->
                                        <div class="col-md-3">
                                            <label for="guest_name" class="form-label fw-semibold">Guest Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="far fa-user text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0" id="guest_name" name="guest_name" placeholder="Enter guest name" value="{{ request('guest_name') }}" style="height: 45px;">
                                            </div>
                                        </div>

                                        <!-- Payment Status Filter -->
                                        <div class="col-md-3">
                                            <label for="payment_status" class="form-label fw-semibold">Payment Status</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0" style="height: 45px;">
                                                    <i class="fas fa-money-check-alt text-muted"></i>
                                                </span>
                                                <select class="form-select border-start-0" id="payment_status" name="payment_status" style="height: 45px;">
                                                    <option value="">All</option>
                                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                                    <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Filter Buttons -->
                                        <div class="col-12 d-flex justify-content-end mt-4">
                                            <a href="{{ route('transactions') }}" class="btn btn-outline-secondary px-4 py-2 me-2" style="width: 120px;">
                                                <i class="fas fa-undo-alt me-2"></i>Reset
                                            </a>
                                            <button type="submit" class="btn btn-success px-4 py-2" style="width: 120px;">
                                                <i class="fas fa-filter me-2"></i>Apply
                                            </button>
                                        </div>
                                    </div>
                                    @if(request('year'))
                                        <input type="hidden" name="year" value="{{ request('year') }}">
                                    @endif
                                </form>
                            </div>
                        </div>
                        <!-- Entrance Fee Section -->
                        <div class="col-md-5">
                            <div class="card shadow-lg border-0 rounded-4 p-2 bg-white bg-opacity-90 h-100" >
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="card-title fw-bold" style="color: #0b573d;">
                                            <i class="fas fa-ticket-alt me-2"></i>Entrance Fee
                                        </h6>
                                        <div>
                                            <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#addEntranceFeeModal">
                                                <i class="fas fa-plus-circle fs-5"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="entrance-fees">
                                        <!-- Dynamic Filterization -->
                                        <div class="mb-3">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                <select class="form-select form-select-sm" id="sessionFilter">
                                                    <option value="">All Sessions</option>
                                                    @foreach($transactions->pluck('session')->unique() as $session)
                                                        <option value="{{ $session }}">{{ ucfirst($session) }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                <div class="col-6">
                                                <select class="form-select form-select-sm" id="typeFilter">
                                                    <option value="">All Types</option>
                                                    @foreach($transactions->pluck('type')->unique() as $type)
                                                        <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="fee-list" style="height: 100px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #0b573d #e9ecef;">
                                            @foreach($transactions as $fee)
                                                <div class="fee-item mb-2 p-3 border rounded hover-shadow" 
                                                    data-id="{{ $fee->id }}"
                                                    data-session="{{ $fee->session }}"
                                                    data-type="{{ $fee->type }}"
                                                    style="transition: all 0.3s ease;">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <span class="fw-bold text-success">
                                                                <i class="fas fa-clock me-2"></i>
                                                                {{ ucfirst($fee->session) }} Session - {{ ucfirst($fee->type) }}
                                                            </span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="fs-6 me-3 fw-bold">₱{{ number_format($fee->entrance_fee, 2) }}</span>
                                                            <a href="#" class="edit-entrance-fee text-primary" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editEntranceFeeModal"
                                                                data-id="{{ $fee->id }}"
                                                                data-session="{{ $fee->session }}"
                                                                data-start-time="{{ $fee->start_time }}"
                                                                data-end-time="{{ $fee->end_time }}"
                                                                data-type="{{ $fee->type }}"
                                                                data-age-range="{{ $fee->age_range }}"
                                                                data-entrance-fee="{{ $fee->entrance_fee }}">
                                                                <i class="fas fa-edit fs-5"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Entrance Fee Modal -->
                    <div class="modal fade" id="addEntranceFeeModal" tabindex="-1" aria-labelledby="addEntranceFeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addEntranceFeeModalLabel">Edit Entrance Fee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="entranceFeeForm" method="POST" action="{{ route('updatePrice') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="session" class="form-label">Session</label>
                                            <select class="form-select" id="session" name="session" required>
                                                <option value="Morning Session">Morning Session</option>
                                                <option value="Night Session">Night Session</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="end_time" class="form-label">End Time</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-select" id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="adult">Adult</option>
                                                <option value="kid">Kid</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="age_range" class="form-label">Age Range</label>
                                            <select class="form-select" id="age_range" name="age_range" required>
                                                <option value="">Select Age Range</option>
                                                <option value="0-3">0-3 years old</option>
                                                <option value="4-12">4-12 years old</option>
                                                <option value="13-59">13-59 years old</option>
                                                <option value="60+">60+ years old</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="entrance_fee" class="form-label">Entrance Fee</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₱</span>
                                                <input type="number" class="form-control" id="entrance_fee" name="entrance_fee" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Entrance Fee Modal -->
                    <div class="modal fade" id="editEntranceFeeModal" tabindex="-1" aria-labelledby="editEntranceFeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="editEntranceFeeModalLabel">
                                        <i class="fas fa-edit me-2"></i>Edit Entrance Fee
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editEntranceFeeForm" method="POST" action="{{ route('updatePrice') }}">
                                        @csrf
                                        <input type="hidden" id="edit_fee_id" name="fee_id">
                                        
                                        <div class="mb-3">
                                            <label for="edit_session" class="form-label fw-bold">
                                                <i class="fas fa-clock me-2 text-success"></i>Session
                                            </label>
                                            <select class="form-select border-2" id="edit_session" name="session" style="height: 45px;" required>
                                                <option value="Morning">Morning Session</option>
                                                <option value="Evening">Evening Session</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_start_time" class="form-label fw-bold">
                                                <i class="far fa-clock me-2 text-success"></i>Start Time
                                            </label>
                                            <input type="time" class="form-control border-2" id="edit_start_time" name="start_time" style="height: 45px;" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_end_time" class="form-label fw-bold">
                                                <i class="far fa-clock me-2 text-success"></i>End Time
                                            </label>
                                            <input type="time" class="form-control border-2" id="edit_end_time" name="end_time" style="height: 45px;" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_type" class="form-label fw-bold">
                                                <i class="fas fa-users me-2 text-success"></i>Type
                                            </label>
                                            <select class="form-select border-2" id="edit_type" name="type" style="height: 45px;" required>
                                                <option value="">Select Guest</option>
                                                <option value="adult">Adult</option>
                                                <option value="kid">Child</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_age_range" class="form-label fw-bold">
                                                <i class="fas fa-users me-2 text-success"></i>Age Range
                                            </label>
                                            <select class="form-select border-2" id="edit_age_range" name="age_range" style="height: 45px;" required>
                                                <option value="">Select Age Range</option>
                                                <option value="13 years - 18 years above">Adult (13 years - 18 years above)</option>
                                                <option value="12 years old below">Child (12 years old below)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_entrance_fee" class="form-label fw-bold">
                                                <i class="fas fa-dollar-sign me-2 text-success"></i>Entrance Fee
                                            </label>
                                            <div class="input-group" style="height: 45px;">
                                                <span class="input-group-text" style="height: 46px;" >₱</span>
                                                <input type="number" class="form-control border-2" id="edit_entrance_fee" name="entrance_fee" style="height: 46px;" required>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save me-2"></i>Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Get all edit buttons
                        const editButtons = document.querySelectorAll('.edit-entrance-fee');
                        
                        // Check if edit buttons exist before adding event listeners
                        if (editButtons && editButtons.length > 0) {
                            // Add click event listener to each edit button
                            editButtons.forEach(button => {
                                button.addEventListener('click', function() {
                                    // Get data attributes from the button
                                    const id = this.getAttribute('data-id');
                                    const session = this.getAttribute('data-session');
                                    const startTime = this.getAttribute('data-start-time');
                                    const endTime = this.getAttribute('data-end-time');
                                    const type = this.getAttribute('data-type');
                                    const ageRange = this.getAttribute('data-age-range');
                                    const entranceFee = this.getAttribute('data-entrance-fee');
                                    
                                    // Check if form elements exist before setting values
                                    const idField = document.getElementById('edit_fee_id');
                                    const sessionField = document.getElementById('edit_session');
                                    const startTimeField = document.getElementById('edit_start_time');
                                    const endTimeField = document.getElementById('edit_end_time');
                                    const typeField = document.getElementById('edit_type');
                                    const ageRangeField = document.getElementById('edit_age_range');
                                    const entranceFeeField = document.getElementById('edit_entrance_fee');
                                    
                                    // Set values in the form if elements exist
                                    if (idField) idField.value = id;
                                    if (sessionField) sessionField.value = session;
                                    if (startTimeField) startTimeField.value = startTime;
                                    if (endTimeField) endTimeField.value = endTime;
                                    if (typeField) typeField.value = type;
                                    if (ageRangeField) ageRangeField.value = ageRange;
                                    if (entranceFeeField) entranceFeeField.value = entranceFee;
                                });
                            });
                        } else {
                            console.log('No edit entrance fee buttons found on the page');
                        }
                    });
                    </script>
                    
                    
                    <!-- Table -->
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr class="text-white" style="background-color: #0b573d;">
                                            <th scope="col" class="py-3 px-4">Guest Name</th>
                                            <th scope="col" class="py-3 px-4">Rooms Booked</th>
                                            <th scope="col" class="py-3 px-4">Amount Paid</th>
                                            <th scope="col" class="py-3 px-4">Remaining Balance</th>
                                            <th scope="col" class="py-3 px-4">Reference Number</th>
                                            <th scope="col" class="py-3 px-4">Payment Mode</th>
                                            <th scope="col" class="py-3 px-4">Check In - Out Date</th>
                                            <th scope="col" class="py-3 px-4">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reservationDetails as $transaction)
                                            <tr class="align-middle border-bottom">
                                                <td class="py-3 px-4">{{ $transaction->name }}</td>
                                                <td class="py-3 px-4">{{ $transaction->accomodation_name }}</td>
                                                <td class="py-3 px-4">₱{{ number_format($transaction->amount, 2) }}</td>
                                                <td class="py-3 px-4">₱{{ in_array($transaction->payment_status, ['paid', 'cancelled', 'checked-out']) ? '0.00' : number_format($transaction->balance, 2) }}</td>
                                                <td class="py-3 px-4">{{ $transaction->reference_num }}</td>
                                                <td class="py-3 px-4">{{ $transaction->payment_method }}</td>
                                                <td class="py-3 px-4">
                                                    {{ \Carbon\Carbon::parse($transaction->reservation_check_in_date)->format('M d, Y') }} - 
                                                    {{ \Carbon\Carbon::parse($transaction->reservation_check_out_date)->format('M d, Y') }}
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="badge rounded-pill {{ $transaction->payment_status === 'paid' ? 'bg-success' : ($transaction->payment_status === 'pending' ? 'bg-warning text-dark' : ($transaction->payment_status === 'booked' ? 'bg-primary' : 'bg-danger')) }}">
                                                        {{ ucfirst($transaction->payment_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">No transactions found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                
                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted">
                                        Showing {{ $reservationDetails->firstItem() ?? 0 }} to {{ $reservationDetails->lastItem() ?? 0 }} of {{ $reservationDetails->total() ?? 0 }} entries
                                    </div>
                                    {{ $reservationDetails->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>

    <!-- Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('incomeChart').getContext('2d');
        
        // Use data from backend
        const chartLabels = {!! $chartLabels !!};
        const chartValues = {!! $chartValues !!};
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Monthly Income',
                    data: chartValues,
                    backgroundColor: 'rgba(11, 87, 61, 0.7)', // Matching your theme color
                    borderColor: 'rgba(11, 87, 61, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
        <script>
        // Date range validation
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            startDate.addEventListener('change', function() {
                endDate.min = this.value;
                if (endDate.value && endDate.value < this.value) {
                    endDate.value = this.value;
                }
            });

            endDate.addEventListener('change', function() {
                startDate.max = this.value;
                if (startDate.value && startDate.value > this.value) {
                    startDate.value = this.value;
                }
            });
        });
    </script>
    <script>
    function updateFeeFields() {
        const selectElement = document.getElementById('select_fee');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
        if (selectedOption.value) {
            document.getElementById('entranceFee').value = selectedOption.dataset.fee;
        }
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#editEntranceFeeModal"]');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const typeField = document.getElementById('edit_type');
                
                if (typeField) {
                    // Convert both values to lowercase for comparison
                    const options = typeField.options;
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value.toLowerCase() === type.toLowerCase()) {
                            typeField.selectedIndex = i;
                            break;
                        }
                    }
                }
                
                // ... existing code ...
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const sessionFilter = document.getElementById('sessionFilter');
        const typeFilter = document.getElementById('typeFilter');
        const feeItems = document.querySelectorAll('.fee-item');

        if (sessionFilter && typeFilter) {
            // Add event listeners
            sessionFilter.addEventListener('change', filterFees);
            typeFilter.addEventListener('change', filterFees);
        }
        function filterFees() {
            const selectedSession = sessionFilter.value;
            const selectedType = typeFilter.value;
            const feeItems = document.querySelectorAll('.fee-item');

            feeItems.forEach(item => {
                const matchSession = !selectedSession || item.dataset.session === selectedSession;
                const matchType = !selectedType || item.dataset.type === selectedType;
                item.style.display = matchSession && matchType ? 'block' : 'none';
            });
        }
    });
    </script>
</body>
</html>

