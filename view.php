<?php session_start(); ?>
<?php
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
?>
<?php
// including the database connection file
include_once("connection.php");
?>
<html>
<head>
    <title>STUDENT REGISTRATION</title>

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
        }

        table {
            width: 80%;
            border: 0;
            margin: 20px auto;
        }

        table tr {
            background-color: #D3B8CA;
        }

        table td {
            padding: 10px;
        }
    </style>
</head>
<body>
    <!-- Header with an optional image -->
    <div id="header">
        <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
        <h1>STUDENT REGISTRATION SYSTEM CENDEKIA GEMILANG SCHOOL</h1>
    </div>
    <!-- Main content area -->
    <div id="content">
        <a href="index.php">Home</a> | <a href="add.html">Add New Data</a> | <a href="logout.php">Logout</a>
        <br /><br />
        <?php
// fetching data in descending order (latest entry first)
// Prepare the SQL statement with a placeholder
$query = $mysqli->prepare("SELECT * FROM student WHERE login_id = ? ORDER BY id DESC");
// Bind the parameter to the placeholder
$query->bind_param("i", $_SESSION['id']); // Assuming 'id' is an integer; adjust the type if needed
// Execute the query
$query->execute();
// Get the result set
$result = $query->get_result();
?>
<table>
<tr>
    <td>Student Name</td>
    <td>IC Number/Passport Number</td>
    <td>Date of Birth</td>
    <td>Address</td>
    <td>Update</td>
</tr>
<?php
// Fetch the data
while ($row = $result->fetch_assoc()) {
    // Process each row of data
   
     $id = $row['id'];
     $name = $row['name'];
     $icnum = $row['icnum'];
     $birth = $row['birth'];
     $Address = $row['Address'];
     
     echo "<tr>";
     echo "<td>$name</td>";
     echo "<td>$icnum</td>";
     echo "<td>$birth</td>";
     echo "<td>$Address</td>";
     echo "<td><a href=\"edit.php?id=$id\">Edit</a> | <a href=\"delete.php?id=$id\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
     echo "</tr>";

}
// Close the statement
$query->close();
?>
</table>
</div>
    <!-- Footer section -->
    <div id="footer">
        <p>© 2025 Group7sec1. All Rights Reserved.</p>
    </div>
</body>
</html>
