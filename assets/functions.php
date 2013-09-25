<?php 
//check radio for isset and output boolean to post variable
function checkBox($post){
				if(isset($_POST[$post])){
					$_POST[$post] = '1';
				}else{
					$_POST[$post] = '0';
					}
				}

//check if boolean in db was set or not. then output input with checked or not
//where $query = the mysql_query and $check is the column in the table queried
function boxChecked($query,$check,$name){

		if($query[$check] == 0){
			echo "<input type='checkbox' name=".$name.">";
		}elseif ($query[$check] == 1) {
			echo "<input type='checkbox' name=".$name." checked>";
		}
	}

//close connection to db
	function dbClose(){
	$db = null;
}

//session timeout put into form action pages so page does not parse if timeout
function sessionTimeout(){
$timeout = 3600;
if(isset($_SESSION['timeout'])){
	$sessionLife = time() - $_SESSION['timeout'];
	if($sessionLife > $timeout){
		session_destroy();
		header("Location: index.php?message=timeout");
	}
	$time = "timeout = 180 | sessionLife = ".$sessionLife." | time = ".$_SESSION['timeout'];
}

}

//redirect with query
function queryRedirect($page,$message){
// Build the query string to be attached to the redirected URL
$query_string = '?message=' . $message;
// Redirection domain and phisical dir
$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname('/www/print/asset/'), '/\\') . '/';
$next_page = $page.".php";
/* The header() function sends a HTTP message The 303 code asks the server to use GET when redirecting to another page */
header('HTTP/1.1 303 See Other');
header('Location: http://' . $server_dir . $next_page . $query_string);

}

//redirect without query
function redirect($page){
// Redirection domain and phisical dir
$server_dir = $_SERVER['HTTP_HOST'] . rtrim(dirname('/www/print/asset/'), '/\\') . '/';
$next_page = $page.".php";
/* The header() function sends a HTTP message The 303 code asks the server to use GET when redirecting to another page */
header('HTTP/1.1 303 See Other');
header('Location: http://' . $server_dir . $next_page);
}
//passwords initial creation**********************

function createFirstUser($firstUser, $initialPass, $db_conn){
//first user only, is admin
$admin = 1; 
//create salt with rand()
$createdSalt = rand(1000,1000000);
//get password from input
$suppliedPass = $initialPass;
//create var with password + salt
$password = $suppliedPass.$createdSalt;
// hash it
$hashedPass = hash('sha512',$password);
//insert into db
$q = $db_conn->prepare("INSERT INTO users (`ID`, `user`, `pass`, `salt`, `admin`) VALUES (NULL,:user, :pass, :salt, :admin)");
	$q->bindParam(":user", $firstUser);
	$q->bindParam(":pass", $hashedPass);
	$q->bindParam(":salt", $createdSalt);
	$q->bindParam(":admin", $admin);
	$q->execute();

if(!$q){
		die(print_r($db_conn->errorInfo(), TRUE));
	}
	if($q){
		echo "<p><strong>first user entered...</strong></p>";
		$q->closeCursor();
	}
}
//password compare on subsequent logins******************
// gather variables
if(isset($_POST['submit'])){

	$suppliedUser = $_POST['user'];
	$suppliedPass = $_POST['pass'];
	$sanitizedPass = $db->quote($suppliedPass);



//query db for username
$q = $db->prepare("SELECT * FROM users WHERE user=:user");
	$q->bindParam(":user",$suppliedUser);
	$q->execute();

	$result = $q->fetch(PDO::FETCH_ASSOC);
//take suplied password and add salt from user query
$testPass = $sanitizedPass.$result['salt'];
//hash it and put into var
$hasedTestPass = hash('sha512',$testPass);
//compare to password in db
if($hashedTestPass === $result['pass']){
		queryRedirect('list',$result['ID']);
	}else{
		
		queryRedirect('index','error');
	}

}
 ?>