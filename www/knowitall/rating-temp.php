<?php 
  $sql = $conn->prepare("SELECT * FROM user_survey WHERE user_id = ? AND survey_id = ?;");
  $sql->bind_param('ss', $uscid, $id);
  $sql->execute();
  $resans = $sql->get_result();
  $resrow = $resans->fetch_assoc();
  if(!empty($resrow)){
    include("responded-message.php");
  }
?>
<form class="ui fluid form master-center" action="rateHelper.php?surveyid=<?php echo $id ?>" method="post">
  <div class="field">
    <div class="ui massive star rating <?php if(!empty($resrow)){echo "readonly";} ?> " data-rating=" <?php if(!empty($resrow)){echo $resrow["option_id"];} ?> " data-max-rating="10"></div>
    <input type="hidden" name="rating" value="0">
  </div>

  <?php 
    if(empty($resrow)){
      include("survey-submit.php");
    }
  ?>
</form>