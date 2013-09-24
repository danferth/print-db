<?php 
session_start();
include "../connection.php";
require_once "../functions.php";
sessionTimeout();

	if(!$_POST['submit']){
		echo "nothing added to database";
		header('Location:index.php');
	}else{

				checkBox('useOld');
				checkBox('revision');
				checkBox('order');
				checkBox('ordered');
				checkBox('alert');

		$part 			= 	$_POST['part'];
		$inHouse 		= 	$_POST['inHouse'];
		$useOld			= 	$_POST['useOld'];
		$description 	= 	$_POST['description'];
		$revision 		= 	$_POST['revision'];
		$order 			=	$_POST['order'];
		$ordered 		=	$_POST['ordered'];
		$alert 			= 	$_POST['alert'];
		$message 		= 	$_POST['message'];

		$query = $db->prepare("INSERT INTO fliers (`ID`, `part_num`, `in_house`, `use_old`, `desc`, `revision`, `order`, `ordered`, `alert`, `message`) VALUES (NULL, :part, :inHouse, :useOld, :description, :order, :ordered, :revision, :alert, :message)");

		$query->bindParam(":part",$part);
		$query->bindParam(":inHouse",$inHouse);
		$query->bindParam(":useOld",$useOld);
		$query->bindParam(":description",$description);
		$query->bindParam(":order",$revision);
		$query->bindParam(":ordered",$order);
		$query->bindParam(":revision",$ordered);
		$query->bindParam(":alert",$alert);
		$query->bindParam(":message",$message);
		$query->execute();

		dbClose();
		
		redirect('list');
	
	}
 ?>