<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])        
</head>
<body class="color-background4">
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
    <div class="container mt-5">
    <div class="row">
        <!-- Left Side: Signup Form -->
        <div class="col-lg-6 col-md-8 col-sm-10 mx-auto mx-lg-0">
            <div class="signup-form d-flex flex-column align-items-start p-4">
                <!-- Back Button & Title in One Row -->
                <div class="d-flex justify-content-between align-items-center w-100 mb-5">
                    <!-- Back Button -->
                    <a href="{{ route('login') }}">
                        <i class="fa-solid fa-circle-left fa-2x color-3 icon-hover"></i>
                    </a>
                    <!-- Centered Title -->
                    <h1 class="text-color-1 font-paragraph mx-auto mb-3">Create an Account</h1>
                </div>

                <!-- Signup Form -->
                <form id="signup-form" class="w-100">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="mb-3">
                        <input type="text" class="form-control p-3 font-paragraph" id="name" name="name" placeholder="Full Name..." required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control p-3 font-paragraph" id="email" name="email" placeholder="Email..." required>
                    </div>
                    <div class="mb-3">
                        <input type="number" class="form-control p-3 font-paragraph" id="mobileNo" name="mobileNo" placeholder="Mobile Number..." required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control p-3 font-paragraph" id="password" name="password" placeholder="Password..." required>
                    </div>
                    <div class="mb-1">
                        <input type="password" class="form-control p-3 font-paragraph" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password..." required>
                    </div>
                    <button type="button" id="signup-btn" class="color-background5 p-2 font-paragraph border-0 rounded-3 fw-bold fs-5 color-3 text-hover-1 w-100">
                        Signup
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Side: Image (Visible on Large Screens) -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
            <img src="{{ asset('images/DSCF2819.JPG') }}" alt="Signup Image" class="img-fluid rounded-4" style="max-width: 100%; height: 90vh; object-fit: cover;">
        </div>
    </div>
</div>

<!-- OTP Verification Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModalLabel">Verify Your Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>We've sent a 6-digit OTP to your email. Please enter it below to verify your account.</p>
                <input type="text" id="otp" class="form-control" placeholder="Enter OTP">
            </div>
            <div class="modal-footer">
                <button type="button" id="verify-otp" class="btn btn-primary">Verify OTP</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('#signup-btn').click(function() {
        let formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            mobileNo: $('#mobileNo').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "{{ url('/signup/send-otp') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included
            },
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                mobileNo: $('#mobileNo').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val()
            },
            success: function(response) {
                alert(response.message);
                $('#otpModal').modal('show'); // Show OTP modal
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "";
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + "\n"; 
                    });
                    alert(errorMessage);
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    });

    $('#verify-otp').click(function() {
        let formData = {
            email: $('#email').val(),
            otp: $('#otp').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: "{{ url('/signup/verify-otp') }}",
            method: "POST",
            data: formData,
            success: function(response) {
                alert(response.message);
                window.location.href = "{{ url('/login') }}"; // Redirect to login
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error || "Invalid OTP");
            }
        });
    });
});
</script>
</body>
</html>