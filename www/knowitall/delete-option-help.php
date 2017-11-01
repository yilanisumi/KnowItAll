<?php 
	session_start();
	$id = $_GET["id"];
	$optid = $_GET["deleteID"];
	include("database-connector.php");
	$sql = $conn->prepare("DELETE FROM survey_options WHERE survey_id = ? AND option_id = ?");
	$sql->bind_param('si', $id, $optid);
	$sql->execute();

	$sql = $conn->prepare("DELETE FROM user_survey WHERE survey_id = ? AND option_id = ?");
	$sql->bind_param('si', $id, $optid);
	$sql->execute();

	$sql = $conn->prepare("UPDATE survey_options SET option_id = option_id-1 WHERE survey_id = ? and option_id > ?");
	$sql->bind_param('si', $id, $optid);
	$sql->execute();

	header("Location: survey.php?id=".$id);
?>