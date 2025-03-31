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
        border-radius: 10px; /* Added border-radius */
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
<body class="bg-light font-paragraph" style="background: url('{{ asset('images/logosheesh.png') }}') no-repeat center center fixed; background-size: cover;">
<div class="container mt-5 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('profile') }}" title="Your Profile" class="text-decoration-none">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-arrow-left text-white" style="font-size: 30px;"></i>
                </div>
            </a>
            <h1 class="me-auto ms-4 font-paragraph fw-bold" style="color: #e9ffcc; font-size: 2.5rem;">SELECT & CUSTOMIZE YOUR PACKAGE</h1>
            <a href="{{ url('/') }}" title="Home" class="text-decoration-none">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <img src="{{ asset('images/appicon.png') }}" alt="App Logo" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </a>
        </div>
    
    <div class="container">
        <form method="POST" action="{{ route('savePackageSelection') }}">
            @csrf
            <input type="hidden" name="package_type" value="custom">

            <div class="col-md-12 d-flex flex-column">
                <div class="form-group">
                    <label for="roomPreference" class="text-white font-paragraph fw-semibold mb-3 ms-2" style="font-size: 1.5rem;">SELECT YOUR ROOM</label>
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

                                    <!-- Hidden input to store selected value (added dynamically by JS) -->
                                </div>
                            </div>
                        </div>

                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
    <form method="POST" action="{{ route('savePackageSelection') }}">
        @csrf
        <input type="hidden" name="package_type" value="custom">
        
        <div class="mb-4">
            <label for="roomPreference" class="text-white font-paragraph fw-semibold fs-4">SELECT YOUR CABIN</label>
            <div class="row g-4">
                @foreach($accomodations->sortByDesc('accomodation_id') as $accomodation)
                <div class="col-md-4">
                    <div class="card select-accommodation {{ $accomodation->accomodation_slot == 0 ? 'disabled' : '' }}" data-id="{{ $accomodation->accomodation_id }}">
                        <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accommodation image" style="max-width: 100%; height: 250px; object-fit: cover;">
                        <div class="card-body bg-white p-3 position-relative">
                            <h5 class="text-success text-capitalize fw-bold fs-4">{{ $accomodation->accomodation_name }}</h5>
                            <span class="badge" style="background-color: {{ $accomodation->accomodation_status === 'available' ? '#C6F7D0' : '#F4C2C7' }};">
                                {{ ucfirst($accomodation->accomodation_status) }}
                            </span>
                            <p class="text-success fs-6">Type: {{ $accomodation->accomodation_type }}</p>
                            <p class="text-success">Capacity: {{ $accomodation->accomodation_capacity }} pax</p>
                            <p class="text-end text-success fw-bold">Price: <span class="bg-success text-white px-2 py-1">₱{{ $accomodation->accomodation_price }}</span></p>
                            <input type="hidden" name="accomodation_id[]" value="{{ $accomodation->accomodation_id }}" class="hidden-input" @if($accomodation->accomodation_slot == 0) disabled @endif>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="text-white font-paragraph fw-semibold">Number of Visitors</label>
                <div class="form-group">
                    <label for="number_of_adults" class="text-white">Adults (18+):</label>
                    <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" oninput="calculateTotalGuest()">
                </div>
                <div class="form-group">
                    <label for="number_of_children" class="text-white">Children (3-12):</label>
                    <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" min="0" oninput="calculateTotalGuest()">
                </div>
                <div class="form-group">
                    <label for="total_guests" class="text-white">Total Guests:</label>
                    <input type="number" name="total_guest" id="total_guests" class="form-control p-2" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <h5 class="text-white font-paragraph fw-semibold">Time</h5>
                <div class="form-group">
                    <label for="check_in" class="text-white">Check-in Time</label>
                    <input type="time" id="check_in" name="reservation_check_in" class="form-control" value="08:00">
                </div>
                <div class="form-group">
                    <label for="check_out" class="text-white">Check-out Time</label>
                    <input type="time" id="check_out" name="reservation_check_out" class="form-control" value="12:00">
                </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <h1 class="text-color-1 font-paragraph fs-6 fw-semibold mb-4 ms-2 mt-3">Add Ons</h1>
                <div class="row">
                    <!-- add ons  -->
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

        <div class="row mt-4">
            <div class="col-md-6">
                <label for="reservation_date" class="text-white">Check-in Date:</label>
                <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required>
                
                <label for="check_out_date" class="form-label fw-bold mt-3 text-white">Check-out Date:</label>
                <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control">
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="form-group">
                <label for="specialRequest" class="form-label text-white">Special Request</label>
                <textarea id="specialRequest" name="special_request" class="form-control" rows="5" placeholder="Enter any special requests"></textarea>
            </div>
        </div>

        <input type="hidden" name="total_amount" id="total_amount">
        
        <div class="row mt-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success w-100 fw-bold py-2">Save and Continue</button>
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

            // I-update ang status text at background color
            let statusSpan = item.querySelector(".card-text");
            if (statusSpan) {
                statusSpan.textContent = "Available";
                statusSpan.style.backgroundColor = "#C6F7D0"; // Green background for available
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        const checkInDateInput = document.getElementById("reservation_date");

        checkInDateInput.addEventListener("change", function () {
            resetFrontendAccommodations(); // I-reset ang frontend kapag nagbago ang check-in date
        });
    });
</script>

<script>
    // Move function outside DOMContentLoaded to prevent "ReferenceError"
    function calculateTotalGuest() {
        let adults = parseInt(document.getElementById("number_of_adults").value) || 0;
        let children = parseInt(document.getElementById("number_of_children").value) || 0;
        let totalGuests = adults + children;

        document.getElementById("total_guests").value = totalGuests;
        calculateTotalAmount(); // Ensure total amount updates correctly
    }

        function calculateTotalAmount() {
            let adultEntranceFee = 100;
            let childEntranceFee = 50;
            let numAdults = parseInt(document.getElementById("number_of_adults").value) || 0;
            let numChildren = parseInt(document.getElementById("number_of_children").value) || 0;

        let entranceTotal = (numAdults * adultEntranceFee) + (numChildren * childEntranceFee);
        let accommodationTotal = 0;

        document.querySelectorAll('.select-accommodation.selected').forEach(card => {
            let price = parseFloat(card.getAttribute("data-price")) || 0;
            accommodationTotal += price;
        });

        let totalAmount = entranceTotal + accommodationTotal;
        document.getElementById("total_amount").value = totalAmount.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const accommodationCards = document.querySelectorAll(".select-accommodation");
        const totalAmountInput = document.getElementById("total_amount");
        const form = document.querySelector("form");

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

        form.addEventListener("submit", function () {
            document.querySelectorAll("input[name='accomodation_id[]']").forEach(input => {
                let accommodationId = input.value;
                let card = document.querySelector(`.select-accommodation[data-id="${accommodationId}"]`);
                if (!card.classList.contains("selected")) {
                    input.remove();
                }
            });
        });

        document.getElementById("number_of_adults").addEventListener("input", calculateTotalGuest);
        document.getElementById("number_of_children").addEventListener("input", calculateTotalGuest);
    });
</script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get check-in and check-out dates from URL
            const urlParams = new URLSearchParams(window.location.search);
            const checkIn = urlParams.get("checkIn") || "";
            const checkOut = urlParams.get("checkOut") || "";

            // Set values in the date inputs
            document.getElementById("reservation_date").value = checkIn;
            document.getElementById("check_out_date").value = checkOut;
        });
</script>
<script>
        document.addEventListener("DOMContentLoaded", function () {
    const checkInDateInput = document.getElementById("reservation_date");
    const accommodationList = document.getElementById("accommodationList");
    const accommodationMessage = document.getElementById("accommodationMessage");

    checkInDateInput.addEventListener("change", function () {
        let checkInDate = this.value;
        if (!checkInDate) return;

        fetch(`/get-available-accommodations?date=${checkInDate}`)
            .then(response => response.json())
            .then(data => {
                accommodationList.innerHTML = ""; // Clear list
                if (data.length === 0) {
                    accommodationMessage.innerHTML = "No accommodations available for this date.";
                    return;
                }

                data.forEach(accommodation => {
                    let div = document.createElement("div");
                    div.classList.add("accommodation-item", "p-3", "mb-2", "border", "rounded");
                    div.innerHTML = `
                        <h5>${accommodation.name}</h5>
                        <p>Type: ${accommodation.type}</p>
                        <p>Capacity: ${accommodation.capacity} pax</p>
                        <p>Price: ₱${accommodation.price}</p>
                        <span class="badge bg-${accommodation.available ? 'success' : 'danger'}">
                            ${accommodation.available ? "Available" : "Fully Booked"}
                        </span>
                    `;
                    accommodationList.appendChild(div);
                });
            })
            .catch(error => console.error("Error fetching accommodations:", error));
    });
});
</script>

</body>
</html>