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
    <?php
      if(!empty($_GET['fail'])) 
        $failed = $_GET['fail'];
    ?>
    <div class="ui error message master-center custom-margin-hor custom-margin-bot-small <?php if(empty($failed)){echo "hidden";} ?>">
      <p>The Information You Entered Was Invalid</p>
    </div>
    <form class="ui form login-padding" action="signup-check.php" method="post">
      <div class="field">
        <label>Full Name</label>
        <input type="text" name="signupName" placeholder="FirstName LastName" required="true">
      </div>
      <div class="field">
        <label>USC Email</label>
        <input type="email" name="signupEmail" placeholder="USC Email" required="true">
        <label class="ui red label valid-email">Please enter a valid USC email</label>
      </div>
      <div class="field">
        <label>USC ID</label>
        <input type="text" name="signupID" placeholder="USC ID" required="true">
        <label class="ui red label valid-id">Please enter a valid USC ID</label>
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" name="signupPassword" placeholder="Password" required="true">
      </div>
      <button class="ui button disabled" type="submit" id="signup-button">Sign up</button>
      <a class="signup-link" href="login.php">Login with an existing account</a>
    </form>

    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>