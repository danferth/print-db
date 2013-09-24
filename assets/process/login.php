<?php 
include "../connection.php";
require_once "../functions.php";

if(isset($_POST['submit'])){

	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$q = $db->prepare("SELECT * FROM users WHERE user=:user AND pass=:pass");
	$q->bindParam(":user",$user);
	$q->bindParam(":pass",$pass);
	$q->execute();

	$result = $q->fetch(PDO::FETCH_ASSOC);

	if($q->rowCount() == 1){
		queryRedirect('list',$result['ID']);
	}else{
		
		queryRedirect('index','error');
	}


}
 ?>