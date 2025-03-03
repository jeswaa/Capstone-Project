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

                        <table class="table table-striped mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">Activity Name</th>
                                    <th scope="col">Activity Type</th>
                                    <th scope="col">Activity Fee</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Activity 1</td>
                                    <td>Activity Type 1</td>
                                    <td>Activity Fee 1</td>
                                    <td>
                                        <a href="#" class="text-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
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
                    <form method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <label for="activityName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="activityName" name="activity_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="activityType" class="form-label">Type</label>
                            <select class="form-select" id="activityType" name="activity_type" required>
                                <option value="" selected disabled>Select Type</option>
                                <option value="group">Group</option>
                                <option value="team">Team</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="activityFee" class="form-label">Fee</label>
                            <input type="number" class="form-control" id="activityFee" name="activity_fee" min="0" required>
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
    </script>
</body>
</html>

