<?php
// ตั้งค่า CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

date_default_timezone_set('Asia/Bangkok');
// เรียกใช้ฟังก์ชัน date เพื่อสร้างวันที่และเวลาปัจจุบันในรูปแบบ Y-m-d H:i:s
$created_at = date("Y-m-d H:i:s");

// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = 'sautechnology.com'; // เช่น localhost
$database = 'u231198616_s6319410013_db'; // ชื่อฐานข้อมูลของคุณ
$username = 'u231198616_s6319410013'; // ชื่อผู้ใช้ MySQL
$password = 'S@u6319410013'; // รหัสผ่าน MySQL

// รับข้อมูลที่ส่งมาจากแอป
$data = json_decode(file_get_contents('php://input'), true);
$message = $data['message'];

// เชื่อมต่อกับ MySQL
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล (รวมกับคอลัมน์ created_at)
$sql = "INSERT INTO user_messages (message, created_at) VALUES ('$message', '$created_at')";

// ทำการเพิ่มข้อมูล
if ($conn->query($sql) === TRUE) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => $conn->error));
}

$conn->close();
