<?php
session_start();
include 'config.php';

$error = ""; // Default

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin_email'] = $email;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!-- Below is HTML part -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | ReviewSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../images/logo.png" type="image/png">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f6fa;
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #00457c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
        }

        .form-group input {
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #00457c;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #00325e;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .error-msg {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<main>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if (isset($_GET['message']) && $_GET['message'] == 'loggedout'): ?>
            <div style="color: green; margin-bottom: 10px; text-align: center;">Logged out successfully.</div>
        <?php endif; ?>

        <?php if (!empty($error)) { echo "<div class='error-msg'>$error</div>"; } ?>
        <form action="/ReviewSphere/admin/admin_login.php" method="post">
            <div class="form-group">
                <label>Email</label><br>
                <input type="email" name="email" size="52" placeholder="email@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div style="position: relative;">
                        <input type="password" id="password" name="password" size="52" placeholder="Password" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i id="eyeIcon" class="fas fa-eye-slash"></i>
                        </span>
                </div>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</main>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }
    </script>

</body>
</html>
