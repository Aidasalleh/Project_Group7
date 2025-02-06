<?php session_start(); ?>

<?php
if (!isset($_SESSION['valid'])) {
    header('Location: loginadmin.php');
}
?>

<?php
//including the database connection file
include_once("../connection.php");

//fetching data in descending order (latest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM login ORDER BY id DESC");
?>

<html>

<head>
    <title>CENDEKIA GEMILANG SCHOOL STUDENT REGISTRATION</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background-color:rgb(232, 240, 173);
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #9B59B6;
        }

        a {
            color: #9B59B6;
            text-decoration: none;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #CCCCCC;
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #F3D3E2;
        }

        tr:hover {
            background-color: #EEE1F9;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <h2>APPROVE TO ACCESS STUDENT DETAILS </h2>

    <!-- User Table -->
    <table>
        <tr bgcolor='#CCCCCC'>
            <th>No ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Username</th>
            <th>Approval</th>
            <th>Actions</th>
        </tr>
        <?php
        while ($log = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $log['id'] . "</td>";
            echo "<td>" . $log['name'] . "</td>";
            echo "<td>" . $log['email'] . "</td>";
            echo "<td>" . $log['username'] . "</td>";
            echo "<td>" . $log['approval'] . "</td>";
            echo "<td><a href=\"approve.php?id=$log[id]\">Approve</a> | <a href=\"delete.php?id=$log[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </table>


    <!-- Navigation -->
    <a href="..\index.php">Home</a> | <a href="logout.php">Logout</a>
    <br/><br/>
</body>

</html>
