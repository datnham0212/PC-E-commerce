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

<?php include 'templates/head.php'; ?>

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
            <?php include 'templates/search.php'; ?>
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

</body>

</html>