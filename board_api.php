<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");

// Include database connection
include_once 'db_connect.php';

// Check if the request method is POST and roomId parameter is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roomId'])) {
    // Get roomId from POST parameters
    $roomId = $_POST['roomId'];

    // Update roomQRStatus in the database from 1 to 0 for the specified roomId
    $query = $conn->prepare("UPDATE roomQR SET roomQRStatus = 0 WHERE roomId = ?");
    $query->bind_param("s", $roomId);
    $query->execute();

    // Check if the update was successful
    if ($query->affected_rows > 0) {
        // Return success response
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Room unlocked successfully']);

        // Wait for 15 seconds
        sleep(15);

        // Update roomQRStatus back to 1 after 15 seconds
        $query = $conn->prepare("UPDATE roomQR SET roomQRStatus = 1 WHERE roomId = ?");
        $query->bind_param("s", $roomId);
        $query->execute();
    } else {
        // Return error response
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to unlock room']);
    }
} else {
    // If the request method is not POST or roomId parameter is not provided
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

?>
