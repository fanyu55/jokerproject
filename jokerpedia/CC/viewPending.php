<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: View Pending Submission</title>
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
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'Conference Chair'){
    header("location: ../logout.php");
    exit;
}
// Include config file
require_once __DIR__.'\..\core\config.php';

// Define and Initialize Variables
$username = $_SESSION["username"];

?>

<!------------------------------------------------------------------------------------------------>
									<!-- CC VIEW PENDING SUBMISSION --> 
<!------------------------------------------------------------------------------------------------>
<h1 class="wrapper">View Pending Submission <b>[<?php echo $_SESSION["username"] ?>]</b></h1>

<?php		
	// Prepare SELECT statement
	$sql = "SELECT pid, title, datetime, approve FROM post WHERE approve='2'";
	
	// Execute Query
	$result = $mysqli->query($sql);
?>

<table class="wrapper" width=100% border=5px solid style=text-align:center>
	<?php
		if(mysqli_num_rows($result) > 0){
		//TABLE TOP ROW HEADINGS
			echo "<tr>";
			echo "<th>"."No."."</th>";
			echo "<th>"."Title"."</th>";
			echo "<th>"."Date and Time"."</th>";
			echo "<th>"."Status"."</th>";
			echo "<th>"."Action"."</th>";
			echo "</tr>";
			
			//Populate Queries
			while($row = mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>". $row['pid']. "</td>";
				echo "<td>". $row['title']. "</td>";
				echo "<td>". $row['datetime']. "</td>";
				
				//Status Rule
				if($row['approve']=='1')
					echo "<td>"."Approved"."</td>";
				else if($row['approve']=='0')
					echo "<td>"."Reject"."</td>";
				else 
					echo "<td>"."Pending"."</td>";
				
				echo "<td>"."<a href=approve.php?pid=".$row['pid']." class='btn btn-warning'>Approve</a>";
				echo "<a href=reject.php?pid=".$row['pid']." class='btn btn-secondary'>Reject</a>"."</td>";
				echo "</tr>";
			}
		}
		else
			echo "<tr>"."<b>Good job! There is currently no pending case!</b>"."</tr>";
	?>	
</table>	
<!------------------------------------------------------------------------------------------------>
<br>
<br>
<a href="..\welcome.php" class="btn btn-primary">Back</a>
</body>
</html>