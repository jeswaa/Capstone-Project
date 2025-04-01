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
<!-- Styles -->
<style>
input[type="file"] {
    width: 500px;
    height: 40px; /* Adjust based on your design */
    line-height: 40px;
    padding: 8px;
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
    flex-direction: column; /* Stack elements vertically */
    align-items: flex-start; /* Align text and stars to the left */
    padding-top:15px;
}
    .stars {
    font-size: 40px; /* Increase the font size */
    display: flex;
    gap: 60px;
    padding-left: 70px;
}

.stars i {
    font-size: 40px; /* Ensure individual stars are also bigger */
    cursor: pointer;
    color: #444;
}

.stars i.active {
    color: #FFD700; /* Highlighted stars */
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
    background-color: #4A5E30; /* Darker green for better visibility */
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    padding: 12px; /* Slightly bigger padding */
    border-radius: 15px;
    border: 2px solid #364220; /* Add a border for contrast */
    text-transform: uppercase; /* Make text more noticeable */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Add shadow for depth */
    transition: 0.3s ease-in-out;
}

.submit-btn:hover {
    background-color: #3A4F25; /* Darker on hover */
    box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5); /* Enhance shadow on hover */
    cursor: pointer;
}

    .open-modal-btn {
        background-color: #718355;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 10px 20px;
    }

    .feedback-text {
    background-color: #819160; /* Set background color */
    color: white; /* Text color */
    height: 80px; /* Set height */
    border-radius: 10px; /* Rounded corners */
    border: none; /* Remove default border */
    padding: 8px; /* Add padding */
    font-size: 1rem; /* Adjust font size */
    resize: none; /* Disable resizing */
}
</style>

<body style="background-color: #97a97c;">
<div class="container mt-5">
    <a href="javascript:history.back()" class="text-black text-decoration-none d-flex align-items-center mb-3">
        <i class="fa-solid fa-circle-left fa-2x color-3 icon"></i>
        <span class="ms-4 fw-bold fs-1 font-weight-bold">RESERVATION</span>
    </a>

    <form id="paymentForm" action="{{ route('savePaymentProcess') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="payment_method" class="form-label fw-bold fs-3" style="margin-left: 65px;">Payment Method</label>
            <div class="d-flex mt-4" style="margin-left: 65px;">
                <input class="form-check-input d-none" type="checkbox" name="payment_method" id="gcash" value="gcash">
                <button type="button" class="d-flex justify-content-center align-items-center px-4 py-1" 
                    style="width: 170px; height: 55px; background-color: #718355; border-radius: 10px; overflow: hidden;">
                <img src="{{ asset('images/cashg.png') }}" alt="GCash Logo" style="width: 140px; height: 55px; object-fit: contain; flex-shrink: 0;">
                </button>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        document.getElementById('gcash').checked = true;
                    });
                </script>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-md-6 d-flex justify-content-center align-items-center mt-3">
                    <img src="{{ asset('images/qrcode.jpg') }}" alt="QR Code" style="width:550px; height:550px;">
                </div>
                <div class="col-md-6">
                <h3>Payment</h3>
                @if (!isset($reservationDetails->package_id) && count($accomodations) > 0)
                    <ul>
                        @foreach ($accomodations as $accomodation)
                            <li>{{ $accomodation->accomodation_name }} - ₱{{ number_format($accomodation->accomodation_price, 2) }}</li>
                        @endforeach
                    </ul>
                    <p><strong>Total Accommodation Price:</strong> ₱{{ number_format($totalAccomodationPrice, 2) }}</p>
                    <p><strong>Entrance Fee per Person:</strong> ₱{{ number_format($entranceFee, 2) }}</p>
                    <p><strong>Total Guests:</strong> {{ $reservationDetails['total_guest'] ?? 0 }}</p>
                    <p><strong>Total Entrance Fee:</strong> ₱{{ number_format($totalEntranceFee, 2) }}</p>
                @endif



                    @php
                        // Ensure $reservationDetails is always treated as an object
                        $reservationDetails = is_array($reservationDetails) ? (object) $reservationDetails : $reservationDetails;
                    @endphp

                    @if (isset($reservationDetails->package_id))
                    @php
                        $selectedPackage = $packages->where('id', $reservationDetails->package_id)->first();
                        $packagePrice = $selectedPackage->package_price ?? 0;
                        $packageEntranceFee = ($selectedPackage->package_max_guests ?? 0) * 100;
                        $totalPackageCost = $packagePrice + $packageEntranceFee;
                    @endphp

                    <p class="text-color-1 font-paragraph fw-semibold">
                        Total Package Cost: ₱ {{ number_format($totalPackageCost, 2) }}
                    </p>
                @endif
                                                    
                    <hr class="mt-3 mb-5">
                    
                    <div class="mb-3">
                        <label for="mobileNo" class="form-label fw-bold fs-5">Mobile Number:</label>
                        <input type="text" class="form-control fs-5" name="mobileNo" id="mobileNo" value="{{ auth()->user() ? auth()->user()->mobileNo : '' }}" required style="height: 55px;">
                    </div>
                    @php
                        $amount = is_array($reservationDetails) ? ($reservationDetails['amount'] ?? 0.00) : ($reservationDetails->amount ?? 0.00);
                        $downpayment = $amount * 0.15; // Compute 15% of the amount
                    @endphp
                    <div class="">
                        <div class="d-flex">
                            <div class="me-2">
                                <label for="amount" class="form-label fw-bold fs-6">Amount:</label>
                                <input type="text" class="form-control" id="amount" name="amount" 
                                value="₱ {{ number_format($amount, 2) }}" 
                                    required style="height: 55px;" readonly>
                            </div>
                            
                            <div>
                                <label for="discount_amount" class="form-label fw-bold fs-6">Downpayment:</label>
                                <input type="text" class="form-control w-75" id="discount_amount" name="discount_amount" 
                                    value="₱{{ number_format($downpayment, 2) }}" 
                                    required style="height: 55px;" readonly>
                            </div>
                            <div>
                                <label for="upload_payment" class="form-label fw-bold fs-6">Upload Payment:</label>
                                <input class="form-control h-50 w-100" type="file" name="upload_payment" id="upload_payment" >
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reference_num" class="form-label fw-bold fs-6">Reference Number:</label>
                        <input type="text" class="form-control fs-5" name="reference_num" id="reference_num" required style="height: 55px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Finish Button (Triggers Modal) -->
        <div class="d-flex justify-content-end me-2 mb-3 mt-3">
            <button type="submit" class="color-background6 p-2 w-25 rounded-3 font-paragraph fs-5 fw-semibold color-3 border-0 text-hover-1" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                Finish
            </button>
        </div>
    </form>
</div>


<!-- JavaScript to Compute Total Amount -->
<script>
document.addEventListener("DOMContentLoaded", function () {
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