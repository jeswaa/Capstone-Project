<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>
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
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30vh;
            background: linear-gradient(to top, rgba(0, 93, 59, 0.8), transparent);
            pointer-events: none;
            z-index: -1;
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
            background-color: #0B5D3B;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 5px 15px;
            border: none;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px; /* Increased width to accommodate loading text */
            cursor: pointer;
            margin: 0 auto;
            height: 40px;
            transition: all 0.3s ease;
        }

        .login-button .loading-text {
            display: none;
            align-items: center;
            gap: 8px;
        }

        .login-button .loading-text i {
            color: white;
            font-size: 1rem;
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
        .flip-horizontal {
        display: inline-block;
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
    }
    #passwordFields {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    .color-background8{
        background-color: #0B5D3B;
    }
    </style>
</head>
<body>
    @include('Alert.errorLogin')
    <!-- Validations -->
    <div class="position-fixed top-0 end-0 mt-3 me-5" style="z-index: 9999;">
        @if (session('success'))
            <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Header with Back Button and Logo -->
    <div class="w-100 d-flex justify-content-between align-items-center p-3">
        <!-- Back Button -->
        <a href="{{ url('/') }}" class="d-flex align-items-center justify-content-center rounded-circle shadow ms-3"
           style="width: 50px; height: 50px; background-color: #0B5D3B; text-decoration: none;">
            <i class="fa-solid fa-arrow-left text-white"></i>
        </a>

        <!-- Logo -->
        <a class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" class="rounded-pill" style="width: 100px; height: auto;">
        </a>
    </div>

    <!-- Main Content Container -->
    <div class="d-flex justify-content-center align-items-center">
    <div class="container p-4 shadow-lg rounded-4 bg-white" style="max-width: 1000px;">
        <div class="row align-items-center">
            
            <!-- Left Side: Login Form -->
            <div class="col-md-6">
                <div class="d-flex align-items-center w-100 mb-3">
                    <h1 class="text-success font-paragraph mx-auto fs-4 text-center fw-bold">Welcome to Lelo's Resort</h1>
                </div>

                <form id="login-form" action="{{ route('login.authenticate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input id="userCredential" type="text" class="form-control @error('credential') is-invalid @enderror p-3" 
                            name="credential" placeholder="Email..." required>
                        @error('credential')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4 position-relative">
                        <input type="password" 
                            class="form-control @error('password') is-invalid @enderror p-3" 
                            name="password" 
                            id="passwordField"
                            placeholder="Password..." 
                            required>
                            
                        <!-- Show/Hide Password Toggle -->
                        <span class="position-absolute end-0 top-50 translate-middle-y me-3 @error('password') is-invalid @enderror p-3" 
                            style="cursor: pointer;"
                            onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                        
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ str_replace('!', '', $message) }}</strong>
                            </div>
                        @enderror
                    </div>

                    <script>
                    function togglePasswordVisibility() {
                        const passwordField = document.getElementById('passwordField');
                        const toggleIcon = document.getElementById('toggleIcon');
                        
                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            toggleIcon.classList.remove('fa-eye');
                            toggleIcon.classList.add('fa-eye-slash');
                        } else {
                            passwordField.type = 'password';
                            toggleIcon.classList.remove('fa-eye-slash');
                            toggleIcon.classList.add('fa-eye');
                        }
                    }
                    </script>

                    <div class="text-start mb-3">
                        <a data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" 
                           class="text-decoration-none text-color-1 font-paragraph text-underline-left-to-right"
                           style="cursor: pointer; font-size: 0.85rem;">Forgot Password?</a>
                    </div>

                    @if ($errors->has('g-recaptcha-response'))
                        <div class="invalid-feedback d-flex justify-content-end">
                            <strong class="flip-horizontal">{{ $errors->first('g-recaptcha-response') }}</strong>
                        </div>
                    @endif

                    
                    <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-md-6 col-lg-4"> <!-- Adjust column sizes as needed -->
                        <div class="g-recaptcha-wrapper" style="transform:scale(0.85);transform-origin:0 0">
                            <div class="g-recaptcha" data-sitekey="6LeAQAgrAAAAAEIzUoydZx4MiA3sE6v0eE22Yr0l"></div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-check text-start mt-2 mb-2">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                        <label class="form-check-label text-color-1 font-paragraph" for="agreeTerms" style="font-size: 0.9rem;">
                            I agree to the  
                            <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal" class="font-paragraph text-decoration-none text-color-1 fw-semibold text-underline-left-to-right">Terms and Conditions</a>
                        </label>
                    </div>

                    <button id="loginButton" type="submit" class="login-button">
                        <span id="loginText" class="fw-bold">LOG IN</span>
                        <span id="loadingText" class="d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>
                            <span id="dynamicLoadingText">Please wait...</span>
                        </span>
                    </button>
                    <!-- Privacy Policy Modal -->
                    <div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="margin-top: 8vh;"> <!-- Adjust margin-top as needed -->
                            <div class="modal-content rounded-4 border-0" style="background-color: #f9f9f9;">

                            <!-- Header -->
                            <div class="modal-header bg-success text-white rounded-top-4 py-3">
                                <h5 class="modal-title fw-bold" id="privacyPolicyLabel">Terms and Conditions</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body d-flex flex-column px-4 py-3" style="max-height: 70vh; overflow-y: auto;">
                                <div class="text-start">
                                    <h5 class="fw-bold text-success mb-4">Terms and Conditions</h5>
                                    
                                    <div class="mb-4">
                                        <p class="fw-bold mb-2">Reservation Agreement</p>
                                        <p>By confirming a reservation, guests acknowledge and agree to all terms and conditions set by Lelo's Resort management.</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="fw-bold mb-2">Payment Policy</p>
                                        <ul class="list-unstyled ps-3">
                                            <li>• Full payment is required in advance to secure the reservation.</li>
                                            <li>• All payments are strictly non-refundable, regardless of:</li>
                                            <ul class="ps-4">
                                                <li>- Cancellations</li>
                                                <li>- Date changes</li>
                                                <li>- Late arrivals</li>
                                                <li>- Early departures</li>
                                                <li>- No-shows</li>
                                                <li>- Weather disturbances</li>
                                                <li>- Any other unforeseen events</li>
                                            </ul>
                                        </ul>
                                        <p class="mt-2">Guests are strongly advised to finalize their plans before confirming a reservation.</p>
                                    </div>

                                    <div class="mb-4">
                                        <p class="fw-bold mb-2">Security Deposit</p>
                                        <ul class="list-unstyled ps-3">
                                            <li>• A security deposit equivalent to 50% of the total booking amount must be provided upon check-in.</li>
                                            <li>• This deposit covers:</li>
                                            <ul class="ps-4">
                                                <li>- Potential damages to resort property</li>
                                                <li>- Loss of items</li>
                                                <li>- Violations of resort rules</li>
                                            </ul>
                                            <li>• The deposit is fully refundable upon check-out if no issues are found after inspection.</li>
                                            <li>• Deductions will be made for any damages or violations, and excess charges will be billed to the guest.</li>
                                        </ul>
                                    </div>

                                    <div class="mb-4">
                                        <p class="fw-bold mb-2">Check-in/Check-out Policy</p>
                                        <ul class="list-unstyled ps-3">
                                            <li>• Guests must follow scheduled check-in and check-out times.</li>
                                            <li>• Early check-in or late check-out is subject to availability and may incur additional charges.</li>
                                        </ul>
                                    </div>

                                    <div class="mb-4">
                                        <p class="fw-bold mb-2">Guest Conduct</p>
                                        <ul class="list-unstyled ps-3">
                                            <li>• Guests must behave responsibly and follow all resort guidelines.</li>
                                            <li>• Respect towards other guests and staff is expected at all times.</li>
                                        </ul>
                                    </div>

                                    <div class="mb-4">
                                        <p class="fw-bold mb-2">Right to Refuse Service</p>
                                        <ul class="list-unstyled ps-3">
                                            <li>• Lelo's Resort reserves the right to refuse service or evict any guest who:</li>
                                            <ul class="ps-4">
                                                <li>- Violates the terms and conditions</li>
                                                <li>- Engages in disruptive or inappropriate behavior</li>
                                            </ul>
                                            <li>• No refund will be given in such cases.</li>
                                        </ul>
                                    </div>

                                    <div class="text-center mt-4">
                                        <p class="fw-bold mb-1">Contact Information</p>
                                        <p>For more details, contact us at <a href="mailto:lelosresort@gmail.com" class="text-decoration-none fw-bold text-success">lelosresort@gmail.com</a></p>
                                    </div>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>

                    <p class="text-center mt-2 text-color-1 font-paragraph" style="font-size: 0.85rem;">
                        Don't have an account? 
                        <a href="{{ route('signup') }}" class="text-color-1 ms-1 text-decoration-none text-hover-effect">Sign Up</a>
                    </p>

                    <a href="{{ route('google.redirect') }}" class="text-white font-paragraph text-decoration-none fw-bold">
                        <div class="d-flex justify-content-center align-items-center bg-success p-3 rounded-4 google"
                             style="font-size: 0.9rem;">
                            <img src="{{ asset('images/google.png') }}" alt="" width="16" height="16" class="me-2"> 
                            Sign In using Google
                        </div>
                    </a>
                </form>
            </div>

            <!-- Right Side: Image -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('images/labasneto.JPG') }}" alt="Login Image" class="img-fluid rounded-4" style="height: 65vh;">
            </div>
        </div>
    </div>
</div>

<!-- OTP Modal (Bootstrap 5) -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">OTP Verification</h5>
      </div>
      <div class="modal-body">
        <p>Enter the 6-digit OTP sent to <strong>{{ session('otp_email') }}</strong></p>
        <form id="otpForm" action="{{ route('verifyOTP') }}" method="POST">
          @csrf
          <input type="hidden" name="user_id" value="{{ session('otp_user_id') }}">
          <div class="mb-3">
            <input type="text" name="otp" class="form-control" placeholder="123456" required>
          </div>
          <button type="submit" class="btn btn-primary">Verify</button>
        </form>
      </div>
    </div>
  </div>
</div>

    @if(session('show_otp_modal'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Kunin ang value ng credential input mula sa previous submission (old input)
                var credential = "{{ old('credential') }}";
                // Regex para sa email format
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                // Ipakita lang ang OTP modal kung email format ang input
                if(emailPattern.test(credential)) {
                    var otpModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
                    otpModal.show();
                    document.getElementById('otpEmail').textContent = "{{ session('otp_email') }}";
                    document.getElementById('otpEmailInput').value = "{{ session('otp_email') }}";
                }
            });
        </script>
    @endif

    <!-- OTP Verification Modal -->
    <div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-labelledby="otpVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpVerificationModalLabel">OTP Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(session('success'))
                    <div class="alert alert-success fade show" role="alert" id="successAlert">
                        {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('successAlert').style.animation = 'fadeOut 0.5s';
                            setTimeout(function() {
                                document.getElementById('successAlert').remove();
                            }, 500);
                        }, 5000);
                    </script>
                @endif
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <p>Please enter the OTP code sent to your email</p>
                        <p class="text-muted" id="otpEmail"></p>
                    </div>
                    
                    <form id="otpVerificationForm" method="POST" action="{{ route('verify-login-otp') }}">
                        @csrf
                        <input type="hidden" name="email" id="otpEmailInput">
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-center">
                                <input type="text" class="form-control text-center" maxlength="6" name="otp" style="width: 200px;" placeholder="Enter 6-digit OTP">
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Verify OTP</button>
                            <button type="button" class="btn btn-outline-secondary" id="resendOTP">
                                Resend OTP <span id="countdown" class="d-none">(60s)</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content rounded-4 border-0" style="background-color: #f8f9fa;">

            <!-- HEADER -->
            <div class="modal-header bg-success text-white py-3 rounded-top-4">
                <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-4">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('forgot.reset') }}" method="POST" id="passwordResetForm">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <!-- EMAIL -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-success">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                </div>

                <!-- OTP -->
                <div class="mb-3">
                    <label for="otp" class="form-label fw-bold text-success">OTP Code</label>
                    <div class="d-flex">
                        <div class="position-relative w-100">
                            <input type="number" class="form-control me-2" name="otp" id="otp" placeholder="Enter OTP" required maxlength="6" oninput="validateOTP(this.value)">
                            <div id="otpValidationMessage" class="position-absolute" style="top: 100%; left: 0; font-size: 0.8rem;" hidden></div>
                        </div>
                        <button type="button" id="sendOTPBtn" class="btn btn-success text-center mx-auto d-block ms-2" style="font-size: 10px; height: 50px;" onclick="sendOTP()">Send OTP</button>
                    </div>
                </div>

                <!-- Hidden password fields initially -->
                <div id="passwordFields" style="display: none;">
                    <!-- NEW PASSWORD -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-success">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="newPassword" placeholder="Enter new password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword" style="height: 50px;">
                                <i class="fas fa-eye" id="newPasswordIcon"></i>
                            </button>
                        </div>
                        <div class="password-strength mt-2">
                            <div class="progress" style="height: 5px;">
                                <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small id="passwordHelp" class="form-text text-muted"></small>
                        </div>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold text-success">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" placeholder="Confirm your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" style="height: 50px;">
                                <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="mt-2"></div>
                    </div>

                    <script>
                        // Toggle visibility for new password
                        document.getElementById('toggleNewPassword').addEventListener('click', function() {
                            const input = document.getElementById('newPassword');
                            const icon = document.getElementById('newPasswordIcon');
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        });

                        // Toggle visibility for confirm password
                        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                            const input = document.getElementById('confirmPassword');
                            const icon = document.getElementById('confirmPasswordIcon');
                            if (input.type === 'password') {
                                input.type = 'text';
                                icon.classList.remove('fa-eye');
                                icon.classList.add('fa-eye-slash');
                            } else {
                                input.type = 'password';
                                icon.classList.remove('fa-eye-slash');
                                icon.classList.add('fa-eye');
                            }
                        });
                    </script>

                    <!-- SUBMIT BUTTON -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2" id="submitBtn" disabled>
                        Reset Password
                        </button>
                    </div>
                </div>

                </form>
            </div>

            </div>
        </div>
    </div>
<!-- Reset pass -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const passwordMatch = document.getElementById('passwordMatch');
    const submitBtn = document.getElementById('submitBtn');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordHelp = document.getElementById('passwordHelp');

    // Real-time password matching check
    confirmPassword.addEventListener('input', checkPasswordMatch);
    newPassword.addEventListener('input', checkPasswordMatch);
    newPassword.addEventListener('input', checkPasswordStrength);

    function checkPasswordMatch() {
        if (newPassword.value && confirmPassword.value) {
            if (newPassword.value === confirmPassword.value) {
                passwordMatch.innerHTML = '<small class="text-success">Passwords match!</small>';
                submitBtn.disabled = false;
            } else {
                passwordMatch.innerHTML = '<small class="text-danger">Passwords do not match!</small>';
                submitBtn.disabled = true;
            }
        } else {
            passwordMatch.innerHTML = '';
            submitBtn.disabled = true;
        }
    }

    function checkPasswordStrength() {
        const strength = calculatePasswordStrength(newPassword.value);
        passwordStrength.style.width = strength.percentage + '%';
        
        if (strength.percentage < 40) {
            passwordStrength.className = 'progress-bar bg-danger';
            passwordHelp.textContent = 'Weak password';
        } else if (strength.percentage < 70) {
            passwordStrength.className = 'progress-bar bg-warning';
            passwordHelp.textContent = 'Moderate password';
        } else {
            passwordStrength.className = 'progress-bar bg-success';
            passwordHelp.textContent = 'Strong password';
        }
    }

    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength += 30;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/[a-z]/.test(password)) strength += 20;
        if (/[0-9]/.test(password)) strength += 20;
        if (/[^A-Za-z0-9]/.test(password)) strength += 10;
        
        return {
            percentage: Math.min(strength, 100)
        };
    }
});
</script>
<!-- Forgot password Modal -->
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
    // Google login success callback
    function handleGoogleLogin(response) {
    fetch('/auth/google/callback', {
        method: 'GET',
        headers: {
        'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.otp_required) {
        // Ipakita ang modal
        const modal = new bootstrap.Modal(document.getElementById('otpModal'));
        document.getElementById('userEmail').textContent = data.email;
        document.getElementById('userId').value = data.user_id;
        modal.show();
        } else {
        window.location.href = '/calendar'; // Redirect kung walang OTP
        }
    });
    }

    // OTP verification
    function verifyOTP() {
    const formData = new FormData(document.getElementById('otpForm'));
    
    fetch('/verify-otp', {
        method: 'POST',
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
        window.location.href = '/calendar'; // Redirect pag successful
        } else {
        alert('Invalid OTP!'); // I-show ang error
        }
    });
    }
</script>
<!-- Verfication Modal After clicking the Login Button-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const userCredential = document.getElementById('userCredential').value;
            const password = document.getElementById('passwordField').value;
            const agreeTerms = document.getElementById('agreeTerms').checked;
            
            // Validate required fields
            if (!userCredential || !password) {
                alert('Fill up all the fields.');
                return;
            }

            // Check if terms are agreed
            if (!agreeTerms) {
                alert('Check the box to agree to the terms.');
                return;
            }
            
            // Check kung email ang ginamit
            const isEmail = userCredential.includes('@');
            
            if (isEmail) {
                try {
                    // Update button text and disable it
                    const loginButton = document.getElementById('loginButton');
                    const loginText = loginButton.querySelector('span');
                    loginButton.disabled = true;
                    loginText.textContent = 'SENDING OTP PLEASE WAIT';

                    // Send OTP request
                    const response = await fetch('{{ route("send-login-otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: `email=${encodeURIComponent(userCredential)}&password=${encodeURIComponent(password)}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show OTP modal
                        const otpModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
                        document.getElementById('otpEmail').textContent = userCredential;
                        document.getElementById('otpEmailInput').value = userCredential;
                        otpModal.show();
                    } else {
                        alert(data.message || 'Hindi matagumpay ang pagpapadala ng OTP. Pakisubukan muli.');
                    }

                    // Reset button after response
                    loginButton.disabled = false;
                    loginText.textContent = 'LOG IN';
                } catch (error) {
                    console.error('Error:', error);
                    alert('May naganap na error. Pakisubukan muli.');
                    
                    // Reset button on error
                    const loginButton = document.getElementById('loginButton');
                    const loginText = loginButton.querySelector('span');
                    loginButton.disabled = false;
                    loginText.textContent = 'LOG IN';
                }
            } else {
                // Para sa username login, direct submit
                this.submit();
            }
        });
    }

    // Resend OTP functionality
    const resendOTPButton = document.getElementById('resendOTP');
    if (resendOTPButton) {
        resendOTPButton.addEventListener('click', async function() {
            const email = document.getElementById('otpEmailInput').value;
            
            try {
                const response = await fetch('{{ route("resend-login-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: `email=${encodeURIComponent(email)}`
                });

                const data = await response.json();

                if (data.success) {
                    alert('OTP has been sent succesfully.');
                    
                    // Start countdown
                    this.disabled = true;
                    let countdown = 60;
                    const countdownSpan = document.getElementById('countdown');
                    countdownSpan.classList.remove('d-none');
                    
                    const timer = setInterval(() => {
                        countdown--;
                        countdownSpan.textContent = `(${countdown}s)`;
                        if (countdown <= 0) {
                            clearInterval(timer);
                            this.disabled = false;
                            countdownSpan.classList.add('d-none');
                        }
                    }, 1000);
                } else {
                    alert(data.message || 'Failed to send OTP.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error sending OTP.Please try again.');
            }
        });
    }
});
</script>

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
    // Google login success callback
    function handleGoogleLogin(response) {
    fetch('/auth/google/callback', {
        method: 'GET',
        headers: {
        'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.otp_required) {
        // Ipakita ang modal
        const modal = new bootstrap.Modal(document.getElementById('otpModal'));
        document.getElementById('userEmail').textContent = data.email;
        document.getElementById('userId').value = data.user_id;
        modal.show();
        } else {
        window.location.href = '/calendar'; // Redirect kung walang OTP
        }
    });
    }

    // OTP verification
    function verifyOTP() {
    const formData = new FormData(document.getElementById('otpForm'));
    
    fetch('/verify-otp', {
        method: 'POST',
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
        window.location.href = '/calendar'; // Redirect pag successful
        } else {
        alert('Invalid OTP!'); // I-show ang error
        }
    });
    }
</script>
<!-- Verfication Modal After clicking the Login Button-->
<script>
document.getElementById('login-form').addEventListener('submit', function(e) {
    const loginText = document.getElementById('loginText');
    const loadingText = document.getElementById('loadingText');
    const dynamicLoadingText = document.getElementById('dynamicLoadingText');
    const userCredential = document.getElementById('userCredential').value;
    
    loginText.classList.add('d-none');
    loadingText.classList.remove('d-none');
    
    // Check if input is email using regex and set loading text
    dynamicLoadingText.textContent = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(userCredential) 
        ? 'Sending OTP...' 
        : 'Please wait...';
    
    // Kung email, ipakita ang OTP verification
    const modalBody = document.querySelector('#otpModal .modal-body');
    const sendingAlert = document.createElement('div');
    sendingAlert.className = 'alert alert-info text-center';
    sendingAlert.textContent = 'Sending OTP...';
    modalBody.insertBefore(sendingAlert, modalBody.firstChild);
    
    function sendLoginOTP(email, password) {
        const sendingAlert = document.createElement('div');
        sendingAlert.className = 'alert alert-info text-center';
        sendingAlert.innerHTML = '<span id="loadingText" class="loading-text">Sending OTP please wait... <i class="fas fa-circle-notch fa-spin"></i></span>';
        
        const modalBody = document.querySelector('#otpVerificationModal .modal-body');
        modalBody.insertBefore(sendingAlert, modalBody.firstChild);

        fetch('{{ route("send-login-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                email: email,
                password: password  // Include password in the request
            })
        })
        .then(response => response.json())
        .then(data => {
            sendingAlert.remove();
            
            if (data.success) {
                alert('OTP has been sent successfully to your email!');
                startResendCountdown();
            } else {
                // Close the OTP modal if credentials are invalid
                if (data.message === 'Invalid email or password.') {
                    bootstrap.Modal.getInstance(document.getElementById('otpVerificationModal')).hide();
                }
                alert(data.message || 'Failed to send OTP. Please try again.');
            }
        })
        .catch(error => {
            sendingAlert.remove();
            console.error('Error sending OTP:', error);
            alert('An error occurred while sending OTP. Please try again.');
        });
    }
    
    // Resend OTP button functionality
    const resendOTPButton = document.getElementById('resendOTP');
    resendOTPButton.addEventListener('click', function() {
        const email = document.getElementById('otpEmailInput').value;
        sendLoginOTP(email);
    });
    
    // Countdown timer for resend button
    function startResendCountdown() {
        const countdownElement = document.getElementById('countdown');
        const resendButton = document.getElementById('resendOTP');
        
        resendButton.disabled = true;
        countdownElement.classList.remove('d-none');
        
        let seconds = 60;
        countdownElement.textContent = `(${seconds}s)`;
        
        const countdownInterval = setInterval(() => {
            seconds--;
            countdownElement.textContent = `(${seconds}s)`;
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                resendButton.disabled = false;
                countdownElement.classList.add('d-none');
            }
        }, 1000);
    }
    
    // OTP verification form submission
    const otpForm = document.getElementById('otpForm');
    if (otpForm) {
        otpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Disable button and show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Verifying...
            `;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'alert alert-success text-center mb-3';
                    successDiv.innerHTML = 'OTP verified successfully! Redirecting...';
                    this.insertBefore(successDiv, this.firstChild);
                    
                    // Redirect after short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '/dashboard';
                    }, 1500);
                } else {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Verify OTP';
                    alert(data.message || 'Invalid OTP. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error verifying OTP:', error);
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = 'Verify OTP';
                alert('An error occurred while verifying OTP. Please try again.');
            });
        });
// Add resend OTP functionality
let resendTimer;
let resendCountdown = 60;

function startResendTimer() {
    const resendButton = document.getElementById('resendOTP');
    const countdownSpan = document.getElementById('countdown');
    
    resendButton.disabled = true;
    countdownSpan.classList.remove('d-none');
    
    resendTimer = setInterval(() => {
        resendCountdown--;
        countdownSpan.textContent = `(${resendCountdown}s)`;
        
        if (resendCountdown <= 0) {
            clearInterval(resendTimer);
            resendButton.disabled = false;
            countdownSpan.classList.add('d-none');
            resendCountdown = 60;
        }
    }, 1000);
}

function resendOTP() {
    const email = document.getElementById('otpEmailInput').value;
    const resendButton = document.getElementById('resendOTP');
    
    resendButton.disabled = true;
    
    fetch('{{ route("resend-login-otp") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('New OTP has been sent to your email!');
            startResendTimer();
        } else {
            alert(data.message || 'Failed to resend OTP. Please try again.');
            resendButton.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error resending OTP:', error);
        alert('An error occurred while resending OTP. Please try again.');
        resendButton.disabled = false;
    });
}

// Add event listener for resend button
document.getElementById('resendOTP').addEventListener('click', resendOTP);

// Start initial timer when OTP is first sent
startResendTimer();

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    const passwordFields = document.getElementById('passwordFields');
    
    // Listen for input in OTP field
    otpInput.addEventListener('input', function() {
        // Check if OTP has 6 digits
        if (this.value.length === 6) {
            // Show password fields with fade-in animation
            passwordFields.style.display = 'block';
            passwordFields.style.opacity = '0';
            setTimeout(() => {
                passwordFields.style.opacity = '1';
                passwordFields.style.transition = 'opacity 0.3s ease-in-out';
            }, 50);
        } else {
            // Hide password fields if OTP is incomplete
            passwordFields.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
