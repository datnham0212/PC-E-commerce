<?php
$customType = "5";
include 'db.php';
include('functions.php');
if (empty($_SESSION)) {
    session_start();
}


if (isset($_SESSION['couponApplyed']))
    unset($_SESSION["couponApplyed"]);

if (isset($_GET["idCat"])) {
    $query = "SELECT * FROM categorie  WHERE (idCategorie = " . $_GET['idCat'] . ")";
    $result2 = mysqli_query($con, $query);
    $row2 = mysqli_fetch_assoc($result2);

    $patal = array();
    array_push($patal, $row2['desp_cat']);

    while ($row2['idCat_parente'] != 0) {

        $query = "SELECT * FROM categorie  WHERE (idCategorie = " . $row2['idCat_parente'] . ")";
        $result2 = mysqli_query($con, $query);
        $row2 = mysqli_fetch_assoc($result2);
        array_push($patal, $row2['desp_cat']);
    }
    $patal = array_reverse($patal);
}
$keysearch="";
if (isset($_POST['search'])  ) 
   $keysearch=$_POST['keyword'];
elseif(isset($_GET['search']))  $keysearch=$_GET['search'];
?>


<!doctype html>
<html class="no-js" lang="en">

<head>
   <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PC Store</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">


    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Owl Carousel main css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <link rel="stylesheet" href="css/recipe2.css">
    <!-- Theme shortcodes/elements style -->



    <link rel="stylesheet" href="css/shortcode/shortcodes.css">

    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">
    <link href="css/recipe.css" rel="stylesheet" type="text/css" />

    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/addWish.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>
    <script src="cssrecipe-3.js" type="text/javascript"></script>
    <script src="js/recipe2.js" type="text/javascript"></script>
    <?php 
    if(isset($_SESSION["id_user"])){
      $query_n = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient= " . $_SESSION["id_user"] . " ");
          $num_Line = mysqli_num_rows($query_n);
           if($num_Line>2){?>
  <?php  }
    }

    if (isset($_GET['idCat']) || isset($_GET['page']) || isset($_POST['submit'])) { ?>
        <script type="text/javascript">
            $(function() {
                $('body, html').animate({
                    scrollTop: '350px'
                }, 400);
            });
        </script>
    <?php } ?>

    <script>
 
  </script>
     <style>
      
         .ui-slider.ui-slider-horizontal.ui-widget.ui-widget-content.ui-corner-all {
  background: #eaeaea none repeat scroll 0 0;
  border: medium none;
  height: 8px;
}
.ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
    border-radius:0;
}

.ui-slider-handle.ui-state-default.ui-corner-all {
  background: red none repeat scroll 0 0;
  border: medium none;
  height: 15px;
  position: absolute;
  top:3px;
  width: 15px;
}
#slider-range .ui-slider-range{
    background-color: #ff4136;
}
    </style>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <!-- Bắt đầu Kiểu Header -->
        <header id="header" class="htc-header header--3 bg__white">
            <!-- Bắt đầu Khu vực Menu chính -->
            <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="images/logo/logo.png" alt="logo">
                                </a>
                            </div>
                        </div>
                        <!-- Bắt đầu Khu vực Menu chính -->
                        <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">
                                        <div class="logo">
                                            <a href="index.html">
                                                <img src="images/logo/logo.png" alt="logo">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Bắt đầu Khu vực Menu chính -->
                                    <div class="col-md-8 col-lg-8 col-sm-6 col-xs-6">
                                        <nav class="mainmenu__nav hidden-xs hidden-sm">
                                            <ul class="main__menu">
                                                <li class="drop"><a href="index.php">Trang chủ</a></li>

                                                <li class="drop"><a href="shop.php">Sản phẩm của chúng tôi</a>
                                                </li>
                                                <li><a href="help.php">Trợ giúp</a></li>
                                                <li><a href="contact.php">Liên hệ</a></li>
                                                <?php if (isset($_SESSION["id_user"])) echo '<li><a href="destroy.php">Đăng xuất</a></li>'; ?>
                                                <!-- Kết thúc Menu Mega Đơn lẻ -->
                                                <!-- Bắt đầu Menu Mega Đơn lẻ -->
                                            </ul>
                                        </nav>
                                        <div class="mobile-menu clearfix visible-xs visible-sm">
                                            <nav id="mobile_dropdown">
                                                <ul>
                                                    <li><a href="index.php">Trang chủ</a></li>
                                                    <li><a href="shop.php">Sản phẩm của chúng tôi</a></li>
                                                    <li><a href="help.php">Trợ giúp</a></li>
                                                    <li><a href="contact.php">Liên hệ</a></li>
                                                    <?php if (isset($_SESSION["id_user"])) echo '<li><a href="destroy.php">Đăng xuất</a></li>'; ?>

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <!-- Kết thúc Khu vực Menu chính -->
                                    <div class="col-md-2 col-sm-4 col-xs-3">
                                        <ul class="menu-extra">
                                            <li class="search search__open hidden-xs"><span class="ti-search"></span></li>
                                            <?php
                                            if (isset($_SESSION["id_user"])) {
                                                echo '<li><a href="account.php"><span class="ti-user">' . $_SESSION["userFirstName"] . '</span></a></li>';
                                            } else {
                                                echo '<li><a href="login-register.php"><span class="ti-user">Đăng nhập</span></a></li>';
                                            }
                                            ?>

                                            <?php if (isset($_SESSION["id_user"]))
                                                echo '<li class="cart__menu"><span class="ti-shopping-cart"></span><span class="cart-counter">' . $_SESSION["cartItems"] . '</span></li>';
                                            else
                                                echo '<li class="cart__menu"><a href="cart_logged_out.php"><span class="ti-shopping-cart"></span><span class="cart-counter">' . $_SESSION["cartItems"] . '</span></a></li>';
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mobile-menu-area"></div>
                            </div>
                        </div>
                        <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Style -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search__inner">
                                <form autocomplete="off" id="easysearch" role="search" method="POST" action="search.php">
                                    <input name="keyword" id="myInput" type="text" aria-label="Search" style="font-size: 20px;">
                                    <button type="submit" id="search" name="search"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close" style="color:black;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $arr = array();

            $arr2 = array();
            $query = "SELECT * FROM produit ";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $arr[] = $row['nom_prod'];
                    $arr2[] = $row["idProduit"];
                    $path = "images/" . $row['img_prod'] . "";
                    $arrimage[] = $path;
                }
            }


            ?>
            <!-- End Search Popap -->

            <!-- Start Cart Panel -->
                <?php if (isset($_SESSION["id_user"])) {
                echo
                '<div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">';

                $total_prix = 0;
                $query = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient= " . $_SESSION["id_user"] . " ");
                $num_Line = mysqli_num_rows($query);
                if ($num_Line == 0) echo ' <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title"></h2>
                                <nav class="bradcaump-inner">
                                    <span class="breadcrumb-item active">Giỏ hàng của bạn trống!</span>
                                    <a class="continuer" href="index.php">Tiếp tục mua sắm</a>                                    
                                </nav>
                            </div>';
                if($num_Line>=1){
                echo '<ul id="ticker">';
                while ($rowp = mysqli_fetch_array($query)) {
                    $image = $rowp["img_prod"];
                    $prix = $rowp['prix'] * (1 - $rowp['promo'] / 100);
                    $total_prix += $prix * $rowp['quantite'];
                    echo '
                            <li> <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="product-details.php?idprod=' . $rowp['idProduit'] . '">
                                    <img src="images/' . $image . '" alt="hình ảnh sản phẩm" style="width:265px;Height:67px;">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.php?idprod=' . $rowp['idProduit'] . '" style="text-transform: uppercase;">' . $rowp['nom_prod'] . '</a></h2>
                                <span class="quantity">Số lượng: ' . $rowp['quantite'] . '</span>
                                <span class="shp__price">Đơn giá: ' . $prix . ' VNĐ</span>
                            </div>
                           
                        </div></li>';
                }

                echo '</ul>
                    </div>
                    ';
                    } echo'
                    <ul class="shoping__total">
                        <li class="subtotal">Tổng phụ:</li>
                        <li class="total__price">' . $total_prix . ' VNĐ</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart_logged_in.php">Xem giỏ hàng của tôi</a></li>
                    </ul>
                </div>
            </div>';

            } ?>
            <!-- Kết thúc Bảng điều khiển Giỏ hàng -->
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Sản phẩm của chúng tôi</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                                    <span class="brd-separetor">></span>
                                    <span class="breadcrumb-item active">Sản phẩm của chúng tôi</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu Khu vực Sản phẩm của Chúng tôi -->
        <section class="htc__product__area shop__page ptb--130 bg__white">
            <div class="container">
                <div class="htc__product__container">
                    <!-- Bắt đầu Menu Sản phẩm -->
                    
                    <!-- Bắt đầu Menu Lọc -->
                   
                    <!-- Kết thúc Menu Lọc -->
                    <!-- Kết thúc Menu Sản phẩm -->

                 


                            <?php
                           $num=0;
                            $keysearch="";
                            if (isset($_POST['search'])  ) {
                                $keysearch=$_POST['keyword'];
                                $run = mysqli_query($con, "SELECT * from produit where stock>0 and nom_prod like '%{$keysearch}%'    ");
                                $num = mysqli_num_rows($run);
                                if($_POST['keyword']=="") $num=0;
                                 
                           }
                           elseif(isset($_GET['search']) ){
                            $keysearch=$_GET['search'];
                                $run = mysqli_query($con, "SELECT * from produit where stock>0 and nom_prod like '%{$keysearch}%'    ");
                                $num = mysqli_num_rows($run);
                           }

                           echo '<div class="pro__dtl__color" style="text-align: center;">
                                      <h2 class="title__5" style="font-size:30px;">';
                                 if($num!=0){
                                if($num == 1) echo $num.' kết quả'; else echo $num.' kết quả';}
                            else echo 'không có kết quả phù hợp..';
                                echo '</h2></div>';

                            $max = ($num % 16 != 0) ? (int)($num / 16) + 1 :  (int)($num / 16);
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;

                            $page =  16 * ($page - 1);
          
                            if(isset($_POST['search'])) {
                                $keyword=$_POST['keyword'];
                                $run=mysqli_query($con, "SELECT * from produit where stock >0 and nom_prod like '%{$keyword}%'   limit $page, 16 ");
                            }
                            elseif(isset($_GET['search']) ){
                                 $keysearch=$_GET['search'];
                                $run = mysqli_query($con, "SELECT * from produit where stock>0 and nom_prod like '%{$keysearch}%' limit $page, 16    ");
                                $num = mysqli_num_rows($run);
                           }
                echo '<div class="row">
                        <div class="product__list another-product-style">';
                            
                          if($num!=0){
                               while ($row = mysqli_fetch_array($run)) {
                                $image = "images/" . $row['img_prod'] . "";
                                $new_price = $row['prix'] * (1 - $row['promo'] * 0.01);
                                echo '
                                  
                                            <div class="col-md-3 single__pro col-lg-3  col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="product-details.php?idprod=' . $row['idProduit'] . '">
                                                                <img src="' . $image .
                                    '" alt="hình ảnh sản phẩm" style="width:270px;height:270px;">
                                                            </a>
                                                        </div>';
                                if (isset($_SESSION["id_user"])) {
                                    $query2 = "SELECT idProduit FROM envie WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
                                    $result2 = mysqli_query($con, $query2);
                                    echo '<div class="product__hover__info">
                                                                <ul class="product__action">';
                                    if (mysqli_num_rows($result2) == 0) {

                                        echo '<li><a title="Thêm ♥" class="add" href="#/"><span class="ti-heart"></span></a></li>';
                                    } else {
                                        echo '<li><a title="Đã thêm ♥" href="#/"><span class="ti-check-box" style="font-size: 25x;">Yêu thích</span></a></li>';
                                    }


                                    echo ' </ul>
                                                               <form class="add-wish" method="post" action="" role="form">  
                                                                    <input type="text" style="display: none;" name="id_product" value="' . $row["idProduit"] . '" />
                                                                </form>
                                                            </div>';
                                                            if($row['promo']!=0)
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';
                                } else {
                                    echo '<div class="product__hover__info">
                                                                <ul class="product__action">
                                                                     <li><a title="Thêm ♥" href="login-register.php"><span class="ti-heart"></span></a></li>
                                                                </ul>
                                                            </div>';
                                                            if($row['promo']!=0)
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';
                                }
                                echo '                  </div>
                                                    <div class="product__details">
                                                        <h2><a href="product-details.php?idprod=' . $row['idProduit'] . '">' . $row['nom_prod'] . '</a></h2>
                                                          <ul class="product__price">';
                                                        if($new_price<$row['prix']){

                                                            echo'<li class="old__price">' . $row['prix'] . ' VNĐ</li>
                                                            
                                                           
                                                            <li class="new__price">' . $new_price . ' VNĐ</li>';}
                                                            else {
                                                                 echo'<li class="new__price" >' . $row['prix'] . ' VNĐ</li>';
                                                            }
                                                       echo' </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                            }


}




                            ?>

                            <!-- Start Single Product -->



                            <!-- End Single Product -->
                        </div>
                        <div class="slider-frame">

                            <ul class="slider-nav">
                                <?php
                                if ($max > 1) {

                                    if (!isset($_GET['page'])) {
                                        if (isset($_POST['search'])) {
                                            $new_path_left = "search.php?page=$max&search=" . $_POST['keyword'] . "";
                                            $new_path_right = "search.php?page=2&search=" . $_POST['keyword'] . "";
                                        } else {
                                            $new_path_left = "search.php?page=$max";
                                            $new_path_right = "search.php?page=2";
                                        }
                                    } else {
                                        $p_left = $_GET['page'] - 1;
                                        $p_right = $_GET['page'] + 1;
                                        $new_path_left = isset($_GET['search']) ? "search.php?page=$p_left&search=" . $_GET['search'] . "" : "search.php?page=$p_left";
                                        $new_path_right = isset($_GET['search']) ? "search.php?page=$p_right&search=" . $_GET['search'] . "" : "search.php?page=$p_right";





                                        if ($_GET['page'] == 1) {
                                            $new_path_left = isset($_GET['search']) ? "search.php?page=$max&search=" . $_GET['search'] . "" : "search.php?page=$max";
                                        } elseif ($_GET['page'] == $max) {
                                            $new_path_right = isset($_GET['search']) ? "search.php?page=1&search=" . $_GET['search'] . "" : "search.php?page=1";
                                        }
                                    }

                                    echo '<a href="' . $new_path_left . '" id="left-icon"><i id="ng_left" class="zmdi zmdi-chevron-left" ></i></a>';

                                    $i = 1;

                                    while ($i <= $max) {
                                        $class = !isset($_GET['page']) ? "active" : "";
                                        $lien="search.php?page=$i&search=$keysearch"; 
                                        echo '
                                               <li><a href="'.$lien.'" ';
                                        if ($i == 1 && !isset($_GET['page'])) echo ' class="active" ';
                                        elseif (isset($_GET['page']) && $i == $_GET['page']) echo ' class="active" ';
                                        echo ' >' . $i . '</a></li>

                                            ';
                                        $i++;
                                    }



                                    echo '<a href="' . $new_path_right . '" ><i id="ng_right" class="zmdi zmdi-chevron-right" style="font-size: 30px;position:absolute;text-align: center;line-height:25px;margin-bottom: -2px;line-height:25px;"></i></a>';
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Bắt đầu nút Tải thêm -->
                    <div class="row mt--60">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <!-- Kết thúc nút Tải thêm -->
                </div>
            </div>
        </section>
        <!-- End Our Product Area -->
        <!-- Start Footer Area -->
        <footer class="htc__foooter__area gray-bg">
            <div class="container">
                <div class="row">
                    <div class="footer__container clearfix">
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-lg-3 col-sm-6">
                            <div class="ft__widget">
                                <div class="ft__logo">
                                    <a href="index.html">
                                        <img src="images/logo/logo.png" alt="footer logo">
                                    </a>
                                </div>
                                <div class="footer-address">
                                    <ul>
                                        <li>
                                            <div class="address-icon">
                                                <i class="zmdi zmdi-pin"></i>
                                            </div>
                                            <div class="address-text">
                                                <p>Hồ Chí Minh <br> Việt Nam</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="address-icon">
                                                <i class="zmdi zmdi-email"></i>
                                            </div>
                                            <div class="address-text">
                                                <a href="#"> info@gmail.com</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="address-icon">
                                                <i class="zmdi zmdi-phone-in-talk"></i>
                                            </div>
                                            <div class="address-text">
                                                <p>+84 123 456 789 </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="social__icon">
                                    <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-lg-2 col-sm-6 smt-30 xmt-30">
                            <div class="ft__widget">
                                <h2 class="ft__title">Danh mục</h2>
                                <ul class="footer-categories">
                                    <li><a href="shop-sidebar.html">Linh kiện</a></li>
                                    <li><a href="shop-sidebar.html">Thiết bị ngoại vi</a></li>
                                    <li><a href="shop-sidebar.html">Laptop</a></li>
                                    <li><a href="shop-sidebar.html">PC chơi game</a></li>
                                    <li><a href="shop-sidebar.html">Bộ xử lý</a></li>
                                    <li><a href="shop-sidebar.html">Lưu trữ</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-lg-2 col-sm-6 smt-30 xmt-30">
                            <div class="ft__widget">
                                <h2 class="ft__title">Thông tin</h2>
                                <ul class="footer-categories">
                                    <li><a href="about.html">Về Chúng Tôi</a></li>
                                    <li><a href="contact.html">Liên Hệ Chúng Tôi</a></li>
                                    <li><a href="#">Điều Khoản & Điều Kiện</a></li>
                                    <li><a href="#">Đổi Trả & Hoàn Tiền</a></li>
                                    <li><a href="#">Thanh Toán & Giao Hàng</a></li>
                                    <li><a href="#">Chính Sách Bảo Mật</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-3 col-lg-3 col-lg-offset-1 col-sm-6 smt-30 xmt-30">
                            <div class="ft__widget">
                                <h2 class="ft__title">Bản tin</h2>
                                <div class="newsletter__form">
                                    <p>Đăng ký nhận bản tin của chúng tôi và nhận giảm giá 10% cho đơn hàng đầu tiên của bạn.</p>
                                    <div class="input__box">
                                        <div id="mc_embed_signup">
                                            <form action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                                <div id="mc_embed_signup_scroll" class="htc__news__inner">
                                                    <div class="news__input">
                                                        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Địa chỉ email" required>
                                                    </div>
                                                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                                    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef" tabindex="-1" value=""></div>
                                                    <div class="clearfix subscribe__btn"><input type="submit" value="Gửi" name="subscribe" id="mc-embedded-subscribe" class="bst__btn btn--white__color">

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Footer Widget -->
                    </div>
                </div>
                <!-- Start Copyright Area -->
                <div class="htc__copyright__area">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="copyright__inner">
                                <div class="copyright">
                                    <p>© 2024 <a href="#">Development Team</a>
                                        All rights reserved.</p>
                                </div>
                                <ul class="footer__menu">
                                    <li><a href="index.php">Trang chủ</a></li>
                                    <li><a href="shop.php">Sản phẩm</a></li>
                                    <li><a href="contact.php">Liên hệ chúng tôi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Copyright Area -->
            </div>
        </footer>
        <!-- End Footer Area -->
    </div>
    <!-- Body main wrapper end -->
    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal__container" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-product">
                            <!-- Start product images -->
                            <div class="product-images">
                                <div class="main-image images">
                                    <img alt="big images" src="images/product/big-img/1.jpg">
                                </div>
                            </div>
                            <!-- end product images -->
                            <div class="product-info">
                                <h1>Túi Vải Đơn Giản</h1>
                                <div class="rating__and__review">
                                    <ul class="rating">
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                    </ul>
                                    <div class="review">
                                        <a href="#">4 đánh giá khách hàng</a>
                                    </div>
                                </div>
                                <div class="price-box-3">
                                    <div class="s-price-box">
                                        <span class="new-price">17.20$</span>
                                        <span class="old-price">45.00$</span>
                                    </div>
                                </div>
                                <div class="quick-desc">
                                    Được thiết kế đơn giản và làm từ vật liệu chất lượng cao. Hình dạng thanh lịch và sự kết hợp vật liệu tạo nên một vẻ ngoài hiện đại.
                                </div>
                                <div class="select__color">
                                    <h2>Chọn màu sắc</h2>
                                    <ul class="color__list">
                                        <li class="red"><a title="Đỏ" href="#">Đỏ</a></li>
                                        <li class="gold"><a title="Vàng" href="#">Vàng</a></li>
                                        <li class="orange"><a title="Cam" href="#">Cam</a></li>
                                        <li class="orange"><a title="Cam" href="#">Cam</a></li>
                                    </ul>
                                </div>
                                <div class="select__size">
                                    <h2>Chọn kích cỡ</h2>
                                    <ul class="color__list">
                                        <li class="l__size"><a title="L" href="#">L</a></li>
                                        <li class="m__size"><a title="M" href="#">M</a></li>
                                        <li class="s__size"><a title="S" href="#">S</a></li>
                                        <li class="xl__size"><a title="XL" href="#">XL</a></li>
                                        <li class="xxl__size"><a title="XXL" href="#">XXL</a></li>
                                    </ul>
                                </div>
                                <div class="social-sharing">
                                    <div class="widget widget_socialsharing_widget">
                                        <h3 class="widget-title-modal">Chia sẻ sản phẩm này</h3>
                                        <ul class="social-icons">
                                            <li><a target="_blank" title="rss" href="#" class="rss social-icon"><i class="zmdi zmdi-rss"></i></a></li>
                                            <li><a target="_blank" title="Linkedin" href="#" class="linkedin social-icon"><i class="zmdi zmdi-linkedin"></i></a></li>
                                            <li><a target="_blank" title="Pinterest" href="#" class="pinterest social-icon"><i class="zmdi zmdi-pinterest"></i></a></li>
                                            <li><a target="_blank" title="Tumblr" href="#" class="tumblr social-icon"><i class="zmdi zmdi-tumblr"></i></a></li>
                                            <li><a target="_blank" title="Pinterest" href="#" class="pinterest social-icon"><i class="zmdi zmdi-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="addtocart-btn">
                                    <a href="#">Thêm vào giỏ hàng</a>
                                </div>
                            </div><!-- .product-info -->
                        </div><!-- .modal-product -->
                    </div><!-- .modal-body -->
                </div><!-- .modal-content -->
            </div><!-- .modal-dialog -->
        </div>
        <!-- END Modal -->
    </div>
    <!-- END QUICKVIEW PRODUCT -->
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>

     <script src="js/jquery-ui.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

 <script>
        const button=document.querySelector('button[type="submit"]');
button.disabled=true;
  function autocomplete(inp, arr, arr2) {

  var currentFocus;
  
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
     
      closeAllLists();
     if(!val) {
        const button=document.querySelector('button[type="submit"]');
button.disabled=true;

     }
      currentFocus = -1;
      
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
       
      this.parentNode.appendChild(a);
      /*
      if(val.toUpperCase()=="" || val.toUpperCase()==" "  || val.toUpperCase()==" " ) {         
           const button=document.querySelector('button[type="submit"]');
button.disabled=true;
      }
*/

if( val=="" || val==" " || val=="  " || val=="   " || val=="    " || val.indexOf("    " )>-1){

    const button=document.querySelector('button[type="submit"]');
button.disabled=true;
const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Apply the stylesheet to a document:
document.adoptedStyleSheets = [sheet];

}    
else{
      var y=0;
      for (i = 0; i < arr.length; i++) { 
   for(var l=0;l<arr[i].length;l++){
        if (arr[i].substr(l, val.length).toUpperCase() == val.toUpperCase() ) {
            console.log(arr[i]);
          y++;

          l=document.createElement("a");
          l.href="product-details.php?idprod=" + arr2[i];
          ul=document.createElement("ul");
          b = document.createElement("DIV");
          b.className='good';
          li=document.createElement("li");
          li.setAttribute("class", "li_search");   
          p=document.createElement("p");
          p.setAttribute("class","p-search");

 
          p.innerHTML += "<a style='color:black;' href='product-details.php?idprod=" + arr2[i] + "'>" + arr[i] + "</a>";
          
          var iconurl =  <?php echo json_encode($arrimage); ?>;
          var img = document.createElement("img"); 
            img.src=iconurl[i];
            img.width=50;
             img.height=50;
             li.appendChild(img);
             li.appendChild(p);
             b.appendChild(li);
             l.appendChild(b);
          b.addEventListener("click", function(e) {
         
              inp.value = this.getElementsByTagName("input")[0].value;
        
              closeAllLists();
          });
          a.appendChild(l);
          
        }
}
      }
      if(y>7) {
        console.log(y);
          b.setAttribute("id", "invisible_");
          
          const sheet = new CSSStyleSheet();
           sheet.replaceSync('.autocomplete-items {height: 371px}');

// Apply the stylesheet to a document:
          document.adoptedStyleSheets = [sheet];
          const button=document.querySelector('button[type="submit"]');
          button.disabled=false;
 }
 else if(y==0) {
          b = document.createElement("DIV");
          b.className='good';
          p=document.createElement("p");
          p.setAttribute("class","p-search");

 
          p.innerHTML += "<p style='color:black;' > không có kết quả..</a>";              
             b.appendChild(p);
           
           
          b.addEventListener("click", function(e) {
         
              inp.value = this.getElementsByTagName("input")[0].value;
        
              closeAllLists();
          });
          a.appendChild(b);
    
    const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Apply the stylesheet to a document:
document.adoptedStyleSheets = [sheet];

const button=document.querySelector('button[type="submit"]');
button.disabled=true;
 }
 else {
    const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Apply the stylesheet to a document:
document.adoptedStyleSheets = [sheet];
const button=document.querySelector('button[type="submit"]');
button.disabled=false;
 }

}
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
      
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) { 
        
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
   
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

var myvar = <?php echo json_encode($arr); ?>;
var myvar2 = <?php echo json_encode($arr2); ?>;
autocomplete(document.getElementById("myInput"), myvar, myvar2);
</script>
</body>

</html>