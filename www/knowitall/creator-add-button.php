<form class="ui form fluid" action="creator-add.php" method="post">
  <input class="newoption" type="text" name="addOption" required="true">
  <button class="ui button" type="submit">Add Option</button><br>
  <input type="hidden" name="surveyid" value="<?php echo $id; ?>">
</form>