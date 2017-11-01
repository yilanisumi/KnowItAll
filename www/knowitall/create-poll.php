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
    
    <h2>Create New Poll Survey</h3>

    <form class="ui form login-padding" action="createPollHelp.php" method="post">
      <div class="field">
        <label>Title</label>
        <input type="text" name="createTitle" required="true">
      </div>
      <!-- <div class="field">
        <label>Open Timespan</label>
        <div class="ui selection dropdown">
          <input type="hidden" name="createOpenTime">
          <i class="dropdown icon"></i>
          <div class="default text">Forever</div>
          <ul class="menu" tabindex="-1">
            <li class="item">Forever</li>
            <li class="item">1 day</li>
            <li class="item">2 days</li>
            <li class="item">1 week</li>
            <li class="item">2 weeks</li>
          </ul>
        </div>
      </div> -->
      <div class="field">
        <label>Options</label>
        <div class="custom-pad-vert-small">
          <input class="newoption" type="text" name="addOption">
          <button class="ui button add-opt" type="button">Add Option</button>
        </div>
      </div>
      <!-- <div class="field">
        <input class="ui checkbox disinline" type="checkbox" name="createShowResults">
        <label class="disinline">Show results before survey closes</label>
      </div> -->
      <div class="field">
        <label>Tags (Separate with Spaces)</label>
        <input type="text" name="tags">
        <label class="ui red label no-more">You cannot add more tags (Max 10)</label>
      </div>
      <div class="field master-center custom-margin-vert">
        <button class="ui big button" type="submit">Create Poll</button>
        <button class="ui big button link-btn"><a href="home-search.php">Cancel</a></button>
      </div>
    </form>

    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>