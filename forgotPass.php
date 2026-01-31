<?php
include 'admin/config.php';

$step = 1;
$email = '';
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['check_email'])) {
        $email = trim($_POST['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $step = 2;
        } else {
            $error = "Email not found. Please try again.";
        }
    }

    if (isset($_POST['reset_password'])) {
        $email = $_POST['email'];
        $newpass = $_POST['new_password'];
        $confpass = $_POST['confirm_password'];

        if ($newpass !== $confpass) {
            $error = "Passwords do not match.";
            $step = 2;
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $newpass)) {
            $error = "Password must be at least 8 characters long, contain at least 1 uppercase letter and 1 number.";
            $step = 2;
        } else {
            $hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);
            $update = "UPDATE users SET password='$hashed_pass' WHERE email='$email'";
            if (mysqli_query($conn, $update)) {
                header("Location: login.php?reset=success");
                exit;
            } else {
                $error = "Something went wrong. Please try again.";
                $step = 2;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | ReviewSphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        .forgot-password-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            background: transparent;
            backdrop-filter: blur(20px);
            position: relative;
        }
        .forgot-password-container h3 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #00457c;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
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
        .toggle-eye {
            position: absolute;
            top: 38px;
            right: 12px;
            cursor: pointer;
            color: #000;
        }
        .footer-links {
            text-align: center;
            margin-top: 15px;
        }
        .footer-links a {
            color: #00457c;
            text-decoration: none;
            font-size: 14px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .message.error {
            color: red;
        }
        @media (max-width: 768px) {
            main {
                height: auto;
                padding: 20px 10px;
            }
            .forgot-password-container {
                padding: 45px;
            }
            .forgot-password-container h3 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>

<main>
    <div class="forgot-password-container">
        <h3>Forgot Password</h3>

        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" placeholder="email@example.com" size="43" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="check_email">Verify Email</button>
                </div>
            </form>
        <?php elseif ($step == 2): ?>
            <form method="POST" action="">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" size="43" required>
                    <i class="fas fa-eye-slash toggle-eye" onclick="togglePassword('new_password', this)"></i>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" size="43" required>
                    <i class="fas fa-eye-slash toggle-eye" onclick="togglePassword('confirm_password', this)"></i>
                </div>
                <div class="form-group">
                    <button type="submit" name="reset_password">Reset Password</button>
                </div>
            </form>
        <?php endif; ?>

        <div class="footer-links">
            <a href="login.php">Back to login</a>
        </div>
    </div>
</main>

<script>
function togglePassword(fieldId, icon) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        field.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
</script>

</body>
</html>
