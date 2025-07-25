<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lelo's Resort</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1,
        h5 {
            font-family: 'Anton', sans-serif;
        }

        body,
        p,
        h6,
        li,
        span {
            font-family: 'Montserrat', sans-serif;
        }

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

        .text-color-1 {
            color: #4a4a4a !important;
        }
        .email-validation-message {
            font-size: 0.8rem;
            margin-top: 0.25rem;
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
            transition: opacity 0.3s ease; /* Smooth transition */
        }

        /* Bootstrap's disabled opacity */
        .signup-button:disabled {
            opacity: 0.65;
            pointer-events: none;
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
    </style>
</head>

<body>
    @include('Alert.loginSuccessUser')
    @include('Alert.errornotification')

    <div class="container-fluid position-relative">
        <div class="row">
            <div class="col-12">
                <div class="position-absolute top-0 start-0 mt-5 ms-5">
                    <a href="{{ url('login') }}" class="d-flex align-items-center justify-content-center rounded-circle shadow"
                        style="width: 45px; height: 45px; background-color: #0B5D3B; text-decoration: none;">
                        <i class="fa-solid fa-arrow-left text-white fs-4"></i>
                    </a>
                </div>

                <div class="position-absolute top-0 end-0 mt-3 me-5">
                    <a href="{{ url('/') }}" class="text-decoration-none">
                        <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; margin-top: 80px;">
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
                            <input type="text" class="form-control p-2 font-paragraph" id="name" name="name"
                                placeholder="Full Name..." required maxlength="50"
                                oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '').slice(0, 30);" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control p-2 font-paragraph" id="email" name="email"
                                placeholder="Email..." required maxlength="50"
                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                title="Please enter a valid email address"
                                oninput="this.value = this.value.toLowerCase().slice(0, 30);">
                            <div id="emailValidationMessage" class="email-validation-message">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control p-2 font-paragraph" id="mobileNo" name="mobileNo"
                                    placeholder="Mobile Number..." required maxlength="11"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);"
                                    pattern="\d{11}" title="Please enter a valid 11-digit mobile number" required> 
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="password" class="form-control p-2 font-paragraph" id="password"
                                    name="password" placeholder="Password..." required oninput="checkPasswordMatch()"
                                    maxlength="20" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="height:42px;">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div id="passwordStrength" class="progress-bar" role="progressbar"
                                        style="width: 0%"></div>
                                </div>
                                <small id="passwordHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="input-group">
                                <input type="password" class="form-control p-2 font-paragraph"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirm Password..." required oninput="checkPasswordMatch()"
                                    maxlength="20" required>
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword"  style="height:42px;">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                            <!-- Password Match Indicator -->
                            <div id="passwordMatchMessage" class="mt-1">
                                <small class="text-muted"></small>
                            </div>
                        </div>

                        <div class="form-check text-start mt-2 mb-2">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                            <label class="form-check-label text-color-1 font-paragraph" for="agreeTerms"
                                style="font-size: 0.9rem;">
                                I agree to the
                                <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal"
                                    class="font-paragraph text-decoration-none text-color-1 fw-semibold text-underline-left-to-right">Terms
                                    and Conditions</a>
                            </label>
                        </div>

                        <!-- Privacy Policy Modal -->
                        <div class="modal fade" id="privacyPolicyModal" tabindex="-1"
                            aria-labelledby="privacyPolicyLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" style="margin-top: 8vh;">
                                <!-- Adjust margin-top as needed -->
                                <div class="modal-content rounded-4 border-0" style="background-color: #f9f9f9;">

                                    <!-- Header -->
                                    <div class="modal-header bg-success text-white rounded-top-4 py-3">
                                        <h5 class="modal-title fw-bold" id="privacyPolicyLabel">Terms and Conditions
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <!-- Body -->
                                    <div class="modal-body d-flex flex-column px-4 py-3"
                                        style="max-height: 70vh; overflow-y: auto;">
                                        <div class="text-start">
                                            <h5 class="fw-bold text-success mb-4">Terms and Conditions</h5>

                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Reservation Agreement</p>
                                                <p>By confirming a reservation, guests acknowledge and agree to all
                                                    terms and conditions set by Lelo's Resort management.</p>
                                            </div>

                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Payment Policy</p>
                                                <ul class="list-unstyled ps-3">
                                                    <li>• Full payment is required in advance to secure the reservation.
                                                    </li>
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
                                                <p class="mt-2">Guests are strongly advised to finalize their plans
                                                    before confirming a reservation.</p>
                                            </div>

                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Security Deposit</p>
                                                <ul class="list-unstyled ps-3">
                                                    <li>• A security deposit equivalent to 50% of the total booking
                                                        amount must be provided upon check-in.</li>
                                                    <li>• This deposit covers:</li>
                                                    <ul class="ps-4">
                                                        <li>- Potential damages to resort property</li>
                                                        <li>- Loss of items</li>
                                                        <li>- Violations of resort rules</li>
                                                    </ul>
                                                    <li>• The deposit is fully refundable upon check-out if no issues
                                                        are found after inspection.</li>
                                                    <li>• Deductions will be made for any damages or violations, and
                                                        excess charges will be billed to the guest.</li>
                                                </ul>
                                            </div>

                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Check-in/Check-out Policy</p>
                                                <ul class="list-unstyled ps-3">
                                                    <li>• Guests must follow scheduled check-in and check-out times.
                                                    </li>
                                                    <li>• Early check-in or late check-out is subject to availability
                                                        and may incur additional charges.</li>
                                                </ul>
                                            </div>

                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Guest Conduct</p>
                                                <ul class="list-unstyled ps-3">
                                                    <li>• Guests must behave responsibly and follow all resort
                                                        guidelines.</li>
                                                    <li>• Respect towards other guests and staff is expected at all
                                                        times.</li>
                                                </ul>
                                            </div>

                                            <div class="mb-4">
                                                <p class="fw-bold mb-2">Right to Refuse Service</p>
                                                <ul class="list-unstyled ps-3">
                                                    <li>• Lelo's Resort reserves the right to refuse service or evict
                                                        any guest who:</li>
                                                    <ul class="ps-4">
                                                        <li>- Violates the terms and conditions</li>
                                                        <li>- Engages in disruptive or inappropriate behavior</li>
                                                    </ul>
                                                    <li>• No refund will be given in such cases.</li>
                                                </ul>
                                            </div>

                                            <div class="text-center mt-4">
                                                <p class="fw-bold mb-1">Contact Information</p>
                                                <p>For more details, contact us at <a
                                                        href="mailto:lelosresort@gmail.com"
                                                        class="text-decoration-none fw-bold text-success">lelosresort@gmail.com</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('togglePassword').addEventListener('click', function () {
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

                            document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
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
                            <button type="submit" id="signup-btn" class="signup-button" disabled>
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
                    <img src="{{ asset('images/labasneto.JPG') }}" alt="Login Image" class="img-fluid rounded-4"
                        style="height: 65vh;">
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-3">
                    <p class="text-success mb-3" style="font-size: 1rem;">
                        We've sent a 6-digit OTP to your email. Please enter it below to verify your account.
                    </p>
                    <input type="text" id="otp" class="form-control p-2 border-success" placeholder="Enter OTP"
                        maxlength="6" style="font-weight: 500;">
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
$(document).ready(function () {
    // Track last OTP request time (moved outside to persist)
    let lastOtpRequest = 0;
    const OTP_COOLDOWN = 60000; // 60 seconds cooldown

    // Handle form submission instead of button click
    $('#signup-form').submit(function (event) {
        event.preventDefault(); // This is crucial to prevent default form submission
        
        // Check if elements exist before proceeding
        const signupBtn = $('#signup-btn');
        const nameField = $('#name');
        const emailField = $('#email');
        const mobileField = $('#mobileNo');
        const passwordField = $('#password');
        const confirmPasswordField = $('#password_confirmation');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        if (!signupBtn.length || !nameField.length || !emailField.length || !passwordField.length) {
            console.error('Required form elements not found');
            alert('Form elements are missing. Please refresh the page.');
            return;
        }
        
        // Disable button and show loading state
        signupBtn.prop('disabled', true);
        signupBtn.html(`
            <div class="d-flex align-items-center">
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Sending OTP. Please wait...
            </div>
        `);

        let formData = {
            name: nameField.val() || '',
            email: emailField.val() || '',
            mobileNo: mobileField.val() || '',
            password: passwordField.val() || '',
            password_confirmation: confirmPasswordField.val() || '',
            _token: csrfToken || ''
        };

        // Validate required fields
        if (!formData.name || !formData.email || !formData.password) {
            resetSignupButton();
            alert('Please fill in all required fields');
            return;
        }

        // Check cooldown period
        const now = Date.now();
        if (now - lastOtpRequest < OTP_COOLDOWN) {
            resetSignupButton();
            alert("Please wait 60 seconds before requesting another OTP");
            return;
        }
        lastOtpRequest = now;

        $.ajax({
            url: "{{ url('/signup/send-otp') }}",
            method: "POST",
            data: formData,
            success: function (response, textStatus, xhr) {
                resetSignupButton();
                
                // Check if it's a redirect response (Laravel redirect)
                if (xhr.getResponseHeader('Content-Type') && xhr.getResponseHeader('Content-Type').includes('text/html')) {
                    // This means it's a redirect response, let's handle it
                    // Parse the response to check for success or error messages
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    
                    // Check for success message
                    const successAlert = doc.querySelector('.alert-success');
                    if (successAlert) {
                        alert(successAlert.textContent.trim());
                        $('#otpModal').modal('show');
                        return;
                    }
                    
                    // Check for error messages
                    const errorAlert = doc.querySelector('.alert-danger');
                    if (errorAlert) {
                        alert(errorAlert.textContent.trim());
                        return;
                    }
                    
                    // If no alerts found, assume success (fallback)
                    alert('OTP sent successfully! Please check your email.');
                    $('#otpModal').modal('show');
                } else {
                    // Handle JSON response (if any)
                    if (response && response.message) {
                        alert(response.message);
                        $('#otpModal').modal('show');
                    } else {
                        alert('OTP sent successfully');
                        $('#otpModal').modal('show');
                    }
                }
            },
            error: function (xhr) {
                resetSignupButton();
                
                // Handle validation errors from Laravel
                if (xhr.status === 422) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            let errorMessages = [];
                            for (const field in response.errors) {
                                if (response.errors[field] && Array.isArray(response.errors[field])) {
                                    errorMessages.push(response.errors[field][0]);
                                }
                            }
                            alert(errorMessages.join('\n'));
                        } else {
                            alert('Please check your input and try again.');
                        }
                    } catch (e) {
                        // If response is HTML (Laravel error page)
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(xhr.responseText, 'text/html');
                        const errorAlert = doc.querySelector('.alert-danger');
                        if (errorAlert) {
                            alert(errorAlert.textContent.trim());
                        } else {
                            alert('Please check your input and try again.');
                        }
                    }
                } else {
                    // Handle other errors
                    try {
                        const response = JSON.parse(xhr.responseText);
                        alert(response.error || response.message || 'Something went wrong. Please try again.');
                    } catch (e) {
                        alert('Something went wrong. Please try again.');
                    }
                }
            }
        });
    });

    // Function to reset signup button state
    function resetSignupButton() {
        const signupBtn = $('#signup-btn');
        if (signupBtn.length) {
            signupBtn.prop('disabled', false);
            signupBtn.html(`
                SIGN-UP
                <span class="arrow d-flex align-items-center justify-content-center rounded-circle">
                    &rsaquo;
                </span>
            `);
        }
    }

    // Handle OTP verification
    $('#verify-otp').click(function (event) {
        event.preventDefault(); // Prevent default action

        const emailField = $('#email');
        const otpField = $('#otp');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        if (!emailField.length || !otpField.length) {
            alert('Required fields are missing');
            return;
        }

        let formData = {
            email: emailField.val() || '',
            otp: otpField.val() || '',
            _token: csrfToken || ''
        };

        if (!formData.email || !formData.otp) {
            alert('Please enter both email and OTP');
            return;
        }

        // Disable button during processing
        const verifyBtn = $('#verify-otp');
        verifyBtn.prop('disabled', true);
        verifyBtn.text('Verifying...');

        $.ajax({
            url: "{{ url('/signup/verify-otp') }}",
            method: "POST",
            data: formData,
            success: function (response, textStatus, xhr) {
                // Check if it's a redirect response
                if (xhr.getResponseHeader('Content-Type') && xhr.getResponseHeader('Content-Type').includes('text/html')) {
                    // This is a redirect, which means success
                    alert('Account created successfully! You can now log in.');
                    window.location.href = "{{ url('/login') }}";
                } else {
                    // Handle JSON response
                    if (response && response.message) {
                        alert(response.message);
                    } else {
                        alert('OTP verified successfully');
                    }
                    window.location.href = "{{ url('/login') }}";
                }
            },
            error: function (xhr) {
                // Re-enable button
                verifyBtn.prop('disabled', false);
                verifyBtn.text('Verify OTP');
                
                if (xhr.status === 422) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            let errorMessages = [];
                            for (const field in response.errors) {
                                if (response.errors[field] && Array.isArray(response.errors[field])) {
                                    errorMessages.push(response.errors[field][0]);
                                }
                            }
                            alert(errorMessages.join('\n'));
                        } else {
                            alert('Invalid OTP. Please try again.');
                        }
                    } catch (e) {
                        alert('Invalid OTP. Please try again.');
                    }
                } else {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        alert(response.error || response.message || 'Invalid OTP. Please try again.');
                    } catch (e) {
                        alert('Invalid OTP. Please try again.');
                    }
                }
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const newPassword = document.getElementById('newPassword') || document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword') || document.getElementById('password_confirmation');
    const passwordMatch = document.getElementById('passwordMatch');
    const submitBtn = document.getElementById('submitBtn') || document.getElementById('signup-btn');
    const passwordStrength = document.getElementById('passwordStrength');
    const passwordHelp = document.getElementById('passwordHelp');

    // Event listeners
    if (newPassword) {
        newPassword.addEventListener('input', () => {
            if (passwordStrength && passwordHelp) {
                checkPasswordStrength(newPassword.value);
            }
            if (confirmPassword && passwordMatch) {
                checkPasswordMatch();
            }
        });
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (passwordMatch) {
                checkPasswordMatch();
            }
        });
    }

    function checkPasswordMatch() {
        if (!newPassword || !confirmPassword || !passwordMatch) return;

        if (newPassword.value && confirmPassword.value) {
            if (newPassword.value === confirmPassword.value) {
                passwordMatch.innerHTML = '<small class="text-success">Passwords match!</small>';
                if (submitBtn) submitBtn.disabled = false;
            } else {
                passwordMatch.innerHTML = '<small class="text-danger">Passwords do not match!</small>';
                if (submitBtn) submitBtn.disabled = true;
            }
        } else {
            passwordMatch.innerHTML = '';
            if (submitBtn) submitBtn.disabled = true;
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

// Form validation for required fields
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#signup-form') || document.querySelector('form');
    
    if (!form) return; // Exit if no form found
    
    const submitBtn = form.querySelector('button[type="submit"]') || document.getElementById('signup-btn');
    const requiredInputs = form.querySelectorAll('input[required]');
    
    if (!submitBtn || !requiredInputs.length) return; // Exit if elements not found
    
    function checkForm() {
        let allFilled = true;
        requiredInputs.forEach(input => {
            if (!input.value.trim()) allFilled = false;
        });
        submitBtn.disabled = !allFilled;
    }
    
    requiredInputs.forEach(input => {
        input.addEventListener('input', checkForm);
    });
    
    // Initial check on page load
    checkForm();
});
</script>
<script>
$(document).ready(function() {
    // Track email validity
    let isEmailValid = false;
    const $submitBtn = $('#signup-btn');
    
    // Email validation on blur (when leaving the field)
    $('#email').on('blur', function() {
        const email = $(this).val().trim();
        const emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
        const $validationMessage = $('#emailValidationMessage');
        
        // Clear previous messages and reset state
        $validationMessage.removeClass('text-success text-danger').text('');
        isEmailValid = false;
        updateSubmitButton();
        
        // Skip if empty
        if (!email) {
            return;
        }
        
        // Validate format first
        if (!emailRegex.test(email)) {
            $validationMessage.addClass('text-danger').text('Please enter a valid email address');
            return;
        }
        
        // Show checking message
        $validationMessage.addClass('text-muted').text('Checking email availability...');
        
        // Check if email exists
        $.ajax({
            url: "{{ route('check.email') }}",
            method: "POST",
            data: {
                email: email,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.exists) {
                    $validationMessage.removeClass('text-muted').addClass('text-danger')
                        .text('This email is already registered');
                    isEmailValid = false;
                } else {
                    $validationMessage.removeClass('text-muted').addClass('text-success')
                        .text('Email is available');
                    isEmailValid = true;
                }
                updateSubmitButton();
            },
            error: function() {
                $validationMessage.removeClass('text-muted').addClass('text-danger')
                    .text('Error checking email availability');
                isEmailValid = false;
                updateSubmitButton();
            }
        });
    });

    // Function to update submit button state
    function updateSubmitButton() {
        // Also check if all other required fields are filled
        let allFieldsValid = true;
        $('input[required]').each(function() {
            if (!$(this).val().trim()) {
                allFieldsValid = false;
                return false; // break loop
            }
        });
        
        // Check password match if both fields have values
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        const passwordsMatch = (password && confirmPassword && password === confirmPassword);
        
        // Check terms checkbox
        const termsChecked = $('#agreeTerms').is(':checked');
        
        // Update button state
        $submitBtn.prop('disabled', !(isEmailValid && allFieldsValid && passwordsMatch && termsChecked));
    }

    // Update button state when other fields change
    $('input[required]').on('input', updateSubmitButton);
    $('#password, #password_confirmation').on('input', updateSubmitButton);
    $('#agreeTerms').change(updateSubmitButton);
});
</script>
</body>
</html>