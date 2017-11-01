<?php
	session_start();
	$dsurveyid = $_POST['deleteID'];
	include("database-connector.php");
	$sql = $conn->prepare("DELETE FROM survey WHERE survey_id = ?;");
	$sql->bind_param('s', $dsurveyid);
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id = ?;");
	$sql->bind_param('s', $dsurveyid);
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM user_survey WHERE survey_id = ?;");
	$sql->bind_param('s', $dsurveyid);
	$sql->execute();
	header("Location: home-search.php");
?>