<?php 
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: home-search.php");
  }
  $stitle = $_POST["createTitle"];
  $stags = $_POST["tags"];
  $userid = $_SESSION["id"];
  date_default_timezone_set('America/Los_Angeles');
  $stime = date("Y-m-d H:i:s");

  // process frequent tags 
  include("database-connector.php");
  
  $tagResults = $_POST['tags']; 
  $tagResults = ltrim($tagResults); // remove whitespace from beginning of tagResults string
  $tagResults = rtrim($tagResults); // remove whitespace from end of tagResults string
  $tagTerms = preg_split('/\s+/', $tagResults);
  $numTags = sizeof($tagTerms);
  for($i = 0; $i < $numTags; $i++)
  {
    // check if the tag is in the frequent_tag table
    $sql = $conn->prepare("SELECT * FROM frequent_tag WHERE tag = ?;");
    $sql->bind_param('s', $tagTerms[$i]);
    $sql->execute();
    $ans = $sql->get_result();
    $numSearch = $ans->num_rows;

    // tag exists in frequent_tag table, increment its freq value
    if($numSearch > 0) {
      $sql = $conn->prepare("UPDATE frequent_tag SET freq = freq + 1 WHERE tag = ?;");
      $sql->bind_param('s', $tagTerms[$i]);
      $sql->execute();  
    }
    // tag does not exist in frequent_tag table, insert it
    else {
      $sql = $conn->prepare("INSERT INTO frequent_tag (tag, freq) VALUES (\"" .$tagTerms[$i]."\", 1);");
      $sql->execute();
    }
  }
  
  $sql = $conn->prepare("SELECT survey_id FROM survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC LIMIT 1;");
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
  $surveyid = "R".$surveyid;

  $ctime = $_POST['createOpenTime'];
  echo $ctime;
  $currentTime = date("Y-m-d H:i:s");  
  if(strcmp($ctime, "2 seconds") == 0){
    $ctime = date("Y-m-d H:i:s", strtotime($currentTime.' + 2 seconds'));
  }else if(strcmp($ctime, "1 day") == 0){
    $ctime = date("Y-m-d H:i:s", strtotime($currentTime.' + 1 days'));
  }else if(strcmp($ctime, "2 days") == 0){
    $ctime = date("Y-m-d H:i:s", strtotime($currentTime.' + 2 days'));
  }else if(strcmp($ctime, "1 week") == 0){
    $ctime = date("Y-m-d H:i:s", strtotime($currentTime.' + 7 days'));
  }else if(strcmp($ctime, "2 weeks") == 0){
    $ctime = date("Y-m-d H:i:s", strtotime($currentTime.' + 14 days'));
  }else{
    $ctime = "9999-99-99 99:99:99";    
  }

  $sql = $conn->prepare("INSERT INTO survey (create_time, rating_average, survey_id, survey_tags, survey_title, user_id, voter_number, close_time) VALUES (?, 0.0, ?, ?, ?, ?, 0, ?);");
  $sql->bind_param('ssssss', $stime, $surveyid, $stags, $stitle, $userid, $ctime);
  $sql->execute();
  
  $i = 0;
  for($i = 0; $i < 10; $i++){
    $sql = $conn->prepare("INSERT INTO survey_options (survey_id, option_id, option_string, voter_number) VALUES (\"" .$surveyid."\", ?, \"\", 0);");
    $y = $i+1;
    $sql->bind_param('i', $y);
    $sql->execute();
  }

  $sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"R%\";");
  $sql->execute();
  $ans = $sql->get_result();
  $numrows = $ans->num_rows;
  if($numrows >= 3){
    $sql = $conn->prepare("DELETE FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id ASC LIMIT 1;");
    $sql->execute();
  }
  $sql = $conn->prepare("INSERT INTO trending_survey (survey_id) VALUES (?);");
  $sql->bind_param('s', $surveyid);
  $sql->execute();

  $rtime = date("Y-m-d H:i:s");
  $sql = $conn->prepare("INSERT INTO user_activity (option_id, survey_id, user_id, action_time, action) VALUES (-99, ?, ?, ?, 2);");
  $sql->bind_param('sss', $surveyid, $userid, $rtime);
  $sql->execute();


  header("Location: survey.php?id=".$surveyid);

  //echo $surveyid;
?>