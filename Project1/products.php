<?php
  require_once 'includes/header.inc.php';
  require_once 'includes/func.inc.php';
 ?>
<div class="wrapper product-container">
    <form class="prod-search-form" method="GET">
      <div class="product-filter">
        <div class="filter-div">
          <label for="option1">
            Shoes:
          </label>
              <input type="checkbox" name="op1" >
        </div>
        <div class="filter-div">
          <label for="option2">
            Tehnology:
          </label>
              <input type="checkbox" name="op2" >
        </div>
        <div class="filter-div">
            <label>
              Clothing:
            </label>
                <input type="checkbox" name="op3" >
          </div>
        <div class="filter-div">
            <label>
              Food:
            </label>
                <input type="checkbox" name="op4" >
          </div>
        <button type="submit" name="search-submit">Filter</button>
      </div>
      <div class="product-search">
        <input type="text" name="search-product" placeholder="Product">
        <button type="submit" name="search-submit">Search</button>
      </div>

      </form>
      <div class="products">
          <div class="wrapper">
            <table>
              <tr>
                <td>Picture</td>
                <td>Name</td>
                <td>Type</td>
                <td>Total</td>
                <td><?php
                if (isset($_GET['error'])) {
                  $error = $_GET['error'];
                  switch ($error) {
                    case 'none':
                      echo "Successfull purchase";
                      break;

                    default:
                      echo "Insert values greater than 0 and lower than total";
                      break;
                  }

                } ?></td>
              </tr>
              <?php
              $text = null;
              if (isset($_GET['search-submit'])) {
                $text = $_GET['search-product'];
              }

              $filters = array('op1' => 0, 'op2' => 0, 'op3' => 0, 'op4' => 0);
              $flag = 0;
              if(isset($_GET['op1'])){
                $filters['op1'] = 1;
                $flag = 1;
              }
              if(isset($_GET['op2'])){
                $filters['op2'] = 2;
                $flag = 1;
              }
              if(isset($_GET['op3'])){
                $filters['op3'] = 3;
                $flag = 1;
              }
              if(isset($_GET['op4'])){
                $filters['op4'] = 4;
                $flag = 1;
              }

              $rezult = filterProducts($conn, $filters, $flag, $text);

              foreach ($rezult as $row) {
                $total = $row['product_total'];
                if ($total == 0) {
                  continue;
                }
                $img = productImg($conn, $row);
                $name = $row['product_name'];
                $type = productType($row);
                echo "
                  <tr>
                    <td><img src='$img' alt='Picture'></td>
                    <td>$name</td>
                    <td>$type</td>
                    <td>$total</td>
                    <td>
                      <form action='includes/buy.inc.php' method='POST'>
                        <input type='number' name='buy-total'>
                        <button type='submit' name='buy-product' value='".$row['product_id']."'>Buy</button>
                      </form>
                    </td>
                  </tr>
                ";
              }
              ?>
            </table>
          </div>
      </div>

</div>
    <nav class="footer">
        <div class="wrapper">

        </div>
    </nav>
</div>
</body>
</html>
