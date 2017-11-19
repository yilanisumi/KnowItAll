<?php 
	session_start();
  	if(!isset($_SESSION['id'])){
    	header("Location: home-search.php");
  	}

  	$usc_id = $_SESSION['id'];

  	include("database-connector.php");
  	$sql = $conn->prepare("DELETE FROM user WHERE usc_id = ?;");
  	$sql->bind_param('s', $usc_id);
    $sql->execute();

    header("Location: login.php");
?>