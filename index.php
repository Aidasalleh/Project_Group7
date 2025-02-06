<?php
session_start();

// Array of pastel colors
$pastel_colors = array("#D7BDE2", "#EBDEF0", "#F2D7D5", "#E8DAEF", "#D6EAF8");

// Randomly select a color for the background
$background_color = $pastel_colors[array_rand($pastel_colors)];

// Define text color
$text_color = "#9B59B6";
?>

<html>

<head>
    <title>Homepage</title>

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
            color: <?php echo $text_color; ?>;
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

<!-- Header with an optional image -->
<div id="header">
    <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
    <h1>STUDENT REGISTRATION SYSTEM</h1>
</div>

<!-- Main content area -->
<div id="content">
    <p>WELCOME TO TIARA PRIMARY SCHOOL</p>

    <?php if (isset($_GET['message']) && $_GET['message'] == 'loggedout') : ?>
        <p>You have been logged out successfully.</p>
    <?php endif; ?>

    <?php if (isset($_SESSION['valid'])) : ?>
        
        <?php
        include("connection.php");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Example of using prepared statement to fetch data
        $stmt = $mysqli->prepare("SELECT * FROM login WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['valid']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        ?>

        <p>Welcome <?php echo htmlspecialchars($user['name']); ?>! <a href='logout.php'>Logout</a></p>

        <p><a href='view.php'>View and Add Student Info</a></p>
        <p><a href='viewall.php'>View All Students</a></p>

    <?php else : ?>

        <p>You must be logged in to register a student</p>
        <p><a href='login.php'>Login</a> | <a href='register.php'>Register</a> | <a href='./admin/loginadmin.php'>Admin</a></p>

    <?php endif; ?>

</div>

<!-- Footer section -->
<div id="footer">
    <p>© 2025 Group7sec1. All Rights Reserved.</p>
</div>

</body>
</html>
