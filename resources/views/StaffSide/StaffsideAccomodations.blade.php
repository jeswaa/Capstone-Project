<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
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
<body class="color-background5">
    @if (session('success'))
    <div class="d-flex align-items-center position-absolute end-0 me-3 mt-3 top-0" style="animation: fadeOut 5s forwards;">
        <div class="alert alert-success text-center" role="alert">
            <i class="fa-circle-check fa-solid me-2"></i>{{ session('success') }}
        </div>
    </div>
    @endif
    <div class="container-fluid">
        <div class="row h-100">
        @include('Navbar.sidenavbarStaff')
            <div class="col-12 col-md-9 color-background3 flex-column align-items-end h-100 rounded-start-50 main-content ms-auto mt-4 pe-0 ps-0">
                <div class="color-background4 p-3 rounded-topright-50 w-100" id="main-content">
                    <div style="height: 50px;" class="d-flex justify-content-start mt-3">
                        
                    </div>
                </div>
                <h1 class="text-color-1 text-uppercase font-paragraph fs-1 fw-bold ms-5 mt-5">Room Overview</h1>
                <div class="container p-4 mt-4">
                    <h2 class="text-center mb-4"></h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-header">Total Rooms</div>
                                <div class="card-body">
                                    <h5 class="card-title" id="totalRooms">{{ $totalRooms }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white mb-3">
                                <div class="card-header">Vacant Rooms</div>
                                <div class="card-body">
                                    <h5 class="card-title" id="vacantRooms">{{ $vacantRooms }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white mb-3">
                                <div class="card-header">Reserved Rooms</div>
                                <div class="card-body">
                                    <h5 class="card-title" id="reservedRooms">{{ $reservedRooms }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-custom p-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Room Image</th>
                                <th>Room Name</th>
                                <th>Room Description</th>
                                <th>Price</th>
                                <th>Capacity</th>
                                <th>Availability</th>
                                <th>Slot</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accomodations as $accomodation)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" alt="Room Image" width="50" height="50"></td>
                                    <td>{{ $accomodation->accomodation_name }}</td>
                                    <td>{{ $accomodation->accomodation_description }}</td>
                                    <td>{{ $accomodation->accomodation_price }}</td>
                                    <td>{{ $accomodation->accomodation_capacity }}</td>
                                    <td>{{ $accomodation->accomodation_status }}</td>
                                    <td>{{ $accomodation->accomodation_slot }}</td>
                                    <td>
                                    <a href="#" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $accomodation->accomodation_id }}">
                                        <i class="fa-pen-to-square fa-solid"></i>
                                    </a>

                                    </td>
                                    
                                </tr>
                                <!-- Edit Room Modal -->
                                <div class="modal fade" id="editRoomModal{{ $accomodation->accomodation_id }}" tabindex="-1" aria-labelledby="editRoomModalLabel{{ $accomodation->accomodation_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form method="POST" action="{{ route('staff.editRoom', ['id' => $accomodation->accomodation_id]) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="editRoomId" name="room_id" value="{{ $accomodation->accomodation_id }}">
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
                                                        <label for="editRoomDescription{{ $accomodation->accomodation_id }}" class="form-label">Description</label>
                                                        <textarea class="form-control" id="editRoomDescription{{ $accomodation->accomodation_id }}" name="accomodation_description" rows="3">{{ $accomodation->accomodation_description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomType{{ $accomodation->accomodation_id }}" class="form-label">Type</label>
                                                        <select class="form-select" id="editRoomType{{ $accomodation->accomodation_id }}" name="accomodation_type" required>
                                                            <option value="room" {{ $accomodation->accomodation_type == 'room' ? 'selected' : '' }}>Room</option>
                                                            <option value="cottage" {{ $accomodation->accomodation_type == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                                        </select>
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
                                                            <option value="maintenance" {{ $accomodation->accomodation_status == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editRoomSlot{{ $accomodation->accomodation_id }}" class="form-label">Slot</label>
                                                        <input type="number" class="form-control" id="editRoomSlot{{ $accomodation->accomodation_id }}" name="accomodation_slot" min="1" required value="{{ $accomodation->accomodation_slot }}">
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
<script>
    const addRoomButton = document.querySelector(".btn-primary.w-25");
    if (addRoomButton) {
        addRoomButton.addEventListener('click', function () {
            var myModal = new bootstrap.Modal(document.getElementById('addRoomModal'));
            myModal.show();
        });
    }

    const closeModalButton = document.querySelector('#addRoomModal button[data-bs-dismiss="modal"]');
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function () {
            var myModal = bootstrap.Modal.getInstance(document.getElementById('addRoomModal'));
            myModal.hide();
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editRoomButtons = document.querySelectorAll(".btn-warning");
        editRoomButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                const editModal = new bootstrap.Modal(document.getElementById("editRoomModal"));
                editModal.show();
            });
        });

        const closeModalButtons = document.querySelectorAll("#editRoomModal .btn-close, #editRoomModal .btn-secondary");
        closeModalButtons.forEach(button => {
            button.addEventListener("click", function () {
                const modalElement = button.closest(".modal");
                const editModal = bootstrap.Modal.getInstance(modalElement);
                editModal.hide();
            });
        });
    });
</script>

</body>
</html>