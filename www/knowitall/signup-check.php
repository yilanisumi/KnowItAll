<?php
	session_start();
  session_unset();
  include("database-connector.php");
  $username = $_POST['signupName'];
  $email = $_POST['signupEmail'];
  $id = $_POST['signupID'];
  $password = $_POST['signupPassword'];
  $passHash = password_hash($password, PASSWORD_BCRYPT);  // password hash that is generated

  //echo ($username." ".$email." ".$id." ".$password);

  $sql = $conn->prepare("SELECT * FROM user WHERE usc_email = ?;");
  $sql->bind_param('s', $email);
  $sql->execute();
  $ans = $sql->get_result();
  $row = $ans->fetch_assoc();
  
  $sql = $conn->prepare("SELECT * FROM user WHERE usc_id = ?;");
  $sql->bind_param('s', $id);
  $sql->execute();
  $ans2 = $sql->get_result();
  $row2 = $ans2->fetch_assoc();

  
  if(empty($row) && empty($row2)){
  	$sql = $conn->prepare("INSERT INTO `user` (`user_id`,`usc_email`, `usc_id`, `password`, `user_name`) VALUES (?, ?, ?, ?, ?);");
    $sql->bind_param('sssss', $id, $email, $id, $passHash, $username);
    $sql->execute();
  	$_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["id"] = $id;
  	header("Location: home-search.php");
  }else{
  	header("Location: signup.php?fail=true");
  }
  exit();
?>