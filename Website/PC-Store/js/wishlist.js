$(document).ready(function () {
    function handleRemoveWish(e) {
        e.preventDefault();
        var $form = $(this);
        $form.addClass("flag");

        $.ajax({
            type: 'POST',
            url: 'removeWish.php',
            data: $form.serialize(),
            dataType: 'json',
            success: function (result) {
                if (result.isSuccess) {
                    if (result.wishItems > 0) {
                        $('.flag').parents("tr").remove();
                    } else {
                        replaceWishlistWithEmptyMessage();
                    }
                } else {
                    alert("Erreur de suppression !");
                }
                $('.flag').removeClass("flag");
            }
        });
    }

    function handleAddWish(e) {
        e.preventDefault();
        var $form = $(this);
        $form.addClass("flag");

        $.ajax({
            type: 'POST',
            url: 'addWishToCart.php',
            data: $form.serialize(),
            dataType: 'json',
            success: function (result) {
                if (result.isSuccess) {
                    $(".cart-counter").html(result.cartItems);
                    $(".flag a").replaceWith('<span class="wish-added">Produit ajouté au panier</span>');
                    if (result.wishItems > 0) {
                        $('.flag').parents("tr").delay(2000).queue(function () { $(this).remove(); });
                    } else {
                        $('#wishlist').delay(2000).queue(function () { replaceWishlistWithEmptyMessage(); });
                    }
                } else {
                    alert("Erreur d'ajout !");
                }
                $('.flag').removeClass("flag");
            }
        });
    }

    function replaceWishlistWithEmptyMessage() {
        var emptyWishlistHtml = '<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">' +
            '<div class="ht__bradcaump__wrap">' +
            '<div class="container">' +
            '<div class="row">' +
            '<div class="col-xs-12">' +
            '<div class="bradcaump__inner text-center">' +
            '<nav class="bradcaump-inner">' +
            '<span class="breadcrumb-item active">Votre liste d\'envies est vide !</span>' +
            '<a class="continuer" href="index.php">Continuer vos achats</a>' +
            '</nav>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $('#wishlist').replaceWith(emptyWishlistHtml);
    }

    $(".remove-wish a").click(function () {
        $(this).parents(".remove-wish").submit();
    });

    $(".remove-wish").submit(handleRemoveWish);

    $(".add-wish a").click(function () {
        $(this).parents(".add-wish").submit();
    });

    $(".add-wish").submit(handleAddWish);

    $(".buttons-cart input:first").click(function (e) {
        $.ajax({
            type: 'POST',
            url: 'resetWishList.php',
            data: "",
            dataType: 'json',
            success: function (result) {
                replaceWishlistWithEmptyMessage();
            }
        });
    });
});
