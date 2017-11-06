<?php
  session_start();
  session_unset();
  if(!isset($_SESSION['id']) && !isset($_SESSION['gid'])){
    include("database-connector.php");
    $sql = $conn->prepare("SELECT user_id FROM search_temp WHERE user_id LIKE \"-%\" ORDER BY user_id DESC LIMIT 1;");
    $sql->execute();
    $ans = $sql->get_result();
    $gid = $ans->fetch_assoc();
    $gid = intval($gid['user_id']);
    //echo $gid;
    //echo "<br>";
    $gid -= 1;
    $_SESSION['gid'] = $gid;
    //echo $gid;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta Tags -->
    <?php include("meta-tags.php");?>

    <title>Kneriter</title>

    <!-- CSS link -->
    <?php include("all-css.php");?>
  </head>
  <body>
    <?php include('big-header.php');?>
    <form class="ui form search-bar custom-pad-hor master-center custom-pad-vert" action="search-results.php" method="get" id="search">
      <input class="custom-margin-bot-small" type="text" placeholder="Search..." name="search" required="true">
      <button class="ui button" type="submit" form="search" value="Submit">Search</button>
    </form>
    <?php
      if(!empty($_GET['fail'])) 
        $failed = $_GET['fail'];
    ?>
    <div class="ui error message master-center custom-margin-hor custom-margin-bot-small <?php if(empty($failed)){echo "hidden";} ?>">
      <p>Incorrect USCID/Email or Password</p>
    </div>
    <form class="ui form login-padding" action="login-check.php" method="post">
      <div class="field">
          <label>USC Email/ID</label>
          <input type="text" name="loginID" placeholder="USC Email/ID" required="true">
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" name="loginPassword" placeholder="Password" required="true">
      </div>
      <button class="ui button">Login</button>
      <a class="signup-link" href="signup.php">Sign up</a>
    </form>

    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>

<!-- <?php
  $sql = "SELECT * FROM testtable WHERE name =" + $name;
  $ans = $conn->query($sql);
  echo $ans->fetch_assoc()["col1"];
?> -->