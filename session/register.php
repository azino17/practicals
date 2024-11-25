<?php
session_start();
require_once 'config.php'; // Database connection
require_once 'session_manager.php'; // For session management

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validate input (basic validation)
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert the new user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $existingUser = $stmt->fetch();

    // Check if the username already exists
    if ($existingUser) {
        echo "Username is already taken.";
    } else {
        // Insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);

        // Automatically log the user in after registration
        $userId = $pdo->lastInsertId(); // Get the last inserted user ID
        $_SESSION['user_id'] = $userId;

        // Redirect to the home page or a success page
        header('Location: index.php');  // Redirect to home page after registration
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>
        
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
