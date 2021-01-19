<?php
session_start();
//Connect to database
 require_once 'database.php';
 require_once 'signupDB.php';
 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="description" content="Registration Page">
	<meta name="author" content="Qamar Abdikadir">
    <title>Sign Up</title>
	<!-- External stylesheet for signup page-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- External stylesheet for signup page font-->
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css">
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
<body>
<div class="navigation" id = "signupNavigation">

<nav>
<a href="index.php"><i class="fa fa-fw fa-home"></i>    Home</a>
<a href="#"><i class="fa fa-fw fa-search"></i>    Search</a> 
<a href="signup.php" class = "active"><i class="fa fa-sign-in"></i>    Sign Up</a>
<a href="activate.php"><i class="fa fa-check"></i>    Activate</a>
<a href="login.php"><i class="fa fa-fw fa-user"></i>    Log In</a>
<a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
</nav>

</div>

    <div class="wrapper">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id = "registrationForm">
            <div class="form-group <?php echo (!empty($name_error)) ? 'has-error' : ''; ?>">
                <label>Enter Your Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="errorReporting"><?php echo $name_error; ?></span>
            </div> 
			<div class="form-group <?php echo (!empty($email_error)) ? 'has-error' : ''; ?>">
                <label>Enter Your Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="errorReporting"><?php echo $email_error; ?></span>
            </div>	
			<div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                <label>Create Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="errorReporting"><?php echo $username_error; ?></span>
            </div>					
            <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
				<label for = "signupPassword">Create Password</label>
                <input type="password" name="password" onkeydown="keydownFunction()" id = "pass" class="form-control" value="<?php echo $password; ?>">
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
			<div class="form-group <?php echo (!empty($sec1_error)) ? 'has-error' : ''; ?>">
				<label name="sec1Lbl">Security Question #1: What is your mother's maiden name?</label>
				<br>
				<input name="sec1Fld" type="text" placeholder="Security Question #1">
				<br>
				<span class="errorReporting"><?php echo $sec1_error; ?></span>
				<br>
			</div>
			<div class="form-group <?php echo (!empty($sec2_error)) ? 'has-error' : ''; ?>">
				<label name="sec2Lbl">Security Question #2: What state were you born in?</label>
				<br>
				<input name="sec2Fld" type="text" placeholder="Security Question #2">
				<br>
				<span class="errorReporting"><?php echo $sec2_error; ?></span>
				<br>
			</div>
			<div class="form-group <?php echo (!empty($sec3_error)) ? 'has-error' : ''; ?>">
				<label name="sec3Lbl">Security Question #3: What was your first grade teacher's name?</label>
				<br>
				<input name="sec3Fld" type="text" placeholder="Security Question #3">
				<br>
				<span class="errorReporting"><?php echo $sec3_error; ?></span>
				<br>
			</div>
			<label><input type = "checkbox" name = "remember">  Remember me</label>
			<br>
			<br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Create Account!">
                <input type="reset" class="btn btn-default" value="Reset" onclick = "resetForm()" style="margin-left:30px;">
            </div>
            <p>Already have an account? <a href="login.php">Go to Login</a></p>
        </form>
    </div> 

<script>
function myFunction() {
  var x = document.getElementById("signupNavigation");
  if (x.className === "navigation") {
    x.className += " responsive";
  } else {
    x.className = "navigation";
  }
}

function resetForm() {
  document.getElementById("registrationForm").reset();
  document.getElementById("passmeter").reset();
}

function keydownFunction(){
	var password = document.getElementById("pass").value;
	var meter = document.getElementById("passmeter");
	var strength = 0;
	if (password.length >= 14)
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
</html>