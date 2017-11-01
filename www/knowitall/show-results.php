<?php
  if(isset($_SESSION['id'])){
    $uscid = $_SESSION['id'];
  }else{
    $uscid = "-1";
  }
  include("database-connector.php");
  $search = $_GET['search'];
  $sql = $conn->prepare("DELETE FROM search_temp WHERE user_id = ?;");
  $sql->bind_param('s', $uscid);
  $sql->execute();
  if(strlen($search) > 0){
    $token = strtok($search, " ");
    while($token !== false){
      $param = "%".$token."%";
      $sql = $conn->prepare("SELECT * FROM survey WHERE survey_tags LIKE ?;");
      $sql->bind_param('s', $param);
      $sql->execute();
      $ans = $sql->get_result();
      $j = $ans->num_rows;
      for($i = 0; $i < $j; $i++){
        $row = $ans->fetch_assoc();
        $sql = $conn->prepare("SELECT * FROM search_temp WHERE survey_id = ?");
        $sql->bind_param('s', $row['survey_id']);
        $sql->execute();
        $ans2 = $sql->get_result();
        if($ans2->num_rows == 0){
          $sql = $conn->prepare("INSERT INTO search_temp (user_id, survey_id, create_time, voter_number) VALUES (?,?,?,?);");
          $sql->bind_param('sssi', $uscid, $row['survey_id'], $row['create_time'], $row['voter_number']);
          $sql->execute();
        }
      }
      $token = strtok(" ");
    }

    $sortm = "";
    if(!empty($_GET['sort'])){
      $sortm = $_GET['sort'];
      if(strcmp($sortm, "relevance") == 0){
      $sql = $conn->prepare("SELECT survey_id FROM search_temp WHERE user_id = ? ORDER BY voter_number DESC;");
      }else{
        $sql = $conn->prepare("SELECT survey_id FROM search_temp WHERE user_id = ? ORDER BY create_time DESC;");
      }
    }else {
      $sql = $conn->prepare("SELECT survey_id FROM search_temp WHERE user_id = ? ORDER BY create_time DESC;");
    }

    $sql->bind_param('s', $uscid);
    $sql->execute();
    $alls = $sql->get_result();
    $j = $alls->num_rows;
    if($j == 0){
      echo "<span class=\"custom-pad-vert custom-pad-hor\">No Results Found</span>";
    }else{
      for($i = 0; $i < $j; $i++){
        $allsrow = $alls->fetch_assoc();
        $sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
        $sql->bind_param('s', $allsrow['survey_id']);
        $sql->execute();
        $sans = $sql->get_result();
        $srow = $sans->fetch_assoc();

        $sql = $conn->prepare("SELECT user_name FROM user WHERE user_id = ?;");
        $sql->bind_param('s', $srow['user_id']);
        $sql->execute();
        $uresult = $sql->get_result();
        $urow = $uresult->fetch_assoc();
        include("result-card.php");
      }
    }
  }
?>