<?php 
	session_start();
	include("database-connector.php");
	$param1 = "true";
	$param2 = "pressed";

	$sql = $conn->prepare("INSERT INTO search_temp VALUES (?, ?, \"test\", -99);");
	$sql->bind_param("ss", $param1, $param2);
	$sql->execute();
?>