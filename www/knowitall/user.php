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
    <h1 class="custom-pad-hor">User Name</h1>
    <h3 class="custom-pad-hor custom-pad-vert master-center">
      <span class="custom-margin-vert-small custom-margin-hor-tiny">Email: *****@usc.edu</span>
      <span class="custom-margin-vert-small custom-margin-hor-tiny">USCID: **********</span><br>
      <button class="ui button custom-margin-vert-tiny custom-margin-hor-tiny"><a href="change-password.php">Change Password</a></button>
      <button class="ui button custom-margin-vert-tiny custom-margin-hor-tiny"><a href="delete-user-confirm.php">Delete Account</a></button>
    </h3>

    <div class="ui grid">
      <div class="equal width row">
        <ul class="column">
          <li class="row header custom-pad-hor"><h4>Activity Log:</h4></li>
          <li class="row surveylink custom-pad-hor custom-pad-top">
            <a href="">
              <div class="ui grid">
                <div class="row custom-pad-hor-small">Voted * on Poll (P9999999999)</div>
              </div>
            </a>
          </li>
        </ul>
        <ul class="column">
          <li class="row header custom-pad-hor"><h4>My Surveys:</h4></li>
          <?php include("result-card.php") ?>
        </ul>
      </div>
    </div>
    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>