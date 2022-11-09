<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>

<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'Reviewer'){
    header("location: ../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'\..\core\config.php';

// Define and Initialize Variables
$pid = $_POST["pid"];
$bidder = $_SESSION['username'];
$rating = $_POST["rating"];
$comment = $_POST["comment"];
$title = $_POST["title"];
$author = $_POST["author"];

?>

<?php
  
if(!isset($_POST["submit"])){
		
	// SQL query to insert Paper Review from Reviewer(s)
	$sql = "INSERT INTO review (pid,title,author,bidder,rating,comment) VALUES ('$pid','$title','$author','$bidder','$rating','$comment')";
	$mysqli->query($sql);
		
	// SQL query to update bid status to 'reviewed'
	$sql = "UPDATE bid SET reviewed='1' WHERE pid='$pid' AND bidder='$bidder'";
	$mysqli->query($sql);
		
	// Close connection
	$mysqli->close();
		
	// Return back
	echo ("<script LANGUAGE='JavaScript'>
			window.alert('Review SENT!')
			window.location.href='viewBid.php' 
			</script>");
	exit;
}
else{
	// Return back
	echo ("<script LANGUAGE='JavaScript'>
			window.alert('You have yet to select any RATING or yet to COMMENT!')
			window.location.href='viewBid.php' 
			</script>");
}
?>

</body>
</html>