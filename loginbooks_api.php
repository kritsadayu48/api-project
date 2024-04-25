<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "sautechnology.com"; 
$username = "u231198616_s6319410013"; 
$password = "S@u6319410013"; 
$dbname = "u231198616_s6319410013_db";

// สร้างการเชื่อมต่อใหม่
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// คำสั่ง SQL สำหรับการดึงข้อมูลห้องที่มีการจองและสถานะของการจอง
$sql = "SELECT  custId, roomId, bookDate,bookStatusPaid,bookCheckinDate,bookCheckoutDate FROM booking";

// ส่งคำสั่ง SQL ไปยังฐานข้อมูล
$result = $conn->query($sql);

// ตรวจสอบว่ามีข้อมูลที่ถูกดึงมาหรือไม่
if ($result->num_rows > 0) {
    // สร้าง array เพื่อเก็บข้อมูลที่ดึงมา
    $data = array();

    // วนลูปเพื่อดึงข้อมูลทุกแถวจากผลลัพธ์ที่ได้
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // ส่งข้อมูลที่ดึงมากลับไปยังแอปพลิเคชันในรูปแบบ JSON
    echo json_encode($data);
} else {
    // ถ้าไม่มีข้อมูล
    echo "No data found";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
