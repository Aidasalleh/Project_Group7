<?php
session_start();
include("connection.php"); // Ensure you have database connection established

// Function to validate password strength
function validatePassword($password) {
    // Password length should be at least 8 characters
    if (strlen($password) < 8) {
        return false;
    }
    // Password should contain at least one uppercase letter, one lowercase letter, one number, and one special character
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^A-Za-z0-9]/', $password)) {
        return false;
    }
    return true;
}

?>

<html>

<head>
    <title>Reset Password</title>

    <style>
        body {
            background-color:rgb(232, 240, 173);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        #header {
            color:rgb(49, 100, 255);
            font-size: 24px;
            padding: 20px;
            background-color: rgb(243, 249, 74);
        }

        a {
            color: #9B59B6;
            text-decoration: none;
        }

        #content {
            padding: 20px;
            width: 50%;
            margin: 0 auto;
        }

        form {
            width: 100%;
            margin-top: 20px;
            text-align: left;
        }

        table {
            width: 100%;
            border: 0;
        }

        table td {
            padding: 10px;
        }

        .error {
            color: red;
        }

        .back-btn {
            margin-top: 20px;
        }

        .notification {
            margin-top: 10px;
            padding: 10px;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
            border-radius: 5px;
        }

        .requirements {
            margin-top: 10px;
            padding: 10px;
            background-color: #d9edf7;
            border: 1px solid #bce8f1;
            color: #31708f;
            border-radius: 5px;
        }
    </style>
    <script>
        // Client-side validation for password strength and matching passwords
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            // Reset error messages
            document.getElementById("password_error").innerHTML = "";
            document.getElementById("confirm_password_error").innerHTML = "";

            // Validate password strength
            if (!validatePassword(password)) {
                document.getElementById("password_error").innerHTML = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                return false;
            }

            // Validate password and confirm password match
            if (password !== confirmPassword) {
                document.getElementById("confirm_password_error").innerHTML = "Passwords do not match.";
                return false;
            }

            return true;
        }
    </script>
</head>

<body>

<!-- Header with an optional image -->
<div id="header">
    <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
    <h1>STUDENT REGISTRATION SYSTEM</h1>
</div>

<!-- Main content area -->
<div id="content">

    <?php
    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        // Check if token is valid and not expired
        $current_time = date('Y-m-d H:i:s');
        $query = "SELECT * FROM login WHERE reset_token='$token' AND token_expiry > '$current_time'";
        $result = mysqli_query($mysqli, $query) or die("Token verification failed.");

        if (mysqli_num_rows($result) == 1) {
            // Token is valid, allow user to reset password
            if (isset($_POST['submit'])) {
                $password = mysqli_real_escape_string($mysqli, $_POST['password']);
                $confirmPassword = mysqli_real_escape_string($mysqli, $_POST['confirm_password']);

                // Validate password strength and match
                if ($password !== $confirmPassword || !validatePassword($password)) {
                    echo '<div class="notification"><p class="error">Password validation failed. ';
                    echo 'Please check the requirements and ensure passwords match.</p></div>';
                    echo '<div class="back-btn"><a href="javascript:history.go(-1)">Go Back</a></div>'; // Added Go Back button
                } else {
                    $pass = hash('sha256', $password);
                    $row = mysqli_fetch_assoc($result);
                    $email = $row['email'];

                    // Update password in the database
                    $update_query = "UPDATE login SET password='$pass', reset_token=NULL, token_expiry=NULL WHERE email='$email'";
                    mysqli_query($mysqli, $update_query) or die("Password update failed.");

                    echo '<div class="notification"><p>Your password has been successfully reset.</p></div>';
                    // You can redirect the user to login page or wherever appropriate
                }
            } else {
                // Display reset password form
                ?>
                <div>
                    <h2>Reset Password</h2>
                    <div class="requirements">
                        <p>Password must be at least 8 characters long and contain:</p>
                        <ul>
                            <li>At least one uppercase letter</li>
                            <li>At least one lowercase letter</li>
                            <li>At least one number</li>
                            <li>At least one special character</li>
                        </ul>
                    </div>
                    <form method="post" action="" onsubmit="return validateForm()">
                        <table>
                            <tr>
                                <td>New Password:</td>
                                <td><input type="password" id="password" name="password"></td>
                                <td><span id="password_error" class="error"></span></td>
                            </tr>
                            <tr>
                                <td>Confirm Password:</td>
                                <td><input type="password" id="confirm_password" name="confirm_password"></td>
                                <td><span id="confirm_password_error" class="error"></span></td>
                            </tr>
                            <tr>
                                <td colspan="3"><input type="submit" name="submit" value="Reset Password"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="back-btn">
                    <a href="index.php">Back to Home</a>
                </div>
            <?php
            }
        } else {
            echo '<div class="notification"><p>Invalid or expired reset token.</p></div>';
        }
    } else {
        echo '<div class="notification"><p>Token not provided.</p></div>';
    }
    ?>
</div>

<!-- Footer section -->
<div id="footer">
    <p>© 2025 Group7sec1. All Rights Reserved.</p>
</div>

</body>

</html>
