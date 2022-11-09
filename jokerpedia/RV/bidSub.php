<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Bid Submission</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ width: 75%; padding: 50px; margin: auto;}
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
$username = $_SESSION["username"];

?>

<!------------------------------------------------------------------------------------------------>
									<!-- CC BID SUBMISSION --> 
<!------------------------------------------------------------------------------------------------>
<h1 class="wrapper">Bid Submission <b>[<?php echo $username ?>]</b></h1>

<?php		
	// Prepare SQL query for all the approved post
	$sql = "SELECT pid, username, title, approve FROM post WHERE approve='1'";
	$result = $mysqli->query($sql);
?>

<table class="wrapper" width=100% border=5px solid style=text-align:center>
	<?php
		if(mysqli_num_rows($result) > 0){
		//TABLE TOP ROW HEADINGS
			echo "<tr>";
			echo "<th>"."No."."</th>";
			echo "<th>"."Author"."</th>";
			echo "<th>"."Title"."</th>";
			echo "<th>"."Action"."</th>";
			echo "</tr>";
			
			//Populate Queries
			while($row = mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>". $row['pid']. "</td>";
				echo "<td>". $row['username']."</td>";
				echo "<td>". $row['title']. "</td>";
				echo "<td>"."<a href=bidding.php?pid=".$row['pid']." class='btn btn-info'>Bid</a>"."</td>";
				echo "</tr>";
			}
		}
		else
			echo "There is currently no post yet!";
	?>	
</table>	
<!------------------------------------------------------------------------------------------------>
<br>
<br>
<a href="..\welcome.php" class="btn btn-primary">Back</a>
</body>
</html>