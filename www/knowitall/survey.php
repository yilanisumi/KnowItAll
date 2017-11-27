<?php 
  session_start();
  $id = $_GET['id'];
  if(isset($_SESSION['id'])){
    $uscid = $_SESSION['id'];
    $username = $_SESSION['username'];
  }
  include("database-connector.php");
  $sql = $conn->prepare("SELECT * FROM survey WHERE survey_id = ?;");
  $sql->bind_param('s', $id);
  $sql->execute();
  $ans = $sql->get_result();
  if($ans->num_rows < 1){
    header("Location: home-search.php");
  }
  $row = $ans->fetch_assoc();
  $creator = $row["user_id"];

  $sql = $conn->prepare("SELECT user_name FROM user WHERE user_id = ?;");
  $sql->bind_param('s', $creator);
  $sql->execute();
  $ans2 = $sql->get_result();
  $row2 = $ans2->fetch_assoc();
  $creator = $row2['user_name'];

  $sql = $conn->prepare("SELECT * FROM survey_options WHERE survey_id = ?;");
  $sql->bind_param('s', $id);
  $sql->execute();
  $ans3 = $sql->get_result();
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
    <article class="ui fluid grid">
      <div class="row search-result">
        <div class="ui fluid grid custom-margin-hor-small custom-margin-vert-small surveycard">
          <div class="twelve wide column"><?php echo $row['survey_title']; ?> (<?php echo $id; ?>)</div>
          <div class="four wide column"><span class="float-right">Responses: <?php echo $row['voter_number'] ?></span></div>
          <div class="eight wide column">Created: <?php echo $row['create_time'] ?></div>
          <div class="eight wide column"><a href="user.php?id=<?php echo $row["user_id"] ?>"><span class="float-right">Creator: <?php echo $creator ?></span></a></div>
          <div class="eight wide column"><span>Tags: <?php echo $row['survey_tags'] ?></span></div>
          <div class="eight wide column"><span class="float-right">Open Until: <?php echo $row['close_time'] ?></span></div>
        </div>
      </div>

      <?php
        if(strcmp(substr($id, 0, 1), "R") == 0){
          include("show-rating-results.php");
        }else if(strcmp(substr($id, 0, 1), "P") == 0){
          include("show-poll-results.php");
        }else{
          header("Location: home-search.php");
        }
      ?>

      <!-- results chart TODO-->
      <div class="fluid row custom-margin-hor">
        
        <?php
          if(isset($_SESSION['id'])){
            if(strcmp(substr($id, 0, 1), "R") == 0){
              include("rating-temp.php");
            }else if(strcmp(substr($id, 0, 1), "P") == 0){
              include("poll-temp.php");
            }else{
              header("Location: home-search.php");
            }
          }else{
            include("login-message.php");
          }
          $sql = $conn->prepare("SELECT * FROM survey_comments WHERE survey_id = ? ORDER BY comment_time ASC;");
          $sql->bind_param('s', $id);
          $sql->execute();
          $result = $sql->get_result();
          $j = $result->num_rows;
        ?>

        <?php 
          if(isset($_SESSION['id'])){
            if($uscid == $row['user_id']){
              include("delete-poll-button.php");
            }
          }
        ?>

        <div class="ui fluid grid comment-section">
          <span class="header row">Comments (<?php echo $j ?>)</span>

          <?php 
            if(isset($_SESSION['id'])){
              include("comment-form.php");
            }
          ?>
          <?php             
            for($i = 0; $i < $j; $i++){
              $crow = $result->fetch_assoc();
              $sql = $conn->prepare("SELECT user_name FROM user WHERE user_id = ?");
              $sql->bind_param('s', $crow['user_id']);
              $sql->execute();
              $uresult = $sql->get_result();
              $urow = $uresult->fetch_assoc();
              $uname = "Anonymous";
              if(strcmp($crow['user_id'], "-1") == 0){
                $uname = "Anonymous";
              }else{
                $uname = $urow['user_name'];
              }
              include("comment-temp.php");
            }
          ?>
        </div>
      </div>
    </article>


    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>