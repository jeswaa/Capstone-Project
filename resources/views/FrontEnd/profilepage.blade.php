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

    <!-- Background Banner -->
    <div class="container-fluid position-relative p-0 mb-n5">
        <div class="bg-image" style="background: url('{{ asset('images/Screenshot.png') }}') no-repeat center center; background-size: cover; height: 300px;">
            <div class="d-flex justify-content-start align-items-start">
                <a href="{{ route('calendar') }}" class="m-3 mt-5">
                    <i class="text-color-1 fa-2x fa-circle-left fa-solid icon icon-hover color-3"></i>
                </a>
            </div>

    <!-- Flash Messages -->
    <div class="container mt-3">
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
            <div class="alert alert-success">{{ session('success') }}</div>
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

    <!-- Main Layout: Profile & Reservation Section -->
    <div class="container mt-1 mt-n3 mb-5 position-relative">
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
                        <p class="fw-bold text-start"><i class="fa-solid fa-circle-user"></i>&nbsp;{{ $user->name }}</p>
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

            <!-- Reservation Section -->
            <div class="col-md-8" >
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
                       <h5 class="mb-3 mt-3 fw-bold">YOUR CURRENT RESERVATION</h5>
                       @if ($latestReservation)
                           <div class="row">
                               <div class="col-md-8">
                                   <div class="card mb-3">
                                       <div class="card-body fw-bold">
                                           <p><strong>Room Type:</strong> 
                                               {{ $reservationDetails->package_room_type ?? 'N/A' }}  
                                               @foreach($accommodations as $accommodation) {{ $accommodation }} @endforeach 
                                           </p>                             
                                           <p><strong>Check-in:</strong> {{ $latestReservation->reservation_check_in }} - {{ $latestReservation->reservation_check_out }}</p>
                                           <p><strong>Check-in Date:</strong> {{ \Carbon\Carbon::parse($latestReservation->reservation_check_in_date)->format('F j, Y') }}</p>
                                           <p><strong>Special Request:</strong> {{ $latestReservation->special_request ?? 'None' }}</p>
                                           <p><strong>Amount:</strong> {{ $latestReservation->amount }}</p>
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

    <script>
        function toggleHistory(event, sectionToShow) {
            event.preventDefault();
            document.getElementById('reservation-list-section').style.display = (sectionToShow === 'reservation-list-section') ? 'block' : 'none';
            document.getElementById('history-section').style.display = (sectionToShow === 'history-section') ? 'block' : 'none';
        }
    </script>

</body>
</html>
