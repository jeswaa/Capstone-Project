<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Package</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    .select-accommodation.unavailable {
        cursor: not-allowed;
        opacity: 0.8;
    }
    
    .select-accommodation.unavailable .card-body {
        background-color: #ffebee !important;
        border-top: 3px solid #dc3545;
    }
    
    .select-accommodation.unavailable::before {
        content: 'Unavailable';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 10px;
        background-color: #dc3545;
        color: white;
        text-align: center;
        font-weight: bold;
        z-index: 1;
    }
    
    .select-accommodation.unavailable img {
        filter: grayscale(70%) brightness(0.7);
    }
    
    .select-accommodation.unavailable .text-success {
        color: #dc3545 !important;
    }
    .modal {
    z-index: 1050;
    }
    .modal-backdrop {
        z-index: 1040;
    }
    #paymentBreakdownModal {
    z-index: 1060;
    }
    #paymentBreakdownModal .modal-backdrop {
        z-index: 1050;
    }
</style>

<body class="bg-light font-paragraph" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/packagebg.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="d-flex align-items-center ms-5 mt-5">
        <a href="{{ route('calendar') }}"><i class="color-3 fa-2x fa-circle-left fa-solid icon icon-hover ms-4"></i></a><h1 class="text-white text-uppercase font-heading ms-3">Reservation</h1>
    </div>
    <div class="position-absolute top-0 end-0 mt-3 me-5 d-none d-md-block">
        <a class="text-decoration-none">
            <img src="{{ asset('images/logo2.png') }}" alt="Lelo's Resort Logo" width="120" class="rounded-pill">
        </a>
    </div>
    
    <div class="container">
    <h1 class="text-white font-heading fs-3 mt-3 mb-3 ms-2">Select your Room</h1>
    
    <form method="POST" action="{{ route('fixPackagesSelection') }}">
        @csrf
        <input type="hidden" name="package_type" value="One day Stay">
        <div class="d-flex justify-content-start mt-4 mb-3 ms-2">
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
                                <div class="card select-accommodation
                                    @if($accomodation->accomodation_status == 'unavailable') unavailable @endif"
                                     data-id="{{ $accomodation->accomodation_id }}"
                                     data-price="{{ $accomodation->accomodation_price }}"
                                     data-capacity="{{ $accomodation->accomodation_capacity }}"
                                     data-room-quantity="{{ $accomodation->quantity }}"
                                     data-status="{{ $accomodation->accomodation_status }}">
                                    <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" class="card-img-top" alt="accommodation image" style="max-width: 100%; height: 250px; object-fit: cover;">
                                    <div class="card-body p-3 position-relative" style="background-color: white;">
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <i class="fas fa-info-circle text-success fs-3 mt-2 me-2" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#roomModal{{ $accomodation->accomodation_id }}"></i>
                                        </div>
                                        <h5 class="text-success text-capitalize font-heading fs-4 fw-bold">{{ $accomodation->accomodation_name }}</h5>
                                        <p class="card-text text-success font-paragraph" style="font-size: smaller;">Description: {{ $accomodation->accomodation_description }}</p>
                                        <p class="card-text text-success font-paragraph">Capacity: {{ $accomodation->accomodation_capacity }} pax</p>
                                        <p class="card-text font-paragraph fw-bold text-success" style="text-align: right;">Price: <span style="background-color: #0b573d; color: white; padding: 2px 5px;">₱{{ $accomodation->accomodation_price }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Room Details -->
                            <div class="modal fade" id="roomModal{{ $accomodation->accomodation_id }}" tabindex="-1" aria-labelledby="roomModalLabel{{ $accomodation->accomodation_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content rounded-4 shadow">
                                        <div class="modal-header border-0" style="background-color: #0b573d;">
                                            <h5 class="modal-title text-white text-uppercase" style="font-family: 'Anton', sans-serif; letter-spacing: 0.1em;" id="roomModalLabel{{ $accomodation->accomodation_id }}">{{ $accomodation->accomodation_name }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <div class="row g-0">
                                                <!-- Left Column - Image -->
                                                <div class="col-md-6">
                                                    <div class="position-relative h-100">
                                                        <img src="{{ asset('storage/' . $accomodation->accomodation_image) }}" 
                                                            class="w-100 h-100 object-fit-cover rounded-start" 
                                                            style="max-height: 400px;" 
                                                            alt="{{ $accomodation->accomodation_name }}">
                                                        <div class="position-absolute bottom-0 start-0 w-100 p-3" 
                                                            style="background: linear-gradient(0deg, rgba(11, 87, 61, 0.9) 0%, rgba(11, 87, 61, 0.7) 100%);">
                                                            <h3 class="text-white mb-0 fw-bold">₱{{ number_format($accomodation->accomodation_price, 2) }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Right Column - Details -->
                                                <div class="col-md-6 p-4">
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Description</h6>
                                                        <p class="text-muted mb-0">{{ $accomodation->accomodation_description }}</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Amenities</h6>
                                                        <p class="text-muted mb-0">{{ $accomodation->amenities }}</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Capacity</h6>
                                                        <p class="text-muted mb-0">{{ $accomodation->accomodation_capacity }} pax</p>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h6 class="text-uppercase fw-bold" style="color: #0b573d;">Availability</h6>
                                                        <p class="text-muted mb-0">
                                                            @if($accomodation->accomodation_status == 'available')
                                                                <span class="badge bg-success">Available</span>
                                                            @else
                                                                <span class="badge bg-danger">Unavailable</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                <div class="card p-3 shadow-sm border-0 mb-4"> 
                                        <h6 class="fw-bold mb-3 text-success">Quantity</h6>
                                        <div class="form-group">
                                            <label for="quantity">Number of Rooms:</label> {{-- Updated label text --}}
                                            <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required oninput="calculateTotalGuest()"> {{-- Added oninput event --}}
                                            <small id="quantityError" class="text-danger mt-2" style="display: none;"></small>
                                        </div>
                                    </div>
                                    <div class="card p-3 shadow-sm border-0">
                                        <h6 class="fw-bold mb-3 text-success">Number of Visitors</h6>
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="number_of_adults">Adults <small style="font-size:10px;">(13 years and above):</small></label>
                                                <small class="text-muted" id="adult_entrance_fee">Entrance Fee: ₱<span id="adult_fee"> {{ number_format($adultTransaction->entrance_fee,2) }}</span></small>
                                            </div>
                                            <input type="number" name="number_of_adults" id="number_of_adults" class="form-control p-2" value="0" oninput="calculateTotalGuest()">
                                            
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="number_of_children">Children <small style="font-size:10px;">(3 to 12 years old):</small></label>
                                                <small class="text-muted" id="child_entrance_fee">Entrance Fee: ₱<span id="child_fee"> {{ number_format($kidTransaction->entrance_fee,2) }}</span></small>
                                            </div>
                                            <input type="number" name="number_of_children" id="number_of_children" class="form-control p-2" value="0" oninput="calculateTotalGuest()">
                                        </div>
                                        <div class="form-group">
                                            <label for="total_guests">Total Guests:</label>
                                            <input type="number" name="total_guest" id="total_guests" class="form-control p-2" readonly>
                                            <small class="text-muted">Total Entrance Fee: ₱<span id="total_entrance_fee">0</span></small>
                                            <small id="guestError" class="text-danger mt-2" style="display: none;"></small>
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
                                            <input type="time" id="start_time" name="reservation_check_in" class="form-control" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $transactions->start_time)->format('H:i') }}" required readonly>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="end_time">End Time:</label>
                                            <input type="time" id="end_time" name="reservation_check_out" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $transactions->end_time)->format('H:i') }}" class="form-control" required readonly>
                                        </div>
                                    </div>

                                    <div class="card p-3 shadow-sm border-0 mt-2">
                                        <h6 class="fw-bold mb-1 text-success">Select Date</h6>
                                        <div class="row g-1">
                                            <div class="col-md-12"> {{-- Changed from col-md-6 to col-md-12 to make date inputs full width within this card --}}
                                                <label for="reservation_date">Check-in Date:</label>
                                                <input type="date" id="reservation_date" name="reservation_check_in_date" class="form-control" required readonly>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="check_out_date" class="form-label">Check-out Date:</label>
                                                <input type="date" id="check_out_date" name="reservation_check_out_date" class="form-control" readonly>
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
                                    Continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Breakdown Modal -->
    <div class="modal fade" id="paymentBreakdownModal" tabindex="-1" aria-labelledby="paymentBreakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="paymentBreakdownModalLabel">Payment Breakdown</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-details">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Room Price:</span>
                            <span id="roomRate">₱0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Number of Rooms:</span>
                            <span id="numberOfRooms">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Entrance Fee:</span>
                            <span id="totalEntranceFeeDisplay">₱0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total Amount:</span>
                            <span id="totalAmountDisplay">₱0.00</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="confirmPayment">Confirm Payment</button>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const submitButton = document.querySelector('button[type="submit"]');
    const confirmPaymentBtn = document.getElementById('confirmPayment');
    const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
    const paymentBreakdownModal = new bootstrap.Modal(document.getElementById('paymentBreakdownModal'));
    
    // Add event listener for when payment breakdown modal is closed
    document.getElementById('paymentBreakdownModal').addEventListener('hidden.bs.modal', function () {
        // Show reservation modal again when payment modal is closed
        reservationModal.show();
    });

    submitButton.addEventListener("click", function(e) {
        e.preventDefault();
        
        // Validate accommodation selection
        const selectedAccommodation = document.querySelector('.select-accommodation.selected');
        if (!selectedAccommodation) {
            Swal.fire({
                icon: 'warning',
                title: 'No Room Selected',
                text: 'Please select a room before proceeding',
                confirmButtonColor: '#198754'
            });
            return;
        }
        
        // Validate quantity
        const quantity = parseInt(document.getElementById('quantity').value) || 0;
        if (quantity <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Quantity',
                text: 'Please enter a quantity greater than 0',
                confirmButtonColor: '#198754'
            });
            return;
        }

        // Validate number of guests
        const adults = parseInt(document.getElementById('number_of_adults').value) || 0;
        const children = parseInt(document.getElementById('number_of_children').value) || 0;
        
        if (adults <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Number of Adults',
                text: 'Please enter the number of adults (must be greater than 0)',
                confirmButtonColor: '#198754'
            });
            return;
        }
        
        if (adults + children <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Number of Guests',
                text: 'The total number of guests must be greater than 0',
                confirmButtonColor: '#198754'
            });
            return;
        }
        
        // Compute payment details
        const roomRate = parseFloat(selectedAccommodation.getAttribute('data-price')) || 0;
        const totalEntranceFee = parseFloat(document.getElementById('total_entrance_fee').textContent.replace(/[^\d.]/g, '')) || 0;
        
        // Calculate total
        const totalAmount = (roomRate * quantity) + totalEntranceFee;
        
        try {
            // Update modal content
            document.getElementById('roomRate').textContent = `₱${roomRate.toFixed(2)}`;
            document.getElementById('numberOfRooms').textContent = quantity;
            document.getElementById('totalEntranceFeeDisplay').textContent = `₱${totalEntranceFee.toFixed(2)}`;
            document.getElementById('totalAmountDisplay').textContent = `₱${totalAmount.toFixed(2)}`;
            
            // Hide reservation modal and show payment breakdown modal
            reservationModal.hide();
            setTimeout(() => {
                paymentBreakdownModal.show();
            }, 300);
        } catch (error) {
            console.error('Error updating modal content:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error processing your request. Please try again.',
                confirmButtonColor: '#198754'
            });
        }
    });
    
    if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener("click", function() {
            // Submit the form
            document.querySelector('form').submit();
        });
    }
});
</script>

<script>
    function calculateTotalGuest() {
        let adults = parseInt(document.getElementById("number_of_adults").value) || 0;
        let children = parseInt(document.getElementById("number_of_children").value) || 0;
        let totalGuests = adults + children;
        let quantity = parseInt(document.getElementById("quantity").value) || 1;
        
        let selectedAccommodation = document.querySelector('.select-accommodation.selected');
        let totalCapacity = 0;
        let availableRoomQuantity = 0;

        if (selectedAccommodation) {
            let roomCapacity = parseInt(selectedAccommodation.getAttribute('data-capacity')) || 0;
            totalCapacity = roomCapacity * quantity;
            availableRoomQuantity = parseInt(selectedAccommodation.getAttribute('data-room-quantity')) || 0;
        }

        let saveButton = document.querySelector('button[type="submit"]');
        let guestError = document.getElementById('guestError');
        let quantityError = document.getElementById('quantityError');
        let totalGuestsInput = document.getElementById("total_guests");

        // Quantity validation against available rooms
        if (quantity > availableRoomQuantity && availableRoomQuantity > 0) {
            quantityError.style.display = 'block';
            quantityError.textContent = `Exceeds available room quantity! (Available: ${availableRoomQuantity} rooms)`;
            saveButton.disabled = true;
            saveButton.classList.add('opacity-50');
        } else {
            quantityError.style.display = 'none';
            // Ensure button is enabled if quantity is valid and other inputs are also valid
            validateInputs();
        }

        // Guest capacity validation
        if (totalGuests > totalCapacity && totalCapacity > 0) {
            guestError.style.display = 'block';
            guestError.textContent = `Exceeds maximum capacity! (Maximum: ${totalCapacity} guests)`;
            saveButton.disabled = true;
            saveButton.classList.add('opacity-50');
            totalGuestsInput.style.color = 'red';
        } else {
            guestError.style.display = 'none';
            totalGuestsInput.style.color = 'black';
             // Ensure button is enabled if guest capacity is valid and other inputs are also valid
            validateInputs();
        }

        // Re-evaluate button state after all checks
        // validateInputs(); // This call is redundant here now that validateInputs is called in the else blocks

        document.getElementById("total_guests").value = totalGuests;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const mainForm = document.querySelector('form');
        const accommodationCards = document.querySelectorAll(".select-accommodation:not(.unavailable)");
        const proceedButton = document.getElementById("proceedToPayment");
        const quantityInput = document.getElementById("quantity"); // Get the quantity input

        // Add event listener to quantity input
        quantityInput.addEventListener('input', calculateTotalGuest); // Call calculateTotalGuest directly

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

        // Magdagdag ng click event listener sa bawat available accommodation card
        accommodationCards.forEach(card => {
            card.addEventListener("click", function () {
                // Check if this accommodation is unavailable
                if (this.classList.contains('unavailable')) {
                    // Show warning message for unavailable accommodations
                    Swal.fire({
                        title: "Accommodation Unavailable",
                        text: "This accommodation is currently unavailable. Please select another room.",
                        icon: "warning",
                        confirmButtonColor: '#198754'
                    });
                    return; // Exit early, don't allow selection
                }

                // Alisin muna ang selected class sa lahat ng cards
                document.querySelectorAll('.select-accommodation').forEach(c => c.classList.remove("selected"));
                
                // I-toggle ang selected class sa clinick na card
                this.classList.add("selected");
                
                updateProceedButton();
                calculateTotalGuest(); // Call calculateTotalGuest when a card is selected
                updateSelectedAccommodation();
            });
        });

        // I-handle ang form submission
        mainForm.addEventListener("submit", function (e) {
            const selectedAccommodation = document.querySelector(".select-accommodation.selected");
            
            if (!selectedAccommodation) {
                e.preventDefault();
                Swal.fire({
                    title: "No room selected",
                    text: "Choose atleast 1.",
                    icon: "warning"
                });
                return;
            }
            
            // Check if selected accommodation is unavailable (extra safety check)
            if (selectedAccommodation.classList.contains('unavailable')) {
                e.preventDefault();
                Swal.fire({
                    title: "Selected room is unavailable",
                    text: "Please select an available room.",
                    icon: "error",
                    confirmButtonColor: '#198754'
                });
                return;
            }
            
            // I-update muna ang hidden input bago mag-submit
            updateSelectedAccommodation();
        });

        // Initial call to set button state and validate on page load if needed
        updateProceedButton();
        calculateTotalGuest();
    });

    // Keep the validateInputs function for other validations if needed
    function validateInputs() {
        let isValid = true;
        const quantityInput = document.getElementById("quantity");
        const adultsInput = document.getElementById("number_of_adults");
        const childrenInput = document.getElementById("number_of_children");
        const saveButton = document.querySelector('button[type="submit"]');

        // Check if quantity, adults, and children inputs are valid numbers and not empty
        if (!quantityInput.value || parseInt(quantityInput.value) <= 0 || isNaN(parseInt(quantityInput.value))) {
            isValid = false;
        }
        if (!adultsInput.value || parseInt(adultsInput.value) < 0 || isNaN(parseInt(adultsInput.value))) {
             isValid = false;
        }
         if (!childrenInput.value || parseInt(childrenInput.value) < 0 || isNaN(parseInt(childrenInput.value))) {
             isValid = false;
        }

        // Check if there are any visible error messages
        const guestError = document.getElementById('guestError');
        const quantityError = document.getElementById('quantityError');

        if (guestError.style.display === 'block' || quantityError.style.display === 'block') {
            isValid = false;
        }

        // Enable or disable the save button based on overall validity
        if (isValid) {
            saveButton.disabled = false;
            saveButton.classList.remove('opacity-50');
        } else {
            saveButton.disabled = true;
            saveButton.classList.add('opacity-50');
        }

        return isValid;
    }
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
    document.addEventListener("DOMContentLoaded", function () {
        // Get check-in and check-out dates from URL
        const urlParams = new URLSearchParams(window.location.search);
        const checkIn = urlParams.get("checkIn") || "";
        const checkOut = urlParams.get("checkOut") || "";
        const roomId = urlParams.get('roomid');

        // Set values in the date inputs
        document.getElementById("reservation_date").value = checkIn;
        document.getElementById("check_out_date").value = checkOut;

        if (roomId) {
            // Find and select the corresponding accommodation card
            const roomCard = document.querySelector(`.select-accommodation[data-id="${roomId}"]`);
            if (roomCard) {
                // Remove selection from all cards first
                document.querySelectorAll(".select-accommodation").forEach(card => {
                    card.classList.remove("selected");
                });
                
                // Select the specified room
                roomCard.classList.add("selected");
                
                // Scroll to the selected card
                roomCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Update the proceed button state
                document.getElementById("proceedToPayment").disabled = false;
                
                // Update the hidden input field
                updateSelectedAccommodation();
            }
        }
    });

    // Function to update the hidden input with selected accommodation
    function updateSelectedAccommodation() {
        const mainForm = document.querySelector('form');
        
        // Remove existing accommodation input
        mainForm.querySelectorAll('input[name="accomodation_id[]"]').forEach(input => input.remove());
        
        // Add new input for selected accommodation
        const selectedCard = document.querySelector(".select-accommodation.selected");
        if (selectedCard) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "accomodation_id[]";
            input.value = selectedCard.getAttribute("data-id");
            mainForm.appendChild(input);
        }
    }
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
    fetch('/get-session-times?session=' + session)
        .then(response => response.json())
        .then(data => {
            // Parse the entrance fees as numbers first
            const adultFee = parseFloat(data.adultFee);
            const kidFee = parseFloat(data.kidFee);

            // Update entrance fees with proper formatting
            document.getElementById('adult_fee').textContent = ' ' + adultFee.toFixed(2);
            document.getElementById('child_fee').textContent = ' ' + kidFee.toFixed(2);

            // Recalculate total entrance fee
            calculateTotalGuest();

            // Update session times
            if (data.start_time && data.end_time) {
                document.getElementById('start_time').value = data.start_time.substring(0,5);
                document.getElementById('end_time').value = data.end_time.substring(0,5);
            } else {
                document.getElementById('start_time').value = '';
                document.getElementById('end_time').value = '';
            }
        })
        .catch(error => {
            console.error('Error fetching session times:', error);
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';
        });
}
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