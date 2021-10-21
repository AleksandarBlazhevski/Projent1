<?php
  require_once 'dbh.inc.php';
  session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Project 1</title>
  <link href="looks/reset.css" rel="stylesheet" type="text/css">
  <link href="looks/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="body">
  <nav class="nav-top">
    <div class="wrapper">
      <a id="logo" href="index.php"></a>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <?php
          if (isset($_SESSION['user_Uid'])) {
            echo '<li><a href="profile.php">Profile</a></li>';
          }
          else {
            echo '<li><a href="register.php">Register</a></li>';
          }
        ?>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </nav>
  <nav class="nav-bottom">
    <div class="wrapper">
      <?php
        if (isset($_SESSION['user_Uid'])) {
          echo '
          <form action="includes/logout.inc.php" method="POST">
            <label>
              <p id="user">'. $_SESSION['user_Uid'].'</p>
              <button type="submit" name="logout-submit">Log out</button>
            </label>
          </form>
          ';
        }
        else {
          echo '
          <form action="includes/login.inc.php" method="POST">
            <label>
              <input type="text" name="uid" placeholder="Username/E-mail">
              <input type="password" name="pwd" placeholder="Password">
              <button type="submit" name="login_submit">Log in</button>
            </label>
          </form>
          ';
        }
      ?>

    </div>
  </nav>
