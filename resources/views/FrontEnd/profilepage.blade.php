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

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    <nav class="navbar navbar-expand-lg position-absolute top-0 w-100" style="z-index: 0;">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0"></ul>
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
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-md-8">
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="image" id="image"
                                            accept="image/*">
                                    </div>
                                </div>
                                @if ($user->image)
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex justify-content-center justify-content-md-start">
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image"
                                                class="img-fluid rounded shadow-sm"
                                                style="width: 100%; height: 120px; object-fit: cover;" required>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Profile Card -->
            <div class="col-12 col-md-4 col-lg-3" style="background-color: #0b573d; min-height: 100vh; z-index: 1;">
                <div class="p-4 text-white d-flex flex-column">
                    <!-- Back Arrow -->
                    <div class="d-flex justify-content-start align-items-start mb-4">
                        <a href="{{ route('homepage') }}" class="text-decoration-none">
                            <i class="text-white fa-2x fa-circle-left fa-solid"></i>
                        </a>
                    </div>

                    <!-- Profile Image -->
                    <div class="text-center mb-3">
                        <div class="rounded-circle border border-white overflow-hidden mx-auto"
                            style="width: 150px; height: 150px;">
                            <img src="{{ $user->image ? url('storage/' . $user->image) : asset('images/default-profile.jpg') }}"
                                alt="Profile Image" class="img-fluid rounded-circle w-100 h-100 object-fit-cover">
                        </div>
                        <!-- Edit Button -->
                        <div class="mt-2">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editModal" class="text-decoration-none">
                                <u class="text-white">Edit Profile</u>
                            </a>
                        </div>
                    </div>

                    <div class="mb-1">
                        <hr style="height: 2px; background-color: white; opacity: 0.8;">
                    </div>

                    <div class="text-center mb-4">
                        <h4 class="text-uppercase fw-bold">Personal Details</h4>
                    </div>

                    <div class="mt-2">
                        <div class="d-flex mb-3">
                            <div style="width: 30px;">
                                <i class="fa-solid fa-envelope fa-lg"></i>
                            </div>
                            <span class="text-break ms-3"
                                style="font-size: clamp(0.875rem, 2vw, 1rem);">{{ $user->email }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <div style="width: 30px;">
                                <i class="fa-solid fa-phone fa-lg"></i>
                            </div>
                            <span class="ms-3"
                                style="font-size: clamp(0.875rem, 2vw, 1rem);">{{ $user->mobileNo }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <div style="width: 30px;">
                                <i class="fa-solid fa-location-dot fa-lg"></i>
                            </div>
                            <span class="text-break ms-3"
                                style="font-size: clamp(0.875rem, 2vw, 1rem);">{{ $user->address }}</span>
                        </div>
                    </div>

                    <!-- Buttons: Logout -->
                    <div class="mt-5 text-end">
                        <a href="{{ route('logout.user') }}" class="text-decoration-none">
                            <u class="text-white">Log Out <i
                                    class="fa-solid fa-right-from-bracket ms-2 text-white"></i></u>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-8 col-lg-9 px-5 py-3" style="margin-top: 80px;">
                <div>
                    <p class="fw-bold text-start display-4"><span class="text-white fs-1">Hello,<br></span><span
                            class="text-color-2">{{ $user->name }}</span></p>
                </div>

                <!-- Main Content Area -->
                <div class="row">
                    <!-- Reservation Section -->
                    <div class="col-md-8">
                        <div class="p-3 shadow text-white background-color mt-4">
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
                                                        <span class="badge ms-2 text-capitalize @if($latestReservation->reservation_status == 'reserved') bg-primary 
                                                        @elseif($latestReservation->reservation_status == 'checked-in') bg-success
                                                        @elseif($latestReservation->reservation_status == 'pending') bg-warning
                                                        @elseif($latestReservation->reservation_status == 'early-checked-out') bg-danger
                                                        @elseif($latestReservation->reservation_status == 'checked-out') bg-danger
                                                        @else bg-danger @endif">
                                                            {{ $latestReservation->reservation_status }}
                                                        </span>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4"><strong>Room Type</strong></div>
                                                        <div class="col-8">
                                                            @foreach($accommodations as $accommodation)
                                                                {{ $accommodation }}
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4"><strong>Time Check-In</strong></div>
                                                        <div class="col-8">
                                                            {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in)->format('h:i A') }} -
                                                            {{ \Carbon\Carbon::parse($latestReservation->reservation_check_out)->format('h:i A') }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4"><strong>Date Check-In</strong></div>
                                                        <div class="col-8">
                                                            {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('F j, Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4"><strong>Special Request</strong>
                                                        </div>
                                                        <div class="col-8">
                                                            {{ $latestReservation->special_request ?? 'None' }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-4"><strong>Balance</strong></div>
                                                        <div class="col-8">
                                                            ₱{{ number_format($latestReservation->amount, 2) }}
                                                        </div>
                                                    </div>
                                                    @if($latestReservation->reservation_status == 'pending')
                                                    <div class="text-end">
                                                        <button class="btn btn-danger px-5 py-3" style="border-radius: 5;"
                                                            onclick="openCancelModal({{ $latestReservation->id }})">
                                                            <strong>Cancel Booking</strong>
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center text-muted">No reservations yet.</p>
                                @endif
                            </section>

                            <section id="history-section" style="display: none;">
                                <h5 class="text-center mt-3">Your Reservation History</h5>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    @forelse ($pastReservations as $reservation)
                                        <div class="card mb-3 mt-4">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <p><strong>Status:</strong>
                                                        <span class="badge 
                                                            @if(isset($reservation) && $reservation->payment_status == 'paid') bg-success 
                                                            @elseif(isset($reservation) && $reservation->payment_status == 'pending') bg-warning 
                                                            @elseif(isset($reservation) && $reservation->payment_status == 'booked') bg-primary 
                                                            @else bg-danger 
                                                            @endif">
                                                            {{ isset($reservation) ? $reservation->payment_status : 'N/A' }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <p><strong>Check-in:</strong>
                                                    {{ $reservation->reservation_check_in }}</p>
                                                <p><strong>Check-out:</strong>
                                                    {{ $reservation->reservation_check_out }}</p>
                                                <p><strong>Guests:</strong> {{ $reservation->total_guest }}</p>
                                                <p><strong>Amount:</strong> {{ $reservation->amount }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center text-muted">No reservation history found.</p>
                                    @endforelse
                                </div>
                            </section>
                        </div>
                    </div>
                    
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

    <style>
        @media (max-width: 767.98px) {
            .col-12 {
                position: static !important;
                height: auto !important;
            }

            .offset-md-4 {
                margin-left: 0 !important;
            }

            .offset-lg-3 {
                margin-left: 0 !important;
            }

            .px-5 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Set initial states
            document.getElementById('reservation-list-section').style.display = 'block';
            document.getElementById('history-section').style.display = 'none';

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

        function openCancelModal(reservationId) {
            // Store the reservation ID if needed for the cancellation process
            document.getElementById("cancelReservationModal").setAttribute("data-reservation-id", reservationId);
            let modal = new bootstrap.Modal(document.getElementById("cancelReservationModal"));
            modal.show();
        }

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

        // Profile menu toggle functionality
        const profileToggleBtn = document.querySelector('[data-bs-target="#profileContent"]');
        const profileContent = document.getElementById('profileContent');

        // Toggle menu when clicking the burger icon
        profileToggleBtn.addEventListener('click', function () {
            const bsCollapse = bootstrap.Collapse.getInstance(profileContent);
            if (!bsCollapse) {
                // Initialize collapse if not yet initialized
                new bootstrap.Collapse(profileContent);
            } else {
                bsCollapse.toggle();
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            if (!profileContent.contains(event.target) &&
                !profileToggleBtn.contains(event.target) &&
                profileContent.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(profileContent);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    </script>
</body>

</html>