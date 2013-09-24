<?php
session_start();
include "assets/connection.php";
require_once "assets/functions.php";
sessionTimeout();
$_SESSION['timeout'] = time();

if(!isset($_SESSION['user'])){

	$q = $db->prepare("SELECT * FROM users WHERE ID=:id");
	$q->bindParam(":id", $_GET['message']);
	$q->execute();
	$userResult = $q->fetch(PDO::FETCH_ASSOC);
	
	$_SESSION['user'] = $userResult['user'];
	
	$welcomeMessage = "<p class='welcome'>Welcome ". $_SESSION['user']."</p>";
}else{
	$welcomeMessage = "<p class='welcome'>Logged in as: ". $_SESSION['user']."</p>";
}



?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>fliers</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/list.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="assets/coffee/functions.js"></script>
	<script src="assets/coffee/prefixfree.min.js"></script>
	<script src="assets/coffee/tablesorter.js"></script>
</head>
<body>
<header>	
<form id="logout" action="assets/process/logout.php" method="POST">
<input type="submit" name="logout" value="logout">
</form>

<?php echo $welcomeMessage; ?>
</header>
<div class="wrapper">
<h1>The List</h1>
	<table class="theList" id="list">
		<thead>
			<tr>
				<th>Part#</th>
				<th>In-house</th>
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
	<td>'.$db_field['part_num'].'</td>
	<td>'.$db_field['in_house'].'</td>
	<td class="bullet old">'.$db_field['use_old'].'</td>
	<td class="desc">'.$db_field['desc'].'</td>
	<td class="bullet revision">'.$db_field['revision'].'</td>
	<td class="bullet order">'.$db_field['order'].'</td>
	<td class="bullet ordered">'.$db_field['ordered'].'</td>
	<td class="bullet alert">'.$db_field['alert'].'</td>
	<td class="bullet message">'.$message.'</td>
	<td><a href="edit.php?ID='.$db_field['ID'].'">edit</a></td>
	<td><a class="delete" href="assets/process/delete.php?ID='.$db_field['ID'].'">delete</a></td>
	</tr>';
}
?>
	</tbody>
	</table>
</div><!-- end wrapper -->
<?php
//close connection to mySQL
$result->closeCursor();
dbClose();	
//form to add records

//******************************
?>

<form class="addItem" action='assets/process/add.php' method='Post'>
	<button class="close">x</button>
	<h2>Add 2 the List</h2>
	<div class="left">
		<p><textarea name="message" cols="30" rows="4"></textarea></p>
		<p class="input"><input type='text' name='part' required><label for='part'>part</label>				</p>
		<p class="input"><input type='text' name='inHouse'><label for='isUseOld'>rev in house</label>	</p>
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

<form class="email" action="assets/process/mail.php" method="POST">
	<button class="close">x</button>
	<h2>email yo peeps</h2>
	<div class="left">
		<p class="input"><input type="email" name="from" required><label for="from">From email:</label></p>
		<p class="formP">TO:</p>
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



<footer>
	<p>Actions:</p>
	<button class="addButton">Add 2 the List</button>
	<button class="emailButton">email some peeps</button>
</footer>

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
$('.alert').hide();
$('.alert').each(function(){
  if($(this).text() != 0){
  $(this).closest('tr').addClass('alerted');
  }
});



//form actions
$('.addItem, .email').hide();

$('.addButton').on('click',function(){
	if($('.emailvisible')){
		$('.email').hide();
	}
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.addItem').fadeIn(200);
});

$('.emailButton').on('click',function(){
	if($('.addItem:visible')){
		$('.addItem').hide();
	}
	$('body').css({'background':'rgba(0,0,0,.45)'});
	$('.wrapper').hide();
	$('.email').fadeIn(200);
});

$('.close').on('click',function(){
	$(this).parent('form').fadeOut(100);
	$('body').css({'background':'rgba(0,0,0,.0)'});
	$('.wrapper').delay(300).fadeIn(400);
});

$('#list').tablesorter();

});
</script>

</body>
</html>