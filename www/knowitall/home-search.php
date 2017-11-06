<?php 
  session_start();
  if(!isset($_SESSION['id']) && !isset($_SESSION['gid'])){
    include("database-connector.php");
    $sql = $conn->prepare("SELECT user_id FROM search_temp WHERE user_id LIKE \"-%\" ORDER BY user_id DESC LIMIT 1;");
    $sql->execute();
    $ans = $sql->get_result();
    $gid = $ans->fetch_assoc();
    $gid = intval($gid['user_id']);
    // echo $gid;
    // echo "<br>";
    $gid -= 1;
    $_SESSION['gid'] = $gid;
    // echo $gid;
  }
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
    <button class="ui button float-right link-btn"><a class="float-right" href="login.php"><?php include("login-out.php"); ?></a></button>
    <?php include('big-header.php');?>

    <form class="ui form search-bar custom-pad-hor master-center custom-pad-vert" action="search-results.php" method="get" id="search">
      <input class="custom-margin-bot-small" type="text" placeholder="Search..." name="search" required="true">
      <button class="ui button" type="submit" form="search" value="Submit">Search</button>
      <button class="ui button link-btn"><a href="create.php">Create New Survey</a></button>
    </form>

    <div class="ui grid">
      <div class="two column row">
        <div class="column">
          <span class="custom-pad-hor">Trending Polls</span>
          <ul>
            <?php include("show-trending-polls.php"); ?>
          </ul>
        </div>
        <div class="column">
          <span class="custom-pad-hor">Trending Ratings</span>
          <ul>
            <?php include("show-trending-ratings.php"); ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>