<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'Conference Chair'){
    header("location: ../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'\..\core\config.php';

?>

<?php
  
    if (isset($_GET['pid'])){
  
        // Store the value from get to a local variable "get_pid" and "get_bidder"
        $get_pid=$_GET['pid'];
		$get_bidder=$_GET['bidder'];
  
        // SQL query that sets the status to TRUE to indicate activation.
        $sql="UPDATE `bid` SET `status`=1 WHERE pid='$get_pid' AND bidder='$get_bidder'";
        $mysqli->query($sql);
		
		// Close connection
		$mysqli->close();
		
		// Return back
		header('location:'. $_SERVER['HTTP_REFERER']);
		exit;
    }
?>