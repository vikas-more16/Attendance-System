<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic QR Code for Attendance</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="qr-container" id="qr-container">
            <h2>Scan to Mark Attendance</h2>
            <a href="markAttendance.html">   
                 <div id="qrcode"></div>
            </a>
            <script>
                // Set the URL for attendance marking
                let attendanceURL = window.location.origin + "/markAttendance.html"; 

                // Generate QR Code
                new QRCode(document.getElementById("qrcode"), {
                    text: attendanceURL, // The URL embedded in the QR code
                    width: 300,
                    height: 300
                });

                console.log("QR Code Generated for: " + attendanceURL);
            </script>
           <form action="Dashbord.php">
            <button id="close-qr-btn" type="submit"> QR
                and Show Results</button>
           </form>
           
    </div>
</body>
</html>