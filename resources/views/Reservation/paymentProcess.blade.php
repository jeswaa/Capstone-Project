<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
<form action="{{ route('savePaymentProcess') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="payment_method">Payment Method:</label>
    <input type="checkbox" name="payment_method" id="gcash" value="gcash"> GCash
    <input type="checkbox" name="payment_method" id="bank_transfer" value="bank_transfer"> Bank Transfer

    <label for="mobileNo">Mobile Number:</label>
    <input type="text" name="mobileNo" id="mobileNo" value="{{ auth()->user()->mobileNo }}" required>

    <label for="amount">Amount:</label>
    <input type="number" name="amount" id="amount" step="0.01" min="0" required>

    <label for="upload_payment">Upload Payment Proof:</label>
    <input type="file" name="upload_payment" id="upload_payment">

    <label for="reference_num">Reference Number:</label>
    <input type="text" name="reference_num" id="reference_num" required>

    <button type="submit">Submit Payment</button>
</form>
</body>
</html>