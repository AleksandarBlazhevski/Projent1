<?php
  require_once "dbh.inc.php";
  if (isset($_POST['del-prod'])) {
    // echo "DELETING PRODUCT WITH ID: ".$_POST['del-prod'];
    $productId = $_POST['del-prod'];
    //Check if img is uploaded
    $sql = "SELECT * FROM productimg WHERE pImg_pid=".$productId.";";
    $rezult = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($rezult);
    // print_r($row);
    if ($row['pImg_status']) {
      $path = "../images/productsId/".$productId.".png";
      unlink($path);
    }


    $sql = "DELETE FROM products WHERE product_id=".$productId.";";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM productimg WHERE pImg_pid=".$productId.";";
    mysqli_query($conn, $sql);


    header("Location: ../profile.php?delete=success");
    mysqli_close($conn);
    exit();

  }else {
    header("Location: ../profile.php");
    exit();
  }
?>
