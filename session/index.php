<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

echo "Welcome, user!<br>";
echo "You are logged in with user ID: " . $_SESSION['user_id'];
?>

<p><a href="logout.php">Logout</a></p>
