<?php 
  session_start();
  date_default_timezone_set('America/Los_Angeles');
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

  $sql = $conn->prepare("SELECT * FROM user_survey WHERE user_id = ? AND survey_id = ?;");
  $sql->bind_param('ss', $userid, $surveyid);
  $sql->execute();
  $resans = $sql->get_result();
  $resrow = $resans->fetch_assoc();

  if (empty($resrow)) {
    $sql = $conn->prepare("UPDATE survey SET voter_number = voter_number + 1 WHERE survey_id = ?;");
    $sql->bind_param('s', $surveyid);
    $sql->execute();

    $sql = $conn->prepare("UPDATE survey_options SET voter_number = voter_number + 1 WHERE survey_id = ? AND option_id = ?;");
    $sql->bind_param('ss', $surveyid, $selectionid);
    $sql->execute();

    $sql = $conn->prepare("INSERT INTO user_survey (option_id, survey_id, user_id) VALUES (?, ?, ?);");
    $sql->bind_param('sss', $selectionid, $surveyid, $userid);
    $sql->execute();
  }

  else {
    $sql = $conn->prepare("SELECT * FROM user_survey WHERE survey_id = ? AND user_id = ?;");
    $sql->bind_param('ss', $surveyid, $userid);
    $sql->execute();
    $ans = $sql->get_result();
    $row = $ans->fetch_assoc();
    if ($selectionid != $row['option_id']) {
      $tmp = $row['option_id'];
      //echo $tmp."<br>";
      $sql = $conn->prepare("DELETE FROM user_survey WHERE survey_id = ? AND user_id = ?;");
      $sql->bind_param('ss', $surveyid, $userid);
      $sql->execute();

      $sql = $conn->prepare("INSERT INTO user_survey (option_id, survey_id, user_id) VALUES (?, ?, ?);");
      $sql->bind_param('iss', $selectionid, $surveyid, $userid);
      $sql->execute();
     
      $sql = $conn->prepare("UPDATE survey_options SET voter_number = voter_number - 1 WHERE survey_id = ? AND option_id = ?;");
      $sql->bind_param('si', $surveyid, $tmp);
      $sql->execute();

      $sql = $conn->prepare("UPDATE survey_options SET voter_number = voter_number + 1 WHERE survey_id = ? AND option_id = ?;");
      $sql->bind_param('si', $surveyid, $selectionid);
      $sql->execute();
  }

  $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? AND survey_id = ?;");
  $sql->bind_param('ss', $userid, $surveyid);
  $sql->execute();
  $resans = $sql->get_result();
  $resrow = $resans->fetch_assoc();

  if(empty($_POST["anon"])){
    if(empty($resrow)) {
      $rtime = date("Y-m-d H:i:s");
      $sql = $conn->prepare("INSERT INTO user_activity (option_id, survey_id, user_id, action_time, action) VALUES (?, ?, ?, ?, 0);");
      $sql->bind_param('ssss', $selectionid, $surveyid, $userid, $rtime);
      $sql->execute();
    }else{
      $rtime = date("Y-m-d H:i:s");
      $sql = $conn->prepare("UPDATE user_activity SET option_id = ?, action_time = ? WHERE survey_id = ?;");
      $sql->bind_param('iss', $selectionid, $rtime, $surveyid);
      $sql->execute();
    }
  }
}
  

  header("Location: survey.php?id=".$surveyid);
?>