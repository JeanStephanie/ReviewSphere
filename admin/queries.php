<?php
include("config.php");

// Handle reply submission
if (isset($_POST['submit_reply'])) {
    $query_id = intval($_POST['query_id']);
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);
    $update_query = "UPDATE queries SET reply = '$reply', replied_at = NOW() WHERE id = $query_id";
    mysqli_query($conn, $update_query);
    header("Location: queries.php");
    exit();
}

$sql = "SELECT * FROM queries ORDER BY id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Queries | ReviewSphere</title>
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
            font-weight: bold;
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
        textarea {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .submit-btn {
            background-color: #00457c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .submit-btn:hover {
            background-color: #00315b;
        }
    </style>
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <h1>Queries</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Submitted On</th>
                    <th>Reply</th>
                    <th>Replied On</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td> <!-- ✅ NEW -->
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo date('d M Y', strtotime($row['submitted_at'])); ?></td>
                        <td>
                            <?php if (!empty($row['reply'])) { ?>
                                <div><?php echo nl2br(htmlspecialchars($row['reply'])); ?></div>
                            <?php } else { ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                                    <textarea name="reply" rows="3" required></textarea>
                                    <br>
                                    <button type="submit" name="submit_reply" class="submit-btn" onclick="return confirm('Submit this reply?')">Submit Reply</button>
                                </form>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $row['replied_at'] ? date('d M Y', strtotime($row['replied_at'])) : '-'; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
