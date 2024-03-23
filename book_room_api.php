<?php

// Check if POST data is sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if necessary data is sent
    if (isset($_POST['bookDate']) && isset($_POST['bookCheckinDate']) && isset($_POST['bookCheckoutDate']) && isset($_POST['bookPrice']) && isset($_POST['bookStatusPaid']) && isset($_POST['bookStatusInOut']) && isset($_POST['custId']) && isset($_POST['roomId'])) {

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
            $bookDate = $_POST['bookDate'];
            $bookCheckinDate = $_POST['bookCheckinDate'];
            $bookCheckoutDate = $_POST['bookCheckoutDate'];
            $bookPrice = $_POST['bookPrice'];
            $bookStatusPaid = $_POST['bookStatusPaid'];
            $bookStatusInOut = $_POST['bookStatusInOut'];
            $custId = $_POST['custId'];
            $roomId = $_POST['roomId'];

            // Prepare SQL command
            $sql = "INSERT INTO booking (bookDate, bookCheckinDate, bookCheckoutDate, bookPrice, bookStatusPaid, bookStatusInOut, custId, roomId) VALUES (:bookDate, :bookCheckinDate, :bookCheckoutDate, :bookPrice, :bookStatusPaid, :bookStatusInOut, :custId, :roomId)";
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':bookDate', $bookDate);
            $stmt->bindParam(':bookCheckinDate', $bookCheckinDate);
            $stmt->bindParam(':bookCheckoutDate', $bookCheckoutDate);
            $stmt->bindParam(':bookPrice', $bookPrice);
            $stmt->bindParam(':bookStatusPaid', $bookStatusPaid);
            $stmt->bindParam(':bookStatusInOut', $bookStatusInOut);
            $stmt->bindParam(':custId', $custId);
            $stmt->bindParam(':roomId', $roomId);

            // Execute SQL command
            $stmt->execute();

            // Get the last inserted id
            $bookId = $conn->lastInsertId();

            // Send the bookId back to the application
            echo $bookId;
        } catch(PDOException $e) {
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
?>
