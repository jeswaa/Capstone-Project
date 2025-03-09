<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Package</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        <form method="POST" action="{{ route('savePackageSelection') }}">
            @csrf
            <input type="hidden" name="package_type" value="custom">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rentAsWhole">Rent as Whole</label>
                        <select id="rentAsWhole" name="rent_as_whole" class="form-control">
                            <option value="" selected disabled hidden>Please select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 d-flex flex-column">
                <div class="form-group">
                    <label for="roomPreference">Room Preference</label>
                    <div class="container">
                        <div class="row">
                            @foreach($accomodations as $accomodation)
                                <div class="col-md-3 mb-3 d-flex">
                                    <div class="card w-100">
                                        <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accomodation image" style="max-width: 100%; height: 150px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <p class="card-text">{{ $accomodation->accomodation_id }}</p>
                                            <h5 class="card-title">{{ $accomodation->accomodation_name }}</h5>
                                            <p class="card-text">Type: {{ $accomodation->accomodation_type }}</p>
                                            <p class="card-text">Capacity: {{ $accomodation->accomodation_capacity }}</p>
                                            <p class="card-text">Price: {{ $accomodation->accomodation_price }}</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="accomodation{{ $accomodation->accomodation_id }}" name="accomodation_id[]" value="{{ $accomodation->accomodation_id }}">
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

            <div>
                <label for="activities">Activities</label>
                <div class="container">
                    <div class="row">
                        @foreach($activities as $activity)
                            <div class="col-md-3 mb-3">
                                <div class="card w-100">
                                    <span class="badge bg-{{ $activity->activity_status == 'Available' ? 'success' : 'danger' }} mb-2">
                                        {{ $activity->activity_status }}
                                    </span>
                                    <img src="{{ asset('storage/' . $activity->activity_image) }}" class="img-fluid rounded mb-2" style="width: 100%; height: 150px; object-fit: cover;" alt="{{ $activity->activity_name }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="activity{{ $activity->id }}" name="activity_id[]" value="{{ $activity->id }}">
                                        <label class="form-check-label" for="activity{{ $activity->id }}">
                                            {{ $activity->activity_name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="number_of_adults">Number of Adults:</label>
                        <input type="number" name="number_of_adults" id="number_of_adults" class="form-control" min="0" value="0" oninput="calculateTotalGuest()">
                    </div>
                    <div class="form-group">
                        <label for="number_of_children">Number of Children:</label>
                        <input type="number" name="number_of_children" id="number_of_children" class="form-control" min="0" value="0" oninput="calculateTotalGuest()">
                    </div>
                    <div class="form-group">
                        <label for="total_guests">Total Guests:</label>
                        <input type="number" name="total_guest" id="total_guests" class="form-control" readonly>
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
                        <h1>Choose Date</h1>
                        <label for="date">Start Date</label>
                        <input type="date" id="date" name="reservation_check_in_date" class="form-control" min="{{ now()->addDay()->toDateString() }}">
                    </div>
                    <div class="form-group">
                        <label for="date">End Date</label>
                        <input type="date" id="date" name="reservation_check_out_date" class="form-control" min="{{ now()->addDay()->toDateString() }}">
                    </div>
                </div>
            </div>

            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="specialRequest" class="form-label">Special Request</label>
                    <textarea id="specialRequest" name="special_request" class="form-control" rows="5" placeholder="Enter any special requests"></textarea>
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

    <script>
        function calculateTotalGuest() {
            let adults = parseInt(document.getElementById("number_of_adults").value) || 0;
            let children = parseInt(document.getElementById("number_of_children").value) || 0;
            let totalGuests = adults + children;

            document.getElementById("total_guests").value = totalGuests;
        }
    </script>
</body>
</html>
