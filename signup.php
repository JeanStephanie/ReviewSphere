<?php
// Include DB connection
include "admin/config.php";

// Handle form submission
$signup_error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        $signup_error = "Passwords do not match.";
    } else {
        // Password strength check (optional - already done in JS)
        $password_regex = "/^(?=.*[A-Z])(?=.*\d).{8,}$/";
        if (!preg_match($password_regex, $password)) {
            $signup_error = "Password must be at least 8 characters long, include at least 1 uppercase letter and 1 number.";
        } else {
            // Check if email already exists
            $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
            if (mysqli_num_rows($check) > 0) {
                $signup_error = "Email already registered. Try logging in.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert into database
                $insert = mysqli_query($conn, "INSERT INTO users (fname, lname, email, password) VALUES ('$fname', '$lname', '$email', '$hashed_password')");
                if ($insert) {
                    header("Location: login.php?signup=success"); // Redirect to login page
                    exit();
                } else {
                    $signup_error = "Something went wrong. Please try again.";
                }
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
    <title>Sign Up | ReviewSphere</title>
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
            height: auto;
            padding: 20px;
        }
        .signup-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            background: transparent;
            backdrop-filter: blur(20px);
        }
        .signup-container h3 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #00457c;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group a {
            color: #00457c;
            text-decoration: none;
        }
        .form-group a:hover {
            text-decoration: underline;
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
        .password-requirements {
            font-size: 12px;
            color: #333;
            margin-top: 5px;
        }
        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }
        @media (max-width: 768px) {
            main {
                height: auto;
                padding: 20px 10px;
            }
            .signup-container {
                padding: 45px;
            }
            .signup-container h3 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <main>
        <div class="signup-container">
            <h3>Create an Account</h3>

            <?php if (!empty($signup_error)): ?>
                <div class="error-message" style="text-align:center;"><?php echo $signup_error; ?></div>
            <?php endif; ?>

            <form id="signupForm" action="" method="POST">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="fname" placeholder="First Name" size="49" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lname" placeholder="Last Name" size="49" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="email@example.com" size="49" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" placeholder="Password" size="49" required>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i id="eyeIconPassword" class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <div class="password-requirements">
                        <ul>
                            <li>Minimum 8 characters</li>
                            <li>At least 1 uppercase letter</li>
                            <li>At least 1 number</li>
                        </ul>
                    </div>
                    <div id="passwordError" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div style="position: relative;">
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" size="49" required>
                        <span class="password-toggle" onclick="toggleConfirmPassword()">
                            <i id="eyeIconConfirmPassword" class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <div id="confirmPasswordError" class="error-message"></div>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="agreeToTerms" required> I agree to the <a href="./home/terms.html">Terms and Conditions</a>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit">Sign Up</button>
                </div>
            </form>

            <div class="footer-links">
                <a href="login.php">Already have an account? Log in</a>
            </div>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIconPassword = document.getElementById('eyeIconPassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIconPassword.classList.remove('fa-eye-slash');
                eyeIconPassword.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIconPassword.classList.remove('fa-eye');
                eyeIconPassword.classList.add('fa-eye-slash');
            }
        }

        function toggleConfirmPassword() {
            const confirmPasswordField = document.getElementById('confirmPassword');
            const eyeIconConfirmPassword = document.getElementById('eyeIconConfirmPassword');
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                eyeIconConfirmPassword.classList.remove('fa-eye-slash');
                eyeIconConfirmPassword.classList.add('fa-eye');
            } else {
                confirmPasswordField.type = 'password';
                eyeIconConfirmPassword.classList.remove('fa-eye');
                eyeIconConfirmPassword.classList.add('fa-eye-slash');
            }
        }

        document.getElementById('signupForm').addEventListener('submit', function (event) {
            let isValid = true;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            passwordError.textContent = '';
            confirmPasswordError.textContent = '';

            const passwordRegex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;
            if (!password.match(passwordRegex)) {
                passwordError.textContent = 'Password must be at least 8 characters long, contain at least 1 uppercase letter and 1 number.';
                isValid = false;
            }
            if (password !== confirmPassword) {
                confirmPasswordError.textContent = 'Passwords do not match.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
