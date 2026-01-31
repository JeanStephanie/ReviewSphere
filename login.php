<?php
session_start();
include 'admin/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Use password_verify to compare input password with hashed password
        if (password_verify($password, $row['password'])) {
            // Password match – start session and redirect
            $_SESSION['user_id'] = $row['u_id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['fname'];

            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ReviewSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="./images/logo.png" type="image/png">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f4f9;
            margin: 0;
            padding: 0;
            background-image: url("images/background.jpg");
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 120px);
            padding: 20px;
        }

        .login-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            background: transparent;
            backdrop-filter: blur(20px);
        }

        .login-container h3 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #00457c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #00457c;
        }

        .form-group input[type="checkbox"] {
            width: 15px;
            height: 15px;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #00457c;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #00315b;
        }

        .footer-links {
            text-align: center;
            margin-top: 15px;
        }

        .footer-links p {
            font-size: 14px;
            color: #333;
        }

        .footer-links a {
            color: #00457c;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            main {
                height: auto;
                padding: 20px 10px;
            }

            .login-container {
                padding: 45px;
            }

            .login-container h3 {
                font-size: 30px;
            }
        }

        .error-msg {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }

        .alert-success {
            color: green;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <main>
        <div class="login-container">
            <h3>ReviewSphere</h3>

            <?php
            if (isset($_GET['message']) && $_GET['message'] === 'logout') {
                echo '<div class="alert-success">You have been logged out successfully.</div>';
            }

            // Password Reset Success Message
            if (isset($_GET['reset']) && $_GET['reset'] === 'success') {
                echo '<div class="alert-success">Password reset successfully. Please login with your new password.</div>';
            }

            // Signup Success Message
            if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
                echo '<div class="alert-success">Account created successfully. Please log in.</div>';
            }

            // Show login error message if any
            if (!empty($error)) {
                echo "<div class='error-msg'>$error</div>";
            }
            ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" size="43" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" size="43" placeholder="Password" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i id="eyeIcon" class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit">Log in</button>
                </div>
            </form>

            <div class="footer-links">
                <a href="forgotPass.php">Forgot password?</a><br>
                <p>New around here? <a href="signup.php">Sign up</a></p>
            </div>
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
