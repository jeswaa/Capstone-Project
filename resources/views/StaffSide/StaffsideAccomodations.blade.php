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
        
        <!-- Main Content -->
        <div class="col-md-10 col-lg-10 py-4 px-4">
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
            <div class="d-flex justify-content-start mt-4 mb-3">
                <select class="form-select" style="width: auto;" id="roomFilter">
                    <option value="all" selected>Select Type of Room</option>
                    @php
                        $types = $accomodations->pluck('accomodation_type')->unique();
                    @endphp
                    @foreach($types as $type)
                        <option value="{{ $type }}">{{ ucfirst($type) }}s</option>
                    @endforeach
                </select>
            </div>

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
                                                    <h5 class="modal-title">Edit Room Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" 
                                                        action="{{ route('staff.editRoom', ['id' => $accomodation->accomodation_id]) }}" 
                                                        enctype="multipart/form-data"
                                                        class="needs-validation">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="room_id" value="{{ $accomodation->accomodation_id }}">
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-bold">Room Image</label>
                                                                <div class="d-flex flex-column align-items-center">
                                                                    <img id="preview{{ $accomodation->accomodation_id }}" 
                                                                        src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                                                        class="img-thumbnail mb-2" 
                                                                        style="width: 200px; height: 200px; object-fit: cover;">
                                                                    <input type="file" 
                                                                        class="form-control" 
                                                                        style="height: 38px;"
                                                                        name="accomodation_image" 
                                                                        accept="image/*" 
                                                                        onchange="previewImage(event, 'preview{{ $accomodation->accomodation_id }}')">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Room Name</label>
                                                                    <input type="text" 
                                                                        class="form-control"
                                                                        style="height: 38px;" 
                                                                        name="accomodation_name" 
                                                                        value="{{ $accomodation->accomodation_name }}" 
                                                                        required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Room Type</label>
                                                                    <select class="form-select" name="accomodation_type" style="height: 38px;" required>
                                                                        <option value="room" {{ $accomodation->accomodation_type == 'room' ? 'selected' : '' }}>Room</option>
                                                                        <option value="cabin" {{ $accomodation->accomodation_type == 'cabin' ? 'selected' : '' }}>Cabin</option>
                                                                        <option value="cottage" {{ $accomodation->accomodation_type == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Description</label>
                                                            <textarea class="form-control" 
                                                                    name="accomodation_description" 
                                                                    style="height: 100px;"
                                                                    rows="3">{{ $accomodation->accomodation_description }}</textarea>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label fw-bold">Capacity</label>
                                                                <input type="number" 
                                                                    class="form-control"
                                                                    style="height: 38px;" 
                                                                    name="accomodation_capacity" 
                                                                    min="1" 
                                                                    value="{{ $accomodation->accomodation_capacity }}" 
                                                                    required>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label fw-bold">Price</label>
                                                                <div class="input-group" style="height: 38px;">
                                                                    <span class="input-group-text h-100">₱</span>
                                                                    <input type="number" 
                                                                        class="form-control h-100"
                                                                        name="accomodation_price" 
                                                                        min="0" 
                                                                        value="{{ $accomodation->accomodation_price }}" 
                                                                        required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label fw-bold">Status</label>
                                                                <select class="form-select" name="accomodation_status" style="height: 38px;" required>
                                                                    <option value="available" {{ $accomodation->accomodation_status == 'available' ? 'selected' : '' }}>Available</option>
                                                                    <option value="unavailable" {{ $accomodation->accomodation_status == 'unavailable' ? 'selected' : '' }}>Not Available</option>
                                                                    <option value="maintenance" {{ $accomodation->accomodation_status == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn text-white" style="background-color: #0b573d;">Save Changes</button>
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
</body>
</html>