<?php
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: home-search.php");
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
    <?php include("small-header.php") ?>
    
    <h1 class="custom-pad-vert">Create New Survey</h1>

    <div class="master-center custom-pad-vert-big">
      <button class="ui massive button custom-margin-hor link-btn"><a href="create-poll.php">Poll</a></button>
      <button class="ui massive button custom-margin-hor link-btn"><a href="create-rating.php">Rating</a></button>
    </div>


    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>