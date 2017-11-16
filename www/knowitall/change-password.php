<?php 
  session_start();
  if(!isset($_SESSION['id'])){
    header("Location: login.php");
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
    <?php include('big-header.php');?>
    <div class="ui error message master-center custom-margin-hor custom-margin-bot-small <?php if(empty($failed)){echo "hidden";} ?>">
      <p>The Information You Entered Was Invalid</p>
    </div>
    <form class="ui form login-padding" action="changePasswordHelp.php" method="post">
      <div class="field">
        <label>Old Password</label>
        <input type="password" name="oldPassword" placeholder="Old Password" required="true">
      </div>
      <div class="field">
        <label>New Password</label>
        <input type="password" name="newPassword" placeholder="New Password" required="true">
      </div>
      <div class="field">
        <label>Confirm New Password</label>
        <input type="password" name="confirmPassword" placeholder="Confirm New Password" required="true">
      </div>
      <button class="ui button" type="submit">Change Password</button>
      <a class="signup-link" href="user.php">Cancel</a>
    </form>
    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>