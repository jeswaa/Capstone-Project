<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Activities</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
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
                        <a href="{{ route('packages') }}" class="text-color-1 me-5 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Packages</h1></a>
                        <a href="{{ route('addActivities') }}" class="text-color-1 text-decoration-none text-underline-left-to-right"><h1 class="fs-5 font-heading">Activities</h1></a>
                    </div>

                    <hr>

                    <div class="mt-5 mb-5">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="p-3 border-0 rounded-3 color-background4 text-hover-1 w-25 font-paragraph text-capitalize fw-bold" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                                Add Activity
                            </button>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-striped mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">Activity Image</th>
                                    <th scope="col">Activity Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td><img src="{{ asset('storage/' . $activity->activity_image) }}" class="img-fluid rounded" style="width: 50px; height: 50px;" alt=""></td>
                                        <td>{{ $activity->activity_name }}</td>
                                        <td>{{ $activity->activity_status }}</td>
                                        <td>
                                            <a href="#editActivityModal{{ $activity->id }}" class="text-warning mx-2" data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                    <!-- Edit Activity Modal -->
                                    <div class="modal fade" id="editActivityModal{{ $activity->id }}" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editActivityModalLabel">Edit Activity</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('updateActivity', $activity->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="activity_name">Activity Name</label>
                                                            <input type="text" class="form-control" id="activity_name" name="activity_name" value="{{ $activity->activity_name }}">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="activity_image">Activity Image</label>
                                                            <input type="file" class="form-control" id="activity_image" name="activity_image">
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="activity_status">Activity Status</label>
                                                            <select class="form-select" id="activity_status" name="activity_status">
                                                                <option value="Available" @if ($activity->activity_status == 'Available') selected @endif>Available</option>
                                                                <option value="Unavailable" @if ($activity->activity_status == 'Unavailable') selected @endif>Unavailable</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Edit Activity Modal -->
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
    <!-- Add Activity Modal -->
    <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addActivityModalLabel">Add Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('storeActivity') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="activityImage" class="form-label">Image</label>
                            <input type="file" class="form-control" id="activityImage" name="activity_image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="activityName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="activityName" name="activity_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="activityStatus" class="form-label">Status</label>
                            <select class="form-select" id="activityStatus" name="activity_status" required>
                                <option value="" selected disabled>Select Status</option>
                                <option name="activity_status" value="available">Available</option>
                                <option name="activity_status" value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="p-2 border-0 rounded-3 text-color-1 color-background4 text-hover-1 font-paragraph text-uppercase fw-bold w-100">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const addActivityBtn = document.querySelector('.btn-primary.w-25');
        if (addActivityBtn) {
            addActivityBtn.addEventListener('click', function () {
                var myModal = new bootstrap.Modal(document.getElementById('addActivityModal'));
                myModal.show();
            });
        }

        const closeModalBtn = document.querySelector('#addActivityModal button[data-bs-dismiss="modal"]');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                var myModal = bootstrap.Modal.getInstance(document.getElementById('addActivityModal'));
                myModal.hide();
            });
        }
document.addEventListener("DOMContentLoaded", function () {
    const editActivityButtons = document.querySelectorAll(".edit-activity-btn");
    editActivityButtons.forEach(button => {
        button.addEventListener("click", function () {
            const activityId = button.getAttribute("data-activity-id");
            const editModal = new bootstrap.Modal(document.getElementById("editActivityModal" + activityId));
            editModal.show();
        });
    });

    document.querySelectorAll(".edit-activity-modal .btn-close, .edit-activity-modal .btn-secondary").forEach(closeButton => {
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

