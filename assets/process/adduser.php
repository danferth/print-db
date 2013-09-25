<?php 
session_start();
include "../connection.php";
require_once "../functions.php";
//check if admin
if($_SESSION['admin'] == 1){

	//check for submit
	if(isset($_POST['submit'])){
		//check for matching passwords
		if($_POST['password'] === $_POST['passwordConfirm']){
			$newUser = $_POST['username'];
			$suppliedPass = $_POST['password'];
			checkBox('isAdmin');
			$isAdmin = $_POST['isAdmin'];
			//sanitize username for user check
			$sanitizedUser = $db->quote($newUser);
			$q = "SELECT * FROM users WHERE user =".$sanitizedUser;
			$result = $db->query($q);
			//check for existing user
			if($result->rowCount()>0){
				$result->closeCursor();
				dbClose();
				queryRedirect('list','userAlreadyExists');
			}else{
	
				//start creating user
				$createdSalt = rand(1000,1000000);
				$password = $suppliedPass.$createdSalt;
				$hashedPass = hash('sha512',$password);
				//insert user into db
				$q = $db->prepare("INSERT INTO users (`ID`, `user`, `pass`, `salt`, `admin`) VALUES (NULL,:user, :pass, :salt, :admin)");
					$q->bindParam(":user", $newUser);
					$q->bindParam(":pass", $hashedPass);
					$q->bindParam(":salt", $createdSalt);
					$q->bindParam(":admin", $admin);
					$q->execute();
				
				if(!$q){
						die(print_r($db_conn->errorInfo(), TRUE));
					}
					if($q){
						$q->closeCursor();
						queryRedirect('list','newUserSuccess');
					}
				}
	
		}else{
			queryRedirect('list','badpass');
		}
	
	}else{
		redirect('list');
	}
}else{
	session_destroy();
	redirect('index');
}




 ?>