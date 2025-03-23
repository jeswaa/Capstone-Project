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
        body {
        background: url("{{ asset('images/logosheesh.png') }}") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        position: relative;
        }
        
        body::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20vh; /* Adjust height as needed */
            background: linear-gradient(to top, rgba(0, 93, 59, 0.8), transparent); /* Dark green smoke effect */
            pointer-events: none;
        }

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

        .login-button {
            background-color: #0B5D3B; /* Dark Green */
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 5px 10px;
            border: none;
            border-radius: 50px; /* Makes it pill-shaped */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px; /* Adjust width as needed */
            cursor: pointer;
            margin: 0 auto;
        }

        .login-button .arrow {
            background-color: white;
            color: #0B5D3B;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            font-size: .7rem;
        }

    </style>
</head>
<body>
<div class="position-absolute top-0 start-0 mt-5 ms-5">
    <a href="{{ url('/') }}" class="d-flex align-items-center justify-content-center rounded-circle shadow"
       style="width: 45px; height: 45px; background-color: #0B5D3B; text-decoration: none;">
        <i class="fa-solid fa-arrow-left text-white fs-4"></i>
    </a>
</div>

    <div class="position-absolute top-0 end-0 mt-3 me-5">
        <a href="{{ url('/') }}" class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
        </a>
    </div>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container p-4 shadow-lg rounded-4 bg-white" style="max-width: 1000px;">
        <div class="row align-items-center">
            
            <!-- Left Side: Login Form -->
            <div class="col-md-6">
                <div class="d-flex align-items-center w-100 mb-3">
                    <h1 class="text-success font-paragraph mx-auto fs-4 text-center fw-bold">Welcome to Lelo's Resort</h1>
                </div>

                <form action="{{ route('login.authenticate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="email" class="form-control @error('email') is-invalid @enderror p-3" 
                               name="email" placeholder="Email..." required>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" class="form-control @error('password') is-invalid @enderror p-3" 
                               name="password" placeholder="Password..." required>
                        @error('password')
                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <a data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" 
                           class="text-decoration-none text-color-1 font-paragraph text-underline-left-to-right"
                           style="cursor: pointer; font-size: 0.85rem;">Forgot Password?</a>
                    </div>

                    <button type="submit" class="login-button d-flex align-items-center justify-content-center">
                        LOG IN 
                        <span class="arrow d-flex align-items-center justify-content-center rounded-circle" style="width: 20px; height: 20px; margin-left: 10px;">
                            &rsaquo;
                        </span>
                    </button>


                    <div class="form-check text-start mt-3">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label text-color-1 font-paragraph" for="agreeTerms" style="font-size: 0.9rem;">
                            I agree to the  
                            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal" class="font-paragraph text-decoration-none text-color-1 fw-semibold text-underline-left-to-right">Privacy Policy</a>
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

                    <p class="text-center mt-2 text-color-1 font-paragraph" style="font-size: 0.85rem;">
                        Don't have an account? 
                        <a href="{{ route('signup') }}" class="text-color-1 ms-1 text-decoration-none text-hover-effect">Sign Up</a>
                    </p>

                    <a href="{{ route('google.redirect') }}" class="color-3 font-paragraph text-decoration-none fw-bold">
                        <div class="d-flex justify-content-center align-items-center color-background6 p-3 rounded-4 google"
                             style="font-size: 0.9rem;">
                            <img src="{{ asset('images/google.png') }}" alt="" width="16" height="16" class="me-2"> 
                            Sign up using Google
                        </div>
                    </a>
                </form>
            </div>

            <!-- Right Side: Image -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/labasneto.jpg') }}" alt="Login Image" class="img-fluid rounded-4" style="height: 65vh;">
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