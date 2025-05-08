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
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#reviews">Review</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="me-3 text-color-2 fs-5 p-2 text-decoration-none fw-semibold text-uppercase text-underline-left-to-right" style="font-family: 'Josefin Sans', sans-serif;">Login</a>
                <a class="navbar-brand d-none d-md-block" href="#">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort" id="logo" height="150" width="130">
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
                            <a href="{{ route('login') }}"
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
    <!-- Rooms section -->    
    <section>
    <div class="container text-center my-5">
        <div class="position-relative py-5">
            <div class="position-absolute top-0 bottom-0 start-0" style="width: 150px; background-color: #eaffcc; clip-path: polygon(0 0, 80% 0, 100% 100%, 0% 100%); z-index: 0;"></div>
            <div class="position-relative bg-light-subtle">
             <h1 class="fw-bold text-success display-5">ROOMS</h1>
          </div>
         <div class="position-absolute top-0 bottom-0 end-0" style="width: 150px; background-color: #eaffcc; clip-path: polygon(20% 0, 100% 0, 100% 100%, 0 100%); z-index: 0;"></div>
          </div>
          <p class="fst-italic text-success">Modern, clean, and comfortable spaces to rest and recharge!</p>
        <div class="row g-4 mt-4">
            <!-- Room 1 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room1.jpg') }}" class="card-img-top" alt="Room 1">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 1</h5>
                    </div>
                </div>
            </div>
            <!-- Room 2 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room2.jpg') }}" class="card-img-top" alt="Room 2">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 2</h5>
                    </div>
                </div>
            </div>
            <!-- Room 3 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room3.jpg') }}" class="card-img-top" alt="Room 3">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 3</h5>
                    </div>
                </div>
            </div>
            <!-- Room 4 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room4.jpg') }}" class="card-img-top" alt="Room 4">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 4</h5>
                    </div>
                </div>
            </div>
            <!-- Room 5 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room5.jpg') }}" class="card-img-top" alt="Room 5">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 5</h5>
                    </div>
                </div>
            </div>
            <!-- Room 6 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room6.jpg') }}" class="card-img-top" alt="Room 6">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 6</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>


    <!-- cottage section -->     
    <section>
    <div class="container text-center my-5">
        <div class="position-relative py-5">
            <div class="position-absolute top-0 bottom-0 start-0" style="width: 150px; background-color: #eaffcc; clip-path: polygon(0 0, 80% 0, 100% 100%, 0% 100%); z-index: 0;"></div>
            <div class="position-relative bg-light-subtle">
             <h1 class="fw-bold text-success display-5">ROOMS</h1>
          </div>
         <div class="position-absolute top-0 bottom-0 end-0" style="width: 150px; background-color: #eaffcc; clip-path: polygon(20% 0, 100% 0, 100% 100%, 0 100%); z-index: 0;"></div>
          </div>
          <p class="fst-italic text-success">Modern, clean, and comfortable spaces to rest and recharge!</p>
        <div class="row g-4 mt-4">
            <!-- Room 1 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room1.jpg') }}" class="card-img-top" alt="Room 1">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 1</h5>
                    </div>
                </div>
            </div>
            <!-- Room 2 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room2.jpg') }}" class="card-img-top" alt="Room 2">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 2</h5>
                    </div>
                </div>
            </div>
            <!-- Room 3 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room3.jpg') }}" class="card-img-top" alt="Room 3">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 3</h5>
                    </div>
                </div>
            </div>
            <!-- Room 4 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room4.jpg') }}" class="card-img-top" alt="Room 4">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 4</h5>
                    </div>
                </div>
            </div>
            <!-- Room 5 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room5.jpg') }}" class="card-img-top" alt="Room 5">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 5</h5>
                    </div>
                </div>
            </div>
            <!-- Room 6 -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/room6.jpg') }}" class="card-img-top" alt="Room 6">
                    <div class="card-img-overlay d-flex align-items-end p-0">
                        <div class="w-100 bg-success bg-opacity-75 text-white p-2 text-end fw-bold" style="font-size: 1.2rem;">
                            Price: ₱ 3,000
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Room 6</h5>
                    </div>
                </div>
            </div>
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


</body>
</html> 