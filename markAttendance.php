<?php
session_start(); // Start the session

// Database connection
$serverName = "localhost";
$userName = "root";
$password = "";
$DATABASE = "2r"; // Fetch database name from session
$SUBJECT = $_SESSION['Subject'];
$DATE = $_SESSION['Date'];

$conn = new mysqli($serverName, $userName, $password, $DATABASE);
if ($conn->connect_error) {
    die("<script>alert('Connection failed: " . $conn->connect_error . "'); window.location.href='markAttendance.html';</script>");
}

// ✅ Ensure 'roll-no' is Provided Before Processing
if (!isset($_POST['roll-no']) || empty($_POST['roll-no'])) {
    die("<script>alert('Error: Please select a roll number!'); window.location.href='markAttendance.html';</script>");
}

$roll = (int) $_POST['roll-no']; 

// ✅ Get the Actual Roll Number Column Name
$rollColumnQuery = "SHOW COLUMNS FROM `$SUBJECT`";
$rollColumnResult = $conn->query($rollColumnQuery);

$rollColumnName = null;
if ($rollColumnResult->num_rows > 0) {
    while ($row = $rollColumnResult->fetch_assoc()) {
        if (stripos($row['Field'], 'roll') !== false) { // Finds column with "roll" in the name
            $rollColumnName = $row['Field'];
            break;
        }
    }
}

// ✅ Ensure Roll Number Column Exists
if (!$rollColumnName) {
    die("<script>alert('Error: Roll number column not found!'); window.location.href='markAttendance.html';</script>");
}

// ✅ Ensure Date Column Exists
$checkColumn = "SHOW COLUMNS FROM `$SUBJECT` LIKE '$DATE'";
$result = $conn->query($checkColumn);
if ($result->num_rows == 0) {
    die("<script>alert('Error: Date column does not exist!'); window.location.href='markAttendance.html';</script>");
}

// ✅ Check if Roll Number Already Exists
$checkRoll = "SELECT * FROM `$SUBJECT` WHERE `$rollColumnName` = $roll";
$result = $conn->query($checkRoll);

if ($result->num_rows > 0) {
    // ✅ If Roll Number Exists, Update Attendance
    $updateAttendance = "UPDATE `$SUBJECT` SET `$DATE` = 'Present' WHERE `$rollColumnName` = $roll";
} else {
    // ✅ If Roll Number Does Not Exist, Insert New Row
    $updateAttendance = "INSERT INTO `$SUBJECT` (`$rollColumnName`, `$DATE`) VALUES ($roll, 'Present')";
}

// ✅ Execute Query
if ($conn->query($updateAttendance) === TRUE) {
    echo "<script>alert('Attendance marked successfully!'); window.location.href='markAttendance.html';</script>";
} else {
    echo "<script>alert('Error updating attendance: " . $conn->error . "'); window.location.href='markAttendance.html';</script>";
}

// ✅ Close Connection
$conn->close();
?>
