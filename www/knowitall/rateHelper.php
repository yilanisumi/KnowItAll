<?php 
  session_start();
  $selectionid = $_POST['rating'];
  $surveyid = $_GET['surveyid'];
  $userid = $_SESSION['id'];
  include("database-connector.php");
  $sql = $conn->prepare("UPDATE survey SET voter_number = voter_number + 1 WHERE survey_id = ?;");
  $sql->bind_param('s', $surveyid);
  $sql->execute();

  $sql = $conn->prepare("UPDATE survey_options SET voter_number = voter_number + 1 WHERE survey_id = ? AND option_id = ?;");
  $sql->bind_param('ss', $surveyid, $selectionid);
  $sql->execute();

  $sql = $conn->prepare("INSERT INTO user_survey (option_id, survey_id, user_id) VALUES (?, ?, ?);");
  $sql->bind_param('sss', $selectionid, $surveyid, $userid);
  $sql->execute();

  header("Location: survey.php?id=".$surveyid);
?>