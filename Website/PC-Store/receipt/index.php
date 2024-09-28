<?php
include '../db.php';
if (empty($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <title>Hoá đơn của khách</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div id="wrap">
        <div>
            <img src="images/success.png" alt="logo">
            <h1>Thanh toán của bạn đã được thực hiện thành công</h1>
            <form method="post" action="create_reciept.php">
                <?php
                $query = "SELECT idAdresse,idCommande FROM livraison ORDER BY idLivraison DESC LIMIT 1";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                $idAdr = $row["idAdresse"];
                $idCom = $row["idCommande"];
                $query = "SELECT * FROM adresse WHERE idAdresse = '$idAdr'";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_array($result);
                $zcode = $row["zipCode"];
                $addr = $row["details"];
                $country = $row["pays"];
                $city = $row["ville"];
                echo '
                <fieldset>
                <legend>Khách hàng</legend>
                    <div class="col">
                        <p>
                            <label for="name">Họ</label>
                            <input type="text" name="name" value="' . $_SESSION["userName"] . '" readonly/>
                        </p>
                        <p>
                            <label>Tên</label>
                            <input type="text" name="firstName" value="' . $_SESSION["userFirstName"] . '" readonly/>
                        </p>
                        <p>
                            <label for="email">Email</label>
                            <input type="text" name="email" value="' . $_SESSION["email"] . '" readonly/>
                        </p>
                    </div>
                    <div class="col">
                        <p>
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" value="' . $addr . '" readonly/>
                        </p>
                        <p>
                            <label for="city">Thành phố</label>
                            <input type="text" name="city" value="' . $city . '" readonly/>
                        </p>
                        <p>
                            <label for="postal_code">Mã bưu chính</label>
                            <input type="text" name="postal_code" value="' . $zcode . '" readonly/>
                        </p>
                        <p>
                            <label for="country">Quốc gia</label><input type="text" name="country" value="' . $country . '" readonly/>
                        </p>
                    </div>
                </fieldset>
                ';
                ?>
                <fieldset>
                    <legend>Giỏ hàng của bạn</legend>
                    <h2>Tổng cộng:
                        <?php
                        $ID = $_SESSION['id_user'];
                        $sql = "SELECT total_cmd,idCommande FROM commande WHERE idClient=$ID ORDER BY idCommande DESC LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if (mysqli_num_rows($result) > 0) {
                            $total = $row["total_cmd"];
                            echo $total;
                        }
                        ?>
                        MAD</h2>

                    <table>
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Giá</td>
                            </tr>
                            <thead>
                            <tbody>
                                <?php
                                $query = "SELECT idProduit,quantite FROM commande_produits WHERE idCommande = $idCom";
                                $result = mysqli_query($con, $query);
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    $idP = $row["idProduit"];
                                    $sql = "SELECT produit_idName($idP)";
                                    $resname = mysqli_query($con, $sql);
                                    $restab = mysqli_fetch_array($resname);
                                    $sql = "SELECT produit_idPrice($idP)";
                                    $resprice = mysqli_query($con, $sql);
                                    $pricetab = mysqli_fetch_array($resprice);
                                    $promoQ = "SELECT produit_idPromo($idP)";
                                    $respromo = mysqli_query($con, $promoQ);
                                    $promotab = mysqli_fetch_array($respromo);

                                    echo '
                                    <td><input type="text" value="' . $restab[0] . '  x  ' . $row["quantite"] . '" name="product[]" readonly/></td>
                                    <td><input type="text" value="' . $pricetab[0] * $row["quantite"] * (1 - $promotab[0] / 100) . '" name="price[]" readonly/> MAD</td>
                                </tr>
                                ';
                                }
                                $livrQ = "SELECT id_typeLivraison FROM commande WHERE idCommande = $idCom";
                                $livrR = mysqli_query($con, $livrQ);
                                $livrA = mysqli_fetch_array($livrR);
                                $idLivr = $livrA[0];
                                if ($idLivr == 1) {
                                    $typeLivr = "TIÊU CHUẨN";
                                    $prixLivr = 20;
                                } elseif ($idLivr == 2) {
                                    $typeLivr = "NHANH";
                                    $prixLivr = 50;
                                }
                                echo '
                            <tr>
                                <td><input type="text" value="Vận chuyển : ' . $typeLivr . '" name="product[]" readonly/></td>
                                <td><input type="text" value="' . $prixLivr . '" name="price[]" readonly/> MAD</td>
                            </tr>

                            ';
                                ?>
                            </tbody>
                    </table>
                    <h3>Loại vận chuyển : <?php echo $typeLivr . '  -  ' . $prixLivr . ' MAD'; ?></h3>
                </fieldset>
                <button type="submit">In hóa đơn của tôi</button>
            </form>
            <script>
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            </script>
        </div>
    </div>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
<script type="text/javascript">
    $('button').click(function() {
        $.post('create_reciept.php', $('form').serialize(), function() {
            $('div#wrap div').fadeOut(function() {
                $(this).empty().html("<h2>Cảm ơn bạn đã mua hàng!</h2><br><p> <a href='reciept.pdf'>Tải hóa đơn của bạn</a> hoặc quay lại <a href='../index.php'>trang chủ</a>. </p>").fadeIn();
            });
        });
        return false;
    });
</script>

</html>