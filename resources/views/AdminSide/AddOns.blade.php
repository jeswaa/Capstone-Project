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
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4 d-flex flex-column align-items-end ms-auto">
                
                <div class="color-background4 p-3 rounded-topright-50 w-100" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control mb-0 rounded-start-5 bg-light border border-secondary" placeholder="Search">
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
                        <a href="{{ route('reservations') }}" class="text-color-1 text-decoration-none me-5"><h1 class="fs-5 font-heading">Reservation</h1></a>
                        <a href="{{ route('rooms') }}" class="text-color-1 me-5 text-decoration-none"><h1 class="fs-5 font-heading">Room</h1></a>
                        <a href="{{ route('packages') }}" class="text-color-1 me-5 text-decoration-none"><h1 class="fs-5 font-heading">Packages</h1></a>
                        <a href="{{ route('addOns') }}" class="text-color-1 me-5 text-decoration-none"><h1 class="fs-5 font-heading">Add Ons</h1></a>
                        <a href="{{ route('addActivities') }}" class="text-color-1 text-decoration-none"><h1 class="fs-5 font-heading">Activities</h1></a>
                    </div>

                    <h1 class="text-color-1 mt-5 font-paragraph">Add Ons & Services</h1>

                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus me-2"></i>Add On</button>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addons as $addon)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $addon->image) }}" class="img-fluid rounded" style="width: 50px; height: 50px;" alt=""></td>
                                    <td>{{ $addon->name }}</td>
                                    <td>{{ $addon->stock }}</td>
                                    <td>{{ $addon->description }}</td>
                                    <td>{{ $addon->price }}</td>
                                    <td>
                                        <!-- Edit Button with Correct Modal Target -->
                                        <a href="#" class="text-primary mx-2" data-bs-toggle="modal" data-bs-target="#editAddOnModal{{ $addon->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>

                                <!-- Edit Add-On Modal (Now Unique for Each Add-On) -->
                                <div class="modal fade" id="editAddOnModal{{ $addon->id }}" tabindex="-1" aria-labelledby="editAddOnModalLabel{{ $addon->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAddOnModalLabel{{ $addon->id }}">Edit Add-On</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{ route('editAddOn', $addon->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="addonName{{ $addon->id }}" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="addonName{{ $addon->id }}" name="name" value="{{ old('name', $addon->name) }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="addonStock{{ $addon->id }}" class="form-label">Stock</label>
                                                    <input type="number" class="form-control" id="addonStock{{ $addon->id }}" name="stock" value="{{ old('stock', $addon->stock) }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="addonPrice{{ $addon->id }}" class="form-label">Price</label>
                                                    <input type="number" class="form-control" id="addonPrice{{ $addon->id }}" name="price" value="{{ old('price', $addon->price) }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="addonImage{{ $addon->id }}" class="form-label">Image</label>
                                                    <input type="file" class="form-control" id="addonImage{{ $addon->id }}" name="image" accept="image/*">
                                                    <input type="hidden" name="hidden_image" value="{{ $addon->image }}">
                                                    
                                                    <div class="mt-2">
                                                        <p>Current Image:</p>
                                                        <img src="{{ asset('storage/' . $addon->image) }}" alt="Current Add-On Image" class="img-fluid" width="100" height="100">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="addonDescription{{ $addon->id }}" class="form-label">Description</label>
                                                    <textarea class="form-control" id="addonDescription{{ $addon->id }}" name="description" rows="3">{{ old('description', $addon->description) }}</textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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

    @include('Navbar.sidenavbar')

    <!-- Add On Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addOnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOnModalLabel">Add On</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('storeAddOns') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" required>
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
        document.addEventListener("DOMContentLoaded", function () {
            var addModal = new bootstrap.Modal(document.getElementById('addModal'));

            document.querySelector('.btn-primary.w-25').addEventListener('click', function () {
                addModal.show();
            });

            document.querySelector('#addModal .btn-close').addEventListener('click', function () {
                addModal.hide();
            });

            var form = document.querySelector('#addModal form');
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var formData = new FormData(form);
                for (var [key, value] of formData.entries()) {
                    console.log(key, value);
                }
                addModal.hide();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editAddOnButtons = document.querySelectorAll(".edit-addon-btn");
            editAddOnButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const addOnId = button.getAttribute("data-addon-id");
                    const editModal = new bootstrap.Modal(document.getElementById("editAddOnModal" + addOnId));
                    editModal.show();
                });
            });

            document.querySelectorAll(".edit-addon-modal .btn-close, .edit-addon-modal .btn-secondary").forEach(closeButton => {
                closeButton.addEventListener("click", function () {
                    const modalElement = closeButton.closest(".modal");
                    const editModal = bootstrap.Modal.getInstance(modalElement);
                    editModal.hide();
                });
            });
        });
    </script>

</body>
</html>
