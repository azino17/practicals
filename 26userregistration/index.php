<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to User System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Welcome to the User Login System</h1>
    <p>Choose an option below:</p>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
</body>
</html>
