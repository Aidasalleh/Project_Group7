<?php
session_start();
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

// AES-128 encryption key (should be kept secret)
$encryptionKey = 'Ks9Hn2Lp7Qw3Xr6Y';

// Function to encrypt data using AES-128
function encryptData($data, $key) {
    $ivLen = openssl_cipher_iv_length('AES-128-CBC');
    $iv = openssl_random_pseudo_bytes($ivLen);
    $encryptedData = openssl_encrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encryptedData);
}

// Function to decrypt data using AES-128
function decryptData($encryptedData, $key) {
    $encryptedData = base64_decode($encryptedData);
    $ivLen = openssl_cipher_iv_length('AES-128-CBC');
    $iv = substr($encryptedData, 0, $ivLen);
    $data = substr($encryptedData, $ivLen);
    $decryptedData = openssl_decrypt($data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedData;
}
?>
<html>
<head>
    <title>Add Data</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background-color:rgb(232, 240, 173);
            margin: 0;
            padding: 0;
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
        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div id="header">
        <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
        <h1>STUDENT REGISTRATION SYSTEM</h1>
    </div>
    <!-- Main content area -->
    <div id="content">
        <?php
        // including the database connection file
        include_once("connection.php");
        if (isset($_POST['Submit'])) {
            // retrieve and sanitize input data
            $name = mysqli_real_escape_string($mysqli, $_POST['name']);
            $icnum = mysqli_real_escape_string($mysqli, $_POST['icnum']);
            $birth = mysqli_real_escape_string($mysqli, $_POST['birth']);
            $address = mysqli_real_escape_string($mysqli, $_POST['Address']);
            $loginId = isset($_SESSION['id']) ? $_SESSION['id'] : 0; // Assign a default value if $_SESSION['id'] is not set

            // Encrypt the icnum using AES-128
            $encryptedIcnum = encryptData($icnum, $encryptionKey);

            // Check if the loginId exists in the login table
            $loginCheckQuery = "SELECT id FROM login WHERE id = ?";
            $loginCheckStmt = $mysqli->prepare($loginCheckQuery);
            $loginCheckStmt->bind_param("i", $loginId);
            $loginCheckStmt->execute();
            $loginCheckStmt->store_result();
            
            if ($loginCheckStmt->num_rows == 0) {
                echo "<font color='red'>Invalid login ID. Please log in again.</font><br/>";
                echo "<br/><a href='login.php'>Login</a>";
            } else {
                // checking empty fields
                if (empty($name) || empty($icnum) || empty($birth) || empty($address)) {
                    if (empty($name)) {
                        echo "<font color='red'>Name field is empty.</font><br/>";
                    }
                    if (empty($icnum)) {
                        echo "<font color='red'>IC Number field is empty.</font><br/>";
                    }
                    if (empty($birth)) {
                        echo "<font color='red'>Birth field is empty.</font><br/>";
                    }
                    if (empty($address)) {
                        echo "<font color='red'>Address field is empty.</font><br/>";
                    }
                    // link to the previous page
                    echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
                } else {
                    // if all the fields are filled (not empty)
                    // insert data into the database
                    $stmt = $mysqli->prepare("INSERT INTO student(name, icnum, birth, Address, login_id) VALUES(?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $name, $encryptedIcnum, $birth, $address, $loginId);
                    $result = $stmt->execute();
                    $stmt->close();

                    if ($result) {
                        // display success message
                        echo "<font color='green'>Data added successfully.</font>";
                        echo "<br/><a href='view.php'>View Result</a>";
                    } else {
                        // display error message
                        echo "<font color='red'>Error adding data: " . $mysqli->error . "</font>";
                    }
                }
            }
            $loginCheckStmt->close();
        }
        ?>
    </div>
    <!-- Back Button -->
    <div class="back-btn">
        <a href="index.php">Back</a>
    </div>
    <!-- Footer section -->
    <div id="footer">
        <p>© 2025 Group7sec1. All Rights Reserved.</p>
    </div>
</body>
</html>
