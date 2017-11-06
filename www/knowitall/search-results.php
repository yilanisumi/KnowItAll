<?php 
  session_start(); 
  include("database-connector.php");
  if(!isset($_SESSION['id']) && !isset($_SESSION['gid'])){
    $sql = $conn->prepare("SELECT user_id FROM search_temp WHERE user_id LIKE \"-%\" ORDER BY user_id DESC LIMIT 1;");
    $sql->execute();
    $ans = $sql->get_result();
    $gid = $ans->fetch_assoc();
    $gid = intval($gid['user_id']);
    //echo $gid;
    //echo "<br>";
    $gid -= 1;
    $_SESSION['gid'] = $gid;
    //echo $gid;
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta Tags -->
    <?php include("meta-tags.php");?>

    <title>Know It All</title>

    <!-- CSS link -->
    <?php include("all-css.php");?>
  </head>

  <?php
    // process frequent search terms 
    //include("database-connector.php");

    $searchResults = $_GET['search']; 
    $searchResults = ltrim($searchResults); // remove whitespace from beginning of searchResults string
    $searchResults = rtrim($searchResults); // remove whitespace from end of searchResults string
    $searchTerms = preg_split('/\s+/', $searchResults);
    $numSearchTerms = sizeof($searchTerms);
    for($i = 0; $i < $numSearchTerms; $i++)
    {
      // check if the search term is in the frequent_search table
      $sql = $conn->prepare("SELECT * FROM frequent_search WHERE search = ?;");
      $sql->bind_param('s', $searchTerms[$i]);
      $sql->execute();
      $ans = $sql->get_result();
      $numSearch = $ans->num_rows;

      // search term exists in frequent_search table, increment its freq value
      if($numSearch > 0) {
        $sql = $conn->prepare("UPDATE frequent_search SET freq = freq + 1 WHERE search = ?;");
        $sql->bind_param('s', $searchTerms[$i]);
        $sql->execute();  
      }
      // search term does not exist in frequent_search table, insert it
      else {
        $sql = $conn->prepare("INSERT INTO frequent_search (search, freq) VALUES (\"" .$searchTerms[$i]."\", 1);");
        $sql->execute();
      }
    }
  ?>

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