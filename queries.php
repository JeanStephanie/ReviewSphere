<?php
include 'admin/config.php';
session_start();

$user_email = $_SESSION['user_email'];

$sql = "SELECT * FROM queries WHERE email = ? ORDER BY submitted_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Queries & Replies</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
        }
        .container {
            margin: 40px auto;
            max-width: 1200px;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
            color: #00457c;
            text-align: center;
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
        .text-muted {
            color: #888;
            font-style: italic;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 12px;
            border-radius: 20px;
            font-weight: bold;
        }
        .badge.success {
            background-color: #28a745;
            color: white;
        }
        .badge.pending {
            background-color: #ffc107;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>My Queries & Replies</h1>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Message</th>
                <th>Submitted On</th>
                <th>Reply</th>
                <th>Replied On</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['subject'] ?? 'No Subject'); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo date("d M Y", strtotime($row['submitted_at'])); ?></td>
                        <td>
                            <?php if (!empty($row['reply'])) {
                                echo nl2br(htmlspecialchars($row['reply']));
                            } else {
                                echo '<span class="text-muted">Awaiting admin reply...</span>';
                            } ?>
                        </td>
                        <td>
                            <?php echo !empty($row['replied_at']) ? date("d M Y", strtotime($row['replied_at'])) : '-'; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['reply'])) {
                                echo '<span class="badge success">Replied</span>';
                            } else {
                                echo '<span class="badge pending">Pending</span>';
                            } ?>
                        </td>
                    </tr>
            <?php } } else { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">You haven't submitted any queries yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
