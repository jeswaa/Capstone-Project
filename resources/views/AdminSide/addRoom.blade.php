<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    @keyframes fadeOut {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}
</style>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success position-absolute top-0 start-100 translate-middle-x d-flex align-items-center" style="animation: fadeOut 1s forwards;">
        {{ session('success') }}
    </div>
@endif
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- Main Content -->
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4 d-flex flex-column align-items-end ms-auto">
                <!-- TOP SECTION -->
                <div class="color-background4 p-3 rounded-topright-50 w-100" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control mb-0 rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success rounded-end-5" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin's Profile">
                            <a href="#"><i class="fa-regular fa-circle-user fs-1 text-decoration-none text-color-1"></i></a>
                        </div>
                    </div>
                </div>

                <div class="overflow-y-auto h-100 p-5 w-100">
                    <div class="d-flex">
                        <a href="{{ route('reservations') }}" class="text-color-1 text-decoration-none me-5 text-underline-left-to-right"><h1 class="fs-5 font-heading">Reservation</h1></a>
                        <a href="{{ route('rooms') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Room</h1></a>
                        <a href="{{ route('addOns') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Add Ons</h1></a>
                        <a href="{{ route('addActivities') }}" class="text-color-1 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Activities</h1></a>
                    </div>

                    <div>
                        <div class="d-flex mt-5 justify-content-center">
                            <div class="color-background4 w-auto p-3 rounded-4 mb-3">
                                <h1 class="fs-5 font-heading pt-2 ms-3 text-color-1">Overview</h1>
                                <div class="d-flex gap-3 mt-3 justify-content-center">
                                    <div class="color-background5 border-secondary rounded-3 ms-3 p-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Total Rooms:</h1>
                                        <p class="fs-4 text-center color-3">{{ $count }}</p>
                                    </div>
                                    <div class="p-3 color-background5 border-secondary rounded-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Available Rooms:</h1>
                                        <p class="fs-4 text-center color-3">{{ $countAvailableRoom }}</p>
                                    </div>
                                    <div class="p-3 color-background5 border-secondary rounded-3 me-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Reserved Rooms:</h1>
                                        <p class="fs-4 text-center color-3">{{ $countReservedRoom }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="roomTypeFilter" class="form-label">Filter by Room Type:</label>
                        <select class="form-select w-25" id="roomTypeFilter">
                            <option value="all">All</option>
                            <option value="room">Room</option>
                            <option value="cottage">Cottage</option>
                            <option value="cabin">Cabin Room</option>
                        </select>
                    </div>


                    <div class="mt-5">
                        <div class="d-flex align-items-end">
                            <h1><a href="{{ route('rooms') }}" class="fs-5 text-decoration-none font-paragraph text-color-1 mb-1 fw-bold text-underline-left-to-right">Rooms</a></h1>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="p-3 border-0 rounded-3 color-background4 text-hover-1 w-25 font-paragraph text-capitalize fw-bold" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                                Add Room
                            </button>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Room ID</th>
                                    <th scope="col">Room Image</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Room Capacity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accomodations as $accomodation)
                                <tr>
                                    <td>{{$accomodation->room_id}}</td>
                                    <td> 
                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" alt="Accommodation Image" width="100" height="100">
                                    </td>
                                    <td>{{ $accomodation->accomodation_name }}</td>
                                    <td>{{ $accomodation->accomodation_type }}</td>
                                    <td>{{ $accomodation->accomodation_description}}</td>
                                    <td>{{ $accomodation->accomodation_capacity }}</td>
                                    <td>{{ $accomodation->accomodation_price }}</td>
                                    <td>{{ $accomodation->accomodation_status }}</td>
                                    <td>
                                        <a href="#" class="text-warning mx-2 edit-room-btn" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $accomodation->accomodation_id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('deleteRoom', ['id' => $accomodation->accomodation_id]) }}" class="text-danger" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this room?')) { document.getElementById('delete-form-{{ $accomodation->accomodation_id }}').submit(); }">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                        <form id="delete-form-{{ $accomodation->accomodation_id }}" action="{{ route('deleteRoom', ['id' => $accomodation->accomodation_id]) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                <!-- Edit Room Modal -->
                                <div class="modal fade" id="editRoomModal{{ $accomodation->accomodation_id }}" tabindex="-1" aria-labelledby="editRoomModalLabel{{ $accomodation->accomodation_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoomModalLabel{{ $accomodation->accomodation_id }}">Edit Room</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('updateRoom', ['id' => $accomodation->accomodation_id]) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="editRoomId" name="room_id" value="{{ $accomodation->accomodation_id }}">
                                                    <div class="mb-3">
                                                        <label for="editRoomId{{ $accomodation->accomodation_id }}" class="form-label">Room ID</label>
                                                        <input type="text" class="form-control" id="editRoomId{{ $accomodation->accomodation_id }}" name="room_id" required value="{{ $accomodation->room_id }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomImage{{ $accomodation->accomodation_id }}" class="form-label">Image</label>
                                                        <input type="file" class="form-control" id="editRoomImage{{ $accomodation->accomodation_id }}" name="accomodation_image" accept="image/*" onchange="previewImage(event, 'preview{{ $accomodation->accomodation_id }}')">
                                                        <img id="preview{{ $accomodation->accomodation_id }}" src="{{ asset('storage/' . $accomodation->accomodation_image) }}" alt="Preview" width="100" height="100">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomName{{ $accomodation->accomodation_id }}" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="editRoomName{{ $accomodation->accomodation_id }}" name="accomodation_name" required value="{{ $accomodation->accomodation_name }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomType{{ $accomodation->accomodation_id }}" class="form-label">Type</label>
                                                        <select class="form-select" id="editRoomType{{ $accomodation->accomodation_id }}" name="accomodation_type" required>
                                                            <option value="room" {{ $accomodation->accomodation_type == 'room' ? 'selected' : '' }}>Room</option>
                                                            <option value="cottage" {{ $accomodation->accomodation_type == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                                            <option value="cabin" {{ $accomodation->accomodation_type == 'cabin' ? 'selected' : '' }}>Cabin</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomDescription{{ $accomodation->accomodation_id }}" class="form-label">Description</label>
                                                        <textarea class="form-control" id="editRoomDescription{{ $accomodation->accomodation_id }}" name="accomodation_description" rows="3">{{ $accomodation->accomodation_description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomCapacity{{ $accomodation->accomodation_id }}" class="form-label">Capacity</label>
                                                        <input type="number" class="form-control" id="editRoomCapacity{{ $accomodation->accomodation_id }}" name="accomodation_capacity" min="1" required value="{{ $accomodation->accomodation_capacity }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomPrice{{ $accomodation->accomodation_id }}" class="form-label">Price</label>
                                                        <input type="number" class="form-control" id="editRoomPrice{{ $accomodation->accomodation_id }}" name="accomodation_price" min="0" required value="{{ $accomodation->accomodation_price }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomStatus{{ $accomodation->accomodation_id }}" class="form-label">Status</label>
                                                        <select class="form-select" id="editRoomStatus{{ $accomodation->accomodation_id }}" name="accomodation_status" required>
                                                            <option value="available" {{ $accomodation->accomodation_status == 'available' ? 'selected' : '' }}>Available</option>
                                                            <option value="unavailable" {{ $accomodation->accomodation_status == 'unavailable' ? 'selected' : '' }}>Not Available</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
    <!-- SIDE NAV BAR -->
    @include('Navbar.sidenavbar')
    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addRoom') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="accomodationImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="accomodationImage" name="accomodation_image" accept="image/*"  required>
                            @if ($errors->has('accomodation_image'))
                                <span class="text-danger">{{ $errors->first('accomodation_image') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="accomodationId" class="form-label">Room ID</label>
                            <input type="text" class="form-control" id="accomodationId" name="room_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="accomodationName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="accomodationName" name="accomodation_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="accomodationType" class="form-label">Type</label>
                            <select class="form-select" id="accomodationType" name="accomodation_type" required>
                                <option value="" selected disabled>Select Type</option>
                                <option value="room">Room</option>
                                <option value="cottage">Cottage</option>
                                <option value="cabin">Cabin</option>    
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accomodationDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="accomodationDescription" name="accomodation_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="accomodationCapacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="accomodationCapacity" name="accomodation_capacity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="accomodationPrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="accomodationPrice" name="accomodation_price" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="accomodationStatus" class="form-label">Status</label>
                            <select class="form-select" id="accomodationStatus" name="accomodation_status" required>
                                <option value="" selected disabled>Select Status</option>
                                <option value="available">Available</option>
                                <option value="unavailable">Not Available</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const addRoomBtn = document.querySelector('.btn-primary.w-25');
        if (addRoomBtn) {
            addRoomBtn.addEventListener('click', function () {
                var myModal = new bootstrap.Modal(document.getElementById('addRoomModal'));
                myModal.show();
            });
        }

        const closeModalBtn = document.querySelector('#addRoomModal button[data-bs-dismiss="modal"]');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                var myModal = bootstrap.Modal.getInstance(document.getElementById('addRoomModal'));
                myModal.hide();
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const editButtons = document.querySelectorAll(".edit-room-btn");
            editButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const row = button.closest("tr");
                    const roomId = row.querySelector("input[name='room_id']").value;
                    document.getElementById("editRoomName" + roomId).value = row.cells[1].textContent.trim();
                    document.getElementById("editRoomType" + roomId).value = row.cells[2].textContent.trim();
                    document.getElementById("editRoomCapacity" + roomId).value = row.cells[3].textContent.trim();
                    document.getElementById("editRoomPrice" + roomId).value = row.cells[4].textContent.trim();
                });
            });
        });

        document.getElementById("roomTypeFilter").addEventListener("change", function () {
            let filterValue = this.value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                let roomType = row.children[3].textContent.toLowerCase(); // Get Room Type column
                if (filterValue === "all" || roomType.includes(filterValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

    </script>
</body>
</html>

