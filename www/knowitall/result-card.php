<li class="surveylink custom-pad-hor custom-pad-top">
	<a href="survey.php?id=<?php echo $srow['survey_id']; ?>">
	  <div class="ui grid">
	    <div class="twelve wide column"><?php echo $srow['survey_title']; ?>(<?php echo $srow['survey_id']; ?>)</div>
	    <div class="four wide column"><span class="float-right">Responses: <?php echo $srow['voter_number'] ?></span></div>
	    <div class="four wide column">Created: <?php echo $srow['create_time'] ?></div>
	    <div class="four wide column">Open Until: <?php echo $srow['close_time'] ?></div>
	    <div class="eight wide column"><span class="float-right">Creator: <?php echo $urow['user_name'] ?></span></div>
	  </div>
	</a>
</li>