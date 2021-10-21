<?php require_once 'includes/header.inc.php'; ?>
        <div class="wrapper">
            <article class="content">
                <h3>Procedural php project</h3>
                <img src="images/products-and-services.jpeg" alt="Products">
                <p>Here you can register, log in, list products ,search for specific product and add new product.</p>
                <?php
                  if (isset($_SESSION['user_Uid'])) {
                    echo "
                    <div class='index-product'>
                      <h3>Product</h3>
                      <a id='add-product' href='profile.php'><button>add or remove</button></a>

                    </div>
                      ";
                  }
                  else {
                    echo "<p class='logged-out'>Currently you are not logged in!</p>";
                    echo "<p>Log in for more services.</p>";
                  }
                ?>
                <br class="clear-both">
            </article>
        </div>

        <nav class="footer">
            <div class="wrapper">

            </div>
        </nav>
    </div>
</body>
</html>
