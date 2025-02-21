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
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- SIDE NAV BAR -->
            @include('Navbar.sidenavbar')

            <!-- Main Content -->
             <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4" >
                <!-- TOP SECTION -->
                <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
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

                <div class="overflow-y-auto h-100 p-5">
                    <div class="d-flex ">
                        <a href="{{ route('reservations') }}" class="text-color-1 text-decoration-none me-5 text-underline-left-to-right"><h1 class="fs-5 font-heading">Reservation</h1></a>
                        <a href="{{ route('roomAvailability') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Room Availability</h1></a>
                        <a href="{{ route('packages') }}" class="text-color-1 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Packages</h1></a>
                    </div>

                    <div>
                        <div class="d-flex mt-5 justify-content-center">
                            <div class="color-background4 w-auto p-3 rounded-4 mb-3">
                                <h1 class="fs-5 font-heading pt-2 ms-3 text-color-1">Overview</h1>
                                <div class="d-flex gap-3 mt-3 justify-content-center">
                                    <div class="color-background5 border-secondary rounded-3 ms-3 p-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Total Rooms:</h1>
                                        <p class="fs-4 text-center color-3">10</p>
                                    </div>
                                    <div class="p-3  color-background5 border-secondary rounded-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Available Rooms:</h1>
                                        <p class="fs-4 text-center color-3">5</p>
                                    </div>
                                    <div class="p-3  color-background5 border-secondary rounded-3 me-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Reserved Rooms:</h1>
                                        <p class="fs-4 text-center color-3">5</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <hr>
                        

                    <div class="mt-5">
                        <div class="d-flex  align-items-end">
                            <h1 class="fs-5 me-5 font-paragraph text-color-1 fw-bold">Rooms Availability</h1>
                            <a href="{{ route ('rooms')}}" class="fs-5 text-decoration-none font-paragraph text-color-1 mb-1 fw-bold text-underline-left-to-right">Rooms</a>
                        </div>
                        <div class="d-flex justify-content-end ">
                            <button type="button" class="btn color-background4 text-hover-1 w-25 font-paragraph text-capitalize fw-bold" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                                Add Room
                            </button>
                        </div>
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Room Image</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Room Capacity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accomodations as $accomodation)
                                <tr>
                                    <td>
                                    @if ($accomodation->accomodation_image)
                                            <a href=# target="_blank">
                                                <img src="{{ asset('storage/public/accomodations/' . basename($accomodation->accomodation_image)) }}" alt="Proof of Payment" style="max-width: 100px; height: auto;">
                                            </a>
                                        @else
                                            No proof uploaded
                                        @endif
                                    </td>
                                    <td>{{ $accomodation->accomodation_type }}</td>
                                    <td>{{ $accomodation->accomodation_capacity}}</td>
                                    <td>{{ $accomodation->accomodation_price}}</td>
                                    <td>    
                                        <a href="#" class="text-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                
                </div>

             </div>
        </div>
    </div>
<!-- Add Room Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('addRoom') }} " enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="accomodationImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="accomodationImage" name="accomodation_image" accept="image/*" required>
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
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="accomodationCapacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" id="accomodationCapacity" name="accomodation_capacity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="accomodationPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="accomodationPrice" name="accomodation_price" min="0" required>
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
    // Script to open the modal when the "Add Accommodation" button is clicked
    document.querySelector('.btn-primary.w-25').addEventListener('click', function () {
        var myModal = new bootstrap.Modal(document.getElementById('addRoomModal'));
        myModal.show();
    });

    // Script to close the modal when the "Close" button is clicked
    document.querySelector('#addRoomModal button[data-bs-dismiss="modal"]').addEventListener('click', function () {
        var myModal = bootstrap.Modal.getInstance(document.getElementById('addRoomModal'));
        myModal.hide();
    });
</script>
</body>
</html>