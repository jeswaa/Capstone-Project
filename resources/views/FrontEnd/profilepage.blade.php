<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="background-color">
    <!-- Container for rectangular top section -->
    <div class="container-fluid position-relative" style="background: url('{{ asset('images/mountain.jpg') }}') no-repeat center center; background-size: cover; height: 250px;">
        <!-- Back logo positioned in the upper-left -->
        <i class="fa-solid fa-arrow-turn-up position-absolute" style="top: 20px; left: 30px; color: black; font-size: 30px; cursor: pointer; transform: rotate(270deg);" onclick="window.history.back();"></i>

    </div>
</body>

<!-- Left-aligned, slightly moved to the right with custom margin -->
<div class="position-absolute start-0 top-custom-l translate-middle-y ms-custom-l">
    <div class="bg shadow p-4" style="width: 25vw; height: 600px; border-radius: 20px; background-color: #B5C99A; position: relative;">
        <!-- Circle inside the container, centered -->
        <div class="circle" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -120%); width: 50%; height: 30%; border-radius: 50%; background-color: #718355; border: 3px solid #fff; z-index: 1;">
            <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
        </div>

        <!-- Example Name below the circle -->
        <p class="text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, 30%); color: #333; font-size: 18px; font-weight: bold; z-index: 2;">
            {{ $user->name }}
        </p>

        <!-- Email and Contact Number below the Name -->
        <p class="text-center" style="position: absolute; top: 55%; left: 50%; transform: translate(-50%, 30%); color: #555; font-size: 15px; font-weight: bold; z-index: 2;">
            {{ $user->email }} <br> {{ $user->mobileNo }}
        </p>

        <!-- Address at the bottom center of the container -->
        <p class="text-center" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: #444; font-size: 20px; font-weight: bold; z-index: 2;">
            {{ $user->address }}
        </p>

        <!-- Clickable Edit Icon in the upper right -->
        <a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#editModal" style="position: absolute; top: 25px; right: 25px; cursor: pointer; z-index: 2;">
            <i class="fa-solid fa-pen" style="font-size: 20px; color:black;"></i>
        </a>
    </div>
</div>
<!-- Include Edit Profile Modal -->



<!-- Right-aligned, slightly moved to the right with custom margin -->
<div class="position-absolute end-0" style="margin-right: 13%; top: 30%;">
    <div class="bg shadow p-4" style="width: 50vw; height: 470px; border-radius: 20px; background-color: #B5C99A; position: relative;">
        
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: transparent;">
            <div class="container-fluid">
                <!-- Navbar Items Aligned to Start -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav gap-2">
                        <li class="nav-item me-4">
                            <a class="nav-link active fw-bold" href="#">RESERVATION</a>
                        </li>
                        <li class="nav-item me-4">
                            <a class="nav-link fw-bold" href="#">HISTORY</a>
                        </li>
                        <li class="nav-item me-4">
                            <a class="nav-link fw-bold" href="#">PAYMENT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

    <!-- Font Awesome 6 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
</body>
</html>
