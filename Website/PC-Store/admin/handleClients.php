<?php

use PHPMailer\PHPMailer\PHPMailer;

include '../db.php';
require('PHPMailer-master/src/PHPMailer.php');
require('PHPMailer-master/src/SMTP.php');
require('PHPMailer-master/src/Exception.php');
if (empty($_SESSION)) {
    session_start();
}
$sql = "SELECT idClient,nom,prenom,email FROM client";
$result = mysqli_query($con, $sql);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="./main.css" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                </div>
                                <img width="42" class="rounded-circle" src="assets/images/avatars/avatar-admin.png" alt="">
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <?php echo $_SESSION["userName"] . ' ' . $_SESSION["userFirstName"] ?>
                                    </div>
                                    <div class="widget-subheading">
                                        Admin
                                    </div>
                                </div>
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                        <li class="app-sidebar__heading">Tổng quan</li>
                            <li>
                                <a href="index.html" class="mm-active">
                                    <i class="metismenu-icon pe-7s-rocket"></i>
                                    Thông tin chung
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Danh mục</li>
                            <li>
                                <a href="addCategorie.php">
                                    <i class="metismenu-icon pe-7s-diamond"></i>
                                    Thêm danh mục
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>
                            <li>
                                <a href="handleCategories.php">
                                    <i class="metismenu-icon pe-7s-car"></i>
                                    Quản lý danh mục
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Sản phẩm</li>
                            <li>
                                <a href="addProduct.php">
                                    <i class="metismenu-icon pe-7s-eyedropper"></i>
                                    Thêm sản phẩm
                                </a>
                                <a href="handleProducts.php">
                                    <i class="metismenu-icon pe-7s-display2"></i>
                                    Quản lý sản phẩm
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Khách hàng</li>
                            <li>
                                <a href="handleClients.php">
                                    <i class="metismenu-icon pe-7s-mouse">
                                    </i>Quản lý khách hàng
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Đơn hàng</li>
                            <li>
                                <a href="handleSells.php">
                                    <i class="metismenu-icon pe-7s-graph2">
                                    </i>Quản lý đơn hàng
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Đăng xuất</li>
                            <li>
                                <a href="../destroy.php">
                                    <i class="metismenu-icon pe-7s-power">
                                    </i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-users icon-gradient bg-happy-itmeo">
                                    </i>
                                </div>
                                <div>Bảng điều khiển
                                    <div class="page-title-subheading">Quản lý khách hàng, đơn hàng và nội dung trang web của bạn.
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <button type="button" data-toggle="tooltip" title="Espace Admin" data-placement="left" class="btn-shadow mr-3 btn btn-dark">
                                    <i class="fa fa-star"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-body"><h5 class="card-title">Tất cả khách hàng</h5>
                                        <table class="mb-0 table table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Họ</th>
                                                <th>Tên</th>
                                                <th>Email</th>
                                                <th>Khách hàng thân thiết</th>
                                                <th>Cấm</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <form action="handleClients.php" method="POST">
                                            <?php
                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                    $idClient = $row['idClient'];
                                                    $sqlfid = "SELECT idClient FROM client_fidele WHERE idClient=$idClient";
                                                    $resultfid = mysqli_query($con, $sqlfid);
                                                    echo '
                                                    <tr>
                                                            <th scope="row">'.$row['idClient'].'</th>
                                                            <td>'.$row['nom'].'</td>
                                                            <td>'.$row['prenom'].'</td>
                                                            <td>'.$row['email'].'</td>';
                                                    if (mysqli_num_rows($resultfid) > 0){
                                                        echo '<th><button type="submit"  class="mb-2 mr-2 btn-transition btn btn-outline-success disabled" disabled><i class="pe-7s-check" aria-hidden="true"></i></button></th>';}
                                                    else {
                                                        echo '<th><button type="submit" name="fidC'.$row['idClient'].'"  class="mb-2 mr-2 btn-transition btn btn-outline-success"><i class="pe-7s-star" aria-hidden="true"></i></button></th>';
                                                    }
                                                        echo '<th><button type="submit" name="banC'.$row['idClient'].'"  class="mb-2 mr-2 btn-transition btn btn-outline-danger"><i class="pe-7s-trash" aria-hidden="true"></i></button></th>
                                                            </tr>';
                                                    if(array_key_exists('banC'.$row['idClient'], $_POST)) { 
                                                        $delQuery = "DELETE FROM client WHERE idClient = $idClient";
                                                        $resDel = mysqli_query($con, $delQuery);
                                                        // Mã gửi email
                                                        require_once __DIR__ . '/PHPMailer-master/src/Exception.php';
                                                        require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
                                                        require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';

                                                        // Truyền true vào hàm khởi tạo để bật ngoại lệ trong PHPMailer
                                                        $mail = new PHPMailer(true);

                                                        try {
                                                            $mail->isSMTP();
                                                            $mail->SMTPOptions = array(
                                                                'ssl' => array(
                                                                'verify_peer' => false,
                                                                'verify_peer_name' => false,
                                                                'allow_self_signed' => true
                                                                )
                                                                );
                                                            $mail->Host = 'smtp.gmail.com';
                                                            $mail->SMTPAuth = true;
                                                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                                            $mail->Port = 587;

                                                            $mail->Username = 'labnotifyer@gmail.com'; // email gmail
                                                            $mail->Password = 'labnotifyer1.0'; // mật khẩu gmail

                                                            // Cài đặt người gửi và người nhận
                                                            $mail->setFrom('labnotifyer@gmail.com', 'FANABLO');
                                                            $mail->addAddress('zakariaziani99@gmail.com'); // thay thế bằng $row['email']
                                                            $mail->addReplyTo('labnotifyer@gmail.com', 'FANABLO'); // để đặt địa chỉ trả lời

                                                            // Cài đặt nội dung email
                                                            $mail->IsHTML(true);
                                                            $mail->Subject = "Bị cấm từ cửa hàng trực tuyến FANABLO";
                                                            $mail->Body = 'Xin chào '.$row['nom'].'. <br><b>FANABLO</b><br>Bạn đã bị cấm từ FANABLO.<br> Điều này có thể xảy ra do nhiều lý do.<br> Nếu bạn nghĩ đây là một sai sót, vui lòng liên hệ support@fanablo.com.';
                                                            //$mail->AltBody = 'Nội dung tin nhắn văn bản thuần túy cho client email không hỗ trợ HTML. Nội dung email SMTP Gmail.';

                                                            $mail->send();
                                                            echo "Đã gửi email thành công.";
                                                        } catch (Exception $e) {
                                                            echo "Lỗi khi gửi email. Lỗi Mailer: {$mail->ErrorInfo}";
                                                        }
                                                        ?>
                                                        <script>
                                                            location.reload(true);
                                                        </script>
                                                        <?php
                                                    }
                                                    if(array_key_exists('fidC'.$row['idClient'], $_POST)) { 
                                                            $insQuery = "INSERT INTO client_fidele (idClient) VALUES ($idClient);";
                                                            $resIns = mysqli_query($con, $insQuery);
                                                            // Mã gửi email
                                                            require_once __DIR__ . '/PHPMailer-master/src/Exception.php';
                                                            require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
                                                            require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
    
                                                            // Truyền true vào hàm khởi tạo để bật ngoại lệ trong PHPMailer
                                                            $mail = new PHPMailer(true);
    
                                                            try {
                                                                $mail->isSMTP();
                                                                $mail->SMTPOptions = array(
                                                                    'ssl' => array(
                                                                    'verify_peer' => false,
                                                                    'verify_peer_name' => false,
                                                                    'allow_self_signed' => true
                                                                    )
                                                                    );
                                                                $mail->Host = 'smtp.gmail.com';
                                                                $mail->SMTPAuth = true;
                                                                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                                                $mail->Port = 587;
    
                                                                $mail->Username = 'labnotifyer@gmail.com'; // email gmail
                                                                $mail->Password = 'labnotifyer1.0'; // mật khẩu gmail
    
                                                                // Cài đặt người gửi và người nhận
                                                                $mail->setFrom('labnotifyer@gmail.com', 'FANABLO');
                                                                $mail->addAddress('zakariaziani99@gmail.com'); // thay thế bằng $row['email']
                                                                $mail->addReplyTo('labnotifyer@gmail.com', 'FANABLO'); // để đặt địa chỉ trả lời
    
                                                                // Cài đặt nội dung email
                                                                $mail->IsHTML(true);
                                                                $mail->Subject = "Chúc mừng! Bạn đã trở thành khách hàng đặc biệt";
                                                                $mail->Body = 'Xin chào '.$row['nom'].'. <br>Cửa hàng trực tuyến <b>FANABLO</b> rất vui mừng thông báo rằng bạn hiện là một trong những khách hàng đặc biệt của chúng tôi.<br>Bạn sẽ được hưởng những ưu đãi thú vị và phiếu giảm giá đặc biệt.';
                                                                //$mail->AltBody = 'Nội dung tin nhắn văn bản thuần túy cho client email không hỗ trợ HTML. Nội dung email SMTP Gmail.';
    
                                                                $mail->send();
                                                            } catch (Exception $e) {
                                                                echo "Lỗi khi gửi email. Lỗi Mailer: {$mail->ErrorInfo}";
                                                            }
                                                            echo "<meta http-equiv='refresh' content='0'>";
                                                    }
                                                    }
                                                ?>
                                                    
                                                
                                            </tbody>
                                        </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-right">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link">
                                PC Store
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/scripts/main.js"></script>
</body>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>