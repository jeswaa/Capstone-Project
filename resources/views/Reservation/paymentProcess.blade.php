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
            <a href="{{ route('selectPackage') }}" title="Go Back to Reservation Package" class="text-decoration-none">
                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-arrow-left text-white" style="font-size: 30px;"></i>
                </div>
            </a>
            <h1 class="text-center fw-bold" style="color: #e9ffcc; font-size: 2.5rem;">RESERVATION PAYMENT</h1>
            <a href="{{ url('/') }}" title="Home" class="text-decoration-none">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <img src="{{ asset('images/appicon.png') }}" alt="App Logo" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            </a>
        </div>

        <form id="paymentForm" action="{{ route('savePaymentProcess') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="stay_duration" value="{{ $reservationDetails['stay_duration'] ?? 1 }}">
            
            <div class="bg-white p-3 shadow rounded-1 mx-auto d-flex flex-column flex-md-row g-0 mt-4" style="width: 90%;">
                <div class="w-100 w-md-50 bg-light p-3 text-white">
                    <h5 class="text-center text-md-center text-success">Payment Method</h5>
                    <hr class="bg-light my-2">
                    <div class="d-flex justify-content-center">
                        <input class="form-check-input d-none" type="checkbox" name="payment_method" id="gcash" value="gcash" checked>
                        <div class="bg-secondary p-1 d-flex align-items-center justify-content-center rounded-2" style="width: 400px; height: 400px; background-image: url('{{ asset('images/logosheesh.png') }}'); background-size: cover; background-position: center;">
                            <img src="{{ asset('images/qrcode.jpg') }}" alt="QR Code" style="max-width: 80%; height: auto;">
                        </div>
                    </div>
                </div>

                <div class="w-100 w-md-50 bg-white p-3 rounded text-dark border">
                    <h5 class="text-center text-md-center fw-bold text-success">Payment Details</h5>
                    <hr class="border-success my-2">
                    <div class="d-flex flex-column gap-2">
                        <div class="duration-display">
                        @php
                            use Carbon\Carbon;

                            // Get check-in and check-out dates from reservation details
                            $checkInDate = isset($reservationDetails['reservation_check_in_date']) ? Carbon::parse($reservationDetails['reservation_check_in_date']) : null;
                            $checkOutDate = isset($reservationDetails['reservation_check_out_date']) ? Carbon::parse($reservationDetails['reservation_check_out_date']) : null;

                            // Compute stay duration (minimum 1 day)
                            $stayDuration = ($checkInDate && $checkOutDate) ? $checkInDate->diffInDays($checkOutDate) : 1;
                        @endphp

                        <p>Stay Duration: {{ $stayDuration }} {{ $stayDuration > 1 ? 'days' : 'day' }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fst-italic">Accommodations:</span>
                            <ul class="list-unstyled text-end">
                            @php
                                // Compute Stay Duration (defaults to 1 if no check-out date is provided)
                                $checkInDate = isset($reservationDetails['reservation_check_in_date']) ? \Carbon\Carbon::parse($reservationDetails['reservation_check_in_date']) : null;
                                $checkOutDate = isset($reservationDetails['reservation_check_out_date']) ? \Carbon\Carbon::parse($reservationDetails['reservation_check_out_date']) : null;

                                $stayDuration = ($checkInDate && $checkOutDate) ? $checkInDate->diffInDays($checkOutDate) : 1;
                            @endphp

                            @foreach ($accomodations as $accomodation)
                                <li>
                                    {{ $accomodation->accomodation_name }} - ₱{{ number_format($accomodation->accomodation_price * $stayDuration, 2) }} 
                                    ({{ $stayDuration }} {{ $stayDuration > 1 ? 'days' : 'day' }})
                                </li>
                            @endforeach

                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fst-italic">Total Accommodation Price</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0" 
                                   value="₱{{ number_format($accomodation->accomodation_price * $stayDuration, 2) }} " readonly>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fst-italic">Entrance Fee per Person</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0" value="₱{{ number_format($entranceFee, 2) }}" readonly>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fst-italic">Total Guests</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0" value="{{ $reservationDetails['total_guest'] ?? 0 }}" readonly>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fst-italic">Total Entrance Fee</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0" value="₱{{ number_format($totalEntranceFee, 2) }}" readonly>
                        </div>

                        @if (isset($reservationDetails->package_id))
                            @php
                                $selectedPackage = $packages->where('id', $reservationDetails->package_id)->first();
                                $packagePrice = $selectedPackage->package_price ?? 0;
                                $packageEntranceFee = ($selectedPackage->package_max_guests ?? 0) * 100;
                                $totalPackageCost = ($packagePrice * ($reservationDetails['stay_duration'] ?? 1)) + $packageEntranceFee;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fst-italic">Package Price ({{ $reservationDetails['stay_duration'] ?? 1 }} days)</span>
                                <input type="text" class="form-control text-end bg-secondary-subtle border-0" 
                                       value="₱ {{ number_format($packagePrice * ($reservationDetails['stay_duration'] ?? 1), 2) }}" readonly>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fst-italic">Package Entrance Fee</span>
                                <input type="text" class="form-control text-end bg-secondary-subtle border-0" value="₱ {{ number_format($packageEntranceFee, 2) }}" readonly>
                            </div>
                        @endif

                        <hr class="border-success my-2">
                        
                        @php
                            // Compute stay duration
                            $stayDuration = isset($reservationDetails['reservation_check_in_date'], $reservationDetails['reservation_check_out_date']) 
                                ? \Carbon\Carbon::parse($reservationDetails['reservation_check_in_date'])->diffInDays(\Carbon\Carbon::parse($reservationDetails['reservation_check_out_date'])) 
                                : 1;

                            // Calculate total accommodation price
                            $totalAccommodationPrice = 0;

                            if (!isset($reservationDetails->package_id) && count($accomodations) > 0) {
                                foreach ($accomodations as $accomodation) {
                                    $totalAccommodationPrice += $accomodation->accomodation_price * $stayDuration;
                                }
                            }

                            // Calculate total entrance fee
                            $entranceFee = isset($reservationDetails['total_guest']) ? $reservationDetails['total_guest'] * 100 : 0;

                            // If a package is selected, use package pricing
                            if (isset($reservationDetails->package_id)) {
                                $selectedPackage = $packages->where('id', $reservationDetails->package_id)->first();
                                $totalAccommodationPrice = ($selectedPackage->package_price ?? 0) * $stayDuration;
                                $entranceFee = ($selectedPackage->package_max_guests ?? 0) * 100;
                            }

                            // Compute total amount
                            $amount = $totalAccommodationPrice + $entranceFee;

                            // Compute downpayment (15% of total)
                            $downpayment = $amount * 0.15;
                        @endphp

                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-success">Total Amount to Pay</h5>
                            <input type="text" class="form-control text-center bg-secondary-subtle border-0 fw-bold fs-5" name="amount" 
                                   style="max-width: 150px;" value="₱ {{ number_format($amount, 2) }}" readonly>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fst-italic">Required 15% Downpayment</span>
                            <input type="text" class="form-control text-end bg-secondary-subtle border-0" 
                                   style="max-width: 150px;" value="₱{{ number_format($downpayment, 2) }}" readonly>
                        </div>
                        
                        <div class="mt-3">
                            <label class="fw-bold">Upload Proof of Payment</label>
                            <input type="file" class="form-control bg-secondary-subtle border-0" name="upload_payment" id="upload_payment">
                        </div>
                        
                        <div class="mt-3">
                            <label class="fw-bold">Sender's Number</label>
                            <input type="text" class="form-control bg-secondary-subtle border-0" name="mobileNo" id="mobileNo" 
                                   value="{{ auth()->user() ? auth()->user()->mobileNo : '' }}" placeholder="ex: 09xxxxxxxxx" required>
                        </div>
                        
                        <div class="mt-3">
                            <label class="fw-bold">Reference Number</label>
                            <input type="text" class="form-control bg-secondary-subtle border-0" name="reference_num" id="reference_num" 
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

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Rate Your Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="rating-section">
                        <div class="stars">
                            <!-- Stars will be added via JavaScript -->
                        </div>
                        <label for="feedback" class="feedback-label">Your Feedback:</label>
                        <textarea id="feedback" class="feedback-text" placeholder="Share your experience..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="submit-btn" data-bs-dismiss="modal">Submit Feedback</button>
                </div>
            </div>
        </div>
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
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        let packageSelect = document.getElementById('package_id');
        let accomodationSelect = document.getElementById('accomodation_id');
        let amountField = document.getElementById('amount');

        if (packageSelect && accomodationSelect && amountField) {
            function computeTotal() {
                let selectedPackage = packageSelect.selectedOptions[0] || {};
                let selectedAccommodation = accomodationSelect.selectedOptions[0] || {};

                let entranceFee = parseFloat(selectedPackage.dataset.entranceFee) || 0;
                let totalGuest = parseInt(selectedPackage.dataset.totalGuest) || 0;
                let accomodationPrice = parseFloat(selectedAccommodation.dataset.accomodationPrice) || 0;

                let totalAmount = (entranceFee * totalGuest) + accomodationPrice;
                amountField.value = '₱ ' + totalAmount.toFixed(2);
            }

            packageSelect.addEventListener('change', computeTotal);
            accomodationSelect.addEventListener('change', computeTotal);
            computeTotal(); // Compute on page load
        }
    });
    </script>
</body>
</html>