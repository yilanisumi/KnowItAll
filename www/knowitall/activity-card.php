<li class="row surveylink custom-pad-hor custom-pad-top">
	<a href="survey.php?id=<?php echo $arow['survey_id']; ?>">
	  <div class="ui grid">
	  	<div class="row custom-pad-hor-small remove-pad-bot">
				<?php echo $arow['action_time']; ?>
	  	</div>
	    <div class="row custom-pad-hor-small">
	    	<?php	
	    		$action = $arow['action'];
	    		if($action == 0){
	    			$sql = $conn->prepare("SELECT option_string FROM survey_options WHERE survey_id = ? AND option_id = ?;");
		    		$sql->bind_param('ss', $arow['survey_id'], $arow['option_id']);
		    		$sql->execute();
		    		$opstring = $sql->get_result();
		    		$opstring = $opstring->fetch_assoc();
	    			echo "<b class=\"custom-pad-hor-space\">Voted '".$opstring['option_string']."' on </b>";
	    		}
	    		if($action == 1){
	    			echo "<b class=\"custom-pad-hor-space\">Rated '".$arow['option_id']."' on </b>";
	    		}
	    		if($action == 2){
	    			echo "<b class=\"custom-pad-hor-space\">Created </b>";
	    		}
	    		if($action == 3){
	    			echo "<b class=\"custom-pad-hor-space\">Commented on </b>";
	    		}

	    		$sql = $conn->prepare("SELECT survey_title FROM survey WHERE survey_id = ?;");
	    		$sql->bind_param('s', $arow['survey_id']);
	    		$sql->execute();
	    		$survey = $sql->get_result();
	    		$survey = $survey->fetch_assoc();
	    		echo $survey['survey_title']."(".$arow['survey_id'].")";
	    	?>
	    </div>
	  </div>
	</a>
</li>