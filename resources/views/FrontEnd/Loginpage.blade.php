<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lelo's Resort</title>

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
        .google:hover {
            background-color: #4a4a4a;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }
        .login:hover {
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
                <a href="{{ route('landingpage') }}">
                    <i class="fa-solid fa-circle-left fa-2x color-3 icon"></i>
                </a>
            </div>

            <!-- Left Side: Login Form (Full Width on Mobile, Half on Larger Screens) -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="w-100 p-4">
                    <h1 class="text-color-1 text-center font-heading fs-4">Welcome to Lelo's Resort</h1>
                    <form action="{{ route('login.authenticate') }}" method="POST">
                        @csrf
                        <div class="mb-3 mt-3">
                            <input type="email" class="form-control p-3 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email..." required>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @else
                                @if(session()->has('error'))
                                    <span class="invalid-feedback" role="alert"><strong>{{ session()->get('error') }}</strong></span>
                                @endif
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control p-3 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password..." required>
                            @error('password')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                            @else
                                @if(session()->has('error'))
                                    <div class="invalid-feedback"><strong>{{ session()->get('error') }}</strong></div>
                                @endif
                            @enderror
                        </div>
                        <button type="submit" class="mb-3 mt-4 border-0 p-2 rounded-4 color-background6 w-100 font-paragraph fw-bold color-3 login">
                            LOGIN
                        </button>
                        <p class="text-center mt-3 text-color-1 font-paragraph">
                            Don't have an account?
                            <a href="{{ route('signup') }}" class="font-paragraph text-color-1 ms-2 text-decoration-none">Sign Up</a>
                        </p>
                        <hr>
                        <a href="{{ route('google.redirect') }}" class="text-decoration-none">
                            <div class="mb-3 mt-4 border-0 p-2 rounded-4 color-background6 w-100 font-paragraph fw-bold color-3 login">
                                <img src="{{ asset('images/google.png') }}" width="20" height="20" class="me-2"> Sign up using Google
                            </div>
                        </a>
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