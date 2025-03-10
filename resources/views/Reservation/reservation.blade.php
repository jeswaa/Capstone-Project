<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation - Lelo's Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
        }
        .progress-line {
            width: 50%;
            height: 2px;
            background-color: #a9b9a6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }
        .progress-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #a9b9a6;
        }
        .progress-dot.active {
            background-color: #718355;
        }
        .input-box {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: white;
            margin-top: 8px;
        }
        .custom-button {
            background-color: #718355 !important;
            color: white;
            border: none;
            padding: 15px 100px !important;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .custom-button:hover {
            background-color: #889885;
            transform: translateY(-1px);
        }
        label {
            color: #4a4a4a;
            font-weight: 500;
            font-size: 0.9rem;
        }
        h1 {
            color: #2b2b2b;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        h4 {
            color: #2b2b2b;
            font-weight: 500;
            font-size: 1.2rem;
            margin: 0;
        }
          .form-container {
        margin-left: 7%;
        margin-top: 0%;
        }
        .header-section {
            display: flex;
            align-items: center;
            margin: 20px 0;
            width: 100%;
            gap: 30%;
        }
    </style>
</head>
<body class="color-background5">
   <div class="position-absolute top-0 start-0 mt-5 ms-5">
        <a href="{{ route('landingpage') }}"><i class="fa-solid fa-circle-left fa-2x color-3 icon"></i></a>
    </div>

    <div class="form-container">
        <h1>RESERVATION</h1>
        <div class="color-background7">
        <hr width="100%" size="5">
        </div>  


           <div class="header-section">
            <h4>Personal Information</h4>
            <div class="progress-line">
                <div class="progress-dot active"></div>
                <div class="progress-dot active"></div>
                <div class="progress-dot"></div>
                <div class="progress-dot"></div>
                <div class="progress-dot"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('saveReservationDetails') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Fullname</label>
                    <input type="text" name="name" class="input-box" 
                           placeholder="Enter your fullname" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="input-box" 
                              placeholder="Enter your address" required></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="input-box" 
                       placeholder="Enter your email" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Mobile No</label>
                    <input type="number" name="mobileNo" class="input-box" 
                           placeholder="Enter mobile number" required>
                </div>
            </div>

            <button type="submit" class="btn custom-button mt-3 ">
                NEXT
            </button>
        </form>
    </div>
</body>
</html>