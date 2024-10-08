$(document).ready(function () {
    function handleAjaxResponse(result, successCallback, errorCallback) {
        if (result.isSuccess) {
            successCallback(result);
        } else {
            errorCallback(result);
        }
    }

    function updateCartStatus(message, isSuccess) {
        $('#cart-status')
            .css('color', isSuccess ? '#4a934a' : '#ff4136')
            .html(message)
            .show()
            .delay(5000)
            .fadeOut(400);
    }

    function updateCartCounter(count) {
        $(".cart-counter").html(count);
    }

    $("#cart-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'manage-cart.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (result) {
                handleAjaxResponse(result,
                    function (data) {
                        updateCartStatus('Produit ajouté avec succès', true);
                        updateCartCounter(data.cartItems);
                    },
                    function () {
                        updateCartStatus('Produit épuisé', false);
                    }
                );
            }
        });
    });

    $(":input").change(function () {
        $(this).parents(".change-quantity").submit();
    });

    $(".change-quantity").submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        $form.addClass("flag");

        $.ajax({
            type: 'POST',
            url: 'quantity.php',
            data: $form.serialize(),
            dataType: 'json',
            success: function (result) {
                handleAjaxResponse(result,
                    function (data) {
                        $('.flag').parents(".product-quantity").next().html(data.total);
                        $('form.flag > input:first').attr("value", data.quantite);
                        updateCartCounter(data.cartItems);
                        $('#sous_amount').html(data.global + ' DH');
                        $('#final_amount').html(data.global2 + ' DH');
                    },
                    function (data) {
                        var newValue = data.quantite <= 0 ? "1" : data.stock;
                        $('form.flag > input:first').attr("value", newValue);
                        alert("quantité invalide !");
                    }
                );
                $('.flag').removeClass("flag");
            }
        });
    });

    $(".remove-product a").click(function () {
        $(this).parents(".remove-product").submit();
    });

    $(".remove-product").submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        $form.addClass("flag");

        $.ajax({
            type: 'POST',
            url: 'remove.php',
            data: $form.serialize(),
            dataType: 'json',
            success: function (result) {
                handleAjaxResponse(result,
                    function (data) {
                        if (data.cartItems == 0) {
                            location.href = data.isLogged ? "cart_logged_in.php" : "cart_logged_out.php";
                        } else {
                            $('.flag').parents("tr").remove();
                            updateCartCounter(data.cartItems);
                        }
                    },
                    function () {
                        alert("erreur de suppression !");
                    }
                );
                $('.flag').removeClass("flag");
            }
        });
    });

    $('input[type=radio][name=type_livraison]').change(function () {
        $(this).parents(".livraison").submit();
    });

    $(".livraison").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'livraison.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (result) {
                $('#final_amount').html(result.total + ' DH');
            }
        });
    });

    $(".wc-proceed-to-checkout a").click(function () {
        $(this).parents(".achat").submit();
    });

    $(".achat").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'commande.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (result) {
                if (result.isEmpty) {
                    $('#cmdError')
                        .css('color', '#d82c2e')
                        .html('Votre panier est vide!')
                        .show()
                        .delay(5000)
                        .fadeOut(400);
                } else {
                    location.href = "checkout.php";
                }
            }
        });
    });

    $(".buttons-cart a:first").click(function (e) {
        $.ajax({
            type: 'POST',
            url: 'resetCart.php',
            data: "",
            dataType: 'json',
            success: function (result) {
                location.href = result.isLogged ? "cart_logged_in.php" : "cart_logged_out.php";
            }
        });
    });
});
