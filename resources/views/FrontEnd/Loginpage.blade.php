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

</body>
</html>