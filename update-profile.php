<?php
session_start();
include("admin/config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = intval($_SESSION['user_id']);  // Ensure it's an integer

// Sanitize user input
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);

// Build the SQL query
$sql = "UPDATE users SET 
            fname = '$fname', 
            lname = '$lname'
        WHERE u_id = $u_id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php?update=success");
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>
