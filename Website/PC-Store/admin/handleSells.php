<?php
include '../db.php';
if (empty($_SESSION)) {
    session_start();
}
$sql = "SELECT idCategorie,desp_cat,idCat_parente FROM categorie";
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
                                <a href="index.php">
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
                                <a href="handleSells.php" class="mm-active">
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
                                    <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                                    </i>
                                </div>
                                <div>Quản lý đơn hàng
                                    <div class="page-title-subheading">Theo dõi
                                        các đơn hàng đang hoạt động
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <button type="button" data-toggle="tooltip" title="Khu vực quản trị" data-placement="left" class="btn-shadow mr-3 btn btn-dark">
                                    <i class="fa fa-star"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-12">
                                
                                    <div class="card-body"><h5 class="card-title">Tất cả đơn hàng</h5>
                                    <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Tên</th>
                                                <th class="text-center">Thành phố</th>
                                                <th class="text-center">Tổng cộng (MAD)</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th class="text-center">Thay đổi trạng thái</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                //! id tên họ email và thành phố của khách hàng có đơn hàng đang hoạt động
                                                $cmdQuery = "SELECT idClient, idCommande, total_cmd FROM commande";
                                                $result = mysqli_query($con, $cmdQuery);
                                                if (!$result) {
                                                    die('Query failed: ' . mysqli_error($con));
                                                }

                                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                    $idc = $row['idClient'];
                                                    $idcmd = $row['idCommande'];
                                                    $totalcmd = $row['total_cmd'];

                                                    $infoQuery = "SELECT nom, prenom, email FROM client WHERE idClient = $idc";
                                                    $res1 = mysqli_query($con, $infoQuery);
                                                    if (!$res1) {
                                                        die('Query failed: ' . mysqli_error($con));
                                                    }
                                                    $tab1 = mysqli_fetch_array($res1);
                                                    //Added error handling 28/09/2024
                                                    //Might help with identifying where the failure occurs and prevent trying to access data from a failed query.
                                                    if (!$tab1) {
                                                        continue; // Skip if no client info found
                                                    }
                                                    $nom = $tab1['nom'];
                                                    $prenom = $tab1['prenom'];
                                                    $email = $tab1['email'];

                                                    $adrQuery = "SELECT idAdresse, statut_liv FROM livraison WHERE idCommande = $idcmd";
                                                    $res2 = mysqli_query($con, $adrQuery);
                                                    if (!$res2) {
                                                        die('Query failed: ' . mysqli_error($con));
                                                    }
                                                    $tab2 = mysqli_fetch_array($res2);
                                                    if (!$tab2) {
                                                        continue; // Skip if no delivery info found
                                                    }
                                                    $idAdr = $tab2['idAdresse'];
                                                    $statutLiv = $tab2['statut_liv'];

                                                    $adrQuery1 = "SELECT ville FROM adresse WHERE idAdresse = $idAdr";
                                                    $res3 = mysqli_query($con, $adrQuery1);
                                                    if (!$res3) {
                                                        die('Query failed: ' . mysqli_error($con));
                                                    }
                                                    $tab3 = mysqli_fetch_array($res3);
                                                    if (!$tab3) {
                                                        continue; // Skip if no address found
                                                    }
                                                    $city = $tab3['ville'];

                                                    echo '
                                                    <tr>
                                                        <td class="text-center text-muted">#'.$idc.'</td>
                                                        <td>
                                                            <div class="widget-content p-0">
                                                                <div class="widget-content-wrapper">
                                                                    <div class="widget-content-left mr-3">
                                                                        <div class="widget-content-left">
                                                                            <img width="40" class="rounded-circle" src="assets/images/avatars/avatar-client.png" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="widget-content-left flex2">
                                                                        <div class="widget-heading">'.$nom.' '.$prenom.'</div>
                                                                        <div class="widget-subheading opacity-7">'.$email.'</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">'.$city.'</td>
                                                        <td class="text-center">'.$totalcmd.'</td>
                                                        <td class="text-center">';
                                                        
                                                    if ($statutLiv == 0) {
                                                        echo '<div class="badge badge-warning">Đang chờ xử lý</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div role="group" class="btn-group-sm btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-outline-warning active">
                                                                <input type="radio" name="options" id="option1" autocomplete="off" checked>
                                                                Đang chờ xử lý
                                                            </label>
                                                            <label class="btn btn-outline-danger">
                                                                <input type="radio" name="options" id="option2" autocomplete="off">
                                                                Đang xử lý
                                                            </label>
                                                            <label class="btn btn-outline-success">
                                                                <input type="radio" name="options" id="option3" autocomplete="off">
                                                                Hoàn thành
                                                            </label>
                                                            </div>
                                                        </td>';
                                                    } elseif ($statutLiv == 1) {
                                                        echo '<div class="badge badge-success">Hoàn thành</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div role="group" class="btn-group-sm btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-outline-warning">
                                                                <input type="radio" name="options" id="option1" autocomplete="off" checked>
                                                                Đang chờ xử lý
                                                            </label>
                                                            <label class="btn btn-outline-danger">
                                                                <input type="radio" name="options" id="option2" autocomplete="off">
                                                                Đang xử lý
                                                            </label>
                                                            <label class="btn btn-outline-success active">
                                                                <input type="radio" name="options" id="option3" autocomplete="off">
                                                                Hoàn thành
                                                            </label>
                                                            </div>
                                                        </td>';
                                                    } elseif ($statutLiv == 2) {
                                                        echo '<div class="badge badge-danger">Đang xử lý</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div role="group" class="btn-group-sm btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-outline-warning">
                                                                <input type="radio" name="options" id="option1" autocomplete="off" checked>
                                                                Đang chờ xử lý
                                                            </label>
                                                            <label class="btn btn-outline-danger active">
                                                                <input type="radio" name="options" id="option2" autocomplete="off">
                                                                Đang xử lý
                                                            </label>
                                                            <label class="btn btn-outline-success">
                                                                <input type="radio" name="options" id="option3" autocomplete="off">
                                                                Hoàn thành
                                                            </label>
                                                            </div>
                                                        </td>';
                                                    }

                                                    echo '</tr>';
                                                }    
                                            ?>
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