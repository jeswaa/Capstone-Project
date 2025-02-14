<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Summary</title>
    <style>
        img.qr-code {
            width: 150px;
            height: 150px;
        }
        #qrCodeContainer {
            margin-top: 20px;
        }
    </style>
    <!-- Include QRCode.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
</head>
<body>
    <!-- Personal Details Section -->
    <h2>Personal Details</h2>
    @if (isset(Auth::user()->personalDetails))
        <p>Name: {{ Auth::user()->personalDetails->name }}</p>
        <p>Email: {{ Auth::user()->personalDetails->email }}</p>
        <p>Phone: {{ Auth::user()->personalDetails->mobileNo }}</p>
        <p>Address: {{ Auth::user()->personalDetails->address }}</p>
        <p>Number of Guests: {{ Auth::user()->personalDetails->number_of_guests }}</p>
    @else
        <p>No personal details found.</p>
    @endif

    

    <!-- Text to QR Code Section -->
    <h2>Text to QR Code</h2>
    <form id="qrCodeForm">
        <label for="textInput">Enter Text:</label>
        <input type="text" id="textInput" value="{{ isset(Auth::user()->personalDetails) ? Auth::user()->personalDetails->name : '' }}" required>
        <button type="button" onclick="generateQRCode()">Generate QR Code</button>
    </form>

    <!-- QR Code Container -->
    <div id="qrCodeContainer" style="display:none;">
        <h3>Generated QR Code</h3>
        <div id="qrCode"></div>
    </div>

    <script>
        function generateQRCode() {
            const text = document.getElementById('textInput').value;

            // Validate input
            if (!text.trim()) {
                alert('Please enter some text to generate a QR code.');
                return;
            }

            // Show the QR Code container
            const qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.style.display = 'block';

            // Clear previous QR code
            document.getElementById('qrCode').innerHTML = '';

            // Generate QR Code using QRCode.js
            new QRCode(document.getElementById('qrCode'), {
                text: text,
                width: 150,
                height: 150
            });
        }
    </script>
</body>
</html>