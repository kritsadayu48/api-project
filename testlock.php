<?php
// Read JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

// Get roomId from JSON data
$roomId = $data['roomId'];

// Perform action based on roomId
// Example: Update status from 1 to 0
// Replace this with your actual database update logic
// สมมติว่าคุณใช้ MySQL ในการเก็บข้อมูล
// และมีตารางชื่อว่า rooms ที่มีคอลัมน์ชื่อว่า roomQRStatus เพื่อเก็บสถานะของห้อง
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

// Update room status from 0 to 1 for the specified roomId
$sql = "UPDATE roomQR SET roomQRStatus = 1 WHERE roomId = '$roomId'";

if ($conn->query($sql) === TRUE) {
  // Update successful
  $response = array('status' => 'success');
} else {
  // Update failed
  $response = array('status' => 'error', 'message' => 'Failed to update room status');
}

// Close connection
$conn->close();

// Send response back to the app
echo json_encode($response);
?>
