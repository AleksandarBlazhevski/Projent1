<?php
session_start();
require_once 'dbh.inc.php';

if (isset($_POST['buy-product'])) {
  if (!isset($_SESSION['user_Id'])) {
    header("Location: ../login.php?error=logfirst");
    exit();
  }
  if ($_POST['buy-total'] < 1) {
    header("Location: ../products.php?error=negativ");
    exit();
  }
  $quantity = $_POST['buy-total'];
  $pid = $_POST['buy-product'];
  $sql = "SELECT * FROM products WHERE product_id=".$pid.";";
  $rezult = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($rezult);


  if ($row['product_total'] < $quantity) {
    header("Location: ../products.php?error=over");
    exit();
  }
  $left = $row['product_total'] - $quantity;
  $sql = "UPDATE products SET product_total = '$left' WHERE product_id = '$pid';";

  if (!mysqli_query($conn, $sql)) {
    echo "Query failed!";
  }
  header("Location: ../products.php?error=none");
  exit();


}else {
  header("Location: ../products.php");
  exit();
}
