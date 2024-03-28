$(function() {
    // Jquery validation
    $('#user-detail').validate({
        rules: {
            user_name: {
                required: true,
                maxlength: 50,
            },
            email_address: {
                checkValidEmailRFC: true,
                maxlength: 255,
            },
            password: {
                validPassword: true,
                minlength: 8,
                maxlength: 16,
            }
        }
    });
});
