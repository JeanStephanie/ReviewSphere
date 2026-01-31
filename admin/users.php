<?php
include 'config.php';

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM users WHERE u_id = $delete_id";
    mysqli_query($conn, $delete_query);
    header("Location: users.php");
    exit();
}

// Fetch users
$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Users | ReviewSphere</title>
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
    </style>
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <h1>All Users</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['u_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['fname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <button class="delete-btn" onclick="confirmDelete(<?php echo $row['u_id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "users.php?delete_id=" + id;
            }
        }
    </script>
</body>
</html>
