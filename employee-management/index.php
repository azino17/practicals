<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Employee List</title>
</head>
<body>
    <h1>Employee List</h1>
    <a href="add.php">Add New Employee</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM employees";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No employees found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
