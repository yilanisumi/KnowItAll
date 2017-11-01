<?php 
  session_start();
  date_default_timezone_set('America/Los_Angeles');
  $ctime = date("Y-m-d H:i:s");
  $content = $_POST["newComment"];
  $surveyid = $_GET["id"];
  $anon = $_POST["anon"];

  if(!empty($anon)){
    $userid = -1;
  }else{
    $userid = $_SESSION["id"];
  }

  include("database-connector.php");
  $sql = $conn->prepare("INSERT INTO survey_comments (survey_id, comment_string, user_id, comment_time) VALUES (?, ?, ?, ?);");
  $sql->bind_param('ssss', $surveyid, $content, $userid, $ctime);
  $sql->execute();

  header("Location: survey.php?id=".$surveyid);
?>