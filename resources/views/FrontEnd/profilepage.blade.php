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
<body class="color-background1">  
    <!-- Container for rectangular top section -->
    <div class="container-fluid position-relative" style="background: url('{{ asset('images/image4.jpg') }}') no-repeat center center; background-size: cover; height: 300px;">
        <a href="{{ route('calendar')}}">
            <i class="text-color-1 fa-2x fa-circle-left fa-solid icon icon-hover ms-3 mt-5"></i>
        </a>
    </div>

    <div class="m-3 position-absolute w-auto start-0 top-0 z-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Left-aligned, slightly moved to the right with custom margin -->
    <div class="position-absolute ms-custom-l start-0 top-custom-l translate-middle-y">
        <div class="p-4 shadow bg" style="width: 25vw; height: 600px; border-radius: 20px; background-color: #B5C99A; position: relative;">
        <a href="{{ route('logout.user') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Log out"><i class="text-color-1 fa-right-from-bracket fa-solid fs-4 icon-hover"></i></a>
            <!-- Circle inside the container, centered -->
            <div class="circle" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -120%); width: 50%; height: 30%; border-radius: 50%; background-color: #718355; border: 3px solid #fff; z-index: 1;">
                <img src="{{ $user->image ? url('storage/' . $user->image) : asset('images/default-profile.jpg') }}" alt="Profile Image" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            </div>

            <!-- Example Name below the circle -->
            <p class="text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, 30%); color: #333; font-size: 18px; font-weight: bold; z-index: 2;">
                {{ $user->name }}
            </p>

            <!-- Email and Contact Number below the Name -->
            <p class="text-center" style="position: absolute; top: 55%; left: 50%; transform: translate(-50%, 30%); color: #555; font-size: 15px; font-weight: bold; z-index: 2;">
                {{ $user->email }} <br> {{ $user->mobileNo }}
            </p>

            <!-- Address at the bottom center of the container -->
            <p class="text-center" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: #444; font-size: 11px; font-weight: bold; z-index: 2;">
                {{ $user->address }}
            </p>

            <!-- Clickable Edit Icon in the upper right -->
            <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#editModal" style="position: absolute; top: 25px; right: 25px; cursor: pointer; z-index: 2;" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit your profile">
                <i class="text-color-1 fa-pen fa-solid icon-hover" style="font-size: 20px;"></i>
            </a>
        </div>
    </div>

    <!-- Include Edit Profile Modal -->
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
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" width="150" class="img-fluid mt-2">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="mobileNo" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobileNo" name="mobileNo" value="{{ $user->mobileNo }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right-aligned, slightly moved to the right with custom margin -->
<div class="position-absolute end-0" style="margin-right: 10%; top: 31%;">
    <div class="p-4 shadow bg" style="width: 50vw; height: 480px; border-radius: 20px; background-color: #B5C99A; position: relative;">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: transparent;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav gap-2">
                        <li class="nav-item me-4">
                            <a class="nav-link text-underline-left-to-right fw-bold" href="#" onclick="toggleHistory(event, 'reservation-list-section')">Reservation</a>
                        </li>
                        <li class="nav-item me-4">
                            <a class="nav-link text-underline-left-to-right fw-bold" href="#" onclick="toggleHistory(event, 'history-section')">History</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section id="reservation-list-section">
                <h5 class="text-center font-paragraph mb-1">Your Reservation</h5>
                @if ($latestReservation)
                    <div class="card mb-3 mt-2">
                        <div class="card-body">
                            <p class="text-end">
                                <strong>Status:</strong>
                                <span class="badge 
                                    @if($latestReservation->payment_status == 'paid') bg-success 
                                    @elseif($latestReservation->payment_status == 'pending') bg-warning 
                                    @elseif($latestReservation->payment_status == 'booked') bg-primary
                                    @else bg-danger 
                                    @endif"
                                    style="text-transform: capitalize;">
                                    {{ $latestReservation->payment_status }}
                                </span>
                            </p>
                            <p><strong>Room Type:</strong>
                                    @if(!empty($reservationDetails->package_room_type))
                                        {{ $reservationDetails->package_room_type }}    
                                    @endif
                                    @foreach($accommodations as $acocomodation)
                                        {{ $acocomodation }}
                                    @endforeach 
                            </p>                            
                            <p><strong>Check-in:</strong> {{ $latestReservation->reservation_check_in }} - {{ $latestReservation->reservation_check_out }}</p>
                            <p><strong>Check-in Date:</strong> {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('F j, Y') }}</p>
                            <p><strong>Special Request:</strong> {{ $latestReservation->special_request ?? 'None' }}</p>
                            <p><strong>Amount:</strong> {{ $latestReservation->amount }}</p>
                            <button class="btn btn-danger btn-sm" onclick="openCancelModal({{ $latestReservation->id }})">
                                Cancel Reservation
                            </button>
                        </div>
                    </div>
                @else
                    <p class="text-center text-muted">No reservations yet.</p>
                @endif
            </section>
            
            <section id="history-section" style="display: none; overflow-y: scroll; max-height: 50vh;">
                <h5 class="text-center font-paragraph mb-3 mt-3">Your Reservation History</h5>
                @forelse ($pastReservations as $reservation)
                    <div class="card mb-3 mt-4">
                        <div class="card-body">
                        <p class="text-end">
                                <strong>Status:</strong>
                                <span class="badge 
                                    @if($latestReservation->payment_status == 'paid') bg-success 
                                    @elseif($latestReservation->payment_status == 'pending') bg-warning 
                                    @elseif($latestReservation->payment_status == 'booked') bg-primary 
                                    @else bg-danger 
                                    @endif"
                                    style="text-transform: capitalize;">    
                                    {{ $latestReservation->payment_status }}
                                </span>
                            </p>
                            <p><strong>Room Type:</strong> {{ $reservation->package_room_type ?? 'N/A' }}</p>
                            <p><strong>Check-in:</strong> {{ $reservation->reservation_check_in }}</p>
                            <p><strong>Check-out:</strong> {{ $reservation->reservation_check_out }}</p>
                            <p><strong>Guests:</strong> {{ $reservation->package_max_guests }}</p>
                            <p><strong>Special Request:</strong> {{ $reservation->special_request ?? 'None' }}</p>
                            <p><strong>Amount:</strong> {{ $reservation->amount }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">No reservation history found.</p>
                @endforelse
            </section>
        </div>
    </div>

    <!-- Cancel Reservation Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cancelForm" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="cancelReservationId">
                        <div class="mb-3">
                            <label for="cancelReason" class="form-label">Reason for Cancellation:</label>
                            <textarea class="form-control" name="cancel_reason" id="cancelReason" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Confirm Cancellation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        function toggleHistory(event, sectionToShow) {
            event.preventDefault();
            document.getElementById('reservation-list-section').style.display = (sectionToShow === 'reservation-list-section') ? 'block' : 'none';
            document.getElementById('history-section').style.display = (sectionToShow === 'history-section') ? 'block' : 'none';
        }

        function openCancelModal(reservationId) {
            document.getElementById("cancelReservationId").value = reservationId;

            let form = document.getElementById("cancelForm");
            form.action = `/reservation/cancel/${reservationId}`;

            var cancelModal = new bootstrap.Modal(document.getElementById("cancelModal"));
            cancelModal.show();
        }

    </script>
    
</body>
</html>


