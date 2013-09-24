<?php 
//script variables***************************************************************
$server = "localhost";
$dbname = "test_db";
$user = "root";
$pass = "";

$firstUser = "dan";
$firstPass = "password";

//connect to MySQL & Database*******************************************************
echo "<p>connecting to database...</p>";

try{
	$dsn = "mysql:host=".$server.";dbname=".$dbname;
	$db = new PDO($dsn, $user, $pass);
	if($db){
		echo "<p><strong>connection established...</strong></p>";
	}
}catch(PDOEXception $e){
	echo "connection failed:" . $e->getMessage();
	exit;
}


//create table FLIERS****************************************************************
echo "<p>creating table <em>fliers</em>...</p>";

$q = "CREATE TABLE IF NOT EXISTS fliers(
	`ID` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(ID),
	`part_num` VARCHAR(20),
	`in_house` VARCHAR(20),
	`use_old` BOOLEAN,
	`desc` VARCHAR(200),
	`revision` BOOLEAN,
	`order` BOOLEAN,
	`ordered` BOOLEAN,
	`alert` BOOLEAN,
	`message` VARCHAR(300)
	)";

$result = $db->query($q);
if(!$result) {
    die(print_r($db->errorInfo(), TRUE));
}


echo "<p>testing to see if <strong>fliers</strong> table exists...</p>";

$q = "SHOW TABLES LIKE 'fliers'";
$result = $db->query($q);
if(!$result) {
    die(print_r($db->errorInfo(), TRUE));
}
if($result->rowCount()>0)
	{
		echo "<p><strong><em>fliers</em> table exists...</strong></p>";
		$result->closeCursor();
	}


//create USERS table***************************************************
echo "creating users table...</p>";

$q = "CREATE TABLE IF NOT EXISTS users(
	`ID` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(ID),
	`user` VARCHAR(20),
	`pass` VARCHAR(20)
	)";
$result = $db->query($q);
if(!$result) {
    die(print_r($db->errorInfo(), TRUE));
}

echo "<p>testing to see if <strong>users</strong> table exists...</p>";
$q = "SHOW TABLES LIKE 'users'";
$result = $db->query($q);
if(!$result) {
    die(print_r($db->errorInfo(), TRUE));
}
if($result->rowCount()>0)
	{
		echo "<p><strong>table exists...</strong></p>";
		$result->closeCursor();
	}

//enter first user*****************************************************************


$q = ("SELECT * FROM users WHERE ID=1 LIMIT 1");
$query = $db->query($q);
$result = $query->fetch(PDO::FETCH_ASSOC);
if($result) {
    echo "<p>Users table contains users no need to input first user</p>";
}else{

	echo "<p>entering first user...</p>";
	
	
	
	$q = $db->prepare("INSERT INTO users (`ID`, `user`, `pass`) VALUES (NULL,:user, :pass)");
	$q->bindParam(":user", $firstUser);
	$q->bindParam(":pass", $firstPass);
	$q->execute();
	
	if(!$q){
		die(print_r($db->errorInfo(), TRUE));
	}
	if($q){
		echo "<p><strong>first user entered...</strong></p>";
		$q->closeCursor();
	}

}
//output user and close connection********************************************************
$q = "SELECT * FROM users";
$result = $db->query($q);
while($arr = $result->fetch(PDO::FETCH_ASSOC)){
	echo $arr['ID']." | <strong>username</strong> = " . $arr['user'] . " | <strong>password</strong> = " . $arr['pass'] . "<br>";
}

$result->closeCursor();
$db = null;
if(is_null($db)){
	echo "<p>connection closed...</p>";
}

    	echo "<a href='../../index.php'>go to login</a>";

 ?>