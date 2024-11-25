<?php
$host = 'localhost';  // or localhost
$dbname = 'user_sessions';  // Your database name
$username = 'root';  // Your database username
$password = '';  // Your database password (empty for XAMPP by default)

// Set up the PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
