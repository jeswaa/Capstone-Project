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
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="payment_method" id="gcash" value="gcash">
                <label class="form-check-label" for="gcash">
                    GCash
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="payment_method" id="bank_transfer" value="bank_transfer">
                <label class="form-check-label" for="bank_transfer">
                    Bank Transfer
                </label>
            </div>
        </div>

        <div class="mb-3">
            <label for="mobileNo" class="form-label">Mobile Number:</label>
            <input type="text" class="form-control" name="mobileNo" id="mobileNo" value="{{ auth()->user()->mobileNo }}" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="number" class="form-control" name="amount" id="amount" step="0.01" min="0" required>
        </div>

        <div class="mb-3">
            <label for="upload_payment" class="form-label">Upload Payment Proof:</label>
            <input class="form-control" type="file" name="upload_payment" id="upload_payment">
        </div>

        <div class="mb-3">
            <label for="reference_num" class="form-label">Reference Number:</label>
            <input type="text" class="form-control" name="reference_num" id="reference_num" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
</div>
</body>
</html>

