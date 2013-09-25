<?php 
include "../connection.php";
require_once "../functions.php";

if(isset($_POST['submit'])){

	$suppliedUser = $_POST['user'];
	$suppliedPass = $_POST['pass'];

//query db for username
$q = $db->prepare("SELECT * FROM users WHERE user=:user");
	$q->bindParam(":user",$suppliedUser);
	$q->execute();

	$result = $q->fetch(PDO::FETCH_ASSOC);
//take suplied password and add salt from user query
$testPass = $suppliedPass.$result['salt'];
//hash it and put into var
$hashedTestPass = hash('sha512',$testPass);
//compare to password in db
if($hashedTestPass === $result['pass']){
		queryRedirect('list',$result['ID']);
	}else{
		
		queryRedirect('index','error');
	}

}
 ?>