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
  
    // Check if id is set or not if true toggle
    if (isset($_GET['pid'])){
  
        // Store the value from get to a local variable "get_uid"
        $get_pid=$_GET['pid'];
  
        // SQL query that sets the status to TRUE to indicate approved.
        $sql="UPDATE `post` SET `approve`=1 WHERE pid='$get_pid'";
        $mysqli->query($sql);
		
		// SQL query to get Title
		$sql1="SELECT title FROM post WHERE pid='$get_pid'" ;
		$result1 = $mysqli->query($sql1);
		$arrayResult1 = mysqli_fetch_array($result1);
		$title = $arrayResult1['title']; // store result into $title
		
		// SQL query to get Username
		$sql2 = "SELECT username FROM post WHERE pid='$get_pid'";
		$result2 = $mysqli->query($sql2);
		$arrayResult2 = mysqli_fetch_array($result2);
		$username = $arrayResult2['username']; // store result into $username
		
		// SQL query to get Email
		$sql3 = "SELECT email FROM user WHERE username='$username'";
		$result3 = $mysqli->query($sql3);
		$arrayResult3 = mysqli_fetch_array($result3);
		$email = $arrayResult3['email']; // store result into $email
		
		// Send Mail to notify Author
		$to = $email;
		$subject = "Jokerpedia: Your post has been APPROVED!";
		$msg = "Dear $username,"."\n\n"."  Your post titled, '$title' has been approved!"."\n\n\n".
				"Best Regards,"."\n"."Conference Chair Community"."\n\n"."[This is an auto-generated signature]";
		mail($to, $subject, $msg);
		
		// Close connection
		$mysqli->close();
		
		// Return back to manage user
		header('location:'. $_SERVER['HTTP_REFERER']);
		exit;
    }
?>