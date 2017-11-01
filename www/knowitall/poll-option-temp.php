<div class="field">
  <div class="ui radio checkbox">
    <input <?php if(!empty($resrow) && $resrow['option_id'] == ($i+1)){echo "checked=\"checked\" ";} ?> class="ui radio" type="radio" name="radio" <?php if(!empty($resrow)){echo "readonly";} ?>><label><?php echo $optionrow['option_string']; ?></label>
    <?php 
      $sql = $conn->prepare("SELECT * FROM survey_options WHERE survey_id = ? AND option_id = ?");
      $i1 = $i+1;
      $sql->bind_param('si', $id, ($i1));
      $sql->execute();
      $vtemp = $sql->get_result();
      $vnum = $vtemp->fetch_assoc();
      if(isset($_SESSION['id'])){
        if($uscid == $row['user_id']){
          if($vnum['voter_number'] < 1){
            include("delete-option-button.php");
          }
        }
      }
    ?>
    <input class="match-radio" type="hidden" name="<?php echo ($i+1);?>">
  </div>
</div>