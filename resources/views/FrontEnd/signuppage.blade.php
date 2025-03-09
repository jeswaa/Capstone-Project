<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
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
            display: block;
            margin-left: 12%;
        }

        .btn-custom:hover {
            background-color: #53633D !important;
            color: white !important;
        }

        .signup-form .form-control {
            background-color: #97A97C !important;
            color: #333 !important;
            border: 0 !important;
            border-radius: 20px !important;
            padding: 10px !important;
            width: 75% !important;
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
        
        .custom-file-label {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            border-radius: 5px;
        }


        .custom-file-label {
            background-color: #f8f9fa;
            border: 0;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .signup-form h1 {
            text-align: center;
        }

        .mb-3 {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body class="background-color">
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="position-absolute top-0 start-0 mt-5 ms-5">
        <a href="{{ route('login') }}"><i class="fa-solid fa-circle-left fa-2x color-3 icon"></i></a>
    </div>
    <div class="signup-container">
        <div class="signup-form">
            <h1 class="text-color-1 mb-3">Create an Account</h1>
            <form action="{{ route('signup.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-color-1 font-paragraph">Fullname</label>
                    <input type="text" class="form-control font-paragraph" id="name" name="name" placeholder="Full Name..." required>
                    <label for="name" class="form-label text-color-1 font-paragraph"></label>
                    <input type="text" class="form-control font-paragraph mt-4" id="name" name="name" placeholder="Full Name..." required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label text-color-1 font-paragraph">Address</label>
                    <input type="text" class="form-control font-paragraph" id="address" name="address" placeholder="Address..." required>
                    <label for="address" class="form-label text-color-1 font-paragraph"></label>
                    <input type="text" class="form-control font-paragraph" id="address" name="address" placeholder="Address..." required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label text-color-1 font-paragraph fw-bold">Upload Image</label>
                    <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                    <label for="image" class="form-label text-color-1 font-paragraph fw-bold"></label>
                    <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label text-color-1 font-paragraph">Email</label>
                    <input type="email" class="form-control font-paragraph" id="email" name="email" placeholder="Email..." required>
                    <label for="email" class="form-label text-color-1 font-paragraph"></label>
                    <input type="email" class="form-control font-paragraph" id="email" name="email" placeholder="Email..." required>
                </div>
                <div class="mb-3">
                    <label for="mobileNo" class="form-label text-color-1 font-paragraph">Mobile Number</label>
                    <input type="number" class="form-control font-paragraph" id="mobileNo" name="mobileNo" placeholder="Mobile Number..." required>
                    <label for="mobileNo" class="form-label text-color-1 font-paragraph"> </label>
                    <input type="number" class="form-control font-paragraph" id="mobileNo" name="mobileNo" placeholder="Mobile Number..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-color-1 font-paragraph">Password</label>
                    <input type="password" class="form-control font-paragraph" id="password" name="password" placeholder="Password..." required>
                    <label for="password" class="form-label text-color-1 font-paragraph">   </label>
                    <input type="password" class="form-control font-paragraph" id="password" name="password" placeholder="Password..." required>
                </div>
                <button type="submit" class="btn btn-custom w-75 btn-custom">SIGNUP</button>
            </form>
        </div>
        <div class="image-container">
            <img src="{{ asset('images/hotelpic.jpg') }}" alt="Resort Image">
        </div>
    </div>
</body>
</html>


