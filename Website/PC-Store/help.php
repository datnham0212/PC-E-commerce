<?php
if (empty($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["id_user"]))
    header('Location: index.php');

if (isset($_SESSION['couponApplyed']))
    unset($_SESSION["couponApplyed"]);

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
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">


    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

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
                                <?php
                                if (isset($_SESSION["id_user"])) {
                                    echo '<li><a href="account.php"><span class="ti-user">' . $_SESSION["userFirstName"] . '</span></a></li>';
                                } else {
                                    echo '<li><a href="login-register.php"><span class="ti-user">Đăng nhập</span></a></li>';
                                }
                                ?>
                                <li class="cart__menu"><span class="ti-shopping-cart"></span><span class='cart-counter'><?php echo $_SESSION['cartItems']; ?></span></li>
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
            <!-- End Search Popap -->
            <!-- Start Offset MEnu -->
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
                        <p>Viết gì ở đây?</p>
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
            <!-- End Offset MEnu -->
            <!-- Start Cart Panel -->
            <div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="images/product/sm-img/1.jpg" alt="hình ảnh sản phẩm">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.html">Loa không dây BO&Play</a></h2>
                                <span class="quantity">SL: 1</span>
                                <span class="shp__price">105.000đ</span>
                            </div>
                            <div class="remove__btn">
                                <a href="#" title="Xóa mục này"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="images/product/sm-img/2.jpg" alt="hình ảnh sản phẩm">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.html">Nến Brone</a></h2>
                                <span class="quantity">SL: 1</span>
                                <span class="shp__price">25.000đ</span>
                            </div>
                            <div class="remove__btn">
                                <a href="#" title="Xóa mục này"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>
                    </div>
                    <ul class="shoping__total">
                        <li class="subtotal">Tổng phụ:</li>
                        <li class="total__price">130.000đ</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart.html">Xem giỏ hàng</a></li>
                        <li class="shp__checkout"><a href="checkout.html">Thanh toán</a></li>
                    </ul>
                </div>
            </div>
            <!-- Kết thúc Bảng điều khiển giỏ hàng -->
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Trợ giúp</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                                    <span class="brd-separetor">/</span>
                                    <span class="breadcrumb-item active">Trợ giúp</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu khu vực Liên hệ -->
        <section class="htc__contact__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="htc__contact__container">
                            
                            <style>
                            .dropdown {
                                position: relative;
                                display: inline-block;
                                width: 100%;
                                margin-bottom: 15px;
                            }
                            
                            .dropdown-toggle {
                                width: 100%;
                                padding: 10px 15px;
                                background-color: #f8f8f8;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                cursor: pointer;
                                text-align: left;
                                font-size: 16px;
                            }
                            
                            .dropdown-toggle::after {
                                content: '\25BC';
                                float: right;
                            }
                            
                            .dropdown-menu {
                                display: none;
                                position: absolute;
                                background-color: #f9f9f9;
                                min-width: 100%;
                                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                                z-index: 1;
                                border-radius: 0 0 4px 4px;
                            }
                            
                            .dropdown-menu a {
                                color: black;
                                padding: 12px 16px;
                                text-decoration: none;
                                display: block;
                            }
                            
                            .dropdown-menu a:hover {
                                background-color: #f1f1f1;
                            }
                            
                            .show {
                                display: block;
                            }
                            </style>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown1')" class="dropdown-toggle">Câu hỏi thường gặp</button>
                                <div id="dropdown1" class="dropdown-menu">
                                    <a href="#">Làm thế nào để đặt hàng?</a>
                                    <a href="#">Chính sách đổi trả</a>
                                    <a href="#">Thời gian giao hàng</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown2')" class="dropdown-toggle">Phương thức thanh toán</button>
                                <div id="dropdown2" class="dropdown-menu">
                                    <a href="#">Thẻ tín dụng</a>
                                    <a href="#">Chuyển khoản ngân hàng</a>
                                    <a href="#">Thanh toán khi nhận hàng</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown3')" class="dropdown-toggle">Vận chuyển</button>
                                <div id="dropdown3" class="dropdown-menu">
                                    <a href="#">Phí vận chuyển</a>
                                    <a href="#">Thời gian vận chuyển</a>
                                    <a href="#">Khu vực giao hàng</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown4')" class="dropdown-toggle">Tài khoản</button>
                                <div id="dropdown4" class="dropdown-menu">
                                    <a href="#">Đăng ký tài khoản</a>
                                    <a href="#">Quên mật khẩu</a>
                                    <a href="#">Cập nhật thông tin</a>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button onclick="toggleDropdown('dropdown5')" class="dropdown-toggle">Liên hệ</button>
                                <div id="dropdown5" class="dropdown-menu">
                                    <a href="#">Gửi email</a>
                                    <a href="#">Gọi điện thoại</a>
                                    <a href="#">Chat trực tuyến</a>
                                </div>
                            </div>
                            
                            <script>
                            function toggleDropdown(id) {
                                document.getElementById(id).classList.toggle("show");
                            }
                            
                            window.onclick = function(event) {
                                if (!event.target.matches('.dropdown-toggle')) {
                                    var dropdowns = document.getElementsByClassName("dropdown-menu");
                                    for (var i = 0; i < dropdowns.length; i++) {
                                        var openDropdown = dropdowns[i];
                                        if (openDropdown.classList.contains('show')) {
                                            openDropdown.classList.remove('show');
                                        }
                                    }
                                }
                            }
                            </script>
                            
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                        
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Area -->
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
                                    <li><a href="shop-sidebar.html">PC gaming</a></li>
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
                                    <p>© 2024 <a href="#">Developer Team</a>
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
                <!-- Kết thúc khu vực bản quyền -->
            </div>
        </footer>
        <!-- Kết thúc khu vực chân trang -->
    </div>
    <!-- Kết thúc wrapper chính của body -->
    <!-- XEM NHANH SẢN PHẨM -->
    <div id="quickview-wrapper">
        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal__container" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-product">
                            <!-- Bắt đầu hình ảnh sản phẩm -->
                            <div class="product-images">
                                <div class="main-image images">
                                    <img alt="hình ảnh lớn" src="images/product/big-img/1.jpg">
                                </div>
                            </div>
                            <!-- kết thúc hình ảnh sản phẩm -->
                            <div class="product-info">
                                <h1>Túi vải đơn giản</h1>
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
                                    Được thiết kế đơn giản và làm từ vật liệu chất lượng cao. Hình dạng thanh lịch và sự kết hợp vật liệu tạo nên vẻ ngoài hiện đại.
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
                                    <h2>Chọn kích thước</h2>
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