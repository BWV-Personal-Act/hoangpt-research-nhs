$(function() {
    // Jquery validation
    $('#customer-detail').validate({
        rules: {
            email_address: {
                required: true,
                checkValidEmailRFC: true,
                maxlength: 255,
            },
            password: {
                validPassword: true,
                minlength: 6,
                maxlength: 16,
            }
        }
    });
});