<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Manage Users</title>
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
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["usertype"] !== 'System Admin'){
    header("location: ../logout.php");
    exit;
}

// Include config file
require_once __DIR__.'\..\core\config.php';

?>

<!------------------------------------------------------------------------------------------------>
									<!-- MANAGING USER --> 
<!------------------------------------------------------------------------------------------------>
<h1 class="my-5">Jokerpedia - Manage Users</b></h1>

<?php		
	// Prepare SELECT statement
	$sql = "SELECT uid, username, email, usertype, active FROM user";
	
	// Execute Query
	$all_username = $mysqli->query($sql, MYSQLI_ASSOC);
?>

<table class="wrapper" width=100% border=5px solid style=text-align:center>
	<!-- TABLE TOP ROW HEADINGS -->
	<tr>
		<th>No.</th>
		<th>Username</th>
		<th>Email</th>
		<th>User Type</th>
		<th>Active</th>
		<th>Enable/Disable</th>
		<th>Update User Type</th>
	</tr>
	<?php
		foreach ($all_username as $user){?>
		<tr>
			<td><?php echo $user['uid']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['usertype']; ?></td>
			<td><?php 
					if($user['active']==true)
						echo "Active";
					else
						echo "Inactive";
	?>
	</td>
	<td>
		<!-- Enable/Disable Button --> 
		<?php
		if($user['active']==true)
			echo "<a href=deactivate.php?uid=".$user['uid']." class='btn btn-dark'>Disable</a>";
		else
			echo "<a href=activate.php?uid=".$user['uid']." class='btn btn-light'>Enable</a>";
		?>
	</td>
	<td>
		<!-- Update User Type -->
		<?php
		echo "<a href=Role/AT.php?uid=".$user['uid']." class='btn btn-success'>Author</a>";
		echo "<a href=Role/RV.php?uid=".$user['uid']." class='btn btn-info'>Reviewer</a>";
		echo "<a href=Role/CC.php?uid=".$user['uid']." class='btn btn-warning'>Conference Chair</a>";
		echo "<a href=Role/SA.php?uid=".$user['uid']." class='btn btn-secondary'>System Admin</a>";
		}?>
	</td>
		</tr>
</table>	
<!------------------------------------------------------------------------------------------------>
<br>
<br>
<a href="..\welcome.php" class="btn btn-primary">Back</a>
</body>
</html>