<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-form {
            width: 100vw;
            height: 80vh;
        }
        .login-center {
            margin: 0 auto;
        }
        .login-img {
            height: 95vh;
            object-position: center;
        }
        .text-hover-effect {
            background: linear-gradient(to right, currentColor 100%, transparent 100%);
            margin-top: 10px;
            background-size: 0% 2px;
            background-repeat: no-repeat;
            background-position: 0% 100%;
            transition: background-size 0.4s ease-in-out;
            &:hover {
                background-size: 100% 2px;
            }
        }
        .google:hover {
           background-color: #4a4a4a;
           color: #fff;
           transition: all 0.3s ease-in-out;
        }
        .login:hover{
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
<body class="color-background5 d-flex justify-content-center align-items-center">
    @if (session('success'))
        <div class="position-absolute top-0 start-50 translate-middle-x mt-5 w-auto alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            
            <!-- Left Side: Login Form -->
            <div class="col-lg-6 d-flex flex-column align-items-center">
                
                <!-- Back Button & Title -->
                <div class="d-flex align-items-center w-100 mb-3 mt-n3"> <!-- Adjusted margin for higher placement -->
                    <a href="{{ route('landingpage') }}" class="me-3">
                        <i class="fa-solid fa-circle-left fa-xl color-3 icon-hover fs-2"></i> <!-- Reduced icon size -->
                    </a>
                    <h1 class="text-color-1 font-paragraph mx-auto fs-5 text-center">Welcome to Lelo's Resort</h1> <!-- Reduced font size -->
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.authenticate') }}" method="POST" class="w-100">
                    @csrf
                    <div class="mb-5 mt-5">
                        <input type="email" class="form-control @error('email') is-invalid @enderror p-3 mb-3" 
                               id="email" name="email" placeholder="Email..." required>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @else
                            @if(session()->has('error'))
                                <span class="invalid-feedback"><strong>{{ session()->get('error') }}</strong></span>
                            @endif
                        @enderror
                    </div>

                    <div class="mb-4 mt-4">
                        <input type="password" class="form-control  @error('password') is-invalid @enderror p-3" 
                               id="password" name="password" placeholder="Password..." required>
                        @error('password')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @else
                            @if(session()->has('error'))
                                <div class="invalid-feedback"><strong>{{ session()->get('error') }}</strong></div>
                            @endif
                        @enderror
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-end">
                        <a data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" 
                           class="text-decoration-none text-color-1 font-paragraph text-underline-left-to-right"
                           style="cursor: pointer; font-size: 0.85rem;">Forgot Password?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="mb-2 mt-3 border-0 p-3 text-hover-1 rounded-4 color-background6 w-100 font-paragraph fw-bold color-3">
                        LOGIN
                    </button>

                    <!-- Signup Link -->
                    <p class="text-center mt-2 text-color-1 font-paragraph" style="font-size: 0.85rem;">
                        Don't have an account? 
                        <a href="{{ route('signup') }}" class="text-color-1 ms-1 text-decoration-none text-hover-effect">Sign Up</a>
                    </p>

                    <hr>

                    <!-- Google Login -->
                    <a href="{{ route('google.redirect') }}" class="color-3 font-paragraph text-decoration-none fw-bold">
                        <div class="d-flex justify-content-center align-items-center color-background6 p-3 rounded-4 google"
                             style="font-size: 0.9rem;">
                            <img src="{{ asset('images/google.png') }}" alt="" width="16" height="16" class="me-2"> 
                            Sign up using Google
                        </div>
                    </a>
                </form>
            </div>  

            <!-- Right Side: Image (Visible on Large Screens) -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                <img src="{{ asset('images/DSCF2819.JPG') }}" alt="Signup Image" class="img-fluid rounded-4 ms-5" 
                     style="max-width: 100%; height: 90vh; object-fit: cover;">
            </div>

        </div>
    </div>
</div>




    <!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content color-background5">
            <div class="modal-header">
                <h5 class="modal-title text-color-1 font-paragraph fs-3" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('forgot.reset') }}" method="POST" class="p-3">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        var myModal = new bootstrap.Modal(document.getElementById("forgotPasswordModal"));
        document.querySelectorAll(".forgot-password").forEach(el => {
            el.addEventListener("click", function () {
                myModal.show();
            });
        });
    </script>
</body>
</html>

