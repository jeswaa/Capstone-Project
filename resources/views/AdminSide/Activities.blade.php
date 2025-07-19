<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Activities</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    h1,
    h5 {
        font-family: 'Anton', sans-serif;
    }

    body,
    p,
    h6,
    li,
    span {
        font-family: 'Montserrat', sans-serif;
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

<<<<<<< HEAD
    .fancy-link:hover::after {
        width: 100%;
    }

    .fancy-link.active::after {
        width: 100% !important;
    }
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    <div class="container-fluid min-vh-100 d-flex p-0">
        @include('Alert.loginSuccessUser')
        @include('Navbar.sidenavbar')

        <!--  Main Content -->
        <div class="col-md-9 col-lg-10 py-4 px-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-semibold fs-1"
                    style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;">ACTIVITIES</h1>
                <form class="d-flex w-50 ms-5" role="search">
                    <div class="input-group">
                        <input type="search" class="form-control rounded-start-5 border-3 border-secondary"
                            style="background-color: transparent; height: 40px;" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-secondary h-75 rounded-end-5" style="color: #e9ffcc;" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100"
                    class="rounded-pill me-3">
            </div>

            <hr class="border-5">
            <!-- Links -->
            <div class="d-flex justify-content-center">
                <a href="{{ route('reservations') }}" class="text-color-2 text-decoration-none me-5 fancy-link "
                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                    <h1 class="fs-1 text-uppercase">Reservation</h1>
                </a>
                <a href="{{ route('rooms') }}" class="text-color-2 me-5 text-decoration-none fancy-link "
                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                    <h1 class="fs-1 text-uppercase">Room </h1>
                </a>
                <a href="{{ route('addActivities') }}" class="text-color-2 text-decoration-none fancy-link active"
                    style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                    <h1 class="fs-1 text-uppercase">Activities</h1>
                </a>
            </div>

            <div>
                <div class="d-flex justify-content-end mb-5 mt-5">
                    <button type="button"
                        class="p-3 border-0 rounded-3 color-background8 text-hover-1 w-25 text-white w-md-25 font-paragraph text-uppercase fw-bold"
                        data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        Add Activity
                    </button>
                </div>

                <!-- Add Activity Modal -->
                <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content border-0">
                            <div class="modal-header border-0" style="background-color: #0b573d;">
                                <h5 class="modal-title text-white fw-bold" id="addActivityModalLabel"
                                    style="font-family: 'Poppins', sans-serif;">Add New Activity</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form action="{{ route('storeActivity') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="activity_name" class="form-label fw-semibold"
                                            style="font-family: 'Poppins', sans-serif;">Activity Name</label>
                                        <input type="text" class="form-control border-2" id="activity_name"
                                            name="activity_name" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="activity_image" class="form-label fw-semibold"
                                            style="font-family: 'Poppins', sans-serif;">Activity Image</label>
                                        <input type="file" class="form-control border-2" id="activity_image"
                                            name="activity_image" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="activity_status" class="form-label fw-semibold"
                                            style="font-family: 'Poppins', sans-serif;">Activity Status</label>
                                        <select class="form-select border-2" id="activity_status" name="activity_status"
                                            required>
                                            <option value="Available">Available</option>
                                            <option value="Unavailable">Unavailable</option>
                                        </select>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn text-white px-4 py-2"
                                            style="background-color: #0b573d;">Add Activity</button>
                                    </div>
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
                                    <td><img src="{{ asset('storage/' . $activity->activity_image) }}"
                                            class="img-fluid rounded" style="width: 50px; height: 50px;" alt=""></td>
                                    <td>{{ $activity->activity_name }}</td>
                                    <td>{{ $activity->activity_status }}</td>
                                    <td>
                                        <a href="#editActivityModal{{ $activity->id }}" class="text-warning mx-2"
                                            data-bs-toggle="modal"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <!-- Edit Activity Modal -->
                                <div class="modal fade" id="editActivityModal{{ $activity->id }}" tabindex="-1"
                                    aria-labelledby="editActivityModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editActivityModalLabel">Edit Activity</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('updateActivity', $activity->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="activity_name">Activity Name</label>
                                                        <input type="text" class="form-control" id="activity_name"
                                                            name="activity_name" value="{{ $activity->activity_name }}">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="activity_image">Activity Image</label>
                                                        <input type="file" class="form-control" id="activity_image"
                                                            name="activity_image">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="activity_status">Activity Status</label>
                                                        <select class="form-select" id="activity_status"
                                                            name="activity_status">
                                                            <option value="Available" @if ($activity->activity_status == 'Available') selected @endif>
                                                                Available</option>
                                                            <option value="Unavailable" @if ($activity->activity_status == 'Unavailable') selected @endif>
                                                                Unavailable</option>
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
=======
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
    @include('Alert.loginSuccessUser')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <div class="d-flex w-100" id="mainLayout" style="min-height: 100vh;">
            @include('Navbar.sidenavbar')
            <!--  Main Content -->
            <div id="mainContent" class="flex-grow-1 py-4 px-4 transition-width" style="transition: all 0.3s ease;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="fw-semibold fs-1" style="font-family: 'Anton', sans-serif; color: #0b573d; letter-spacing: 0.2em;"></h1>
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
                        <button type="button" class="p-3 border-0 rounded-3 text-white w-25 w-md-25 font-paragraph text-uppercase fw-bold" style="background-color: #0b573d;" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                            Add Activity
                        </button>
                    </div>

                    <!-- Add Activity Modal -->
                    <div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0">
                                <div class="modal-header border-0" style="background-color: #0b573d;">
                                    <h5 class="modal-title text-white fw-bold" id="addActivityModalLabel" style="font-family: 'Poppins', sans-serif;">Add New Activity</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('storeActivity') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="activity_name" class="form-label fw-semibold" style="font-family: 'Poppins', sans-serif;">Activity Name</label>
                                            <input type="text" class="form-control border-2" id="activity_name" name="activity_name" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="activity_image" class="form-label fw-semibold" style="font-family: 'Poppins', sans-serif;">Activity Image</label>
                                            <input type="file" class="form-control border-2" id="activity_image" name="activity_image" required>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="activity_status" class="form-label fw-semibold" style="font-family: 'Poppins', sans-serif;">Activity Status</label>
                                            <select class="form-select border-2" id="activity_status" name="activity_status" required>
                                                <option value="Available">Available</option>
                                                <option value="Unavailable">Unavailable</option>
                                            </select>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn text-white px-4 py-2" style="background-color: #0b573d;">Add Activity</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
>>>>>>> e7feac40c7fb2d9dcc6a9eec3e7fbbf774d09206
                </div>
            </div>
        </div>
    </div>
</body>

</html>