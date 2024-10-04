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
$keysearch="";
if (isset($_POST['search'])  ) 
   $keysearch=$_POST['keyword'];
elseif(isset($_GET['search']))  $keysearch=$_GET['search'];
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
        <!-- Bắt đầu Kiểu Header -->
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
                                    <span class="breadcrumb-item active">Giỏ hàng của bạn trống!</span>
                                    <a class="continuer" href="index.php">Tiếp tục mua sắm</a>                                    
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
                                    <img src="images/' . $image . '" alt="hình ảnh sản phẩm" style="width:265px;Height:67px;">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="product-details.php?idprod=' . $rowp['idProduit'] . '" style="text-transform: uppercase;">' . $rowp['nom_prod'] . '</a></h2>
                                <span class="quantity">Số lượng: ' . $rowp['quantite'] . '</span>
                                <span class="shp__price">Đơn giá: ' . $prix . ' VNĐ</span>
                            </div>
                           
                        </div></li>';
                }

                echo '</ul>
                    </div>
                    ';
                    } echo'
                    <ul class="shoping__total">
                        <li class="subtotal">Tổng phụ:</li>
                        <li class="total__price">' . $total_prix . ' VNĐ</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart_logged_in.php">Xem giỏ hàng của tôi</a></li>
                    </ul>
                </div>
            </div>';

            } ?>
            <!-- Kết thúc Bảng điều khiển Giỏ hàng -->
        </div>
        <!-- Kết thúc Offset Wrapper -->
        <!-- Bắt đầu khu vực Bradcaump -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Sản phẩm của chúng tôi</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                                    <span class="brd-separetor">></span>
                                    <span class="breadcrumb-item active">Sản phẩm của chúng tôi</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu Khu vực Sản phẩm của Chúng tôi -->
        <section class="htc__product__area shop__page ptb--130 bg__white">
            <div class="container">
                <div class="htc__product__container">
                    <!-- Bắt đầu Menu Sản phẩm -->
                    
                    <!-- Bắt đầu Menu Lọc -->
                   
                    <!-- Kết thúc Menu Lọc -->
                    <!-- Kết thúc Menu Sản phẩm -->

                            <?php
                           $num=0;
                            $keysearch="";
                            if (isset($_POST['search'])  ) {
                                $keysearch=$_POST['keyword'];
                                $run = mysqli_query($con, "SELECT * from produit where stock>0 and nom_prod like '%{$keysearch}%'    ");
                                $num = mysqli_num_rows($run);
                                if($_POST['keyword']=="") $num=0;
                                 
                           }
                           elseif(isset($_GET['search']) ){
                            $keysearch=$_GET['search'];
                                $run = mysqli_query($con, "SELECT * from produit where stock>0 and nom_prod like '%{$keysearch}%'    ");
                                $num = mysqli_num_rows($run);
                           }

                           echo '<div class="pro__dtl__color" style="text-align: center;">
                                      <h2 class="title__5" style="font-size:30px;">';
                                 if($num!=0){
                                if($num == 1) echo $num.' kết quả'; else echo $num.' kết quả';}
                            else echo 'không có kết quả phù hợp..';
                                echo '</h2></div>';

                            $max = ($num % 16 != 0) ? (int)($num / 16) + 1 :  (int)($num / 16);
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;

                            $page =  16 * ($page - 1);
          
                            if(isset($_POST['search'])) {
                                $keyword=$_POST['keyword'];
                                $run=mysqli_query($con, "SELECT * from produit where stock >0 and nom_prod like '%{$keyword}%'   limit $page, 16 ");
                            }
                            elseif(isset($_GET['search']) ){
                                 $keysearch=$_GET['search'];
                                $run = mysqli_query($con, "SELECT * from produit where stock>0 and nom_prod like '%{$keysearch}%' limit $page, 16    ");
                                $num = mysqli_num_rows($run);
                           }
                echo '<div class="row">
                        <div class="product__list another-product-style">';
                            
                          if($num!=0){
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
                                    '" alt="hình ảnh sản phẩm" style="width:270px;height:270px;">
                                                            </a>
                                                        </div>';
                                if (isset($_SESSION["id_user"])) {
                                    $query2 = "SELECT idProduit FROM envie WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
                                    $result2 = mysqli_query($con, $query2);
                                    echo '<div class="product__hover__info">
                                                                <ul class="product__action">';
                                    if (mysqli_num_rows($result2) == 0) {

                                        echo '<li><a title="Thêm ♥" class="add" href="#/"><span class="ti-heart"></span></a></li>';
                                    } else {
                                        echo '<li><a title="Đã thêm ♥" href="#/"><span class="ti-check-box" style="font-size: 25x;">Yêu thích</span></a></li>';
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
                                                                     <li><a title="Thêm ♥" href="login-register.php"><span class="ti-heart"></span></a></li>
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

                                                            echo'<li class="old__price">' . $row['prix'] . ' VNĐ</li>
                                                            
                                                           
                                                            <li class="new__price">' . $new_price . ' VNĐ</li>';}
                                                            else {
                                                                 echo'<li class="new__price" >' . $row['prix'] . ' VNĐ</li>';
                                                            }
                                                       echo' </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            ';
                            }


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
                                        if (isset($_POST['search'])) {
                                            $new_path_left = "search.php?page=$max&search=" . $_POST['keyword'] . "";
                                            $new_path_right = "search.php?page=2&search=" . $_POST['keyword'] . "";
                                        } else {
                                            $new_path_left = "search.php?page=$max";
                                            $new_path_right = "search.php?page=2";
                                        }
                                    } else {
                                        $p_left = $_GET['page'] - 1;
                                        $p_right = $_GET['page'] + 1;
                                        $new_path_left = isset($_GET['search']) ? "search.php?page=$p_left&search=" . $_GET['search'] . "" : "search.php?page=$p_left";
                                        $new_path_right = isset($_GET['search']) ? "search.php?page=$p_right&search=" . $_GET['search'] . "" : "search.php?page=$p_right";





                                        if ($_GET['page'] == 1) {
                                            $new_path_left = isset($_GET['search']) ? "search.php?page=$max&search=" . $_GET['search'] . "" : "search.php?page=$max";
                                        } elseif ($_GET['page'] == $max) {
                                            $new_path_right = isset($_GET['search']) ? "search.php?page=1&search=" . $_GET['search'] . "" : "search.php?page=1";
                                        }
                                    }

                                    echo '<a href="' . $new_path_left . '" id="left-icon"><i id="ng_left" class="zmdi zmdi-chevron-left" ></i></a>';

                                    $i = 1;

                                    while ($i <= $max) {
                                        $class = !isset($_GET['page']) ? "active" : "";
                                        $lien="search.php?page=$i&search=$keysearch"; 
                                        echo '
                                               <li><a href="'.$lien.'" ';
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
                    <!-- Bắt đầu nút Tải thêm -->
                    <div class="row mt--60">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <!-- Kết thúc nút Tải thêm -->
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

 <script>
        const button=document.querySelector('button[type="submit"]');
button.disabled=true;
  function autocomplete(inp, arr, arr2) {

  var currentFocus;
  
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
     
      closeAllLists();
     if(!val) {
        const button=document.querySelector('button[type="submit"]');
button.disabled=true;

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

if( val=="" || val==" " || val=="  " || val=="   " || val=="    " || val.indexOf("    " )>-1){

    const button=document.querySelector('button[type="submit"]');
button.disabled=true;
const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Apply the stylesheet to a document:
document.adoptedStyleSheets = [sheet];

}    
else{
      var y=0;
      for (i = 0; i < arr.length; i++) { 
   for(var l=0;l<arr[i].length;l++){
        if (arr[i].substr(l, val.length).toUpperCase() == val.toUpperCase() ) {
            console.log(arr[i]);
          y++;

          l=document.createElement("a");
          l.href="product-details.php?idprod=" + arr2[i];
          ul=document.createElement("ul");
          b = document.createElement("DIV");
          b.className='good';
          li=document.createElement("li");
          li.setAttribute("class", "li_search");   
          p=document.createElement("p");
          p.setAttribute("class","p-search");

 
          p.innerHTML += "<a style='color:black;' href='product-details.php?idprod=" + arr2[i] + "'>" + arr[i] + "</a>";
          
          var iconurl =  <?php echo json_encode($arrimage); ?>;
          var img = document.createElement("img"); 
            img.src=iconurl[i];
            img.width=50;
             img.height=50;
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
      if(y>7) {
        console.log(y);
          b.setAttribute("id", "invisible_");
          
          const sheet = new CSSStyleSheet();
           sheet.replaceSync('.autocomplete-items {height: 371px}');

// Apply the stylesheet to a document:
          document.adoptedStyleSheets = [sheet];
          const button=document.querySelector('button[type="submit"]');
          button.disabled=false;
 }
 else if(y==0) {
          b = document.createElement("DIV");
          b.className='good';
          p=document.createElement("p");
          p.setAttribute("class","p-search");

 
          p.innerHTML += "<p style='color:black;' > không có kết quả..</a>";              
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

const button=document.querySelector('button[type="submit"]');
button.disabled=true;
 }
 else {
    const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Apply the stylesheet to a document:
document.adoptedStyleSheets = [sheet];
const button=document.querySelector('button[type="submit"]');
button.disabled=false;
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
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

var myvar = <?php echo json_encode($arr); ?>;
var myvar2 = <?php echo json_encode($arr2); ?>;
autocomplete(document.getElementById("myInput"), myvar, myvar2);
</script>
</body>

</html>