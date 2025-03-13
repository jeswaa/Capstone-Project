<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <form action="{{ route('savePaymentProcess') }}" method="POST" enctype="multipart/form-data">
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

        <!-- Upload Payment Proof -->
        <div class="mb-3">
            <label for="upload_payment" class="form-label">Upload Payment Proof:</label>
            <input class="form-control" type="file" name="upload_payment" id="upload_payment" required>
        </div>

        <!-- Reference Number -->
        <div class="mb-3">
            <label for="reference_num" class="form-label">Reference Number:</label>
            <input type="text" class="form-control" name="reference_num" id="reference_num" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Payment</button>
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

</body>
</html>
