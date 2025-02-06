<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include_once("connection.php");

//fetching data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM student ORDER BY id DESC");
?>

<html>
<head>
	<title>STUDENT REGISTRATION</title>
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

		#content {
			padding: 20px;
		}

		table {
			width: 80%;
			border: 0;
			margin: 20px auto;
		}

		table tr {
			background-color: #CCCCCC;
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
		<img src="logosekolah.jpg" alt="School Logo" style="width:100px;height:100px;">
		<h1>STUDENT REGISTRATION SYSTEM</h1>
	</div>

	<!-- Main content area -->
	<div id="content">
		<h2>VIEW ALL STUDENT</h2>
		<br/><br/>

		<table width='80%' border=0>
			<tr bgcolor='#CCCCCC'>
				<td>Student Name</td>
				<td>IC Number/Passport Number</td>
				<td>Date of Birth</td>
				<td>Address</td>
				<td>Update</td>
			</tr>
			<?php
			while($res = mysqli_fetch_array($result)) {		
				echo "<tr>";
				echo "<td>".$res['name']."</td>";
				echo "<td>".$res['icnum']."</td>";
				echo "<td>".$res['birth']."</td>";
				echo "<td>".$res['Address']."</td>";	
				echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";		
			}
			?>
		</table>

		<!-- Back Button -->
		<div class="back-btn">
			<a href="index.php">Back</a>
		</div>
	</div>

	<!-- Footer section -->
	<div id="footer">
		<p>© 2025 Group7sec1. All Rights Reserved.</p>
	</div>
</body>
</html>
