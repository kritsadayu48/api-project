<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "sautechnology.com"; // เปลี่ยนเป็นโฮสต์ของเซิร์ฟเวอร์ MySQL ของคุณ
$username = "u231198616_s6319410013"; // เปลี่ยนเป็นชื่อผู้ใช้ MySQL ของคุณ
$password = "S@u6319410013"; // เปลี่ยนเป็นรหัสผ่าน MySQL ของคุณ
$dbname = "u231198616_s6319410013_db"; // เปลี่ยนเป็นชื่อฐานข้อมูล MySQL ของคุณ

// รับค่า username และ password จากฟอร์ม
$user = $_POST['username'];
$pass = $_POST['password'];

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// คำสั่ง SQL สำหรับค้นหา username และ password ในตาราง adminLogin
$sql = "SELECT * FROM adminLogin WHERE username='$user' AND password='$pass'";
$result = $conn->query($sql);

// ตรวจสอบว่ามีผลลัพธ์ที่สอดคล้องหรือไม่
if ($result->num_rows > 0) {
    // ล็อกอินสำเร็จ
    echo "Login successful";
} else {
    // ล็อกอินไม่สำเร็จ
    echo "Invalid username or password";
}

$conn->close();
?>
