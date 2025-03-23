<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lelo's Resort Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
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
            background: linear-gradient(to top, rgba(0, 93, 59, 0.8), transparent);
            pointer-events: none;
        }
        .container-custom {
            width: 100vw;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }
        .hover-effect:hover {
            background-color: #b5c99a;
            color: #4a4a4a;
            transition: .3s ease-out;
        }
    </style>
</head>
<body>
    <div class="container-custom d-flex align-items-center justify-content-center">
        <div class="row shadow-lg rounded-4 overflow-hidden w-50">
            <div class="col-md-12 d-flex p-0">
                <!-- Left Side (Login Form) -->
                <div class="col-md-6 bg-white p-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/') }}" class="btn btn-sm btn-secondary rounded-pill text-white hover-effect">
                            Go Back
                        </a>
                        <h2 class="text-center text-uppercase font-heading mt-5" style="color: #008000;">Admin Login</h2>
                    </div>
                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="mt-3 mb-3 font-heading">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror font-paragraph" id="username" name="username" placeholder="admin123..." required>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label mb-3 font-heading">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror font-paragraph" id="password" name="password" placeholder="*********" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="color-background2 border-0 p-2 rounded-4 w-100 font-paragraph fw-bold color-3 mt-5 text-uppercase hover-effect">
                            Login
                        </button>
                    </form>
                </div>

                <!-- Right Side (Image) -->
                <div class="col-md-6 d-none d-md-block">
                    <img src="{{ asset('images/labasneto.jpg') }}" class="w-100 h-100 object-fit-cover" alt="Login Image">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
