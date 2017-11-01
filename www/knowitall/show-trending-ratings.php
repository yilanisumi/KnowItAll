<?php 
  include("database-connector.php");
  $sql = $conn->prepare("SELECT * FROM trending_survey WHERE survey_id LIKE \"R%\" ORDER BY survey_id DESC;");
  $sql->execute();
  $result = $sql->get_result();
  $j = $result->num_rows;
  for($i = 0; $i < $j; $i++){
    $trow = $result->fetch_assoc();
    $sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
    $sql->bind_param('s', $trow['survey_id']);
    $sql->execute();
    $sresult = $sql->get_result();
    $srow = $sresult->fetch_assoc();

    $sql = $conn->prepare("SELECT user_name FROM user WHERE user_id = ?;");
    $sql->bind_param('s', $srow['user_id']);
    $sql->execute();
    $uresult = $sql->get_result();
    $urow = $uresult->fetch_assoc();
    include("trending-card.php");
  }
?>