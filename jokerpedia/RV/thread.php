<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: View Thread</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ width: 80%; padding: 50px; margin:auto; }
    </style>
</head>
<body>
<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'\..\core\config.php';

// Define and Initialize Variables
$username = $_SESSION["username"];
$pid = $_GET['pid'];

?>

<!------------------------------------------------------------------------------------------------>
									<!-- RV THREAD --> 
<!------------------------------------------------------------------------------------------------>
<h1 class="my-5">View Thread <b>[<?php echo $username ?>]</b></h1>

<?php		
	// Prepare SELECT statement
	$sql = "SELECT bidder, rating, comment, datetime FROM review WHERE pid ='$pid'";
	
	// Execute Query
	$result = $mysqli->query($sql);
?>

<table class="wrapper" width=100% border=5px solid style=text-align:center>
	<?php
		if(mysqli_num_rows($result) > 0){
		//TABLE TOP ROW HEADINGS
			echo "<tr>";
			echo "<th>"."Date Time"."</th>";
			echo "<th>"."Posted By"."</th>";
			echo "<th>"."Comment"."</th>";
			echo "<th>"."Rating"."</th>";
			echo "</tr>";
			
			//Populate Queries
			while($row = mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>". $row['datetime']."</td>";
				echo "<td>". $row['bidder']. "</td>";
				echo "<td>". $row['comment']. "</td>";
				echo "<td>". $row['rating']. "</td>";
				echo "</tr>";
			}
		}
		else
			echo "<tr>"."<b>You have yet to review anything!</b>"."</tr>";
	?>	
</table>	
<!------------------------------------------------------------------------------------------------>
<br>
<br>
<a href="viewBid.php" class="btn btn-primary">Back</a>
</body>
</html>