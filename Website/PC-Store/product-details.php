<?php

include 'db.php';
include 'functions.php';
if (empty($_SESSION)) {
    session_start();
}
if(isset($_SESSION["id_user"])){
 if ($_SERVER["REQUEST_METHOD"] == "POST" ) 
    { 
        // Kiểm tra xem các khóa có tồn tại trong $_POST không
        $name = isset($_POST["name"]) ? $_POST["name"] : '';
        $email = isset($_POST["email"]) ? $_POST["email"] : '';
        $comment = isset($_POST["textarea"]) ? $_POST["textarea"] : '';
  
        $isSuccess = true; 
        
        // Kiểm tra xem các trường có giá trị không trước khi chèn vào cơ sở dữ liệu
        if(!empty($name) && !empty($email) && !empty($comment)) {
            $result3 = mysqli_query($con, "INSERT INTO avis (idClient,idProduit,commentaire,evaluation) VALUES (".$_SESSION["id_user"].",".$_GET['idprod'].", '".mysqli_real_escape_string($con, $comment)."','3')" );
            if(!$result3) {
                $isSuccess = false;
                // Xử lý lỗi ở đây, ví dụ:
                // error_log("Lỗi SQL: " . mysqli_error($con));
            }
        } else {
            $isSuccess = false;
            // Có thể thêm thông báo lỗi cho người dùng ở đây
        }
    }
}

if (isset($_GET['idprod']))
    $idProduit = $_GET['idprod'];

$query = "SELECT * FROM produit  WHERE (idProduit = '$idProduit')";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$query = "SELECT * FROM categorie  WHERE (idCategorie = " . $row['idCategorie'] . ")";
$result2 = mysqli_query($con, $query);
$row2 = mysqli_fetch_assoc($result2);



$patal = array();
array_push($patal, $row2['desp_cat']);

while ($row2['idCat_parente'] != 0) {

    $query = "SELECT * FROM categorie  WHERE (idCategorie = " . $row2['idCat_parente'] . ")";
    $result2 = mysqli_query($con, $query);
    $row2 = mysqli_fetch_assoc($result2);
    array_push($patal, $row2['desp_cat']);
}
$patal = array_reverse($patal);

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
            <?php
            $arr = array();

            $arr2 = array();
            $quer = "SELECT * FROM produit ";
            $resul = mysqli_query($con, $quer) or die(mysqli_error($con));
            if (mysqli_num_rows($resul) > 0) {
                while ($rowse = mysqli_fetch_assoc($resul)) {
                    $arr[] = $rowse['nom_prod'];
                    $arr2[] = $rowse["idProduit"];
                    $path = "images/" . $rowse['img_prod'] . "";
                    $arrimage[] = $path;
                }
            }


            ?>

            <!-- Kết thúc Tìm kiếm Popap -->
            <!-- Bắt đầu Bảng Giỏ hàng -->
            <?php include 'templates/shopping_cart.php'; ?>
            <!-- Kết thúc Bảng Giỏ hàng -->
        </div>
        <!-- Kết thúc Wrapper Offset -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <?php
        include 'templates/bradcaump.php';

        // Thêm dòng này để lấy tên sản phẩm
        $productName = $row['nom_prod'];
        
        renderBradcaump(
            $productName,
            [
                ['url' => 'index.php', 'text' => 'Trang chủ '],
                ['url' => 'shop.php', 'text' => 'Sản phẩm / '],
                ['text' => $productName]
            ]
        ); ?>

        <!-- End Bradcaump area -->
        <!-- Start Product Details -->
        <?php
        echo ' <section class="htc__product__details pt--120 pb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="product__details__container">

                            <div class="product__big__images">
                                <div class="portfolio-full-image tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active product-video-position" id="img-tab-1">
                                        <img src="images/' . $row['img_prod'] . '" alt="hình ảnh đầy đủ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                        <div class="htc__product__details__inner">
                            <div class="pro__detl__title">
                                <h2>' . $row['nom_prod'] . '</h2>
                            </div>
                            <div class="pro__dtl__rating">
                                <ul class="pro__rating">
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                    <li><span class="ti-star"></span></li>
                                </ul>
                                <span class="rat__qun">(Dựa trên 0 Đánh giá)</span>
                            </div>
                            <br><br>
                            <div class="pro__dtl__color">
                                <h2 class="title__5"><b>Danh mục</b> : ';
        for ($i = 0; $i < count($patal); $i++) {
            if ($i == 0) {
                echo $patal[$i];
            } else {
                echo ' > ' . $patal[$i];
            }
        }
        echo ' </h2>
                            </div>
                            <ul class="pro__dtl__prize">';
        if ($row['promo'] != 0) {
            echo ' <li class="old__prize">' . $row['prix'] . ' Đồng</li>
                                <li>' . $row['prix'] * (1 - $row['promo'] / 100) . ' Đồng</li>';
        } else {
            echo '<li>' . $row['prix'] . ' Đồng</li>';
        }

        echo '</ul>


                            <form id="cart-form" method="post" action="" role="form">
                                <div class="product-action-wrap">
                                    <div class="prodict-statas"><span>Số lượng :</span></div>
                                    <div class="product-quantity">
                                        <div class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" type="text" name="qtybutton" min="1" max="' . $row['stock'] . '" value="01" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="pro__dtl__btn">

                                    <li class="buy__now__btn"><input type="submit" id="addToCart" class="form-submit" value="Thêm vào giỏ hàng" /></li>
                                    <li><input name="id_product" style="display:none;" value="' . $row['idProduit'] . '"></li>';
        if (isset($_SESSION["id_user"])) {
        $query2 = "SELECT idProduit FROM envie WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
        $result2 = mysqli_query($con, $query2);
        if (mysqli_num_rows($result2) == 0)
            echo '<li class="add"><a title="Thêm ♥" href="#/" class="add"><span class="ti-heart"></span></a></li>';
        else
            echo '<li class="add"><a title="Đã thêm ♥" href="#/" class="add"><span class="ti-heart" style="color: red; font-weight: bolder"></span></a></li>';
        } else {
            echo '<li class="add"><a title="Thêm ♥" href="login-register.php" class="add"><span class="ti-heart"></span></a></li>';
        }
        echo '<li>
                                        <span id="cart-status" class="cart-status"></span>
                                    </li>
                                    
                                </ul>
                            </form>

                            <form id="add-wish" method="post" action="" role="form">  
                                <input type="text" style="display: none;" name="id_product" value="' . $row["idProduit"] . '" />
                            </form>
                            
                            <div class="pro__social__share">
                                <h2>Chia sẻ :</h2>
                                <ul class="pro__soaial__link">
                                    <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                    <li><a href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                                    <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                    <li><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';

        ?>
        <!-- End Product Details -->
        <!-- Start Product tab -->
        <section class="htc__product__details__tab bg__white pb--120">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <ul class="product__deatils__tab mb--60" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#description" role="tab" data-toggle="tab">Mô tả</a>
                            </li>
                            <li role="presentation">
                                <a href="#reviews" role="tab" data-toggle="tab">Đánh giá</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product__details__tab__content">
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="description" class="product__tab__content fade in active">
                                <div class="product__description__wrap">
                                    <div class="product__desc">
                                        <h2 class="title__6">Chi tiết</h2>
                                        <p><?php echo $row['desp_prod']; ?></p>
                                    </div>
                                    <div class="pro__feature">
                                        <h2 class="title__6">Thông số kỹ thuật</h2>
                                        <ul class="feature__list">
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>....</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>....</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>....</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-play-circle"></i>....</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Content -->
                            <!-- Start Single Content -->
                            <div role="tabpanel" id="reviews" class="product__tab__content fade">
                                <div class="review__address__inner">
                                    <!-- Start Single Review -->
                                    
                            <?php

   


                            $idProduit=$_GET['idprod'];
                            $sqlReview = "SELECT idClient, commentaire, evaluation FROM avis WHERE idProduit = $idProduit";
                            $resultR = mysqli_query($con, $sqlReview);
                            while ($row = mysqli_fetch_array($resultR, MYSQLI_ASSOC)){
                                $idC = $row['idClient'];
                                $sqlClient = "SELECT nom, prenom FROM client WHERE idClient = $idC";
                                $resultC = mysqli_query($con, $sqlClient);
                                $rowC = mysqli_fetch_assoc($resultC);
                                echo '   <div class="pro__review">
                                                <div class="review__details">
                                                    <div class="review__info">

                                                        <h4>'.$rowC["nom"].' '.$rowC["prenom"].'</h4>
                                                        <ul class="rating">';
                                                        for ($i=0; $i < $row["evaluation"]; $i++) { 
                                                            echo '<li><i class="zmdi zmdi-star"></i></li>';
                                                        }
                                                    echo '
                                                        </ul>

                                                    </div>
                                                    <p>'.$row["commentaire"].'</p>
                                                </div>
                                            </div>';

                                        }
                                            ?>
                                    <!-- End Single Review -->
                                    <!-- Start Single Review -->
                             
                                    <!-- End Single Review -->
                                </div>
                                <!-- Start RAting Area -->
                                <div class="rating__wrap">
                                    <h2 class="rating-title">Viết đánh giá</h2>
                                    <h4 class="rating-title-2">Đánh giá của bạn</h4>
                                    <div class="rating__list">
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                        <!-- Start Single List -->
                                        <ul class="rating">
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                            <li><i class="zmdi zmdi-star-half"></i></li>
                                        </ul>
                                        <!-- End Single List -->
                                    </div>
                                </div>
                                <!-- End RAting Area -->
                                <div class="review__box">
                                <?php     echo' <form id="review-form" action="#reviews" method="POST" >
                                
                                        <div class="single-review-form">
                                            <div class="review-box name">
                                                <input type="text" name="name" placeholder="Nhập tên của bạn">
                                                <input type="email" name="email" placeholder="Nhập email của bạn">
                                            </div>
                                        </div>
                                        <div class="single-review-form">
                                            <div class="review-box message">
                                                <textarea placeholder="Viết đánh giá của bạn" name="textarea"></textarea>
                                            </div>
                                        </div>
                                        <div class="review-btn">
                                            <button class="fv-btn" name="submit-form"  id="submit-form">Gửi
                                            </button>
                                        </div>
                                    </form>
                                    ';
                                    ?>
                                </div>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Product tab -->
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
                                    <h2>Select color</h2>
                                    <ul class="color__list">
                                        <li class="red"><a title="Red" href="#">Red</a></li>
                                        <li class="gold"><a title="Gold" href="#">Gold</a></li>
                                        <li class="orange"><a title="Orange" href="#">Orange</a></li>
                                        <li class="orange"><a title="Orange" href="#">Orange</a></li>
                                    </ul>
                                </div>
                                <div class="select__size">
                                    <h2>Select size</h2>
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
                                        <h3 class="widget-title-modal">Share this product</h3>
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
                                    <a href="#">Add to cart</a>
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
                /*
      if(val.toUpperCase()=="" || val.toUpperCase()==" "  || val.toUpperCase()==" " ) {         
           const button=document.querySelector('button[type="submit"]');
button.disabled=true;
      }
*/

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