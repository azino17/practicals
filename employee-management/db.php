<?php
$host = "localhost";
$username = "root";
$password = ""; // Leave blank for default MySQL setup in XAMPP
$dbname = "employee_db";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
