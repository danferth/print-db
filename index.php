<?php 
session_start();
require_once 'assets/functions.php';
if(isset($_SESSION['user'])){
	redirect('list');
}

include "assets/connection.php";
 ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log|In</title>
	<!-- Opera speed dial icon -->
    <link rel="icon" type="image/png" href="assets/icons/195x195image.png">
	<!-- display largest first as iOS < 4.2 does not support size attr -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/icons/apple-touch-icon-114x114-precomposed.png">
	<!-- For iPad: apple doesn't need this but andoid OS (2.1+) does -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/icons/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" href="assets/icons/touch-icon-iphone.png" />
	<!-- browser should find ICO file by default without <link> -->
	<link rel="icon" type="image/png" href="assets/icons/favicon.png" />
	<!--[if IE]><link rel="shortcut icon" href="pathto/favicon.ico"><![endif]-->
	<!-- or, set /favicon.ico for IE10 win -->
	<meta name="msapplication-TileColor" content="#2E8D61">
	<meta name="msapplication-TileImage" content="assets/icons/tileicon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="assets/coffee/functions.js"></script>
	<script src="assets/coffee/prefixfree.min.js"></script>
	
</head>
<body>
<div class="wrapper login">


<h1>Login please</h1>
<form action="assets/process/login.php" method="POST">
	<p class="input"><input type="text" name="user" required><label for="user">User Name</label></p>
	<p class="input"><input type="password" name="pass" required><label for="pass">Password</label></p>
	<p><input type="submit" name="submit" value="Enter"></p>

</form>

<?php 
if(isset($_GET['message'])){
	if($_GET['message'] == "error"){
		echo "<p class='alert'>Username or Password is Incorrect</p>";
	}
	if($_GET['message'] == "timeout"){
		echo "<p class='alert'>Sorry but you have been logged out due to inactivity</p>";
	}
}

 ?>	
</div><!-- end wrapper -->
<script>
	$(document).ready(function(){
		$('.wrapper').hide().delay(500).fadeIn(1000);

		$('.wrapper').on('mouseover',function(){
			$('body').css({'background':'rgba(0,0,0,.35'});

		});
		$('.wrapper').on('mouseout',function(){
			$('body').css({'background':'rgba(0,0,0,.0'});

		});

$.labelSwitch();



	});
	</script>
</body>
</html>