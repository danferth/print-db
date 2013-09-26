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
?>