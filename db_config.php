<?php
$server = "localhost";  
$db_user = "root";
$db_pass = "";  
$database = "hizliokumapp"; 

try {
	$bgl = new PDO("mysql:host=$server;dbname=$database;charset=utf8", "$db_user", "$db_pass", [
		PDO::ATTR_EMULATE_PREPARES => false, 
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	]);
} catch ( PDOException $e ){
	print $e->getMessage();
}
?>