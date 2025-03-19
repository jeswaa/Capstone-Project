<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>

</style>
<body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light justify-content-start">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" aria-current="page" href="#Home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#About">About</a>
                        </li>
                        <li class="nav-item fw-semibold">
                            <a class="nav-link text-uppercase text-underline-left-to-right me-4" style="color: #0b573d; font-family: 'Josefin Sans', sans-serif" href="#ContactUs">Contact Us</a>
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
    <section id="Home">
        
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