<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Transactions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="color-background5">
    <div class="container-fluid">
        <div class="row h-100">
            

            <!-- Main Content -->
             <div class="col-md-9 col-12 main-content color-background3 rounded-start-50 ps-0 pe-0 mt-4 flex-column align-items-end ms-auto" >
                <!-- TOP SECTION -->
                <div class="color-background4 w-auto p-3 rounded-topright-50" id="main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <form class="d-flex align-items-center w-75" role="search">
                            <div class="input-group">
                                <input type="search" class="form-control mb-0 rounded-start-5 bg-light border border-secondary" placeholder="Search" aria-label="Search">
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

                <!-- MAIN SECTION -->
                 <div class="overflow-y-auto h-100 p-5">
                        <!-- Entrance Fee -->
                        <div class="row g-3">
                            <div class="col-auto ms-auto position-relative color-background5 p-2 rounded-3">
                                <i class="fa-solid fa-pencil-alt fs-6 text-color-1 position-absolute top-0 end-0 mt-2 me-2 cursor-pointer" data-bs-toggle="modal" data-bs-target="#editEntranceFeeModal" title="Edit"></i>
                                <h1 for="price_per_head" class="font-heading mb-2 text-uppercase fs-5 mt-4 color-3">Entrance Fee</h1>
                                <p class="font-paragraph fs-4 fw-bold text-color-1 text-center justify-content-center">{{ isset($entranceFee) ? $entranceFee : 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="editEntranceFeeModal" tabindex="-1" aria-labelledby="editEntranceFeeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editEntranceFeeModalLabel">Edit Entrance Fee</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('updatePrice') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="entranceFee" class="form-label">Entrance Fee</label>
                                                <input type="number" class="form-control" id="entranceFee" name="entrance_fee" value="{{ isset($entranceFee) ? $entranceFee : 'N/A' }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                 </div>
             </div>
        </div>
    </div>
    <!-- SIDE NAV BAR -->
    @include('Navbar.sidenavbar')
    <script>
        document.querySelector('#editEntranceFeeModal').addEventListener('show.bs.modal', event => {
            document.querySelector('#entranceFee').focus();
        });
        document.querySelector('#editEntranceFeeModal').addEventListener('hide.bs.modal', event => {
            document.querySelector('.modal-body p').textContent = '';
        });
    </script>
</body>
</html>