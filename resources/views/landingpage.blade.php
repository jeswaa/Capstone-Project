<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Hero Section with Background -->
    <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative"
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
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Content -->
        <div class="container text-start d-flex flex-column align-items-start">
            <h1 class="display-4 fw-bold">LOREM IPSUM<br>DOLOR SIT AMET</h1>
            <button class="btn btn-success mt-3">Book Your Stay</button>
        </div>

    </div>

<!-- Welcome Section -->
<section id="about" class="py-5 bg-light">
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



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
