<?php
if (empty($_SESSION)) {
    session_start();
}
include 'db.php';
include('functions.php');
if (!isset($_SESSION['cartItems'])) {
    $_SESSION['cartItems'] = 0;
}

?>

<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>
    
    <?php
    if (isset($_SESSION["id_user"])) {
        $query_n = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient= " . $_SESSION["id_user"] . " ");
        $num_Line = mysqli_num_rows($query_n);
        if ($num_Line > 2) { ?>
            <script src="js/recipe2.js" type="text/javascript"></script>
    <?php  }
    }
    ?>


<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <!-- Start Header Style -->
        <?php include 'templates/header.php'; ?>
        <!-- End Header Style -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <?php include 'templates/search.php'; ?>
            <?php
            $arr = array();

            $arr2 = array();
            $query = "SELECT * FROM produit ";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $arr[] = $row['nom_prod'];
                    $arr2[] = $row["idProduit"];
                    $path = "images/" . $row['img_prod'] . "";
                    $arrimage[] = $path;
                }
            }
            ?>

            <!-- End Search Popap -->

            <!-- Start Cart Panel -->
            <?php include 'templates/shopping_cart.php'; ?>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Feature Product -->
        <section class="categories-slider-area bg__white">
            <div class="container">
                <div class="row">
                    <!-- Start Left Feature -->
                    <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12 float-left-style">
                        <!-- Start Slider Area -->
                        <div class="slider__container slider--one">
                            <div class="slider__activation__wrap owl-carousel owl-theme">
                                <!-- Start Single Slide -->
                                <div class="slide slider__full--screen slider-height-inherit slider-text-right" style="background: rgba(0, 0, 0, 0) url(images/slider/shopPc.jpg) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-10 col-lg-8 col-md-offset-2 col-lg-offset-4 col-sm-12 col-xs-12">
                                                <div class="slider__inner">
                                                    <h1>Sản phẩm mới <span class="text--theme">Bộ sưu tập</span></h1>
                                                    <div class="slider__btn">
                                                        <a class="htc__btn" href="shop.php">Mua ngay</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slide -->
                                <!-- Start Single Slide -->
                                <div class="slide slider__full--screen slider-height-inherit  slider-text-left" style="background: rgba(0, 0, 0, 0) url(images/slider/phones.jpg) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                                <div class="slider__inner">
                                                    <h1>Sản phẩm mới <span class="text--theme">Bộ sưu tập</span></h1>
                                                    <div class="slider__btn">
                                                        <a class="htc__btn" href="shop.php">Mua ngay</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide slider__full--screen slider-height-inherit  slider-text-left" style="background: rgba(0, 0, 0, 0) url(images/slider/camera.png) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                                <div class="slider__inner">
                                                    <h1>Sản phẩm mới <span class="text--theme">Bộ sưu tập</span></h1>
                                                    <div class="slider__btn">
                                                        <a class="htc__btn" href="shop.php">Mua ngay</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Slide -->
                            </div>
                        </div>
                        <!-- Start Slider Area -->
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 float-right-style">
                        <div class="categories-menu mrg-xs">
                            <div class="category-heading">
                                <h3>Danh mục của chúng tôi</h3>
                            </div>
                            <div class="category-menu-list">
                                <ul> <?php
                                        $query = "select * from categorie where idCat_parente=0";
                                        $run = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_array($run)) {
                                            $query1 = "select * from categorie where idCat_parente=" . $row['idCategorie'] . "";
                                            $run1 = mysqli_query($con, $query1);
                                            $total1 = mysqli_num_rows($run1);
                                            echo '
                                                        <li><a href="shop.php?idCat=' . $row['idCategorie'] . '">' . $row['desp_cat'] . ' ';
                                            if ($total1 > 1) {
                                                echo ' <i class="zmdi zmdi-chevron-right"></i></a>
                                                     <div class="category-menu-dropdown" style="width:300px;" >
                                                     <div class="category-part-3 category-common mb--30" style="width:100%;color:black;green;margin-top:-40px;margin-bottom:-40px;"> 
                                                     <ul>';

                                                while ($row1 = mysqli_fetch_array($run1)) {
                                                    echo '<li><a href="shop.php?idCat=' . $row1['idCategorie'] . '" >' . $row1['desp_cat'] . ' </a></li>';
                                                }
                                                echo '
                                                        </ul>
                                            </div>
                                            
                                           
                                        </div> ';
                                            } else echo '</a>';

                                            echo '</li>';
                                        }

                                        ?>





                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End Left Feature -->
                </div>
            </div>
        </section>
        <!-- End Feature Product -->
        <div class="only-banner ptb--100 bg__white">
            <div class="container">
                <div class="only-banner-img">
                    <a href="shop-sidebar.html"><img src="images/new-product/gaming.png" alt="new product"></a>
                </div>
            </div>
        </div>


        <?php
        $i = 0;
        $i1 = 1;
        $i2 = 2;
        $i3 = 3;

        $statement = mysqli_query($con, "select * from categorie where idCat_parente=0");

        while ($line = mysqli_fetch_array($statement)) {
            $query = "select * from categorie where idCat_parente=" . $line['idCategorie'] . "";
            $run = mysqli_query($con, $query);
            if (mysqli_num_rows($run) != 0) {
                echo ' 
         <!-- Start Our Product Area -->
         <section class="htc__product__area bg__white" id="cat_redirect' . $i . '">
            <div class="container">
                <div class="row" >
                    <div class="col-md-3">
                        <div class="product-categories-all">
                            <div class="product-categories-title">
                                <h3><a href="index.php?category=' . $line['idCategorie'] . '#cat_redirect' . $i . '">' . $line['desp_cat'] . '</a></h3>
                            </div>
                            <div class="product-categories-menu">
                                <ul>';
                while ($row = mysqli_fetch_array($run)) {
                    echo '<li ><a class="category-hover-' . $row['idCategorie'] . '" href="index.php?category=' . $row['idCategorie'] . '#cat_redirect' . $i . '"
                                               ';
                    if (isset($_GET['category']) && $_GET['category'] == $row['idCategorie'])  echo 'style="color:red;"';
                    echo ' >' . $row['desp_cat'] . ' </a></li>';
                }

                echo '       </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="product-style-tab">
                            <div class="product-tab-list">
                                <!-- Nav tabs -->
                                <ul class="tab-style" role="tablist">
                                    <li class="active">
                                        <a href="#home' . $i1 . '" data-toggle="tab">
                                            <div class="tab-menu-text">
                                                <h4>Mới</h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#home' . $i2 . '" data-toggle="tab">
                                            <div class="tab-menu-text">
                                                <h4>Bán chạy nhất</h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#home' . $i3 . '" data-toggle="tab">
                                            <div class="tab-menu-text">
                                                <h4>Đánh giá tốt nhất</h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="shop.php?idCat=' . $line['idCategorie'] . '" >
                                            <div class="tab-menu-text">
                                                <h4>Tất cả sản phẩm</h4>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content another-product-style jump">
                                <div class="tab-pane active" id="home' . $i1 . '">
                                    <div class="row">
                                    <div class="product-slider-active owl-carousel"> ';


                if (isset($_GET['category']) && getParent($_GET['category']) == $line['idCategorie']) {
                    if (getParent($_GET['category']) == $line['idCategorie'])
                        $run = mysqli_query($con, "SELECT * from produit where idCategorie=" . $_GET['category'] . " and stock>0 ");
                } else {
                    $run = mysqli_query($con, "select * from produit join categorie on categorie.idCategorie=produit.idCategorie where idCat_parente=" . $line['idCategorie'] . " and stock>0 ");
                }


                while ($row = mysqli_fetch_array($run)) {
                    $image = "images/" . $row['img_prod'] . "";
                    $new_price = $row['prix'] * (1 - $row['promo'] * 0.01);
                    echo '
                                  
                                            <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="product-details.php?idprod=' . $row['idProduit'] . '">
                                                                <img src="' . $image . '" alt="product images">
                                                            </a>
                                                        </div>';
                    if (isset($_SESSION["id_user"])) {
                        $query2 = "SELECT idProduit FROM envie WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
                        $result2 = mysqli_query($con, $query2);
                        echo '<div class="product__hover__info">
                                                                <ul class="product__action">';
                        if (mysqli_num_rows($result2) == 0) {

                            echo '<li><a title="Ajouter ♥" class="add" href="#/"><span class="ti-heart"></span></a></li>';
                        } else {
                            echo '<li><a title="Ajouté ♥" href="#/"><span class="ti-check-box" style="font-size: 25x; color: red;">Favori</span></a></li>';
                        }


                        echo ' </ul>
                                                               <form class="add-wish" method="post" action="" role="form">  
                                                                    <input type="text" style="display: none;" name="id_product" value="' . $row["idProduit"] . '" />
                                                                </form>
                                                            </div>';
                                                             if($row['promo']!=0)
                                                        {echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';}
                                                        
                    } else {
                        echo '<div class="product__hover__info">
                                                                <ul class="product__action">
                                                                     <li><a title="Ajouter ♥" href="login-register.php"><span class="ti-heart"></span></a></li>
                                                                </ul>
                                                            </div>';
                                                             if($row['promo']!=0) {
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> '; }
                                                       
                    }

                    echo ' </div>
                        <div class="product__details">
                            <h2><a href="product-details.php?idprod=' . $row['idProduit'] . '">' . $row['nom_prod'] . '</a></h2>
                                <ul class="product__price">';
                            if($new_price<$row['prix']){

                                echo'<li class="old__price">' . $row['prix'] . ' Dhs</li>
                                
                                
                                <li class="new__price">' . $new_price . ' Dhs</li>';}
                                else {
                                        echo'<li class="new__price" >' . $row['prix'] . ' Dhs</li>';
                                }
                            echo' </ul>
                        </div>
                    </div>
                </div>
                ';
                }



                echo '
   
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="home' . $i3 . '">
                                   
                                    <div class="row">
                                    <div class="product-slider-active owl-carousel"> ';


                if (isset($_GET['category']) && getParent($_GET['category']) == $line['idCategorie']) {
                    if (getParent($_GET['category']) == $line['idCategorie'])
                        $run = mysqli_query($con, "SELECT *,AVG(evaluation) from produit join avis on produit.idProduit=avis.idProduit where idCategorie=" . $_GET['category'] . " and stock>0 group by avis.idProduit order by AVG(evaluation) DESC;   ");
                } else {
                    $run = mysqli_query($con, "SELECT *,AVG(evaluation) from produit join categorie on categorie.idCategorie=produit.idCategorie join avis on produit.idProduit=avis.idProduit where idCat_parente=" . $line['idCategorie'] . " and stock>0  group by avis.idProduit order by AVG(evaluation) DESC;    ");
                }


                while ($row = mysqli_fetch_assoc($run)) {
                    $image = "images/" . $row['img_prod'] . "";
                    $new_price = $row['prix'] * (1 - $row['promo'] * 0.01);
                    echo '
                                  
                                            <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="product-details.php?idprod=' . $row['idProduit'] . '">
                                                                <img src="' . $image . '" alt="product images">
                                                            </a>
                                                        </div>';
                                                         if (isset($_SESSION["id_user"])) {
                        $query2 = "SELECT idProduit FROM envie WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
                        $result2 = mysqli_query($con, $query2);
                        echo '<div class="product__hover__info">
                                                                <ul class="product__action">';
                        if (mysqli_num_rows($result2) == 0) {

                            echo '<li><a title="Ajouter ♥" class="add" href="#/"><span class="ti-heart"></span></a></li>';
                        } else {
                            echo '<li><a title="Ajouté ♥" href="#/"><span class="ti-check-box" style="font-size: 25x;">Favori</span></a></li>';
                        }


                        echo ' </ul>
                                                               <form class="add-wish" method="post" action="" role="form">  
                                                                    <input type="text" style="display: none;" name="id_product" value="' . $row["idProduit"] . '" />
                                                                </form>
                                                            </div>';
                                                              if($row['promo']!=0){
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';}
                    } else {
                        echo '<div class="product__hover__info">
                                                                <ul class="product__action">
                                                                     <li><a title="Ajouter ♥" href="login-register.php"><span class="ti-heart"></span></a></li>
                                                                </ul>
                                                            </div>';
                                                              if($row['promo']!=0){
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';}
                    }

                    
                                                 echo'    </div>
                                                     
                                                   <div class="product__details">
                                                        <h2><a href="product-details.php?idprod=' . $row['idProduit'] . '">' . $row['nom_prod'] . '</a></h2>
                                                          <ul class="product__price">';
                                                        if($new_price<$row['prix']){

                                                            echo'<li class="old__price">' . $row['prix'] . ' Dhs</li>
                                                            
                                                           
                                                            <li class="new__price">' . $new_price . ' Dhs</li>';}
                                                            else {
                                                                 echo'<li class="new__price" >' . $row['prix'] . ' Dhs</li>';
                                                            }
                                                       echo' </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                }



                echo '
   
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="home' . $i2 . '">
                                    <div class="row">
                                        <div class="product-slider-active owl-carousel">';

                if (isset($_GET['category']) && getParent($_GET['category']) == $line['idCategorie']) {
                    if (getParent($_GET['category']) == $line['idCategorie'])
                        $run = mysqli_query($con, "SELECT * from produit  where idCategorie=" . $_GET['category'] . " order by vendu DESC;   ");
                } else {
                    $run = mysqli_query($con, "SELECT * from produit join categorie on categorie.idCategorie=produit.idCategorie  where idCat_parente=" . $line['idCategorie'] . " order by vendu DESC;    ");
                }


                while ($row = mysqli_fetch_assoc($run)) {
                    $image = "images/" . $row['img_prod'] . "";
                    $new_price = $row['prix'] * (1 - $row['promo'] * 0.01);
                    echo '
                                  
                                            <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="product-details.php?idprod=' . $row['idProduit'] . '">
                                                                <img src="' . $image . '" alt="product images">
                                                            </a>
                                                        </div>';
                                                        if (isset($_SESSION["id_user"])) {
                        $query2 = "SELECT idProduit FROM envie WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
                        $result2 = mysqli_query($con, $query2);
                        echo '<div class="product__hover__info">
                                                                <ul class="product__action">';
                        if (mysqli_num_rows($result2) == 0) {

                            echo '<li><a title="Ajouter ♥" class="add" href="#/"><span class="ti-heart"></span></a></li>';
                        } else {
                            echo '<li><a title="Ajouté ♥" href="#/"><span class="ti-check-box" style="font-size: 25x;">Favori</span></a></li>';
                        }


                        echo ' </ul>
                                                               <form class="add-wish" method="post" action="" role="form">  
                                                                    <input type="text" style="display: none;" name="id_product" value="' . $row["idProduit"] . '" />
                                                                </form>
                                                            </div>';
                                                            if($row['promo']!=0)
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';
                    } else {
                        echo '<div class="product__hover__info">
                                                                <ul class="product__action">
                                                                     <li><a title="Ajouter ♥" href="login-register.php"><span class="ti-heart"></span></a></li>
                                                                </ul>
                                                            </div>';
                                                            if($row['promo']!=0)
                                                        echo'
                                                        <span class="new">'.$row['promo'].'%</span> ';
                    }

                   
                                             echo'        </div>
                                                   <div class="product__details">
                                                        <h2><a href="product-details.php?idprod=' . $row['idProduit'] . '">' . $row['nom_prod'] . '</a></h2>
                                                          <ul class="product__price">';
                                                        if($new_price<$row['prix']){

                                                            echo'<li class="old__price">' . $row['prix'] . ' Dhs</li>
                                                            
                                                           
                                                            <li class="new__price">' . $new_price . ' Dhs</li>';}
                                                            else {
                                                                 echo'<li class="new__price" >' . $row['prix'] . ' Dhs</li>';
                                                            }
                                                       echo' </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                }



                echo '
   
                                        </div>
                                    </div>
                                </div>
                                          
                                           
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </section>
        <!-- End Our Product Area --> ';
                $i++;
                $i1 += 4;
                $i2 += 4;
                $i3 += 4;
            }
        }
        ?>


        <div class="only-banner ptb--100 bg__white">
            <div class="container" id="cat2_redirect">
                <div class="only-banner-img">
                    <a href="shop-sidebar.html"><img src="images/new-product/pub.jpg" alt="new product"></a>
                </div>
            </div>
        </div>


        <!-- Start Footer Area -->
        <?php include 'templates/footer.php'; ?>
        <!-- End Footer Area -->
    </div>
    <!-- Body main wrapper end -->
    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal__container" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-product">
                            <!-- Start product images -->
                            <div class="product-images">
                                <div class="main-image images">
                                    <img alt="big images" src="images/product/big-img/1.jpg">
                                </div>
                            </div>
                            <!-- end product images -->
                            <div class="product-info">
                                <h1>Simple Fabric Bags</h1>
                                <div class="rating__and__review">
                                    <ul class="rating">
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                        <li><span class="ti-star"></span></li>
                                    </ul>
                                    <div class="review">
                                        <a href="#">4 customer reviews</a>
                                    </div>
                                </div>
                                <div class="price-box-3">
                                    <div class="s-price-box">
                                        <span class="new-price">$17.20</span>
                                        <span class="old-price">$45.00</span>
                                    </div>
                                </div>
                                <div class="quick-desc">
                                    Designed for simplicity and made from high quality materials. Its sleek geometry and material combinations creates a modern look.
                                </div>
                                <div class="select__color">
                                    <h2>Chọn màu sắc</h2>
                                    <ul class="color__list">
                                        <li class="red"><a title="Red" href="#">Red</a></li>
                                        <li class="gold"><a title="Gold" href="#">Gold</a></li>
                                        <li class="orange"><a title="Orange" href="#">Orange</a></li>
                                        <li class="orange"><a title="Orange" href="#">Orange</a></li>
                                    </ul>
                                </div>
                                <div class="select__size">
                                    <h2>Chọn kích cỡ</h2>
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
                                    <a href="#">Thêm vào giỏ</a>
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
    <script src="jQuery.3.5.1.js"></script>
    <script type="text/javascript">
        $(function() {
            $('a[href*=#]:not([href=#])').click(function() {
                if (this.hash.length > 0) {
                    $('body, html').animate({
                        scrollTop: $(this.hash).offset().top
                    }, 500);
                }
                return false;
            });
        });
    </script>

    <script>
        const button = document.querySelector('button[type="submit"]');
        button.disabled = true;

        function autocomplete(inp, arr, arr2) {

            var currentFocus;

            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;

                closeAllLists();
                if (!val) {
                    const button = document.querySelector('button[type="submit"]');
                    button.disabled = true;

                }
                currentFocus = -1;

                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");

                this.parentNode.appendChild(a);

                if (val == "" || val == " " || val == "  " || val == "   " || val == "    " || val.indexOf("    ") > -1) {

                    const button = document.querySelector('button[type="submit"]');
                    button.disabled = true;
                    const sheet = new CSSStyleSheet();
                    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

                    // Apply the stylesheet to a document:
                    document.adoptedStyleSheets = [sheet];

                } else {
                    var y = 0;
                    for (i = 0; i < arr.length; i++) {
                        for (var l = 0; l < arr[i].length; l++) {
                            if (arr[i].substr(l, val.length).toUpperCase() == val.toUpperCase()) {
                                console.log(arr[i]);
                                y++;

                                l = document.createElement("a");
                                l.href = "product-details.php?idprod=" + arr2[i];
                                ul = document.createElement("ul");
                                b = document.createElement("DIV");
                                b.className = 'good';
                                li = document.createElement("li");
                                li.setAttribute("class", "li_search");
                                p = document.createElement("p");
                                p.setAttribute("class", "p-search");


                                p.innerHTML += "<a style='color:black;' href='product-details.php?idprod=" + arr2[i] + "'>" + arr[i] + "</a>";

                                var iconurl = <?php echo json_encode($arrimage); ?>;
                                var img = document.createElement("img");
                                img.src = iconurl[i];
                                img.width = 50;
                                img.height = 50;
                                li.appendChild(img);
                                li.appendChild(p);
                                b.appendChild(li);
                                l.appendChild(b);
                                b.addEventListener("click", function(e) {

                                    inp.value = this.getElementsByTagName("input")[0].value;

                                    closeAllLists();
                                });
                                a.appendChild(l);

                            }
                        }
                    }
                    if (y > 7) {
                        console.log(y);
                        b.setAttribute("id", "invisible_");

                        const sheet = new CSSStyleSheet();
                        sheet.replaceSync('.autocomplete-items {height: 371px}');

                        // Apply the stylesheet to a document:
                        document.adoptedStyleSheets = [sheet];
                        const button = document.querySelector('button[type="submit"]');
                        button.disabled = false;
                    } else if (y == 0) {
                        b = document.createElement("DIV");
                        b.className = 'good';
                        p = document.createElement("p");
                        p.setAttribute("class", "p-search");


                        p.innerHTML += "<p style='color:black;' > aucun resultat..</a>";
                        b.appendChild(p);


                        b.addEventListener("click", function(e) {

                            inp.value = this.getElementsByTagName("input")[0].value;

                            closeAllLists();
                        });
                        a.appendChild(b);

                        const sheet = new CSSStyleSheet();
                        sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

                        // Apply the stylesheet to a document:
                        document.adoptedStyleSheets = [sheet];

                        const button = document.querySelector('button[type="submit"]');
                        button.disabled = true;
                    } else {
                        const sheet = new CSSStyleSheet();
                        sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

                        // Apply the stylesheet to a document:
                        document.adoptedStyleSheets = [sheet];
                        const button = document.querySelector('button[type="submit"]');
                        button.disabled = false;
                    }

                }
            });
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {

                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) {

                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) {
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {

                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        var myvar = <?php echo json_encode($arr); ?>;
        var myvar2 = <?php echo json_encode($arr2); ?>;
        autocomplete(document.getElementById("myInput"), myvar, myvar2);
    </script>
</body>

</html>