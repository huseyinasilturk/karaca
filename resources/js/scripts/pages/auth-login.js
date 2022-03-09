$(function () {
    ("use strict");

    var pageLoginForm = $(".auth-login-form");

    // jQuery Validation
    // --------------------------------------------------------------------
    if (pageLoginForm.length) {
        pageLoginForm.validate({
            rules: {
                "login-email": {
                    required: true,
                    email: true,
                },
                "login-password": {
                    required: true,
                },
            },
        });
    }
});
