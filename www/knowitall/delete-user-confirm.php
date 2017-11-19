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
    
    <h1 class="custom-pad-vert">Are You Sure You Want To Delete Your Account?</h1>

    <div class="master-center custom-pad-vert-big">
      <button class="ui massive button custom-margin-hor link-btn"><a href="delete-user.php">Delete</a></button>
      <button class="ui massive button custom-margin-hor link-btn"><a href="user.php">Cancel</a></button>
    </div>


    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>