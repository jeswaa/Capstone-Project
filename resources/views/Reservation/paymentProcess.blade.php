<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .submit-button {
        background-color: #0B5D3B; 
        color: white;
        font-weight: bold;
        font-size: 0.8rem;
        padding: 5px 10px;
        border: none;
        border-radius: 50px; 
        display: flex;
        align-items: center;
        justify-content: center;
        width: 150px; 
        cursor: pointer;
        margin: 0 auto;
    }

    .submit-button .arrow {
        background-color: white;
        color: #0B5D3B;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 5px;
        font-size: .7rem;
    }
    
    .custom-modal {
        background-color: #6B7546;
        border-radius: 10px;
        padding: 20px;
    }
    
    .modal-header h5 {
        color: #4A4A4A;
        font-size: 20px;
        font-weight: bolder;
        text-align: center;
        width: 100%;
    }
    
    .rating-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-top:15px;
    }
    
    .stars {
        font-size: 40px;
        display: flex;
        gap: 60px;
        padding-left: 70px;
    }
    
    .stars i {
        font-size: 40px;
        cursor: pointer;
        color: #444;
    }
    
    .stars i.active {
        color: #FFD700;
    }
    
    .feedback-label {
        margin-top: 15px;
    }
    
    .feedback-text {
        background-color: #819160;
        border: none;
        border-radius: 5px;
        padding: 8px;
        color: #fff;
        font-size: 1rem;
    }
    
    .submit-btn {
        width: 100%;
        background-color: #4A5E30;
        color: white;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 12px;
        border-radius: 15px;
        border: 2px solid #364220;
        text-transform: uppercase;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        transition: 0.3s ease-in-out;
    }
    
    .submit-btn:hover {
        background-color: #3A4F25;
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5);
        cursor: pointer;
    }
    
    .open-modal-btn {
        background-color: #718355;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 10px 20px;
    }
    
    .feedback-text {
        background-color: #819160;
        color: white;
        height: 80px;
        border-radius: 10px;
        border: none;
        padding: 8px;
        font-size: 1rem;
        resize: none;
    }
    
    /* New integrated styles */
    body {
        background: url('{{ asset('images/newbg.png') }}') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Poppins', sans-serif;
    }
    
    .payment-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }
    
    .payment-header {
        color: #e9ffcc;
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .payment-method-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .payment-details-section {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    
    .form-control {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
    
    .form-control:focus {
        background-color: #e9ffcc;
        border-color: #0B5D3B;
    }
    
    .qr-code-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .total-amount {
        font-size: 1.2rem;
        font-weight: bold;
        color: #0B5D3B;
    }
    
    .duration-display {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
        font-weight: bold;
        text-align: center;
        font-size: 1.1rem;
    }
</style>

<body class="bg-light font-paragraph">
    <div class="container mt-5 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-center fw-bold" style="color: #e9ffcc; font-size: 2.5rem; margin: 0 auto;">RESERVATION PAYMENT</h1>
        </div>

        <form id="paymentForm" action="{{ route('savePaymentProcess') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="stay_duration" id="stay_duration" value="1">
            
            <div class="bg-white p-3 shadow rounded-1 mx-auto d-flex flex-column flex-md-row g-0 mt-4" style="width: 90%;">
                <div class="w-100 w-md-50 bg-light p-3 text-white">
                    <h5 class="text-center text-md-center text-success">Payment Method</h5>
                    <hr class="bg-light my-2">
                    
                    <!-- Payment Method Tabs -->
                    <ul class="nav nav-tabs justify-content-center mb-3" id="paymentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="gcash1-tab" data-bs-toggle="tab" data-bs-target="#gcash1-content" type="button" role="tab" aria-controls="gcash1-content" aria-selected="true" style="color: #0B5D3B; transition: all 0.3s ease;">
                                GCash 1
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gcash2-tab" data-bs-toggle="tab" data-bs-target="#gcash2-content" type="button" role="tab" aria-controls="gcash2-content" aria-selected="false" style="color: #0B5D3B; transition: all 0.3s ease;">
                                GCash 2
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gcash3-tab" data-bs-toggle="tab" data-bs-target="#gcash3-content" type="button" role="tab" aria-controls="gcash3-content" aria-selected="false" style="color: #0B5D3B; transition: all 0.3s ease;">
                                GCash 3
                            </button>
                        </li>

                     <!-- Tab Content -->
                    <div class="tab-content" id="paymentTabContent">
                        <!-- GCash 1 Content -->
                        <div class="tab-pane fade show active" id="gcash1-content" role="tabpanel" aria-labelledby="gcash1-tab">
                            <div class="d-flex flex-column align-items-center">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="gcash1" value="gcash" checked>
                                <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 400px; height: 400px; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                                    <img src="{{ asset('images/qrcode.jpg') }}" alt="GCash QR Code 1" style="max-width: 80%; height: auto;">
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-bold text-success mb-0">GCash Number:</p>
                                    <p class="text-dark">0912-345-6789</p>
                                </div>
                                <div class="alert mt-3" role="alert" style="background-color: #0B5D3B; color: white;">
                                    <h6 class="fw-bold">Important Payment Instructions:</h6>
                                    <ul class="mb-0">
                                        <li>Please ensure to scan the correct QR code for payment</li>
                                        <li>Double check the amount before confirming the transaction</li>
                                        <li>Save your reference number and screenshot of payment</li>
                                        <li>Payment confirmation may take up to 24 hours</li>
                                        <li>No Refund Policy</li>
                                        <li>Required security deposit. "Follow up will be done after done the reservation"</li>
                                        <li>For assistance, contact our support team</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- GCash 2 Content -->
                        <div class="tab-pane fade" id="gcash2-content" role="tabpanel" aria-labelledby="gcash2-tab">
                            <div class="d-flex flex-column align-items-center">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="gcash" value="gcash">
                                <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 400px; height: 400px; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                                    <img src="{{ asset('images/qrcode.jpg') }}" alt="GCash QR Code 2" style="max-width: 80%; height: auto;">
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-bold text-success mb-0">GCash Number:</p>
                                    <p class="text-dark">0923-456-7890</p>
                                </div>
                                <div class="alert mt-3" role="alert" style="background-color: #0B5D3B; color: white;">
                                    <h6 class="fw-bold">Important Payment Instructions:</h6>
                                    <ul class="mb-0">
                                        <li>Please ensure to scan the correct QR code for payment</li>
                                        <li>Double check the amount before confirming the transaction</li>
                                        <li>Save your reference number and screenshot of payment</li>
                                        <li>Payment confirmation may take up to 24 hours</li>
                                        <li>No Refund Policy</li>
                                        <li>Required security deposit. "Follow up will be done after done the reservation"</li>
                                        <li>For assistance, contact our support team</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- GCash 3 Content -->
                        <div class="tab-pane fade" id="gcash3-content" role="tabpanel" aria-labelledby="gcash3-tab">
                            <div class="d-flex flex-column align-items-center">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="gcash3" value="gcash">
                                <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 400px; height: 400px; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                                    <img src="{{ asset('images/qrcode.jpg') }}" alt="GCash QR Code 3" style="max-width: 80%; height: auto;">
                                </div>
                                <div class="text-center mt-3">
                                    <p class="fw-bold text-success mb-0">GCash Number:</p>
                                    <p class="text-dark">0934-567-8901</p>
                                </div>
                                <div class="alert mt-3" role="alert" style="background-color: #0B5D3B; color: white;">
                                    <h6 class="fw-bold">Important Payment Instructions:</h6>
                                    <ul class="mb-0">
                                        <li>Please ensure to scan the correct QR code for payment</li>
                                        <li>Double check the amount before confirming the transaction</li>
                                        <li>Save your reference number and screenshot of payment</li>
                                        <li>Payment confirmation may take up to 24 hours</li>
                                        <li>No Refund Policy</li>
                                        <li>Required security deposit. "Follow up will be done after done the reservation"</li>
                                        <li>For assistance, contact our support team</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100 w-md-50 bg-white p-3 rounded text-dark border">
                    <h5 class="text-center text-md-center fw-bold text-success">Payment Details</h5>
                    <hr class="border-success my-2">
                    <div class="d-flex flex-column gap-2">
                        <div class="duration-display">
                            <p id="duration-text">Stay Duration</p>
                        </div>

                        @php
                            // Calculate stay duration from check-in and check-out dates
                            $checkInDate = new DateTime($reservationDetails['reservation_check_in_date'] ?? '');
                            $checkOutDate = new DateTime($reservationDetails['reservation_check_out_date'] ?? '');
                            $stayDuration = $checkInDate && $checkOutDate ? $checkOutDate->diff($checkInDate)->days : 1;
                            if ($stayDuration < 1) $stayDuration = 1;
                        @endphp

                        <div class="d-flex justify-content-between ">
                            <span class="fst-italic">Room</span>
                            <ul class="list-unstyled text-end" id="accommodation-list">
                                @foreach ($accomodations as $accomodation)
                                @php
                                    $quantity = session('reservation_details.quantity') ?? 1;
                                    $pricePerRoom = floatval($accomodation->accomodation_price) ?? 0;
                                    $roomTotalPrice = $pricePerRoom * $quantity;
                                    $totalPrice = $roomTotalPrice * $stayDuration;
                                @endphp
                                <p>
                                {{ $accomodation->accomodation_name }}({{$quantity}}x) - ₱{{ number_format(floatval($accomodation->accomodation_price) ?? 0, 2) }}  
                                </p>
                                @endforeach
                            </ul>
                        </div>
                        @if($totalEntranceFee > 0)
                        <div class="d-flex justify-content-between">
                            <span class="fst-italic">Entrance Fee</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0 w-75" value="₱{{ number_format($totalEntranceFee, 2) }}" readonly>
                        </div>
                        @endif

                        @if (isset($reservationDetails->package_id))
                            @php
                                $selectedPackage = $packages->where('id', $reservationDetails->package_id)->first();
                                $packagePrice = $selectedPackage->package_price ?? 0;
                                $packageEntranceFee = ($selectedPackage->package_max_guests ?? 0) * 100;
                                $totalPackageCost = ($packagePrice * 1) + $packageEntranceFee;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fst-italic">Package Price (1 day)</span>
                                <input type="text" class="form-control text-end bg-secondary-subtle border-0" 
                                       value="₱ {{ number_format($packagePrice, 2) }}" readonly>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fst-italic">Package Entrance Fee</span>
                                <input type="text" class="form-control text-end bg-secondary-subtle border-0" value="₱ {{ number_format($packageEntranceFee, 2) }}" readonly>
                            </div>
                        @endif

                        <hr class="border-success my-2">
                        
                        @php
                            // Calculate stay duration from check-in and check-out dates
                            $checkInDate = new DateTime($reservationDetails['reservation_check_in_date'] ?? '');
                            $checkOutDate = new DateTime($reservationDetails['reservation_check_out_date'] ?? '');
                            $stayDuration = $checkInDate && $checkOutDate ? $checkOutDate->diff($checkInDate)->days : 1;
                            if ($stayDuration < 1) $stayDuration = 1;
                            
                            // Calculate total room price with correct duration
                            $quantity = session('reservation_details.quantity') ?? 0;
                            $totalPrice = 0;
                            foreach ($accomodations as $accomodation) {
                                $pricePerRoom = ($accomodation->accomodation_price);
                                $roomTotalPrice = $pricePerRoom * $quantity;
                                $totalPrice += $roomTotalPrice * $stayDuration;
                            }
                            
                            // Calculate final amount including entrance fee
                            $amount = $totalPrice + ($totalEntranceFee ?? 0);
                            
                            // Calculate downpayment (50% of total amount)
                            $downpayment = $amount * 0.50;
                        @endphp

                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-success">Amount to Pay</h5>
                            <input type="text" class="form-control text-center bg-secondary-subtle border-0 fw-bold fs-5" 
                                   id="amount-display" style="max-width: 150px;" 
                                   value="₱{{ number_format($amount, 2) }}" 
                                   readonly>
                            <input type="hidden" name="amount" value="{{ $amount }}">
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fst-italic">Required 50% Downpayment</span>
                            <input type="text" id="downpayment-display" class="form-control text-end bg-secondary-subtle border-0" 
                                   style="max-width: 150px;" value="₱ {{ number_format($downpayment, 2) }}" readonly>
                            <input type="hidden" name="downpayment" value="{{ $downpayment }}">
                        </div>

                        <div class="alert alert-info py-2 px-3 mt-1 mb-0" role="alert">
                            <small class="fst-italic d-block text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                The required 50% downpayment includes the security deposit.
                            </small>
                        </div>
                            <!-- Hidden input for raw balance value -->
                        <input type="hidden" name="balance" value="{{ $amount - $downpayment }}">
                        <div class="mt-3">
                            <label class="fw-bold">Upload Proof of Payment</label>
                            <input type="file" class="form-control bg-secondary-subtle border-0" name="upload_payment" id="upload_payment" accept="image/*" required>
                        </div>
                        
                        <div class="mt-3">
                            <label class="fw-bold">Sender's Number</label>
                            <input type="number" class="form-control bg-secondary-subtle border-0" name="mobileNo" id="mobileNo" 
                                   value="{{ auth()->user() ? auth()->user()->mobileNo : '' }}" placeholder="ex: 09xxxxxxxxx" required>
                        </div>
                        
                        <div class="mt-3">
                            <label class="fw-bold">Reference Number</label>
                            <input type="number" class="form-control bg-secondary-subtle border-0" name="reference_num" id="reference_num" 
                                   placeholder="ex: 1100xx-xxx-xxx" required>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <button class="submit-button" type="submit" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                                Submit
                                <span class="arrow">&rsaquo;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    
    <!-- JavaScript -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Star rating functionality
        document.querySelectorAll(".stars").forEach(starContainer => {
            for (let i = 1; i <= 5; i++) {
                let star = document.createElement("i");
                star.classList.add("fas", "fa-star");
                star.dataset.value = i;
                star.addEventListener("click", function () {
                    let stars = this.parentElement.querySelectorAll("i");
                    stars.forEach(s => s.classList.remove("active"));
                    for (let j = 0; j < i; j++) {
                        stars[j].classList.add("active");
                    }
                });
                starContainer.appendChild(star);
            }
        });
        
        // Ensure GCash is selected by default
        document.getElementById('gcash').checked = true;

        // Calculate proper stay duration
        const checkInDate = "{{ $reservationDetails['reservation_check_in_date'] ?? '' }}";
        const checkOutDate = "{{ $reservationDetails['reservation_check_out_date'] ?? '' }}";
        
        let stayDuration = 1;
        if(checkInDate && checkOutDate) {
            const start = new Date(checkInDate);
            const end = new Date(checkOutDate);
            stayDuration = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            if (stayDuration < 1) stayDuration = 1;
        }

        // Update duration display and hidden input
        document.getElementById('duration-text').textContent = `Stay Duration: ${stayDuration} ${stayDuration > 1 ? 'days' : 'day'}`;
        document.getElementById('stay_duration').value = stayDuration;

        // Update accommodation prices
        const accommodationItems = document.querySelectorAll('#accommodation-list li');
        let totalAccommodation = 0;
        
        accommodationItems.forEach(item => {
            const price = parseFloat(item.dataset.price);
            const total = price * stayDuration;
            totalAccommodation += total;
            item.textContent = `${item.textContent.split(' - ')[0]} - ₱${total.toFixed(2)} (${stayDuration} ${stayDuration > 1 ? 'days' : 'day'})`;
        });

        // Update total accommodation price
        document.getElementById('total-accommodation').value = `₱${totalAccommodation.toFixed(2)}`;

        // Update total amount (if needed)
        const entranceFee = parseFloat("{{ $totalEntranceFee ?? 0 }}");
        const totalAmount = totalAccommodation + entranceFee;
        document.querySelector('input[name="amount"]').value = `₱ ${totalAmount.toFixed(2)}`;
        
        // Update downpayment (15% of total)
        const downpayment = totalAmount * 0.15;
        document.querySelector('input[name="downpayment"]').value = `₱${downpayment.toFixed(2)}`;
    });
    </script>
</body>
</html>