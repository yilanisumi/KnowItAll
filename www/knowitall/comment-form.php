<form class="ui form fluid search-bar" action="commentHelper.php?id=<?php echo $id; ?>" method="post">
  <input type="text" placeholder="Write a comment..." name="newComment">
  <div class="ui checkbox">
    <input class="ui checkbox" type="checkbox" name="anon">
    <label class="disinline">Be Anonymous</label>
  </div>
  <button class="ui button custom-margin-hor-tiny" type="submit">Comment</button>
</form>