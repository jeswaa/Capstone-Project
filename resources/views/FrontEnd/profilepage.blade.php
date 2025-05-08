<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
</style>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    <nav class="navbar navbar-expand-lg  position-absolute top-0 w-100" style="z-index: 10;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4"
                            style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4"
                            style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4"
                            style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#reviews">Review</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}"
                    class="me-3 text-color-2 fs-5 p-2 text-decoration-none fw-semibold text-uppercase text-underline-left-to-right"
                    style="font-family: 'Josefin Sans', sans-serif;">Login</a>
                <a class="navbar-brand d-none d-md-block" href="#">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort" id="logo" height="150" width="130">
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="toast show align-items-center text-white bg-danger border-0 mb-2" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix these errors:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-hide toasts after 5 seconds
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();

                setTimeout(() => {
                    bsToast.hide();
                }, 5000);
            });
        });
    </script>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('editProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" width="150"
                                    class="img-fluid mt-2" required>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="mobileNo" class="form-label">Mobile Number</label>
                            <input type="number" class="form-control" id="mobileNo" name="mobileNo"
                                value="{{ $user->mobileNo }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $user->address }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Layout: Profile & Reservation Section -->
    <div class="container mt-1 mt-n3 position-relative ms-0 ">
        <div class="row justify-content-center">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="p-4 shadow bg text-center text-white color-background8 h-100">
                    <!-- Back Arrow -->
                    <div class="d-flex justify-content-start align-items-start mb-3">
                        <a href="{{ route('calendar') }}" class="text-decoration-none">
                            <i class="text-color-1 fa-2x fa-circle-left fa-solid icon icon-hover color-3"></i>
                        </a>
                    </div>

                    <!-- Profile Image -->
                    <div class="d-flex justify-content-center">
                        <div class="rounded-circle border border-white overflow-hidden w-150px h-150px">
                            <img src="{{ $user->image ? url('storage/' . $user->image) : asset('images/default-profile.jpg') }}"
                                alt="Profile Image" class="rounded-circle mx-auto p-3 w-100 h-100">
                        </div>
                    </div>
                    <!-- User Info -->
                    <div>
                        <h1>Personal Details</h1>
                    </div>
                    <div class="text-center mt-3">

                        <p class="fw-bold text-start"><i class="fa-solid fa-envelope"></i>&nbsp;{{ $user->email }}</p>
                        <p class="fw-bold text-start"><i class="fa-solid fa-phone"></i>&nbsp;{{ $user->mobileNo }}</p>
                        <p class="fw-bold text-start"><i class="fa-solid fa-location-dot"></i>&nbsp;{{ $user->address }}
                        </p>
                    </div>

                    <!-- Buttons: Logout & Edit -->
                    <div class="d-flex justify-content-between mt-4 px-3">
                        <a href="{{ route('logout.user') }}" data-bs-toggle="tooltip" title="Log out">
                            <i class="text-white fa-solid fa-right-from-bracket fs-4 icon-hover mt-5"></i>
                        </a>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" title="Edit your profile">
                            <i class="text-white fa-solid fa-pen fs-4 icon-hover mt-5"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-8 mt-md-10 mt-lg-12" style="margin-top: 8rem !important;">
                <div>
                    <p class="fw-bold text-start display-4"><span class="text-white fs-1">Hello,<br></span><span
                            class="text-color-2">{{ $user->name }}</span></p>
                </div>
                <div class="p-4 shadow text-white background-color mt-5">
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="reservation-tab"
                                onclick="toggleTab(event, 'reservation-list-section', 'reservation-tab', 'history-tab')"
                                style="background-color: #0b573d; color: white;">Reservation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="history-tab"
                                onclick="toggleTab(event, 'history-section', 'history-tab', 'reservation-tab')"
                                style="background-color: white; color: #0b573d;">History</a>
                        </li>
                    </ul>

                    <script>
                        function toggleTab(event, sectionToShow, activeTabId, inactiveTabId) {
                            event.preventDefault();

                            // Toggle sections visibility
                            document.getElementById('reservation-list-section').style.display = 'none';
                            document.getElementById('history-section').style.display = 'none';
                            document.getElementById(sectionToShow).style.display = 'block';

                            // Toggle tab styles
                            document.getElementById(activeTabId).style.backgroundColor = '#0b573d';
                            document.getElementById(activeTabId).style.color = 'white';
                            document.getElementById(inactiveTabId).style.backgroundColor = 'white';
                            document.getElementById(inactiveTabId).style.color = '#0b573d';
                        }
                    </script>


                    <!-- Reservation List -->
                    <section id="reservation-list-section">
                        <h5 class="mb-4 fw-bold text-color-2 border-bottom pb-2">YOUR CURRENT RESERVATION</h5>
                        @if ($latestReservation && $latestReservation->payment_status !== 'cancelled')
                            <div class="row">
                                <div class="col-12">
                                    <div class="border-0 mb-4" style="background: transparent;">
                                        <div class="fw-bold text-color-2">
                                            <div class="d-flex align-items-center mb-3">
                                                <p class="mb-0"><strong>Status:</strong></p>
                                                <span class="badge ms-2 @if($latestReservation->payment_status == 'paid') bg-success 
                                                @elseif($latestReservation->payment_status == 'pending') bg-warning 
                                                @elseif($latestReservation->payment_status == 'booked') bg-primary
                                                @else bg-danger @endif">
                                                    {{ $latestReservation->payment_status }}
                                                </span>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-4"><strong>Room Type</strong></div>
                                                <div class="col-8">
                                                    @foreach($accommodations as $accommodation) {{ $accommodation }}
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-4"><strong>Time Check-In</strong></div>
                                                <div class="col-8">{{ $latestReservation->reservation_check_in }} - {{ $latestReservation->reservation_check_out }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-4"><strong>Date Check-In</strong></div>
                                                <div class="col-8">{{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('F j, Y') }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-4"><strong>Special Request</strong></div>
                                                <div class="col-8">{{ $latestReservation->special_request ?? 'None' }}</div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-4"><strong>Balance</strong></div>
                                                <div class="col-8">₱{{ number_format($latestReservation->amount, 2) }}</div>
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-danger px-5 py-3" style="border-radius: 5;" onclick="openCancelModal({{ $latestReservation->id }})">
                                                    Cancel Booking
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center text-muted">No reservations yet.</p>
                        @endif
                    </section>

                    <!-- History Section -->
                    <section id="history-section" style="display: none;">
                        <h5 class="text-center mt-3">Your Reservation History</h5>
                        @forelse ($pastReservations as $reservation)
                            <div class="card mb-3 mt-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <p><strong>Status:</strong>
                                            <span
                                                class="badge 
                                                                                                                                                                                                                                                                @if(isset($reservation) && $reservation->payment_status == 'paid') bg-success 
                                                                                                                                                                                                                                                                @elseif(isset($reservation) && $reservation->payment_status == 'pending') bg-warning 
                                                                                                                                                                                                                                                                @elseif(isset($reservation) && $reservation->payment_status == 'booked') bg-primary 
                                                                                                                                                                                                                                                                    @else bg-danger 
                                                                                                                                                                                                                                                                @endif">
                                                {{ isset($reservation) ? $reservation->payment_status : 'N/A' }}
                                            </span>
                                        </p>
                                    </div>
                                    <p><strong>Room Type:</strong> {{ $reservation->package_room_type ?? 'N/A' }}</p>
                                    <p><strong>Check-in:</strong> {{ $reservation->reservation_check_in }}</p>
                                    <p><strong>Check-out:</strong> {{ $reservation->reservation_check_out }}</p>
                                    <p><strong>Guests:</strong> {{ $reservation->package_max_guests }}</p>
                                    <p><strong>Amount:</strong> {{ $reservation->amount }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No reservation history found.</p>
                        @endforelse
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Reservation Modal -->
    <div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReservationModalLabel">Cancel Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this reservation?</p>
                    @if(isset($latestReservation) && $latestReservation && $latestReservation->id)
                        <form method="POST"
                            action="{{ route('guestcancelReservation', ['id' => $latestReservation->id]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="cancel_reason">Reason for cancellation:</label>
                                <textarea class="form-control" id="cancel_reason" name="cancel_reason" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Confirm Cancel</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            No active reservation found to cancel.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCancelModal(reservationId) {
            // Store the reservation ID if needed for the cancellation process
            document.getElementById("cancelReservationModal").setAttribute("data-reservation-id", reservationId);
            let modal = new bootstrap.Modal(document.getElementById("cancelReservationModal"));
            modal.show();
        }

        function confirmCancel() {
            // Retrieve the reservation ID
            let reservationId = document.getElementById("cancelReservationModal").getAttribute("data-reservation-id");
            // Implement the cancellation logic here, potentially an AJAX request to cancel the reservation
            console.log("Reservation ID to cancel:", reservationId);
            // Close the modal after cancellation
            let modal = bootstrap.Modal.getInstance(document.getElementById("cancelReservationModal"));
            modal.hide();
        }
    </script>

    <script>
        function toggleHistory(event, sectionToShow) {
            event.preventDefault();
            document.getElementById('reservation-list-section').style.display = (sectionToShow === 'reservation-list-section') ? 'block' : 'none';
            document.getElementById('history-section').style.display = (sectionToShow === 'history-section') ? 'block' : 'none';
        }
    </script>

</body>

</html>