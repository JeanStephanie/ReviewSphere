<?php
include("config.php");

// Handle review deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM reviews WHERE r_id = $delete_id";
    mysqli_query($conn, $delete_query);
    header("Location: reviews.php");
    exit();
}

$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$sql = "SELECT reviews.*, CONCAT(users.fname, ' ', users.lname) AS user_name FROM reviews
        LEFT JOIN users ON reviews.u_id = users.u_id";

if (!empty($categoryFilter)) {
    $categoryFilterEscaped = mysqli_real_escape_string($conn, $categoryFilter);
    $sql .= " WHERE reviews.product_name = '$categoryFilterEscaped'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Reviews | ReviewSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .filter-section {
            margin-bottom: 20px;
        }
        select, button {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #00457c;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .media-placeholder {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <h1>Manage Reviews</h1>

        <div class="filter-section">
            <form method="GET" action="">
                <label for="category">Filter by Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <option value="Mobile" <?php if($categoryFilter == "Mobile") echo 'selected'; ?>>Mobile</option>
                    <option value="Laptop" <?php if($categoryFilter == "Laptop") echo 'selected'; ?>>Laptop</option>
                    <option value="TV" <?php if($categoryFilter == "TV") echo 'selected'; ?>>TV</option>
                    <option value="Speaker" <?php if($categoryFilter == "Speaker") echo 'selected'; ?>>Speaker</option>
                    <option value="Washing Machine" <?php if($categoryFilter == "Washing Machine") echo 'selected'; ?>>Washing Machine</option>
                    <option value="AC" <?php if($categoryFilter == "AC") echo 'selected'; ?>>AC</option>
                    <option value="Refrigerator" <?php if($categoryFilter == "Refrigerator") echo 'selected'; ?>>Refrigerator</option>
                    <option value="Vacuum Cleaner" <?php if($categoryFilter == "Vacuum Cleaner") echo 'selected'; ?>>Vacuum Cleaner</option>
                    <option value="Car" <?php if($categoryFilter == "Car") echo 'selected'; ?>>Car</option>
                    <option value="Scooter" <?php if($categoryFilter == "Scooter") echo 'selected'; ?>>Scooter</option>
                    <option value="Bike" <?php if($categoryFilter == "Bike") echo 'selected'; ?>>Bike</option>
                    <option value="Pickup Truck" <?php if($categoryFilter == "Pickup Truck") echo 'selected'; ?>>Pickup Truck</option>
                    <option value="Mattress" <?php if($categoryFilter == "Mattress") echo 'selected'; ?>>Mattress</option>
                    <option value="Pillow" <?php if($categoryFilter == "Pillow") echo 'selected'; ?>>Pillow</option>
                    <option value="Bedsheet" <?php if($categoryFilter == "Bedsheet") echo 'selected'; ?>>Bedsheet</option>
                    <option value="Lighting" <?php if($categoryFilter == "Lighting") echo 'selected'; ?>>Lighting</option>
                    <option value="Skincare" <?php if($categoryFilter == "Skincare") echo 'selected'; ?>>Skincare</option>
                    <option value="Haircare" <?php if($categoryFilter == "Haircare") echo 'selected'; ?>>Haircare</option>
                    <option value="Makeup" <?php if($categoryFilter == "Makeup") echo 'selected'; ?>>Makeup</option>
                    <option value="Grooming Devices" <?php if($categoryFilter == "Grooming Devices") echo 'selected'; ?>>Grooming Devices</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Image</th>
                    <th>Video</th>
                    <th>Uploaded</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['r_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['brand']); ?></td>
                        <td><?php echo htmlspecialchars($row['model']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?>/5</td>
                        <td><?php echo htmlspecialchars($row['review_text']); ?></td>
                        <td>
                            <?php if (!empty($row['image'])) { ?>
                                <a href="../uploads/images/<?php echo $row['image']; ?>" target="_blank">
                                    <img src="../uploads/images/<?php echo $row['image']; ?>" alt="Image" style="width:50px; height:auto; border-radius:6px;">
                                </a>
                            <?php } else { ?>
                                <span class="media-placeholder">No Image</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($row['video'])) { ?>
                                <a href="../uploads/videos/<?php echo $row['video']; ?>" target="_blank">
                                    <i class="fas fa-play-circle" style="font-size:22px; color:#00457c;"></i>
                                </a>
                            <?php } else { ?>
                                <span class="media-placeholder">No Video</span>
                            <?php } ?>
                        </td>
                        <td><?php echo isset($row['upload_date']) ? date('d M Y', strtotime($row['upload_date'])) : '—'; ?></td>
                        <td><?php echo isset($row['updated_date']) ? date('d M Y', strtotime($row['updated_date'])) : '—'; ?></td>
                        <td>
                            <button class="delete-btn" onclick="confirmDelete(<?php echo $row['r_id']; ?>)">Delete</button>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this review?")) {
                window.location.href = "reviews.php?delete_id=" + id;
            }
        }
    </script>
</body>
</html>