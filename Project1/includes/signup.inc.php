<?php
require_once 'dbh.inc.php';
require_once 'func.inc.php';

if(isset($_POST['signup_submit'])){
  $first = $_POST['first'];
  $last = $_POST['last'];
  $mail = $_POST['mail'];
  $uid = $_POST['uid'];
  $pwd = $_POST['pwd'];
  $rePwd = $_POST['re_pwd'];

  //FILTERS
  if(emptyFields($first, $last, $mail, $pwd, $rePwd)){
    header("Location: ../register.php?error=empty&first=$first&last=$last&mail=$mail&uid=$uid");
    exit();
  }else if(invalidNames($first)){
    header("Location: ../register.php?error=invfirst&last=$last&mail=$mail&uid=$uid");
    exit();
  }else if(invalidNames($last)){
    header("Location: ../register.php?error=invlast&first=$first&mail=$mail&uid=$uid");
    exit();
  }elseif (invalidEmail($mail)) {
    header("Location: ../register.php?error=invmail&first=$first&last=$last&uid=$uid");
    exit();
  }elseif (nameShort($uid)) {
    header("Location: ../register.php?error=short&first=$first&last=$last&mail=$mail");
    exit();
  }elseif($pwd !== $rePwd){
    header("Location: ../register.php?error=pwdnm&first=$first&last=$last&mail=$mail&uid=$uid");
    exit();
  }elseif (userExist($conn, $uid)) {
    header("Location: ../register.php?error=uexist&first=$first&last=$last&mail=$mail");
    exit();
  }elseif (userExist($conn, $mail)) {
    header("Location: ../register.php?error=mailexist&first=$first&last=$last&uid=$uid");
    exit();
  }

  insertUser($conn, $first, $last, $mail, $uid, $pwd);
  header("Location: ../register.php?error=none");


}else {
  header("Location: ../register.php");
}
