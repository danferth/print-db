<?php 
session_start();
require_once 'assets/functions.php';
if(isset($_SESSION['user'])){
	redirect('list');
}

include "assets/connection.php";
//page variables and head
$pageTitle = "Log|In";
$pagecss = "login.css";
include_once '_head.php';
 ?>
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
<?php include_once '_tail.php'; ?>
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