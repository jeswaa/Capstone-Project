<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            overflow: hidden; /* Prevent content from cutting off */
        }
        .login-form {
            width: 100vw;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-center {
            margin: 0 auto;
        }
        .login-img {
            height: 95vh;
            object-position: center;
            opacity: 0; /* Hide initially for smooth animation */
            transition: opacity 1s ease-in-out;
        }
        .text-hover-effect {
            background: linear-gradient(to right, currentColor 100%, transparent 100%);
            margin-top: 10px;
            background-size: 0% 2px;
            background-repeat: no-repeat;
            background-position: 0% 100%;
            transition: background-size 0.4s ease-in-out;
        }
        .text-hover-effect:hover {
            background-size: 100% 2px;
        }
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
        .form-control {
            border: none;
            border-radius: 0;
            background-color: #f5f5f5;
            padding: 1rem;
            transition: background-color 0.3s ease-in-out;
        }
        .form-control:focus {
            background-color: #e5f9db;
            outline: none;
        }
        .btn-login {
            background-color: #718355;
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 0;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-login:hover {
            background-color: #4a4a4a;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="color-background5 d-flex justify-content-center align-items-center" onload="AOS.init();">
        <div class="position-absolute top-0 start-0 mt-5 ms-5">
            <a href="{{ route('landingpage') }}"><i class="fa-solid fa-circle-left fa-2x color-3 icon"></i></a>
        </div>
    <div class="login-center login-form d-flex justify-content-center align-items-center">
        <div class="w-50" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true" data-aos-delay="100">
            <h1 class="text-color-1 mt-3 font-heading fs-4 text-center">Welcome to Lelo's Resort</h1>
            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="email" class="form-label text-color-1"></label>
                    <input type="email" class="form-control p-2 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email..." required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @else
                        @if(session()->has('error'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ session()->get('error') }}</strong>
                            </span>
                        @endif
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-color-1"></label>
                    <input type="password" class="form-control p-2 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password..." required>
                    @error('password')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @else
                        @if(session()->has('error'))
                            <div class="invalid-feedback ">
                                <strong>{{ session()->get('error') }}</strong>
                            </div>
                        @endif
                    @enderror
                </div>
                <button type="submit" class="mb-3 mt-4 border-0 p-2 rounded-4 color-background6 w-100 font-paragraph fw-bold color-3 btn-login" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="200">LOGIN</button>
                <p class="text-center mt-3 text-color-1 font-paragraph" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="300">Don't have an account?<a href="{{ route('signup') }}" class="font-paragraph text-color-1 ms-3 text-decoration-none text-hover-effect">Sign Up</a></p>
               <hr>
               <a href="{{ route('google.redirect') }}" class="color-3 font-paragraph text-decoration-none fw-bold" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="400">
                    <div class="d-flex justify-content-center w-100 color-background6 p-2 rounded-4 google">
                            <img src="{{ asset('images/google.png') }}" alt="" width="20" height="20" class="me-2"> Sign up using Google
                    </div>
                </a>
            </form>
        </div>
    </div>
    <img src="{{ asset('images/DSCF2819.jpg') }}" alt="Resort Image" class="login-img w-50 mt-3 me-3 rounded-5" data-aos="fade-left" data-aos-duration="1000" onload="this.style.opacity=1;">
</body>
</html>

