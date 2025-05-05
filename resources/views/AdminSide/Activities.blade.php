<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Activities</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
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
    <div class="container-fluid min-vh-100 d-flex p-0">
    @include('Alert.loginSuccessUser')
        <!-- Side NavBar -->
        <div class="col-md-3 col-lg-2 color-background8 text-white py-5 position-sticky" style="top: 0; height: 100vh;">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3 border border-5 border-white">
                <p class="font-heading sidebar-text" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;">Edit Profile</p>
            </div>

            <div class="d-flex flex-column px-4 mt-4">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-tachometer-alt me-2 fs-5"></i> Dashboard
                </a>
                <a href="{{ route('reservations') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-calendar-alt me-2 fs-5"></i> Reservations
                </a>
                <a href="{{ route('guests') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-users me-2 fs-5"></i> Guests
                </a>
                <a href="{{ route('transactions') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-credit-card me-2 fs-5"></i> Transactions
                </a>

                <div class="dropdown py-2 mt-4">
                    <a class="text-white text-decoration-none d-flex align-items-center dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-line me-2 fs-5 text-underline-left-to-right"></i> Reports
                    </a>
                    <ul class="dropdown-menu " aria-labelledby="reportsDropdown">
                        <li><a class="dropdown-item" href="{{ route('reports') }}">Summary Report</a></li>
                        <li><a class="dropdown-item" href="{{ route('activityLogs') }}">Activity Logs</a></li>
                    </ul>
                </div>

                <a href="{{ route('logout') }}" class="text-white text-decoration-none py-2 d-flex align-items-center mt-4 text-underline-left-to-right">
                    <i class="fas fa-sign-out-alt me-2 fs-5"></i> Logout
                </a>
            </div>
        </div>

        <!--  Main Content -->
          <div class="col-md-9 col-lg-10 py-4 px-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="fw-semibold fs-1" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">ACTIVITIES</h1>
                    <form class="d-flex w-50 ms-5" role="search">
                        <div class="input-group">
                            <input type="search" class="form-control rounded-start-5 border-3 border-secondary" style="background-color: transparent; height: 40px;" placeholder="Search" aria-label="Search">
                            <button class="btn btn-secondary h-75 rounded-end-5" style="color: #e9ffcc;" type="submit">
                                <i class="fa-solid fa-magnifying-glass" ></i>
                            </button>
                        </div>
                    </form>
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
                </div>

                <hr class="border-5">
                <!-- Links -->
                <div class="d-flex justify-content-center">
                    <a href="{{ route('reservations') }}" class="text-color-2 text-decoration-none me-5 fancy-link " style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Reservation</h1></a>
                    <a href="{{ route('rooms') }}" class="text-color-2 me-5 text-decoration-none fancy-link " style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Room </h1></a>
                    <a href="{{ route('addActivities') }}" class="text-color-2 text-decoration-none fancy-link active" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;"><h1 class="fs-1 text-uppercase">Activities</h1></a>
                </div>

                <div>
                    <div class="d-flex justify-content-end mb-5 mt-5">
                        <button type="button" class="p-3 border-0 rounded-3 color-background8 text-hover-1 w-25 text-white w-md-25 font-paragraph text-uppercase fw-bold" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                            Add Activity
                        </button>
                    </div>

                    <!-- Add Activity Modal -->
                    <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addActivityModalLabel">Add New Activity</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('storeActivity') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="activity_name">Activity Name</label>
                                            <input type="text" class="form-control" id="activity_name" name="activity_name" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="activity_image">Activity Image</label>
                                            <input type="file" class="form-control" id="activity_image" name="activity_image" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="activity_status">Activity Status</label>
                                            <select class="form-select" id="activity_status" name="activity_status" required>
                                                <option value="Available">Available</option>
                                                <option value="Unavailable">Unavailable</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Add Activity</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Activity Modal -->

                    <!-- Table -->
                    <div class="bg-white shadow-lg rounded-4 p-4 mt-2">
                        <table class="table table-hover table-borderless mb-0">
                                <thead class="table-light text-uppercase text-secondary small">
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
</body>
</html>




