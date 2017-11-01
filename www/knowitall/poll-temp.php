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
<form class="ui form fluid" action="voteHelper.php?surveyid=<?php echo $id ?>" method="post">
  <?php 
    $rowcount = $ans3->num_rows;
    echo "<input type=\"hidden\" name=\"numopts\" value=\"".$rowcount."\">";
    for($i = 0; $i < $rowcount; $i++){
      $optionrow = $ans3->fetch_assoc();
      include("poll-option-temp.php");
    }
  ?>
  <!-- <div class="field">
    <div class="ui radio checkbox">
      <input class="ui radio" type="radio" name="option1"><label>Option 1</label>
    </div>
  </div>
  <div class="field">
    <div class="ui radio checkbox">
      <input class="ui radio" type="radio" name="option1"><label>Option 2</label>
    </div>
  </div>
  <div class="field">
    <div class="ui radio checkbox">
      <input class="ui radio" type="radio" name="option1"><label>Option 3</label>
    </div>
  </div> -->

  <?php 
    if(empty($resrow)){
      include("survey-submit.php");
    }
  ?>
</form>

<?php 
  if(isset($_SESSION['id'])){
    if($uscid == $row['user_id']){
      include("creator-add-button.php");
    }
  }
?>