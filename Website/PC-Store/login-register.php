<?php

include 'db.php';
if (empty($_SESSION)) {
    session_start();
}

if (isset($_SESSION["id_user"]))
    header('Location: index.php');

if (isset($_SESSION['couponApplyed']))
unset($_SESSION["couponApplyed"]);

if (isset($_GET['cart']))
    $isCart = $_GET['cart'];
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
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">


    <!-- Modernizr JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/login-register.js"></script>



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

                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- Kết thúc Khu vực Menu chính -->
                        <div class="col-md-2 col-sm-4 col-xs-3">
                            <ul class="menu-extra">
                                <li class="search search__open hidden-xs"><span class="ti-search"></span></li>
                                <li><a href="login-register.php"><span class="ti-user"><?php if (isset($_SESSION["id_user"])) echo 'Đã đăng nhập';
                                                                                        else echo 'Đăng nhập'; ?></span></a></li>
                                <li class="cart__menu"><a href="cart_logged_out.php"><span class="ti-shopping-cart"></span><span class="cart-counter"><?php echo $_SESSION["cartItems"]; ?></span></a></li>
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
        <!-- Bắt đầu Wrapper Offset -->
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
        </div>
        <!-- Kết thúc Wrapper Offset -->
        <!-- Bắt đầu Khu vực Đăng nhập Đăng ký -->
        <div class="htc__login__register bg__white ptb--130" style="background: rgba(0, 0, 0, 0) url(images/bg/5.jpg) no-repeat scroll center center / cover ;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="login__register__menu" role="tablist">
                            <li role="presentation" class="login active"><a href="#login" role="tab" data-toggle="tab">Đăng nhập</a></li>
                            <li role="presentation" class="register"><a href="#register" role="tab" data-toggle="tab">Đăng ký</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Start Login Register Content -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="htc__login__register__wrap">
                            <!-- Start Single Content -->
                            <div id="login" role="tabpanel" class="single__tabs__panel tab-pane fade in active">
                                <form id="login-form" method="post" action="" role="form">
                                    <div class="form-group login">
                                        <input type="email" name="email2" id="email2" placeholder="Email">
                                        <p class="comments"></p>
                                    </div>
                                    <div class="form-group login">
                                        <input type="password" name="password2" id="password2" placeholder="Mật khẩu">
                                        <span toggle="#password2" class="zmdi zmdi-eye field-icon toggle-password"></span>
                                        <p class="comments"></p>
                                    </div>
                                    <div class="form-group htc__login__btn">
                                        <input type="text" name="isCart" style="display: none;" value="<?php echo $isCart; ?>" />
                                        <input type="submit" class="form-submit" value="Đăng nhập" />

                                    </div>
                                </form>

                                <div class="htc__social__connect">
                                    <h2>Hoặc đăng nhập bằng</h2>
                                    <ul class="htc__soaial__list">
                                        <li><a class="bg--twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>

                                        <li><a class="bg--instagram" href="#"><i class="zmdi zmdi-instagram"></i></a>
                                        </li>

                                        <li><a class="bg--facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>

                                        <li><a class="bg--googleplus" href="#"><i class="zmdi zmdi-google-plus"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            <div id="register" role="tabpanel" class="single__tabs__panel tab-pane fade">
                                <form id="register-form" method="post" action="" role="form">
                                    <div class="form-group login">
                                        <input type="text" name="name" id="name" placeholder="Họ*">
                                        <p class="comments"></p>
                                    </div>

                                    <div class="form-group login">
                                        <input type="text" name="firstname" id="firstname" placeholder="Tên*">
                                        <p class="comments"></p>
                                    </div>

                                    <div class="form-group login">
                                        <input type="email" name="email" id="email" placeholder="Email*">
                                        <p class="comments"></p>
                                    </div>

                                    <div class="form-group login">
                                        <input type="password" name="password" id="password" placeholder="Mật khẩu*">
                                        <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                                        <p class="comments"></p>
                                    </div>
                                    <div class="form-group htc__login__btn">
                                        <input type="text" name="isCart2" style="display: none;" value="<?php echo $isCart; ?>" />
                                        <input type="submit" class="form-submit" value="Tạo tài khoản" />
                                    </div>

                                </form>


                                <div class="htc__social__connect">
                                    <h2>Hoặc tạo tài khoản bằng</h2>
                                    <ul class="htc__soaial__list">
                                        <li><a class="bg--twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                        <li><a class="bg--instagram" href="#"><i class="zmdi zmdi-instagram"></i></a>
                                        </li>
                                        <li><a class="bg--facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                        <li><a class="bg--googleplus" href="#"><i class="zmdi zmdi-google-plus"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
                <!-- End Login Register Content -->
            </div>
        </div>
        <!-- End Login Register Area -->
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
                                    <li><a href="about.html">Về chúng tôi</a></li>
                                    <li><a href="contact.html">Liên hệ chúng tôi</a></li>
                                    <li><a href="#">Điều khoản & Điều kiện</a></li>
                                    <li><a href="#">Đổi trả & Hoàn tiền</a></li>
                                    <li><a href="#">Thanh toán & Giao hàng</a></li>
                                    <li><a href="#">Chính sách bảo mật</a></li>
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