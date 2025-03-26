<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>
    <h1>QR Code Scanner</h1>
    <video id="preview" width="300" height="300"></video>
    <p>Scanned QR Code: <span id="qrResult">None</span></p>
    <button id="toggleCamera" onclick="toggleCamera()">Toggle Camera</button>

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
                document.getElementById("toggleCamera").addEventListener("click", function() {
                    if (isCameraOn) {
                        scanner.stop();
                        isCameraOn = false;
                    } else {
                        scanner.start(cameras[0]);
                        isCameraOn = true;
                    }
                });
            } else {
                swal("Error", "No cameras found.", "error");
            }
        }).catch(function (e) {
            console.error(e);
            swal("Error", "An error occurred while accessing the cameras.", "error");
        });

        // Add button to turn off scanner
        let scannerStopButton = document.createElement("button");
        scannerStopButton.innerHTML = "Stop Scanner";
        scannerStopButton.onclick = function() {
            scanner.stop();
            isCameraOn = false;
        };
        document.body.appendChild(scannerStopButton);
    </script>
</body>
</html>

