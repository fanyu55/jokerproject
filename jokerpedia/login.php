<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jokerpedia: Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
		.wrapper{ width: 50%; padding: 10px; margin: auto;}
		input {text-align: center;}
    </style>
</head>
<body>

<?php
// Initialize the session
session_start();
 
// Check if already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) === true && $_SESSION["active"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once 'core/config.php';
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
	
        // Prepare a select statement
        $sql = "SELECT uid, username, email, password, usertype, active FROM user WHERE username = ?";
        
        if($query = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $query->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
			        
            // Attempt to execute the prepared statement
            if($query->execute()){
                // Store result
                $query->store_result();
                
                // Check if username exists, if yes then verify password
                if($query->num_rows == 1){                    
                    // Bind result variables
                    $query->bind_result($uid, $username, $email, $hashed_password, $usertype, $active);
                    if($query->fetch()){
                        if(password_verify($password, $hashed_password)){
							// Password is correct
							// Start new session
							if($active == true){
								session_start();
								// Store data in session variables
								$_SESSION["loggedin"] = true;
								$_SESSION["uid"] = $uid;
								$_SESSION["username"] = $username;
								$_SESSION["usertype"] = $usertype;
								$_SESSION["active"] = $active;
							
								// Redirect to welcome page
								header("location: welcome.php");
							} 
								else{
									// Account Disabled, display a generic error message
									$login_err = "Account is DISABLED. Contact System Administrator.";
								}
						}
                    } 
							else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
							}
                }
            } 
				else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
				}
        } 	
			else{
                echo "Oops! Something went wrong. Please try again later.";
			}

        // Close statement
        $query->close();
    }
}
    
    // Close connection
    $mysqli->close();

?>
    <div class="wrapper">
        <h2>Jokerpedia: Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="wrapper">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="wrapper">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="wrapper">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
			<p>Don't have an account? <a href="register.php">Sign up here</a>.</p>
        </form>
    </div>
</body>
</html>