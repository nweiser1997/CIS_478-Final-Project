<?php
	require "header.php"
?>

	</head>

<div id="outer_frame">

<body>

<div id="header">

</div>

<div class="navigation" id = "signupNavigation">

<nav>
<a href="index.php">Home</a>
<a href="signup.php">Sign Up</a>
<a href="login.php" class = "active">Log In</a>
</nav>

</div>

<h1>Reset your password</h1>
<p> An email will be send to you with instructions on how to reset your password. </p>
<form action= "includes/reset-request.php" method="post">
	<input type="text" name="email" placeholder= "Enrer your e-mail address.."> 
	<button type="submit" name="reset-request-submit">Receive new password by e-mail address</button>
</form>	