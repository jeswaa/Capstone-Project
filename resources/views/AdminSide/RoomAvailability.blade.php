<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Reservation</title>
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

                <div class="overflow-y-auto h-100 p-5">
                    <div class="d-flex ">
                        <a href="{{ route('reservations') }}" class="text-color-1 text-decoration-none me-5 hover-underline-animation"><h1 class="fs-5 font-heading">Reservation</h1></a>
                        <a href="{{ route('roomAvailability') }}" class="text-color-1 text-decoration-none active"><h1 class="fs-5 font-heading">Room Availability</h1></a>
                    </div>

                    <div>
                        <div class="d-flex mt-5 justify-content-center">
                            <div class="color-background4 w-auto p-3 rounded-4 mb-3">
                                <h1 class="fs-5 font-heading pt-2 ms-3 text-color-1">Overview</h1>
                                <div class="d-flex gap-3 mt-3 justify-content-center">
                                    <div class="color-background5 border-secondary rounded-3 ms-3 p-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Total Rooms:</h1>
                                        <p class="fs-4 text-center color-3">10</p>
                                    </div>
                                    <div class="p-3  color-background5 border-secondary rounded-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Available Rooms:</h1>
                                        <p class="fs-4 text-center color-3">5</p>
                                    </div>
                                    <div class="p-3  color-background5 border-secondary rounded-3 me-3 mb-2">
                                        <h1 class="fs-6 font-heading text-color-1">Reserved Rooms:</h1>
                                        <p class="fs-4 text-center color-3">5</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                        

                    <div class="mt-5">
                        <h1>Rooms</h1>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Room ID</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Room Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Deluxe Room</td>
                                    <td>Available</td>
                                    <td>
                                        <a href="#" class="text-success"><i class="fa-solid fa-eye"></i></a>
                                        <a href="#" class="text-warning mx-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="text-danger"><i class="fa-solid fa-trash-can"></i></a>
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