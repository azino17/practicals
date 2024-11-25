<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Employee</title>
</head>
<body>
    <h1>Add New Employee</h1>
    <form action="add.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="department">Department:</label>
        <input type="text" name="department" required><br>
        <button type="submit" name="submit">Add Employee</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $department = $_POST['department'];

        $sql = "INSERT INTO employees (name, email, department) VALUES ('$name', '$email', '$department')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Employee added successfully!</p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
    ?>
    <a href="index.php">View Employee List</a>
</body>
</html>
