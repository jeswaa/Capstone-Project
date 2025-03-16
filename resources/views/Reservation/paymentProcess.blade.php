<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> <!-- Added FontAwesome -->
</head>

<!-- Styles -->
<style>
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
        <i class="bi bi-arrow-left fs-1 font-weight-bold"></i>
        <span class="ms-4 fw-bold fs-1 font-weight-bold">RESERVATION</span>
    </a>

    <form id="paymentForm" action="{{ route('savePaymentProcess') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Payment Method -->
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="payment_method" id="gcash" value="gcash">
                <label class="form-check-label" for="gcash">GCash</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="payment_method[]" id="bank_transfer" value="bank_transfer">
                <label class="form-check-label" for="bank_transfer">Bank Transfer</label>
            <label for="payment_method" class="form-label fw-bold fs-3" style="margin-left: 65px;">Payment Method</label>
            <div class="d-flex mt-4" style="margin-left: 65px;">
                <input class="form-check-input d-none" type="checkbox" name="payment_method" id="gcash" value="gcash">
                <button type="button" class="d-flex justify-content-center align-items-center px-4 py-1" 
                    onclick="toggleCheckbox('gcash')" 
                    style="width: 170px; height: 55px; background-color: #718355; border-radius: 10px; overflow: hidden;">
                <img src="{{ asset('images/cashg.png') }}" alt="GCash Logo" style="width: 140px; height: 55px; object-fit: contain; flex-shrink: 0;">
                </button>
            </div>
        </div>

        <!-- Mobile Number -->
        <div class="mb-3">
            <label for="mobileNo" class="form-label">Mobile Number:</label>
            <input type="text" class="form-control" name="mobileNo" id="mobileNo" value="{{ $reservationDetails->mobileNo }}" required>
        </div>

        <!-- Total Amount -->
        <div class="form-group">
            <label for="amount">Total Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" value="₱ {{ number_format($reservationDetails->amount, 2) }}" readonly>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('images/qrcode.png') }}" alt="QR Code" style="width:350px; height:350px;">
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="mobileNo" class="form-label fw-bold fs-5">Mobile Number:</label>
                        <input type="text" class="form-control fs-5" name="mobileNo" id="mobileNo" value="{{ auth()->user()->mobileNo }}" required style="height: 55px;">
                    </div>
                    <div class="mb-3">
                        <div class="d-flex">
                            <div class="me-2">
                                <label for="amount" class="form-label fw-bold fs-5">Amount:</label>
                                <input type="number" class="form-control fs-5" name="amount" id="amount" step="0.01" min="0" required style="height: 55px;">
                            </div>
                            <div>
                                <label for="upload_payment" class="form-label fw-bold fs-5">Upload Payment:</label>
                                <input class="form-control" type="file" name="upload_payment" id="upload_payment" style="height: 55px;">
                            </div>
                        </div>
                    </div>

        <!-- Upload Payment Proof -->
        <div class="mb-3">
            <label for="upload_payment" class="form-label">Upload Payment Proof:</label>
            <input class="form-control" type="file" name="upload_payment" id="upload_payment" required>
        </div>

        <!-- Reference Number -->
        <div class="mb-3">
            <label for="reference_num" class="form-label">Reference Number:</label>
            <input type="text" class="form-control" name="reference_num" id="reference_num" required>
                    <div class="mb-3">
                        <label for="reference_num" class="form-label fw-bold fs-5">Reference Number:</label>
                        <input type="text" class="form-control fs-5" name="reference_num" id="reference_num" required style="height: 55px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Finish Button (Triggers Modal) -->
        <button type="submit" class="btn btn-primary" style="width: 120px; height: 50px; float: right; margin-right: 10px; margin-top: 15px; background-color: #718355; font-size: 1.5rem; font-weight: bold" data-bs-toggle="modal" data-bs-target="#feedbackModal">
    Finish
</button>
    </form>
</div>

<!-- JavaScript to Compute Total Amount -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    function computeTotal() {
        let packageSelect = document.getElementById('package_id');
        let accomodationSelect = document.getElementById('accomodation_id');
        let amountField = document.getElementById('amount');

        let selectedPackage = packageSelect.selectedOptions[0] || {};
        let selectedAccommodation = accomodationSelect.selectedOptions[0] || {};

        let entranceFee = parseFloat(selectedPackage.dataset.entranceFee) || 0;
        let packagePrice = parseFloat(selectedPackage.dataset.packagePrice) || 0;
        let totalGuest = parseInt(selectedPackage.dataset.totalGuest) || 0;
        let accomodationPrice = parseFloat(selectedAccommodation.dataset.accomodationPrice) || 0;

        let totalAmount = (entranceFee * totalGuest) + accomodationPrice + packagePrice;
        amountField.value = '₱ ' + totalAmount.toFixed(2);
    }

    document.getElementById('package_id').addEventListener('change', computeTotal);
    document.getElementById('accomodation_id').addEventListener('change', computeTotal);
    computeTotal(); // Compute on page load
});
</script>


<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 660px;">
        <div class="modal-content custom-modal" style="background-color: #6B7546; border-radius: 30px;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Share Your Experience with Lelo’s Resort</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="rating-section">
                    <p class="fw-bold fs-5" style="color: #E5F9DB;">Experience</p>
                    <div class="stars" data-category="experience"></div>
                </div>
                <div class="rating-section">
                    <p class="fw-bold fs-5" style="color: #E5F9DB;">Reservation Process</p>
                    <div class="stars" data-category="reservation"></div>
                </div>
                <div class="rating-section">
                    <p class="fw-bold fs-5" style="color: #E5F9DB;">Customer Service</p>
                    <div class="stars" data-category="service"></div>
                </div>
                <p class="feedback-label text-center fs-5 fw-bold" style="color: #E5F9DB;">Give us your feedback?</p>
                <textarea class="form-control feedback-text" placeholder="Write your feedback here..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn submit-btn fs-5 fw-bold" style="color: #E5F9DB;">SUBMIT</button>
            </div>
        </div>
    </div>
</div>

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
</script>

</body>
</html>
