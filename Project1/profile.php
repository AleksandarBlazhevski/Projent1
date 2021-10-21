<?php
require_once 'includes/header.inc.php';
require_once 'includes/func.inc.php';
if (!isset($_SESSION['user_Uid'])) {
  header("Location: index.php");
}
?>
  <div class="wrapper">
    <article class="content">
      <div class="add-product">
        <h3 class="user-error1">Add new product</h3>
        <h3 class="user-error">
          <?php

            if (isset($_GET['error'])) {
              switch ($_GET['error']) {
                case 'empty':
                  echo "Fill all fields";
                  break;
                case 'negativ':
                  echo "Product total must be greater than 0";
                  break;
                case 'none':
                  echo "Upload successful";
                  break;

              }
            }else if (isset($_GET['insert'])) {
              echo "Upload successful";
            }else{
              echo "<br>";
            }
          ?>
        </h3>
        <form action="includes/add.inc.php" method="POST">
          <?php
            if (isset($_GET['name'])) {
              echo '<input type="text" name="product_name" placeholder="Product name" value="'.$_GET['name'].'">';
            }
            else {
              echo '<input type="text" name="product_name" placeholder="Product name">';
            }
          ?>
          <div class="product_type">
            <label>Shoes:</label>
            <input type="radio" name="product_type" value="1">
          </div>
          <div class="product_type">
            <label>Tehnology:</label>
            <input type="radio" name="product_type" value="2">
          </div>
          <div class="product_type">
            <label>Clotding:</label>
            <input type="radio" name="product_type" value="3">
          </div>
          <div class="product_type">
            <label>Food:</label>
            <input type="radio" name="product_type" value="4">
          </div>
          <input type="text" name="product_total" placeholder="Product total">
          <button type="submit" name="product_add">Add</button>
        </form>
      </div>
      <div class="user-products">
        <h3>Your product/s</h3>
        <h3 class="user-error">
          <?php
            if (isset($_GET['error'])) {
              switch ($_GET['error']) {
                case 'error':
                  echo "Chose an image";
                  break;
                case 'extension':
                  echo "Supports only .png format";
                  break;
                case 'none':
                  echo "Upload successful";
                  break;
              }
            }
            if (isset($_GET['delete'])) {
              echo "Delete successful";
            }
          ?>
        </h3>
        <div class="wrapper">

          <?php
            $user = $_SESSION['user_Id'];
            $userProduct = userProducts($conn, $user);
            if (0 == mysqli_num_rows($userProduct)) {
              echo "Empty";
            }else {
              echo "
              <table>
                <tbody>
                  <tr>
                    <th>Product</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                  </tr>
              ";
              while ($product = mysqli_fetch_assoc($userProduct)) {
                $productImg = productImg($conn, $product);
                $productStatus = productStatus($product);
                echo '
                <tr class="product">
                  <td><img src="'.$productImg.'"></td>
                  <td>'.$product["product_name"].'</td>
                  <td>'.productType($product).'</td>
                  <td>'.$product["product_total"].'</td>
                  <td class="'.$productStatus.'"></td>
                  <td>
                  <form action="includes/uploadimg.inc.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="upload-file">
                    <button type="submit" name="upload-img" value="'.$product['product_id'].'">Upload</button>
                  </form>
                  </td>
                  <td>
                  <form action="includes/delprod.inc.php" method="POST">
                    <button type="submit" name="del-prod" value="'.$product['product_id'].'">Delete</button>
                  </form>
                  </td>
                </tr>
                ';
              }
              echo "
                </tbody>
                </table>
              ";
            }
          ?>

      </div>
      </div>
    </article>
  </div>

  <nav class="footer">
    <div class="wrapper">



    </div>
  </nav>
</div>
</body>
</html>
