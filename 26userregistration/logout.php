<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Clear cookies
setcookie('user_id', '', time() - 3600, "/");
setcookie('username', '', time() - 3600, "/");

header("Location: login.php");
exit();
?>
