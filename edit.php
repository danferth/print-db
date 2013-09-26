<?php 
session_start();
include "assets/connection.php";
require_once "assets/functions.php";
if(!isset($_SESSION['secure'])){
	session_destroy();
	redirect('index');
}
sessionTimeout();
if(!isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$q = "SELECT * FROM fliers WHERE ID= $ID";
	$result = $db->query($q);
	$db_result = $result->fetch(PDO::FETCH_ASSOC);
//page variables and head
$pageTitle = "Edit entry";
$pagecss = "edit.css";
include_once '_head.php';
 ?>
<body>
 <form class="editList" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
 	<a href="list.php" class="close">x</a>
	<h2>Editing the following entry</h2>
		<p class="formP"><strong>EDITING: </strong><?php echo $db_result['part_num']." | <strong>".$db_result['desc'] ?></strong></p>
	<div class="left">
	 	<p class="input"><input type='text' name='part' value="<?php echo $db_result['part_num']; ?>"><label for='part'>Part Number</label></p>
		<p class="input"><input type='text' name='inHouse' value="<?php echo $db_result['in_house']; ?>"><label for='inHouse'>In-House</label></p>
		<p class="input"><input type='text' name='description' value="<?php echo $db_result['desc']; ?>"><label for='description'>Description</label></p>
	</div>
	<div class="right">
		<p class="check"><?php boxChecked($db_result,'use_old','useOld'); ?><label for='useOld'>OK to Use Old</label></p>
		<p class="check"><?php boxChecked($db_result,'revision','revision'); ?><label for='revision'>In Revision</label></p>
		<p class="check"><?php boxChecked($db_result,'order','order'); ?><label for='order'>Need to Order</label></p>
		<p class="check"><?php boxChecked($db_result,'ordered','ordered'); ?><label for='ordered'>Ordered</label></p>
		<p class="check"><input type="checkbox" name="alert" checked><label for='alert'>Set Alert</label></p>
		<p><textarea name="message" cols="30" rows="4"><?php echo $db_result['message']; ?></textarea></p>
	
	 	<input type="hidden" name="id" value="<?php echo $_GET['ID'] ?>">
	 	<p class="check"><input type="checkbox" name="clearMessage"><label for="clearMessage">Check me to clear the message</label></p>
	
	 	<p><input type="submit" name="submit" value="submit"></p>
	 </div>

 </form>

<?php
}
	if(isset($_POST['submit'])){
		checkBox('useOld');
		checkBox('revision');
		checkBox('order');
		checkBox('ordered');
		checkBox('alert');


		$id 			=	$_POST['id'];
		$part 			= 	$_POST['part'];
		$inHouse 		= 	$_POST['inHouse'];
		$useOld 		=	$_POST['useOld'];
		$description 	= 	$_POST['description'];
		$revision 		= 	$_POST['revision'];
		$order 	 		= 	$_POST['order'];
		$ordered 		= 	$_POST['ordered'];
		$alert 			= 	$_POST['alert'];

		if(isset($_POST['clearMessage'])){
			$message = "";
		}else{
		$message 		= 	$_POST['message'];
		}

		$db_change = $db->prepare("UPDATE fliers SET `part_num`=:part, `in_house`=:inHouse, `use_old`=:useOld, `desc`=:description, `revision`=:revision, `order`=:order, `ordered`=:ordered, `alert`=:alert, `message`=:message WHERE ID='$id'");

		$db_change->bindParam(":part",$part);
		$db_change->bindParam(":inHouse",$inHouse);
		$db_change->bindParam(":useOld",$useOld);
		$db_change->bindParam(":description",$description);
		$db_change->bindParam(":revision",$revision);
		$db_change->bindParam(":order",$order);
		$db_change->bindParam(":ordered",$ordered);
		$db_change->bindParam(":alert",$alert);
		$db_change->bindParam(":message",$message);
		$db_change->execute();


		dbClose();

		header('Location:list.php');

	}

?>
<?php include_once '_tail.php'; ?>
<script>
	$(document).ready(function(){
		$('form.editList').on('mouseover',function(){
			$('body').css({'background':'rgba(0,0,0,.5)'});
		});
		$('form.editList').on('mouseout',function(){
			$('body').css({'background':'rgba(0,0,0,0'});
		});

		$.labelSwitch();



	});

</script>
</body>
</html>