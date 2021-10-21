<?php
require_once 'dbh.inc.php';
function emptyFields($first, $last, $mail, $pwd, $rePwd){
  $rezult;
  if(empty($first) || empty($last) || empty($mail) || empty($pwd) || empty($rePwd)){
    $rezult = true;
  }
  else {
    $rezult = false;
  }
  return $rezult;
}
function nameShort($uid){
  $length = strlen($uid);
  if ($length > 4) {
    return false;
  }else {
    return true;
  }
}
function invalidNames($name){
  $rezult;
  if (!preg_match("/^[a-zA-Z]*$/", $name)) {
    $rezult = true;
  }
  else {
    $rezult = false;
  }
  return $rezult;
}
function invalidEmail($mail){
  $rezult;
  if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $rezult = true;
  }
  else {
    $rezult = false;
  }
  return $rezult;
}

function insertUser($conn, $first, $last, $mail, $uid, $pwd){
  //INSERT USER P. Stmt
  $sql = "INSERT INTO users (user_first, user_last, user_mail, user_uid, user_pwd)
   VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../register.php?error=stmtfailed");
    exit();
  }
  $hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt, "sssss", $first, $last, $mail, $uid, $hashedpwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}
function emptyLoginInput($uid, $pwd){
  $rezult;
  if(empty($uid) || empty($pwd)){
    $rezult = true;
  }
  else {
    $rezult = false;
  }
  return $rezult;
}

function userExist($conn, $user){
  $sql = "SELECT * FROM users WHERE user_uid=? OR user_mail=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../register.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ss", $user, $user );
  mysqli_stmt_execute($stmt);
  $rezult = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($rezult)) {
    return $row;
  }
  else {
    return false;
  }
  mysqli_stmt_close($stmt);
}

function loginUser($conn, $username, $pwd){

  $uidExist = userExist($conn, $username);

  if ($uidExist === false) {
    header("Location: ../login.php?error=missuid");
    exit();
  }
  $pwdHashed = $uidExist["user_pwd"];
  $pwdCheck = password_verify($pwd, $pwdHashed);

  if ($pwdCheck === false) {
    header("Location: ../login.php?error=missuid");
    exit();
  }
  elseif ($pwdCheck === true) {
    session_start();
    $_SESSION['user_Id'] = $uidExist['user_id'];
    $_SESSION['user_Uid'] = $uidExist['user_uid'];
    $_SESSION['user_First'] = $uidExist['user_first'];
    header("Location: ../index.php");
    exit();
  }
}

function isPositive($productTotal){
  if ($productTotal >= 0) {
    return true;
  }
  else {
    return false;
  }
}

function isNumber($productTotal){
  if (preg_match("/^[0-9-]*$/", $productTotal)) {
    return true;
  }
  else {
    return false;
  }
}

function isZero($zero){
  if ($zero == 0) {
    return true;
  }
  else {
    return false;
  }
}

function isEmpty($productName, $productType){
  if (empty($productName) || empty($productType)) {
    return true;
  }
  else {
    return false;
  }


}
function insertProduct($conn, $productName, $productType, $productTotal, $productUser){

  // 1.insert product in products table
  $sql = "INSERT INTO products (product_name, product_type, product_total, product_user)
  VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../register.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ssss", $productName, $productType, $productTotal, $productUser);
  mysqli_stmt_execute($stmt);

  // 2. get productid
  $productId = getProductId($conn, $productName, $productUser, $productType);

  // 3. insert product id in productimg table
  $userId = $_SESSION['user_Id'];
  $sql = "INSERT INTO productimg (pimg_pid, pimg_status)
  VALUES (".$productId.", 0);";
  if (mysqli_query($conn, $sql)) {
    echo "Succsess!";
  }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
function getProductId($conn, $productName, $productUser, $productType){

  $sql = "SELECT * FROM products WHERE product_name=? AND product_user=".$productUser." AND product_type=".$productType.";";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../register.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt , "s", $productName);
  mysqli_stmt_execute($stmt);
  $rezult = mysqli_stmt_get_result($stmt);

  $productId = mysqli_fetch_assoc($rezult);

  return $productId['product_id'];
}

function existProductAndUser($conn, $productName, $productUser, $productType){

  $sql = "SELECT * FROM products WHERE product_name=? AND product_user=? AND product_type=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../register.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "sss", $productName, $productUser, $productType);
  mysqli_stmt_execute($stmt);
  $rezult = mysqli_stmt_get_result($stmt);

  if($row = mysqli_fetch_assoc($rezult)){
    return $row;
  }
  else return false;
}

function addProductTotal($conn, $productName, $productUser, $productTotal, $productType){
  // 1. Get product row
  $sql = "SELECT * FROM products WHERE product_name=? AND product_user=? AND product_type=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../register.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "sss", $productName, $productUser, $productType);
  mysqli_stmt_execute($stmt);

  // 2. Get product_total
  $rezult = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($rezult);
  $pTotal = $row['product_total'] + $productTotal;

  // 3. Update product_total
  $pid = $row['product_id'];
  $sql = "UPDATE products
          SET product_total = $pTotal
          WHERE product_id = $pid;";
  mysqli_query($conn, $sql);
  mysqli_close($conn);
}

function userProducts($conn, $user){

  $sql = "SELECT * FROM products WHERE product_user=".$user.";";
  $rezult = mysqli_query($conn, $sql);
  return $rezult;
}
function getProducts($conn, $text){
  if ($text == null) {
    $sql = "SELECT * FROM products;";
    $rezult = mysqli_query($conn, $sql);
  }else {
    $sql = "SELECT * FROM products WHERE product_name LIKE ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo "Stmt prepare fail";
    }
      $word = "%".$text."%";
      mysqli_stmt_bind_param($stmt , "s", $word);
      mysqli_stmt_execute($stmt);
      $rezult = mysqli_stmt_get_result($stmt);
  }

  return $rezult;
}
function productImg($conn, $product){

  $productId = $product['product_id'];
  $productType = $product['product_type'];
  $sql = "SELECT * FROM productimg WHERE pImg_pid=".$productId.";";
  $rezult = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($rezult);
  if (!$row['pImg_status']) {
    return "images/productType/".$productType.".png";
  }
  else {
    // if product img exist
    return "images/productsId/".$productId.".png";
  }
}
function productType($product){
  switch ($product['product_type']) {
    case '1':
      return "Shoes";
      break;
    case '2':
      return "Tehnology";
      break;
    case '3':
      return "Clothing";
      break;
    case '4':
      return "Food";
      break;

    default:
      return "Error";
      break;
  }
}
function productStatus($product){

  if ($product['product_total'] == 0) {
    return "red";
  }
  else {
    return "green";
  }
}
function productImgStatus($conn, $pid){

  $sql = "UPDATE productimg
          SET pImg_status = 1
          WHERE pImg_pid = ".$pid.";";
  mysqli_query($conn, $sql);
  mysqli_close($conn);
}

function filterProducts($conn, $filters, $flag = 0, $text = null){
  if ($text == null) {
    if ($flag == 0) {
      $sql = "SELECT * FROM products;";
      $rezult = mysqli_query($conn, $sql);
    }else {
      $sql = "SELECT * FROM products WHERE product_type IN ";
      $types = "(". implode(", " , $filters) . ");";
      $sql .= $types;
      $rezult = mysqli_query($conn, $sql);
    }
  }elseif ($flag == 0) {
    $sql = "SELECT * FROM products WHERE product_name LIKE ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo "Stmt prepare fail";
    }
      $word = "%".$text."%";
      mysqli_stmt_bind_param($stmt , "s", $word);
      mysqli_stmt_execute($stmt);
      $rezult = mysqli_stmt_get_result($stmt);
  }else {
    $sql = "SELECT * FROM products WHERE product_name LIKE ? AND product_type IN ";
    $types = "(". implode(", " , $filters) . ");";
    $sql .= $types;
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo "Stmt prepare fail";
    }
      $word = "%".$text."%";
      mysqli_stmt_bind_param($stmt , "s", $word);
      mysqli_stmt_execute($stmt);
      $rezult = mysqli_stmt_get_result($stmt);
  }
  $rezultArray = array();
  while ($row = mysqli_fetch_assoc($rezult)) {
    array_push($rezultArray, $row);
    }
  return $rezultArray;
}
// function filterProducts($allProducts, $filters, $flag = 0){
//   $rezult = array();
//   if ($flag) {
//     while ($row = mysqli_fetch_assoc($allProducts)) {
//       if (in_array($row['product_type'], $filters)) {
//         array_push($rezult, $row);
//       }
//     }
//   }
//   else {
//     while ($row = mysqli_fetch_assoc($allProducts)) {
//         array_push($rezult, $row);
//     }
//   }
//
//   return $rezult;
// }
