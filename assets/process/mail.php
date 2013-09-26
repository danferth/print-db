<?php 
session_start();
require_once "../functions.php";
sessionTimeout();

<<<<<<< HEAD

$message = $_POST['emailMessage'];
$from = $_POST['from'];
$to = array();

if(isset($_POST['marketing'])){
	$to[] = "";
}
if(isset($_POST['admin'])){
	$to[] = "";
}
if(isset($_POST['warehouse'])){
	$to[] = "";
}
if(isset($_POST['purchasing'])){
	$to[] = "";
}




$mail->senderName = "Fliers ALERT!";
$mail->senderMail = $from;
$mail->subject = "ALERT! | Fliers page needs your attention";

$mail->body = $message;

$mail->create();



$recipients = $to;
  if($mail->send($recipients)){
  	redirect('list');
}else{
   echo $mail->error;
=======
if(!isset($_POST['send'])){
	session_destroy();
	redirect('index');
	}else{

	require_once("mimemail.php");
	$mail = new MIMEMAIL("HTML");
	$message = $_POST['emailMessage'];
	$from = $_POST['from'];
	$to = array();
	
	if(isset($_POST['marketing'])){
		$to[] = "marketing@htslabs.com";
	}
	if(isset($_POST['admin'])){
		$to[] = "assoc@htslabs.com";
	}
	if(isset($_POST['warehouse'])){
		$to[] = "maritza@htslabs.com";
	}
	if(isset($_POST['purchasing'])){
		$to[] = "purchase@hplc1.com";
	}
	
	$mail->senderName = "Fliers ALERT!";
	$mail->senderMail = $from;
	$mail->subject = "ALERT! | Fliers page needs your attention";
	$mail->body = $message;
	$mail->create();
	$recipients = $to;
	  if($mail->send($recipients)){
	  	redirect('list');
	}else{
	   echo $mail->error;
	}
>>>>>>> working
}
 ?>