<?php
header('Content-Type: application/json');

$servername = 'sautechnology.com'; // เช่น localhost
$dbname = 'u231198616_s6319410013_db'; // ชื่อฐานข้อมูลของคุณ
$username = 'u231198616_s6319410013'; // ชื่อผู้ใช้ MySQL
$password = 'S@u6319410013'; // รหัสผ่าน MySQL

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => "Connection failed: " . $conn->connect_error]);
    exit();
}

$query = "SELECT r.roomQRId, r.roomId, r.custId, r.roomQRCode, r.roomQRStatus, r.roomTimeGen FROM roomQR r 
          LEFT JOIN booking b ON r.roomId = b.roomId AND r.custId = b.custId
          WHERE b.roomId IS NULL AND b.custId IS NULL";

$result = $conn->query($query);
$deleted_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expired_insert = "INSERT INTO roomQR_experid (roomQRId, roomId, custId, roomQRCode, roomQRStatus, roomTimeGen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($expired_insert);
        $stmt->bind_param("iiisss", $row['roomQRId'], $row['roomId'], $row['custId'], $row['roomQRCode'], $row['roomQRStatus'], $row['roomTimeGen']);
        $stmt->execute();

        $delete_query = "DELETE FROM roomQR WHERE roomQRId = ?";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bind_param("i", $row['roomQRId']);
        $delete_stmt->execute();

        $deleted_items[] = $row['roomQRId']; // Track deleted items
    }
    echo json_encode(['success' => "Expired room QR codes moved and deleted successfully.", 'deleted' => $deleted_items]);
} else {
    echo json_encode(['message' => "No expired room QR codes found."]);
}

$conn->close();
