<?php
// logout.php

session_start();        // Start session
session_unset();        // Unset all session variables
session_destroy();      // Destroy the session

// Redirect to login page with a success message
header("Location: login.php?message=logout");  
exit();
?>
