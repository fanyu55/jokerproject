<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: View Approved/Rejected Bid</title>
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
									<!-- CC VIEW APPROVED/REJECTED BID --> 
<!------------------------------------------------------------------------------------------------>
<h1 class="wrapper">View Approved/Rejected Bid <b>[<?php echo $username ?>]</b></h1>

<?php		
	// Prepare SELECT statement
	$sql = "SELECT pid, author, title, bidder, status, reviewed FROM bid WHERE NOT status='2'";
	
	// Execute Query
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
			echo "<th>"."Bidder"."</th>";
			echo "<th>"."Status"."</th>";
			echo "<th>"."Reviewed"."</th>";
			echo "<th>"."Action"."</th>";
			echo "</tr>";
			
			//Populate Queries
			while($row = mysqli_fetch_array($result)){
				echo "<tr>";
				echo "<td>". $row['pid']. "</td>";
				echo "<td>". $row['author']."</td>";
				echo "<td>". $row['title']. "</td>";
				echo "<td>". $row['bidder']. "</td>";
				
				//Status Rule
				if($row['status']=='1' && $row['reviewed']=='0'){
					echo "<td>"."Approved"."</td>";
					echo "<td>"."No"."</td>";
					echo "<td>"."<a href=rejectBid.php?pid=".$row['pid']."&bidder=".$row['bidder']." class='btn btn-warning'>Reject</a>"."</td>";
				}
				else if ($row['status']=='1' && $row['reviewed']=='1'){
					echo "<td>"."Approved"."</td>";
					echo "<td>"."Yes"."</td>";
					echo "<td>"."<a href=rejectBid.php?pid=".$row['pid']."&bidder=".$row['bidder']." class='btn btn-warning'>Reject</a>";
					echo "<a href=thread.php?pid=".$row['pid']." class='btn btn-success'>Read Thread</a>"."</td>";
					}
				else{
					echo "<td>"."Reject"."</td>";
					echo "<td>"."No Action Needed"."</td>";
					echo "<td>"."<a href=approveBid.php?pid=".$row['pid']."&bidder=".$row['bidder']." class='btn btn-info'>Approve</a>"."</td>";
				}
				echo "</tr>";	
			}	
		}
		else
			echo "<tr>"."<b>You have yet to approve/reject any bid!</b>"."</tr>";
	?>	
</table>
<!------------------------------------------------------------------------------------------------>
<br>
<br>
<a href="..\welcome.php" class="btn btn-primary">Back</a>
</body>
</html>