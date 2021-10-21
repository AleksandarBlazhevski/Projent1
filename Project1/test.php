<?php
include_once 'includes/dbh.inc.php';
require_once 'includes/func.inc.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="looks/test.css" rel="stylesheet">
    <title></title>
  </head>
  <body>
    <form method="get">
      <input type="text" name="search-text">
      <button type="submit" name="search-submit">Search</button>
    </form>
    <?php
    $filters = array('op1' => 0, 'op2' => 2, 'op3' => 0, 'op4' => 0);
    $rezult = filterProducts($conn, $filters, $flag = 1, $text = "new");
    foreach ($rezult as $row) {
      echo $row['product_id']. "\t" .$row['product_name']. "\t".productType($row). "\t".$row['product_total']. "\t".$row['product_user']. "<br>";
    }

    ?>

  </body>
</html>
