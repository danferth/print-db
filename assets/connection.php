<?php 
$db_user = 'syringel_dan';
$db_pass = 'QMVLynWAmxP3';
$db_server = 'localhost';
$db_name = 'syringel_print';
$dsn = "mysql:host=".$db_server.";dbname=".$db_name;
$db = new PDO($dsn,$db_user,$db_pass);
?>