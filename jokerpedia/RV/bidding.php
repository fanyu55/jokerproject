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

// Define and Initialize Variables (Bidder Username)
$bidder = $_SESSION["username"];

?>

<?php
  
    // Check if id is set or not if true toggle
    if (isset($_GET['pid'])){
  
        // Store the value from get to a local variable "get_pid"
        $get_pid=$_GET['pid'];
		
		// SQL query to get Title
		$sql1="SELECT title FROM post WHERE pid='$get_pid'" ;
		$result1 = $mysqli->query($sql1);
		$arrayResult1 = mysqli_fetch_array($result1);
		$title = $arrayResult1['title']; // store result into $title
		
		// SQL query to get Author Username
		$sql2 = "SELECT username FROM post WHERE pid='$get_pid'";
		$result2 = $mysqli->query($sql2);
		$arrayResult2 = mysqli_fetch_array($result2);
		$author = $arrayResult2['username']; // store result into $author
		
		// SQL query to check for exisiting bid
		$sql3 = "SELECT bidder FROM bid WHERE pid='$get_pid' AND bidder='$bidder'";
		$result = $mysqli->query($sql3);
		
		// Insert if post not bidded yet
		if (mysqli_num_rows($result) == 0){
			// SQL query to INSERT bidder into the bid system
			$sql4 = "INSERT into bid VALUES ('$get_pid', '$author', '$title', '$bidder', '2', '0')";
			$mysqli->query($sql4);
			
			// Close connection
			$mysqli->close();
			
			// Return back
			echo ("<script LANGUAGE='JavaScript'>
			window.alert('BID SUCCESSFUL!')
			window.location.href='bidSub.php' 
			</script>");
			exit;
		}
		else
			echo ("<script LANGUAGE='JavaScript'>
			window.alert('YOU ALREADY BIDDED THIS TITLE!')
			window.location.href='bidSub.php' 
			</script>");
			exit;
		
    }
?>