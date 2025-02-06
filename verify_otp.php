<?php
session_start();
include("connection.php");

if (isset($_POST['verify'])) {
    $otp = mysqli_real_escape_string($mysqli, $_POST['otp']);
    $user = $_SESSION['valid'];

    // Check if OTP is correct and not expired
    $query = "SELECT * FROM login WHERE username='$user' AND reset_otp='$otp' AND otp_expiry > NOW()";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        // Error in query execution
        echo "<div class='alert alert-danger'>Error in query: " . mysqli_error($mysqli) . "</div>";
    } else if (mysqli_num_rows($result) == 1) {
        // OTP is correct and not expired, complete login
        $row = mysqli_fetch_assoc($result);
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        header('Location: index.php');
        exit();
    } else {
        echo "<div class='alert alert-danger'>Invalid or expired OTP. Please try again.</div>";
    }
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <style>
        body {
            background-color:rgb(232, 240, 173);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        #content {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        form {
            width: 50%;
            margin: 0 auto;
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
    <div id="content">
        <h2>Verify OTP</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" name="otp" class="form-control" id="otp">
            </div>
            <button type="submit" name="verify" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>
