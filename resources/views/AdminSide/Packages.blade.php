<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Packages</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                        <a href="{{ route('reservations') }}" class="text-color-1 text-decoration-none me-5 hover-underline-animation active"><h1 class="fs-5 font-heading">Reservation</h1></a>
                        <a href="{{ route('roomAvailability') }}" class="text-color-1 me-5 text-decoration-none hover-underline-animation"><h1 class="fs-5 font-heading">Room Availability</h1></a>
                        <a href="{{ route('packages') }}" class="text-color-1 text-decoration-none hover-underline-animation"><h1 class="fs-5 font-heading">Packages</h1></a>
                    </div>
                    
                    <!-- Adding Packages -->
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-primary w-25" id="add-package-btn">Add Package</button>
                    </div>
                    @php
                        use Illuminate\Support\Facades\DB;
                        $packages = DB::table('packagestbl')->get();
                    @endphp

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Max Guests</th>
                                <th>Activities</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->package_name }}</td>
                                    <td>{{ $package->package_description }}</td>
                                    <td>{{ $package->package_duration }}</td>
                                    <td>{{ $package->package_max_guests }}</td>
                                    <td>{{ $package->package_activities }}</td>
                                    <td>{{ $package->package_price }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="#" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
             </div>
        </div>
    </div>
<!-- Modal for Adding Packages -->
<div class="modal fade" id="addPackageModal" tabindex="-1" aria-labelledby="addPackageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPackageModalLabel">Add Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('addPackage') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="packageName" class="form-label">Package Name</label>
            <input type="text" class="form-control" id="packageName" name="package_name" placeholder="Enter package name" required>
          </div>
          <div class="mb-3">
            <label for="packageDescription" class="form-label">Package Description</label>
            <textarea class="form-control" id="packageDescription" name="package_description" rows="3" placeholder="Enter package description"></textarea>
          </div>
          <div class="mb-3">
            <label for="packagePrice" class="form-label">Package Price</label>
            <input type="number" class="form-control" id="packagePrice" name="package_price" placeholder="Enter package price" required>
          </div>
          <div class="mb-3">
            <label for="packageDuration" class="form-label">Package Duration</label>
            <input type="text" class="form-control" id="packageDuration" name="package_duration" placeholder="Enter package duration">
          </div>
          <div class="mb-3">
            <label for="packageMaxGuests" class="form-label">Package Max Guests</label>
            <input type="number" class="form-control" id="packageMaxGuests" name="package_max_guests" placeholder="Enter package max guests">
          </div>
          <div class="mb-3">
            <label for="packageActivities" class="form-label">Package Activities</label>
            <textarea class="form-control" id="packageActivities" name="package_activities" rows="3" placeholder="Enter package activities"></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save Package</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Script to open the modal when the "Add Package" button is clicked
  document.querySelector('.btn-primary.w-25').addEventListener('click', function () {
    var myModal = new bootstrap.Modal(document.getElementById('addPackageModal'));
    myModal.show();
  });

  // Script to close the modal when the "Close" button is clicked
  document.querySelector('#addPackageModal button[data-bs-dismiss="modal"]').addEventListener('click', function () {
    var myModal = bootstrap.Modal.getInstance(document.getElementById('addPackageModal'));
    myModal.hide();
  });
</script>

</body>
</html>

