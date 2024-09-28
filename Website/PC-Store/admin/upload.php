<?php
include '../db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomProduit = $_POST['nomProd'];
    $prixProduit = $_POST['prixProd'];
    $stockProduit = $_POST['stockProd'];
    $promoProduit = $_POST['promo'];
    $descrProduit = $_POST['descrProd'];
    $catProduit = $_POST['selectCat'];
    $pathImageProduit = basename($_FILES["file"]["name"]);
    $addQuery = "INSERT INTO produit (nom_prod, desp_prod, prix, img_prod, promo, stock, idCategorie, vendu) VALUES ('$nomProduit', '$descrProduit', '$prixProduit',  '$pathImageProduit', '$promoProduit', '$stockProduit', '$catProduit', '0')";
    $result = mysqli_query($con, $addQuery);
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Hình ảnh thật hay giả
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        echo "Tệp là một hình ảnh - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Tệp không phải là hình ảnh.";
        $uploadOk = 0;
    }
    // Tệp đã tồn tại
    if (file_exists($target_file)) {
        echo "Xin lỗi, tệp đã tồn tại.";
        $uploadOk = 0;
    }
    // $uploadOk được đặt thành 0 do lỗi
    if ($uploadOk == 0) {
        echo "Xin lỗi, tệp của bạn không được tải lên.";
    // Tải tệp lên
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "Tệp ". htmlspecialchars( basename( $_FILES["file"]["name"])). " đã được tải lên.";
        } else {
        echo "Xin lỗi, đã xảy ra lỗi khi tải tệp của bạn lên.";
        }
    }
}


// Tệp đã tồn tại
if (file_exists($target_file)) {
    echo "Xin lỗi, tệp đã tồn tại.";
    $uploadOk = 0;
  }
// $uploadOk được đặt thành 0 do lỗi
if ($uploadOk == 0) {
    echo "Xin lỗi, tệp của bạn không được tải lên.";
  // Tải tệp lên
  } else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      echo "Tệp ". htmlspecialchars( basename( $_FILES["file"]["name"])). " đã được tải lên.";
    } else {
      echo "Xin lỗi, đã xảy ra lỗi khi tải tệp của bạn lên.";
    }
  }
  header('Location: index.php',true,301);
?>