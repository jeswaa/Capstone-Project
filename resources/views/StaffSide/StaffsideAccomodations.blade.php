<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
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
.transition-width {
        transition: all 0.3s ease;
}
#mainContent.full-width {
    width: 100% !important;
    flex: 0 0 100% !important;
    max-width: 100% !important;
}
</style>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.loginSucess')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
        @include('Navbar.sidenavbarStaff')
        <!-- Main Content -->
        <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-end align-items-end mb-1">
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
            </div>

            <hr class="border-5">

            <div>
                <h1 class="fw-semibold text-capitalize mt-4" style="font-size: 50px; letter-spacing: 1px; color: #0b573d; margin-top: -30px; font-family: 'Anton', sans-serif; letter-spacing: .1em;">Room Overview</h1>
            </div>
            <div class="d-flex gap-3 mt-3">
                <!-- Total Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $totalRooms ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Total<br>Rooms
                            </p>
                        </div>
                        <i class="fas fa-bed fs-1 text-white ms-auto"></i>
                    </div>
                </div>

                <!-- Upcoming Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $vacantRooms ?? 0 }}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                                Vacant<br>Rooms
                            </p>
                        </div>
                        <i class="fas fa-door-open fs-1 text-white ms-auto"></i>
                    </div>
                </div>

                <!-- Checked-in Reservations -->
                <div class="flex-grow-1 p-4 rounded-4" style="background-color: #0b573d;">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="fs-1 fw-bold text-white mb-0">{{ $reservedRooms ?? 0}}</h2>
                            <p class="text-white text-uppercase mb-0 font-paragraph" style="font-size: 0.8rem;">
                               Reserved<br>Rooms
                            </p>
                        </div>
                        <i class="fas fa-door-closed fs-1 text-white ms-auto"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <select class="form-select" style="width: auto;" id="roomFilter">
                    <option value="all" selected>All Rooms</option>
                    @php
                        $types = $accomodations->pluck('accomodation_type')->unique();
                    @endphp
                    @foreach($types as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}s</option>
                    @endforeach
                </select>

                <button type="button" class="btn text-white" style="background-color: #0b573d;" data-bs-toggle="modal" data-bs-target="#activeReservationsModal">
                    <i class="fas fa-list me-2"></i>View Active Reservations
                </button>
            </div>

            <!-- Active Reservations Modal -->
            <div class="modal fade" id="activeReservationsModal" tabindex="-1" aria-labelledby="activeReservationsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #0b573d;">
                            <h5 class="modal-title text-white" id="activeReservationsModalLabel">
                                <i class="fas fa-calendar-check me-2"></i>Active Reservations
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($activeReservations->count() > 0)
                                @foreach($activeReservations as $reservation)
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h3 class="h5 mb-1">{{ $reservation->name }}</h3>
                                                <p class="text-muted mb-0">
                                                    <span class="fw-medium">{{ $reservation->reserved_quantity }}</span> of 
                                                    <span class="fw-medium">{{ $reservation->total_quantity }}</span> rooms occupied
                                                </p>
                                            </div>
                                            <span class="badge {{ $reservation->status == 'checked-in' ? 'bg-success' : 'bg-warning' }}">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-flex align-items-center text-muted mb-2">
                                            <i class="far fa-calendar-alt me-2"></i>
                                            Check-out: {{ \Carbon\Carbon::parse($reservation->next_available_time)->format('M j, Y H:i') }}
                                        </div>
                                        
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-clock me-2"></i>
                                            <div class="countdown-timer" data-checkout="{{ $reservation->next_available_time }}" id="countdown-{{ $loop->index }}">
                                                <span class="countdown-display text-primary fw-medium">Calculating time remaining...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="far fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h3 class="h5">No active reservations</h3>
                                    <p class="text-muted mb-0">There are currently no reservations with 'reserved' or 'checked-in' status.</p>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateCountdown(element, checkoutDate) {
                    const now = new Date();
                    const checkout = new Date(checkoutDate);
                    const distance = checkout - now;

                    if (distance < 0) {
                        element.querySelector('.countdown-display').innerHTML = 
                            '<span class="text-danger fw-bold">CHECKOUT OVERDUE</span>';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    let countdownText = '';
                    if (days > 0) countdownText += days + 'd ';
                    countdownText += hours.toString().padStart(2, '0') + 'h ';
                    countdownText += minutes.toString().padStart(2, '0') + 'm ';
                    countdownText += seconds.toString().padStart(2, '0') + 's';

                    element.querySelector('.countdown-display').innerHTML = 
                        '<span class="fw-medium">' + countdownText + ' remaining</span>';
                }

                const countdownElements = document.querySelectorAll('.countdown-timer');
                countdownElements.forEach(element => {
                    const checkoutDate = element.getAttribute('data-checkout');
                    updateCountdown(element, checkoutDate);
                    setInterval(() => updateCountdown(element, checkoutDate), 1000);
                });
            });
            </script>

            <style>
            .countdown-display {
                transition: color 0.3s ease;
            }
            </style>

            <!-- Table  -->
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover table-responsive m-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">Room ID</th>
                                    <th scope="col" class="text-center">Room Image</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Room Description</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Room Qty</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Capacity</th>
                                    <th scope="col" class="text-center">Availability</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accomodations as $accomodation)
                                    <tr>
                                        <td class="text-center align-middle">{{ $accomodation->room_id}}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                                alt="Room Image" 
                                                class="img-thumbnail rounded"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </td>
                                        <td class="align-middle">{{ $accomodation->accomodation_name }}</td>
                                        <td class="align-middle">{{ Str::limit($accomodation->accomodation_description, 50) }}</td>
                                        <td class="align-middle text-capitalize">{{ $accomodation->accomodation_type }}</td>
                                        <td class="align-middle">{{ $accomodation->quantity }}</td>
                                        <td class="text-center align-middle">₱{{ number_format($accomodation->accomodation_price, 2) }}</td>
                                        <td class="text-center align-middle">{{ $accomodation->accomodation_capacity }}</td>
                                        <td class="text-center align-middle">
                                            <span class="badge rounded-pill {{ $accomodation->accomodation_status == 'available' ? 'bg-success' : ($accomodation->accomodation_status == 'maintenance' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ ucfirst($accomodation->accomodation_status) }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-warning btn-sm text-white" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editRoomModal{{ $accomodation->accomodation_id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Room Modal -->
                                    <div class="modal fade" id="editRoomModal{{ $accomodation->accomodation_id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header text-white" style="background-color: #0b573d;">
                                                    <h5 class="modal-title fs-5 fw-bold"><i class="fas fa-edit me-2" style="height: 20px;"></i>Edit Room Details</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <form method="POST" 
                                                        action="{{ route('staff.editRoom', ['id' => $accomodation->accomodation_id]) }}" 
                                                        enctype="multipart/form-data"
                                                        class="needs-validation">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="room_id" value="{{ $accomodation->accomodation_id }}">
                                                        
                                                        <div class="row g-4">
                                                            <div class="col-md-6">
                                                                <div class="card h-100 border-0 shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <label class="form-label fw-bold mb-3 fs-6">Room Image</label>
                                                                        <div class="position-relative d-inline-block">
                                                                            <img id="preview{{ $accomodation->accomodation_id }}" 
                                                                                src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                                                                class="img-thumbnail rounded-3 mb-3" 
                                                                                style="width: 250px; height: 250px; object-fit: cover;">
                                                                            <div class="mt-2">
                                                                                <input type="file" 
                                                                                    class="form-control border-2" 
                                                                                    name="accomodation_image" 
                                                                                    accept="image/*" 
                                                                                    onchange="previewImage(event, 'preview{{ $accomodation->accomodation_id }}')">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="card h-100 border-0 shadow-sm">
                                                                    <div class="card-body">
                                                                        <div class="mb-4">
                                                                            <label class="form-label fw-bold text-dark fs-6">Room Name</label>
                                                                            <input type="text" 
                                                                                class="form-control form-control-md border-2" 
                                                                                name="accomodation_name" 
                                                                                value="{{ $accomodation->accomodation_name }}" 
                                                                                required>
                                                                        </div>

                                                                        <div class="mb-4">
                                                                            <label class="form-label fw-bold text-dark fs-6">Room Type</label>
                                                                            <select class="form-select form-select-md border-2" name="accomodation_type" required>
                                                                                <option value="room" {{ $accomodation->accomodation_type == 'room' ? 'selected' : '' }}>Room</option>
                                                                                <option value="cabin" {{ $accomodation->accomodation_type == 'cabin' ? 'selected' : '' }}>Cabin</option>
                                                                                <option value="cottage" {{ $accomodation->accomodation_type == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-4">
                                                                            <label class="form-label fw-bold text-dark fs-6">Description</label>
                                                                            <textarea class="form-control border-2" 
                                                                                    name="accomodation_description" 
                                                                                    style="height: 120px; resize: none;"
                                                                                    rows="3">{{ $accomodation->accomodation_description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row g-4 mt-2">
                                                            <div class="col-md-4">
                                                                <div class="card border-0 shadow-sm">
                                                                    <div class="card-body">
                                                                        <label class="form-label fw-bold text-dark fs-6">Capacity</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text border-2" style="height: 51px;"><i class="fas fa-users"></i></span>
                                                                            <input type="number" 
                                                                                class="form-control form-control-md border-2" 
                                                                                name="accomodation_capacity" 
                                                                                min="1" 
                                                                                value="{{ $accomodation->accomodation_capacity }}" 
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="card border-0 shadow-sm">
                                                                    <div class="card-body">
                                                                        <label class="form-label fw-bold text-dark fs-6">Price</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text border-2" style="height: 51px;">₱</span>
                                                                            <input type="number" 
                                                                                class="form-control form-control-md border-2"
                                                                                name="accomodation_price" 
                                                                                min="0" 
                                                                                value="{{ $accomodation->accomodation_price }}" 
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="card border-0 shadow-sm">
                                                                    <div class="card-body">
                                                                        <label class="form-label fw-bold text-dark fs-6">Status</label>
                                                                        <select class="form-select form-select-md border-2" name="accomodation_status" required>
                                                                            <option value="available" {{ $accomodation->accomodation_status == 'available' ? 'selected' : '' }}>
                                                                                <i class="fas fa-check-circle text-success" style="height: 16px;"></i> Available
                                                                            </option>
                                                                            <option value="unavailable" {{ $accomodation->accomodation_status == 'unavailable' ? 'selected' : '' }}>
                                                                                <i class="fas fa-times-circle text-danger" style="height: 16px;"></i> Not Available
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0 mt-4">
                                                            <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-2" style="height: 16px;"></i>Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-md text-white" style="background-color: #0b573d;">
                                                                <i class="fas fa-save me-2" style="height: 16px;"></i>Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Section -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                @if($accomodations->total() > 0)
                                    Showing {{ $accomodations->firstItem() }} to {{ $accomodations->lastItem() }} of {{ $accomodations->total() }} results
                                @else
                                    No results found
                                @endif
                            </div>
                            <div>
                                @if ($accomodations->hasPages())
                                    <nav>
                                        <ul class="pagination mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($accomodations->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $accomodations->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i>  </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($accomodations->getUrlRange(1, $accomodations->lastPage()) as $page => $url)
                                                <li class="page-item {{ $page == $accomodations->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($accomodations->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $accomodations->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('roomFilter');
            const tableRows = document.querySelectorAll('tbody tr');

            filterSelect.addEventListener('change', function() {
                const filterValue = this.value;

                tableRows.forEach(row => {
                    const roomType = row.querySelector('td:nth-child(5)').textContent.toLowerCase().trim();
                    
                    if (filterValue === 'all' || roomType === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
        // Function to update countdown for a specific element
        function updateCountdown(element, checkoutDate) {
            const now = new Date().getTime();
            const checkout = new Date(checkoutDate).getTime();
            const distance = checkout - now;

            if (distance < 0) {
                element.querySelector('.countdown-display').innerHTML = '<span class="text-danger">OVERDUE</span>';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let countdownText = '';
            if (days > 0) {
                countdownText += days + 'd ';
            }
            countdownText += hours.toString().padStart(2, '0') + 'h ';
            countdownText += minutes.toString().padStart(2, '0') + 'm ';
            countdownText += seconds.toString().padStart(2, '0') + 's';

            element.querySelector('.countdown-display').innerHTML = 
                '<span class="badge bg-primary">' + countdownText + '</span>';
        }

        // Initialize all countdown timers
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElements = document.querySelectorAll('.countdown-timer');
            
            countdownElements.forEach(function(element) {
                const checkoutDate = element.getAttribute('data-checkout');
                
                // Update immediately
                updateCountdown(element, checkoutDate);
                
                // Update every second
                setInterval(function() {
                    updateCountdown(element, checkoutDate);
                }, 1000);
            });
        });
    </script>
</body>
</html>