<?php
session_start();
require 'db_connection.php'; // Include your database connection file

// Function to clean up expired sessions (older than 5 minutes)
function cleanExpiredSessions($conn) {
    $stmt = $conn->prepare("DELETE FROM user_sessions WHERE last_activity < NOW() - INTERVAL 5 MINUTE");
    $stmt->execute();
}

// Function to enforce the maximum concurrent session limit
function enforceSessionLimit($conn, $user_id, $max_sessions = 3) {
    // Clean expired sessions first
    cleanExpiredSessions($conn);

    // Count the active sessions for the user
    $stmt = $conn->prepare("SELECT COUNT(*) AS session_count FROM user_sessions WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $active_sessions = $row['session_count'];

    if ($active_sessions >= $max_sessions) {
        // Fetch and delete the oldest session if the limit is reached
        $stmt = $conn->prepare("SELECT session_id FROM user_sessions WHERE user_id = ? ORDER BY last_activity ASC LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $oldest_session = $result->fetch_assoc();

        if ($oldest_session) {
            // Remove the oldest session
            $stmt = $conn->prepare("DELETE FROM user_sessions WHERE session_id = ?");
            $stmt->bind_param("s", $oldest_session['session_id']);
            $stmt->execute();
        }
    }

    // Register the current session in the database
    $session_id = session_id();
    $stmt = $conn->prepare("REPLACE INTO user_sessions (session_id, user_id, last_activity) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $session_id, $user_id);
    $stmt->execute();
}

// Example user ID (in a real application, fetch it from the logged-in user's session)
$user_id = 1; // Replace with the actual logged-in user's ID

// Enforce the session limit (allowing a maximum of 3 concurrent sessions)
enforceSessionLimit($conn, $user_id);

// Display a message indicating the session is active
echo "Session active for user ID: $user_id";

// Debugging: View the user's current sessions
$stmt = $conn->prepare("SELECT * FROM user_sessions WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    echo "<br>Session ID: " . $row['session_id'] . ", Last Activity: " . $row['last_activity'];
}
?>
