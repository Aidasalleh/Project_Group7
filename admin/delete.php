<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: loginadmin.php');
}
?>

<?php
//including the database connection file
include("../connection.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table
$result=mysqli_query($mysqli, "DELETE FROM login WHERE id=$id");

//redirecting to the display page (admin.php in our case)
header("Location:admin.php");
?>

