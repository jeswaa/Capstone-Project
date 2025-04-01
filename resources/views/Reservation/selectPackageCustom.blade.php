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
<style>
    .select-accommodation {
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.05);
    }

    .select-accommodation.selected {
        background-color: #718355 !important;  
        border: 2px solid #414141 !important;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        transform: scale(1.05);
    }

    .select-accommodation:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 16px 32px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .stay-duration {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        font-weight: bold;
    }
</style>
@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<body class="color-background4">
    <div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('calendar') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-color-1 text-uppercase font-heading ms-3">Reservation</h1>
    </div>
    
    <div class="container">
    <h1 class="text-color-1 font-heading fs-2 mt-3">Select and Customize your Package</h1>
        <form method="POST" action="{{ route('savePackageSelection') }}">
            @csrf
            <input type="hidden" name="package_type" value="custom">

            <div class="col-md-12 d-flex flex-column">
                <div class="form-group">
                    <label for="roomPreference" class="text-color-1 font-paragraph fw-semibold mb-3 ms-2">Room Preference</label>
                    <div class="container">
                        <div class="row">
                        @foreach($accomodations as $accomodation)
                        <div class="col-md-3 d-flex mb-3">
                            <div class="rounded-4 w-100 color-background5 select-accommodation 
                                        {{ $accomodation->accomodation_slot == 0 ? 'disabled' : '' }}" 
                                data-id="{{ $accomodation->accomodation_id }}" 
                                data-price="{{ $accomodation->accomodation_price }}">

                                <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                    class="card-img-top rounded-4" 
                                    alt="accommodation image" 
                                    style="max-width: 100%; height: 250px; object-fit: cover;">

                                <div class="card-body p-3 position-relative">
                                    <h5 class="color-3 text-capitalize font-heading fs-4 fw-bold">
                                        {{ $accomodation->accomodation_name }}
                                    </h5>
                                    <span class="card-text font-paragraph" style="background-color: {{ $accomodation->accomodation_status === 'available' ? '#C6F7D0' : '#F4C2C7' }};">
                                        {{ ucfirst($accomodation->accomodation_status) }}
                                    </span>

                                    <p class="text-color-1 font-paragraph" style="font-size: smaller;">Description:
                                        {{ $accomodation->accomodation_description }}
                                    </p>

                                    <p class="card-text text-capitalize font-paragraph fs-6">
                                        Type: {{ $accomodation->accomodation_type }}
                                    </p>
                                    <p class="card-text font-paragraph">Capacity: {{ $accomodation->accomodation_capacity }} pax</p>
                                    <p class="card-text font-paragraph">Price: ₱ {{ $accomodation->accomodation_price }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label for="activities" class="text-color-1 font-paragraph fw-semibold ms-2 mt-3">Activities</label>
                <div class="container">
                    <div class="row">
                        @foreach($activities as $activity)
                            <div class="col-md-3 mb-3 mt-3">
                                <div class="color-background5 rounded-3 w-100">
                                    <img src="{{ asset('storage/' . $activity->activity_image) }}" class="rounded img-fluid mb-2" style="width: 100%; height: 200px; object-fit: cover;" alt="{{ $activity->activity_name }}">
                                        <div class="d-flex align-items-center ms-3">
                                            <p class="color-3 text-capitalize font-paragraph fs-5 fw-semibold mb-2">{{ $activity->activity_name }}</p>
                                        </div>
                                    <div class="d-none form-check">
                                        <input class="form-check-input" type="checkbox" id="activity{{ $activity->id }}" name="activity_id[]" value="{{ $activity->id }}" {{ old('activity_id') && in_array($activity->id, old('activity_id')) ? 'checked' : 'checked' }}>
                                        <label class="form-check-label" for="activity{{ $activity->id }}"></label>
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
                        <label for="number_of_adults">Number of Adults (18+):</label>
                        <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" value="1">
                    </div>
                    <div class="form-group">
                        <label for="number_of_children">Number of Children (3-12):</label>
                        <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" min="0" value="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h1 for="time" class="text-color-1 font-paragraph fs-6 fw-semibold mb-4 ms-2 mt-3">Time</h1>
                        <label for="check_in">Check-in Time</label>
                        <input type="time" id="check_in" name="reservation_check_in" class="form-control" value="08:00">
                        <label for="check_out">Check-out Time</label>
                        <input type="time" id="check_out" name="reservation_check_out" class="form-control mb-4" value="12:00">
                    </div>
                </div>
            </div>

            <div class="row">
                @php
                    $selectedDate = request()->query('date', '');
                @endphp
                <div class="col-md-6">
                    <div class="row mt-4 d-flex align-items-center justify-content-between mx-auto">
                        <div class="col-md-5 col-12 mb-3 mb-md-0">
                            <label for="reservation_date">Check-in Date:</label>
                            <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required>

                            <label for="check_out_date" class="form-label fw-bold mt-3">Check-out Date</label>
                            <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control">
                            
                            <div class="stay-duration">
                                Stay Duration: <span id="duration_days">0</span> days
                                <input type="hidden" name="stay_duration" id="stay_duration">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <h1 class="text-color-1 font-paragraph fs-6 fw-semibold mb-4 ms-2 mt-3">Add Ons</h1>
                <div class="row">
                    @foreach($addons as $addon)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="{{ asset('storage/' . $addon->image) }}" class="card-img-top" alt="{{ $addon->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $addon->name }}</h5>
                                <p class="card-text">{{ $addon->description }}</p>
                                <p class="card-text text-end"><strong>Price: </strong>{{ $addon->price }}</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="addons[]" value="{{ $addon->id }}" id="addon{{ $addon->id }}">
                                    <label class="form-check-label" for="addon{{ $addon->id }}">
                                        Select
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="specialRequest" class="form-label">Special Request</label>
                    <textarea id="specialRequest" name="special_request" class="form-control" rows="5" placeholder="Enter any special requests"></textarea>
                </div>
            </div>
            <input type="hidden" name="total_amount" id="total_amount">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="color-background5 border-0 p-2 rounded-3 text-color-1 text-hover-1 w-100 font-paragraph fw-bold mb-5 mt-2">Save and Continue</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
    function resetFrontendAccommodations() {
        console.log("Resetting accommodations to available...");

        document.querySelectorAll(".select-accommodation").forEach(item => {
            item.classList.remove("disabled");
            item.classList.add("available");

            let statusSpan = item.querySelector(".card-text");
            if (statusSpan) {
                statusSpan.textContent = "Available";
                statusSpan.style.backgroundColor = "#C6F7D0";
            }
        });
    }

    function calculateStayDuration() {
        const checkInDate = document.getElementById("reservation_date").value;
        const checkOutDate = document.getElementById("check_out_date").value;
        
        if (!checkInDate || !checkOutDate) return;
        
        const date1 = new Date(checkInDate);
        const date2 = new Date(checkOutDate);
        
        // Calculate difference in milliseconds
        const diffTime = Math.abs(date2 - date1);
        
        // Convert to days
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        
        document.getElementById("duration_days").textContent = diffDays;
        document.getElementById("stay_duration").value = diffDays;
        
        calculateTotalAmount(); // Update total amount based on stay duration
    }

    function calculateTotalAmount() {
        let accommodationTotal = 0;
        const durationDays = parseInt(document.getElementById("stay_duration").value) || 1;

        document.querySelectorAll('.select-accommodation.selected').forEach(card => {
            let price = parseFloat(card.getAttribute("data-price")) || 0;
            accommodationTotal += price * durationDays; // Multiply by number of days
        });

        document.getElementById("total_amount").value = accommodationTotal.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const accommodationCards = document.querySelectorAll(".select-accommodation");
        const form = document.querySelector("form");

        // Calculate stay duration when dates change
        document.getElementById("reservation_date").addEventListener("change", calculateStayDuration);
        document.getElementById("check_out_date").addEventListener("change", calculateStayDuration);

        accommodationCards.forEach(card => {
            card.addEventListener("click", function () {
                this.classList.toggle("selected");

                let accommodationId = this.getAttribute("data-id");
                let existingInput = document.querySelector(`input[name="accomodation_id[]"][value="${accommodationId}"]`);

                if (this.classList.contains("selected")) {
                    if (!existingInput) {
                        let input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "accomodation_id[]";
                        input.value = accommodationId;
                        form.appendChild(input);
                    }
                } else {
                    if (existingInput) existingInput.remove();
                }

                calculateTotalAmount();
            });
        });

        // Set initial dates from URL if available
        const urlParams = new URLSearchParams(window.location.search);
        const checkIn = urlParams.get("checkIn") || "";
        const checkOut = urlParams.get("checkOut") || "";

        if (checkIn) document.getElementById("reservation_date").value = checkIn;
        if (checkOut) document.getElementById("check_out_date").value = checkOut;
        
        // Calculate initial duration if dates are set
        if (checkIn && checkOut) calculateStayDuration();
    });
</script>
</body>
</html>