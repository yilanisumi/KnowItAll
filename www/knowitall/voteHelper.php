<?php 
  session_start();
  $numopts = $_POST['numopts'];
  $surveyid = $_GET['surveyid'];
  $userid = $_SESSION['id'];
  $selectionid = 0;
  for($i = 1; $i <= $numopts; $i++){
    if(!empty($_POST[$i])){
      $selectionid = $i;
    }
  }
  include("database-connector.php");
  // $sql = $conn->prepare("SELECT option_string FROM survey_options WHERE survey_id = ? AND option_id = ?;");
  // $sql->bind_param('ss', $surveyid, $selectionid);
  // $sql->execute();
  // $ans = $sql->get_result();
  // $row = $ans->fetch_assoc();

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