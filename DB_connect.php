<?php
	$servername = "192.168.1.46";
	$username = "nathanael";
	$password = "Zachaarone2010";
	
	try{
		$pdo = new PDO("pgsql:host=$servername; port=5433; dbname=test", $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // mode d'erreur de PDO en "exception"
// 		echo "Connected successfully"."<br>";
	}
	
	catch(PDOEcxception $e){
		echo "Connection failed: ".$e->getMessage()."<br>";
	}	
?>