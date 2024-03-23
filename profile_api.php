<?php
// ตัวอย่างการเชื่อมต่อกับฐานข้อมูล MySQL
$host = 'sautechnology.com';
$username = 'u231198616_s6319410013';
$password = 'S@u6319410013';
$database = 'u231198616_s6319410013_db';

// สร้างการเชื่อมต่อ
$connection = new mysqli($host, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// รับค่า custId จาก request
$custId = $_GET['custId'];

// คำสั่ง SQL เพื่อดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM customer WHERE custId = $custId";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // สร้างตัวแปร array เพื่อเก็บข้อมูลผู้ใช้
    $userData = array();
    while($row = $result->fetch_assoc()) {
        // เพิ่มข้อมูลผู้ใช้ลงใน array
        $userData = $row;
    }
    // ส่งข้อมูลผู้ใช้ในรูปแบบ JSON กลับไปยังแอป Flutter
    echo json_encode($userData);
} else {
    // หากไม่พบข้อมูลผู้ใช้
    echo "0 results";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล MySQL
$connection->close();
?>
