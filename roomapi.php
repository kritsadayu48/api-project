<?php
// กำหนด Header เพื่อให้ส่งค่า JSON กลับไปยัง Client
header("Content-Type: application/json; charset=UTF-8");

// ตั้งค่าการเชื่อมต่อกับฐานข้อมูล MySQL
$servername = "sautechnology.com";
$username = "u231198616_s6319410013"; // ชื่อผู้ใช้ฐานข้อมูล
$password = "S@u6319410013"; // รหัสผ่านฐานข้อมูล
$database = "u231198616_s6319410013_db"; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เขียนคำสั่ง SQL เพื่อดึงข้อมูลห้อง
$sql = "SELECT * FROM room";
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลห้องหรือไม่
if ($result->num_rows > 0) {
    $room = array();
    // เก็บข้อมูลห้องในรูปแบบของ Array
    while ($row = $result->fetch_assoc()) {
        $roomId = $row['roomId'];
        $checkBookingSql = "SELECT * FROM booking WHERE roomId = '$roomId'";
        $bookingResult = $conn->query($checkBookingSql);

        // หากห้องไม่มีการจองอยู่ ให้เปลี่ยนสถานะเป็น Available
        if ($bookingResult->num_rows == 0) {
            $row['statusRoom'] = 'Available'; // อัปเดตสถานะห้องในข้อมูลที่ส่งกลับไปยัง Client
            $updateRoomStatusSql = "UPDATE room SET statusRoom = 'Available' WHERE roomId = '$roomId'";
            if ($conn->query($updateRoomStatusSql) !== TRUE) {
                echo "Error updating room status: " . $conn->error;
            }
        }
        $room[] = $row;
    }

    // ส่งค่า JSON กลับไปยัง Client
    echo json_encode($room);
} else {
    echo "0 results";
}

$conn->close();
?>
