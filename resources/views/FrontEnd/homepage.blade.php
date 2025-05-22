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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

    .navbar-nav .nav-link {
        color: #0b573d;
        font-family: 'Josefin Sans', sans-serif;
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: white;
    }

    /* Hover for small screens */
    @media (max-width: 991px) {
        .navbar-nav {
            flex-direction: column;
            align-items: stretch;
            background-color: rgba(11, 87, 61, 0.95);
            padding: 0;
            border-radius: 0.8rem;
            width: 200px;
            margin-left: auto;
            backdrop-filter: blur(8px);
            overflow: hidden;
        }

        .navbar-nav .nav-item {
            width: 100%;
        }

        .navbar-nav .nav-link {
            color: white !important;
            padding: 1rem;
            width: 100%;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            margin: 0;
            border-radius: 0;
            border-bottom: 2px solid #e6f4e6; /* separator line */
        }
        .navbar-nav .nav-item:last-child .nav-link {
            border-bottom: none; /* walang separator sa huli */
        }
    }
</style>
<body>
    <nav class="navbar navbar-expand-lg position-absolute top-0 w-100 mt-4" style="z-index: 10;">
        <div class="container">
            <a href="{{ route('profile') }}" class="text-decoration-none me-auto">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#0b573d'" href="#rooms">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#0b573d'" href="#activities">Activities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#0b573d'" href="#">Reservations</a>
                    </li>
                </ul>
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


    <section id="about">

        <div class="container">
            <h1 class="fw-bold text-uppercase text-start mt-4"
                style="font-size: calc(2rem + 1vw); color: #0b573d; font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                ABOUT</h1>
        </div>


        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4 h-100" style="background: #0b573d; border-radius: 10px;">
                        <h5 class="text-center mb-4"
                            style="font-size: 2.5rem; color: white; font-family: 'Montserrat', sans-serif; font-weight: 600;">
                            Lelo's Resort Location
                        </h5>
                        <div class="map-container"
                            style="position: relative; overflow: hidden; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d961.0491022967285!2d121.15607442205169!3d15.527598132646467!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339733007d27d00d%3A0xb261c522c057f04f!2sLelo&#39;s%20Peak!5e0!3m2!1sen!2sus!4v1746511741643!5m2!1sen!2sus"
                                width="100%" height="350" style="border: none;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class=" text-start">
                            <h5
                                style="font-size: 2rem; color: white; font-family: 'Montserrat', sans-serif; font-weight: 600;">
                                Our Locations
                            </h5>
                            <p
                                style="font-size: 1.2rem; color: white; font-family: 'Montserrat', sans-serif; margin-bottom: 0.8rem;">
                                Resort: Laur, Nueva Ecija, Philippines
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Second section content -->
                    <div class="p-4 h-100">
                        <div class="d-flex flex-column h-100">
                            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" class="img-fluid mb-4"
                                style="height: 150px; width: auto; margin: -20px auto; display: block;">

                            <div class="text-start">
                                <h3 class="mb-4"
                                    style="color: #0b573d; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 2.5rem;">
                                    About Lelo's Resort</h3>

                                <div class="mb-4">
                                    <h5
                                        style="color: #0b573d; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 1.8rem;">
                                        Our Story</h5>
                                    <p style="font-family: 'Montserrat', sans-serif; font-size: 1.2rem; color: #333;">
                                        Established in 2020, Lelo's Resort has been providing a serene mountain getaway
                                        experience for families and friends. Nestled in the heart of Nueva Ecija, our
                                        resorts offer stunning views, comfortable accommodations, and a perfect blend of
                                        nature and modern amenities.</p>
                                </div>
                            </div>
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
                                 data-roomprice="{{ number_format($accommodation->accomodation_price, 2) }}"
                                 data-roomcapacity="{{ $accommodation->accomodation_capacity }}">
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
                            <div class="mb-3">
                                <span class="badge" style="background-color: #0b573d; font-size: 1.2rem; padding: 10px 18px;">
                                    Amount to pay: ₱<span id="totalAmount"></span>
                                </span>
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
                                  <input type="date" class="form-control border-success" id="checkOutDate" name="reservation_check_out_date">
                                </div>
                                <div class="mb-3">
                                  <label for="checkInTime" class="form-label" style="color: #0b573d;">Check-in Time</label>
                                  <select class="form-control border-success" id="checkInTime" name="reservation_check_in" required>
                                      @php
                                          $uniqueStartTimes = $transactions->unique('start_time');
                                      @endphp
                                      @foreach($uniqueStartTimes as $transaction)
                                          <option value="{{ $transaction->start_time }}">{{ date('h:i A', strtotime($transaction->start_time)) }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="checkOutTime" class="form-label" style="color: #0b573d;">Check-out Time</label>
                                  <select class="form-control border-success" id="checkOutTime" name="reservation_check_out" required>
                                      @php
                                          $uniqueEndTimes = $transactions->unique('end_time');
                                      @endphp
                                      @foreach($uniqueEndTimes as $transaction)
                                          <option value="{{ $transaction->end_time }}">{{ date('h:i A', strtotime($transaction->end_time)) }}</option>
                                      @endforeach
                                  </select>
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
                    <div class="card-body p-2">
                        <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">Cottage 6</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="reserveButton" style="background-color: #0b573d;">Reserve</button>
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
            <div class="row align-items-center">
                <!-- Left: App Icon -->
                <div class="col-md-2 d-flex justify-content-start align-items-center">
                    <img src="{{ asset('images/appicon.png') }}" class="img-fluid" alt="App Icon" style="height: 90px;">
                </div>

                <!-- Spacer or optional center -->
                <div class="col-md-7"></div>

                <!-- Right: Facebook + Contact -->
                <div class="col-md-3 d-flex flex-column align-items-end text-white">
                    <a href="https://www.facebook.com/lelosmountainresort" target="_blank"
                        class="text-white d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-facebook fs-4" style="color: #0a66c2;"></i>
                        <span class="text-white">Lelo's Mountain Resort</span>
                    </a>
                    <span>Contact: +63 912 345 6789</span>
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
let roomCapacity = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Reservation Modal Event Handler
    $('#reservationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var roomName = button.data('room');
        var roomId = button.data('roomid');
        var roomImg = button.data('roomimg');
        var roomPrice = button.data('roomprice');
        roomCapacity = button.data('roomcapacity');
        
        // Update modal content
        var modal = $(this);
        modal.find('#modalRoomName').text(roomName);
        modal.find('#modalRoomId').val(roomId);
        modal.find('#modalRoomImg').attr('src', roomImg);
        modal.find('#modalRoomPrice').text('₱ ' + roomPrice);
        
        // Reset form values
        modal.find('#modalRoomQty').val(1);
        modal.find('#numAdults').val(1);
        modal.find('#numChildren').val(0);
        updateTotalGuests();
    });

    // Function para sa pag-update ng total guests
    function updateTotalGuests() {
        var adults = parseInt($('#numAdults').val()) || 0;
        var children = parseInt($('#numChildren').val()) || 0;
        var quantity = parseInt($('#modalRoomQty').val()) || 1;
        var totalCapacity = roomCapacity * quantity;
        var totalGuests = adults + children;
        
        $('#totalGuest').val(totalGuests);
        
        var errorDiv = $('#capacityError');
        if (!errorDiv.length) {
            $('#totalGuest').after('<div id="capacityError" class="text-danger mt-2"></div>');
            errorDiv = $('#capacityError');
        }
        
        if (totalGuests > totalCapacity) {
            errorDiv.text(`Exceeded maximum capacity of ${totalCapacity} guests!`);
            $('#reserveButton').prop('disabled', true);
        } else {
            errorDiv.text('');
            $('#reserveButton').prop('disabled', false);
        }
    }

    // Event listeners para sa pag-update ng total guests
    $('#numAdults, #numChildren, #modalRoomQty').on('change', updateTotalGuests);
});

// Functions para sa quantity buttons
function incrementQuantity() {
    var input = document.getElementById('modalRoomQty');
    input.value = parseInt(input.value) + 1;
    input.dispatchEvent(new Event('change'));
}

function decrementQuantity() {
    var input = document.getElementById('modalRoomQty');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.dispatchEvent(new Event('change'));
    }
}
</script>
<script>
    function updateTotalGuests() {
        var adults = parseInt($('#numAdults').val()) || 0;
        var children = parseInt($('#numChildren').val()) || 0;
        var quantity = parseInt($('#modalRoomQty').val()) || 1;
        var totalCapacity = roomCapacity * quantity;
        var totalGuests = adults + children;
        
        $('#totalGuest').val(totalGuests);
        
        var errorDiv = $('#capacityError');
        if (!errorDiv.length) {
            $('#totalGuest').after('<div id="capacityError" class="text-danger mt-2"></div>');
            errorDiv = $('#capacityError');
        }
        
        if (totalGuests > totalCapacity) {
            errorDiv.text(`Exceeded maximum capacity of ${totalCapacity} guests for this accommodation!`);
            $('#reserveButton').prop('disabled', true);
        } else {
            errorDiv.text('');
            $('#reserveButton').prop('disabled', false);
        }
    }

    // Add event listeners
    $('#numAdults, #numChildren, #modalRoomQty').on('change', updateTotalGuests);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reservationType = document.getElementById('reservationType');
        const checkInDate = document.getElementById('checkInDate');
        const checkOutDate = document.getElementById('checkOutDate');
        const checkOutDateGroup = document.getElementById('checkOutDateGroup');

        // Handle reservation type change
        reservationType.addEventListener('change', function() {
            if (this.value === 'one_day') {
                checkOutDateGroup.style.display = 'none';
                checkOutDate.value = checkInDate.value;
            } else {
                checkOutDateGroup.style.display = 'block';
            }
        });

        // Handle check-in date change
        checkInDate.addEventListener('change', function() {
            if (reservationType.value === 'one_day') {
                checkOutDate.value = this.value;
            }
        });
    });
</script>
<script>
    function calculateTotalAmount() {
        const quantity = parseInt(document.getElementById('modalRoomQty').value) || 1;
        const priceText = document.getElementById('modalRoomPrice').textContent;
        const price = parseFloat(priceText.replace(/[^0-9.]/g, ''));
        const checkInDate = new Date(document.getElementById('checkInDate').value);
        const checkOutDate = new Date(document.getElementById('checkOutDate').value);
        const reservationType = document.getElementById('reservationType').value;

        if (!isNaN(price) && !isNaN(quantity)) {
            let totalAmount = quantity * price;
            
            if (reservationType === 'overnight') {
                const timeDiff = checkOutDate - checkInDate;
                const stayDuration = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                totalAmount *= stayDuration;
            }

            document.getElementById('totalAmount').textContent = totalAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        } else {
            document.getElementById('totalAmount').textContent = '0.00';
        }
    }

    function incrementQuantity() {
        const quantityInput = document.getElementById('modalRoomQty');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        calculateTotalAmount();
    }

    function decrementQuantity() {
        const quantityInput = document.getElementById('modalRoomQty');
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            calculateTotalAmount();
        }
    }

        document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('modalRoomQty');
        const checkInDateInput = document.getElementById('checkInDate');
        const checkOutDateInput = document.getElementById('checkOutDate');
        
        quantityInput.addEventListener('change', calculateTotalAmount);
        quantityInput.addEventListener('input', calculateTotalAmount);
        checkInDateInput.addEventListener('change', calculateTotalAmount);
        checkOutDateInput.addEventListener('change', calculateTotalAmount);
        
        // Initialize total amount on modal open
        $('#reservationModal').on('show.bs.modal', function() {
            calculateTotalAmount();
        });
    });
</script>
</body>
</html>

