<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if student exists
    $query = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($query);
    $student = $result->fetch_assoc();

    if ($student && password_verify($password, $student['password'])) {
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['name'] = $student['name'];
        header('Location: dashboard.php');
    } else {
        echo "Invalid email or password!";
    }
}
?>
