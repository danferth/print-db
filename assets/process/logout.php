<?php 
session_start();
require_once '../functions.php';


if(isset($_POST['logout'])){
	session_unset();
	session_destroy();

	redirect('index');
}


 ?>