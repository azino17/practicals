<?php
session_start();

// Check if session or cookie exists
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

// Use session or cookie data
$user_id = $_SESSION['user_id'] ?? $_COOKIE['user_id'];
$username = $_SESSION['username'] ?? $_COOKIE['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>You are now logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
