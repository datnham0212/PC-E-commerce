$(document).ready(function () {
    $("#account-form").submit(function (e) {
        e.preventDefault();
        $('.comments').empty();
        var postdata = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'manageAccount.php',
            data: postdata,
            dataType: 'json',
            success: function (result) {
                if (result.isSuccess) {
                    $('#account-form')[0].reset();
                    showStatus('#account-status', 'Modifications enregistrées avec succès', '#4a934a');
                    updateFormFields(result);
                } else if (result.emailError) {
                    showStatus('#email-status', 'e-mail invalide !', '#ff4136');
                }
            }
        });
    });

    function showStatus(selector, message, color) {
        $(selector).css('color', color).html(message).show().delay(5000).fadeOut(400);
    }

    function updateFormFields(result) {
        $('#firstName').val(result.firstName);
        $('#lastName').val(result.lastName);
        $('#email').val(result.email);
        $('#tel').val(result.tel);
    }
});

