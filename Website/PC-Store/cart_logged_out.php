<?php

include 'db.php';
include 'functions.php';
if (empty($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['panier']))
    header('Location: index.php');

if (isset($_SESSION['couponApplyed']))
    unset($_SESSION["couponApplyed"]);

creationPanier();
for ($i = 0; $i < count($_SESSION['panier']['idProduit']); $i++) {

    $query = "SELECT * FROM produit  WHERE (idProduit = " . $_SESSION['panier']['idProduit'][$i] . ")";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['stock'] == 0) {

        $_SESSION['cartItems'] -= $_SESSION['panier']['qteProduit'][$i];
        $_SESSION['panier']['qteProduit'][$i] = 0;
    } else if ($_SESSION['panier']['qteProduit'][$i] > $row['stock']) {

        $_SESSION['cartItems'] -= $_SESSION['panier']['qteProduit'][$i] - $row['stock'];
        $_SESSION['panier']['qteProduit'][$i] = $row['stock'];
    }
}

$query = "SELECT * FROM types_livraisons";
$result2 = mysqli_query($con, $query);
?>
<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">Bạn đang sử dụng một trình duyệt <strong>lỗi thời</strong>. Vui lòng <a href="http://browsehappy.com/">nâng cấp trình duyệt của bạn</a> để cải thiện trải nghiệm.</p>
    <![endif]-->

    <!-- Bắt đầu wrapper chính của body -->
    <div class="wrapper fixed__footer">
        <!-- Bắt đầu Kiểu Header -->
        <?php include 'templates/header.php'; ?>
        <!-- End Header Style -->

        <div class="body__overlay"></div>
        <!-- Bắt đầu Offset Wrapper -->
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

            <!-- Kết thúc Offset Wrapper -->
            <!-- Bắt đầu khu vực Bradcaump -->
            <?php
            if ($_SESSION['cartItems'] == 0 || !isset($_SESSION['panier'])) {
                echo '<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Giỏ hàng</h2>
                                <nav class="bradcaump-inner">
                                    <span class="breadcrumb-item active">Giỏ hàng của bạn trống!</span>
                                    <a class="continuer" href="index.php">Tiếp tục mua sắm</a> 
                                    <br><br>
                                    <span class="breadcrumb-item active">Bạn đã có tài khoản? </span>
                                    <a class="continuer" href="login-register.php"> Đăng nhập </a>
                                    <span class="breadcrumb-item active">để xem các mặt hàng trong giỏ hàng của bạn.</span>                                
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
            } else {

                echo '<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Giỏ hàng</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.php">Trang chủ</a>
                                    <span class="brd-separetor">/</span>
                                    <span class="breadcrumb-item active">Giỏ hàng</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu khu vực giỏ hàng chính -->

        <div class="cart-main-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Hình ảnh</th>
                                        <th class="product-name">Sản phẩm</th>
                                        <th class="product-price">Đơn giá</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-subtotal">Tổng phụ</th>
                                        <th class="product-remove">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $totalFinal = 0;
                for ($i = 0; $i < count($_SESSION['panier']['idProduit']); $i++) {

                    $query = "SELECT * FROM produit  WHERE (idProduit = " . $_SESSION['panier']['idProduit'][$i] . ")";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);

                    $prix = $_SESSION['panier']['prixProduit'][$i] * (1 - $row['promo'] / 100);
                    echo '<tr>';
                    echo '<td class="product-thumbnail"><a href="product-details.php?idprod=' . $row["idProduit"] . '"><img src="images/' . $row['img_prod'] . '" alt="hình ảnh sản phẩm" /></a></td>';
                    echo '<td class="product-name"><a href="product-details.php?idprod=' . $row["idProduit"] . '">' . $row['nom_prod'] . '</a></td>';
                    echo '<td class="product-price"><span class="amount">' . $prix . ' VNĐ</span></td>';
                    echo '<td class="product-quantity">
                        <form class="change-quantity" method="post" action="" role="form">';
                    if ($row['stock'] == 0) {
                        echo '<input type="number" style="display: none;" name="quantity" value="0" min="1" max="' . $row['stock'] . '" />';
                        echo '<span class="comments">Hết hàng</span>';
                        $total = 0;
                    } else if ($_SESSION['panier']['qteProduit'][$i] > $row['stock']) {
                        echo '<input type="number" name="quantity" value="' . $row['stock'] . '" min="1" max="' . $row['stock'] . '" />';
                        $total = $row['stock'] * $prix;
                    } else {
                        echo '<input type="number" name="quantity" value="' . $_SESSION['panier']['qteProduit'][$i] . '" min="1" max="' . $row['stock'] . '" />';
                        $total = $_SESSION['panier']['qteProduit'][$i] * $prix;
                    }
                    $totalFinal += $total;
                    echo '<input type="text" style="display: none;" name="id_product" value="' . $row['idProduit'] . '" />
                      </form>
                </td>';
                    echo '<td class="product-subtotal">' . $total . '</td>';
                    echo '<td class="product-remove">
                    <form class="remove-product" method="post" action="" role="form">
                        <a href="#/"><span class="ti-trash" style="font-size: 25px;"></span></a>
                        <input type="text" style="display: none;" name="id_product" value="' . $row['idProduit'] . '" />
                    </form>
                </td>';

                    echo '</tr>';
                }
                $_SESSION["montantGlobale"] = $totalFinal;
                echo
                ' </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                    <div class="buttons-cart">
                                        <a href="#/">Xóa giỏ hàng</a>
                                        <a href="index.php">Tiếp tục mua sắm</a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="cart_totals">
                                        <h2>Tổng giỏ hàng</h2>
                                        <table>
                                             <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>Tổng phụ</th>
                                                    <td><span id="sous_amount" class="amount">' . $totalFinal . ' VNĐ</span></td>
                                                </tr>
                                                <tr class="shipping">
                                                   <th>Vận chuyển</th>
                                                   <td>';
                $row2 = mysqli_fetch_assoc($result2);
                $bilan = $row2['prix_livraison'] + $totalFinal;
                $_SESSION["type_livr"] = $row2['id_type'];

                echo '<form class="livraison" method="post" action="" role="form">
                                                            <ul id="shipping_method">
                                                                <li>
                                                                    <input type="radio" id="' . $row2['nom_type'] . '" name="type_livraison" value="' . $row2['id_type'] . '" checked>
                                                                    <label for="' . $row2['nom_type'] . '">
                                                                        ' . $row2['nom_type'] . ': <span class="amount">' . $row2['prix_livraison'] . ' VNĐ</span>
                                                                    </label>
                                                                </li>';
                $row2 = mysqli_fetch_assoc($result2);
                echo '<li>
                                                                    <input type="radio" id="' . $row2['nom_type'] . '" name="type_livraison" value="' . $row2['id_type'] . '">
                                                                    <label for="' . $row2['nom_type'] . '">
                                                                        ' . $row2['nom_type'] . ': <span class="amount">' . $row2['prix_livraison'] . ' VNĐ</span>
                                                                    </label>
                                                                </li>
                                                                <li></li>
                                                            </ul>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>Tổng cộng</th>
                                                    <td>
                                                        <strong><span id="final_amount" class="amount ">' . $bilan . ' VNĐ</span></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="wc-proceed-to-checkout">
                                            <a href="login-register.php?cart=1">Tiến hành thanh toán</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>';
            }
            ?>
            <!-- cart-main-area end -->
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

                    // Áp dụng stylesheet cho tài liệu:
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

                        // Áp dụng stylesheet cho tài liệu:
                        document.adoptedStyleSheets = [sheet];
                        const button = document.querySelector('button[type="submit"]');
                        button.disabled = false;
                    } else if (y == 0) {
                        b = document.createElement("DIV");
                        b.className = 'good';
                        p = document.createElement("p");
                        p.setAttribute("class", "p-search");


                        p.innerHTML += "<p style='color:black;' > không có kết quả..</a>";
                        b.appendChild(p);


                        b.addEventListener("click", function(e) {

                            inp.value = this.getElementsByTagName("input")[0].value;

                            closeAllLists();
                        });
                        a.appendChild(b);

                        const sheet = new CSSStyleSheet();
                        sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

                        // Áp dụng stylesheet cho tài liệu:
                        document.adoptedStyleSheets = [sheet];

                        const button = document.querySelector('button[type="submit"]');
                        button.disabled = true;
                    } else {
                        const sheet = new CSSStyleSheet();
                        sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

                        // Áp dụng stylesheet cho tài liệu:
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