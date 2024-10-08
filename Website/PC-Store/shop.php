<?php
$customType = "5";
include 'db.php';
include('functions.php');
if (empty($_SESSION)) {
    session_start();
}


if (isset($_SESSION['couponApplyed']))
    unset($_SESSION["couponApplyed"]);

if (isset($_GET["idCat"])) {
    $query = "SELECT * FROM categorie  WHERE (idCategorie = " . $_GET['idCat'] . ")";
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
}

?>


<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>
    <?php 
    if(isset($_SESSION["id_user"])){
      $query_n = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient= " . $_SESSION["id_user"] . " ");
          $num_Line = mysqli_num_rows($query_n);
           if($num_Line>2){?>
  <?php  }
    }

    if (isset($_GET['idCat']) || isset($_GET['page']) || isset($_POST['submit'])) { ?>
        <script type="text/javascript">
            $(function() {
                $('body, html').animate({
                    scrollTop: '350px'
                }, 400);
            });
        </script>
    <?php } ?>

    <script>
 
  </script>
     <style>         
        .ui-slider.ui-slider-horizontal.ui-widget.ui-widget-content.ui-corner-all {
            background: #eaeaea none repeat scroll 0 0;
            border: medium none;
            height: 8px;
        }
        .ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
            border-radius:0;
        }

        .ui-slider-handle.ui-state-default.ui-corner-all {
            background: red none repeat scroll 0 0;
            border: medium none;
            height: 15px;
            position: absolute;
            top:3px;
            width: 15px;
        }
        #slider-range .ui-slider-range{
            background-color: #ff4136;
        }
    </style>


<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <!-- Start Header Style -->
        <header id="header" class="htc-header header--3 bg__white">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="images/logo/logo.png" alt="logo">
                                </a>
                            </div>
                        </div>
                        <!-- Start Mainmenu Area -->
                        <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">
                                        <div class="logo">
                                            <a href="index.html">
                                                <img src="images/logo/logo.png" alt="logo">
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Start MAinmenu Ares -->
                                    <div class="col-md-8 col-lg-8 col-sm-6 col-xs-6">
                                        <nav class="mainmenu__nav hidden-xs hidden-sm">
                                            <ul class="main__menu">
                                                <li class="drop"><a href="index.php">Trang chủ</a></li>

                                                <li class="drop"><a href="shop.php">Sản phẩm của chúng tôi</a>
                                                </li>
                                                <li><a href="help.php">Trợ giúp</a></li>
                                                <li><a href="contact.php">Liên hệ</a></li>
                                                <?php if (isset($_SESSION["id_user"])) echo '<li><a href="destroy.php">Đăng xuất</a></li>'; ?>
                                                <!-- End Single Mega MEnu -->
                                                <!-- Start Single Mega MEnu -->
                                            </ul>
                                        </nav>
                                        <div class="mobile-menu clearfix visible-xs visible-sm">
                                            <nav id="mobile_dropdown">
                                                <ul>
                                                    <li><a href="index.php">Trang chủ</a></li>
                                                    <li><a href="shop.php">Sản phẩm của chúng tôi</a></li>
                                                    <li><a href="help.php">Trợ giúp</a></li>
                                                    <li><a href="contact.php">Liên hệ</a></li>
                                                    <?php if (isset($_SESSION["id_user"])) echo '<li><a href="destroy.php">Đăng xuất</a></li>'; ?>

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <!-- End MAinmenu Ares -->
                                    <div class="col-md-2 col-sm-4 col-xs-3">
                                        <ul class="menu-extra">
                                            <li class="search search__open hidden-xs"><span class="ti-search"></span></li>
                                            <?php
                                            if (isset($_SESSION["id_user"])) {
                                                echo '<li><a href="account.php"><span class="ti-user">' . $_SESSION["userFirstName"] . '</span></a></li>';
                                            } else {
                                                echo '<li><a href="login-register.php"><span class="ti-user">Đăng nhập</span></a></li>';
                                            }
                                            ?>

                                            <?php if (isset($_SESSION["id_user"]))
                                                echo '<li class="cart__menu"><span class="ti-shopping-cart"></span><span class="cart-counter">' . $_SESSION["cartItems"] . '</span></li>';
                                            else
                                                echo '<li class="cart__menu"><a href="cart_logged_out.php"><span class="ti-shopping-cart"></span><span class="cart-counter">' . $_SESSION["cartItems"] . '</span></a></li>';
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mobile-menu-area"></div>
                            </div>
                        </div>
                        <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Style -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search__inner">
                                <form autocomplete="off" id="easysearch" role="search" method="POST" action="search.php">
                                    <input name="keyword" id="myInput" type="text" aria-label="Search" style="font-size: 20px;">
                                    <button type="submit" id="search" name="search"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close" style="color:black;"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
               <?php if (isset($_SESSION["id_user"])) {
                echo
                '<div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">';

                $total_prix = 0;
                $query = mysqli_query($con, "SELECT * from panier_produits join produit on produit.idProduit=panier_produits.idProduit where idClient= " . $_SESSION["id_user"] . " ");
                $num_Line = mysqli_num_rows($query);
                if ($num_Line == 0) echo ' <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title"></h2>
                                <nav class="bradcaump-inner">
                                    <span class="breadcrumb-item active">Votre panier est vide !</span>
                                    <a class="continuer" href="index.php">Continuer vos achats</a>                                    
                                </nav>
                            </div>';
                if($num_Line>=1){
                echo '<ul id="ticker">';
                while ($rowp = mysqli_fetch_array($query)) {
                    $image = $rowp["img_prod"];
                    $prix = $rowp['prix'] * (1 - $rowp['promo'] / 100);
                    $total_prix += $prix * $rowp['quantite'];
                    echo '
                            <li> <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="product-details.php?idprod=' . $rowp['idProduit'] . '">
                                    <img src="images/' . $image . '" alt="product images" style="width:265px;Height:67px;">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.php?idprod=' . $rowp['idProduit'] . '" style="text-transform: uppercase;">' . $rowp['nom_prod'] . '</a></h2>
                                <span class="quantity">Quantité: ' . $rowp['quantite'] . '</span>
                                <span class="shp__price">Prix unitaire : ' . $prix . ' DH</span>
                            </div>
                           
                        </div></li>';
                }

                echo '</ul>
                    </div>
                    ';
                    } echo'
                    <ul class="shoping__total">
                        <li class="subtotal">Sous-total:</li>
                        <li class="total__price">' . $total_prix . ' DH</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart_logged_in.php">Voir mon panier</a></li>
                    </ul>
                </div>
            </div>';

            } ?>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <?php
        include 'templates/bradcaump.php';

        renderBradcaump(
            'Sản phẩm của chúng tôi',
            [
                ['url' => 'index.php', 'text' => 'Trang chủ / '],
                ['text' => 'Sản phẩm của chúng tôi']
            ]
        ); ?>
        <!-- End Bradcaump area -->
        <!-- Start Our Product Area -->
        <div class="up-div"></div>
        <section  class="htc__product__area shop__page ptb--130 bg__white">
        	
            <div  class="container">
                <div  class="htc__product__container">
                    <!-- Start Product MEnu -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="filter__menu__container" >
                                <div class="product__menu" >
                                    <ul  class="main__menu">

                                        <li class="drop shop" style="width:150px;text-align: center;">
                                            <?php
                                            $checked = "";
                                            if (!isset($_GET['idCat'])) {

                                                $statement = mysqli_query($con, "SELECT * from produit where stock >0 order by idProduit DESC ");
                                                $num = mysqli_num_rows($statement);
                                                $checked = "is-checked";
                                            }
                                            ?>

                                            <a href="shop.php" <?php echo 'class=' . $checked . ''; ?>>
                                                <div class="link-content">
                                                    <div id="filter" class="nav-item">ALL </div>
                                                    
                                                </div>
                                            </a>
                                        </li>
                                        </form>

                                        <?php
                                        $query = "select * from categorie where idCat_parente=0";
                                        $run = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_array($run)) {
                                            $checked = (isset($_GET['idCat']) && $_GET['idCat'] == $row['idCategorie']) ? "is-checked" : "";
                                            $query1 = "select * from categorie where idCat_parente=" . $row['idCategorie'] . "";
                                            $run1 = mysqli_query($con, $query1);
                                            $total1 = mysqli_num_rows($run1);

                                            echo ' <li class="drop shop"  style="width:160px;text-align: center;">
                                            <a href="shop.php?idCat=' . $row['idCategorie'] . '"  class="' . $checked . '" >
                                                <div class="link-content">
                                                    <div class="nav-item">
                                                        <span class="category-name">' . $row['desp_cat'] . '</span>';
                                            if ($total1 > 1) echo '<span class="down-arrow"></span>';
                                                echo '      </div>
                                                </div></a>';
                                            if ($total1 > 1) {
                                                echo '<ul class="dropdown" >';

                                                while ($row1 = mysqli_fetch_array($run1)) {
                                                    $checked = (isset($_GET['idCat']) && $_GET['idCat'] == $row1['idCategorie']) ? "is-checked" : "";
                                                    echo '<li>
                                                <a  href="shop.php?idCat=' . $row1['idCategorie'] . '"  class="'.$checked.'">
                                                    <div class="sub-link-content">
                                                        <div class="sub-nav-item">' . $row1['desp_cat'] . '</div>
                                                    </div>
                                                </a>
                                            </li>
                                            ';
                                            }
                                                echo '</ul>';
                                            }
                                            echo '</li>';
                                        }


                                        ?>

                                    </ul>
                                </div>
                                <div class="filter__box">
                                    <a class="filter__menu" style="position:absolute;margin-top:0px;" href="#">filter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Filter Menu -->
                    <div class="filter__wrap">
                        <div class="filter__cart">
                            <div class="filter__cart__inner">
                                <div style="top:0px;height:50px;" class="filter__menu__close__btn">
                                    <a href="#"><i class="zmdi zmdi-close"></i></a>
                                </div>
                                <div class="filter__content" >
                                    <!-- Start Single Content -->
                                    <div class="fiter__content__inner" >
                                       <?php echo ' <form method="POST" action=" ';  if (isset($_GET['idCat'])) echo 'shop.php?idCat='.$_GET['idCat'].' '; else { echo 'shop.php';} echo ' " style="width:100%;">';



                                       ?>
                                        <div class="single__filter">
                                            <h2 class="side-title s1">Giá(VNĐ)</h2>
                                          <div style="width:400px;" id="slider-range"></div>
                                              <p>
                                                <input type="text" name="amount" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                              </p>
                                        </div>
                                        <div class="single__filter" style="width: 400px;margin-top: 5px;">
                                            <h2 class="side-title s5" style="width:300px;">Sắp xếp theo</h2><br>
                                          
                                             <div class="radio" style="width:400px;">
                                                <input type="radio" name="sortby" value="nomaz" ><label style="font-size:16px;"> Tên: Từ A đến Z
                                                </label>
                                                </div>
                                             <div class="radio">
                                                <input type="radio" name="sortby" value="nomza" ><label style="font-size:16px;"> Tên: Từ Z đến A
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" name="sortby" value="prixc" ><label style="font-size:16px;"> Giá: Từ thấp đến cao
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <input type="radio" name="sortby" value="prixd" ><label style="font-size:16px;"> Giá: Từ cao đến thấp
                                                </label>
                                            </div>

                                        </div>





                                        <div class="single__filter" >
                                            <h2 class="side-title s2">Thương hiệu</h2>

                                           <br>
                                                
                                                    

                                            <?php 
                                            $q=mysqli_query($con,"SELECT * from brand" );
                                            while($rw=mysqli_fetch_array($q))
                                            {
                                                echo '
                                                <div class="checkbox">
                                                <input type="checkbox" name="brand[]" value="'.$rw['brand'].'" ><label style="font-size:16px;"> '.$rw["brand_nom"].'
                                                </label>
                                                </div>
                                                
                                                ';

                                            }
                                            
                                            ?>
                                       

                                             
                                         <div class="single__filter" >
                                            <h2 class="side-title s3" >Giảm giá</h2>

                                            <br>
                                             
                                            <?php 
                                           $nbi=10;
                                            while($nbi<60)
                                            {
                                                echo '
                                                <div class="radio" style="width:200px;" >
                                                <input type="radio" name="remise" value="'.$nbi.'"  ><label style="font-size:16px;"> '.$nbi.'% trở lên
                                                </label>
                                                </div>
                                                
                                                ';
                                                $nbi+=10;

                                            }
                                            
                                            ?>                                         
                                        </div>

                                         <div class="single__filter" style="width: 400px;">
                                            <h2 class="side-title s4" >Gửi từ</h2><br>
                                          
                                             <div class="checkbox" style="width:400px;">
                                                <input type="checkbox" name="expedie[]" value="1" ><label style="font-size:16px;"> Gửi từ Morocco
                                                </label>
                                                </div>
                                             <div class="checkbox">
                                                <input type="checkbox" name="expedie[]" value="2" ><label style="font-size:16px;"> Gửi từ nước ngoài
                                                </label>
                                            </div>
                                        </div>


                                        



                                            <div class="s-filter" style="position: absolute;width:30%;margin-top: -20px;left:300px;">
                                                <input id="filtrer" type="submit" value="Lọc" name="submit">
                                            </div>

                                                  
                                        </div>
                                        </form>
                                        
                                    
                                    </div>
                                    <!-- End Single Content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Filter Menu -->
                    <!-- End Product MEnu -->
  
                    <div class="row">
                        <div class="product__list another-product-style">


                            <?php
                            echo '<br><div class="pro__dtl__color" style="text-align: center;">
                                      <h2 class="title__5">';
                                       
                            if (isset($_GET["idCat"])) {
                                for ($i = 0; $i < count($patal); $i++) {
                                    if ($i == 0) {
                                        echo $patal[$i];
                                    } else {
                                        echo ' > ' . $patal[$i];
                                    }
                                }
                            }




                            echo '</h2></div>';





                             $amount=0;
                                $min=5;$maxi=3000;
                                $remise=0;
                                $sortby="";
                                $expedie=array(1,2);
                                $brand=array(0,1,2,3,4,5,6,7,8); 

                                $ids = join(",",$brand);
                            $remise=(int)$remise;
                             $exp=join(",",$expedie);   

                             $send_submit=array('prixmin'=>$min,
                                            'prixmax'=>$maxi,
                                            'sortby'=>$sortby,
                                            'ids'=>$ids,
                                            'remise'=>$remise,
                                            'exp'=>$exp
                                          );  

                            if(isset($_GET['idCat']))  
                            {
                                $request="SELECT * from produit join categorie on categorie.idCategorie=produit.idCategorie where  stock >0 and idCat_parente=" . $_GET['idCat'] . " ";
                                $run = mysqli_query($con,$request);
                                $num = mysqli_num_rows($run);
                                if (getParent($_GET['idCat']) != 0 || $num == 0) {
                                    $request =  "SELECT * from produit where idCategorie=" . $_GET['idCat'] . " and stock >0 order by idProduit DESC ";
                                    $run = mysqli_query($con, $request);
                                    $num = mysqli_num_rows($run);
                                }


                                if(isset($_POST['submit'])   && $_POST['submit']=="filtrer" ){
 
                                    $amount=$_POST['amount'];
                                     $amount_array=explode("-",$amount);
                                    $min=substr($amount_array[0],1);
                                    $maxi=substr($amount_array[1],2);
    
                                    if(!empty($_POST['brand'])){
                                    $brand=$_POST['brand'];

                            }

                                 if(!empty($_POST['remise'])){
                                    $remise=$_POST['remise'];

                            }
                             if(!empty($_POST['expedie'])){
                                    $expedie=$_POST['expedie'];

                            }
                            if(!empty($_POST['sortby'])){
                                    $sortby=$_POST['sortby'];

                            }
                            

                            $ids = join(",",$brand);
                            $remise=(int)$remise;
                             $exp=join(",",$expedie); 

                            $send_submit=array('prixmin'=>$min,
                                            'prixmax'=>$maxi,
                                            'sortby'=>$sortby,
                                            'ids'=>$ids,
                                            'remise'=>$remise,
                                            'exp'=>$exp
                                          );

                            $ordre=" order by idProduit DESC ";

                            if($sortby=="nomaz") 
                            $ordre=" order by nom_prod ";
                            if($sortby=="nomza")
                             $ordre=" order by nom_prod DESC ";
                            if($sortby=="prixc")
                             $ordre=" order by aprix ";
                            if($sortby=="prixd")
                             $ordre=" order by aprix DESC "; 

                               

                            $request = "SELECT *,prix*(1-0.01*promo) as aprix FROM produit  join categorie on categorie.idCategorie=produit.idCategorie where stock >0 and idCat_parente=" . $_GET['idCat'] . "   AND  prix*(1-0.01*promo) between $min and $maxi and brand IN ($ids) and promo >= $remise and expedie in ($exp) ";
                            $request.=$ordre;
                            $run = mysqli_query($con, $request);
                             $num = mysqli_num_rows($run);
                               if (getParent($_GET['idCat']) != 0 || $num == 0) {                                     
                                    $request =  "SELECT *,prix*(1-0.01*promo) as aprix from produit where  prix*(1-0.01*promo) between $min and $maxi and brand IN ($ids) and promo >= $remise and expedie in ($exp) and idCategorie=" . $_GET['idCat'] . " and stock >0  ";
                                      $request.=$ordre;

                                     $run = mysqli_query($con, $request);

                                    $num = mysqli_num_rows($run);
                                }

                            }

//222222222222222222222222222222222222222222222222222222222222

                            else if(isset($_GET['prixmax'])){

                              
                                    $min=$_GET['prixmin'];
                                    $maxi=$_GET['prixmax'];
                      
                                    $ids=$_GET['ids'];

                                    $remise=$_GET['remise'];

                                    $exp=$_GET['exp'];

                                    $sortby=$_GET['sortby'];

                            
                            

                            $send_submit=array('prixmin'=>$min,
                                            'prixmax'=>$maxi,
                                            'sortby'=>$sortby,
                                            'ids'=>$ids,
                                            'remise'=>$remise,
                                            'exp'=>$exp
                                          );

                            $ordre=" order by idProduit DESC ";

                            if($sortby=="nomaz") 
                            $ordre=" order by nom_prod ";
                            if($sortby=="nomza")
                             $ordre=" order by nom_prod DESC ";
                            if($sortby=="prixc")
                             $ordre=" order by aprix ";
                            if($sortby=="prixd")
                             $ordre=" order by aprix DESC "; 

                               

                            $request = "SELECT *,prix*(1-0.01*promo) as aprix FROM produit  join categorie on categorie.idCategorie=produit.idCategorie where stock >0 and idCat_parente=" . $_GET['idCat'] . "   AND  prix*(1-0.01*promo) between $min and $maxi and brand IN ($ids) and promo >= $remise and expedie in ($exp) ";
                            $request.=$ordre;
                            $run = mysqli_query($con, $request);
                             $num = mysqli_num_rows($run);
                               if (getParent($_GET['idCat']) != 0 || $num == 0) {                                     
                                    $request =  "SELECT *,prix*(1-0.01*promo) as aprix from produit where  prix*(1-0.01*promo) between $min and $maxi and brand IN ($ids) and promo >= $remise and expedie in ($exp) and idCategorie=" . $_GET['idCat'] . " and stock >0  ";
                                      $request.=$ordre;

                                     $run = mysqli_query($con, $request);

                                    $num = mysqli_num_rows($run);
                                }

                            }
                        
                            }
                            else {
                                   
                                   if(isset($_POST['submit'])   && $_POST['submit']=="filtrer" ){


                                $amount=$_POST['amount'];
                                $amount_array=explode("-",$amount);
                                $min=substr($amount_array[0],1);
                                $maxi=substr($amount_array[1],2);
    
                                if(!empty($_POST['brand'])){
                                    $brand=$_POST['brand'];

                            }
                            
                             if(!empty($_POST['remise'])){
                                    $remise=$_POST['remise'];

                            }
                            if(!empty($_POST['expedie'])){
                                    $expedie=$_POST['expedie'];

                            }
                             if(!empty($_POST['sortby'])){
                                    $sortby=$_POST['sortby'];

                            }

                            $remise=(int)$remise;

                            $ids = join(",",$brand);
                            $exp=join(",",$expedie);   

                             $send_submit=array('prixmin'=>$min,
                                            'prixmax'=>$maxi,
                                            'sortby'=>$sortby,
                                            'ids'=>$ids,
                                            'remise'=>$remise,
                                            'exp'=>$exp
                                          );

                            $ordre=" order by idProduit DESC ";


                            if($sortby=="nomaz") 
                            $ordre=" order by nom_prod ";
                            if($sortby=="nomza")
                             $ordre=" order by nom_prod DESC ";
                            if($sortby=="prixc")
                             $ordre=" order by aprix ";
                            if($sortby=="prixd")
                             $ordre=" order by aprix DESC "; 

 
                            $request = "SELECT *,prix*(1-0.01*promo) as aprix  FROM produit   where prix*(1-0.01*promo) between $min and $maxi and brand IN ($ids) and promo >= $remise and expedie in ($exp)  and stock > 0  ";
                           $request.=$ordre;
                            $run = mysqli_query($con, $request);
                             $num = mysqli_num_rows($run);
                            }
                             elseif(isset($_GET['prixmax'])) {


                                 $min=$_GET['prixmin'];
                                    $maxi=$_GET['prixmax'];
                      
                                    $ids=$_GET['ids'];

                                    $remise=$_GET['remise'];

                                    $exp=$_GET['exp'];

                                    $sortby=$_GET['sortby'];

                            

                            $send_submit=array('prixmin'=>$min,
                                            'prixmax'=>$maxi,
                                            'sortby'=>$sortby,
                                            'ids'=>$ids,
                                            'remise'=>$remise,
                                            'exp'=>$exp
                                          );

                            $ordre=" order by idProduit DESC ";

                            if($sortby=="nomaz") 
                            $ordre=" order by nom_prod ";
                            if($sortby=="nomza")
                             $ordre=" order by nom_prod DESC ";
                            if($sortby=="prixc")
                             $ordre=" order by aprix ";
                            if($sortby=="prixd")
                             $ordre=" order by aprix DESC "; 

                               

                         $request = "SELECT *,prix*(1-0.01*promo) as aprix  FROM produit   where prix*(1-0.01*promo) between $min and $maxi and brand IN ($ids) and promo >= $remise and expedie in ($exp)  and stock > 0  ";
                           $request.=$ordre;
                            $run = mysqli_query($con, $request);
                             $num = mysqli_num_rows($run);
                            }


                            else {

                                $request= "SELECT * from produit where stock >0 order by idProduit DESC ";
                                $run = mysqli_query($con, $request);
                                $num = mysqli_num_rows($run);
                            }
                        }
                            //----------------------------------------------------------------

                            $max = ($num % 16 != 0) ? (int)($num / 16) + 1 :  (int)($num / 16);
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;

                            $page =  16 * ($page - 1);


                            //-----------------------------------------------------------------------------
                            //-----------------------------------------------------------------------------
                            $request.="limit $page,16";
                            $run = mysqli_query($con, $request);
                           //--------------------------------------------------------------------
                         
                            while ($row = mysqli_fetch_array($run)) {
                                $image = "images/" . $row['img_prod'] . "";
                                $new_price = $row['prix'] * (1 - $row['promo'] * 0.01);
                                echo '
                                  
                                            <div class="col-md-3 single__pro col-lg-3  col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="product-details.php?idprod=' . $row['idProduit'] . '">
                                                                <img src="' . $image .
                                    '" alt="product images" style="width:270px;height:270px;">
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
                                echo '                  </div>
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





                            ?>

                            <!-- Start Single Product -->



                            <!-- End Single Product -->
                        </div>
                        <div class="slider-frame">

                            <ul class="slider-nav">
                                <?php
                                if ($max > 1) {
                                    if (!isset($_GET['page'])) {                                       

                                        if (isset($_GET['idCat'])) {

                                            $new_path_left = "shop.php?page=$max&idCat=" . $_GET['idCat'] . "&". http_build_query($send_submit) ."";
                                            $new_path_right = "shop.php?page=2&idCat=" . $_GET['idCat'] . "&". http_build_query($send_submit) ."";
                                        } else {
                                            $new_path_left = "shop.php?page=$max&". http_build_query($send_submit) ."";
                                            $new_path_right = "shop.php?page=2&". http_build_query($send_submit) ."";
                                        }
                                    }else {
                                        $p_left = $_GET['page'] - 1;
                                        $p_right = $_GET['page'] + 1;
                                        $new_path_left = isset($_GET['idCat']) ? "shop.php?page=$p_left&idCat=" . $_GET['idCat'] . "&". http_build_query($send_submit) ."": "shop.php?page=$p_left&". http_build_query($send_submit) ."";
                                        $new_path_right = isset($_GET['idCat']) ? "shop.php?page=$p_right&idCat=" . $_GET['idCat'] . "&". http_build_query($send_submit) ."" : "shop.php?page=$p_right&". http_build_query($send_submit) ."";



                                        if ($_GET['page'] == 1) {
                                            $new_path_left = isset($_GET['idCat']) ? "shop.php?page=$max&idCat=" . $_GET['idCat'] . "&". http_build_query($send_submit) ."" : "shop.php?page=$max&". http_build_query($send_submit) ."";
                                        } elseif ($_GET['page'] == $max) {
                                            $new_path_right = isset($_GET['idCat']) ? "shop.php?page=1&idCat=" . $_GET['idCat'] . "&". http_build_query($send_submit) ."" : "shop.php?page=1&". http_build_query($send_submit) ."";
                                        }
                                    }

                                    echo '<a href="' . $new_path_left . '" id="left-icon"><i id="ng_left" class="zmdi zmdi-chevron-left" ></i></a>';

                                    $i = 1;

                                    while ($i <= $max) {
                                        $class = !isset($_GET['page']) ? "active" : "";
                                        echo '
                                               <li><a  href="shop.php?page=' . $i . '&'. http_build_query($send_submit) .' "';
                                        if ($i == 1 && !isset($_GET['page'])) echo ' class="active" ';
                                        elseif (isset($_GET['page']) && $i == $_GET['page']) echo ' class="active" ';
                                        echo ' >' . $i . '</a></li>

                                            ';
                                        $i++;
                                    }



                                    echo '<a href="' . $new_path_right . '" ><i id="ng_right" class="zmdi zmdi-chevron-right" style="font-size: 30px;position:absolute;text-align: center;line-height:25px;margin-bottom: -2px;line-height:25px;"></i></a>';
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Start Load More BTn -->
                    <div class="row mt--60">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <!-- End Load More BTn -->
                </div>
            </div>
        </section>
        <!-- End Our Product Area -->
        <!-- Start Footer Area -->
        <?php include 'templates/footer.php'; ?>
        <!-- End Footer Area -->
    </div>
    <!-- Body main wrapper end -->
    <?php include 'templates/quickview_product.php'; ?>
    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>

     <script src="js/jquery-ui.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>
    <script src="js/search.js"></script>
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