<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        /* Ensure the burger menu button is always on the right for mobile */
        @media (max-width: 767.98px) {
            #sidebarToggle {
                position: fixed;
                top: 1rem;
                right: 1rem;
                z-index: 1050;
            }

            #profileSidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background-color: #0b573d;
                overflow-y: auto;
                z-index: 1040;
                transition: transform 0.3s ease-in-out;
                transform: translateX(-100%);
                display: block !important;
            }

            #profileSidebar.show {
                transform: translateX(0);
            }

            .row.g-0 {
                margin-left: 0 !important;
                flex-direction: column;
            }

            #mainContent {
                width: 100%;
                position: relative;
                height: auto;
                background: inherit;
            }

            body.sidebar-open #mainContent {
                margin-top: 1rem;
            }
        }

        }

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

            /* Styling for mobile sidebar */
            #profileSidebar {
                position: relative;
                width: 100%;
                height: auto;
                min-height: auto;
                overflow-y: hidden;
                display: none;
                background-color: #0b573d;
            }

            #profileSidebar.show {
                display: block;
            }

            /* Main content styling for mobile */
            #mainContent {
                width: 100%;
                position: relative;
                height: auto;
                background: inherit;
            }

            /* Remove any transitions or transformations */
            body.sidebar-open #mainContent {
                margin-top: 1rem;
            }

            /* Ensure no blank space */
            .row.g-0 {
                margin-left: 0 !important;
                flex-direction: column;
            }
        }

        @media (min-width: 768px) {
            #desktopSidebarToggle {
                position: relative;
                z-index: 1050;
            }
        }

        @media (min-width: 768px) {
            #profileSidebar {
                transform: none !important;
            }

            /* Reset order for desktop view */
            .order-md-1 {
                order: 1 !important;
            }

            .order-md-2 {
                order: 2 !important;
            }
        }

        .current-reservation {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem 2rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color: #0b573d;
            font-family: 'Poppins', sans-serif;
        }

        .current-reservation table {
            width: 100%;
            border-collapse: collapse;
        }

        .current-reservation th,
        .current-reservation td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .current-reservation th {
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 2px solid #0b573d;
            letter-spacing: 0.1em;
        }

        #profileSidebar.collapsed {
    width: 0;
    overflow: hidden;
    transition: width 0.3s ease;
}

#desktopSidebarToggle.collapsed {
    position: fixed;
    top: 1.5rem;
    left: 0rem;
    z-index: 1050;
    background-color: transparent !important;
    color: white !important;
    border: none !important;
    padding: 10px 15px !important;
    border-radius: 4px;
}
    </style>
</head>

<body
    style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.infoNotif')


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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-0" style="background-color: #0b573d;">
                    <h5 class="modal-title text-white text-uppercase"
                        style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;" id="editModalLabel">Edit
                        Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('editProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Profile
                                Picture</label>
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
                </div>
                <div class="mb-4">

                    <label for="name" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                        required>
                </div>
                <div class="mb-2">
                    <div class="mb-3">
                        <label for="mobileNo" class="form-label text-uppercase fw-bold" style="color: #0b573d;">Mobile
                            Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="mobileNo" name="mobileNo"
                                value="{{ substr($user->mobileNo, 0, 11) }}" required maxlength="11"
                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) && event.charCode != 45;"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);"
                                pattern="[0-9]{11}" title="Please enter a valid 11-digit mobile number (numbers only)">
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="address" class="form-label text-uppercase fw-bold"
                        style="color: #0b573d;">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}"
                        required>
                </div>
                <button type="submit" class="btn text-white w-100" style="background-color: #0b573d;">Save
                    changes</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Main Layout: Profile & Reservation Section -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Burger Menu Button (Visible only on mobile) -->
            <div class="d-md-none position-fixed top-0 end-0 p-3" style="z-index: 1030;">
                <button class="btn btn-success" type="button" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <!-- Profile Card -->
            <div class="col-12 col-md-4 col-lg-3" id="profileSidebar"
                style="background-color: #0b573d; min-height: 100vh; z-index: 1020;">
                <div class="p-4 text-white d-flex flex-column">
                    <!-- Back Arrow -->
                    <!-- Modify the toggle button container to use flex with justify-content-between -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('homepage') }}" class="text-decoration-none">
                            <i class="text-white fa-2x fa-house fa-solid"></i>
                        </a>

                        <button id="desktopSidebarToggle" class="btn btn-xl btn-light d-none d-md-block"
                            style="background-color: #0b573d; color: white; border: none; padding: 15px 20px;">
                            <i class="fa-solid fa-bars fa-2x"></i>
                        </button>
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
                        <a href="{{ route('logout.user') }}" class="text-decoration-none text-white">
                            Log Out <i class="fa-solid fa-right-from-bracket ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-8 col-lg-9 px-5 py-3" id="mainContent">
                <div>
                    <p class="fw-bold text-start display-4"><span class="text-white fs-1">Hello,<br></span><span
                            class="text-color-2">{{ $user->name }}</span></p>
                </div>

                <div id="dateTimeDisplay" class="position-absolute mt-0 end-0 p-2 pe-5 text-end d-none d-lg-block"
                    style="top: 4rem; z-index: 1100; font-family: 'Montserrat', sans-serif;">
                    <div id="time" class="fw-bold fs-1"></div>
                    <div id="date" class="fs-5"></div>
                </div>

                <div class="current-reservation">
                    <h2 class="fw-bold" style="color: #0b573d;">CURRENT RESERVATION</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="color: #0b573d;">Room Type</th>
                                    <th scope="col" style="color: #0b573d;">Reservation Type</th>
                                    <th scope="col" style="color: #0b573d;">Check IN</th>
                                    <th scope="col" style="color: #0b573d;">Check Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Reservation rows go here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="row">
                    <!-- Reservation Section -->
                    <div class="col-12 col-xl-10 mx-auto" style="max-width: 100%; width: 100%;">
                        <div class="p-3 shadow text-white background-color mt-1">
                            <!-- Navigation Tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item w-60">
                                    <a class="nav-link active w-100 text-center" href="#" id="reservation-tab"
                                        onclick="toggleTab(event, 'reservation-list-section', 'reservation-tab', 'history-tab')"
                                        style="background-color: #0b573d; color: white;">Reservation</a>
                                </li>
                            </ul>

                            <!-- Reservation List -->
                            <section id="reservation-list-section" class="p-3 p-md-4 w-100">
                                <h5 class="mb-4 text-color-2 border-bottom pb-2"
                                    style="color: #0b573d; letter-spacing: 0.2em;">RESERVATION</h5>
                                @if ($latestReservation && $latestReservation->reservation_status !== 'cancelled')
                                                    <div class="card shadow-sm border-0 w-100"
                                                        style="background-color: rgba(255, 255, 255, 0.9);">
                                                        <div class="card-body p-3 p-md-4">
                                                            <div class="row align-items-center">
                                                                <div class="col-12 col-md-3 fw-semibold text-success">Room Type</div>
                                                                <div class="col-12 col-md-5 text-success">
                                                                    @foreach($accommodations as $accommodation){{ $accommodation }}@endforeach
                                                                </div>
                                                                <div class="col-6 col-md-2">
                                                                    <span class="badge text-capitalize px-3 py-2 @if($latestReservation->reservation_status == 'checked in') bg-success 
                                                                    @elseif($latestReservation->reservation_status == 'pending') bg-warning 
                                    @elseif($latestReservation->reservation_status == 'reserved') bg-primary
                                    @else bg-danger @endif">
                                                                        {{ $latestReservation->reservation_status }}
                                                                    </span>
                                                                </div>
                                                               <div class="col-6 col-md-2 d-grid  text-end">
    <button type="button" class="btn btn-outline-success w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#viewReservationModal">
        View
    </button>
</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="viewReservationModal" tabindex="-1"
                                                        aria-labelledby="viewReservationModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background-color: #0b573d;">
                                                                    <h5 class="modal-title text-white" id="viewReservationModalLabel">
                                                                        Reservation Details</h5>
                                                                    <button type="button" class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" style="color: #0b573d;">
                                                                    <div class="row g-4">
                                                                        <div class="col-12 col-md-6">
                                                                            <p><strong>Reservation Type:</strong>
                                                                                @php
                                                                                    $checkInDate = \Carbon\Carbon::parse($latestReservation->reservation_check_in_date);
                                                                                    $checkOutDate = \Carbon\Carbon::parse($latestReservation->reservation_check_out_date);
                                                                                    $daysDiff = $checkInDate->diffInDays($checkOutDate);
                                                                                @endphp
                                                                                @if($daysDiff == 0)
                                                                                    Day Tour
                                                                                @else
                                                                                    Stay In ({{ $daysDiff }}
                                                                                    {{ Str::plural('night', $daysDiff) }})
                                                                                @endif
                                                                            </p>
                                                                            <p><strong>Time Check-In:</strong>
                                                                                {{ date('h:i A', strtotime($latestReservation->reservation_check_in)) }}
                                                                                -
                                                                                {{ date('h:i A', strtotime($latestReservation->reservation_check_out)) }}
                                                                            </p>
                                                                            <p><strong>Date Check In - Out:</strong>
                                                                                {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('F j, Y') }}
                                                                                -
                                                                                {{ \Carbon\Carbon::parse($latestReservation->reservation_check_out_date)->format('F j, Y') }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-12 col-md-6">
                                                                            <p><strong>Special Request:</strong>
                                                                                {{ $latestReservation->special_request ?? 'None' }}</p>
                                                                            <p><strong>Total Amount:</strong>
                                                                                ₱{{ number_format($latestReservation->amount, 2) }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                @else
                                    <div class="text-center p-4 p-md-5 w-100">
                                        <i class="fas fa-calendar-times fa-3x mb-3" style="color: #0b573d;"></i>
                                        <p class="text-muted">No reservations yet.</p>
                                    </div>
                                @endif
                            </section>

                            <section id="history-section" class="p-3 p-md-4" style="display: none;">
                                <h5 class="text-center mt-3">Your Reservation History</h5>
                                @forelse ($pastReservations as $reservation)
                                    <div class="card mb-3 mt-4">
                                        <div class="card-body p-3 p-md-4">
                                            <div
                                                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                                <p class="mb-0"><strong>Status:</strong>
                                                    <span class="badge ms-2 @if(isset($reservation) && $reservation->payment_status == 'paid') bg-success 
                                                    @elseif(isset($reservation) && $reservation->payment_status == 'pending') bg-warning 
                                                        @elseif(isset($reservation) && $reservation->payment_status == 'booked') bg-primary 
                                                            @else bg-danger @endif">
                                                        {{ isset($reservation) ? $reservation->payment_status : 'N/A' }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="mt-3">
                                                <p class="mb-2"><strong>Check-in:</strong>
                                                    {{ $reservation->reservation_check_in }}</p>
                                                <p class="mb-2"><strong>Check-out:</strong>
                                                    {{ $reservation->reservation_check_out }}</p>
                                                <p class="mb-2"><strong>Guests:</strong> {{ $reservation->total_guest }}</p>
                                                <p class="mb-0"><strong>Amount:</strong>
                                                    ₱{{ number_format($reservation->amount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center p-4 p-md-5">
                                        <p class="text-muted mb-0">No reservation history found.</p>
                                    </div>
                                @endforelse
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #0b573d;">
                    <h5 class="modal-title" id="cancelReservationModalLabel">Cancel Reservation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this reservation?</p>
                    @if(isset($latestReservation) && $latestReservation && $latestReservation->id)
                        <form method="POST"
                            action="{{ route('guestcancelReservation', ['id' => $latestReservation->id]) }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="cancel_reason" class="form-label">Reason for cancellation:</label>
                                <select class="form-select" id="cancel_reason" name="cancel_reason" required>
                                    <option value="">Select a reason</option>
                                    <option value="Change of plans">Change of plans</option>
                                    <option value="Found a better deal">Found a better deal</option>
                                    <option value="Travel restrictions">Travel restrictions</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Confirm Cancel</button>
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
        const sidebar = document.getElementById('profileSidebar');
const toggleBtn = document.getElementById('desktopSidebarToggle');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
    toggleBtn.classList.toggle('collapsed');
});
    </script>
    <script>  // TIMER OF THE EARTG
        function updateDateTime() {
            const now = new Date();

            // Format time as h:mm AM/PM
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const timeString = hours + ':' + minutes + ' ' + ampm;

            // Format date as Weekday, Month Day
            const options = { weekday: 'long', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString(undefined, options);

            document.getElementById('time').textContent = timeString;
            document.getElementById('date').textContent = dateString;
        }

        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute
    </script>
    <script>
        function openCancelModal(reservationId) {
            // Check if reservationId is valid
            if (!reservationId) {
                console.error("No valid reservation ID provided.");
                return;
            }

            // Optionally set the reservation ID in a hidden field if you want to use it later
            // document.getElementById('reservationIdInput').value = reservationId;

            // Show the modal using Bootstrap 5
            var modal = new bootstrap.Modal(document.getElementById('cancelReservationModal'));
            modal.show();
        }
    </script>

    <script>
        // Add smooth transition for sidebar collapse/expand
        const sidebar = document.getElementById('profileSidebar');
        const mainContent = document.querySelector('.col-12.col-md-8.col-lg-9');

        sidebar.style.transition = 'all 0.3s ease';
        mainContent.style.transition = 'all 0.3s ease';
    </script>

    <script>
        <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.body.classList.toggle('sidebar-open');
            document.getElementById('profileSidebar').classList.toggle('show');
    });
    </script>
    </script>
</body>

<script>
            document.addEventListener('DOMContentLoaded', function () {
        var sidebar = document.getElementById('profileSidebar');
            var mainContent = document.getElementById('mainContent');
            var toggleBtn = document.getElementById('sidebarToggle');
            var isSidebarOpen = false;

            function openSidebar() {
                sidebar.classList.add('show');
            document.body.classList.add('sidebar-open');
            isSidebarOpen = true;
        }

            function closeSidebar() {
                sidebar.classList.remove('show');
            document.body.classList.remove('sidebar-open');
            isSidebarOpen = false;
        }

            toggleBtn.addEventListener('click', function () {
            if (isSidebarOpen) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

            // Close sidebar when window is resized to desktop view
            window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });

            // Initialize state
            if (window.innerWidth < 768) {
                closeSidebar(); // Ensure sidebar is closed initially on mobile
        }
    });

            // Existing tab toggle function
            function toggleTab(event, showSectionId, activeTabId, inactiveTabId) {
                // ... existing code ...
            }
</script>


</html>