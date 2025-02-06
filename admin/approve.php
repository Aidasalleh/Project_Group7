<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: loginadmin.php');
}
?>

<?php
// including the database connection file
include_once("../connection.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $approval = $_POST['approval'];

    // checking empty fields
    $errorMessages = [];
    if (empty($name)) {
        $errorMessages[] = "Name field is empty.";
    }

    if (empty($email)) {
        $errorMessages[] = "Email field is empty.";
    }

    if (empty($username)) {
        $errorMessages[] = "Username field is empty.";
    }

    if (!empty($errorMessages)) {
        foreach ($errorMessages as $errorMessage) {
            echo "<font color='red'>$errorMessage</font><br/>";
        }
    } else {
        // updating the table
        $result = mysqli_query($mysqli, "UPDATE login SET name='$name', email='$email', username='$username', approval='$approval' WHERE id=$id");

        // redirecting to the display page. In our case, it is admin.php
        header("Location: admin.php");
    }
}
?>
<?php
// getting id from URL
$id = $_GET['id'];

// selecting data associated with this particular id
$result2 = mysqli_query($mysqli, "SELECT * FROM login WHERE id=$id");

while ($log = mysqli_fetch_array($result2)) {
    $name = $log['name'];
    $email = $log['email'];
    $username = $log['username'];
    $approval = $log['approval'];
}
?>
<html>

<head>
    <title>Approve User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background-color:rgb(232, 240, 173);
            margin: 0;
            padding: 0;
        }

        form {
            width: 50%;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #CCCCCC;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #F3D3E2;
        }
    </style>
</head>

<body>
    <h2>Approve User</h2>

    <!-- User Approval Form -->
    <form name="form2" method="post" action="approve.php">
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo $email; ?>"></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
            </tr>
            <tr>
                <td>Approval</td>
                <td><input type="text" name="approval" value="<?php echo $approval; ?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $_GET['id']; ?>></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>

</html>
