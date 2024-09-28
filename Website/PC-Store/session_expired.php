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
<html class="no-js" lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>FANABLO</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Đặt favicon.ico trong thư mục gốc -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">


    <!-- Tất cả các tệp css được bao gồm ở đây. -->
    <!-- CSS framework Bootstrap chính -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- CSS chính của Owl Carousel -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- Tệp core.css này chứa tất cả các tệp css của plugin. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Kiểu shortcodes/elements của chủ đề -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Kiểu chính của chủ đề -->
    <link rel="stylesheet" href="style.css">
    <!-- CSS đáp ứng -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Kiểu của người dùng -->
    <link rel="stylesheet" href="css/custom.css">


    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">Bạn đang sử dụng một trình duyệt <strong>lỗi thời</strong>. Vui lòng <a href="http://browsehappy.com/">nâng cấp trình duyệt của bạn</a> để cải thiện trải nghiệm.</p>
    <![endif]-->

    <!-- Bắt đầu wrapper chính của body -->
    <div class="wrapper fixed__footer">
        
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
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">PHIÊN ĐÃ HẾT HẠN</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.php">Trang chủ</a>
                                    <span class="brd-separetor">|</span>
                                    <a class="breadcrumb-item" href="cart_logged_in.php">Giỏ hàng</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        
    </div>
    <!-- Kết thúc wrapper chính của body -->
    <!-- Đặt js ở cuối tài liệu để các trang tải nhanh hơn -->

    <!-- phiên bản jquery mới nhất -->
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <!-- JS framework Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Tất cả các plugin js được bao gồm trong tệp này. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Tệp js chính chứa tất cả các kích hoạt plugin jQuery. -->
    <script src="js/main.js"></script>

</body>

</html>