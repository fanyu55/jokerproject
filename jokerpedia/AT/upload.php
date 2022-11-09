<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Success</title>
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
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'Author'){
    header("location: ../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'/../core/config.php';

// Define and Initialize Variables
$username = $_SESSION['username'];
$title = $_POST["title"];
$targetDir = "uploads/$username"."_";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
    
	// Allow certain file formats
    $allowTypes = array('pdf');
	
    if(in_array($fileType, $allowTypes)){
        
		// Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
		
			// Prepare SQL Statement for updating post
			$sql = "INSERT INTO post (username, title, filePath) VALUE ('$username','$title','$targetFilePath')";
			// Execute SQL Statement
			$mysqli->query($sql);
			// Close connection 
			$mysqli->close();
			
			// Return back
			echo ("<script LANGUAGE='JavaScript'>
				window.alert('Upload Successful!')
				window.location.href='../welcome.php' 
				</script>");
	exit;
        }
		else{
			// Return back
			echo ("<script LANGUAGE='JavaScript'>
				window.alert('Error Uploading File! Please Try Again!')
				window.location.href='newSub.php' 
				</script>");
        }
    }
	else{
        // Return back
		echo ("<script LANGUAGE='JavaScript'>
			window.alert('Only PDF allowed! Please Try Again!')
			window.location.href='newSub.php' 
			</script>");
    }
}
else{
    // Return back
	echo ("<script LANGUAGE='JavaScript'>
		window.alert('Please select a file to upload!')
		window.location.href='newSub.php' 
		</script>");
}
?>

</body>
</html>