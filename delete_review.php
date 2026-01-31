<?php
session_start();
include 'admin/config.php';

if (isset($_GET['r_id']) && isset($_SESSION['user_id'])) {
    $r_id = intval($_GET['r_id']);
    $u_id = $_SESSION['user_id'];

    // Check if the review belongs to this user (using prepared statement)
    $stmt = $conn->prepare("SELECT * FROM reviews WHERE r_id = ? AND u_id = ?");
    $stmt->bind_param("ii", $r_id, $u_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Proceed with delete
        $deleteStmt = $conn->prepare("DELETE FROM reviews WHERE r_id = ?");
        $deleteStmt->bind_param("i", $r_id);
        if ($deleteStmt->execute()) {
            $_SESSION['delete_status'] = "success";
        } else {
            $_SESSION['delete_status'] = "error";
        }
    } else {
        // Unauthorized attempt
        $_SESSION['delete_status'] = "unauthorized";
    }
} else {
    $_SESSION['delete_status'] = "invalid";
}
header("Location: reviews.php");
exit();
?>
