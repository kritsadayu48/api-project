<?php
// ทำการรับข้อมูลจากแอพพลิเคชั่น Flutter
$custFullName = $_POST['custFullName'];
$custEmail = $_POST['custEmail'];
$custPhone = $_POST['custPhone'];


// ทำการเชื่อมต่อฐานข้อมูล MySQL
$servername = "sautechnology.com";
$username = "u231198616_s6319410013";
$password = "S@u6319410013";
$dbname = "u231198616_s6319410013_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// อัปเดตข้อมูลผู้ใช้ในฐานข้อมูล
$sql = "UPDATE customer SET name='$custFullname', custEmail='$custEmail', custPhone='$custPhone' WHERE custId=1";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
