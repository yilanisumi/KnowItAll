<?php 
  session_start();
  if(isset($_SESSION['id'])){
    $user = $_SESSION['id'];
  }
  include("database-connector.php");
  $uscid = "-99";
  if(isset($_GET['id'])){
    $uscid = $_GET['id'];
  }else{
    header("Location: login.php");
  }
  $sql = $conn->prepare("SELECT * FROM user WHERE user_id = ?;");
  $sql->bind_param('s', $uscid);
  $sql->execute();
  $ans = $sql->get_result();
  $urow = $ans->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta Tags -->
    <?php include("meta-tags.php");?>

    <title>Know It All</title>

    <!-- CSS link -->
    <?php include("all-css.php");?>
  </head>

  <body>
    <?php include("small-header.php") ?>
    <h1 class="custom-pad-hor"><u><?php echo $urow['user_name']; ?></u></h1>
    <h3 class="custom-pad-hor custom-pad-vert master-center">
      <span class="custom-margin-vert-small custom-margin-hor-tiny">Email: 
        <?php
          if(isset($_SESSION['id']) && strcmp($uscid, $user) == 0){
            echo $urow['usc_email']; 
          }else{
            echo "******@usc.edu";
          }
        ?>
       </span>
      <span class="custom-margin-vert-small custom-margin-hor-tiny">USCID: 
        <?php
          if(isset($_SESSION['id']) && strcmp($uscid, $user) == 0){
            echo $urow['usc_id']; 
          }else{
            echo "**********";
          }
        ?>
      </span><br>
      <?php 
        if(isset($_SESSION['id']) && strcmp($uscid, $user) == 0){
          echo "<button class=\"ui button custom-margin-vert-tiny custom-margin-hor-tiny\"><a href=\"change-password.php\">Change Password</a></button>
            <button class=\"ui button custom-margin-vert-tiny custom-margin-hor-tiny\"><a href=\"delete-user-confirm.php\">Delete Account</a></button>";
        }
      ?>
    </h3>

    <div class="ui grid">
      <div class="equal width row">
        <ul class="column">
          <li class="row header custom-pad-hor"><h4>Activity Log:</h4></li>
          <li class="row header custom-pad-hor custom-pad-vert-small">
            <span class="custom-pad-hor-space">Filter:</span>
            <?php
              $filter2 = "";
              if(!empty($_GET['filter2'])){
                $filter2 = $_GET['filter2'];
              }
            ?>
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter2=".$filter2?>">All</a>/
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter2=".$filter2?>&filter1=vote">Vote</a>/
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter2=".$filter2?>&filter1=rate">Rate</a>/
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter2=".$filter2?>&filter1=create">Create</a>/
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter2=".$filter2?>&filter1=comment">Comment</a>
          </li>
          <?php
            if(!empty($_GET['filter1'])){
              if(strcmp($_GET['filter1'], "vote") == 0){
                $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? AND action = 0 ORDER BY action_time DESC;");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans3 = $sql->get_result();
              }else if(strcmp($_GET['filter1'], "rate") == 0){
                $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? AND action = 1 ORDER BY action_time DESC;");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans3 = $sql->get_result();
              }else if(strcmp($_GET['filter1'], "create") == 0){
                $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? AND action = 2 ORDER BY action_time DESC;");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans3 = $sql->get_result();
              }else if(strcmp($_GET['filter1'], "comment") == 0){
                $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? AND action = 3 ORDER BY action_time DESC;");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans3 = $sql->get_result();
              }else{
                $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? ORDER BY action_time DESC;");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans3 = $sql->get_result();
              }
            }else{
              $sql = $conn->prepare("SELECT * FROM user_activity WHERE user_id = ? ORDER BY action_time DESC;");
              $sql->bind_param('s', $uscid);
              $sql->execute();
              $ans3 = $sql->get_result();
            }

            for($i = 0; $i < $ans3->num_rows; $i++){
              $arow = $ans3->fetch_assoc();
              include('activity-card.php');
            }
          ?>
        </ul>
        <ul class="column">
          <li class="row header custom-pad-hor"><h4>My Surveys:</h4></li>
          <li class="row header custom-pad-hor custom-pad-vert-small">
            <span class="custom-pad-hor-space">Filter:</span> 
            <?php
              $filter1 = "";
              if(!empty($_GET['filter1'])){
                $filter1 = $_GET['filter1'];
              }
            ?>
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter1=".$filter1?>">All</a>/
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter1=".$filter1?>&filter2=poll">Poll</a>/
            <a class="disinline custom-pad-hor-space" href="user.php?id=<?php echo $uscid; echo "&filter1=".$filter1?>&filter2=rating">Rating</a>
          <?php 
            if(!empty($_GET['filter2'])){
              if(strcmp($_GET['filter2'], "poll") == 0){
                $sql = $conn->prepare("SELECT * FROM survey WHERE user_id = ? AND survey_id LIKE \"P%\";");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans2 = $sql->get_result();
              }else if(strcmp($_GET['filter2'], "rating") == 0){
                $sql = $conn->prepare("SELECT * FROM survey WHERE user_id = ? AND survey_id LIKE \"R%\";");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans2 = $sql->get_result();
              }else{
                $sql = $conn->prepare("SELECT * FROM survey WHERE user_id = ?;");
                $sql->bind_param('s', $uscid);
                $sql->execute();
                $ans2 = $sql->get_result();
              }
            }else{
              $sql = $conn->prepare("SELECT * FROM survey WHERE user_id = ?;");
              $sql->bind_param('s', $uscid);
              $sql->execute();
              $ans2 = $sql->get_result();
            }

            for($i = 0; $i < $ans2->num_rows; $i++){
              $srow = $ans2->fetch_assoc();
              include('result-card.php');
            }
          ?>
        </ul>
      </div>
    </div>
    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>