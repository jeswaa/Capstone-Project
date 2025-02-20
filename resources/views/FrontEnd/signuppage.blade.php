<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin-left: 20%;
        }

        .background-color {
            background-color: #b5c99a;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signup-container {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #b5c99a;
        }

        .signup-form {
            flex: 1;
            padding: 20px;
            max-width: 50%;
            margin-left: 10%;
            margin-right: 5%;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .image-container img {
            width: 100%;
            height: 90%;
            margin-right: 35px;
            object-fit: cover;
            border-radius: 50px;
        }

        .btn-custom {
            background-color: #61704A !important;
            border: none !important;
            margin-top: 20px !important;
            color: white !important;
            padding: 0.75rem !important;
            border-radius: 20px !important;
            font-weight: 500 !important;
            margin-left: 10% !important
        }

        .btn-custom:hover {
            background-color: #53633D !important;
            color: white !important;
        }

        .signup-form .form-control {
            background-color: #97A97C !important;
            color: #333 !important;
            border: 2px solid #61704A !important;
            border-radius: 20px !important;
            padding: 10px !important;
        }

        .signup-form .form-control::placeholder {
            color: #fff !important;
        }

        .signup-form .form-control:focus {
            background-color: #fff !important;
            border-color: #53633D !important;
            box-shadow: 0 0 5px rgba(81, 102, 57, 0.5) !important;
        }

        .back-arrow {
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
        }

        .back-arrow i {
            font-size: 2rem;
            transform: rotate(-90deg);
            display: inline-block;
        }
    </style>
</head>
<body class="background-color">
    <div class="back-arrow" onclick="window.history.back()">
        <i class="fa-solid fa-arrow-turn-up"></i>
    </div>
    <div class="signup-container">
        <div class="signup-form">
            <h1 class="text-color-1">Create an Account</h1>
            <form action="{{ route('signup.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-color-1"></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Full Name..." required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label text-color-1"></label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address..." required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label text-color-1"></label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-color-1"></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required>
                </div>
                <div class="mb-3">
                    <label for="mobileNo" class="form-label text-color-1"></label>
                    <input type="number" class="form-control" id="mobileNo" name="mobileNo" placeholder="Mobile Number..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-color-1"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password..." required>
                </div>
                <button type="submit" class="btn btn-custom w-75 mb-3">SIGNUP</button>
            </form>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/hotelpic.jpg') }}" alt="Resort Image">
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
