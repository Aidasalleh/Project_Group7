<?php
session_start();
include("connection.php"); // Ensure you have a database connection established

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>

<html>

<head>
    <title>Forgot Password</title>

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
            background-color: rgb(243, 249, 74); /* White background for header */
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
    </style>
</head>

<body>

<!-- Header -->
<div id="header">
    <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
    <h1>STUDENT REGISTRATION SYSTEM</h1>
</div>

<!-- Main Content -->
<div id="content">
    <a href="index.php">Home</a> <br />

    <?php
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p>Invalid email address. Please try again.</p>";
        } else {
            $token = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $sql = "UPDATE login SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
            if (mysqli_query($mysqli, $sql)) {
                if (mysqli_affected_rows($mysqli) > 0) {
                    $reset_link = "http://localhost/studreg/reset_password.php?token=" . $token;

                    $mail = new PHPMailer(true);

                    try {
                        // SMTP Configuration
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'biawakgoreng700@gmail.com'; // Replace with your Gmail
                        $mail->Password = 'hyre oosk tvni qppx'; // Replace with your App Password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Recipients
                        $mail->setFrom('your_email@gmail.com', 'Student Registration System');
                        $mail->addAddress($email);

                        // Email Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Reset your password';
                        $mail->Body = "Please click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

                        $mail->send();
                        echo "<p>An email has been sent with instructions to reset your password.</p>";
                    } catch (Exception $e) {
                        echo "<p>Failed to send the reset email. Mailer Error: {$mail->ErrorInfo}</p>";
                    }
                } else {
                    echo "<p>Email address not found. Please try again.</p>";
                }
            } else {
                echo "<p>Database error: " . mysqli_error($mysqli) . "</p>";
            }
        }
    } else {
    ?>
        <p><font size="+2">Forgot Password</font></p>
        <form method="post" action="">
            <table>
                <tr>
                    <td width="20%">Enter your email address:</td>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
    <?php
    }
    ?>
</div>

<!-- Footer -->
<div id="footer">
    <p>© 2025 Group7sec1. All Rights Reserved.</p>
</div>

</body>

</html>
