<?php
session_start();
include "assets/connection.php";
require_once "assets/functions.php";
if(!isset($_SESSION['secure'])){
	session_destroy();
	redirect('index');
}
sessionTimeout();
$_SESSION['timeout'] = time();

if(!isset($_SESSION['user'])){

	$q = $db->prepare("SELECT * FROM users WHERE ID=:id");
	$q->bindParam(":id", $_GET['message']);
	$q->execute();
	$userResult = $q->fetch(PDO::FETCH_ASSOC);
	
	$_SESSION['user'] = $userResult['user'];
	$_SESSION['admin'] = $userResult['admin'];
	$q->closeCursor();
	
	$welcomeMessage = "<p class='welcome'>Welcome ". $_SESSION['user']."</p>";
}else{
	$welcomeMessage = "<p class='welcome'>Logged in as: ". $_SESSION['user']."</p>";
}
dbClose();
//page variables and head
$pageTitle = "the List";
$pagecss = "list.css";
include_once '_head.php';
include_once '_tail.php';
?>
<script>

$(document).ready(function(){

$.labelSwitch();
//warning on delete
	$('a.delete').on('click',function(){

		var id = $(this).closest('tr').find('td.desc').html();
		if(confirm("Are you sure you want to delete " + id + "?")){
		}else{
			return false;
		}

	});
//replace boolean with Icons
//old
$('.old').icon('U');
//revision
$('.revision').icon("R");
//order
$('.order').icon("o");
//ordered
$('.ordered').icon("O");
//message
$('.message').icon("A");

//if alert checked then add class alerted to tr
$('td.alert').hide();
$('.alert').each(function(){
  if($(this).text() != 0){
  $(this).closest('tr').addClass('alerted');
  }
});
//form actions
$('.addItem, .email, .adduser').hide();
//check for message ad display adduser if true
var urlString = String(document.location);
var test1 = "?message=badpass";
var test2 = "?message=userAlreadyExists";

if(urlString.indexOf(test1) != -1){
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.adduser').fadeIn(200);	
}
if(urlString.indexOf(test2) != -1){
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.adduser').fadeIn(200);	
}
$('.addButton').on('click',function(){
	if($('.email:visible')){
		$('.email').hide();
	}
	if($('.adduser:visible')){
		$('.adduser').hide();
	}
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.addItem').fadeIn(200);
});
$('.emailButton').on('click',function(){
	if($('.addItem:visible')){
		$('.addItem').hide();
	}
	if($('.adduser:visible')){
		$('.adduser').hide();
	}
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.email').fadeIn(200);
});
$('.adminButton').on('click',function(){
	if($('.addItem:visible')){
		$('.addItem').hide();
	}
	if($('.email:visible')){
		$('.email').hide();
	}
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.adduser').fadeIn(200);
});

$('.close').on('click',function(){
	$(this).parent('form').fadeOut(100);
	$('body').css({'background':'rgba(0,0,0,.0)'});
	$('.wrapper').delay(300).fadeIn(400);
});
$('#list').tablesorter();
//sets scroll on long tables

var windowWidth = $(window).width();
if(windowWidth <= 790){
	$('.tableWrap, .theList td').css({'width':windowWidth});

}


//new user form controls




});
</script>
<body>
<!-- header with logout****************************************************** -->
<header>	
<form id="logout" action="assets/process/logout.php" method="POST">
<input type="submit" name="logout" value="logout">
</form>
<?php echo $welcomeMessage; ?>
</header>
<!-- admin*********************************************************************** -->
<?php
if($_SESSION['admin'] == 1){
	echo "<button class='adminButton'>!</button>";
}
?>
<form action="assets/process/adduser.php" class="adduser" method="POST">
	<button class="close">x</button>
	<?php
		if(isset($_GET['message'])){
			if($_GET['message'] == 'badpass'){
				echo "<p class='alert'>PASSWORDS DO NOT MATCH</p>";
			}
			if($_GET['message'] == 'userAlreadyExists'){
				echo "<p class='alert'>USER NAME ALREADY IN USE</p>";
			}
		}
	?>
	<h2>Add new user</h2>
	<p class="input"><input type="text" name="username" required><label for="username">user name</label></p>
	<p class="input"><input type="password" name="password" required><label for="password">password</label></p>
	<p class="input"><input type="password" name="passwordConfirm" required><label for="passwordConfirm">repeat password</label></p>
	<p class="check"><input type="checkbox" name="isAdmin"><label for="isAdmin">will this user be admin?</label></p>
	<input type="submit" name="submit" value="add user">

</form>

</div>


<!-- The List******************************************************************* -->
<div class="wrapper">
<h1>The List</h1>
<div class="tableWrap">
	<table class="theList" id="list">
		<thead>
			<tr>
				<th>Part#</th>
				<th>Cur. REV</th>
				<th>Can Use Old</th>
				<th>Description</th>
				<th>Revision</th>
				<th>Need to Order</th>
				<th>Ordered</th>
				<th>Message</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
	</tbody>
<?php
$SQL = "SELECT * FROM fliers";
$result = $db->query($SQL);
while($db_field = $result->fetch(PDO::FETCH_ASSOC)){
	if($db_field['message'] === "" || $db_field['message'] === "message"){
		$message = "";
	}else{
		$message = "A";
	}

	echo '<tr>
	<td data-title="Part#" class="part">'.$db_field['part_num'].'</td>
	<td data-title="Cur. Rev">'.$db_field['in_house'].'</td>
	<td data-title="Use Old" class="bullet old">'.$db_field['use_old'].'</td>
	<td data-title="Desc" class="desc">'.$db_field['desc'].'</td>
	<td data-title="Revision" class="bullet revision">'.$db_field['revision'].'</td>
	<td data-title="Order" class="bullet order">'.$db_field['order'].'</td>
	<td data-title="Ordered" class="bullet ordered">'.$db_field['ordered'].'</td>
	<td data-title="Alert" class="bullet alert">'.$db_field['alert'].'</td>
	<td data-title="Message" class="bullet message">'.$message.'</td>
	<td data-title="Edit" class="edit"><a href="edit.php?ID='.$db_field['ID'].'">edit</a></td>
	<td data-title="Delete" class="delete"><a class="delete" href="assets/process/delete.php?ID='.$db_field['ID'].'">delete</a></td>
	</tr>';
}
?>
	</tbody>
	</table>
	</div>
</div><!-- end wrapper -->
<?php
//close connection to mySQL
$result->closeCursor();
dbClose();
?>
<!-- form to add records*************************************************** -->
<form class="addItem" action='assets/process/add.php' method='Post'>
	<button class="close">x</button>
	<h2>Add to the List</h2>
	<div class="left">
		<p><textarea name="message" cols="30" rows="4"></textarea></p>
		<p class="input"><input type='text' name='part' required><label for='part'>part</label>				</p>
		<p class="input"><input type='text' name='inHouse'><label for='isUseOld'>Current Revision</label>	</p>
		<p class="input"><input type='text' name='description' required><label for='description'>description</label>	</p>
	</div>
	<div class="right">
		<p class="check"><input type='checkbox' name='useOld'><label for='isUseOld'>OK to Use Old</label>	</p>
		<p class="check"><input type='checkbox' name='revision'><label for='isRevision'>In Revision</label>	</p>
		<p class="check"><input type='checkbox' name='order'><label for='isRevision'>Need to Order</label></p>
		<p class="check"><input type='checkbox' name='ordered'><label for='isRevision'>Ordered</label>		</p>
		<p class="check"><input type='checkbox' name='alert' checked><label for='isAlert'>Alert</label>			</p>
  		<input type='submit' name='submit' value='submit'>
	</div>
</form>
<!-- form for email************************************************************** -->
<form class="email" action="assets/process/mail.php" method="POST">
	<button class="close">x</button>
	<h2>email yo peeps</h2>
	<div class="left">
		<p class="input"><input type="email" name="from" required><label for="from">From email:</label></p>
		<h2>To:</h2>
		<p class="check"><input type="checkbox" name="marketing"><label for="marketing">Marketing <em>(Dan)</em></label></p>
		<p class="check"><input type="checkbox" name="admin"><label for="marketing">Administrator <em>(Angelica)</em></label></p>
		<p class="check"><input type="checkbox" name="warehouse"><label for="marketing">Warehouse <em>(Maritza)</em></label></p>
		<p class="check"><input type="checkbox" name="purchasing"><label for="marketing">Purchasing <em>(Ashley)</em></label></p>
	</div>
	<div class="right">
		<p><textarea name="emailMessage" cols="30" rows="8"></textarea></p>
		<p><input type="submit" name="send" value="send"></p>
	</div>
</form>
<!-- footer******************************************************** -->
<footer>
	<p>Actions:</p>
	<button class="addButton">Add to the List</button>
	<button class="emailButton">email some peeps</button>

</footer>

</body>
</html>