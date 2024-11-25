<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'user_system');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Set cookie (optional, 7-day expiry)
            if (isset($_POST['remember'])) {
                setcookie('user_id', $user['id'], time() + (7 * 24 * 60 * 60), "/");
                setcookie('username', $user['username'], time() + (7 * 24 * 60 * 60), "/");
            }

            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No account found with that email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <label>
            <input type="checkbox" name="remember"> Remember Me
        </label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
