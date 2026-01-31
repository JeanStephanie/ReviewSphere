<?php
session_start();
include("admin/config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = intval($_SESSION['user_id']);

$sql = "DELETE FROM users WHERE u_id = $u_id";
if (mysqli_query($conn, $sql)) {
    session_destroy();
    header("Location: index.php?delete=success");
    exit();
} else {
    echo "Error deleting account: " . mysqli_error($conn);
}
?>
