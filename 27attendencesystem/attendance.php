<?php
session_start();
if (!isset($_SESSION['teacher_logged_in'])) {
    header("Location: teacher_login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "attendance_system";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attendance_date = $_POST['attendance_date'];

    foreach ($_POST['attendance'] as $student_id => $status) {
        $sql = "INSERT INTO attendance (student_id, attendance_date, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $student_id, $attendance_date, $status);
        $stmt->execute();
    }

    echo "Attendance recorded successfully!";
}

$students = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Take Attendance</title>
</head>
<body>
    <h2>Take Attendance</h2>
    <form method="post">
        <label for="attendance_date">Date:</label>
        <input type="date" name="attendance_date" required><br><br>

        <table border="1">
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Present</th>
                <th>Absent</th>
            </tr>
            <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['roll_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <input type="radio" name="attendance[<?php echo $row['id']; ?>]" value="Present" required>
                    </td>
                    <td>
                        <input type="radio" name="attendance[<?php echo $row['id']; ?>]" value="Absent" required>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <button type="submit">Submit Attendance</button>
    </form>
</body>
</html>
