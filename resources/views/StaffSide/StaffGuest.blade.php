<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
@include('Alert.loginSucess')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- Side NavBar -->
        <div class="col-md-3 col-lg-2 color-background8 text-white position-sticky" id="sidebar" style="top: 0; height: 100vh; background-color: #0b573d background-color: #0b573d ">
            <div class="d-flex flex-column h-100">
                @include('Navbar.sidenavbarStaff')
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-10 col-lg-10 py-4 px-4">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-end align-items-end mb-1">
                <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
            </div>
            <hr class="border-5">

            <div>
                <h1 class="fw-semibold text-capitalize mt-4" style="font-size: 50px; letter-spacing: 1px; color: #0b573d; margin-top: -30px; font-family: 'Anton', sans-serif; letter-spacing: .1em;">Guest Information Overview</h1>
                <div class="mb-4 mt-3">
                    <form action="{{ route('staff.guests') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}" oninput="toggleClearButton(this)">
                            <button type="submit" class="btn btn-success me-2" style="height: 49px; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="btn btn-danger rounded-1" id="clearButton" style="height: 49px; display: {{ request('search') ? 'block' : 'none' }};" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                    function toggleClearButton(input) {
                        const clearButton = document.getElementById('clearButton');
                        clearButton.style.display = input.value ? 'block' : 'none';
                    }

                    function clearSearch() {
                        document.querySelector('input[name="search"]').value = '';
                        window.location.href = "{{ route('staff.guests') }}";
                    }
                </script>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Guest ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guests as $guest)
                                <tr>
                                    <td>{{ $guest->id }}</td>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->email }}</td>
                                    <td>{{ $guest->mobileNo }}</td>
                                    <td>{{ $guest->address }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewGuest{{ $guest->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGuest{{ $guest->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteGuest{{ $guest->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($guests->isEmpty())
                        <div class="text-center p-3">
                            <p>No guests found.</p>
                        </div>
                        @endif

                        <div class="d-flex justify-content-end mt-4">
                            <div class="pagination-container">
                                <style>
                                    .pagination-container .pagination {
                                        --bs-pagination-color: #0b573d;
                                        --bs-pagination-active-bg: #0b573d;
                                        --bs-pagination-active-border-color: #0b573d;
                                        --bs-pagination-hover-color: #0b573d;
                                        gap: 5px;
                                    }
                                    .pagination-container .page-link {
                                        border-radius: 5px;
                                        transition: all 0.3s ease;
                                    }
                                    .pagination-container .page-link:hover {
                                        background-color: #e9ecef;
                                        transform: translateY(-2px);
                                    }
                                    .pagination-container .page-item.active .page-link {
                                        box-shadow: 0 2px 5px rgba(11, 87, 61, 0.2);
                                    }
                                </style>
                                {{ $guests->links() }}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>