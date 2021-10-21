<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Project 1</title>
    <link href="looks/reset.css" rel="stylesheet" type="text/css">
    <link href="looks/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav class="nav-top">
    <div class="wrapper">
        <a id="logo" href="index.php"></a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </div>
</nav>
<nav class="nav-bottom">
    <div class="wrapper">
        <p class="height"></p>
    </div>
</nav>
<div class="login-body">
    <div class="wrapper">
        <form action="includes/login.inc.php" method="POST">
            <label>
                <h3>Login</h3>
                <input type="text" name="uid" placeholder="Username/E-mail">
                <input type="password" name="pwd" placeholder="Password">
                <button type="submit" name="login_submit">Log in</button>
                <?php
                    if(isset($_GET['error'])){
                        switch ($_GET['error']) {
                            case 'empty':
                            echo "<p class='error'>Fill all fields.</p>";
                            break;
                            case 'notexist':
                            echo "<p class='error'>User does not exist.</p>";
                            break;
                            case 'missuid':
                            echo "<p class='error'>Username and password does not match.</p>";
                            break;
                            case 'logfirst':
                            echo "<p class='error'>Log in to buy products.</p>";
                            break;
                        }
                    }
                ?>
            </label>
        </form>
    </div>
</div>
</body>
</html>
