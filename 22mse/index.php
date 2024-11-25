<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIT Semester Result System</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional CSS File -->
</head>
<body>
    <header>
        <h1>VIT Semester Result System</h1>
    </header>

    <nav>
        <ul>
            <?php if (isset($_SESSION['student_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <main>
        <section>
            <h2>Welcome to the VIT Semester Result System</h2>
            <p>This system helps students register, log in, and view their semester results based on MSE and ESE scores.</p>
            <p><strong>Features:</strong></p>
            <ul>
                <li>Student Registration</li>
                <li>Login for secure access</li>
                <li>Result entry and calculation (MSE: 30%, ESE: 70%)</li>
                <li>Responsive design for all devices</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> VIT Semester Result System. All Rights Reserved.</p>
    </footer>
</body>
</html>
