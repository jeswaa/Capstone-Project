<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lelo's Resort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .animate-button {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 87, 61, 0.5);
    }
    .animate-button.icon-move > span > i {
        animation: move-icon 0.5s ease-in-out infinite alternate;
    }
    @keyframes move-icon {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(10px);
        }
    }
    .room-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
    }
    .room-card:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(11, 87, 61, 0.15);
    }
    .room-card, .room-card * {
        user-select: none;
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg  position-absolute top-0 w-100 mt-5" style="z-index: 10;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase me-4 text-underline-left-to-right" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase me-4 text-underline-left-to-right" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#activities">Activities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase me-4 text-underline-left-to-right" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#">Reservations</a>
                    </li>
                </ul>
                <a href="{{ route('profile') }}" class="text-decoration-none">
                    <div class="profile-icon d-flex align-items-center justify-content-center" 
                         style="width: 45px; 
                                height: 45px; 
                                background-color: #0b573d;
                                border-radius: 50%;
                                transition: all 0.3s ease;
                                box-shadow: 0 2px 5px rgba(0,0,0,0.2);"
                         onmouseover="this.style.transform='scale(1.1)'; this.style.backgroundColor='#0d6a4a';" 
                         onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#0b573d';">
                        <i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i>
                    </div>
                </a>
                </a>
            </div>
        </div>
    </nav>
    <!-- First Page -->
    <section id="home">
        <div class="smoke"></div>
        <!-- Hero Section with Background -->
        <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative"
            style="background: url('{{ asset('images/background.png') }}') no-repeat center; background-size: cover; overflow: hidden">
            
    
            <!-- Hero Content -->
            <div id="hero" class="container">
                <div class="row align-items-center justify-content-center">
                    <!-- Responsive Text Content -->
                    <div class="col-lg-6 col-md-10 col-sm-12 text-lg-end text-center ms-auto">
                        <div class="d-flex justify-content-center align-items-center">
                            <h1 class="fw-bold text-white" style="font-size: 3vw; text-align: center;">WELCOME TO LELO'S</h1>
                        </div>
                        <p class="fw-bold" style="color:#e9ffcc; font-size: 10vw; font-weight: 900; line-height: .8; text-align: center;">RESORT</p>
                        <h1 class="fw-bold text-white" style="font-size: 2vw; text-align: center;">DIGITAL BOOKING COMPANION</h1>

                        <!-- Responsive Button -->
                        <div class="d-flex justify-content-lg-center justify-content-center mt-4">
                            <a href="{{ route('calendar') }}"
                                class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-bold text-white"
                                style="border-radius: 50px; background-color: #0b573d; font-style: italic; transition: all 0.3s ease-in-out;"
                                onmouseover="this.classList.add('animate-button'); this.classList.add('icon-move');"
                                onmouseout="this.classList.remove('animate-button'); this.classList.remove('icon-move');">
                                BOOK YOUR STAY
                                <span class="d-flex align-items-center justify-content-center bg-white rounded-circle"
                                    style="width: 1.8rem; height: 1.8rem; transition: all 0.3s ease-in-out;">
                                    <i class="fas fa-chevron-right" style="color: #0b573d; transform: translateX(0);"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Accommodations Section -->
    <section id="rooms">
        <div class="container text-center my-5">
            <div class="py-5">
                <div class="position-relative">
                    <!-- Main heading with enhanced styling -->
                    <div class="position-relative px-4 py-3 w-100" style="background-color: #eaffcc; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            ROOMS
                        </h1>
                    </div>
                </div>
            </div>
            
            <!-- Subtitle with enhanced styling -->
            <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
                Discover your perfect stay - choose from our selection of rooms
            </p>
            
            <!-- Decorative line -->
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                <i class="bi bi-star-fill text-success"></i>
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
            </div>
    
            <!-- Display all accommodation types in a single view -->
            <div class="row g-4 justify-content-center">
                @php
                    $displayedTypes = ['room' => false, 'cottage' => false, 'cabin' => false];
                @endphp
                
                @foreach($accommodations as $accommodation)
                    @if(!$displayedTypes[$accommodation->accomodation_type])
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 room-card"
                                 style="border-radius: 20px; overflow: hidden;"
                                 data-bs-toggle="modal"
                                 data-bs-target="#reservationModal"
                                 data-room="{{ $accommodation->accomodation_name }}"
                                 data-roomid="{{ $accommodation->accomodation_id }}"
                                 data-roomimg="{{ asset('storage/' . $accommodation->accomodation_image) }}"
                                 data-roomprice="{{ number_format($accommodation->accomodation_price, 2) }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $accommodation->accomodation_image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $accommodation->accomodation_name }}" 
                                         style="border-radius: 20px 20px 0 0; height: 250px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold" 
                                         style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                        Price: ₱ {{ number_format($accommodation->accomodation_price, 2) }}
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d; font-size: 1.5rem;">
                                        {{ $accommodation->accomodation_name }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @php
                            $displayedTypes[$accommodation->accomodation_type] = true;
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- Reservation Modal -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="border-radius: 24px; border: 3px solid #0b573d;">
            <div class="modal-header" style="border-top-left-radius: 24px; border-top-right-radius: 24px; background-color: #0b573d;">
                <h5 class="modal-title fw-bold text-white" id="reservationModalLabel" style="font-size: 2rem;">Reservation Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Add Error Message Alert -->
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <!-- Add Success Message Alert -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form id="reservationForm" action="{{ route('homepageReservation') }}" method="POST">
                @csrf
                <!-- Add Validation Errors -->
                @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <div class="modal-body">
                    <div class="row g-4 align-items-center">
                        <!-- Column 1: Room Info -->
                        <div class="col-md-4 text-center">
                            <img id="modalRoomImg" src="" alt="Room Image" class="img-fluid rounded mb-3" style="max-height: 200px; border-radius: 20px; object-fit: cover; border: 2px solid #0b573d;">
                            <h3 class="fw-bold mb-2" id="modalRoomName" style="font-style: italic; color: #0b573d; font-size: 2rem;"></h3>
                            <div class="mb-2">
                                <span class="badge" style="background-color: #0b573d; font-size: 1.2rem; padding: 10px 18px;">
                                  Price: <span id="modalRoomPrice"></span>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="modalRoomQty" class="form-label" style="color: #0b573d;">Quantity</label>
                                <div class="input-group" style="width: 150px; margin: 0 auto;">
                                    <button type="button" class="btn btn-success" onclick="decrementQuantity()" style="background-color: #0b573d; height: 38px;">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" min="1" value="1" class="form-control border-success text-center" id="modalRoomQty" name="quantity" required style="height: 38px;">
                                    <button type="button" class="btn btn-success" onclick="incrementQuantity()" style="background-color: #0b573d; height: 38px;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="modalRoomId" name="accomodation_id">
                        </div>
                        
                        <!-- Column 2: Adults and Children -->
                        <div class="col-md-4">
                            <div class="card-body p-3">
                                <div class="mb-3">
                                  <label for="numAdults" class="form-label" style="color: #0b573d;">Number of Adults</label>
                                  <input type="number" min="1" value="1" class="form-control border-success" id="numAdults" name="number_of_adults" required>
                                </div>
                                <div class="mb-3">
                                  <label for="numChildren" class="form-label" style="color: #0b573d;">Number of Children</label>
                                  <input type="number" min="0" value="0" class="form-control border-success" id="numChildren" name="number_of_children" required>
                                </div>
                                <div class="mb-3">
                                  <label for="totalGuest" class="form-label" style="color: #0b573d;">Total Guest</label>
                                  <input type="number" class="form-control border-success" id="totalGuest" name="total_guest" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- Column 3: Reservation Type and Dates -->
                        <div class="col-md-4">
                            <div class="card-body p-3">
                                <div class="mb-3">
                                  <label class="form-label" style="color: #0b573d;">Reservation Type</label>
                                  <select class="form-select border-success" id="reservationType" name="reservation_type" required>
                                    <option value="one_day">One Day</option>
                                    <option value="overnight">Overnight</option>
                                  </select>
                                </div>
                                <div class="mb-3">
                                  <label for="checkInDate" class="form-label" style="color: #0b573d;">Check-in Date</label>
                                  <input type="date" class="form-control border-success" id="checkInDate" name="reservation_check_in_date" required>
                                </div>
                                <div class="mb-3" id="checkOutDateGroup" style="display: none;">
                                  <label for="checkOutDate" class="form-label" style="color: #0b573d;">Check-out Date</label>
                                  <input type="date" class="form-control border-success" id="checkOutDate" name="reservation_check_out_date" required>
                                </div>
                                <div class="mb-3">
                                  <label for="checkInTime" class="form-label" style="color: #0b573d;">Check-in Time</label>
                                  <input type="time" class="form-control border-success" id="checkInTime" name="reservation_check_in" required>

                                </div>
                                <div class="mb-3">
                                  <label for="checkOutTime" class="form-label" style="color: #0b573d;">Check-out Time</label>
                                  <input type="time" class="form-control border-success" id="checkOutTime" name="reservation_check_out" required>
                                </div>
                            </div>
                        </div>
                        <!-- Activities Section - Updated Design -->
                        <div class="col-12">
                            <div class="card border-success" style="border-radius: 15px;">
                                <div class="card-header bg-success text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px; background-color: #0b573d !important;">
                                    <h5 class="mb-0 fw-bold">Activities <small>( All Included )</small></h5>
                                </div>
                                <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                    <div class="row g-3">
                                        @foreach($activities as $activity)
                                        <div class="col-md-4">
                                            <div class="p-2 border border-success rounded" style="background-color: #eaffcc;">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="activity-image" style="min-width: 80px; width: 80px; height: 80px; overflow: hidden; border-radius: 10px; border: 2px solid #0b573d;">
                                                        <img src="{{ asset('storage/' . $activity->activity_image) }}" 
                                                             alt="{{ $activity->activity_name }}" 
                                                             style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                    <span class="fw-semibold flex-grow-1" style="color: #0b573d; font-style: italic; font-size: 1.1rem;">
                                                        {{ $activity->activity_name }}
                                                    </span>
                                                    <input type="hidden" name="activity_id[]" value="{{ $activity->id }}">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 24px; border-bottom-right-radius: 24px;">
                    <button type="submit" class="btn btn-light px-4 fw-bold" style="border-radius: 25px; color: #0b573d; border: 2px solid #0b573d;">Reserve</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!--activity section -->  
    <section id="activities">
        <div class="container text-center my-5">
            <div class="py-5">
                <div class="position-relative">
                    <!-- Main heading with enhanced styling -->
                    <div class="position-relative px-4 py-3" style="background-color: #eaffcc; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                        ACTIVITIES
                        </h1>
                    </div>
                </div>
            </div>
            
            <!-- Subtitle with enhanced styling -->
            <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
            Explore fun, engaging activities for all ages—whether you're into adventure or relaxation!
            </p>
            
            <!-- Decorative line -->
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                <i class="bi bi-star-fill text-success"></i>
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
            </div>

            <div class="row g-4">
                @foreach($activities->chunk(3) as $chunk)
                    <div class="row g-4 mb-4">
                        @foreach($chunk as $activity)
                            <div class="col-md-4">
                                <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $activity->activity_image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $activity->activity_name }}" 
                                             style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                                    </div>
                                    <div class="card-body p-2">
                                        <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">
                                            {{ $activity->activity_name }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
     <!-- footer section -->                                   
    <footer style="background-color: #0b573d; height: auto; padding: 20px;">
    <div class="container">
        <div class="row">
            <!-- Left Side: Smaller App Icon -->
            <div class="col-md-6 d-flex justify-content-start align-items-center">
                <img src="{{ asset('images/appicon.png') }}" class="img-fluid" alt="App Icon" style="height: 100px;">
            </div>

            <!-- Right Side: Facebook Link -->
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <a href="https://www.facebook.com/lelosmountainresort" target="_blank" class="text-white fs-6 text-center">
                    <i style="color: #0a66c2" class="bi bi-facebook fs-3"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
<script>
function incrementQuantity() {
    var input = document.getElementById('modalRoomQty');
    input.value = parseInt(input.value) + 1;
}

function decrementQuantity() {
    var input = document.getElementById('modalRoomQty');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var reservationModal = document.getElementById('reservationModal');
    var reservationForm = document.getElementById('reservationForm');
    var reservationTypeSelect = document.getElementById('reservationType');

    // Initial set on modal show
    reservationModal.addEventListener('show.bs.modal', function (event) {
        var card = event.relatedTarget;
        
        // Para sa input fields (hidden)
        var accommodationId = card.getAttribute('data-roomid');
        document.getElementById('modalRoomId').name = 'accomodation_id';
        document.getElementById('modalRoomId').value = accommodationId;
        
        // Para sa ibang fields
        document.getElementById('modalRoomImg').src = card.getAttribute('data-roomimg');
        document.getElementById('modalRoomQty').value = 1;
        document.getElementById('modalRoomName').textContent = card.getAttribute('data-room');
        document.getElementById('modalRoomPrice').textContent = '₱ ' + card.getAttribute('data-roomprice');
        
        // Reset all form fields
        document.getElementById('reservationType').value = 'one_day';
        document.getElementById('checkInDate').value = '';
        document.getElementById('checkInTime').value = '';
        document.getElementById('checkOutDate').value = '';
        document.getElementById('checkOutTime').value = '';
        document.getElementById('checkOutDateGroup').style.display = 'none';
        document.getElementById('checkOutTimeGroup').style.display = 'none';
        
        updateFormAction();
    });

    // Logic para sa reservation type at form action
    reservationTypeSelect.addEventListener('change', function() {
        var type = this.value;
        var checkOutDateGroup = document.getElementById('checkOutDateGroup');
        var checkOutTimeGroup = document.getElementById('checkOutTimeGroup');
        var checkIn = document.getElementById('checkInDate');
        var checkOut = document.getElementById('checkOutDate');
        var checkOutTime = document.getElementById('checkOutTime');
        
        if(type === 'overnight') {
            checkOutDateGroup.style.display = 'block';
            checkOutTimeGroup.style.display = 'block';
            checkOut.required = true;
            checkOutTime.required = true;
        } else {
            checkOutDateGroup.style.display = 'none';
            checkOutTimeGroup.style.display = 'none';
            checkOut.value = checkIn.value;
            checkOutTime.value = document.getElementById('checkInTime').value;
            checkOut.required = false;
            checkOutTime.required = false;
        }
        
        updateFormAction();
    });

    // Kapag nagbago ang check-in date at one day lang, auto set check-out date
    document.getElementById('checkInDate').addEventListener('change', function() {
        var type = document.getElementById('reservationType').value;
        if(type === 'one_day') {
            document.getElementById('checkOutDate').value = this.value;
        }
    });

    // Kapag nagbago ang check-in time at one day lang, auto set check-out time
    document.getElementById('checkInTime').addEventListener('change', function() {
        var type = document.getElementById('reservationType').value;
        if(type === 'one_day') {
            document.getElementById('checkOutTime').value = this.value;
        }
    });

    // Auto-calculate total guest
    function calculateTotalGuest() {
        const adults = parseInt(document.getElementById('numAdults').value) || 0;
        const children = parseInt(document.getElementById('numChildren').value) || 0;
        document.getElementById('totalGuest').value = adults + children;
    }

    // Add event listeners for changes
    document.getElementById('numAdults').addEventListener('change', calculateTotalGuest);
    document.getElementById('numChildren').addEventListener('change', calculateTotalGuest);

    // Initial calculation
    calculateTotalGuest();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInDate = document.getElementById('checkInDate');
    const checkOutDate = document.getElementById('checkOutDate');

    checkInDate.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const minDate = selectedDate.toISOString().split('T')[0];
        
        // Set minimum date for check-out date
        checkOutDate.min = minDate;
        
        // If check-out date is before check-in date, reset it
        if (new Date(checkOutDate.value) < selectedDate) {
            checkOutDate.value = minDate;
        }
    });
});
</script>
</body>
</html>
