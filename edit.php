<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit(); // add exit to stop further execution
}
?>

<?php
// including the database connection file
include_once("connection.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];

    $name = $_POST['name'];
    $icnum = $_POST['icnum'];
    $birth = $_POST['birth'];
    $Address = $_POST['Address'];

    // checking empty fields
    if (empty($name) || empty($icnum) || empty($birth) || empty($Address)) {

        if (empty($name)) {
            echo "<font color='red'>Name field is empty.</font><br/>";
        }

        if (empty($icnum)) {
            echo "<font color='red'>IC Number field is empty.</font><br/>";
        }

        if (empty($birth)) {
            echo "<font color='red'>Birth field is empty.</font><br/>";
        }
        if (empty($Address)) {
            echo "<font color='red'>Address field is empty.</font><br/>";
        }
    } else {
        // updating the table
        $result = mysqli_query($mysqli, "UPDATE student SET name='$name', icnum='$icnum', birth='$birth', Address='$Address' WHERE id=$id");

        // redirecting to the display page. In our case, it is view.php
        header("Location: view.php");
    }
}
?>
<?php
// getting id from url
$id = $_GET['id'];

// selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM student WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
    $name = $res['name'];
    $icnum = $res['icnum'];
    $birth = $res['birth'];
    $Address = $res['Address'];
}
?>
<html>

<head>
    <title>Edit Data</title>
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

    <!-- Navigation -->
    <div id="content">
        <a href="index.php">Home</a> | <a href="view.php">View student</a> | <a href="logout.php">Logout</a>
        <br/><br/>

        <!-- Form to Edit Data -->
        <form name="form1" method="post" action="edit.php?id=<?php echo $id; ?>">
            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
                </tr>
                <tr>
                    <td>IC Number/Passport Number</td>
                    <td><input type="text" name="icnum" value="<?php echo $icnum; ?>"></td>
                </tr>
                <tr>
                    <td>Date of Birth (yyyy-mm-dd)</td>
                    <td><input type="text" name="birth" value="<?php echo $birth; ?>"></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input type="text" name="Address" value="<?php echo $Address; ?>"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value=<?php echo $id; ?>></td>
                    <td><input type="submit" name="update" value="Update"></td>
                </tr>
            </table>
        </form>
    </div>

    <!-- Footer section -->
    <div id="footer">
        <p>© 2025 Group7sec1. All Rights Reserved.</p>
    </div>
</body>

</html>
