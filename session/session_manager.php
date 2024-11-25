<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}

require_once 'config.php';

// Session timeout duration in seconds (5 minutes)
$timeout_duration = 300; // 300 seconds = 5 minutes

// Function to create a new session for the user, with a limit of 3 active sessions
function createSession() {
    global $pdo, $timeout_duration;

    // Ensure user_id is available in the session
    if (!isset($_SESSION['user_id'])) {
        // If user_id is not set in session, redirect to login page
        header('Location: login.php');
        exit();
    }

    $userId = $_SESSION['user_id']; // Get the user ID from the session

    // Step 1: Cleanup expired sessions (older than 5 minutes)
    $stmt = $pdo->prepare("DELETE FROM sessions WHERE user_id = :user_id AND start_time < NOW() - INTERVAL :timeout_duration SECOND");
    $stmt->execute(['user_id' => $userId, 'timeout_duration' => $timeout_duration]);

    // Step 2: Check the number of active sessions for this user
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM sessions WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $sessionCount = $stmt->fetchColumn();

    // Step 3: If less than 3 sessions, create a new session
    if ($sessionCount < 3) {
        $stmt = $pdo->prepare("INSERT INTO sessions (user_id, start_time) VALUES (:user_id, NOW())");
        $stmt->execute(['user_id' => $userId]);
        return true; // Session created successfully
    }

    // Step 4: If there are 3 or more sessions, deny session creation
    return false; // Maximum session limit reached
}

// Function to check session timeout and destroy expired sessions
function checkSessionTimeout() {
    global $pdo, $timeout_duration;

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // If the session has been inactive for more than 5 minutes, destroy it
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
            // Delete expired sessions from the database
            $stmt = $pdo->prepare("DELETE FROM sessions WHERE user_id = :user_id AND start_time < NOW() - INTERVAL :timeout_duration SECOND");
            $stmt->execute(['user_id' => $userId, 'timeout_duration' => $timeout_duration]);

            // Destroy the session
            session_unset();     // Remove all session variables
            session_destroy();   // Destroy the session

            header('Location: login.php'); // Redirect to login page
            exit();
        }

        // Update the last activity time
        $_SESSION['last_activity'] = time();
    }
}

// Call the functions as needed
checkSessionTimeout(); // Check for timeout and session cleanup
createSession(); // Attempt to create a new session (with max 3 concurrent sessions)
?>
