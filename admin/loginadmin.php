<?php session_start(); ?>
<html>
<head>
    <title>Login Admin</title>
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
        }

        #footer {
            padding: 10px;
            background-color: #fff; /* White background for footer */
        }

        img {
            max-width: 100%; /* Ensure images don't exceed their container */
            height: auto;
        }
    </style>
</head>

<body>

<!-- Header -->
<div id="header">
    <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
    <h1>ADMIN LOGIN</h1>
</div>

<!-- Main content area -->
<div id="content">
    <?php
    include("../connection.php");

    if (isset($_POST['submit'])) {
        $user = mysqli_real_escape_string($mysqli, $_POST['username']);
        $password = mysqli_real_escape_string($mysqli, $_POST['password']);
        $pass = hash('sha256', $password);

        if ($user == "" || $pass == "") {
            echo "Either username or password field is empty.";
            echo "<br/>";
            echo "<a href='loginadmin.php'>Go back</a> | <a href='../index.php'>Home</a>";
        } else {
            $result = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$user' AND password='$pass' AND username='admin'")
                or die("Could not execute the select query.");

            $row = mysqli_fetch_assoc($result);

            if (is_array($row) && !empty($row)) {
                $validuser = $row['username'];
                $_SESSION['valid'] = $validuser;
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
            } else {
                echo "You are not an administrator.";
                echo "<br/>";
                echo "<a href='loginadmin.php'>Go back</a> | <a href='../index.php'>Home</a>";
            }

            if (isset($_SESSION['valid'])) {
                header('Location: admin.php');
            }
        }
    } else {
        ?>
        <p><font size="+2">Login</font></p>
        <form name="form1" method="post" action="">
            <table width="75%" border="0">
                <tr>
                    <td width="10%">Username</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" value="Submit"></td>
                </tr>
            </table>
        </form>

        <a href='../index.php'>Home</a>
        <?php
    }
    ?>
</div>

<!-- Footer section


