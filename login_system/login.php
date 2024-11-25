<?php
include('includes/config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the fields are empty
    if (empty($username) || empty($password)) {
        echo "Both fields are required.";
        exit();
    }

    // Prepare SQL query to select the user by username
    $sql = "SELECT * FROM users WHERE username = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter to the query
        $stmt->bind_param("s", $username);
        
        // Execute the query
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();

        // Check if the username exists
        if ($result->num_rows > 0) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify the password against the hash stored in the database
            if (password_verify($password, $user['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo "Login successful!";
                // Redirect to the dashboard or home page
                header("Location: dashboard.php");
                exit();
            } else {
                // Invalid password
                echo "Incorrect password.";
            }
        } else {
            // User not found
            echo "No user found.";
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
