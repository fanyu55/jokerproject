<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Review</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ width: 75%; padding: 50px; margin:auto; }
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

// Define and Initialize Variables (Bidder Username)
$bidder = $_SESSION["username"];
$rating = $comment = "";


// Check if id is set or not if true toggle
    if (isset($_GET['pid'])){
  
        // Store the value from get to a local variable "get_pid"
        $get_pid=$_GET['pid'];
		
		// SQL query to get Title
		$sql="SELECT title FROM post WHERE pid='$get_pid'" ;
		$result = $mysqli->query($sql);
		$arrayResult = mysqli_fetch_array($result);
		$title = $arrayResult['title']; // store result into $title
		
		// SQL query to get Author Username
		$sql = "SELECT username FROM post WHERE pid='$get_pid'";
		$result = $mysqli->query($sql);
		$arrayResult = mysqli_fetch_array($result);
		$author = $arrayResult['username']; // store result into $author
		
		// SQL query to get Filepath
		$sql = "SELECT filePath FROM post WHERE pid='$get_pid'";
		$result = $mysqli->query($sql);
		$arrayResult = mysqli_fetch_array($result);
		$filePath = $arrayResult['filePath']; // store result into $filePath
		$filePathActual = '../AT/' . $filePath;    
	}
?>

<!------------------------------------------------------------------------------------------------>
									<!-- RV REVIEW PAPER --> 
<!------------------------------------------------------------------------------------------------>
<h1>Review-in-Progress.. <b>[<?php echo $bidder ?>]</b></h1>

<!-- REVIEW DETAILS -->
	<div class="wrapper">
        <form method="post" action="comment.php"> 			
            <div class="form-group">
				<label>Click on the "Title" to DOWNLOAD the Paper</label>
				<br>
				Author: <?php echo $author ?>
				<br/>
				Title: <a href='download.php?pid=<?php echo $get_pid ?>' ><?php echo $title ?></a>
				</br><br><br/>
                <label>Please RATE the Paper</label>
				<br>
                <input type="radio" id="rating" name="rating" value="-3"> Strong Reject ||
				<input type="radio" id="rating" name="rating" value="-2"> Reject ||
				<input type="radio" id="rating" name="rating" value="-1"> Weak Reject ||
				<input type="radio" id="rating" name="rating" value="0"> Borderline Paper ||
				<input type="radio" id="rating" name="rating" value="1"> Weak Accept ||
				<input type="radio" id="rating" name="rating" value="2"> Accept ||
				<input type="radio" id="rating" name="rating" value="3"> Strong Accept
            </div>	 
			<div class="form-group">
				<label>Comment</label>
				<br/>
                <textarea id="comment" name="comment" rows="5" cols="75" style="font-size:1em;padding-left:3px;min-height:60px;width:75%;"></textarea>
            </div> 
            <div class="form-group">
				<input type="hidden" id="pid" name="pid" value="<?php echo $get_pid; ?>">
				<input type="hidden" id="author" name="author" value="<?php echo $author ?>">
				<input type="hidden" id="title" name="title" value="<?php echo $title ?>">
                <input type="submit" class="btn btn-warning" value="submit">
				<a href="viewBid.php" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>    
</body>
</html>