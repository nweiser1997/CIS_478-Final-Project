<?php 
// Initialize the session
session_start();
 
// Check if the user is logged in. Yes --> stay on this page, No --> redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<head>

<div id="outer_frame">

<title>Logged In</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
	require_once 'header.php';
?>

<style>

.navigation a {
  margin-left:40px;
  padding: 20px;
  font-size: 35px;
  }
  
nav :last-child{
	float: right;
}

#logout{
	color:#bd2a13;
}
</style>
</head>

<body>

<div class="navigation" id = "signupNavigation">

<nav>
<a href="index.php" class = "active"><i class="fa fa-fw fa-home"></i></a>
<a href="#"><i class="fa fa-newspaper-o"></i></a>
<a href="#"><i class="fa fa-television"></i></a>
<a href="#"><i class="fa fa-gamepad"></i></a>
<a href="logout.php" id="logout"><i class="fa fa-power-off"></i></a>
</nav>

</div>

<div id="login_box">
<br>
<br>
<header>Congratulations! You have successfully logged in!</header>
<br>
<br>
	
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vehicula lacinia magna, ac rhoncus ipsum volutpat eu. Etiam sodales aliquam eleifend. Donec et dolor quis arcu consectetur porta quis non ante. Praesent consequat elit ac turpis finibus sollicitudin. Cras non ultrices nisi. Curabitur sed dolor neque. Etiam at egestas augue. Aliquam sagittis lobortis lectus, in volutpat metus aliquam vel. Aenean auctor elit sed justo tristique, nec hendrerit eros malesuada. Etiam tincidunt dolor aliquam, condimentum ligula et, mollis quam.</p>

<p>Sed vestibulum risus tellus, vitae mollis ipsum imperdiet ut. Duis sed ex tempor, ultricies sapien ut, efficitur ipsum. Sed cursus efficitur ex, sed maximus ligula interdum eget. Cras vestibulum sollicitudin leo. Vivamus tempor blandit elit a tincidunt. Duis quis laoreet nulla. Praesent dictum mi in mi gravida viverra. Proin ut molestie purus.</p>

<p>Quisque turpis diam, feugiat eget nisi ac, imperdiet porta urna. Vestibulum gravida elementum est, bibendum egestas leo faucibus ac. Suspendisse eget diam vitae erat blandit sollicitudin. Maecenas convallis velit ornare rhoncus pretium. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam rhoncus neque at dolor lacinia egestas. Maecenas lacus tellus, bibendum consectetur justo eu, hendrerit facilisis ante. Proin congue rutrum leo imperdiet tempor. Vivamus quis lorem a justo pellentesque mollis id quis felis. Nam a nunc non metus mattis porttitor at quis justo. Nunc accumsan mauris id metus accumsan, vitae luctus nisl consectetur. Integer eu sodales turpis. Sed nec tempor erat.</p>

</p>Aliquam sollicitudin, sapien a pulvinar molestie, nisi nisl consequat metus, quis iaculis massa ex in urna. Morbi non libero venenatis, consequat velit et, fermentum arcu. Nullam facilisis, nunc ultricies ultricies elementum, dui libero rutrum libero, in blandit leo elit a lorem. Mauris vitae convallis lectus. Phasellus et accumsan est. Morbi nisi nisi, scelerisque eu aliquam nec, euismod nec odio. Suspendisse aliquet non enim a cursus. Aenean vel nisl molestie, molestie turpis a, fermentum mi. Vestibulum porttitor fermentum ultrices. Mauris et sem eu ex rhoncus gravida eget vel ante. Nunc venenatis neque eget dictum tincidunt. Phasellus sodales, lacus eu venenatis rhoncus, lectus nisl tempor ante, vitae lobortis quam massa id felis.</p>

<p>Ut suscipit ligula a nulla sodales, vel posuere risus lobortis. Vestibulum elementum dui at vehicula blandit. Praesent pretium facilisis convallis. Suspendisse orci lectus, auctor non pretium at, accumsan ac elit. Nulla venenatis risus eget varius ultrices. Duis fermentum porta tellus vel vestibulum. Donec facilisis consequat augue id faucibus. Curabitur vitae mi id sem congue ultricies.</p>

</div>

</body>

<br>
<br>
<br>

<footer>
<?php
	require_once 'footer.php';
?>
</footer>