<?php

// Check if POST data is sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if necessary data is sent
    if (isset($_POST['roomId']) && isset($_POST['custId'])) {
        // Database connection settings
        $host = 'sautechnology.com'; // เช่น localhost
        $dbname = 'u231198616_s6319410013_db'; // ชื่อฐานข้อมูลของคุณ
        $username = 'u231198616_s6319410013'; // ชื่อผู้ใช้ MySQL
        $password = 'S@u6319410013'; // รหัสผ่าน MySQL

        // Connection to MySQL using PDO
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Receive data from the application
            $roomId = intval($_POST['roomId']);
            $custId = intval($_POST['custId']);

            // Prepare SQL command to insert data into roomQR table
            $insertRoomQrSql = "INSERT INTO roomQR (roomId, roomQRCode, roomTimeGen, roomQRStatus, custId) 
                                VALUES (:roomId, :roomQRCode, :roomTimeGen, :roomQRStatus, :custId)";

            $insertRoomQrStmt = $conn->prepare($insertRoomQrSql);

            // Generate roomQRCode and roomTimeGen
            $roomQRCode = bin2hex(random_bytes(200));
            date_default_timezone_set('Asia/Bangkok');
            $roomTimeGen = date("Y-m-d H:i:s");
            $roomQRStatus = 1; // Set default value to 1 for locked room

            // Bind parameters and execute SQL command
            $insertRoomQrStmt->bindParam(':roomId', $roomId);
            $insertRoomQrStmt->bindParam(':roomQRCode', $roomQRCode);
            $insertRoomQrStmt->bindParam(':roomTimeGen', $roomTimeGen);
            $insertRoomQrStmt->bindParam(':roomQRStatus', $roomQRStatus);
            $insertRoomQrStmt->bindParam(':custId', $custId);
            $insertRoomQrStmt->execute();

            echo "Room ID saved successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } else {
        // If data is incomplete
        echo "Required parameters are missing";
    }
} else {
    // If data is not sent via POST method
    echo "Invalid request method";
}
