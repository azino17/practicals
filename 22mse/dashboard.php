<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
}

if (isset($_POST['submit_results'])) {
    $student_id = $_POST['student_id'];
    $subject1_mse = $_POST['subject1_mse'];
    $subject1_ese = $_POST['subject1_ese'];
    $subject2_mse = $_POST['subject2_mse'];
    $subject2_ese = $_POST['subject2_ese'];
    $subject3_mse = $_POST['subject3_mse'];
    $subject3_ese = $_POST['subject3_ese'];
    $subject4_mse = $_POST['subject4_mse'];
    $subject4_ese = $_POST['subject4_ese'];

    // Calculate final marks
    $final_marks = (($subject1_mse * 0.30) + ($subject1_ese * 0.70) +
                    ($subject2_mse * 0.30) + ($subject2_ese * 0.70) +
                    ($subject3_mse * 0.30) + ($subject3_ese * 0.70) +
                    ($subject4_mse * 0.30) + ($subject4_ese * 0.70)) / 4;

    // Insert the results into the database
    $query = "INSERT INTO results (student_id, subject1_mse, subject1_ese, subject2_mse, subject2_ese, subject3_mse, subject3_ese, subject4_mse, subject4_ese, final_marks)
              VALUES ('$student_id', '$subject1_mse', '$subject1_ese', '$subject2_mse', '$subject2_ese', '$subject3_mse', '$subject3_ese', '$subject4_mse', '$subject4_ese', '$final_marks')";
    
    if ($conn->query($query) === TRUE) {
        echo "Results submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Enter Student Marks</h2>
    <form action="dashboard.php" method="POST">
        <input type="hidden" name="student_id" value="<?= $_SESSION['student_id']; ?>">
        <label>Subject 1 MSE:</label>
        <input type="number" name="subject1_mse" required><br>
        <label>Subject 1 ESE:</label>
        <input type="number" name="subject1_ese" required><br>

        <label>Subject 2 MSE:</label>
        <input type="number" name="subject2_mse" required><br>
        <label>Subject 2 ESE:</label>
        <input type="number" name="subject2_ese" required><br>

        <label>Subject 3 MSE:</label>
        <input type="number" name="subject3_mse" required><br>
        <label>Subject 3 ESE:</label>
        <input type="number" name="subject3_ese" required><br>

        <label>Subject 4 MSE:</label>
        <input type="number" name="subject4_mse" required><br>
        <label>Subject 4 ESE:</label>
        <input type="number" name="subject4_ese" required><br>

        <button type="submit" name="submit_results">Submit Results</button>
    </form>
</body>
</html>
