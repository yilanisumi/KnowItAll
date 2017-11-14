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
    <form class="ui form login-padding" action="" method="post">
      <div class="field">
        <label>Old Password</label>
        <input type="email" name="signupEmail" placeholder="Old Password" required="true">
      </div>
      <div class="field">
        <label>New Password</label>
        <input type="text" name="signupID" placeholder="New Password" required="true">
      </div>
      <div class="field">
        <label>Confirm New Password</label>
        <input type="password" name="signupPassword" placeholder="Confirm New Password" required="true">
      </div>
      <button class="ui button" type="submit">Change Password</button>
      <a class="signup-link" href="user.php">Cancel</a>
    </form>
    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>