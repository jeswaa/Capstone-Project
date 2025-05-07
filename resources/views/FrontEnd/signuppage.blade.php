<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url("{{ asset('images/logosheesh.png') }}") no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        body::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20vh;
            background: linear-gradient(to top, rgba(0, 93, 59, 0.8), transparent);
            pointer-events: none;
        }

        .signup-button {
            background-color: #0B5D3B;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
            padding: 5px 10px;
            border: none;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            cursor: pointer;
            margin: 0 auto;
        }

        .signup-button .arrow {
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

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            font-weight: bold;
            color: #0B5D3B;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
        @if (session('success'))
                <div class="alert alert-success text-center" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-center" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="position-absolute top-0 start-0 mt-4 ms-5">
        <a href="{{ url('/') }}" class="d-flex align-items-center justify-content-center rounded-circle shadow"
        style="width: 45px; height: 45px; background-color: #0B5D3B; text-decoration: none;">
            <i class="fa-solid fa-arrow-left text-white fs-4"></i>
        </a>
    </div>

    <div class="position-absolute top-0 end-0 mt-1 me-5">
        <a href="{{ url('/') }}" class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill">
        </a>
    </div>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container p-4 shadow-lg rounded-4 bg-white" style="max-width: 1000px;">
            <div class="row align-items-center">

                <!-- Left Side: Signup Form -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center w-100 mb-3">
                        <p class="text-success font-paragraph mx-auto fs-2 text-center fw-bold">Create an Account</p>
                    </div>

                    <form id="signup-form" class="w-100">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="mb-3">
                            <input type="text" class="form-control p-2 font-paragraph" id="name" name="name" placeholder="Full Name..." required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control p-2 font-paragraph" id="email" name="email" placeholder="Email..." required>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control p-2 font-paragraph" id="mobileNo" name="mobileNo" placeholder="Mobile Number..." required>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" class="form-control p-2 font-paragraph" id="password" name="password" placeholder="Password..." required oninput="checkPasswordMatch()">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div id="passwordStrength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="passwordHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="input-group">
                                <input type="password" class="form-control p-2 font-paragraph" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password..." required oninput="checkPasswordMatch()">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            <!-- Password Match Indicator -->
                            <div id="passwordMatchMessage" class="mt-1">
                                <small class="text-muted"></small>
                            </div>
                        </div>

                        <script>
                            document.getElementById('togglePassword').addEventListener('click', function() {
                                const passwordInput = document.getElementById('password');
                                const icon = this.querySelector('i');
                                
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordInput.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });

                            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                                const confirmPasswordInput = document.getElementById('password_confirmation');
                                const icon = this.querySelector('i');
                                
                                if (confirmPasswordInput.type === 'password') {
                                    confirmPasswordInput.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    confirmPasswordInput.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            
                            function checkPasswordMatch() {
                                const password = document.getElementById('password');
                                const confirmPassword = document.getElementById('password_confirmation');
                                const matchMessage = document.getElementById('passwordMatchMessage').querySelector('small');
                                const signupBtn = document.getElementById('signup-btn');

                                if (confirmPassword.value === '') {
                                    matchMessage.textContent = '';
                                    matchMessage.className = 'text-muted';
                                    signupBtn.disabled = true;
                                    return;
                                }

                                if (password.value === confirmPassword.value) {
                                    matchMessage.textContent = 'Passwords match';
                                    matchMessage.className = 'text-success';
                                    signupBtn.disabled = false;
                                } else {
                                    matchMessage.textContent = 'Password does not match';
                                    matchMessage.className = 'text-danger';
                                    signupBtn.disabled = true;
                                }
                            }
                        </script>

                        <div class="mt-3 text-center">
                            <button type="submit" id="signup-btn" class="signup-button">
                                SIGN-UP
                                <span class="arrow d-flex align-items-center justify-content-center rounded-circle">
                                    &rsaquo;
                                </span>
                            </button>

                            <hr style="border-top: 1px solid #0B5D3B; width: 80%; margin: 15px auto;">

                            <p class="login-link">
                                Already have an account? 
                                <a href="{{ url('/login') }}">Log in here</a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Right Side: Image -->
                <div class="col-md-6 d-none d-md-block">
                    <img src="{{ asset('images/labasneto.JPG') }}" alt="Login Image" class="img-fluid rounded-4" style="height: 65vh;">
                </div>
            </div>
        </div>
    </div>


<!-- OTP Verification Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0" style="background-color: #f9f9f9;">

      <!-- Header -->
      <div class="modal-header bg-success text-white rounded-top-4 py-3">
        <h5 class="modal-title fw-bold" id="otpModalLabel">Verify Your Email</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body px-4 py-3">
        <p class="text-success mb-3" style="font-size: 1rem;">
          We've sent a 6-digit OTP to your email. Please enter it below to verify your account.
        </p>
        <input type="text" id="otp" class="form-control p-2 border-success" placeholder="Enter OTP" maxlength="6" style="font-weight: 500;">
      </div>

      <!-- Footer -->
      <div class="modal-footer border-0 px-4 pb-4">
        <button type="button" id="verify-otp" class="btn btn-success fw-bold px-4 py-2 w-100">
          Verify OTP
        </button>
      </div>

    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Handle signup button click
    $('#signup-btn').click(function(event) {
        event.preventDefault(); // Prevent form submission

        // Disable the signup button and show loading message
        $('#signup-btn').prop('disabled', true);
        $('#signup-btn').html(`
            <div class="d-flex align-items-center">
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Sending OTP. Please wait...
            </div>
        `);

        let formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            mobileNo: $('#mobileNo').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: "{{ url('/signup/send-otp') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                // Reset button state
                $('#signup-btn').prop('disabled', false);
                $('#signup-btn').html(`
                    SIGN-UP
                    <span class="arrow d-flex align-items-center justify-content-center rounded-circle">
                        &rsaquo;
                    </span>
                `);
                
                alert(response.message);
                $('#otpModal').modal('show'); // Show OTP modal
            },
            error: function(xhr) {
                // Reset button state
                $('#signup-btn').prop('disabled', false);
                $('#signup-btn').html(`
                    SIGN-UP
                    <span class="arrow d-flex align-items-center justify-content-center rounded-circle">
                        &rsaquo;
                    </span>
                `);
                
                handleAjaxError(xhr);
            }
        });
    });

    // Handle OTP verification
    $('#verify-otp').click(function(event) {
        event.preventDefault(); // Prevent default action

        let formData = {
            email: $('#email').val(),
            otp: $('#otp').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: "{{ url('/signup/verify-otp') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                alert(response.message);
                window.location.href = "{{ url('/login') }}"; // Redirect to login page
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.error || "Invalid OTP");
            }
        });
    });

    // Handle AJAX errors
    function handleAjaxError(xhr) {
        if (xhr.status === 422) {
            let errors = xhr.responseJSON.errors;
            let errorMessage = Object.values(errors).map(e => e[0]).join("\n");
            alert(errorMessage);
        } else {
            alert("Something went wrong. Please try again.");
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const newPassword = document.getElementById('newPassword') || document.getElementById('password'); // fallback if using a single input
    const confirmPassword = document.getElementById('confirmPassword');
    const passwordMatch = document.getElementById('passwordMatch');
    const submitBtn = document.getElementById('submitBtn');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordHelp = document.getElementById('passwordHelp');

    // Event listeners
    if (newPassword) {
        newPassword.addEventListener('input', () => {
            checkPasswordStrength(newPassword.value);
            checkPasswordMatch();
        });
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', checkPasswordMatch);
    }

    function checkPasswordMatch() {
        if (!newPassword || !confirmPassword || !passwordMatch || !submitBtn) return;

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

    function checkPasswordStrength(password) {
        if (!passwordStrength || !passwordHelp) return;

        const strength = calculatePasswordStrength(password);
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



</script>
</body>
</html>
