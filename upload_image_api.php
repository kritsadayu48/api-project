<?php
header('Content-Type: application/json');

// Database connection
$servername = "sautechnology.com";
$username = "u231198616_s6319410013";
$password = "S@u6319410013";
$database = "u231198616_s6319410013_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Upload image
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Get image data
    $image_data = file_get_contents($_FILES["image"]["tmp_name"]);

    // Convert image data to base64
    $image_base64 = base64_encode($image_data);

    // Get booking details
    $bookId = $_POST['bookId']; // Assuming you pass bookId from your Flutter app
    $custId = $_POST['custId']; // Assuming you pass custId from your Flutter app

    // File uploaded successfully, now insert into database with bookId and custId
    $sql = "UPDATE booking SET paymentImage = '$image_base64' WHERE bookId = $bookId AND custId = $custId";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Image uploaded and saved successfully"));
    } else {
        echo json_encode(array("error" => "Error saving image: " . $conn->error));
    }
} else {
    echo json_encode(array("error" => "Invalid request"));
}

$conn->close();
?>
