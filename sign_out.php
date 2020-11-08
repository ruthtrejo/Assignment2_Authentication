<?php
// Initialize the session.
session_start();
// Unset all of the session variables.
unset($_SESSION['users_name']);
unset($_SESSION['logged_in']);
unset($_SESSION['status']);
unset($_SESSION['firstName']);
// Finally, destroy the session.
session_destroy();

// Include URL for Login page to login again.
header("Location: mainpage.php");
exit;