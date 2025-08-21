<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lelo's Resort</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </body>

</head>
<style>
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Anton', sans-serif;
    }

    body,
    p,
    span,
    a,
    div {
        font-family: 'Montserrat', sans-serif;
    }

    section {
        padding-top: 50px;
        margin-top: -50px;
    }

    .animate-button {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(0, 87, 61, 0.5);
    }

    .animate-button.icon-move>span>i {
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

    .nav-link.custom-hover {
        position: relative;
    }

    .nav-link.custom-hover::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #0b573d;
        transition: width 0.3s ease;
    }

    .nav-link.custom-hover:hover::after {
        width: 100%;
    }

    .nav-link.custom-hover:hover {
        color: #0b573d !important;
    }
</style>

<body>

    <!-- Navbar (Fixed at the Top with z-index) -->
    <nav class="navbar navbar-expand-lg position-absolute w-100" style="z-index: 10; top: 20px;">
        <div class="container">
            <!-- Hamburger button for mobile -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#sideNavbar"
                aria-controls="sideNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars" style="color: #0b573d; font-size: 1.5rem;"></i>
            </button>

            <!-- Desktop Navbar -->
            <div class="collapse navbar-collapse justify-content-center text-center" id="navbarSupportedContent">
                <div class="d-flex align-items-center me-4">
                </div>
                <ul class="navbar-nav gap-4">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3 py-2 px-3 position-relative overflow-hidden"
                            href="#rooms" style="transition: all 0.3s ease;">
                            <i class="fas fa-bed" style="color: #0b573d; font-size: 1.1rem;"></i>
                            <span class="fw-semibold text-uppercase"
                                style="color: #0b573d; letter-spacing: 2px; font-size: 1rem;">
                                Rooms
                            </span>
                            <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3 py-2 px-3 position-relative overflow-hidden"
                            href="#about" style="transition: all 0.3s ease;">
                            <i class="fas fa-info-circle" style="color: #0b573d; font-size: 1.1rem;"></i>
                            <span class="fw-semibold text-uppercase"
                                style="color: #0b573d; letter-spacing: 2px; font-size: 1rem;">
                                About Us
                            </span>
                            <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3 py-2 px-3 position-relative overflow-hidden"
                            href="#reviews" style="transition: all 0.3s ease;">
                            <i class="fas fa-star" style="color: #0b573d; font-size: 1.1rem;"></i>
                            <span class="fw-semibold text-uppercase"
                                style="color: #0b573d; letter-spacing: 2px; font-size: 1rem;">
                                Reviews
                            </span>
                            <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-3 py-2 px-3 position-relative overflow-hidden"
                            href="{{ route('login') }}" style="transition: all 0.3s ease;">
                            <i class="fas fa-sign-in-alt" style="color: #0b573d; font-size: 1.1rem;"></i>
                            <span class="fw-semibold text-uppercase"
                                style="color: #0b573d; letter-spacing: 2px; font-size: 1rem;">
                                Login
                            </span>
                            <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Mobile Sidebar -->
            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="sideNavbar"
                aria-labelledby="sideNavbarLabel" style="width: 300px;">
                <div class="offcanvas-header" style="background-color: #0b573d; padding: 1.5rem;">
                    <div class="d-flex align-items-center w-100 justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" class="me-3"
                                style="width: 60px; height: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                            <h5 class="offcanvas-title text-white mb-0" id="sideNavbarLabel"
                                style="font-size: 1.5rem; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                                LELO'S RESORT
                            </h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></button>
                    </div>
                </div>
                <div class="offcanvas-body" style="background-color: #f8fff4;">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 py-3 px-4 border-bottom position-relative overflow-hidden"
                                href="#rooms" style="transition: all 0.3s ease;">
                                <i class="fas fa-bed" style="color: #0b573d; font-size: 1.2rem;"></i>
                                <span class="fw-semibold text-uppercase"
                                    style="color: #0b573d; letter-spacing: 2px; font-size: 1.1rem;">
                                    Rooms
                                </span>
                                <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                    style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 py-3 px-4 border-bottom position-relative overflow-hidden"
                                href="#about" style="transition: all 0.3s ease;">
                                <i class="fas fa-info-circle" style="color: #0b573d; font-size: 1.2rem;"></i>
                                <span class="fw-semibold text-uppercase"
                                    style="color: #0b573d; letter-spacing: 2px; font-size: 1.1rem;">
                                    About Us
                                </span>
                                <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                    style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 py-3 px-4 border-bottom position-relative overflow-hidden"
                                href="#reviews" style="transition: all 0.3s ease;">
                                <i class="fas fa-star" style="color: #0b573d; font-size: 1.2rem;"></i>
                                <span class="fw-semibold text-uppercase"
                                    style="color: #0b573d; letter-spacing: 2px; font-size: 1.1rem;">
                                    Reviews
                                </span>
                                <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                    style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 py-3 px-4 border-bottom position-relative overflow-hidden"
                                href="{{ route('login') }}" style="transition: all 0.3s ease;">
                                <i class="fas fa-sign-in-alt" style="color: #0b573d; font-size: 1.2rem;"></i>
                                <span class="fw-semibold text-uppercase"
                                    style="color: #0b573d; letter-spacing: 2px; font-size: 1.1rem;">
                                    Login
                                </span>
                                <div class="hover-bg position-absolute top-0 start-0 w-100 h-100"
                                    style="background-color: #e0f0e9; transform: translateX(-100%); transition: transform 0.3s ease;">
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- First Page -->
    <section>
        <div class="smoke"></div>
        <!-- Hero Section with Background -->
        <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative"
            style="background: url('{{ asset('images/background.png') }}') no-repeat center; background-size: cover; overflow: hidden">
            <!-- Hero Content -->
            <div id="hero" class="container-fluid">
                <div class="row justify-content-center">
                    <!-- Responsive Text Content -->
                    <div class="col-lg-9 col-md-8 col-sm-12 text-center mt-5">
                        <div class="content-wrapper p-4 rounded-3"
                            style="background-color: rgba(0, 0, 0, 0.6); font-family: 'Montserrat', sans-serif;">
                            <style>
                                @media (max-width: 991px) {
                                    .content-wrapper {
                                        background-color: transparent !important;
                                    }
                                }
                            </style>
                            <div class="d-flex justify-content-center align-items-center mt-1">
                                <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" class="mx-3"
                                    style="width: 120px; height: auto; @media (max-width: 768px) { width: 100px; }">
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <h1 class="text-white"
                                    style="font-family: 'Montserrat', sans-serif; font-size: min(2vw, 24px); letter-spacing: 5px;">
                                    WELCOME TO</h1>
                            </div>
                            <p class="fw-bold"
                                style="font-family: 'Montserrat', sans-serif; color:#e9ffcc; font-size: min(7vw, 84px); font-weight: 900; line-height: .8;">
                                LELO'S</p>
                            <p class="fw-bold"
                                style="font-family: 'Montserrat', sans-serif; color:#e9ffcc; font-size: min(10vw, 120px); font-weight: 900; line-height: .8;">
                                RESORT</p>
                            <h1 class="text-white"
                                style="font-family: 'Montserrat', sans-serif; font-size: min(2vw, 24px); letter-spacing: 5px">
                                DIGITAL BOOKING COMPANION</h1>

                            <!-- Responsive Button -->
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('login') }}"
                                    class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-bold text-white"
                                    style="font-family: 'Montserrat', sans-serif; background-color: #0b573d; font-style: italic; transition: all 0.3s ease-in-out; font-size: min(16px, 4vw);"
                                    onmouseover="this.classList.add('animate-button'); this.classList.add('icon-move');"
                                    onmouseout="this.classList.remove('animate-button'); this.classList.remove('icon-move');">
                                    BOOK YOUR STAY
                                    <span
                                        class="d-flex align-items-center justify-content-center bg-white rounded-circle"
                                        style="width: 1.8rem; height: 1.8rem; transition: all 0.3s ease-in-out;">
                                        <i class="fas fa-chevron-right"
                                            style="color: #0b573d; transform: translateX(0);"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="border-bottom border-white mx-auto mt-4" style="width: 15%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Second Page -->
    <section class="d-flex flex-column justify-content-center align-items-center py-5" style="background-color: white;">
        <div class="container">
            <div class="row align-items-center text-center">

                <!-- Lower Section with Text & Carousel -->
                <div class="container mt-5">
                    <div class="row align-items-center text-center">
                        <!-- Left Carousel Section -->
                        <div class="col-lg-6">
                            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" data-bs-interval="5000">
                                        <img src="{{ asset('images/harap.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 1">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/labas.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 2">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/loob.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/una.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image9.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/dalawa.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/tatlo.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <!-- Right Text Section -->
                        <div class="col-lg-6 mb-4">
                            <hr class="border-success mx-auto" style="width: 80%;">
                            <p class="fst-italic text-success" style="font-size: 1.2rem;">
                                Relax & Unwind
                            </p>
                            <h1 class="fw-bold text-success text-uppercase"
                                style="font-size: calc(1.8rem + 1vw); line-height: 1.2;">
                                at Lelo's Resort, where comfort and peace come together.
                            </h1>
                            <hr class="border-dark mx-auto" style="width: 80%;">
                        </div>
                    </div>
                </div>

                <!-- Lower Section with Text & Carousel -->
                <div class="container mt-5">
                    <div class="row align-items-center text-center">
                        <!-- Left Text Section -->
                        <div class="col-lg-6 mb-4">
                            <hr class="border-success mx-auto" style="width: 80%;">
                            <p class="fst-italic text-success" style="font-size: 1.2rem;">
                                Enjoy breathtaking
                            </p>
                            <h1 class="fw-bold text-success text-uppercase"
                                style="font-size: calc(1.8rem + 1vw); line-height: 1.2;">
                                Beautiful Views, <br>
                                Great Amenities, <br>
                                & Friendly Service
                            </h1>
                            <div class="mt-3 p-3 rounded-pill"
                                style="background-color: #E6F4E6; display: inline-block;">
                                <p class="text-success m-0" style="font-size: 1.1rem;">
                                    <em>Book your stay with quick and simple reservation system!</em>
                                </p>
                            </div>
                            <hr class="border-dark mx-auto" style="width: 80%;">
                        </div>
                        <!-- Right Carousel Section -->
                        <div class="col-lg-6">
                            <div id="carouselExampleInterval2" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" data-bs-interval="5000">
                                        <img src="{{ asset('images/image1.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 1">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image5.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 2">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image8.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image10.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 4">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image3.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 5">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image9.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 6">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image2.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 7">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleInterval2" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleInterval2" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
    </section>

    <!-- content Amenities -->
    <section id="rooms">
        <div class="container text-center my-5">
            <div class="py-3">
                <div class="position-relative">
                    <!-- Main heading with enhanced styling -->
                    <div class="position-relative px-4 py-3 w-100"
                        style="background-color: #E6F4E6; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5"
                            style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            ROOMS
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Subtitle with enhanced styling -->
            <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
                Stay close, enjoy outdoor fun that starts near your cottage room.
            </p>

            <!-- Decorative line -->
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                <i class="bi bi-star-fill text-success"></i>
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
            </div>

            <div class="row g-4">
                @php
                    $displayedTypes = ['room' => false, 'cottage' => false, 'cabin' => false];
                @endphp

                @foreach($accommodations as $accommodation)
                    @if(!$displayedTypes[$accommodation->accomodation_type])
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 room-card" style="border-radius: 20px; overflow: hidden;"
                                data-bs-toggle="modal" data-bs-target="#roomDetailsModal"
                                data-room="{{ $accommodation->accomodation_name }}"
                                data-roomid="{{ $accommodation->accomodation_id }}"
                                data-roomimg="{{ asset('storage/' . $accommodation->accomodation_image) }}"
                                data-roomprice="{{ number_format($accommodation->accomodation_price, 2) }}"
                                data-description="{{ $accommodation->accomodation_description }}"
                                data-amenities="{{ $accommodation->amenities }}"
                                data-capacity="{{ $accommodation->accomodation_capacity }}">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $accommodation->accomodation_image) }}" class="card-img-top"
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
                        <div class="modal fade" id="roomDetailsModal" tabindex="-1" aria-labelledby="roomDetailsModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                                    <div class="modal-header"
                                        style="background-color: #0b573d; color: white; border-bottom: 3px solid #E6F4E6;">
                                        <h5 class="modal-title fw-bold" id="roomDetailsModalLabel" style="font-size: 1.5rem;">
                                            <i class="bi bi-house-heart-fill me-2"></i>Room Details
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: #f8f9fa;">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="position-relative">
                                                    <img id="modalRoomImage" src="" class="img-fluid rounded shadow"
                                                        alt="Room Image"
                                                        style="max-height: 300px; width: 100%; object-fit: cover;">
                                                    <div
                                                        class="position-absolute bottom-0 start-0 m-3 px-3 py-2 bg-success bg-opacity-75 rounded-pill">
                                                        <h4 class="text-white mb-0">₱<span id="modalRoomPrice"
                                                                class="fw-bold"></span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3 id="modalRoomName" class="fw-bold mb-4"
                                                    style="color: #0b573d; font-size: 2rem;"></h3>

                                                <div class="info-section mb-4 text-start">
                                                    <h5 class="d-flex align-items-start" style="color: #0b573d;">
                                                        <i class="bi bi-card-text me-2"></i>Description
                                                    </h5>
                                                    <p id="modalRoomDescription" class="ms-4 text-muted"></p>
                                                </div>

                                                <div class="info-section mb-4 text-start">
                                                    <h5 class="d-flex align-items-start" style="color: #0b573d;">
                                                        <i class="bi bi-stars me-2"></i>Amenities
                                                    </h5>
                                                    <p id="modalRoomAmenities" class="ms-4 text-muted"></p>
                                                </div>

                                                <div class="info-section text-start">
                                                    <h5 class="d-flex align-items-start" style="color: #0b573d;">
                                                        <i class="bi bi-people-fill me-2"></i>Capacity
                                                    </h5>
                                                    <p id="modalRoomCapacity" class="ms-4 text-muted"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $displayedTypes[$accommodation->accomodation_type] = true;
                        @endphp
                    @endif
                @endforeach


                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const roomCards = document.querySelectorAll('.room-card');

                        roomCards.forEach(card => {
                            card.addEventListener('click', function () {
                                // Get data from clicked card
                                const roomName = this.dataset.room;
                                const roomImg = this.dataset.roomimg;
                                const roomPrice = this.dataset.roomprice;
                                const description = this.dataset.description;
                                const amenities = this.dataset.amenities;
                                const capacity = this.dataset.capacity;

                                // Update modal content
                                document.getElementById('modalRoomName').textContent = roomName;
                                document.getElementById('modalRoomImage').src = roomImg;
                                document.getElementById('modalRoomPrice').textContent = roomPrice;
                                document.getElementById('modalRoomDescription').textContent = description;
                                document.getElementById('modalRoomAmenities').textContent = amenities;
                                document.getElementById('modalRoomCapacity').textContent = `Good for ${capacity} persons`;
                            });
                        });
                    });
                </script>
    </section>
    <section>
        <div class="container text-center my-5">
            <div class="py-5">
                <!-- ACTIVITIES SECTION (Nested inside Amenities) -->
                <div class="py-5 mt-5">
                    <div class="position-relative px-4 py-3"
                        style="background-color: #E6F4E6; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5"
                            style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            ACTIVITIES
                        </h1>
                    </div>
                </div>

                <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
                    Explore fun, engaging activities for all ages—whether you're into adventure or relaxation!
                </p>

                <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                    <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                    <i class="bi bi-star-fill text-success"></i>
                    <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach($activities->chunk(3) as $chunk)
                        <div class="row g-4 mb-4">
                            @foreach($chunk as $activity)
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $activity->activity_image) }}" class="card-img-top"
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
    <!-- Third Page -->
    <section id="about">

        <div class="py-4 mt-4 d-flex justify-content-center">
            <div class="position-relative px-5 py-3 text-center"
                style="width: 85%; max-width: 85%; margin: 0 auto; background-color: #E6F4E6; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <h1 class="fw-bolder text-success display-5 mb-0"
                    style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                    ABOUT US
                </h1>
            </div>
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
                            <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" class="img-fluid mb-4"
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



    <!-- Fourth Page -->
    <section id="reviews" class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <!-- Title for All Screens -->
                <div class="py-4 mt-4 d-flex justify-content-center">
                    <div class="position-relative px-5 py-3 text-center"
                        style="width: 100%; max-width: 100%; margin: 0 auto; background-color: #E6F4E6; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5 mb-0"
                            style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            REVIEWS
                        </h1>
                    </div>
                </div>

                <!-- HR Lines and Content -->
                <div class="col-12">
                    <hr class="mb-3" style="border-width: 5px; border-color: #0b573d; opacity: 1;">

                    <!-- Responsive Card Grid -->
                    <div class="row g-3 justify-content-center">
                        @foreach ($feedbacks as $feedback)
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card h-100 shadow" style="background-color: #0b573d; border-radius: 15px;">
                                    @if (!empty($feedback->image) && file_exists(storage_path('app/public/' . $feedback->image)))
                                        <img src="{{ asset('storage/' . $feedback->image) }}" class="card-img-top"
                                            alt="User Review"
                                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                                    @else
                                        <img src="{{ asset('images/default-profile.jpg') }}" class="card-img-top"
                                            alt="Default Profile"
                                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: #f5f5dc;">
                                            {{ $feedback->name ?? 'Anonymous' }}
                                        </h5>
                                        <div class="mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $feedback->rating ? '-fill' : '' }}"
                                                    style="color: #f5f5dc;"></i>
                                            @endfor
                                        </div>
                                        <p class="card-text" style="color: #f5f5dc;">
                                            {{ $feedback->comment }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr class="mt-3 mb-5" style="border-width: 5px; border-color: #0b573d; opacity: 1;">
                </div>
            </div>
        </div>
    </section>

    <!-- footer section -->
    <!-- footer section -->
    <footer style="background-color: #0b573d; color: white;font-size: 10px;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left: Logo -->
                <div class="col-md-4 mb-2 text-md-start text-center">
                    <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" class="img-fluid"
                        style="max-width: 110px;">
                </div>
                <!-- Center: Contact Info -->
                <div class="col-md-4 mb-2 text-center">
                    <div class="d-flex flex-column gap-2 justify-content-center h-100">
                        <div>
                            <i class="bi bi-telephone-fill me-2"></i>
                            <span style="font-size: 14px; letter-spacing: 1px;">+123 456 7890</span>
                        </div>
                        <div>
                            <i class="bi bi-envelope-fill me-2"></i>
                            <span style="font-size: 14px; letter-spacing: 1px;">lelosresort@gmail.com</span>
                        </div>
                        <div>
                            <a href="https://facebook.com/lelosmountainresort"
                                style="color: white; font-size: 14px; letter-spacing: 1px; text-decoration: none;">
                                <i class="bi bi-facebook me-2"></i>
                                facebook.com/lelosmountainresort
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Terms and Privacy -->
                <!-- Right: Terms of Service and Privacy Policy -->
                <div class="col-md-4 mb-3">
                    <div class="col text-center">
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex flex-wrap justify-content-center">
                                <a href="#" class="text-white text-decoration-none" style="font-size: 14px;"
                                    data-bs-toggle="modal" data-bs-target="#termsModal">TERMS AND CONDITIONS</a>
                                <span class="text-white mx-2" style="font-size: 14px;">|</span>
                                <a href="#" class="text-white text-decoration-none" style="font-size: 14px;"
                                    data-bs-toggle="modal" data-bs-target="#privacyModal">PRIVACY POLICY</a>
                            </div>
                            <div class="mt-3">
                                <span class="text-white" style="font-size: 14px;">© 2025 Lelo's Resort. All rights
                                    reserved.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions Modal -->
                    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="termsModalLabel"
                                        style="font-family: 'Anton', sans-serif;">TERMS AND CONDITIONS</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex flex-column px-4 py-3"
                                    style="max-height: 70vh; overflow-y: auto;">
                                    <div class="text-start" style="font-family: 'Montserrat', sans-serif;">
                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Reservation Agreement</p>
                                            <p>By confirming a reservation, guests acknowledge and agree to all terms
                                                and conditions set by Lelo's Resort management.</p>
                                        </div>

                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Payment Policy</p>
                                            <ul class="list-unstyled ps-3">
                                                <li class="text-black">• Full payment is required in advance to secure
                                                    the reservation.</li>
                                                <li class="text-black">• All payments are strictly non-refundable,
                                                    regardless of:</li>
                                                <ul class="ps-4">
                                                    <li class="text-black">- Cancellations</li>
                                                    <li class="text-black">- Date changes</li>
                                                    <li class="text-black">- Late arrivals</li>
                                                    <li class="text-black">- Early departures</li>
                                                    <li class="text-black">- No-shows</li>
                                                    <li class="text-black">- Weather disturbances</li>
                                                </ul>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Security Deposit</p>
                                            <ul class="list-unstyled ps-3">
                                                <li class="text-black">• A security deposit of 50% of the total booking
                                                    amount is required at check-in</li>
                                                <li class="text-black">• The deposit covers potential damages, losses,
                                                    and rule violations</li>
                                                <li class="text-black">• Fully refundable upon inspection at check-out
                                                    if no issues found</li>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Check-in/Check-out Policy</p>
                                            <ul class="list-unstyled ps-3">
                                                <li class="text-black">• Check-in: 2:00 PM</li>
                                                <li class="text-black">• Check-out: 12:00 PM</li>
                                                <li class="text-black">• Early check-in/late check-out subject to
                                                    availability and fees</li>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Resort Rules</p>
                                            <ul class="list-unstyled ps-3">
                                                <li class="text-black">• Quiet hours: 10:00 PM - 6:00 AM</li>
                                                <li class="text-black">• No smoking in rooms</li>
                                                <li class="text-black">• No pets allowed</li>
                                                <li class="text-black">• Guests liable for damages</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privacy Policy Modal -->
                    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="privacyModalLabel"
                                        style="font-family: 'Anton', sans-serif;">DATA PRIVACY NOTICE</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex flex-column px-4 py-3"
                                    style="max-height: 70vh; overflow-y: auto;">
                                    <div class="text-start" style="font-family: 'Montserrat', sans-serif;">
                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Data Privacy Act Compliance</p>
                                            <p>In accordance with Republic Act 10173 (Data Privacy Act of 2012), Lelo's
                                                Resort is committed to protecting your personal information. By using
                                                our services:</p>
                                            <ul class="list-unstyled ps-3">
                                                <li class="text-black">• You consent to the collection and processing of
                                                    your personal data</li>
                                                <li class="text-black">• Your information will be:</li>
                                                <ul class="ps-4">
                                                    <li class="text-black">- Securely stored and protected</li>
                                                    <li class="text-black">- Used only for legitimate business purposes
                                                    </li>
                                                    <li class="text-black">- Retained only for the duration required by
                                                        law</li>
                                                    <li class="text-black">- Never shared with third parties without
                                                        consent</li>
                                                </ul>
                                            </ul>
                                        </div>

                                        <div class="mb-4">
                                            <p class="fw-bold mb-2 text-success">Your Rights</p>
                                            <ul class="list-unstyled ps-3">
                                                <li class="text-black">• Access your personal data</li>
                                                <li class="text-black">• Request corrections or deletions</li>
                                                <li class="text-black">• Object to processing</li>
                                                <li class="text-black">• File a complaint</li>
                                            </ul>
                                        </div>

                                        <div class="text-center mt-4">
                                            <p class="text-black">For privacy concerns, contact us at:</p>
                                            <p><a href="mailto:lelosresort@gmail.com"
                                                    class="text-decoration-none fw-bold text-success">lelosresort@gmail.com</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const offcanvasElement = document.getElementById('sideNavbar');
        const closeButton = offcanvasElement.querySelector('.btn-close');
        let isProgrammaticClose = false;
        let scrollPosition = 0;

        // Disable backdrop click
        offcanvasElement.setAttribute('data-bs-backdrop', 'static');

        offcanvasElement.addEventListener('show.bs.offcanvas', function () {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            offcanvasElement.dataset.previousScroll = scrollPosition;
            document.body.style.top = `-${scrollPosition}px`;
        });

        function customClose(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            isProgrammaticClose = true;
            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
            if (bsOffcanvas) {
                bsOffcanvas.hide();
            }
        }

        // X button
        closeButton.addEventListener('click', function (e) {
            // Save current scroll position before closing
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            offcanvasElement.dataset.previousScroll = currentScroll;
            customClose(e);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && offcanvasElement.classList.contains('show')) {
                customClose(e);
            }
        });

        offcanvasElement.addEventListener('hidden.bs.offcanvas', function () {
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.top = '';
            // Restore to the saved scroll position
            window.scrollTo(0, parseInt(offcanvasElement.dataset.previousScroll || '0'));
            isProgrammaticClose = false;
        });

        // Override the hide method to prevent closing on outside click
        const originalHide = bootstrap.Offcanvas.prototype.hide;
        bootstrap.Offcanvas.prototype.hide = function () {
            if (!isProgrammaticClose) {
                return this; // Prevent closing
            }
            originalHide.call(this);
            return this;
        };
    });
</script>