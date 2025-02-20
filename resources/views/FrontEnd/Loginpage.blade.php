<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Full-screen layout */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .background-color {
            background-color: #b5c99a; /* Background color for the entire page */
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%; /* Full width */
            height: 100vh; /* Full viewport height */
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #b5c99a; /* Background color for the container */
        }

        .login-form {
    flex: 1;
    padding: 20px;
    max-width: 50%;
    margin-left: 10%;
    margin-right: 5%; /* Add space between the form and the image */
}

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; /* Full height */
        }

        .image-container img {
            width: 100%; /* Full width of the container */
            height: 100%; /* Full height of the container */
            object-fit: cover; /* Ensure the image covers the area without distortion */
            border-radius: 50PX; /* Remove border radius for full-screen effect */
            margin-left: 0%
        }

        .btn-custom {
            background-color: #61704A !important;
            border: none !important;
            margin-top: 20px !important;
            color: white !important;
            padding: 0.75rem !important;
            border-radius: 20px !important;
            font-weight: 500 !important;
        }

        .btn-custom:hover {
            background-color: #53633D !important;
            color: white !important;
        }

        /* Custom Form Styling */
        .login-form .form-control {
            background-color: #97A97C !important;
            color: #333 !important;
            border: 2px solid #61704A !important;
            border-radius: 20px !important;
            padding: 10px !important;
        }

        .login-form .form-control::placeholder {
            color: #fff !important;
        }

        .login-form .form-control:focus {
            background-color: #fff !important;
            border-color: #53633D !important;
            box-shadow: 0 0 5px rgba(81, 102, 57, 0.5) !important;
        }

        .btn-google {
            background-color: #61704A !important;
            border: none !important;
            color: white !important;
            padding: 0.75rem !important;
            border-radius: 20px !important;
            font-weight: 500 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-align: center;
        }

        .btn-google:hover {
            background-color: #53633D !important;
            color: white !important;
        }

        .divider {
            border-top: 1px solid #61704A;
            margin: 1.5rem 0;
        }

        .google-icon {
            font-size: 24px; /* Adjust size as needed */
            margin-right: 25px;
            background: linear-gradient(
                -2deg,
                #4285F4 0% 25%, /* Blue */
                #34A853 25% 50%, /* Green */
                #FBBC05 60% 75%, /* Yellow */
                #EA4335 75% 100% /* Red */
            );
            -webkit-background-clip: text; /* Clip background to text */
            background-clip: text;
            color: transparent; /* Make the icon text transparent */
        }

        .login-container h1 {
            font-size: 200% !important;
        }

        .back-arrow {
    position: absolute;
    top: 20px;  /* Distance from the top */
    left: 20px; /* Distance from the left */
    cursor: pointer;
}

.back-arrow i {
    font-size: 2rem; /* Make the arrow bigger */
    transform: rotate(-90deg); /* Rotates the arrow to the left */
    display: inline-block;
}
    </style>
</head>
<body>
<body class="background-color">
    <div class="back-arrow" onclick="window.history.back()">
        <i class="fa-solid fa-arrow-turn-up"></i>
    </div>
    <div class="login-container">
        <!-- Login Form Section -->
        <div class="login-form">
            <h1 class="text-color-1">Welcome to Lelo's Resort</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-color-1"></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-color-1"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password..." required>
                </div>
                <button type="submit" class="btn btn-custom w-75 mb-3">LOGIN</button>
                <p class="text-center mt-3 text-color-1">Don't have an account? <a href="{{ route('signup') }}" class="signup-link">Sign Up</a></p>
                <div class="divider"></div> <!-- Line between buttons -->
                <a href="{{ route('google.redirect') }}" class="btn btn-google w-75">
                    <i class="fab fa-google google-icon"></i> Sign Up using Google
                </a>
            </form>
        </div>
        
        <!-- Image Section -->
        <div class="image-container">
            <img src="{{ asset('images/hotelpic.jpg') }}" alt="Resort Image" class="activity-img">
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
    <br>
</html>
