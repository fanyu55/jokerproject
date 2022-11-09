<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: New Submission</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ width: 75%; padding: 50px; margin: auto;}
		.wrapper1{ width: 75%; padding: 10px; margin: auto;}
    </style>
</head>
<body>

<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'Author'){
    header("location: ../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'\..\core\config.php';

// Define and Initialize Variables

?>
<div class="wrapper">
	<h2 class="wrapper">New Submission <b>[<?php echo $_SESSION["username"] ?>]</b></h2>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<div class="wrapper1">
				<label>Title:</label>
				<input type="text" name="title" id="title">
			</div>
			<div class="wrapper1"> 
				<label>Select a file to upload:</label>
				<input type="file" name="file" id="file"><br></br>
			</div>
			<div class="wrapper1">	
				<input type="submit" name="submit" class="btn btn-success" value="Submit">
			</div>
		</form>	
</div>
<br><br>
<a href="..\welcome.php" class="btn btn-primary">Return to Main Menu</a>
</body>
</html>