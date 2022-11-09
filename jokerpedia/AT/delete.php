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

?>

<?php
  
    // Check if id is set or not, return back after close
    if (isset($_GET['pid'])){
  
        // Store the value from get to a local variable "get_pid"
        $get_pid=$_GET['pid'];
  
        // SQL query that delete selected POST.
		$sql1 = "SELECT filePath FROM post where pid='$get_pid'";
        $sql2 = "DELETE FROM post WHERE pid='$get_pid'";
  
        // Execute the query and delete physical file from server (AT\uploads/)
		$result = $mysqli->query($sql1);
		while ($row = mysqli_fetch_array($result)){
			unlink($row['filePath']);
		}
        $mysqli->query($sql2);
		
		// Close connection
		$mysqli->close();
		
		// Return back to manage user
		header('location: viewSub.php');
    }
?>