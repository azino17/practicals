<?php
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if fields are empty
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); 

    // Prepare SQL query to insert the data
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful.";
            // Redirect to login page or dashboard after successful registration
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
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
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
