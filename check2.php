<?php
// อ่านข้อมูล JSON ที่ส่งมาจากแอพ
$data = json_decode(file_get_contents('php://input'), true);

// ดึงค่า roomId จากข้อมูล JSON
$roomId = isset($data['roomId']) ? $data['roomId'] : 'default_room_id';

// ตั้งค่าการเชื่อมต่อกับฐานข้อมูล
$servername = "sautechnology.com"; 
$username = "u231198616_s6319410013"; 
$password = "S@u6319410013"; 
$dbname = "u231198616_s6319410013_db";

// สร้างการเชื่อมต่อ MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลของห้องที่ร้องขอ
$sql = "SELECT roomQRStatus, roomQRCode FROM roomQR WHERE roomId = '2'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // ถ้าพบข้อมูล
  $row = $result->fetch_assoc();
  $response = array('status' => 'success', 'roomQRStatus' => $row["roomQRStatus"], 'roomQRCode' => $row["roomQRCode"]);
} else {
  // ถ้าไม่พบข้อมูล
  $response = array('status' => 'error', 'message' => 'Room not found');
}

// ปิดการเชื่อมต่อ MySQL
$conn->close();

// ส่งข้อมูลกลับไปยังแอพ
echo json_encode($response);
?>
