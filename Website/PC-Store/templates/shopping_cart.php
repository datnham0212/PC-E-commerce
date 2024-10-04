<?php if (isset($_SESSION["id_user"])) { ?>
<div class="shopping__cart">
    <div class="shopping__cart__inner">
        <div class="offsetmenu__close__btn">
            <a href="#"><i class="zmdi zmdi-close"></i></a>
        </div>
        <div class="shp__cart__wrap">
            <?php
            $total_prix = 0;
            $query = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient= " . $_SESSION["id_user"] . " ");
            $num_Line = mysqli_num_rows($query);
            if ($num_Line == 0) {
                echo '<div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title"></h2>
                    <nav class="bradcaump-inner">
                        <span class="breadcrumb-item active">Giỏ hàng của bạn trống!</span>
                        <a class="continuer" href="index.php">Tiếp tục mua sắm</a>                                    
                    </nav>
                </div>';
            } else {
                echo '<ul id="ticker">';
                while ($rowp = mysqli_fetch_array($query)) {
                    $image = $rowp["img_prod"];
                    $prix = $rowp['prix'] * (1 - $rowp['promo'] / 100);
                    $total_prix += $prix * $rowp['quantite'];
                    echo '
                    <li>
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="product-details.php?idprod=' . $rowp['idProduit'] . '">
                                    <img src="images/' . $image . '" alt="product images" style="width:265px;Height:67px;">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.php?idprod=' . $rowp['idProduit'] . '" style="text-transform: uppercase;">' . $rowp['nom_prod'] . '</a></h2>
                                <span class="quantity">Số lượng: ' . $rowp['quantite'] . '</span>
                                <span class="shp__price">Giá đơn vị: ' . $prix . ' DH</span>
                            </div>
                        </div>
                    </li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
        <ul class="shoping__total">
            <li class="subtotal">Tổng phụ:</li>
            <li class="total__price"><?php echo $total_prix; ?> DH</li>
        </ul>
        <ul class="shopping__btn">
            <li><a href="cart_logged_in.php">Xem giỏ hàng của tôi</a></li>
        </ul>
    </div>
</div>
<?php } ?>