<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- ✅ Navbar (Fixed at the Top with z-index) -->
    <nav class="navbar navbar-expand-lg  position-absolute top-0 w-100" style="z-index: 10;">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#Home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#About">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#ContactUs">Contact Us</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="me-3 text-color-2 fs-5 p-2 text-decoration-none fw-semibold text-uppercase text-underline-left-to-right" style="font-family: 'Josefin Sans', sans-serif;">Login</a>
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort" height="150" width="130">
                </a>
            </div>
        </div>
    </nav>
    <!-- First Page -->
    <section>
            <!-- Hero Section with Background -->
    <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative"
        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.9)), url('{{ asset('images/DSCF2819.JPG') }}') no-repeat center; background-size: cover; overflow: hidden;">
        <div class="smoke position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, transparent, rgba(0,115,0,0.2));"></div>
        <!-- Hero Content with Carousel -->
        <div id="hero" class="container" style="box-sizing: content-box;">
            <div class="row align-items-end ms-5 justify-content-end">
                <!-- Left Side - Text Content -->
                <div class="col-md-8 text-end" style="box-sizing: content-box;">
                    <h1 class="display-4 fw-bold position-relative" style="top: 50px; margin-right: 150px; font-size: 35px;">WELCOME TO YOUR</h1>
                    <p class="fw-bold text-white" style="color:rgb(173, 221, 112); font-size: 150px;">RESORTS</p>
                    <h1 class="display-4 fw-bold position-relative" style="bottom: 50px; margin-right: 55px; font-size: 35px;">DIGITAL BOOKING COMPANION</h1>
                    <div class="d-flex justify-content-center mt-4">
                        <button class="btn btn-success btn-lg px-4 font-paragraph position-relative" style="margin-left: 200px; bottom: 50px; border-radius: 50px; background-color: #0c5720; color: white; font-style: italic; font-weight: bold; display: flex; align-items: center; gap: 10px;">BOOK YOUR STAY
                            <span style="display: inline-block; background-color: white; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right" style="color: #0c5720;"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>    

    </section>

    <!-- Second Page -->
    <section>

    </section>

    <!-- Third Page -->
    <section>

    </section>

    <!-- Fourth Page -->
    <section>

    </section>

        
</body>
</html> 