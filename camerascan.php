<?php
// Read JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

// Get roomId and custId from JSON data
$roomId = $data['roomId'];
$custId = $data['custId'];

$servername = "sautechnology.com";
$username = "u231198616_s6319410013";
$password = "S@u6319410013";
$dbname = "u231198616_s6319410013_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to update room status from 1 to 0 for the specified roomId and custId
$sql = "UPDATE roomQR SET roomQRStatus = 0 WHERE roomId = ? AND custId = ?";

// Prepare the SQL statement to avoid SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $roomId, $custId);
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    // Update successful
    $response = array('status' => 'success', 'message' => 'Room status updated successfully');
} else {
    // Update failed or no change needed
    $response = array('status' => 'error', 'message' => 'Failed to update room status or no changes made');
}

// Now fetch the current status to confirm update
$sql = "SELECT roomQRStatus FROM roomQR WHERE roomId = ? AND custId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $roomId, $custId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If data is found
    $row = $result->fetch_assoc();
    $roomQRStatus = $row["roomQRStatus"];
    $response = array('status' => 'success', 'roomQRStatus' => $roomQRStatus);
} else {
    // If no data is found
    $response = array('status' => 'error', 'message' => 'Room not found');
}

// Close statement and connection
$stmt->close();
$conn->close();

// Send response back to the app
echo json_encode($response);
