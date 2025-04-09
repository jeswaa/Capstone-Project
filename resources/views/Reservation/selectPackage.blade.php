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
    .activity-card {
        border-radius: 15px;
        overflow: hidden;
        position: relative;
    }
    .activity-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .activity-title {
        position: absolute;
        bottom: 10px;
        left: 15px;
        font-size: 1.2rem;
        font-weight: bold;
        color: white;
    }
    .availability-badge {
        position: absolute;
        bottom: 10px;
        right: 15px;
        background-color: green;
        color: white;
        padding: 3px 8px;
        border-radius: 5px;
        font-size: 0.8rem;
    }

    
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
<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/packagegb.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('selectPackage') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-white text-uppercase font-heading ms-3">Reservation</h1>
    </div>
    
    <div class="position-absolute top-0 end-0 mt-3 me-5">
        <a href="{{ url('/') }}" class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
        </a>
    </div>

    
    <div class="container">
        <form method="POST" action="{{ route('savePackageSelection') }}">
            @csrf
            <input type="hidden" name="package_type" value="custom">

            <div class="col-md-12 d-flex flex-column">
                <div class="form-group">
                    <label for="roomPreference" class="text-white font-paragraph fw-semibold mb-3 ms-2" style="font-size: 1.5rem;">SELECT YOUR COTTAGE</label>
                    <div class="container">
                        <div class="row g-4">
                        @foreach($accomodations->sortByDesc('accomodation_id') as $accomodation)
                        @if($accomodation->accomodation_type == 'cottage')
                        <div class="col-md-4">
                        <div class="card select-accommodation {{ $accomodation->accomodation_slot == 0 ? 'disabled' : '' }}" 
                                        data-id="{{ $accomodation->accomodation_id }}" 
                                        data-price="{{ $accomodation->accomodation_price }}"
                                        data-capacity="{{ $accomodation->accomodation_capacity }}"
                                        style="border: 2px solid #0b573d; border-radius: 10px; overflow: hidden; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
                                <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accommodation image" style="max-width: 100%; height: 250px; object-fit: cover;">
                                <div class="card-body p-3 position-relative" style="background-color: white;">
                                    <h5 class="text-success text-capitalize font-heading fs-4 fw-bold">{{ $accomodation->accomodation_name }}</h5>
                                    <span class="card-text text-success font-paragraph" style="background-color: {{ $accomodation->accomodation_status === 'available' ? '#C6F7D0' : '#F4C2C7' }};">
                                        {{ ucfirst($accomodation->accomodation_status) }}
                                    </span>
                                    <p class="card-text text-success font-paragraph fs-6">Type: {{ $accomodation->accomodation_type }}</p>
                                    <p class="card-text text-success font-paragraph">Capacity: {{ $accomodation->accomodation_capacity }} pax</p>
                                    <p class="card-text font-paragraph fw-bold text-success" style="text-align: right;">Price: <span style="background-color: #0b573d; color: white; padding: 2px 5px;">₱{{ $accomodation->accomodation_price }}</span></p>
                                    <input type="hidden" name="accomodation_id[]" value="{{ $accomodation->accomodation_id }}" class="hidden-input" @if($accomodation->accomodation_slot == 0) disabled @endif>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
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
                                        <input class="form-check-input" type="checkbox" id="activity{{ $activity->id }}" name="activity_id[]" value="{{ $activity->id }}" {{ old('activity_id') && in_array($activity->id, old('activity_id')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activity{{ $activity->id }}"></label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-primary w-100" id="proceedToPayment" data-bs-toggle="modal" data-bs-target="#reservationModal">Proceed to Payment</button>
                </div>
              </div>

              <script>
                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById("proceedToPayment").addEventListener("click", function () {
                        let modal = new bootstrap.Modal(document.getElementById("reservationModal"));
                        modal.show();
                    });
                });
              </script>

<!-- Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-4">
            <!-- HEADER -->
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold" id="reservationModalLabel">Booking Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body px-4">
                <form method="POST" action="{{ route('savePackageSelection') }}">
                    @csrf
                    <input type="hidden" name="package_type" value="custom">

                    <!-- VISITOR INFO -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card p-3 shadow-sm border-0">
                                <h6 class="fw-bold mb-3 text-success">Number of Visitors</h6>
                                <div class="form-group mb-3">
                                    <label for="number_of_adults">Adults (18+):</label>
                                    <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" oninput="calculateTotalGuest()">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="number_of_children">Children (3-12):</label>
                                    <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" min="0" oninput="calculateTotalGuest()">
                                </div>
                                <div class="form-group">
                                    <label for="total_guests">Total Guests:</label>
                                    <input type="number" name="total_guest" id="total_guests" class="form-control p-2" readonly>
                                    <div id="guestError" class="text-danger mt-2" style="display: none;">
                                        Exceeds maximum room capacity!
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- TIME SELECTION -->
<div class="col-md-6">
    <div class="card p-3 shadow-sm border-0">
        <h6 class="fw-bold mb-3 text-success">Time</h6>
        <div class="form-group mb-3">
            <label for="check_in">Check-in Time:</label>
            <input type="time" id="check_in" name="reservation_check_in" class="form-control" value="15:00" readonly>
        </div>
        <div class="form-group">
            <label for="check_out">Check-out Time:</label>
            <input type="time" id="check_out" name="reservation_check_out" class="form-control" value="10:00" readonly>
        </div>
    </div>
</div>


                        <!-- DATE SELECTION -->
                        <div class="col-md-12">
                            <div class="card p-3 shadow-sm border-0">
                                <h6 class="fw-bold mb-3 text-success">Select Date</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="reservation_date">Check-in Date:</label>
                                        <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="check_out_date" class="form-label">Check-out Date:</label>
                                        <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SPECIAL REQUEST -->
                        <div class="col-md-12">
                            <div class="card p-3 shadow-sm border-0">
                                <h6 class="fw-bold mb-3 text-success">Special Request</h6>
                                <textarea id="specialRequest" name="special_request" class="form-control" rows="4" placeholder="Enter any special requests"></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="total_amount" id="total_amount">

                    <!-- SUBMIT BUTTON -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success fw-bold px-5 py-2 shadow-sm">
                            Save and Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

    let selectedAccommodations = document.querySelectorAll(".select-accommodation.selected");
    let totalCapacity = 0;
    selectedAccommodations.forEach(item => {
        totalCapacity += parseInt(item.getAttribute("data-capacity"));
    });

    // Show or hide the error message based on the comparison
    if (totalGuests > totalCapacity) {
        document.getElementById("guestError").style.display = "block";
    } else {
        document.getElementById("guestError").style.display = "none";
    }

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
    const checkOutDateInput = document.getElementById("check_out_date");

    function fetchAvailableAccommodations() {
        const checkInDate = checkInDateInput.value;
        const checkOutDate = checkOutDateInput.value;
        if (!checkInDate || !checkOutDate) return;

        fetch(`/get-available-accommodations?checkIn=${checkInDate}&checkOut=${checkOutDate}`)
            .then(response => response.json())
            .then(data => {
                // Update accommodations based on data
                resetFrontendAccommodations();
                data.forEach(accomodation => {
                    const card = document.querySelector(`.select-accommodation[data-id="${accomodation.id}"]`);
                    if (card) {
                        if (accomodation.available_slots === 0) {
                            card.classList.add("disabled");
                            card.querySelector(".card-text").textContent = "Fully Booked";
                            card.querySelector(".card-text").style.backgroundColor = "#F4C2C7";
                        }
                    }
                });
            })
            .catch(error => console.error("Error:", error));
    }

    checkInDateInput.addEventListener("change", fetchAvailableAccommodations);
    checkOutDateInput.addEventListener("change", fetchAvailableAccommodations);
});

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("check_in").value = "15:00";
        document.getElementById("check_out").value = "10:00";
    });
</script>

</script>

</body>
</html>