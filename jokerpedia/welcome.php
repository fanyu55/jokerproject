<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ width: 80%; padding: 50px; margin: auto;}
    </style>
</head>
<body>
<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
	}

// Include config file
require_once 'core/config.php';

?>
    <h1 class="wrapper">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]." (". $_SESSION["usertype"].")" ); ?></b>.</h1>
		<h2 class="wrapper">What would you like to do?</h2>
		
		<?php
		//Determine which user type page to be shown
		$usertype = $_SESSION["usertype"];
		
		switch($usertype){
			case "Author":
				echo "<a href=","AT/newSub.php"," ","class='btn btn-primary'",">","New Submission</a>";
				echo "<a href=","AT/viewSub.php"," ","class='btn btn-secondary'",">","View Submission</a>";
				break;
			case "Reviewer":
				echo "<a href=","RV/bidSub.php"," ","class='btn btn-primary'",">","Bid Submission</a>";
				echo "<a href=","RV/viewBid.php"," ","class='btn btn-secondary'",">","View Bid</a>";
				break;
			case "Conference Chair":
				echo "<a href=","CC/viewPending.php"," ","class='btn btn-primary'",">","View Pending Submission</a>";
				echo "<a href=","CC/viewAll.php"," ","class='btn btn-secondary'",">","View Approved/Rejected Submission</a>";
				echo "<a href=","CC/viewPendingBid.php"," ","class='btn btn-info'",">","View Pending Bid</a>";
				echo "<a href=","CC/viewAllBid.php"," ","class='btn btn-success'",">","View Approved/Rejected Bid</a>";
				break;
			case "System Admin":
				echo "<a href=","SA/user.php"," ","class='btn btn-primary'",">","Manage Users</a>";
				break;
		}
		?>
		
		</p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
    </p>
</body>
</html>