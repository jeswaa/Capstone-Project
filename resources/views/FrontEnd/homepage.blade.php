<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Bootstrap CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('Alert.loginSuccessUser')
<section style="background-color: #E5F9DB;">
    <!-- Hero Section with Background -->
    <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative "
     style="background: url('{{ asset('images/hotelPic.jpg') }}') no-repeat center center; background-size: cover; border-bottom-left-radius: 100px; overflow: hidden;">
     
        <!-- Navbar (Inside Hero) -->
        <nav class="navbar navbar-expand-lg navbar-dark position-absolute top-0 start-0 w-100">
    <div class="container">
        <a class="navbar-brand fs-2 fw-bold" href="#">LOGO NAME</a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item me-3">
                    <a class="nav-link fs-4 fw-bold text-light" href="#">Home</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link fs-4 fw-bold text-light" href="#">About</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link fs-4 fw-bold text-light" href="#">Contact Us</a> 
                </li>
                <!-- Profile Logo -->
                <li class="nav-item">
                    <a class="nav-link fs-3 text-black" href="#">
                        <i class="bi bi-person-circle"></i> <!-- Profile Logo -->
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

        <!-- Hero Content -->
        <div class="container text-start d-flex flex-column align-items-start">
            <h1 class="display-4 fw-bold">LOREM IPSUM<br>DOLOR SIT AMET</h1>
            <a href="{{ route('reservation')}}"><button class="btn btn-success mt-3">Make a Reservation</button></a>
        </div>
    </div>
    </section>
<!-- Welcome Section -->
<section id="about" class="py-5" style="background-color: #E5F9DB;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Text Content -->
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <!-- First Heading -->
                    <h2 class="display-7 text-center text-md-start ms-4 mt-3">Welcome to</h2>

                    <!-- Second Heading with larger font weight -->
                    <h2 class="display-4 fw-bold text-center text-md-start ms-3">Lelo’s Resort</h2>
                </div>

                <!-- Paragraph -->
                <div class="d-flex flex-column align-items-center justify-content-center text-center me-5">
                    <p class="lead text-md-end text-secondary me-5">
                        Relax and unwind at Lelo’s Resort, where
                        comfort and peace come together. Enjoy 
                        beautiful views, great amenities, and friendly 
                        service. Booking your stay is quick and easy with
                        our simple reservation system!
                    </p>
                </div>
            </div>

            <!-- Image Content -->
            <div class="col-md-6">
                <img src="{{ asset('images/hotelpic.jpg') }}" class="img-fluid rounded" alt="Welcome Image">
            </div>
        </div>
    </div>
</section>

<!-- Activities Section -->
<section class="py-5" style="background-color: #E5F9DB;">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">ACTIVITIES</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <img src="{{ asset('images/hotelpic.jpg') }}" class="card-img activity-img" alt="Swimming">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h4 class="fw-bold">Swimming</h4>
                        <p class="small">Enjoy a refreshing swim in our pool or natural water spots.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <img src="{{ asset('images/hotelpic.jpg') }}" class="card-img activity-img" alt="Camping">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h4 class="fw-bold">Camping</h4>
                        <p class="small">Experience nature up close with our camping facilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <img src="{{ asset('images/hotelpic.jpg') }}" class="card-img activity-img" alt="Hiking">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h4 class="fw-bold">Hiking</h4>
                        <p class="small">Explore scenic trails with breathtaking views.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Testimonials -->
<section class="py-5" style="background-color: #E5F9DB;">
    <div class="container">
        <div class="card shadow-lg rounded-4 p-4" style="background-color: #97A97C;"> <!-- Changed card background color -->
        <h2 class="fw-bold text-center position-relative" style="top: 70px;">What Our Customers Say?</h2>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('images/hotelpic.jpg') }}" class="testimonial-img" alt="Customer Review">
                            </div>
                            <div class="col-md-8">
                                <p class="lead">"An amazing experience! The staff was so friendly, and the views were breathtaking. Highly recommended!"</p>
                                <p class="fw-bold">- Jobert</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('images/hotelpic.jpg') }}" class="testimonial-img" alt="Customer Review">
                            </div>
                            <div class="col-md-8">
                                <p class="lead">"The best getaway I’ve had in years. Everything was perfect from the rooms to the activities."</p>
                                <p class="fw-bold">- Maria</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="py-5" style="background-color: #6B8E6B; color: white;">
    <div class="container">
        <div class="row d-flex justify-content-between align-items-center">
            <!-- Logo and Map Section -->
            <div class="col-md-4">
                <h4 class="fw-bold fs-1">LOGO NAME</h4>
                <!-- Map Image Below the Logo Name -->
                <div class="mt-3">
                    <img src="{{ asset('images/map.png') }}" class="img-fluid" alt="Map" style="max-width: 110%; height: auto;">
                </div>
            </div>
            <!-- Terms, Privacy Policy, and Facebook Icon Section with Custom Gap -->
            <div class="d-flex justify-content-end align-items-center custom-gap custom-move">
                <a href="#" class="text-white text-decoration-none fs-5 fw-bold">Terms of Service</a>
                <a href="#" class="text-white text-decoration-none fs-5 fw-bold">Privacy Policy</a>
                <a href="#" class="text-black fs-1 fw-bold"><i class="bi bi-facebook"></i></a>
            </div>
            <!-- Contact Info Section -->
            <div class="col-md-3 text-white align-items-center custom-move-b custom-mt-5">
                <p><strong>Phone:</strong> +123 456 7890</p>
                <p><strong>Email:</strong> contact@yourdomain.com</p>
                <p><strong>Address:</strong> 123 Street Name, City, Country</p>
            </div>
        </div> <!-- Closing the row div -->
    </div> <!-- Closing the container div -->
</footer>
</body>
</html> 