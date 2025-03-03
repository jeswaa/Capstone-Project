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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
</style>
<body>
<section style="background-color: #E5F9DB;">
    <!-- Hero Section with Background -->
    <div class="hero vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light position-relative"
        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('{{ asset('images/DSCF2819.JPG') }}') no-repeat center; background-size: cover; border-bottom-left-radius: 100px; overflow: hidden;">

        <!-- Navbar (Inside Hero) -->
        <nav class="navbar navbar-expand-lg navbar-dark position-absolute top-0 start-0 w-100">
            <div class="container">
                <h1 class=" fs-1 fw-bold text-color-1 ms-5 mt-3" href="#">Lelo’s Resort</h1>
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

        <!-- Hero Content with Carousel -->
        <div class="container" style=" box-sizing: content-box;">
            <div class="row align-items-center">
                <!-- Left Side - Text Content -->
                <div class="col-md-4 text-start ms-5"  style=" box-sizing: content-box;">
                    <h1 class="display-4 fw-bold color-3"  style="font-size: 65px;" data-aos="fade-right" data-aos-duration="1000">LOREM IPSUM <br> DOLOR SIT AMET</h1>
                    <a href="{{ route('login') }}">
                    <button class="btn btn-success btn-lg mt-3 p-3 font-paragraph" data-aos="fade-right" data-aos-duration="1000">
    Book Your Stay
</button>
                    </a>
                </div>
                
                    <!-- Right Side - Carousels -->
                    <div class="col-md-7 d-flex justify-content-end align-items-center mt-5 ms-4" data-aos="fade-right" data-aos-duration="1000">
                        <div class="d-flex flex-column "> <!-- Stack Carousel 1 & 2 -->
                            <!-- Small Carousel 1 (Top) -->
                            <div id="smallHotelCarousel1" class="carousel slide custom-carousel mb-3" data-bs-ride="carousel" data-bs-interval="2000" style="max-width: 270px; border-radius: 30px;">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/image1.jpg') }}" class="w-100 rounded-3" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/image2.jpg') }}" class="w-100 rounded-3" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/image4.jpg') }}" class="w-100 rounded-3" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 3">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/image3.jpg') }}" class="w-100 rounded-3" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 3">
                                    </div>
                                </div>
                            </div>

                            <!-- Small Carousel 2 (Bottom) -->
                            <div id="smallHotelCarousel2" class="carousel slide custom-carousel" data-bs-ride="carousel" data-bs-interval="3000" style="max-width: 270px; border-radius: 30px;">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/image5.jpg') }}" class="w-100 rounded-4" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/image9.jpg') }}" class="w-100 rounded-4" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/image10.jpg') }}" class="w-100 rounded-4" style="height: 270px; object-fit: cover;" alt="Hotel Lobby 3">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Space in the Middle -->
                        <div class="mx-4"></div>

                        <!-- Small Carousel 3 (Right Side) -->
                        <div id="smallHotelCarousel3" class="carousel slide custom-carousel" data-bs-ride="carousel" data-bs-interval="3200" style="max-width: 300px; border-radius: 30px;">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('images/image8.jpg') }}" class="w-100 rounded-5" style="height: 400px; object-fit: cover;" alt="Pool Image 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/image1.jpg') }}" class="w-100 rounded-5" style="height: 400px; object-fit: cover;" alt="Pool Image 2">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('images/image10.jpg') }}" class="w-100 rounded-5" style="height: 400px; object-fit: cover;" alt="Pool Image 3">
                                </div>
                            </div>
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
                                        <h2 class="display-7 text-center text-md-start ms-4 mt-3"data-aos="fade-right" data-aos-duration="1000">Welcome to</h2>

                                        <!-- Second Heading with larger font weight -->
                                        <h2 class="display-4 fw-bold text-center text-md-start ms-3"data-aos="fade-right" data-aos-duration="1000">Lelo’s Resort</h2>
                                    </div>

                                    <!-- Paragraph -->
                                    <div class="d-flex flex-column align-items-center justify-content-center text-center me-5"data-aos="fade-right" data-aos-duration="1000">
                                        <p class="lead text-md-end text-secondary me-5"data-aos="fade-right" data-aos-duration="1000">
                                            Relax and unwind at Lelo’s Resort, where
                                            comfort and peace come together. Enjoy 
                                            beautiful views, great amenities, and friendly 
                                            service. Booking your stay is quick and easy with
                                            our simple reservation system!
                                        </p>
                                    </div>
                                </div>

                                <!-- Image Content -->
                                <div class="col-md-6" data-aos="fade-right" data-aos-duration="500">
                                    <img src="{{ asset('images/image7.jpg') }}" class="img-fluid rounded" alt="Welcome Image">
                                </div>
                            </div>
                        </div>
                    </section>

<!-- Activities Section -->
<section class="py-5" style="background-color: #E5F9DB;">
    <div class="container">
        <h2 class="fw-bold text-center mb-4" data-aos="fade-right" data-aos-duration="1000">ACTIVITIES</h2>
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card bg-dark text-white" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="0">
                    <img src="{{ asset('images/DSCF2814.jpg') }}" class="card-img activity-img" alt="Swimming">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h4 class="fw-bold">Swimming</h4>
                        <p class="small">Enjoy a refreshing swim in our pool or natural water spots.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="300">
                    <img src="{{ asset('images/hotelpic.jpg') }}" class="card-img activity-img" alt="Camping">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h4 class="fw-bold">Camping</h4>
                        <p class="small">Experience nature up close with our camping facilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="600">
                    <img src="{{ asset('images/image3.jpg') }}" class="card-img activity-img" alt="Hiking">
                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                        <h4 class="fw-bold">Atv</h4>
                        <p class="small">Explore scenic trails with breathtaking views.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Customer Testimonials -->
<section class="py-5" style="background-color: #E5F9DB;">
    <div class="container " data-aos="fade-right" data-aos-duration="1000">
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

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            let boxes = document.querySelectorAll(".box");

            boxes.forEach((box, index) => {
                let animation = (index % 2 === 0) ? "fade-right" : "fade-left";
                box.setAttribute("data-aos", animation);
                box.setAttribute("data-aos-duration", "1000");
                box.setAttribute("data-aos-once", "false"); // Para mag-retrigger kapag nag-scroll pataas
            });

            AOS.init({
                duration: 1000, // Tagal ng animation
                once: false, // Para gumana kahit mag-scroll pataas
                mirror: true // Para ma-trigger ulit kapag bumalik sa viewport
            });
        });
</script>
</body>
</html> 