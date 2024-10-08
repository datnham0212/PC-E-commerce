$(document).ready(function () {
    function handleFormSubmit(formId, url) {
        $(formId).submit(function (e) {
            e.preventDefault();
            $('.comments').empty();
            var postdata = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: postdata,
                dataType: 'json',
                success: function (result) {
                    if (result.isSuccess || result.isSuccessClient || result.isSuccessAdmin) {
                        $(formId)[0].reset();
                        if (result.isSuccessAdmin) {
                            location.href = "admin/index.php";
                        } else if (result.isCart) {
                            location.href = "checkout.php?isCart=1";
                        } else {
                            location.href = "index.php";
                        }
                    } else {
                        displayErrors(result, formId);
                    }
                }
            });
        });
    }

    function displayErrors(result, formId) {
        if (formId === '#register-form') {
            $('#firstname + .comments').html(result.firstnameError);
            $('#name + .comments').html(result.nameError);
            $('#email + .comments').html(result.emailError);
            $('#password ~ .comments').html(result.passwordError);
        } else if (formId === '#login-form') {
            $('#email2 + .comments').html(result.emailError);
            $('#password2 ~ .comments').html(result.passwordError);
        }
    }

    handleFormSubmit("#register-form", "register.php");
    handleFormSubmit("#login-form", "login.php");
});
