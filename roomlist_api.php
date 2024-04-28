<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "sautechnology.com";
$username = "u231198616_s6319410013";
$password = "S@u6319410013";
$dbname = "u231198616_s6319410013_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// รับค่าประเภทห้องจากแอปพลิเคชัน Flutter
$roomType = $_GET['roomType']; // สมมติว่ารับค่าผ่าน URL parameter ชื่อ room_type

// คำสั่ง SQL เพื่อดึงข้อมูลห้องตามประเภทที่ระบุ
$sql = "SELECT * FROM room WHERE roomType = '$roomType'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // สร้าง array เพื่อเก็บข้อมูลห้องทั้งหมด
  $rooms = array();
  while($row = $result->fetch_assoc()) {
    // เพิ่มข้อมูลของแต่ละห้องลงใน array
    $rooms[] = $row;
  }
  // แปลง array เป็น JSON และส่งค่ากลับไปยังแอปพลิเคชัน Flutter
  echo json_encode($rooms);
} else {
  // ถ้าไม่มีข้อมูลห้องที่ตรงกับเงื่อนไข
  echo "0 results";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
