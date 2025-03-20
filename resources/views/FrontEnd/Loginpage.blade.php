<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            overflow: hidden; /* Prevent content from cutting off */
        }
        .login-form {
            width: 100vw;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-center {
            margin: 0 auto;
        }
        .login-img {
            height: 95vh;
            object-position: center;
            opacity: 0; /* Hide initially for smooth animation */
            transition: opacity 1s ease-in-out;
        }
        .text-hover-effect {
            background: linear-gradient(to right, currentColor 100%, transparent 100%);
            margin-top: 10px;
            background-size: 0% 2px;
            background-repeat: no-repeat;
            background-position: 0% 100%;
            transition: background-size 0.4s ease-in-out;
        }
        .text-hover-effect:hover {
            background-size: 100% 2px;
        }
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
        .form-control {
            border: none;
            border-radius: 0;
            background-color: #f5f5f5;
            padding: 1rem;
            transition: background-color 0.3s ease-in-out;
        }
        .form-control:focus {
            background-color: #e5f9db;
            outline: none;
        }
        .btn-login {
            background-color: #718355;
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 0;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-login:hover {
            background-color: #4a4a4a;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="color-background5 d-flex justify-content-center align-items-center">
    @if ($errors->any())
        <div class="position-absolute top-0 end-0 translate-middle-x mt-5 w-auto alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                    <h1 class="text-color-1 font-paragraph mx-auto fs-2 text-center">Welcome to Lelo's Resort</h1> <!-- Reduced font size -->
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.authenticate') }}" method="POST" class="w-100">
                    @csrf
                    <div class="mb-5 mt-5"> 
                        <input type="email" class="form-control @error('email') is-invalid @enderror p-3 mb-3" 
                            name="email" placeholder="Email..." required>
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
                               name="password" placeholder="Password..." required>
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

                    <div class="form-check text-start mt-3">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label text-color-1 font-paragraph" for="agreeTerms" style="font-size: 0.9rem; color: #555;">
                            I agree to the  
                            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal" class="font-paragraph fs-6 text-decoration-none text-color-1 fw-semibold text-underline-left-to-right">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Privacy Policy Modal -->
                    <div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-paragraph text-color-1" id="privacyPolicyLabel">Privacy Policy</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="font-paragraph text-color-1">We collect and store your email and password securely for authentication purposes. Your data is protected and will not be shared without your consent. By using our service, you agree to our terms.</p>
                                    <p  class="font-paragraph text-color-1">For more details, contact us at lelosresort@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>


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
        <div class="modal-content" style="background-color: #97a97c;">
            <div class="modal-header">
                <h5 class="modal-title text-center text-color-1 font-paragraph fs-3" id="forgotPasswordModalLabel">Forgot Password</h5>
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
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="mb-3">
                        <label for="email" class="form-label font-paragraph text-color-1">Email</label>
                        <input type="email" class="form-control font-paragraph" name="email" id="email" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="otp" class="form-label font-paragraph text-color-1">OTP Code</label>
                        <div class="d-flex">
                            <input type="text" class="form-control font-paragraph me-2" name="otp" id="otp" placeholder="Enter OTP" required>
                            <button type="button" id="sendOTPBtn" class="btn btn-secondary" onclick="sendOTP()">Send OTP</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label font-paragraph text-color-1">New Password</label>
                        <input type="password" class="form-control font-paragraph" name="password" placeholder="Enter new password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label font-paragraph text-color-1">Confirm Password</label>
                        <input type="password" class="form-control font-paragraph" name="password_confirmation" placeholder="Confirm your password" required>
                    </div>

                    <button type="submit" class="color-background6 p-2 border-0 text-hover-1 font-paragraph color-3 rounded-2 w-100">
                        Reset Password
                    </button>
                </form>
            </div>
<body class="color-background5 d-flex justify-content-center align-items-center" onload="AOS.init();">
        <div class="position-absolute top-0 start-0 mt-5 ms-5">
            <a href="{{ route('landingpage') }}"><i class="fa-solid fa-circle-left fa-2x color-3 icon"></i></a>
        </div>
    <div class="login-center login-form d-flex justify-content-center align-items-center">
        <div class="w-50" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true" data-aos-delay="100">
            <h1 class="text-color-1 mt-3 font-heading fs-4 text-center">Welcome to Lelo's Resort</h1>
            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label text-color-1"></label>
                    <input type="email" class="form-control p-2 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email..." required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @else
                        @if(session()->has('error'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ session()->get('error') }}</strong>
                            </span>
                        @endif
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-color-1"></label>
                    <input type="password" class="form-control p-2 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password..." required>
                    @error('password')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @else
                        @if(session()->has('error'))
                            <div class="invalid-feedback ">
                                <strong>{{ session()->get('error') }}</strong>
                            </div>
                        @endif
                    @enderror
                </div>
                <button type="submit" class="mb-3 mt-4 border-0 p-2 rounded-4 color-background6 w-100 font-paragraph fw-bold color-3 btn-login" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="200">LOGIN</button>
                <p class="text-center mt-3 text-color-1 font-paragraph" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="300">Don't have an account?<a href="{{ route('signup') }}" class="font-paragraph text-color-1 ms-3 text-decoration-none text-hover-effect">Sign Up</a></p>
               <hr>
               <a href="{{ route('google.redirect') }}" class="color-3 font-paragraph text-decoration-none fw-bold" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="400">
                    <div class="d-flex justify-content-center w-100 color-background6 p-2 rounded-4 google">
                            <img src="{{ asset('images/google.png') }}" alt="" width="20" height="20" class="me-2"> Sign up using Google
                    </div>
                </a>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Add before your custom scripts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let modalElement = document.getElementById("forgotPasswordModal");
        if (modalElement) {
            var myModal = new bootstrap.Modal(modalElement);
            document.querySelectorAll(".forgot-password").forEach(el => {
                el.addEventListener("click", function () {
                    myModal.show();
                });
            });
        }
    });

    function sendOTP() {
        let email = document.getElementById("email").value;
        let sendOTPBtn = document.getElementById("sendOTPBtn");

        if (!email) {
            alert("Please enter your email first.");
            return;
        }

        sendOTPBtn.disabled = true; // Disable button to prevent multiple requests
        sendOTPBtn.textContent = "Sending...";

        fetch("{{ route('forgot.sendOTP') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            console.error("Error sending OTP:", error);
            alert("Failed to send OTP. Please try again.");
        })
        .finally(() => {
            sendOTPBtn.disabled = false;
            sendOTPBtn.textContent = "Send OTP";
        });
    }

    function resetPassword() {
        let email = document.getElementById("email").value;
        let otp = document.getElementById("otp").value;
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("confirmPassword").value;
        let resetPasswordBtn = document.getElementById("resetPasswordBtn");

        if (!email || !otp || !password || !confirmPassword) {
            alert("Please fill in all fields.");
            return;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return;
        }

        resetPasswordBtn.disabled = true;
        resetPasswordBtn.textContent = "Resetting...";

        fetch("{{ route('forgot.reset') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ email, otp, password, password_confirmation: confirmPassword })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.message === "Password reset successfully!") {
                window.location.href = "/login"; // Redirect to login page after successful reset
            }
        })
        .catch(error => {
            console.error("Error resetting password:", error);
            alert("Failed to reset password. Please try again.");
        })
        .finally(() => {
            resetPasswordBtn.disabled = false;
            resetPasswordBtn.textContent = "Reset Password";
        });
    }
</script>


</body>
</html>

