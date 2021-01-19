<?php
session_start();
// Connect to database
 require_once 'database.php';
	
unset ($_SESSION["login_attempts"]);
	
// Create & initialize new field variables and error variables
$username = $password = $confirmPassword = "";
$username_error = $password_error = $confirmPassword_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter your username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM login_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
			
			// Set parameters
            $param_username = trim($_POST["username"]);
			
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
 
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
					$username = trim($_POST["username"]);
                } else{
                    $username_error = "This username does not exist";
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 15){
        $password_error = "Password must be the combination of 15 characters, including upper and lower cases, numbers, special cases";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPassword_error = "Please confirm password.";     
    } else{
        $confirmPassword = trim($_POST["confirmPassword"]);
        if(empty($password_error) && ($password != $confirmPassword)){
            $confirmPassword_error = "Password did not match.";
        }
    }
	
	// Prepare a select statement
	$sql = "SELECT id, username, password FROM login_users WHERE username = ?";
	$stmt = mysqli_stmt_init($link);

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
            
        // Set parameters
        $param_username = $username;
            
        // Attempt to execute the prepared statement to check if the password is the current one
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
                
            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
						$password_error = "This is your current password.";
					}
				}
			}
			else{
                    // Display an error message if username doesn't exist
                    $username_error = "No account found with that username.";
                }
		}
		else{
                echo "Oops! Something went wrong. Please contact your systems administrator.";
				header ("location: index.php");
            }
		// Close statement
        mysqli_stmt_close($stmt);
	}
	//Check to see if this is an old password
	
	$selectStatement = "SELECT * FROM login_pass WHERE Username = '$username'";
	$squery = mysqli_query($link, $selectStatement);
	if(!$squery)
	{
		die('Invalid query: ' . mysqli_error($link));
	}
	
	//ValidPass is the error message
	$validPass = "";
	//Gets an array of the row
	$result = $squery->fetch_array(MYSQLI_ASSOC);
	$currentnum = $result["Passwords"] + 1;
	$password2 = $result["Password1"];
	$password3 = $result["Password2"];
	$password4 = $result["Password3"];
	$password5 = $result["Password4"];
	$password6 = $result["Password5"];
	$password7 = $result["Password6"];
	$password8 = $result["Password7"];
	$password9 = $result["Password8"];
	$password10 = $result["Password9"];
	$password11 = $result["Password10"];
	if(password_verify($password, $password2)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password3)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password4)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password5)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password6)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password7)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password8)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password9)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password10)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password11)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	elseif(password_verify($password, $password2)){
		echo "Already used this password.";
		$validPass = "Old";
	}
	else{}
	
    
    // Check input errors before inserting in database
    if(empty($username_error) && empty($password_error) && empty($confirmPassword_error)){
		if(empty($validPass)){
			// Prepare an update statement
			
			$sql = "UPDATE login_pass SET passwords = ?, password1 = ?, password2 = ?,
			password3 = ?, password4 = ?, password5 = ?, password6 = ?,
			password7 = ?, password8 = ?, password9 = ?, password10 = ? WHERE username = ?";
         
			if($stmt = mysqli_prepare($link, $sql)){
			
				// Set parameters
				$param_username = $username;
				// Creates a password hash
				$param_password = password_hash($password, PASSWORD_BCRYPT); 
			
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "isssssssssss", $currentnum, $param_password, $password2, $password3, $password4, $password5, $password6, $password7, $password8, $password9, $password10, $param_username);
            
			
			$updatemain = "UPDATE login_users SET password = ? WHERE username = ?";
			if($updatestatement = mysqli_prepare($link, $updatemain)){
			
				mysqli_stmt_bind_param($updatestatement, "ss", $param_password, $param_username);
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt) && mysqli_stmt_execute($updatestatement)){
					// Redirect to login page
					header("location: login.php");
				} else{
					echo "Something went wrong. Please try again later." . mysqli_error($link);
				}
			}
			else
			{
				echo "Update not prepared";
			}

				// Close statement
				mysqli_stmt_close($stmt);
			}
		}
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Create new password</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="styles.css">
<!-- Favicon-->
<link rel="icon" type="image/png" sizes="32x32" href="gear.png">

<style type="text/css">
        body{ 
			font-family: 'Raleway', sans-serif;
		}
		
        .wrapper{ 
			width: 45%; 
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

		.navigation .icon {
		  display: none;
		}

    </style>

</head>

<div id="outer_frame">

<body>

<div id="header">

</div>

<div class="navigation" id = "signupNavigation">

<nav>
<a href="index.php"><i class="fa fa-fw fa-home"></i>    Home</a>
<a href="#"><i class="fa fa-fw fa-search"></i>    Search</a> 
<a href="#"><i class="fa fa-fw fa-envelope"></i>    Contact</a>
<a href="signup.php"><i class="fa fa-sign-in"></i>    Sign Up</a>
<a href="login.php" class = "active"><i class="fa fa-fw fa-user"></i>    Log In</a>
<a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
</nav>

</div>

<div class="wrapper">
<header>Reset or change your password</header>
<br>
<br>
<form action= "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
    <label>Enter Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
    <span class="errorReporting"><?php echo $username_error; ?></span>
	</div>					
    <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
	<label for = "signupPassword">Create Password</label>
    <input type="password" name="password" onkeyup="keyupFunction()" id = "pass" class="form-control" value="<?php echo $password; ?>">
	<label for = "passwordmeter">Password Strength</label>
	<meter max="5" ID="passmeter" value = 0></meter>
	<br>
    <span class="errorReporting"><?php echo $password_error; ?></span>
    </div>
    <div class="form-group <?php echo (!empty($confirmPassword_error)) ? 'has-error' : ''; ?>">
    <label>Confirm Password</label>
    <input type="password" name="confirmPassword" class="form-control" value="<?php echo $confirmPassword; ?>">
    <span class="errorReporting"><?php echo $confirmPassword_error; ?></span>
	</div>
	
	<div class="form-group">
	<button type="submit" class="btn btn-primary" name="reset-request-submit">Create New Password</button>
	</div>
	
</form>	

</div>



<script>

function keyupFunction(){
	var password = document.getElementById("pass").value;
	var meter = document.getElementById("passmeter");
	var strength = 0;
	if (password.length >= 15)
	{
		strength++;
	}
	
	var patt1 = /[0-9]/g;
	
	if(password.match(patt1))
	{
		strength++;
	}
	
	var patt2 = /[a-z]/g;
	if(password.match(patt2))
	{
		strength++;
	}
	
	var patt3 = /[A-Z]/g;
	if(password.match(patt3))
	{
		strength++;
	}
	
	var patt4 = /[$&+,:;=?@#|'<>.^*()%!-]/g;
	if(password.match(patt4))
	{
		strength++;
	}
	
	meter.value = strength;
}

</script>
	


</body>

<footer>
<?php
	require "footer.php"
?>
</footer>