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
                <input class="form-check-input" type="checkbox" name="payment_method" id="bank_transfer" value="bank_transfer">
                <label class="form-check-label" for="bank_transfer">Bank Transfer</label>
            </div>
        </div>

        <!-- Mobile Number -->
        <div class="mb-3">
            <label for="mobileNo" class="form-label">Mobile Number:</label>
            <input type="text" class="form-control" name="mobileNo" id="mobileNo" value="{{ auth()->user()->mobileNo }}" required>
        </div>

        <!-- Package Selection -->
        <div class="mb-3">
            <label for="package_id" class="form-label">Select Package:</label>
            <select class="form-select" id="package_id" name="package_id" disabled>
                <option value="" selected disabled>Select a package</option>
                @foreach ($packages as $package)
                    <option 
                        value="{{ $package->id }}" 
                        data-entrance-fee="{{ $entranceFee }}" 
                        data-accomodation-price="{{ $package->accomodation_price }}" 
                        data-total-guest="{{ $reservationDetails->total_guest }}" 
                        data-max-guests="{{ $package->package_max_guests }}" 
                        data-package-price="{{ $package->package_price }}"
                        {{ $package->id == $reservationDetails->package_id ? 'selected' : '' }}>
                        {{ $package->package_name }} - ₱{{ number_format($package->package_price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Accommodation Selection -->
        <div class="mb-3">
            <label for="accomodation_id" class="form-label">Select Accommodation:</label>
            <select class="form-select" id="accomodation_id" name="accomodation_id">
                @foreach ($accomodations as $accomodation)
                    <option 
                        value="{{ $accomodation->accomodation_id }}" 
                        data-accomodation-price="{{ $accomodation->accomodation_price }}">
                        {{ $accomodation->accomodation_name }} - ₱{{ number_format($accomodation->accomodation_price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Total Amount -->
        <div class="form-group">
            <label for="amount">Total Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" value="₱ 0.00" readonly>
        </div>

        <!-- Upload Payment Proof -->
        <div class="mb-3">
            <label for="upload_payment" class="form-label">Upload Payment Proof:</label>
            <input class="form-control" type="file" name="upload_payment" id="upload_payment">
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
        let selectedPackage = document.getElementById('package_id').selectedOptions[0];
        let selectedAccommodation = document.getElementById('accomodation_id').selectedOptions[0];
        
        let entranceFee = parseFloat(selectedPackage.dataset.entranceFee) || 0;
        let packagePrice = parseFloat(selectedPackage.dataset.packagePrice) || 0;
        let totalGuest = parseInt(selectedPackage.dataset.totalGuest) || 0;
        let accomodationPrice = parseFloat(selectedAccommodation.dataset.accomodationPrice) || 0;

        let totalAmount = (entranceFee * totalGuest) + (accomodationPrice * totalGuest) + packagePrice;
        document.getElementById('amount').value = '₱ ' + totalAmount.toFixed(2);
    }

    document.getElementById('package_id').addEventListener('change', computeTotal);
    document.getElementById('accomodation_id').addEventListener('change', computeTotal);
    computeTotal(); // Compute on page load
});
</script>

</body>
</html>

