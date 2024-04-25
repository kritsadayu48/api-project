<?php

// Include database connection
require_once('db_connect.php');

// Check if POST data exists
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roomId'])) {
    
    // Extract roomId from POST data
    $roomId = $_POST['roomId'];

    // Prepare SQL statement to fetch roomQRCode and roomQRStatus based on roomId
    $stmt = $conn->prepare("SELECT roomQRCode, roomQRStatus FROM roomQR WHERE roomId = ?");
    $stmt->bind_param("s", $roomId);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result($roomQRCode, $roomQRStatus);

        // Fetch values
        $stmt->fetch();

        // Close statement
        $stmt->close();

        // Create JSON response
        $response = array(
            'roomQRCode' => $roomQRCode,
            'roomQRStatus' => $roomQRStatus
        );

        // Return JSON response
        echo json_encode($response);
    } else {
        // Error in executing SQL statement
        echo json_encode(array('message' => 'Failed to fetch room data.'));
    }
} else {
    // Invalid request method or missing roomId
    echo json_encode(array('message' => 'Invalid request.'));
}

?>
