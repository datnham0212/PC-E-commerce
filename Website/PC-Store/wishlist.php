<?php
if (empty($_SESSION)) {
    session_start();
}
?>
<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <!-- Start Header Style -->
        <header id="header" class="htc-header header--3 bg__white">
            <!-- Start Mainmenu Area -->
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
                        <!-- Start MAinmenu Ares -->
                        <div class="col-md-8 col-lg-8 col-sm-6 col-xs-6">
                            <nav class="mainmenu__nav hidden-xs hidden-sm">
                                <ul class="main__menu">
                                    <li class="drop"><a href="index.php">Trang chủ</a></li>

                                    <li class="drop"><a href="shop.php">Sản phẩm của chúng tôi</a>
                                    </li>
                                    <li><a href="help.php">Trợ giúp</a></li>
                                    <li><a href="contact.php">Liên hệ</a></li>
                                    <?php if (isset($_SESSION["id_user"])) echo '<li><a href="destroy.php">Đăng xuất</a></li>'; ?>
                                    <!-- End Single Mega MEnu -->
                                    <!-- Start Single Mega MEnu -->
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
                        <!-- End MAinmenu Ares -->
                        <div class="col-md-2 col-sm-4 col-xs-3">
                            <ul class="menu-extra">
                                <li class="search search__open hidden-xs"><span class="ti-search"></span></li>
                                <li><a href="login-register.php"><span class="ti-user"><?php if (isset($_SESSION["id_user"])) echo 'Đã đăng nhập';
                                                                                        else echo 'Đăng nhập'; ?></span></a></li>

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
        <!-- Bắt đầu Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Bắt đầu Tìm kiếm Popap -->
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search__inner">
                                <form action="#" method="get">
                                    <input placeholder="Tìm kiếm tại đây... " type="text">
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
            <!-- Bắt đầu Menu Offset -->
            <div class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="off__contact">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images/logo/logo.png" alt="logo">
                            </a>
                        </div>
                        <p>Thêm gì vày đây?</p>
                    </div>
                    <ul class="sidebar__thumd">
                        <li><a href="#"><img src="images/sidebar-img/1.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/2.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/3.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/4.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/5.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/6.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/7.jpg" alt="hình ảnh thanh bên"></a></li>
                        <li><a href="#"><img src="images/sidebar-img/8.jpg" alt="hình ảnh thanh bên"></a></li>
                    </ul>
                    <div class="offset__widget">
                        <div class="offset__single">
                            <h4 class="offset__title">Ngôn ngữ</h4>
                            <ul>
                                <li><a href="#"> Tiếng Anh </a></li>
                                <li><a href="#"> Tiếng Pháp </a></li>
                                <li><a href="#"> Tiếng Đức </a></li>
                            </ul>
                        </div>
                        <div class="offset__single">
                            <h4 class="offset__title">Tiền tệ</h4>
                            <ul>
                                <li><a href="#"> USD : Đô la </a></li>
                                <li><a href="#"> EUR : Euro </a></li>
                                <li><a href="#"> POU : Bảng Anh </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="offset__sosial__share">
                        <h4 class="offset__title">Theo dõi chúng tôi trên mạng xã hội</h4>
                        <ul class="off__soaial__link">
                            <li><a class="bg--twitter" href="#" title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>

                            <li><a class="bg--instagram" href="#" title="Instagram"><i class="zmdi zmdi-instagram"></i></a></li>

                            <li><a class="bg--facebook" href="#" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>

                            <li><a class="bg--googleplus" href="#" title="Google Plus"><i class="zmdi zmdi-google-plus"></i></a></li>

                            <li><a class="bg--google" href="#" title="Google"><i class="zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Kết thúc Menu Offset -->

            <!-- Bắt đầu Bảng điều khiển Giỏ hàng -->
            <?php if (isset($_SESSION["id_user"])) {
                echo
                    '<div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                        <ul id="ticker">';
                $total_prix = 0;
                $query = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient=1 ");
                $num_Line = mysqli_num_rows($query);
                while ($rowp = mysqli_fetch_array($query)) {
                    $image = $rowp["img_prod"];
                    $prix = $rowp['prix'] * (1 - $rowp['promo'] / 100);
                    $total_prix += $prix * $rowp['quantite'];
                    echo '
                    	    <li> <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="product-details.php">
                                    <img src="images/' . $image . '" alt="hình ảnh sản phẩm" style="width:265px;Height:67px;">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.php" style="text-transform: uppercase;">' . $rowp['nom_prod'] . '</a></h2>
                                <span class="quantity">Số lượng: ' . $rowp['quantite'] . '</span>
                                <span class="shp__price">Đơn giá: ' . $prix . ' VNĐ</span>
                            </div>
                           
                        </div></li>';
                }

                echo '</ul>
                    </div>
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
        <!-- Kết thúc Wrapper Offset -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Danh sách yêu thích</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                                    <span class="brd-separetor">/</span>
                                    <span class="breadcrumb-item active">Danh sách yêu thích</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu khu vực danh sách yêu thích -->
        <div class="wishlist-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                            <form action="#">
                                <div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-remove"><span class="nobr">Xóa</span></th>
                                                <th class="product-thumbnail">Hình ảnh</th>
                                                <th class="product-name"><span class="nobr">Tên sản phẩm</span></th>
                                                <th class="product-price"><span class="nobr"> Đơn giá </span></th>
                                                <th class="product-stock-stauts"><span class="nobr"> Tình trạng kho </span></th>
                                                <th class="product-add-to-cart"><span class="nobr">Thêm vào giỏ hàng</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="product-remove"><a href="#">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img src="images/product/4.png" alt="" /></a></td>
                                                <td class="product-name"><a href="#">Sản phẩm 1</a></td>
                                                <td class="product-price"><span class="amount">165.000 VNĐ</span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock">Còn hàng</span></td>
                                                <td class="product-add-to-cart"><a href="#"> Thêm vào giỏ hàng</a></td>
                                            </tr>
                                            <tr>
                                                <td class="product-remove"><a href="#">×</a></td>
                                                <td class="product-thumbnail"><a href="#"><img src="images/product/5.png" alt="" /></a></td>
                                                <td class="product-name"><a href="#">Sản phẩm 2</a></td>
                                                <td class="product-price"><span class="amount">50.000 VNĐ</span></td>
                                                <td class="product-stock-status"><span class="wishlist-in-stock">Còn hàng</span></td>
                                                <td class="product-add-to-cart"><a href="#"> Thêm vào giỏ hàng</a></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="wishlist-share">
                                                        <h4 class="wishlist-share-title">Chia sẻ trên:</h4>
                                                        <div class="social-icon">
                                                            <ul>
                                                                <li><a href="#"><i class="zmdi zmdi-rss"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-vimeo"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-tumblr"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                                                                <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wishlist-area end -->
        <!-- Start Footer Area -->
        <?php include 'templates/footer.php'; ?>
        <!-- End Footer Area -->
    </div>
    <!-- Body main wrapper end -->
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

</body>

</html>