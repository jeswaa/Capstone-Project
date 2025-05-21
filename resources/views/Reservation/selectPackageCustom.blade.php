<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay In</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
      .select-accommodation {
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .select-accommodation.selected {
        transform: translateY(-5px);
    }

    .select-accommodation.selected::before {
        content: '✓ Selected';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background-color: #198754;
        color: white;
        text-align: center;
        font-weight: bold;
        z-index: 1;
    }

    .select-accommodation.selected img {
        filter: brightness(0.8);
    }

    .select-accommodation.selected .card-body {
        background-color: #e8f5e9 !important;
        border-top: 3px solid #198754;
    }

    .select-accommodation:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
</style>

<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)), url('{{ asset('images/packagebg.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('calendar') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-white text-uppercase font-heading ms-3"> Stay In Reservation</h1>
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
    
        <!-- Accommodation Cards Container -->
        <div class="col-md-12 d-flex flex-column">
            <div class="form-group">
                <div class="container">
                    <div class="row g-4" id="accommodationContainer">
                        @foreach($accomodations as $accomodation)
                            <div class="col-md-4 accommodation-card">
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
                                        <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" min="0" value="0" oninput="calculateTotalGuest()">
                                        
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="number_of_children">Children <small style="font-size:10px;">(3 to 12 years old):</small></label>
                                        </div>
                                        <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" min="0" value="0" oninput="calculateTotalGuest()">
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
                        
                            <div class="col-md-6 mb-4">
                                <div class="card p-3 shadow-sm border-0">
                                    <h6 class="fw-bold mb-3 text-success">Time</h6>
                                    <div class="form-group">
                                        <label for="start_time">Check-in Time:</label>
                                        <input type="time" id="start_time" name="reservation_check_in" class="form-control" value="14:00" readonly required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="end_time">Check-out Time:</label>
                                        <input type="time" id="end_time" name="reservation_check_out" value="12:00" class="form-control" readonly required>
                                    </div>
                                </div>
                                <div class="card p-2 shadow-sm border-0 mt-2">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                                    <small class="text-muted" style="font-size: 10px;">Number of rooms to reserve</small>
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
                        <div class="text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-success fw-bold px-5 py-2 shadow-sm">
                                Continue to payment
                                <i class="fas fa-arrow-right ms-2"></i>
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
            let quantity = parseInt(document.getElementById("quantity").value) || 1;
            
            // Kunin ang selected accommodation at calculate ang total capacity base sa quantity
            let selectedAccommodation = document.querySelector('.select-accommodation.selected');
            let totalCapacity = 0;
            
            if (selectedAccommodation) {
                let roomCapacity = parseInt(selectedAccommodation.getAttribute('data-capacity')) || 0;
                totalCapacity = roomCapacity * quantity;
            }
            
            // Kunin ang save button at error message elements
            let saveButton = document.querySelector('button[type="submit"]');
            let guestError = document.getElementById('guestError');
            let totalGuestsInput = document.getElementById("total_guests");
            
            // I-update ang total guests display
            totalGuestsInput.value = totalGuests;
            
            // I-check kung ang total guests ay lumampas sa total capacity
            if (totalGuests > totalCapacity && totalCapacity > 0) {
                guestError.style.display = 'block';
                guestError.textContent = `Exceeds maximum capacity! (Maximum: ${totalCapacity} guests)`;
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
            const selectedAccommodation = document.querySelector(".select-accommodation.selected");
            proceedButton.disabled = !selectedAccommodation;
        }

        // Function para i-update ang hidden input ng selected accommodation
        function updateSelectedAccommodation() {
            // Tanggalin muna ang existing accommodation input
            mainForm.querySelectorAll('input[name="accomodation_id[]"]').forEach(input => input.remove());
            
            // Magdagdag ng bagong input para sa selected accommodation
            const selectedCard = document.querySelector(".select-accommodation.selected");
            if (selectedCard) {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "accomodation_id[]";
                input.value = selectedCard.getAttribute("data-id");
                mainForm.appendChild(input);
            }
        }

        // Magdagdag ng click event listener sa bawat accommodation card
        accommodationCards.forEach(card => {
            card.addEventListener("click", function () {
                // Alisin muna ang selected class sa lahat ng cards
                accommodationCards.forEach(c => c.classList.remove("selected"));
                
                // I-toggle ang selected class sa clinick na card
                this.classList.add("selected");
                
                updateProceedButton();
                calculateTotalGuest();
                updateSelectedAccommodation();
            });
        });

        // I-handle ang form submission
        mainForm.addEventListener("submit", function (e) {
            const selectedAccommodation = document.querySelector(".select-accommodation.selected");
            
            if (!selectedAccommodation) {
                e.preventDefault();
                Swal.fire({
                    title: "Walang Napiling Room",
                    text: "Mangyaring pumili ng isang room para makapagpatuloy.",
                    icon: "warning"
                });
                return;
            }
            
            // I-update muna ang hidden input bago mag-submit
            updateSelectedAccommodation();
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

