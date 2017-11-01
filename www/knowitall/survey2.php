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
    <article class="ui fluid grid">
      <div class="row search-result">
        <div class="ui fluid grid custom-margin-hor-small custom-margin-vert-small surveycard">
          <div class="twelve wide column">Survey Title(ID0000000)</div>
          <div class="four wide column"><span class="float-right">O 999 O 999</span></div>
          <div class="eight wide column">Created: 10-10-2017 Closed</div>
          <div class="eight wide column"><span class="float-right">Creator: Thomas Wayne</span></div>
        </div>
      </div>

      <div class="row">
        <div class="ui dimmable dimmed master-center">
          <img src="" width="300" height="200">
          <div class="ui dimmer active">
            <div class="content">
              <div class="center">
                <button class="ui button">Show Results</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- results chart TODO-->
      <div class="fluid row custom-margin-hor custom-margin-vert">
        <form class="ui form master-center">
          <div class="field">
            <div class="ui massive star rating" data-rating="0" data-max-rating="10"></div>
          </div>

          <div class="field">
            <div class="ui checkbox">
              <input class="ui checkbox" type="checkbox" name="anon">
              <label class="disinline">Be Anonymous</label>
            </div>
            <button class="ui button custom-margin-hor-small" type="button">Submit</button>
          </div>
        </form>
    </article>


    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>