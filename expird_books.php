<?php

// กำหนดค่าเชื่อมต่อ MySQL
$servername = "sautechnology.com"; 
$username = "u231198616_s6319410013"; 
$password = "S@u6319410013"; 
$database = "u231198616_s6319410013_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// คำสั่ง SQL เพื่อเลือกข้อมูลการจองที่หมดอายุ
$sql = "SELECT * FROM booking WHERE bookCheckoutDate < NOW()";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // วนลูปผลลัพธ์และเพิ่มลงในตาราง expired_bookings
    while($row = $result->fetch_assoc()) {
        $insert_sql = "INSERT INTO expired_bookings (bookId, bookDate, bookCheckinDate, bookCheckoutDate, bookPrice, bookStatusPaid, bookStatusInOut, custId, roomId, paymentImage)
                       VALUES ('".$row["bookId"]."', '".$row["bookDate"]."', '".$row["bookCheckinDate"]."', '".$row["bookCheckoutDate"]."', '".$row["bookPrice"]."', '".$row["bookStatusPaid"]."', '".$row["bookStatusInOut"]."', '".$row["custId"]."', '".$row["roomId"]."', '".$row["paymentImage"]."')";
        
        if ($conn->query($insert_sql) === TRUE) {
            // ลบข้อมูลจองที่หมดอายุออกจากตาราง bookings
            $delete_sql = "DELETE FROM booking WHERE bookId = '".$row["bookId"]."'";
            $conn->query($delete_sql);
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "0 results";
}

$conn->close();
?>
