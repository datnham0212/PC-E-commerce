<?php
include '../db.php';
if (empty($_SESSION)) {
    session_start();
}

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
                                    <i class="pe-7s-upload text-success">
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
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Thêm sản phẩm vào cơ sở dữ liệu</h5>
                            <form id="addProd-form" method="post" action="upload.php" enctype="multipart/form-data">
                                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Tên sản phẩm</label>
                                    <div class="col-sm-10"><input name="nomProd" id="exampleEmail" placeholder="ví dụ: Màn hình MSI" type="text" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Giá (MAD)</label>
                                    <div class="col-sm-10"><input name="prixProd" id="exampleEmail" placeholder="ví dụ: 3400" type="text" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Số lượng</label>
                                    <div class="col-sm-10"><input name="stockProd" id="exampleEmail" placeholder="ví dụ: 120" type="text" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-2 col-form-label">Khuyến mãi (%)</label>
                                    <div class="col-sm-10"><input name="promo" id="exampleEmail" placeholder="ví dụ: 15" type="text" class="form-control"></div>
                                </div>
                                <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Mô tả sản phẩm</label>
                                    <div class="col-sm-10"><textarea name="descrProd" id="exampleText" class="form-control"></textarea></div>
                                </div>
                                <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Danh mục</label>
                                    <div class="col-sm-10"><select name="selectCat" id="exampleSelect" class="form-control">
                                            <?php
                                            $sql = "SELECT idCategorie,desp_cat FROM categorie";
                                            $result = mysqli_query($con, $sql);
                                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                echo '<option value="' . $row['idCategorie'] . '">' . $row['desp_cat'] . '</option>';
                                            }
                                            ?>
                                        </select></div>
                                </div>
                                <div class="position-relative row form-group"><label for="exampleFile" class="col-sm-2 col-form-label">Hình ảnh</label>
                                    <div class="col-sm-10"><input name="file" id="imageProd" type="file" accept="image/png, image/jpg, image/jpeg" class="form-control-file">
                                        <small class="form-text text-muted">Chèn một hình ảnh hiển thị rõ ràng sản phẩm</small>
                                    </div>
                                </div>
                                <div class="position-relative row form-check">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button name="addP" type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/scripts/main.js"></script>
</body>

</html>