<?php
// Read JSON data sent from the app
$data = json_decode(file_get_contents('php://input'), true);

// Extract the roomId from the JSON data
$roomId = $data['roomId'];

// Database connection details
$servername = "sautechnology.com";
$username = "u231198616_s6319410013";
$password = "S@u6319410013";
$dbname = "u231198616_s6319410013_db";

// Create a MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create SQL query to fetch roomQRStatus and roomQRCode for the requested roomId
$sql = "SELECT roomQRStatus, roomQRCode FROM roomQR WHERE roomId = '1'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // If data is found
  $row = $result->fetch_assoc();
  $roomQRStatus = $row["roomQRStatus"];
  $roomQRCode = $row["roomQRCode"];
  $response = array('status' => 'success', 'roomQRStatus' => $roomQRStatus, 'roomQRCode' => $roomQRCode);
} else {
  // If data is not found
  $response = array('status' => 'error', 'message' => 'Room not found');
}

// Close MySQL connection
$conn->close();

// Send JSON response back to the app
echo json_encode($response);
