<?php
// Read JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

// Get roomId, custId, and scannedCode from JSON data
$roomId = $data['roomId'];
$custId = $data['custId'];
$scannedCode = $data['scannedCode'];

// Validate inputs to prevent SQL injection
$roomId = filter_var($roomId, FILTER_SANITIZE_STRING);
$custId = filter_var($custId, FILTER_SANITIZE_STRING);
$scannedCode = filter_var($scannedCode, FILTER_SANITIZE_STRING);

// Database credentials
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

// SQL to check if the scanned QR code matches the expected QR code
$sql = "SELECT roomQRCode FROM roomQR WHERE roomId = ? AND custId = ?";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $roomId, $custId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $expectedQRCode = $row['roomQRCode'];

  if ($scannedCode === $expectedQRCode) {
    // QR Code is correct, update the room status or perform some action
    $updateSql = "UPDATE roomQR SET roomQRStatus = 0 WHERE roomId = ? AND custId = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $roomId, $custId);
    if ($updateStmt->execute()) {
      $response = array('status' => 'success', 'message' => 'Room unlocked successfully');
    } else {
      $response = array('status' => 'error', 'message' => 'Failed to unlock room');
    }
    $updateStmt->close();
  } else {
    // QR Code does not match
    $response = array('status' => 'error', 'message' => 'Invalid or incorrect QR Code');
  }
} else {
  // No data found for custId and roomId
  $response = array('status' => 'error', 'message' => 'No matching room found for the provided customer and room ID');
}

$stmt->close();
$conn->close();

// Send response back to the app
echo json_encode($response);
