<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lelo's Resort</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Vite (For Laravel Projects) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        /* Hover Effects */
        .signup:hover {
            color: #718355;
            background-color: #e5f9db;
            transition: all 0.3s ease-in-out;
        }
        .icon:hover {
            color: #4a4a4a;
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="color-background5 d-flex align-items-center vh-100">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            
            <!-- Back Button -->
            <div class="position-absolute top-0 start-0 mt-4 ms-4">
                <a href="{{ route('login') }}">
                    <i class="fa-solid fa-circle-left fa-2x color-3 icon"></i>
                </a>
            </div>

            <!-- Left Side: Signup Form (Full Width on Mobile, Half on Larger Screens) -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="w-100 p-4">
                    <h1 class="text-color-1 text-center font-heading fs-4">Create an Account</h1>
                    <form action="{{ route('signup.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control p-3" id="name" name="name" placeholder="Full Name..." required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control p-3" id="address" name="address" placeholder="Address..." required>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control p-3" id="image" name="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control p-3" id="email" name="email" placeholder="Email..." required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control p-3" id="mobileNo" name="mobileNo" placeholder="Mobile Number..." required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control p-3" id="password" name="password" placeholder="Password..." required>
                        </div>
                        <button type="submit" class="mb-3 mt-4 border-0 p-2 rounded-4 color-background6 w-100 font-paragraph fw-bold color-3 signup">
                            SIGNUP
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Image (Hidden on Small Screens, Visible on Larger) -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/hotelpic.jpg') }}" alt="Resort Image" class="img-fluid rounded-5">
            </div>
        </div>
    </div>

</body>
</html>
