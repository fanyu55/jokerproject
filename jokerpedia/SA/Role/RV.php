<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'System Admin'){
    header("location: ../../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'\..\..\core\config.php';

?>

<?php
  
    // Check if id is set or not if true toggle
    if (isset($_GET['uid'])){
  
        // Store the value from get to a local variable "get_uid"
        $get_uid=$_GET['uid'];
  
        // SQL query that sets the user type to Reviewer 
        $sql="UPDATE `user` SET `usertype` = 'Reviewer' WHERE uid='$get_uid'";
  
        // Execute the query
        $mysqli->query($sql);
		
		// Close connection
		$mysqli->close();
		
		// Return back to manage user
		echo ("<script LANGUAGE='JavaScript'>
			window.alert('SUCCESS!')
			window.location.href='../user.php' 
			</script>");
		exit;
    }
?>