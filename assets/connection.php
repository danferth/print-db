<?php 
$db_user = 'root';
$db_pass = '';
$db_server = 'localhost';
$db_name = 'test_db';
$dsn = "mysql:host=".$db_server.";dbname=".$db_name;
$db = new PDO($dsn,$db_user,$db_pass);
?>