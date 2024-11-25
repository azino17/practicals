<?php
// Include database connection
include __DIR__ . '/db_connect.php';

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input to avoid SQL injection

    // SQL to delete the student
    $sql = "DELETE FROM students WHERE id = ?";
    
    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: ../index.php?message=Student deleted successfully");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

// Close the connection
$conn->close();
?>
