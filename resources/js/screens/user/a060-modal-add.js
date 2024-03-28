$(function() {
    var modal = $('#add-modal'),
        form = modal.find('.modal-form'); 

    // function to get modal form data
    const getFormData = function () {
        return {
            login_id: form.find('input[name="login_id"]').val(),
            password: form.find('input[name="password"]').val(),
            user_name: form.find('input[name="user_name"]').val(),
            email_address: form.find('input[name="email_address"]').val(),
        };
    };

    // function to send AJAX to add user
    const addAjax = function () {
        $.ajax({
            url: ADD_URL,
            type: 'POST',
            data: getFormData(),
            beforeSend: function() {
                _common.showLoading();
            },
            complete: function(response) {
                _common.showLoading(false);
                if (response.responseJSON && response.responseJSON.errors) {
                    response.responseJSON.errors.forEach((err) => 
                        modal.find('.modal-errors').html(
                            `<div class="alert alert-danger">${err}</div>`
                        )
                    );
                }
                else {
                    modal.modal('hide');
                    window.location.reload();
                }
            },
        });
    };

    // handle modal form
    form.on('submit', e => e.preventDefault());

    form.validate({
        rules: {
            login_id: {
                required: true,
                maxlength: 50,
                remote: {
                    url: CHECK_LOGIN_ID_URL,
                    type: "post",
                    data: {
                        'login_id': () => form.find('input[name="login_id"]').val(),
                    },
                }
            },
            password: {
                required: true,
                validPassword: true,
                minlength: 8,
                maxlength: 16,
            },
            user_name: {
                required: true,
                maxlength: 50,
            },
            email_address: {
                checkValidEmailRFC:true,
                maxlength: 255,
            },
        },
        // send ajax to add text
        submitHandler: function() {
            if($(form).valid()){
                addAjax();
            }
        }
    });

    // readonly for prevent password auto fill (browser autocomplete)
    // remove reaonly on focus
    form.find('input[readonly]').focus(function(e) {
        $(e.target).removeAttr('readonly');
    });
});