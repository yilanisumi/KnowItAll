<?php session_start(); ?>

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
    <form class="ui form search-bar custom-pad-hor master-center custom-pad-vert" action="search-results.php" method="get" id="search">
      <input class="custom-margin-bot-small" type="text" name="search" value="<?php echo $_GET['search'] ?>" required="true">
      <button class="ui button" type="submit" form="search" value="Submit">Search</button>
      <button class="ui button link-btn"><a href="create.php">Create New Survey</a></button>
    </form>

    <span class="custom-pad-vert custom-pad-hor">Search Results For: <?php echo $_GET['search'] ?></span>
    <div class="float-right custom-pad-hor custom-pad-vert">
      <span class="disinline">Sort:</span>
      <a class="disinline" href="search-results.php?sort=relevance&search=<?php echo $_GET['search'] ?>">Relevance</a>
      <span>/</span>
      <a class="disinline" href="search-results.php?sort=chronological&search=<?php echo $_GET['search'] ?>">Chronological</a>
    </div>
    <ul class="clearfloat">
      <?php include("show-results.php") ?>
    </ul>

    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>