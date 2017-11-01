<?php 
	$server = "localhost";
	$username = "root";
	$password = "";
	$db = "knowitall_test";

	$conn = new mysqli($server, $username, $password, $db);
	if($conn->connect_error){
		die("Connection Failed " . $conn->connect_error);
	}
?>