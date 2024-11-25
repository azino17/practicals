<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $stmt = $conn->prepare("INSERT INTO students (name, email, age) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $email, $age);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
