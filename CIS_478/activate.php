<?php
require_once 'database.php';

if(empty($_POST["otp"])){
   $otp_error = "Please enter a OTP code.";
}
else if(!empty($_POST["submit"]) && $_POST["otp"]!='') {
$sqlQuery = "SELECT id FROM login_otp WHERE otp='". $_POST["otp"]."' AND expired!=1 AND NOW() <= DATE_ADD(created, INTERVAL 1 HOUR)";
	$result = mysqli_query($link, $sqlQuery);
	$count = mysqli_num_rows($result);
	if(!empty($count)) {
		$sqlUpdate = "UPDATE login_otp SET expired = 1 WHERE otp = '" . $_POST["otp"] . "'";
		$result = mysqli_query($link, $sqlUpdate);
		header("Location:login.php");
	} else {
		$otp_error = "Invalid OTP!";
	}	
} 
else{
        $otp = trim($_POST["otp"]);
    }

?>
<!DOCTYPE HTML>
<head> 
<title>Activate Account</title>
<link rel="stylesheet" href="styles.css">
<!-- Favicon-->
<link rel="icon" type="image/png" sizes="32x32" href="gear.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.form-group{
	margin-top:30px;
	margin-left: 50px;
}

.wrapper{ 
	width: 45%; 
	padding: 20px; 
	margin: auto;
}

button{
	margin-top: 50px;
	margin-left: 30px;
}

		
		.errorReporting{
			color: red;
		}

</style>
</head>

<body>

<div id="outer_frame">

<body>

<div id="header">

</div>

<div class="navigation" id = "signupNavigation">

<nav>
<a href="index.php"><i class="fa fa-fw fa-home"></i>    Home</a>
<a href="#"><i class="fa fa-fw fa-search"></i>    Search</a> 
<a href="signup.php"><i class="fa fa-sign-in"></i>    Sign Up</a>
<a href="activate.php" class = "active"><i class="fa fa-check"></i>    Activate</a>
<a href="login.php"><i class="fa fa-fw fa-user"></i>    Log In</a>
<a href="javascript:void(0);" class="icon" onclick="myFunction()"></a>
</nav>

</div>

<div class="wrapper">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<div class="form-group <?php echo (!empty($otp_error)) ? 'has-error' : ''; ?>">
<!--NEEDS TO AUTHENTICATE OTP CODE AND THEN ENTER USER DATA INTO DATABASE--> 
<label>Enter 6-digit OTP Code</label>
<input type="text" name="otp" placeholder="123456" class="form-control" style="width:30%;" value="<?php echo $otp; ?>">
<span class="errorReporting"><?php echo $otp_error; ?></span>
</div>

<div class="form-group">
<form action="login.php">
<input type="button" class="btn btn-primary" name="otp" style="width:25%;" onclick = "location.href='login.php'" value="Verify Account!"></input>
</form>
</div>

</form>
</div>

<footer>
<?php
	require_once 'footer.php';
?>
</footer>