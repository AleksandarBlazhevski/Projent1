<?php
session_start();
require_once 'dbh.inc.php';
require_once 'func.inc.php';

if (isset($_POST['product_add'])) {
  $productName = $_POST['product_name'];
  $productType =  $_POST['product_type'];
  $productTotal = $_POST['product_total'];
  $productUser = $_SESSION['user_Id'];

  if(isEmpty($productName, $productType)){
    header("Location: ../profile.php?error=empty&name=".$productName."");
    exit();
  }
  if (!isNumber($productTotal)) {
    header("Location: ../profile.php?error=nonnum&name=".$productName."");
    exit();
  }
  if (!isPositive($productTotal)) {
    header("Location: ../profile.php?error=negativ&name=".$productName."");
    exit();
  }
  if (existProductAndUser($conn, $productName, $productUser, $productType)) {
    addProductTotal($conn, $productName, $productUser, $productTotal, $productType);
    header("Location: ../profile.php?error=exist");
  }
  else {
    // echo "Product doesn't exist!";
    insertProduct($conn, $productName, $productType, $productTotal, $productUser);
  }


  header("Location: ../profile.php?insert=succsess");
}
else {
  header("Location: ../profile.php");
  exit();
}
