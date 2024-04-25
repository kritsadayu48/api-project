<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // ตั้งค่า CORS ให้อนุญาตให้แอพพลิเคชันเรียกใช้ API ได้จากทุกที่

// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = 'sautechnology.com'; // เช่น localhost
$database = 'u231198616_s6319410013_db'; // ชื่อฐานข้อมูลของคุณ
$username = 'u231198616_s6319410013'; // ชื่อผู้ใช้ MySQL
$password = 'S@u6319410013'; // รหัสผ่าน MySQL

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูล roomType และ roomPrice จากฐานข้อมูล
$sql = "SELECT DISTINCT roomType, roomPrice FROM room";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // สร้าง array เพื่อเก็บข้อมูลราคาและประเภทห้อง
    $rooms = array();
    while ($row = $result->fetch_assoc()) {
        $room = array(
            'roomType' => $row['roomType'],
            'roomPrice' => $row['roomPrice']
        );
        $rooms[] = $room;
    }
    echo json_encode($rooms); // แปลง array เป็น JSON และแสดงผลลัพธ์
} else {
    echo json_encode(array('message' => 'ไม่พบข้อมูล')); // แสดงข้อความแจ้งเตือนถ้าไม่พบข้อมูล
}
$conn->close();
