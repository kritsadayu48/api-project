<?php
// กำหนดค่าตัวแปรสำหรับการเชื่อมต่อฐานข้อมูล MySQL
$servername = "localhost"; // ชื่อ Host
$username = "u231198616_s6319410013"; // ชื่อผู้ใช้ของฐานข้อมูล MySQL
$password = "S@u6319410013"; // รหัสผ่านของฐานข้อมูล MySQL
$dbname = "u231198616_s6319410013_db"; // ชื่อฐานข้อมูลที่ต้องการใช้งาน

// รับค่าที่ส่งมาจากแอปพลิเคชัน
$custFullname = $_POST['custFullname'];
$custUsername = $_POST['custUsername'];
$custPassword = $_POST['custPassword'];
$custEmail = $_POST['custEmail'];
$custPhone = $_POST['custPhone'];
// รับรูปภาพ (หากมี)
if(isset($_FILES['custImage'])){
    $file_name = $_FILES['custImage']['name'];
    $file_temp = $_FILES['custImage']['tmp_name'];
    move_uploaded_file($file_temp,"uploads/".$file_name);
    $custImage = $file_name;
}

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในฐานข้อมูล
$sql = "INSERT INTO customer (custFullname, custUsername, custPassword, custEmail, custPhone, custImage)
VALUES ('$custFullname', '$custUsername', '$custPassword', '$custEmail', '$custPhone', '$custImage')";

// ทำการเพิ่มข้อมูลลงในฐานข้อมูล
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
