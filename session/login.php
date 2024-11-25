<?php
session_start();
require_once 'config.php';  // Include database connection
require_once 'session_manager.php'; // Include session management functions

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Check if the username exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, create a session
        $_SESSION['user_id'] = $user['id'];

        // Check if the user has less than 3 active sessions
        if (createSession($user['id'])) {
            header('Location: index.php');  // Redirect to home/dashboard page
            exit();
        } else {
            echo "Maximum concurrent sessions reached.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

<form method="POST" action="login.php">
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username" required><br><br>
    
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password" required><br><br>
    
    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>
