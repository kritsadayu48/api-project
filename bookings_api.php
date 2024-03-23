<?php

// ทำการเชื่อมต่อกับฐานข้อมูล MySQL
$servername = "sautechnology.com"; // เปลี่ยนเป็นโฮสต์ของเซิร์ฟเวอร์ MySQL ของคุณ
$username = "u231198616_s6319410013"; // เปลี่ยนเป็นชื่อผู้ใช้ MySQL ของคุณ
$password = "S@u6319410013"; // เปลี่ยนเป็นรหัสผ่าน MySQL ของคุณ
$dbname = "u231198616_s6319410013_db"; // เปลี่ยนเป็นชื่อฐานข้อมูล MySQL ของคุณ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

$custId =  $_REQUEST['custId'];


// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// สร้างคำสั่ง SQL เพื่อดึงข้อมูลการจอง
$sql = "SELECT * FROM booking where  custid='".$custId."' ";

// ดึงข้อมูลจากฐานข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // สร้างอาร์เรย์เพื่อเก็บข้อมูลการจอง
    $bookings = array();
    // เก็บข้อมูลการจองในอาร์เรย์
    while($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    // แปลงข้อมูลเป็นรูปแบบ JSON และส่งกลับไปยังแอพพลิเคชัน
    echo json_encode($bookings);
} else {
    // ถ้าไม่มีข้อมูล ส่งข้อความว่างกลับไปยังแอพพลิเคชัน
    echo json_encode(array());
}

// ปิดการเชื่อมต่อฐานข้อมูล MySQL
$conn->close();
?>
