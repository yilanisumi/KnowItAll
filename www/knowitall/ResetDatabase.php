<?php 
	include("database-connector.php");
	$sql = $conn->prepare("DELETE FROM search_temp;");
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM survey_comments;");
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM user_survey;");
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM survey WHERE survey_id != \"P0000000001\" AND survey_id != \"P0000000002\" AND survey_id != \"R0000000001\" AND survey_id != \"R0000000002\";");
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id != \"P0000000001\" AND survey_id != \"P0000000002\" AND survey_id != \"R0000000001\" AND survey_id != \"R0000000002\";");
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM survey_options WHERE survey_id != \"P0000000001\" AND survey_id != \"P0000000002\" AND survey_id != \"R0000000001\" AND survey_id != \"R0000000002\";");
	$sql->execute();
	$sql = $conn->prepare("DELETE FROM user WHERE user_id != \"9999999999\" AND user_id != \"2222222222\";");
	$sql->execute();
	$sql = $conn->prepare("UPDATE survey SET voter_number = 0 WHERE voter_number != 0;");
	$sql->execute();
	$sql = $conn->prepare("UPDATE survey_options SET voter_number = 0 WHERE voter_number != 0;");
	$sql->execute();

	echo "Database Resetted";
?>

