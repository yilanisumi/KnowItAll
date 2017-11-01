<?php 
  if(isset($_SESSION['id'])){
      echo("Logout");
  }else{
      echo("Login");
  }
?>