<?php

// Check if POST data is sent
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if necessary data is sent
    $data = json_decode(file_get_contents("php://input"), true); // Decode JSON data
    if (isset($data['custId']) && isset($data['roomId'])) {
        // Database connection settings
        $host = 'sautechnology.com';
        $dbname = 'u231198616_s6319410013_db';
        $username = 'u231198616_s6319410013';
        $password = 'S@u6319410013';

        try {
            // Connection to MySQL using PDO
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Receive data from the application
            $custId = $data['custId'];
            $roomId = $data['roomId'];

            // Prepare SQL command to fetch checkout date from booking table
            $fetchCheckoutDateSql = "SELECT bookCheckoutDate FROM booking WHERE custId = :custId AND roomId = :roomId";
            $stmt = $conn->prepare($fetchCheckoutDateSql);
            $stmt->bindParam(':custId', $custId);
            $stmt->bindParam(':roomId', $roomId);
            $stmt->execute();

            // Fetch the checkout date
            $checkoutDate = $stmt->fetchColumn();

            // Check if checkout date is available
            if ($checkoutDate) {
                // Return the checkout date as JSON response
                echo json_encode(['bookCheckoutDate' => $bookCheckoutDate]);
            } else {
                // Return empty response if checkout date is not available
                echo json_encode(['error' => 'Checkout date not found']);
            }
        } catch (PDOException $e) {
            // Handle database connection error
            echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
        }
    } else {
        // If data is incomplete
        $missingParams = [];
        if (!isset($data['custId'])) {
            $missingParams[] = 'custId';
        }
        if (!isset($data['roomId'])) {
            $missingParams[] = 'roomId';
        }
        echo json_encode(['error' => 'Required parameters are missing: ' . implode(', ', $missingParams)]);
    }
} else {
    // If data is not sent via POST method
    echo json_encode(['error' => 'Invalid request method']);
}
