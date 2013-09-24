<?php  
echo "<p>connecting to MySQL database...</p>";

$server = "localhost";
$dbname = "test_db";
$dsn = "mysql:host=".$server.";dbname=".$dbname;
$user = "root";
$pass = "";

$db = new PDO($dsn, $user, $pass);

if($db){
	echo "<p><strong>connection established...</strong></p>";
}else{
	echo "<p>connection FAILED...</p>";
}

echo "creating users table...</p>";

$q = "CREATE TABLE IF NOT EXISTS users(`ID` INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), `user` VARCHAR(20), `pass` VARCHAR(20) )";

$result = $db->query($q);
if(!$result) {
    die(print_r($db->errorInfo(), TRUE));
}

if($result)
	{
		echo "<p><strong>table created...</strong></p>";
		$result->closeCursor();
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

?>