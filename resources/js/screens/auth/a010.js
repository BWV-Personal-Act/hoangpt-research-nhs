$(function() {
    $('#login-form').validate({
        rules: {
            login_id: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 16,
            }
        }
    });
});