<?php require_once 'includes/header.inc.php'; ?>
<div class="wrapper">
    <div class="signin-form">
        <h3>Register</h3>
        <form action="includes/signup.inc.php" method="POST">
            <label>
              <?php
                if (isset($_GET['first'])) {
                  $first = $_GET['first'];
                  echo '<input type="text" name="first" placeholder="Name" value="'.$first.'">';
                }else {
                  echo '<input type="text" name="first" placeholder="Name">';
                }
                if (isset($_GET['last'])) {
                  $last = $_GET['last'];
                  echo '<input type="text" name="last" placeholder="Surname" value="'.$last.'">';
                }else {
                  echo '<input type="text" name="last" placeholder="Surname">';
                }
                if (isset($_GET['mail'])) {
                  $mail = $_GET['mail'];
                  echo '<input type="text" name="mail" placeholder="E-mail" value="'.$mail.'">';
                }else {
                  echo '<input type="text" name="mail" placeholder="E-mail">';
                }
                if (isset($_GET['uid'])) {
                  $uid = $_GET['uid'];
                  echo '<input type="text" name="uid" placeholder="Username" value="'.$uid.'">';
                }else {
                  echo '<input type="text" name="uid" placeholder="Username">';
                }
              ?>

                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="re_pwd" placeholder="Retype password">
                <button type="submit" name="signup_submit">Sign up</button>
                <?php
                  if (isset($_GET['error'])) {
                    switch ($_GET['error']) {
                      case 'empty':
                        echo "<p class='error'>Fill all fields.</p>";
                        break;
                      case 'invfirst':
                        echo "<p class='error'>Invalid characters in name.</p>";
                        break;
                      case 'invlast':
                        echo "<p class='error'>Invalid characters in surname.</p>";
                        break;
                      case 'invmail':
                        echo "<p class='error'>Insert valid E-mail.</p>";
                        break;
                      case 'short':
                        echo "<p class='error'>Username is too short.<br>
                              Username must be greater thank 4 characters.</p>";
                        break;
                      case 'pwdnm':
                        echo "<p class='error'>Passwords does not match.</p>";
                        break;
                      case 'uexist':
                        echo "<p class='error'>Username already exist.</p>";
                        break;
                      case 'mailexist':
                        echo "<p class='error'>E-mail already exist.</p>";
                        break;
                      case 'stmtfailed':
                        echo "<p class='error'>Something went wrong. Try again.</p>";
                        break;
                      case 'none':
                        echo "<p class='success'>Sign up is successful</p>";
                        break;
                    }
                  }
                 ?>

            </label>
            <br>
            <br>
            <br>
        </form>
    </div>
</div>
<nav class="footer">
    <div class="wrapper">

    </div>
</nav>
</div>
</body>
</html>
