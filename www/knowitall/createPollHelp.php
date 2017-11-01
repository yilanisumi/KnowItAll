<?php 
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: home-search.php");
  }
  $stitle = $_POST["createTitle"];
  $stags = $_POST["tags"];
  $userid = $_SESSION["id"];
  date_default_timezone_set('America/Los_Angeles');
  $stime = date("Y-m-d", time());
  $opts = $_POST["options"];

  include("database-connector.php");
  $sql = $conn->prepare("SELECT survey_id FROM survey WHERE survey_id LIKE \"P%\" ORDER BY survey_id DESC LIMIT 1;");
  $sql->execute();
  $ans = $sql->get_result();
  $maxid = $ans->fetch_assoc();
  $oldid = substr($maxid["survey_id"], 1);
  $oldid = intval($oldid);
  $oldid += 1;
  $surveyid = "".$oldid;
  while(strlen($surveyid) < 10){
    $surveyid = "0".$surveyid;
  }
  $surveyid = "P".$surveyid;

  //echo sizeof($opts);
  $sql = $conn->prepare("INSERT INTO survey (create_time, rating_average, survey_id, survey_tags, survey_title, user_id, voter_number) VALUES (?, 0.0, ?, ?, ?, ?, 0);");
  $sql->bind_param('sssss', $stime, $surveyid, $stags, $stitle, $userid);
  $sql->execute();
  
  $i = 0;
  for($i = 0; $i < sizeof($opts); $i++){
    $sql = $conn->prepare("INSERT INTO survey_options (survey_id, option_id, option_string, voter_number) VALUES (\"" .$surveyid."\", ?, ?, 0);");
    $y = $i+1;
    $z = $opts[$i];
    $sql->bind_param('is', $y, $z);
    $sql->execute();
  }

  $sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"P%\";");
  $sql->execute();
  $ans = $sql->get_result();
  $numrows = $ans->num_rows;
  if($numrows >= 3){
    $sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id LIKE \"P%\" ORDER BY survey_id ASC LIMIT 1;");
    $sql->execute();
  }
  $sql = $conn->prepare("INSERT INTO trending_survey (survey_id) VALUES (?);");
  $sql->bind_param('s', $surveyid);
  $sql->execute();

  header("Location: survey.php?id=".$surveyid);

  //echo $surveyid;
?>