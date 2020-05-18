<?php
	$servername = "pedago.univ-avignon.fr";
	$username = "uapv1903416";
	$password = "vr24nzm9";
	
	try{
		$pdo = new PDO("pgsql:host=$servername; dbname=test", $username, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // mode d'erreur de PDO en "exception"
// 		echo "Connected successfully"."<br>";
	}
	
	catch(PDOEcxception $e){
		echo "Connection failed: ".$e->getMessage()."<br>";
	}	
?>
