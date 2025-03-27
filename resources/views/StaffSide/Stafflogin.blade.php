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
            background-color: #718355;
        }
        .container-custom {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 20px;
        }
        .hover-effect:hover{
            background-color: #b5c99a;
            color:#4a4a4a;
            transition: .3s ease-out;
        }
    </style>
</head>
<body class="color-background6">
    <div class="container-custom">
        <form action="{{ route ('staff.authenticate') }}" method="post" class="p-5">
            @csrf
            <h2 class="text-center text-uppercase font-heading color-3">Staff Login</h2>
            <div class="mb-3">
                <label for="username" class="mt-3 mb-3 font-heading">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror font-paragraph" id="username" name="username" placeholder="staff123..." required style="width: 400px;">
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label mb-3 font-heading">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror font-paragraph" id="password" name="password" placeholder="*********"required style="width: 400px;">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="color-background2 border-0 p-2 rounded-4  w-100 font-paragraph fw-bold color-3 mt-4 text-uppercase hover-effect">Login</button>
        </form>
    </div>
</body>
</html>