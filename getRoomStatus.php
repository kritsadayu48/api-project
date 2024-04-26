<?php
// Read JSON data sent from the app
$data = json_decode(file_get_contents('php://input'), true);

// Extract the roomId and custId from the JSON data
$roomId = $data['roomId'];
$custId = $data['custId'];

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

// Create SQL query to fetch roomQRStatus and potentially roomQRCode for the requested roomId
$sql = "SELECT roomQRStatus FROM roomQR WHERE roomId = ? AND custId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $roomId, $custId); // Bind the parameters to the SQL query
$stmt->execute();
$result = $stmt->get_result(); // Execute the query and get the result

if ($result->num_rows > 0) {
    // If data is found
    $row = $result->fetch_assoc();
    $roomQRStatus = $row['roomQRStatus'];
    $roomQRCode = $row['roomQRCode']; // Assuming you also want to fetch roomQRCode
    $response = array('status' => 'success', 'roomQRStatus' => $roomQRStatus);
} else {
    // If data is not found
    $response = array('status' => 'error', 'message' => 'Room not found');
}

// Close MySQL connection
$stmt->close();
$conn->close();

// Set header to ensure the response is treated as JSON
header('Content-Type: application/json');

// Send JSON response back to the app
echo json_encode($response);
?>
