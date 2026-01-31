<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}
include("config.php");

// Get counts for dashboard stats
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$review_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reviews"))['total'];
$query_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM queries"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | ReviewSphere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            background-color: #00457c;
            padding-top: 20px;
            color: white;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #00315b;
        }
        .main-content {
            margin-left: 240px;
            padding: 30px;
        }
        h1 {
            margin-bottom: 20px;
            color: #00457c;
        }
        .dashboard-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            min-width: 250px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .card i {
            font-size: 28px;
            color: #00457c;
        }
        .card .info {
            display: flex;
            flex-direction: column;
        }
        .card .info .number {
            font-size: 22px;
            font-weight: bold;
        }
        .card .info .label {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <h1>Welcome, Admin!</h1>

        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-users"></i>
                <div class="info">
                    <div class="number"><?php echo $user_count; ?></div>
                    <div class="label">Total Users</div>
                </div>
            </div>
            <div class="card">
                <i class="fas fa-star"></i>
                <div class="info">
                    <div class="number"><?php echo $review_count; ?></div>
                    <div class="label">Total Reviews</div>
                </div>
            </div>
            <div class="card">
                <i class="fas fa-envelope"></i>
                <div class="info">
                    <div class="number"><?php echo $query_count; ?></div>
                    <div class="label">Contact Queries</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
