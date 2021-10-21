<?php
require_once 'dbh.inc.php';
require_once 'func.inc.php';

if(isset($_POST['login_submit'])){
  $username = $_POST['uid'];
  $pwd = $_POST['pwd'];

  if (emptyLoginInput($username, $pwd)) {
    header("Location: ../login.php?error=empty");
    exit();
  }
  if (!userExist($conn, $username)) {
    header("Location: ../login.php?error=notexist");
    exit();
  }
  loginUser($conn, $username, $pwd);
}
else {
  header("Location: login.php");
  exit();
}
