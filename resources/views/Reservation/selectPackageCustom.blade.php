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
    .accommodation-type-btn {
    transition: all 0.3s ease;
    border: 2px solid white;
    font-weight: bold;
    letter-spacing: 1px;
    padding: 10px 20px;
    }

    .accommodation-type-btn:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .accommodation-type-btn.active {
        background-color: white;
        color: #0b573d !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .accommodation-card {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .accommodation-card.hidden {
        display: none;
        opacity: 0;
        transform: scale(0.95);
    }
</style>

<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/packagebg.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('calendar') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-white text-uppercase font-heading ms-3">Reservation</h1>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="position-absolute top-0 end-0 mt-3 me-5">
        <a class="text-decoration-none">
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
        </a>
    </div>
    
    <div class="container">
    <h1 class="text-white font-heading fs-2 mt-3 mb-3 ms-2">Select your Room</h1>
    
    <form method="POST" action="{{ route('savePackageSelection') }}">
        @csrf
        <input type="hidden" name="package_type" value="One day Stay">
        <div class="d-flex justify-content-end mt-4 mb-3">
            <button type="button" 
                class="btn text-dark px-4" 
                style="background-color: rgba(255, 255, 255, 0.9);" 
                id="proceedToPayment" 
                data-bs-toggle="modal" 
                data-bs-target="#reservationModal" 
                disabled>
                <i class="fas fa-calendar-check me-2"></i>Booking Details
            </button>
        </div>
        <!-- Accommodation Type Selection -->
        <div class="mb-4">
            <div class="btn-group w-100" role="group" aria-label="Accommodation Types">
                @php
                    $types = $accomodations->pluck('accomodation_type')->unique();
                @endphp
                
                @foreach($types as $type)
                    <button type="button" class="btn btn-outline-light accommodation-type-btn text-uppercase" data-type="{{ $type }}">
                        {{ ucfirst($type) }}s
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Accommodation Cards Container -->
        <div class="col-md-12 d-flex flex-column">
            <div class="form-group">
                <div class="container">
                    <div class="row g-4" id="accommodationContainer">
                        @foreach($accomodations as $accomodation)
                            <div class="col-md-4 accommodation-card " data-type="{{ $accomodation->accomodation_type }}">
                                <div class="card select-accommodation" 
                                     data-id="{{ $accomodation->accomodation_id }}" 
                                     data-price="{{ $accomodation->accomodation_price }}"
                                     data-capacity="{{ $accomodation->accomodation_capacity }}">
                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accommodation image" style="max-width: 100%; height: 250px; object-fit: cover;">
                                    <div class="card-body p-3 position-relative" style="background-color: white;">
                                        <h5 class="text-success text-capitalize font-heading fs-4 fw-bold">{{ $accomodation->accomodation_name }}</h5>
                                        <p class="card-text text-success font-paragraph" style="font-size: smaller;">Description: {{ $accomodation->accomodation_description }}</p>
                                        <p class="card-text text-success font-paragraph">Capacity: {{ $accomodation->accomodation_capacity }} pax</p>
                                        <p class="card-text font-paragraph fw-bold text-success" style="text-align: right;">Price: <span style="background-color: #0b573d; color: white; padding: 2px 5px;">₱{{ $accomodation->accomodation_price }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Activities Section -->
        <div>
            <label for="activities" class="text-white font-paragraph fw-semibold mb-3 ms-2 mt-4" style="font-size: 1.5rem;">Activities <span style="font-size: 1rem;">(ALL INCLUDED)</span></label>
            <div class="container">
                <div class="row">
                    @foreach($activities as $activity)
                        <div class="col-md-3 mb-3 mt-3">
                            <div class="card rounded-3 w-100">
                                <img src="{{ asset('storage/' . $activity->activity_image) }}" class="rounded img-fluid mb-2" style="width: 100%; height: 200px; object-fit: cover;" alt="{{ $activity->activity_name }}">
                                <div class="d-flex align-items-center ms-3">
                                    <p class="text-success text-capitalize font-heading fs-4 fw-bold">{{ $activity->activity_name }}</p>
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
        <!-- Reservation Modal -->
        <!-- Tanggalin ang form tag dito at ilagay ang mga input fields sa main form -->
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-success text-white py-3">
                        <h5 class="modal-title fw-bold" id="reservationModalLabel">Booking Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                
                    <div class="modal-body px-4">
                        <!-- Tanggalin ang form tag dito -->
                        @csrf
                        <input type="hidden" name="package_type" value="custom">
                        
                        <!-- VISITOR INFO -->
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card p-3 shadow-sm border-0">
                                    <h6 class="fw-bold mb-3 text-success">Number of Visitors</h6>
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="number_of_adults">Adults <small style="font-size:10px;">(13 years old and above):</small></label>
                                        </div>
                                        <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" oninput="calculateTotalGuest()">
                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="number_of_children">Children <small style="font-size:10px;">(3 to 12 years old):</small></label>
                                        </div>
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
                        
                            <div class="col-md-6">
                                <div class="card p-3 shadow-sm border-0">
                                    <h6 class="fw-bold mb-3 text-success">Time</h6>
                                    <div class="form-group mb-3">
                                        <label for="check_in">Session:</label>
                                        <select id="session" name="session" class="form-control" onchange="updateSessionTimes()">
                                            <option value="morning" {{ (isset($transactions->session) && $transactions->session == 'morning') ? 'selected' : '' }}>Morning Session</option>
                                            <option value="evening" {{ (isset($transactions->session) && $transactions->session == 'evening') ? 'selected' : '' }}>Evening Session</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_time">Start Time:</label>
                                        <input type="time" id="start_time" name="reservation_check_in" class="form-control" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $transactions->start_time)->format('H:i') }}" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="end_time">End Time:</label>
                                        <input type="time" id="end_time" name="reservation_check_out" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $transactions->end_time)->format('H:i') }}" class="form-control" required>
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
                                            <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="check_out_date" class="form-label">Check-out Date:</label>
                                            <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control" required readonly>
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
                    </div>
                </div>
            </div>
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
        function calculateTotalGuest() {
            let adults = parseInt(document.getElementById("number_of_adults").value) || 0;
            let children = parseInt(document.getElementById("number_of_children").value) || 0;
            let totalGuests = adults + children;
            
            // Get all selected accommodations and calculate total capacity
            let selectedAccommodations = document.querySelectorAll('.select-accommodation.selected');
            let totalCapacity = 0;
            selectedAccommodations.forEach(accommodation => {
                totalCapacity += parseInt(accommodation.getAttribute('data-capacity')) || 0;
            });
            
            // Get the save button and error message elements
            let saveButton = document.querySelector('button[type="submit"]');
            let guestError = document.getElementById('guestError');
            let totalGuestsInput = document.getElementById("total_guests");
            
            // Update total guests display
            totalGuestsInput.value = totalGuests;
            
            // Check if total guests exceeds total capacity
            if (totalGuests > totalCapacity && totalCapacity > 0) {
                guestError.style.display = 'block';
                saveButton.disabled = true;
                saveButton.classList.add('opacity-50');
                totalGuestsInput.style.color = 'red';
            } else {
                guestError.style.display = 'none';
                saveButton.disabled = false;
                saveButton.classList.remove('opacity-50');
                totalGuestsInput.style.color = 'black';
            }
            
            document.getElementById("total_guests").value = totalGuests;
            calculateTotalAmount();
        }

    document.addEventListener("DOMContentLoaded", function () {
        const mainForm = document.querySelector('form');
        const accommodationCards = document.querySelectorAll(".select-accommodation");
        const proceedButton = document.getElementById("proceedToPayment");

        // Function para i-update ang estado ng button
        function updateProceedButton() {
            const selectedAccommodations = document.querySelectorAll(".select-accommodation.selected");
            proceedButton.disabled = selectedAccommodations.length === 0;
        }

        // Function para i-update ang hidden inputs ng selected accommodations
        function updateSelectedAccommodations() {
            // Tanggalin muna lahat ng existing accommodation inputs
            mainForm.querySelectorAll('input[name="accomodation_id[]"]').forEach(input => input.remove());
            
            // Magdagdag ng bagong input para sa bawat selected accommodation
            document.querySelectorAll(".select-accommodation.selected").forEach(card => {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "accomodation_id[]";
                input.value = card.getAttribute("data-id");
                mainForm.appendChild(input);
            });
        }

        // Magdagdag ng click event listener sa bawat accommodation card
        accommodationCards.forEach(card => {
            card.addEventListener("click", function () {
                this.classList.toggle("selected");
                updateProceedButton();
                calculateTotalGuest();
                updateSelectedAccommodations();
            });
        });

        // I-handle ang form submission
        mainForm.addEventListener("submit", function (e) {
            const selectedAccommodations = document.querySelectorAll(".select-accommodation.selected");
            
            if (selectedAccommodations.length === 0) {
                e.preventDefault();
                alert("Mangyaring pumili ng kahit isang accommodation.");
                return;
            }
            
            // I-update muna ang hidden inputs bago mag-submit
            updateSelectedAccommodations();
        });
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
<script>
function updateSessionTimes() {
    var session = document.getElementById('session').value;
    fetch('/get-session-times-only?session=' + session)
        .then(response => response.json())
        .then(data => {
            var startElem = document.getElementById('start_time');
            var endElem = document.getElementById('end_time');
            if (startElem && endElem && data.start_time && data.end_time) {
                startElem.value = data.start_time.substring(0,5);
                endElem.value = data.end_time.substring(0,5);
            }
        })
        .catch(error => {
            console.error('Error fetching session times:', error);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    // I-set agad ang tamang oras base sa default session
    updateSessionTimes();
    // I-update kapag nagbago ang session
    var sessionSelect = document.getElementById('session');
    if (sessionSelect) {
        sessionSelect.addEventListener('change', updateSessionTimes);
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeButtons = document.querySelectorAll('.accommodation-type-btn');
    const cards = document.querySelectorAll('.accommodation-card');
    
    // Ipakita ang unang type ng accommodation by default
    if (typeButtons.length > 0) {
        typeButtons[0].classList.add('active');
        const defaultType = typeButtons[0].getAttribute('data-type');
        filterAccommodations(defaultType);
    }

    typeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Alisin ang active class sa lahat ng buttons
            typeButtons.forEach(btn => btn.classList.remove('active'));
            
            // Idagdag ang active class sa napiling button
            this.classList.add('active');
            
            // I-filter ang mga accommodations
            const selectedType = this.getAttribute('data-type');
            filterAccommodations(selectedType);
        });
    });

    function filterAccommodations(type) {
        cards.forEach(card => {
            if (card.getAttribute('data-type') === type) {
                card.classList.remove('hidden');
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 50);
            } else {
                card.classList.add('hidden');
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
            }
        });
    }
});
</script>
</body>
</html>
