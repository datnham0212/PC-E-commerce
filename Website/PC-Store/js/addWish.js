$(document).ready(function () {
    function handleWishlistSubmit(e) {
        e.preventDefault();
        var $form = $(this);
        var postdata = $form.serialize();
        $form.addClass("flag");

        $.ajax({
            type: 'POST',
            url: 'addWish.php',
            data: postdata,
            dataType: 'json',
            success: function (result) {
                if (result.isSuccess) {
                    updateWishlistUI($form);
                } else {
                    alert("Erreur d'ajout !");
                    $form.removeClass("flag");
                }
            }
        });
    }

    function updateWishlistUI($form) {
        if ($form.attr('id') === 'add-wish') {
            $form.prev("#cart-form").find(".pro__dtl__btn .add").replaceWith('<li class="add"><a title="Ajouté ♥" href="#/" class="add"><span class="ti-heart" style="color: red; font-weight: bolder"></span></a></li>');
            $('#cart-status').css('color', '#4a934a').html('Produit ajouté à la liste d\'envies').show().delay(5000).fadeOut(400);
        } else {
            $form.prev(".product__action").find("li").replaceWith('<li><a title="Ajouté ♥" href="#/"><span class="ti-check-box" style="font-size: 25px; color: red">Favori</span></a></li>');
        }
    }

    $('.product__action a').click(function () {
        $(this).closest(".product__action").next().submit();
    });

    $('a.add').closest(".product__action").next().submit(handleWishlistSubmit);

    $('.pro__dtl__btn a').click(function () {
        $("#add-wish").submit();
    });

    $("#add-wish").submit(handleWishlistSubmit);
});
