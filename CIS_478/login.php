<?php 
session_start();
// Initialize the session
require_once 'session.php';
// Connect to database
 require_once 'database.php';
 
// Define variables and initialize with empty values
$username = $password = $ip = "";
$username_error = $password_error = "";
 
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$current_ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$current_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$current_ip = $_SERVER['REMOTE_ADDR'];
	}
 echo $current_ip;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Check if the user exists in the database
    if(empty($username_error) && empty($password_error)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM login_users WHERE username = ?";
        $stmt = mysqli_stmt_init($link);

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
                            
                            // Redirect user to welcome page
                            header("location: successful_login.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_error = "The password you entered was not valid.";
							$_SESSION["login_attempts"] += 1;
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_error = "No account found with that username.";
					$_SESSION["login_attempts"] += 1;
                }
            } else{
                echo "Oops! Something went wrong. Please contact your systems administrator.";
				header ("location: index.php");
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
	<!-- External stylesheets for login page-->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Favicon-->
	<link rel="icon" type="image/png" sizes="32x32" href="gear.png">
    <style type="text/css">
        body{ 
			font-family: 'Raleway', sans-serif;
		}
		
        .wrapper{ 
			width: 55%;; 
			padding: 20px; 
			margin: auto;
		}
		
		.errorReporting{
			color: red;
		}
		
		.navigation {
		  overflow: hidden;
		  background-color: #333;
		}

		.navigation a {
		  float: left;
		  display: block;
		  color: #f2f2f2;
		  text-align: center;
		  padding: 14px 16px;
		  text-decoration: none;
		  font-size: 17px;
		}

		.navigation a:hover {
		  background-color: #c8ccca;
		  color: black;
		}

		.navigation a.active {
		  background-color: #6183e8;
		  color: white;
		}
		
    </style>
</head>
<body>

<div class="navigation" id = "signupNavigation">

<nav>
<a href="index.php"><i class="fa fa-fw fa-home"></i>    Home</a>
<a href="#"><i class="fa fa-fw fa-search"></i>    Search</a> 
<a href="signup.php"><i class="fa fa-sign-in"></i>    Sign Up</a>
<a href="activate.php"><i class="fa fa-check"></i>    Activate</a>
<a href="login.php" class = "active"><i class="fa fa-fw fa-user"></i>    Log In</a>
<a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
</nav>

</div>
    <div class="wrapper">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                <label><i class="fas fa-user"></i>  Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="errorReporting"><?php echo $username_error; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
                <label><i class="fas fa-lock"></i>  Password</label>
                <input type="password" name="password" class="form-control">
                <span class="errorReporting"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group">
			<?php
			if ($_SESSION["login_attempts"] > 2){
				echo "<p style='color:red;'>Your account has been locked! It must be reset.</p>";
			}
			else{
			?>
				<input type="submit" class="btn btn-primary" value="Log in!">
			<?php } ?>
				<input type="button" class="btn btn-primary" onclick = "location.href='reset-username.php'" value ="Forgot username?" style = "margin-left: 30px;">
				<input type="button" class="btn btn-primary" onclick = "location.href='reset-password.php'" value ="Forgot password?" style="float: right; position: absolute; margin-left: 30px;"> 
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now!</a></p>
        </form>
    </div>    
</body>
</html>