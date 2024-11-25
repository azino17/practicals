<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "attendance_system";

$conn = new mysqli($host, $user, $pass, $dbname);

$result = $conn->query("SELECT s.roll_no, s.name, a.attendance_date, a.status FROM attendance a JOIN students s ON a.student_id = s.id ORDER BY a.attendance_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Attendance</title>
</head>
<body>
    <h2>Attendance Records</h2>
    <table border="1">
        <tr>
            <th>Roll No</th>
            <th>Name</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['roll_no']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['attendance_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
