<?php

// Establish connection to the MySQL database
$servername = "sautechnology.com"; // Replace with your MySQL server host
$username = "u231198616_s6319410013"; // Replace with your MySQL username
$password = "S@u6319410013"; // Replace with your MySQL password
$dbname = "u231198616_s6319410013_db"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$custId = $_REQUEST['custId'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create SQL command to retrieve booking data, roomQR status, and room type
$sql = "SELECT b.*, r.roomQRStatus, rm.roomType 
        FROM booking AS b
        LEFT JOIN roomQR AS r ON b.roomId = r.roomId
        LEFT JOIN room AS rm ON b.roomId = rm.roomId
        WHERE b.custId = '" . $conn->real_escape_string($custId) . "'";

// Execute query
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Initialize an array to store booking details
    $bookings = array();
    // Store booking details in array
    while($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    // Convert booking details to JSON format and return to application
    echo json_encode($bookings);
} else {
    // If no data is found, return an empty array
    echo json_encode(array());
}

// Close database connection
$conn->close();
?>
