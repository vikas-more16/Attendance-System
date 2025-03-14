<?php
session_start();
$_SESSION['Class'] = $_POST['Class'];
$_SESSION['Subject'] = $_POST['Subject'];
$_SESSION['Date'] = $_POST['date'];

$Subject = $_SESSION['Subject'];
$Date = $_SESSION['Date'];
$serverName = "localhost";
$userName = "root";
$password = "";
$DATABASE = "2r"; 

$conn = new mysqli($serverName, $userName, $password, $DATABASE);
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "');</script>");
}

// Sanitize inputs
$Subject = mysqli_real_escape_string($conn, $Subject);
$Date = mysqli_real_escape_string($conn, $Date);

// Check if the column already exists
$checkColumn = "SHOW COLUMNS FROM `$Subject` LIKE '$Date'";
$result = $conn->query($checkColumn);

if ($result->num_rows == 0) {
    // Column does not exist, so add it
    $sql = "ALTER TABLE `$Subject` ADD COLUMN `$Date` VARCHAR(10) DEFAULT 'Absent'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: QR.html");
        exit();
    } else {
        echo "<script>alert('Error adding column: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>alert('Column already exists!');</script>";
    header("Location: QR.html");
    exit();
}

$conn->close();
?>
