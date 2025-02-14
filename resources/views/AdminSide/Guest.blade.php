<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Guest</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            <!-- SIDE NAV BAR -->
            @include('Navbar.sidenavbar')

            <!-- Main Content -->
             <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 h-100 mt-4" >
                 <!-- TOP SECTION -->
                 <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success rounded-end-5" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Admin's Profile">
                            <a href="#"><i class="fa-regular fa-circle-user fs-1 text-decoration-none text-color-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                 <div class="overflow-y-auto h-auto p-5">
                    <div class="p-3 rounded-4 color-background4">
                        <h1 class="fs-5 font-heading fw-bold text-color-1 mb-3">Guest Overview</h1>
                        <div class="d-flex flex-row justify-content-between gap-1">
                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Registered Guests</h1>
                                <p class="fs-4 text-center color-3"> 10000</p>
                            </div>

                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Checked-in</h1>
                                <p class="fs-4 text-center color-3">10</p></div>

                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Upcoming Reservations</h1>
                                <p class="fs-4 text-center color-3">100</p></div>

                            <div class="text-color-1 font-paragraph  p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Cancellations / No-Shows: </h1>
                                <p class="fs-4 text-center color-3">100</p></div>

                            <div class="text-color-1 font-paragraph s p-2 rounded color-background5">
                                <h1 class="fs-6 font-heading text-color-1">Guest Feedback & Complaints: </h1>
                                <p class="fs-4 text-center color-3">100</p></div>
                        </div>
                    </div>

                    <div class="p-3 mt-5">
                        <h1 class="fs-5 font-heading fw-bold color-2 mb-3">Guest Information</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Guest Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Room Number</th>
                                    <th scope="col">Check-in</th>
                                    <th scope="col">Check-out</th>
                                    <th scope="col">Send Email</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>john.doe@gmail.com</td>
                                    <td>0927-123-4567</td>
                                    <td>101</td>
                                    <td>2022-09-01</td>
                                    <td>2022-09-03</td>
                                    <td><a href="#" class="text-primary ml-2"><i class="fa-solid fa-envelope"></i></a></td>
                                    <td>
                                        <a href="#" class="text-success"><i class="fa-solid fa-check-circle"></i> </a>
                                        <a href="#" class="text-danger ml-2"><i class="fa-solid fa-times-circle"></i> </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jane Doe</td>
                                    <td>jane.doe@gmail.com</td>
                                    <td>0927-123-4568</td>
                                    <td>102</td>
                                    <td>2022-09-02</td>
                                    <td>2022-09-04</td>
                                    <td><a href="#" class="text-primary ml-2"><i class="fa-solid fa-envelope"></i></a></td>
                                    <td>
                                        <a href="#" class="text-success"><i class="fa-solid fa-check-circle"></i> </a>
                                        <a href="#" class="text-danger ml-2"><i class="fa-solid fa-times-circle"></i></a>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                 </div>
             </div>
        </div>
    </div>
</body>
</html>