<?php
// Database connection details
$servername = "sautechnology.com"; 
$username = "u231198616_s6319410013"; 
$password = "S@u6319410013"; 
$dbname = "u231198616_s6319410013_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query
$sql = "SELECT * FROM roomQR";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    // Create an array to store the data
    $data = array();

    // Loop through each row and add it to the data array
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert the data array to JSON format
    $json_data = json_encode($data);

    // Set the appropriate headers for the API response
    header('Content-Type: application/json');
    echo $json_data;
} else {
    echo "No data found";
}

// Close the database connection
$conn->close();
?>