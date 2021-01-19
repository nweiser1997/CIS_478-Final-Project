<?php
session_start();
// Connect to database
 require_once 'database.php';
 

unset ($_SESSION["login_attempts"]);

$email = "";
$email_error = "";

 // Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
if(empty(trim($_POST["email"]))){
        $email_error = "Please enter your email.";
    } 
	else
	{
    $email = trim($_POST["email"]);
   // Validate email
        // Prepare a select statement
        $sql = "SELECT id FROM login_users WHERE email = ?";
          // Set parameters
        $param_email = $email;
		
        if($stmt = mysqli_prepare($link, $sql)){
 
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $email);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
 
			if(mysqli_stmt_num_rows($stmt) == 1)
			{
	
				$body = 'You have requested to change your password! Please click the link below to reset your password.
				
Create new password: http://bscacad3.buffalostate.edu/~weisernj01/CIS_478/change-pass.php?email='.$email.'  
				';
				$to = $email;
				$subject = "Reset Password";
				$from = "LOGINSYSTEM@NO-REPLY.COM";
				$headers = "From:".$from;
				mail($to,$subject,$body,$headers);
				echo "An email with instructions has been sent to you!"; 
			}
			else{
				$email_error = "No account with this email found. Please try again.";
			}
            // Close statement
            mysqli_stmt_close($stmt);
        }
		// Close connection
		mysqli_close($link);
	  }
	}
	
	// Resets the password after confirming security question answers match

	// Checks if all questions are answered
	if(!($_POST["usernameFld"]))
	{
		$username_error = "Username must be entered.";
	}
	else
	{
		$usernameEnt = $_POST["usernameFld"];
	}
	
	if(!($_POST["sec1Fld"]))
	{
		$sec1_error = "Please answer the first security question.";
	}
	else
	{
		$sec1 = $_POST["sec1Fld"];
	}
	
	if(!($_POST["sec2Fld"]))
	{
		$sec2_error = "Please answer the second security question.";
	}
	else
	{
		$sec2 = $_POST["sec2Fld"];
	}
	
	if(!($_POST["sec3Fld"]))
	{
		$sec3_error = "Please answer the third security question.";
	}
	else
	{
		$sec3 = $_POST["sec3Fld"];
	}
	
	// Checks if answers match database answers
	
	// Prepares SQL statement to get username
	$sql = "SELECT username from login_users WHERE username = '$usernameEnt';";
	
	// Executes SELECT statement and stores it in $username
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) == 0 && empty($username_error))
	{
		$username_error = "Username does not match in database.";
	}
	
	else
	{
		$username = $usernameEnt;
	}
	
	// Prepares SQL to get three Security question answers
	$sql = "SELECT Security1, Security2, Security3 from login_users 
		WHERE Security1 = '$sec1' & Security2 = '$sec2' & Security3 = '$sec3';";
	
	// Executes SELECT statements and stores them in $securityvars
	$result = mysqli_query($link, $sql);
	$securityvars = mysqli_fetch_array($result);
	
	// Compares grabbed data with user-entered answers
	if ($securityvars[0] == $sec1)
	{
		$ans1Correct = TRUE;
	}
	
	else
	{
		$ans1Correct = FALSE;
		$sec1_error = "Security question answers do not match.";
	}
	
	if ($securityvars[1] == $sec2)
	{
		$ans2Correct = TRUE;
	}
	
	else
	{
		$ans2Correct = FALSE;
		$sec2_error = "Security question answers do not match.";
	}
	
	if ($securityvars[2] == $sec3)
	{
		$ans3Correct = TRUE;
	}
	
	else
	{
		$ans3Correct = FALSE;
		$sec3_error = "Security question answers do not match.";
	}

	// Takes them to change-pass page if they match
	if ($ans1Correct == TRUE && $ans2Correct == TRUE && $ans3Correct = TRUE && empty($username_error))
	{
		header("Location: change-pass.php");
		exit;
	}
}

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Favicon-->
<link rel="icon" type="image/png" sizes="32x32" href="gear.png">

<style>
.form-group{
	margin-top:60px;
	margin-left: 50px;
}

.wrapper{ 
	width: 45%; 
	padding: 20px; 
	margin: auto;
}

.errorReporting{
	color: red;
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
<a href="signup.php"><i class="fa fa-sign-in"></i>    Sign Up</a>
<a href="activate.php"><i class="fa fa-check"></i>    Activate</a>
<a href="login.php" class = "active"><i class="fa fa-fw fa-user"></i>    Log In</a>
<a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
</nav>

</div>

<div class="wrapper">
<header>Reset your password</header>
<br>
<br>
<p style="text-indent:50px;">An email will be sent to you with instructions on how to reset your password.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id = "changePasswordForm">
    <div class="form-group <?php echo (!empty($email_error)) ? 'has-error' : ''; ?>">
		<label>Enter Your Email</label>
		<input type="email" name="email" class="form-control" style="width:55%;" value="<?php echo $email; ?>">
		<span class="errorReporting"><?php echo $email_error; ?></span>
    </div>	
		<br>
		<br>
		<br>
	<div class="form-group">
		<button type="submit" class="btn btn-primary" name="reset-request-submit" style="width:28%;">Change Password</button>
	</div>
</form>	

<h1>
Security Questions
</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
	<div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
		<label name="usernameLbl">Please enter your username</label>
		<br>
		<input name="usernameFld" type="text" placeholder="Username">
		<br>
		<span class="errorReporting"><?php echo $username_error; ?></span>
	</div>
	<div class="form-group <?php echo (!empty($sec1_error)) ? 'has-error' : ''; ?>">
		<label name="sec1Lbl">Security Question #1: What is your mother's maiden name?</label>
		<br>
		<input name="sec1Fld" type="text" placeholder="Security Question #1">
		<br>
		<span class="errorReporting"><?php echo $sec1_error; ?></span>
	</div>
	<div class="form-group <?php echo (!empty($sec2_error)) ? 'has-error' : ''; ?>">
		<label name="sec2Lbl">Security Question #2: What state were you born in?</label>
		<br>
		<input name="sec2Fld" type="text" placeholder="Security Question #2">
		<br>
		<span class="errorReporting"><?php echo $sec2_error; ?></span>
	</div>
	<div class="form-group <?php echo (!empty($sec3_error)) ? 'has-error' : ''; ?>">
		<label name="sec3Lbl">Security Question #3: What was your first grade teacher's name?</label>
		<br>
		<input name="sec3Fld" type="text" placeholder="Security Question #3">
		<br>
		<span class="errorReporting"><?php echo $sec3_error; ?></span>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Reset Password">
	</div>
</form>

</div>

</body>

<footer>
<?php
	require "footer.php"
?>
</footer>