$(function() {
    var modal = $('#add-text-modal'),
        form = modal.find('.modal-form'); 

    // function to get modal form data
    const getFormData = function () {
        return {
            type: form.find('input[name="type"]').val(),
            disable_flg: form.find('input[name="disable_flg"]').val(),
            title: form.find('input[name="title"]').val(),
            content_text: form.find('textarea[name="content_text"]').val(),
            display_start_date: form.find('input[name="display_start_date"]').val(),
            display_end_date: form.find('input[name="display_end_date"]').val(),
        };
    };

    // function to send AJAX to add news
    const addNewsAjax = function () {
        $.ajax({
            url: ADD_TEXT_URL,
            type: 'POST',
            data: getFormData(),
            beforeSend: function() {
                _common.showLoading();
            },
            complete: function() {
                _common.showLoading(false);
            },
            success: () => {
                modal.modal('hide');
                window.location.reload();
            },
        });
    };

    // handle modal form
    form.on('submit', e => e.preventDefault());

    form.validate({
        rules: {
            title: {
                required: true,
                maxlength: 50,
                checkCharset: true,
            },
            content_text: {
                required: true,
                maxlength: 1000,
                checkCharset: true,
            },
            display_start_date: {
                required: true,
                date: true,
            },
            display_end_date: {
                required: true,
                date: true,
                greaterThanEqual: '#add-text-modal input[name="display_start_date"]',
            },
        },
        messages: {
            display_end_date: {
                greaterThanEqual: $.validator.messages.greaterThanDate
            }
        },
        // send ajax to add text
        submitHandler: function() {
            if($(form).valid()){
                addNewsAjax();
            }
        }
    });
});