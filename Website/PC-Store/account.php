<?php

include 'db.php';
include 'functions.php';
if (empty($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["id_user"]))
    header('Location: index.php');

$query = "SELECT * FROM client WHERE (idClient = " . $_SESSION['id_user'] . ")";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);


?>

<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>

<body>

    <!-- Bắt đầu wrapper chính của body -->
    <div class="wrapper fixed__footer">
        <!-- Bắt đầu Kiểu Header -->
        <header id="header" class="htc-header header--3 bg__white">
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
                                    <!-- Kết thúc Menu Mega đơn -->
                                    <!-- Bắt đầu Menu Mega đơn -->
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
            <!-- Kết thúc Khu vực Menu chính -->
        </header>
        <!-- Kết thúc Kiểu Header -->
        <div class="body__overlay"></div>
        <!-- Bắt đầu Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Bắt đầu Tìm kiếm Popap -->
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search__inner">
                                <form action="#" method="get">
                                    <input placeholder="Tìm kiếm ở đây... " type="text">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kết thúc Tìm kiếm Popap -->
            <!-- Bắt đầu Panel Giỏ hàng -->
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
                                <span class="shp__price">Đơn giá: ' . $prix . ' DH</span>
                            </div>
                           
                        </div></li>';
                }

                echo '</ul>
                    </div>
                    ';
                    } echo'
                    <ul class="shoping__total">
                        <li class="subtotal">Tổng phụ:</li>
                        <li class="total__price">' . $total_prix . ' DH</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart_logged_in.php">Xem giỏ hàng</a></li>
                    </ul>
                </div>
            </div>';

            } ?>
            <!-- Kết thúc Panel Giỏ hàng -->
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Tài khoản của tôi</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                                    <span class="brd-separetor">></span>
                                    <span class="breadcrumb-item active">Tài khoản của tôi</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->

        <!-- Bắt đầu tab Sản phẩm -->
        <section class="htc__product__details__tab bg__white pb--120">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <br>
                        <ul class="product__deatils__tab mb--60" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#description" role="tab" data-toggle="tab">Hồ sơ của tôi</a>
                            </li>
                            <li role="presentation">
                                <a href="#reviews" role="tab" data-toggle="tab">Đánh giá đang chờ của tôi</a>
                            </li>
                            <li role="presentation">
                                <a href="#orders" role="tab" data-toggle="tab">Danh sách yêu thích của tôi</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product__details__tab__content">
                            <!-- Bắt đầu Nội dung Đơn lẻ -->
                            <div role="tabpanel" id="description" class="product__tab__content fade in active">

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                            <div class="product__details__container">

                                                <div class="product__big__images">
                                                    <div class="portfolio-full-image tab-content">
                                                        <div role="tabpanel" class="tab-pane fade in active product-video-position" id="img-tab-1">
                                                            <img src="images/user_img.png" alt="full-image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                                            <div class="htc__product__details__inner">

                                                <form id="account-form" method="post" action="" role="form">
                                                    <div class="checkout-form">
                                                        <h2 class="section-title-3">Thông tin cá nhân</h2>

                                                        <div class="checkout-form-inner">

                                                            <div class="single-checkout-box">

                                                                <h3>Họ</h3>
                                                                <input style="margin-top:10px;" name="lastName" id="lastName" type="text" placeholder="Họ" value="<?php echo $row["nom"]; ?>" required>
                                                            </div>
                                                            <div class="single-checkout-box">
                                                                <h3>Tên</h3>
                                                                <input style="margin-top:10px;" name="firstName" id="firstName" type="text" placeholder="Tên" value="<?php echo $row["prenom"]; ?>" required>
                                                            </div>
                                                            <div class="single-checkout-box">
                                                                <h3>Email</h3>
                                                                <input style="margin-top:10px;" name="email" id="email" type="text" placeholder="email" value="<?php echo $row["email"]; ?>" required>
                                                                <span id="email-status" class="comments"></span>
                                                            </div>
                                                            <div class="single-checkout-box">
                                                                <h3>Điện thoại</h3>
                                                                <input style="margin-top:10px;" name="tel" id="tel" type="text" placeholder="tel" value="<?php echo $row["tel"]; ?>">
                                                                <span id="tel-status" class="comments"></span>
                                                            </div>
                                                            <ul class="pro__dtl__btn" style="margin-bottom:10px;">
                                                                <li class="buy__now__btn"><input type="submit" class="form-submit" value="Lưu" /></li>
                                                            </ul>
                                                            <span id="account-status" class="comments"></span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Content -->

                            <!-- Start Single Content -->
                            <div role="tabpanel" id="reviews" class="product__tab__content fade">
                                <div class="review__address__inner" >
                                    <!-- Start Single Review -->
                                    <?php
                                    $query = "SELECT * FROM commande JOIN commande_produits ON commande.idCommande = commande_produits.idCommande JOIN produit ON commande_produits.idProduit = produit.idProduit  WHERE (idClient = " . $_SESSION['id_user'] . ")";
                                    $result2 = mysqli_query($con, $query);
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        echo '<div class="pro__review style="margin: 0 auto;">
                                        <div class="review__thumb">
                                            <img src="images/' . $row2["img_prod"] . '" alt="hình ảnh đánh giá" style="height:88px; width:99px;">
                                        </div>
                                        <div class="review__details"  style="width:400px;">
                                            <div class="review__info">
                                            <br>
                                                <h4><a href="product-details.php?idprod='.$row2["idProduit"]. '">' . $row2["nom_prod"] . '</a></h4>
                                            
                                            </div>
                                            <div class="review__date">
                                                <span>Đặt hàng vào ngày ' . date('j', strtotime($row2["date_cmd"])) . ' tháng ' . date('m', strtotime($row2["date_cmd"])) . ', ' . date('Y', strtotime($row2["date_cmd"])) . ' lúc ' . date('H:i', strtotime($row2["date_cmd"])) . '</span>
                                            </div>
                                           
                                        </div>
                                        
                                        <div class="rating__send" style="margin-top: 30px;">
                                            <a data-toggle="modal" data-target="#productModal" title="Xem nhanh" class="quick-view modal-view detail-link" href="#"><i class="zmdi zmdi-star"></i></a>
                                                
                                        </div>
                                    </div><br>
                                    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal__container" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="modal-product">
                                                         <!-- Start RAting Area -->
                                                         <div class="rating__wrap">
                                                                <h2 class="rating-title">Viết đánh giá</h2><br>
                                                                <h4 class="rating-title-2">Đánh giá của bạn</h4>
                            
                                                                <form action="sendReview.php" method="POST">
                                                                <div class="rate">
                                                                    <input type="radio" id="star5" name="rate" value="5" />
                                                                    <label for="star5" title="5 sao"></label>
                                                                    <input type="radio" id="star4" name="rate" value="4" />
                                                                    <label for="star4" title="4 sao"></label>
                                                                    <input type="radio" id="star3" name="rate" value="3" />
                                                                    <label for="star3" title="3 sao"></label>
                                                                    <input type="radio" id="star2" name="rate" value="2" />
                                                                    <label for="star2" title="2 sao"></label>
                                                                    <input type="radio" id="star1" name="rate" value="1" required/>
                                                                    <label for="star1" title="1 sao"></label>
                                                                </div>                                
                                                            </div>
                                                                <input type="text" name="idProd" value="'.$row2["idProduit"].'" style = "display : none"/>
                                                            </div>
                                                            <div class="review__box">
                                                                    <div class="single-review-form">
                                                                        <div class="review-box message">
                                                                            <textarea name="review" placeholder="Viết đánh giá của bạn" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="review-btn">
                                                                        <input type="submit" class="fv-btn" value="Gửi đánh giá">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    ';
                                    }
                                    ?>
                                    <!-- End Single Review -->
                                </div>
                                <div id="quickview-wrapper">

    </div>
                            </div>
                            <!-- End Single Content -->

                            <!-- Start Single Content -->
                            <div role="tabpanel" id="orders" class="product__tab__content fade in">
                                <!-- cart-main-area start -->
                                <?php
                                $query = "SELECT * FROM envie NATURAL JOIN produit  WHERE (idClient = " . $_SESSION['id_user'] . ")";
                                $result = mysqli_query($con, $query);

                                if (mysqli_num_rows($result) == 0) {
                                    echo '   <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
                                            <div class="ht__bradcaump__wrap">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="bradcaump__inner text-center">
                                                                <nav class="bradcaump-inner">
                                                                    <span class="breadcrumb-item active">Danh sách yêu thích của bạn trống!</span>
                                                                    <a class="continuer" href="index.php">Tiếp tục mua sắm</a>  
                                                                </nav>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                } else {
                                    echo '<div id="wishlist" class="cart-main-area ptb--120 bg__white">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
            
                                                    <div class="table-content table-responsive">';

                                    echo '<table>
                                                            <thead>
                                                                <tr>
                                                                    <th class="product-thumbnail">Hình ảnh</th>
                                                                    <th class="product-name">Sản phẩm</th>
                                                                    <th class="product-price">Giá</th>
                                                                    <th class="product-subtotal">Thêm vào giỏ hàng</th>
                                                                    <th class="product-remove">Xóa</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo '<tr>';
                                                                echo '<td class="product-thumbnail"><a href="product-details.php?idprod=' . $row["idProduit"] . '"><img src="images/' . $row['img_prod'] . '" alt="hình ảnh sản phẩm" /></a></td>';
                                                                echo '<td class="product-name"><a href="product-details.php?idprod=' . $row["idProduit"] . '">' . $row['nom_prod'] . '</a></td>';
                                                                echo '<td class="product-price"><span class="amount">' . $row["prix"] * (1 - $row["promo"] / 100) . ' VND</span></td>';
                                                                echo '<td class="product-subtotal">';
                                                                if($row["stock"] > 0){
                                                                    
                                                                        echo'<form class="add-wish" method="post" action="" role="form">
                                                                            <a href="#/"><span class="ti-shopping-cart" style="font-size: 25px;"></span></a>
                                                                            <input type="text" style="display: none;" name="id_product" value="' . $row['idProduit'] . '" />
                                                                        </form>';
    
                                                                    
                                                                }
                                                                else{
                                                                         echo '<span class="comments">Hết hàng</span>';
                                                                }
                                                                echo '</td>';
                                        echo '<td class="product-remove">
                                                                    <form class="remove-wish" method="post" action="" role="form">
                                                                        <a href="#/"><span class="ti-trash" style="font-size: 25px;"></span></a>
                                                                        <input type="text" style="display: none;" name="id_product" value="' . $row['idProduit'] . '" />
                                                                    </form>
                                                                </td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>
                                                        </table>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8 col-sm-7 col-xs-12">
                                                            <div class="buttons-cart">
                                                                <input type="submit" value="Xóa danh sách yêu thích" />
                                                                <a href="index.php">Tiếp tục mua sắm</a>
                                                            </div>

                                                        </div>

                                                    </div>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                ?>
                                <!-- cart-main-area end -->
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product tab -->
        <!-- Start Footer Area -->
        <?php include 'templates/footer.php'; ?>
        <!-- Kết thúc khu vực chân trang -->
    </div>
    <!-- Kết thúc wrapper chính của body -->
    <?php include 'templates/quickview_product.php'; ?>
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
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
    <script>
      const btn = document.querySelector("button");
      const post = document.querySelector(".post");
      const widget = document.querySelector(".star-widget");
      const editBtn = document.querySelector(".edit");
      btn.onclick = ()=>{
        widget.style.display = "none";
        post.style.display = "block";
        editBtn.onclick = ()=>{
          widget.style.display = "block";
          post.style.display = "none";
        }
        return false;
      }
    </script>

</body>

</html>