<?php
session_start();
include 'config.php';

// Get total users
$userResult = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$userData = mysqli_fetch_assoc($userResult);
$totalUsers = $userData['total_users'];

// Get total reviews
$reviewResult = mysqli_query($conn, "SELECT COUNT(*) AS total_reviews FROM reviews");
$reviewData = mysqli_fetch_assoc($reviewResult);
$totalReviews = $reviewData['total_reviews'];

// Get total contact queries
$queryResult = mysqli_query($conn, "SELECT COUNT(*) AS total_queries FROM contact_queries");
$queryData = mysqli_fetch_assoc($queryResult);
$totalQueries = $queryData['total_queries'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
        }

        .container {
            margin-left: 220px;
            padding: 30px;
        }

        .stat-box {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            font-size: 30px;
            color: #00457c;
        }

        .stat-text h3 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }

        .stat-text p {
            margin: 5px 0 0;
            color: #777;
        }

        .heading {
            font-size: 26px;
            color: #00457c;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="container">
        <h2 class="heading">Welcome to Admin Dashboard</h2>

        <div class="stat-box">
            <i class="fas fa-users stat-icon"></i>
            <div class="stat-text">
                <h3><?php echo $totalUsers; ?></h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="stat-box">
            <i class="fas fa-star stat-icon"></i>
            <div class="stat-text">
                <h3><?php echo $totalReviews; ?></h3>
                <p>Total Reviews</p>
            </div>
        </div>

        <div class="stat-box">
            <i class="fas fa-envelope stat-icon"></i>
            <div class="stat-text">
                <h3><?php echo $totalQueries; ?></h3>
                <p>Total Contact Queries</p>
            </div>
        </div>
    </div>

</body>
</html>
