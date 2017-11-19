<div class="ui sticky horizontal menu"> <!-- STICKY TODO -->
  <div class="ui item">
    <a href="home-search.php">Know It All</a>
  </div>
  <div class="right floated item">
  	<?php
  		if(isset($_SESSION['id'])){
  			echo"<button class=\"ui button link-btn custom-margin-hor-tiny\"><a href=\"user.php?id=".$_SESSION['id']."\">Profile</a></button>";
  		}
  	?>
    <button class="ui button link-btn"><a href="login.php"><?php include("login-out.php"); ?></a></button>
  </div>
</div>