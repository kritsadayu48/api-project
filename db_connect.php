<?php
// Database configuration
$servername = "sautechnology.com"; 
$username = "u231198616_s6319410013"; 
$password = "S@u6319410013"; 
$database = "u231198616_s6319410013_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
