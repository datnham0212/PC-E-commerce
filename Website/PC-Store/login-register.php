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

<?php include 'templates/head.php'; ?>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <!-- Bắt đầu Kiểu Header -->
        <?php include 'templates/header.php'; ?>
        <!-- Kết thúc Kiểu Header -->

        <div class="body__overlay"></div>
        <!-- Bắt đầu Wrapper Offset -->
        <div class="offset__wrapper">
            <!-- Bắt đầu Tìm kiếm Popap -->
            <?php include 'templates/search.php'; ?>
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