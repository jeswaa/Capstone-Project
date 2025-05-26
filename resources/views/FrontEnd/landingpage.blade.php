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
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
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
            margin-top: 0.5rem;
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
            border-bottom: 2px solid #e6f4e6;
        }

        .navbar-nav .nav-item:last-child .nav-link {
            border-bottom: none;
        }
    }
</style>

<body>
    <!-- Navbar (Fixed at the Top with z-index) -->
    <nav class="navbar navbar-expand-lg position-absolute top-0 w-100" style="z-index: 10;">
        <div class="container">
            <!-- Logo - visible on all screens, aligned left -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort" id="logo" height="150" width="130">
            </a>

            <!-- Navbar toggler - aligned right -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content - aligned right -->
            <div class="collapse navbar-collapse justify-content-end text-end mb-5" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-decoration-none" href="#reviews">Review</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}"
                            class="nav-link fw-semibold text-uppercase text-decoration-none">Login</a>
                    </li>
                </ul>
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
            <div id="hero" class="container">
                <div class="row align-items-center justify-content-center">
                    <!-- Responsive Text Content -->
                    <div class="col-lg-6 col-md-10 col-sm-12 text-lg-end text-center ms-auto">
                        <div class="d-flex justify-content-center align-items-center">
                            <h1 class="fw-bold text-white" style="font-size: 3vw; text-align: center;">WELCOME TO LELO'S
                            </h1>
                        </div>
                        <p class="fw-bold"
                            style="color:#e9ffcc; font-size: 10vw; font-weight: 900; line-height: .8; text-align: center;">
                            RESORT</p>
                        <h1 class="fw-bold text-white" style="font-size: 2vw; text-align: center;">DIGITAL BOOKING
                            COMPANION</h1>

                        <!-- Responsive Button -->
                        <div class="d-flex justify-content-lg-center justify-content-center mt-4">
                            <a href="{{ route('login') }}"
                                class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-bold text-white"
                                style="border-radius: 50px; background-color: #0b573d; font-style: italic; transition: all 0.3s ease-in-out;"
                                onmouseover="this.classList.add('animate-button'); this.classList.add('icon-move');"
                                onmouseout="this.classList.remove('animate-button'); this.classList.remove('icon-move');">
                                BOOK YOUR STAY
                                <span class="d-flex align-items-center justify-content-center bg-white rounded-circle"
                                    style="width: 1.8rem; height: 1.8rem; transition: all 0.3s ease-in-out;">
                                    <i class="fas fa-chevron-right"
                                        style="color: #0b573d; transform: translateX(0);"></i>
                                </span>
                            </a>
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
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image3.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image9.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image2.JPG') }}" class="d-block w-100 rounded"
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
                                Enjoy breathtakingly
                            </p>
                            <h1 class="fw-bold text-success text-uppercase"
                                style="font-size: calc(1.8rem + 1vw); line-height: 1.2;">
                                Beautiful Views <br>
                                Great Amenities <br>
                                & Friendly Service
                            </h1>
                            <div class="mt-3 p-3 rounded-pill"
                                style="background-color: #E6F4E6; display: inline-block;">
                                <p class="text-success m-0" style="font-size: 1.1rem;">
                                    <em>Booking your stay is quick and easy with our simple reservation system!</em>
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
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image3.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image9.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="5000">
                                        <img src="{{ asset('images/image2.JPG') }}" class="d-block w-100 rounded"
                                            alt="Hotel Image 3">
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
            </div>
        </div>
    </section>

    <!-- content Amenities -->
    <section>
        <div class="container text-center my-5">
            <div class="py-5">
                <div class="position-relative">
                    <!-- Main heading with enhanced styling -->
                    <div class="position-relative px-4 py-3 w-100"
                        style="background-color: #E6F4E6; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <h1 class="fw-bolder text-success display-5"
                            style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1); font-weight: 900;">
                            ANO LALAGAY KO DITO ETO YUNG PARANG MARKETING EH
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Subtitle with enhanced styling -->
            <p class="fst-italic text-success mb-4" style="font-size: 1.2rem; letter-spacing: 0.5px;">
                Stay close, enjoy hard—outdoor fun starts near your cottage room.
            </p>

            <!-- Decorative line -->
            <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
                <i class="bi bi-star-fill text-success"></i>
                <div style="height: 2px; width: 50px; background-color: #0b573d;"></div>
            </div>

            <div class="row g-4">
                <!-- Room 1 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="position-relative">
                            <img src="{{ asset('images/room1.jpg') }}" class="card-img-top" alt="Room 1"
                                style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                            <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                Price: ₱ 3,000
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">Room </h5>
                        </div>
                    </div>
                </div>
                <!-- Room 2 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="position-relative">
                            <img src="{{ asset('images/room1.jpg') }}" class="card-img-top" alt="Room 2"
                                style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                            <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                Price: ₱ 3,000
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">cottage</h5>
                        </div>
                    </div>
                </div>
                <!-- Room 3 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="position-relative">
                            <img src="{{ asset('images/room3.jpg') }}" class="card-img-top" alt="Room 3"
                                style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                            <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                Price: ₱ 3,000
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">cabin</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Third Page -->
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
                    <!-- Activity 1 -->
                    <div class="col-md-5">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative">
                                <img src="{{ asset('images/room1.jpg') }}" class="card-img-top" alt="Activity 1"
                                    style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                                <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                    style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                    Nature Walk
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">Activity 1
                                </h5>
                            </div>
                        </div>
                    </div>

                    <!-- Activity 2 -->
                    <div class="col-md-5">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative">
                                <img src="{{ asset('images/campings.jpg') }}" class="card-img-top" alt="Camping"
                                    style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                                <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                    style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                    Camping
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">Activity 2
                                </h5>
                            </div>
                        </div>
                    </div>

                    <!-- Activity 3 -->
                    <div class="col-md-5">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative">
                                <img src="{{ asset('images/DSCF2729.jpg') }}" class="card-img-top" alt="ATV"
                                    style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                                <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                    style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                    ATV
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">Activity 3
                                </h5>
                            </div>
                        </div>
                    </div>

                    <!-- Activity 4 -->
                    <div class="col-md-5">
                        <div class="card h-100 shadow-sm border-0" style="border-radius: 20px; overflow: hidden;">
                            <div class="position-relative">
                                <img src="{{ asset('images/swimming.jpg') }}" class="card-img-top" alt="Swimming"
                                    style="border-radius: 20px 20px 0 0; height: 180px; object-fit: cover;">
                                <div class="position-absolute bottom-0 end-0 m-2 px-3 py-1 bg-success text-white fw-bold"
                                    style="border-radius: 8px; font-style: italic; font-size: 1.2rem;">
                                    Swimming
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h5 class="card-title mb-0" style="font-style: italic; color: #0b573d;">Activity 4
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fourth Page -->
    <section id="reviews" class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row">
                <!-- Title for All Screens -->
                <div class="col-12 text-center mb-3">
                    <h1 class="fw-bold text-uppercase text-start"
                        style="font-size: calc(2rem + 1vw); color: #0b573d; font-family: 'Anton', sans-serif; letter-spacing: 0.1em;">
                        REVIEWS
                    </h1>
                </div>

                <!-- HR Lines and Content -->
                <div class="col-12">
                    <hr class="mb-3" style="border-width: 5px; border-color: #0b573d; opacity: 1;">

                    <!-- Responsive Card Grid -->
                    <div class="row g-3 justify-content-center">
                        @foreach (['DSCF2814.JPG', 'DSCF2821.JPG', 'DSCF2729.JPG'] as $index => $image)
                                                <div class="col-12 col-sm-6 col-md-4">
                                                    <div class="card h-100 shadow" style="background-color: #0b573d; border-radius: 15px;">
                                                        <img src="{{ asset('images/' . $image) }}" class="card-img-top"
                                                            alt="Review {{ $index + 1 }}"
                                                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                                                        <div class="card-body">
                                                            <h5 class="card-title" style="color: #f5f5dc;">
                                                                {{ ['Amazing Resort', 'Best Experience', 'Relaxing Stay'][$index] }}
                                                            </h5>
                                                            <p class="card-text" style="color: #f5f5dc;">{{ [
                                'This resort is amazing! The staff is so friendly and the rooms are so comfortable.',
                                'I had the best experience at this resort. The food is delicious and the amenities are top-notch.',
                                'I had a very relaxing stay at this resort. The staff is so friendly and the rooms are so comfortable.'
                            ][$index] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                        @endforeach
                    </div>

                    <hr class="mt-3" style="border-width: 5px; border-color: #0b573d; opacity: 1;">
                </div>
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
</body>

</html>