<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center">
            <h1 class="mb-4">QR Code Scanner</h1>
            <div class="card mx-auto" style="width: 20rem;">
                <div class="card-body">
                    <video id="preview" class="img-fluid mb-4" width="100%" height="auto"></video>
                    <p class="font-weight-bold">Scanned QR Code: <span id="qrResult" class="text-muted">None</span></p>
                    <button id="toggleCamera" class="btn btn-primary mb-3 w-100" onclick="toggleCamera()">Toggle Camera</button>
                    <!-- Stop Scanner button -->
                    <button id="stopScanner" class="btn btn-danger w-100" style="display: none;" onclick="stopScanner()">Stop Scanner</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add scripts -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        let isCameraOn = false;

        scanner.addListener('scan', function (content) {
            document.getElementById("qrResult").innerText = content; // Display scanned QR content
            swal("Scanned!", "QR Code Content: " + content, "success");
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                // Toggle camera on and off
                document.getElementById("toggleCamera").addEventListener("click", function() {
                    if (isCameraOn) {
                        stopScanner();
                    } else {
                        scanner.start(cameras[0]);
                        isCameraOn = true;
                        document.getElementById("toggleCamera").style.display = 'none';
                        document.getElementById("stopScanner").style.display = 'block';
                    }
                });
            } else {
                swal("Error", "No cameras found.", "error");
            }
        }).catch(function (e) {
            console.error(e);
            swal("Error", "An error occurred while accessing the cameras.", "error");
        });

        // Stop scanner
        function stopScanner() {
            scanner.stop();
            isCameraOn = false;
            document.getElementById("toggleCamera").style.display = 'block';
            document.getElementById("stopScanner").style.display = 'none';
        }
    </script>
</body>
</html>
