<?php
include 'admin/config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$subject = !empty($_POST['subject']) ? $_POST['subject'] : NULL;
$message = $_POST['message'];

$sql = "INSERT INTO queries (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    header("Location: index.php?query=success");
    exit();
} else {
    header("Location: index.php?query=fail");
    exit();
}
?>
