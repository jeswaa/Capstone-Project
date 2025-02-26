<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .row {
            height: 100%;
        }
        .form-check-input[type="radio"] {
            display: none;
        }
        .form-check-input[type="radio"]:checked + label span {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container d-flex justify-content-start">
        <div class="row w-75 g-4 mt-4">
        <h1 class="font-heading">Packages</h1>
            @php
                use Illuminate\Support\Facades\DB;
                $packages = DB::table('packagestbl')->get();
            @endphp
            @foreach($packages as $package)
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="package{{ $package->id }}" name="selected_packages[]" value="{{ $package->id }}">
                        <label class="form-check-label" for="package{{ $package->id }}">
                            <div class="card">
                                <div class="card-header">{{ $package->package_name }}</div>
                                <div class="card-body">
                                    <p>{{ $package->package_description }}</p>
                                    <p>Duration: {{ $package->package_duration }}</p>
                                    <p>Max Guests: {{ $package->package_max_guests }}</p>
                                    <p>Activities: {{ $package->package_activities }}</p>
                                    <p>Price: {{ $package->package_price }}</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customPackageModal">Custom Package</button>
    </div>
    
    <div class="modal fade" id="customPackageModal" tabindex="-1" aria-labelledby="customPackageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customPackageModalLabel">Custom Your Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('savePackageSelection') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rentAsWhole">Rent as Whole</label>
                                <select id="rentAsWhole" name="rent_as_whole" class="form-control">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="roomPreference">Room Preference</label>
                                <div class="container">
                                    <div class="row">
                                        @foreach($accomodations as $accomodation)
                                            <div class="col-md-3 w-50">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accomodation image" style="max-width: 100px; height: auto;">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $accomodation->accomodation_name }}</h5>
                                                        <p class="card-text">Type: {{ $accomodation->accomodation_type }}</p>
                                                        <p class="card-text">Capacity: {{ $accomodation->accomodation_capacity }}</p>
                                                        <p class="card-text">Price: {{ $accomodation->accomodation_price }}</p>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="accomodation{{ $accomodation->accomodation_id }}" name="accomodations[]" value="{{ $accomodation->accomodation_id }}">
                                                            <label class="form-check-label" for="accomodation{{ $accomodation->accomodation_id }}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="activities">Activities</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="hiking" name="activities" value="hiking">
                                    <label class="form-check-label" for="hiking">Hiking</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="camping" name="activities" value="camping">
                                    <label class="form-check-label" for="camping">Camping</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="swimming" name="activities" value="swimming">
                                    <label class="form-check-label" for="swimming">Swimming</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="reservation_date" class="form-control" min="{{ now()->addDay()->toDateString() }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <h1>Check-in Time</h1>
                                <input type="time" id="check_in" name="reservation_check_in" class="form-control" value="08:00">
                                <h1>Check-out Time</h1>
                                <input type="time" id="check_out" name="reservation_check_out" class="form-control" value="12:00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialRequest">Special Request</label>
                                <textarea id="specialRequest" name="special_request" class="form-control" rows="3" placeholder="Enter any special requests"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save and Continue</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Script to open the modal
    document.querySelector('.btn-primary').addEventListener('click', function () {
        var myModal = new bootstrap.Modal(document.getElementById('customPackageModal'));
        myModal.show();
    });

    // Script to close the modal
    document.querySelector('#customPackageModal button[data-bs-dismiss="modal"]').addEventListener('click', function () {
        var myModal = bootstrap.Modal.getInstance(document.getElementById('customPackageModal'));
        myModal.hide();
    });
</script>

</body>
</html>

