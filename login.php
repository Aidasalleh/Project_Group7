<?php
session_start();
include("connection.php");

$error_message = '';

if (isset($_POST['submit'])) {
    // Verify reCAPTCHA
    $recaptcha_secret = "6LenTDspAAAAAChDepGmGP7Tubv1ZoxI8l9T7NCZ"; // Replace with your reCAPTCHA secret key
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
    $response = file_get_contents($verify_url);
    $recaptcha_data = json_decode($response);

    if (!$recaptcha_data->success) {
        $error_message = "reCAPTCHA verification failed.";
    } else {
        // Sanitize and hash user inputs
        $user = mysqli_real_escape_string($mysqli, $_POST['username']);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);
        $pass = hash('sha256', $password);

        if ($user == "" || $password == "") {
            $error_message = "Either username or password field is empty.";
        } else {
            $result = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$user' AND password='$pass' AND approval='1'")
                or die("Could not execute the select query.");

            $row = mysqli_fetch_assoc($result);

            if (is_array($row) && !empty($row)) {
                // User authenticated, generate and send OTP
                $otp = rand(100000, 999999); // Generate 6-digit OTP
                $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP valid for 10 minutes

                // Store OTP and its expiry time in the database
                $update_otp_query = "UPDATE login SET reset_otp='$otp', otp_expiry='$expiry' WHERE username='$user'";
                $update_result = mysqli_query($mysqli, $update_otp_query);

                if (!$update_result) {
                    die("Could not update OTP: " . mysqli_error($mysqli));
                }

                // Send OTP to user email
                $to = $row['email'];
                $subject = 'Your OTP for Login';
                $message = "Your OTP for login is: $otp";
                $headers = 'From: biawakgoreng700@gmail.com' . "\r\n" .
                           'Reply-To: biawakgoreng700@gmail.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);

                // Redirect to OTP verification page
                $_SESSION['valid'] = $user;
                header('Location: verify_otp.php');
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        #content {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #0000001a;
        }
        .error-message {
            color: red;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div id="header">
        <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
        <h1>STUDENT REGISTRATION SYSTEM CENDEKIA GEMILANG SCHOOL</h1>
    </div>
    <div id="content">
        <a href="index.php">Home</a> <br />
        <p><font size="+2">Login</font></p>
        <div class="form-container">
            <?php
            if ($error_message != '') {
                echo "<div class='alert alert-danger' role='alert'>{$error_message}</div>";
            }
            ?>
            <form name="form1" method="post" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <!-- reCAPTCHA integration -->
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6LenTDspAAAAAAUZlstO3f0WowCrJkLKC58RSARN"></div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <br />
        <a href="forgot_password.php">Forgot Password?</a>
    </div>
    <div id="footer">
        <p>© 2025 Group7sec1. All Rights Reserved.</p>
    </div>
</body>
</html>
<?php
?>
