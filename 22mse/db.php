<?php
$host = "localhost"; // MySQL host
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "vit_result"; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
