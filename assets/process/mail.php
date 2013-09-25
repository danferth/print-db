<?php 
session_start();
require_once "../functions.php";
sessionTimeout();
require_once("mimemail.php");
$mail = new MIMEMAIL("HTML");


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
}
 ?>