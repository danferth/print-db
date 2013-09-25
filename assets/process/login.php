<?php 
include "../connection.php";
require_once "../functions.php";

if(isset($_POST['submit'])){

		$suppliedUser = $_POST['user'];
		$suppliedPass = $_POST['pass'];
	
	$q = $db->prepare("SELECT * FROM users WHERE user=:user");
		$q->bindParam(":user",$suppliedUser);
		$q->execute();
	
		$result = $q->fetch(PDO::FETCH_ASSOC);
		$q->closeCursor();
		$testPass = $suppliedPass.$result['salt'];
		$hashedTestPass = hash('sha512',$testPass);
	
	if($hashedTestPass === $result['pass']){
			queryRedirect('list',$result['ID']);
		}else{
			
			queryRedirect('index','error');
		}
	
}
 ?>