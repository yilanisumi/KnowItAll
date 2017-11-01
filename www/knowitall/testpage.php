<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta Tags -->
    <?php include("meta-tags.php");?>

    <title>Kneriter</title>

    <!-- CSS link -->
    <?php include("all-css.php");?>
  </head>
  <body>
    <form action="testHelper.php?pressme=true" method="post">
    	<button type="submit">Press Me</button>
    	<input type="hidden" name="press" value="pressed">
    </form>

    <!-- Scripts -->
    <?php include('all-scripts.php');?>
  </body>
</html>