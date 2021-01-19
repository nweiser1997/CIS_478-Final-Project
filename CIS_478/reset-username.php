<head>

<head>
<title>Retrieve username</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="styles.css">
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
<header>Reset your username</header>
<br>
<br>
<p style="text-indent:50px;"> An email will be sent to you with instructions on how to reset your username. </p>
<form action= "includes/reset-request.php" method="POST">
    <div class="form-group">
	<input type="email" name="forgotUsername" class="form-control" placeholder= "Enter your email" style="width:55%;" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>		
	<br>
	<br>
	<br>	
	<button type="submit" class="btn btn-primary" name="reset-request-submit">Retrieve Username by Email</button>
	</div>
</form>	

</div>

</body>

<footer>
<?php
	require "footer.php"
?>
</footer>