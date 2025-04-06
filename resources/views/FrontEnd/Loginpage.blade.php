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
        .flip-horizontal {
        display: inline-block;
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
    }
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

    </style>
</head>
<body>
    @include('Alert.errorLogin')
    <!-- Validations -->
    <div class="position-absolute top-0 end-0 mt-3 me-5" style="z-index: 9999;">
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


    
<div class="position-absolute top-0 start-0 mt-5 ms-5">
    <a href="{{ url('/') }}" class="d-flex align-items-center justify-content-center rounded-circle shadow text-decoration-none">
       <i class="fa-solid fa-circle-left fa-2x color-3 icon-hover"></i>
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

                    <div class="text-end">
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
    // Auto-show modal kapag may OTP requirement
    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('otpModal'));
      modal.show();
    });
  </script>
@endif


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
                <form action="{{ route('forgot.reset') }}" method="POST" class="p-3" id="passwordResetForm">
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
                        <input type="password" class="form-control font-paragraph" name="password" id="newPassword" placeholder="Enter new password" required>
                        <div class="password-strength mt-1">
                            <div class="progress" style="height: 5px;">
                                <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small id="passwordHelp" class="form-text text-muted"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label font-paragraph text-color-1">Confirm Password</label>
                        <input type="password" class="form-control font-paragraph" name="password_confirmation" id="confirmPassword" placeholder="Confirm your password" required>
                        <div id="passwordMatch" class="mt-1"></div>
                    </div>

                    <button type="submit" class="color-background6 p-2 border-0 text-hover-1 font-paragraph color-3 rounded-2 w-100" id="submitBtn" disabled>
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Modal for Staff/Admin (Bootstrap Version) -->
<div id="staffAdminModal" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Staff/Admin Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" name="role" required>
              <option value="">-- Select Role --</option>
              <option value="staff">Staff</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    // Ctrl + Shift + A to trigger modal
document.addEventListener('keydown', function(e) {
  if (e.ctrlKey && e.shiftKey && e.key === 'A') {
    e.preventDefault();
    const modal = new bootstrap.Modal(document.getElementById('staffAdminModal'));
    modal.show();
  }
});
// Prevent right-click, F12, Ctrl+Shift+I, etc.
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('keydown', e => {
  if (e.key === 'F12' || 
      (e.ctrlKey && e.shiftKey && e.key === 'I') || 
      (e.ctrlKey && e.shiftKey && e.key === 'J') ||
      (e.ctrlKey && e.key === 'U')) {
    e.preventDefault();
  }
});
</script>


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

</body>
</html>
