<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
body {
    background: 
        url("{{ asset('images/Screenshot.png') }}") no-repeat center top, 
        url("{{ asset('images/logosheesh.png') }}") no-repeat center bottom;
    background-size: 100% 40%, 100% 70%; /* 30% taas, 70% baba */
    background-attachment: fixed, fixed; /* Para hindi gumalaw habang nag-scroll */
    position: relative;
    height: 100vh;
    margin: 0;
}
body::before {
    content: "";
    position: fixed;
    top: 10%; /* Aligns with the bottom of the top section */
    left: 0;
    width: 100%;
    height: 30%; /* Covers the top section */
    background: linear-gradient(to top, rgba(0, 93, 59, 0.8), transparent); /* Green smoke effect */
    pointer-events: none;
    z-index: 0;
}

/* White Overlay for Bottom Background */
body::after {
    content: "";
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60%; /* Covers the bottom background */
    background: rgba(255, 255, 255, 0.8); /* White overlay */
    pointer-events: none;
    z-index: -1;
}
</style>  

    <!-- Background Banner -->
    <div class="container-fluid position-relative p-0 mb-n5">
            <div class="d-flex justify-content-start align-items-start">
                <a href="{{ route('calendar') }}" class="m-3 mt-5">
                    <i class="text-color-1 fa-2x fa-circle-left fa-solid icon icon-hover color-3"></i>
                </a>
            </div>

    <!-- Flash Messages -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="toast show align-items-center text-white bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true">
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
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
            <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
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

    <div class="position-absolute top-0 end-0 mt-3 me-5">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
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
                            <input type="file" class="form-control" name="image" id="image" accept="image/*">
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" width="150" class="img-fluid mt-2" required>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobileNo" class="form-label">Mobile Number</label>
                            <input type="number" class="form-control" id="mobileNo" name="mobileNo" value="{{ $user->mobileNo }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Layout: Profile & Reservation Section -->
    <div class="container mt-1 mt-n3 position-relative">
        <div class="row justify-content-center">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="p-4 shadow bg rounded-4 text-center text-white color-background8 h-100">
                    <!-- Profile Image -->
                   <div class="d-flex justify-content-center">
                       <div class="rounded-circle border border-white overflow-hidden w-150px h-150px">
                           <img src="{{ $user->image ? url('storage/' . $user->image) : asset('images/default-profile.jpg') }}" 
                                alt="Profile Image" class="rounded-circle mx-auto p-3 w-100 h-100">
                       </div>
                   </div>
                    <!-- User Info -->
                    
                    <div class="text-center mt-3">

                        <p class="fw-bold text-start"><i class="fa-solid fa-envelope"></i>&nbsp;{{ $user->email }}</p>
                        <p class="fw-bold text-start"><i class="fa-solid fa-phone"></i>&nbsp;{{ $user->mobileNo }}</p>
                        <p class="fw-bold text-start"><i class="fa-solid fa-location-dot"></i>&nbsp;{{ $user->address }}</p>
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

            <div class="col-md-8" >
            <div>
                <p class="fw-bold text-start display-4"><span class="text-white fs-1">Hello,<br></span><span class="color-3">{{ $user->name }}</span></p>
            </div>
                <div class="p-4 shadow bg rounded-4 text-white color-background8 mt-5" >
                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="toggleHistory(event, 'reservation-list-section')">Reservation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="toggleHistory(event, 'history-section')">History</a>
                        </li>
                    </ul>
                    

                    <!-- Reservation List -->
                   <section id="reservation-list-section">
                       <h5 class="mb-3 fw-bold">YOUR CURRENT RESERVATION</h5>
                       @if ($latestReservation && $latestReservation->payment_status !== 'cancelled')
                           <div class="row">
                               <div class="col-md-8">
                                   <div class="card mb-4 shadow-sm">
                                       <div class="card-body fw-bold">
                                           <p>
                                               <strong class="me-5">Room Type:</strong> 
                                               <span class="d-inline-block ms-4">
                                                   @foreach($accommodations as $accommodation) {{ $accommodation }} @endforeach
                                               </span>
                                           </p>
                                           <p>
                                               <strong class="me-5">Check-in:</strong> 
                                               <span class="d-inline-block ms-4">
                                                   {{ $latestReservation->reservation_check_in }} - {{ $latestReservation->reservation_check_out }}
                                               </span>
                                           </p>
                                           <p>
                                               <strong class="me-2">Check-in Date:</strong> 
                                               <span class="d-inline-block ms-4">
                                                   {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('F j, Y') }}
                                               </span>
                                           </p>
                                           <p>
                                               <strong class="me-1">Special Request:</strong> 
                                               <span class="d-inline-block ms-4">
                                                   {{ $latestReservation->special_request ?? 'None' }}
                                               </span>
                                           </p>
                                           <p>
                                               <strong class="me-5">Amount:</strong> 
                                               <span class="d-inline-block ms-4">
                                                   {{ $latestReservation->amount }}
                                               </span>
                                           </p>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-4 d-flex justify-content-between align-items-center">
                                   <p><strong>Status:</strong> 
                                   <span class="badge mb-5
                                       @if($latestReservation->payment_status == 'paid') bg-success 
                                       @elseif($latestReservation->payment_status == 'pending') bg-warning 
                                       @elseif($latestReservation->payment_status == 'booked') bg-primary
                                       @else bg-danger 
                                       @endif">
                                       {{ $latestReservation->payment_status }}
                                   </span>
                                   <button class="btn btn-danger btn-sm mt-5" onclick="openCancelModal({{ $latestReservation->id }})">
                                       Cancel Reservation
                                   </button>
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
                                            <span class="badge 
                                                @if($latestReservation->payment_status == 'paid') bg-success 
                                                @elseif($latestReservation->payment_status == 'pending') bg-warning 
                                                @elseif($latestReservation->payment_status == 'booked') bg-primary 
                                                @else bg-danger 
                                                @endif">
                                                {{ $latestReservation->payment_status }}
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
<div class="modal fade" id="cancelReservationModal" tabindex="-1" aria-labelledby="cancelReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelReservationModalLabel">Cancel Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this reservation?</p>
                @if(isset($latestReservation) && $latestReservation)
                    <form method="POST" action="{{ route('guestcancelReservation', ['id' => $latestReservation->id]) }}">
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