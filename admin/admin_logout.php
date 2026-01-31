<?php
session_start();
session_destroy();
header("Location: admin_login.php?message=loggedout");
exit();
?>
