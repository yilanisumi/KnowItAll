<?php 
	session_start();
	$newopt = $_POST['addOption'];
	$surveyid = $_POST['surveyid'];
	include("database-connector.php");
	$sql = $conn->prepare("SELECT option_id FROM survey_options WHERE survey_id = ? ORDER BY option_id DESC LIMIT 1;");
	$sql->bind_param('s', $surveyid);
	$sql->execute();
	$currans = $sql->get_result();
	$curr = $currans->fetch_assoc();
	$currnum = $curr['option_id']+1;

	$sql = $conn->prepare("INSERT INTO survey_options (survey_id, option_id, option_string, voter_number) VALUES (?, ?, ?, 0);");
	$sql->bind_param('sis', $surveyid, $currnum, $newopt);
	$sql->execute();
	
	header("Location: survey.php?id=".$surveyid);
?>