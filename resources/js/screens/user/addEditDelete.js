$(function() {
    $('#addEditForm').validate({
        rules: {
            user_name: {
                required: true,
                maxlength: 100,
            },
            email: {
                required: true,
                checkValidEmailRFC: true,
                maxlength: 255
            },
            group: {
                required: true,
            },
            started_date: {
                required: true,
            },
            position: {
                required: true,
            },
            password: {
                required: true,
            },
            password_confirmation: {
                required: true,
            },
        }
    });
});
