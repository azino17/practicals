<?php
$host = "localhost"; // Database host
$dbname = "test"; // Replace with your database name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
