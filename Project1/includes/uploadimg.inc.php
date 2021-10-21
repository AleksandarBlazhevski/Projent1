<?php
  require_once 'dbh.inc.php';
  require_once 'func.inc.php';

  if (isset($_POST['upload-img'])) {
    $file = $_FILES['upload-file'];
    print_r($file);
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    echo $fileName;
    echo $fileTmpName;
    echo $fileSize;
    echo $fileError;

    $fileTmpExt = explode(".", $fileName);
    $fileExt = strtolower(end($fileTmpExt));
    if ($fileError != 0) {
      header("Location: ../profile.php?error=error");
      exit();
    }
    if ($fileExt != "png") {
      header("Location: ../profile.php?error=extension");
      exit();
    }
    if ($fileSize > 500000) {
      header("Location: ../profile.php?error=size");
      exit();
    }
    $fileNameNew = $_POST['upload-img'].".png";
    $fileDestination = "../images/productsId/".$fileNameNew;
    move_uploaded_file($fileTmpName, $fileDestination);
    $pid = $_POST['upload-img'];
    productImgStatus($conn, $pid);
    header("Location: ../profile.php?error=none");
  }
  else {
    header("Location: ../profile.php");
    exit();
  }
 ?>
