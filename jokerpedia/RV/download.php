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

?>

<?php
  
    // Check if id is set or not if true toggle
    if (isset($_GET['pid'])){
  
        // Store the value from get to a local variable "get_pid"
        $get_pid=$_GET['pid'];
  
		// SQL query to get Title
		$sql="SELECT title FROM post WHERE pid='$get_pid'" ;
		$result = $mysqli->query($sql);
		$arrayResult = mysqli_fetch_array($result);
		$t1 = $arrayResult['title']; // store result into $t1
		$title = $t1.'.pdf';
  
		// SQL query to get Filepath
		$sql = "SELECT filePath FROM post WHERE pid='$get_pid'";
		$result = $mysqli->query($sql);
		$arrayResult = mysqli_fetch_array($result);
		$filePath = $arrayResult['filePath']; // store result into $filePath
		$filePathActual = '../AT/' . $filePath; 
		
		// Close connection
		$mysqli->close();
		
		// Force Download PDF File
		header('Content-Type: application/pdf');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=".$title);
		readfile($filePathActual);
		
		// Return back to manage user
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
    }
?>