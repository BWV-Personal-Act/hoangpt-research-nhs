$(function() {
    var modal = $('#add-pdf-modal'),
        form = modal.find('.modal-form'); 

    // function to get modal form data
    const getFormData = function () {
        var formData = new FormData();
        formData.append('type', form.find('input[name="type"]').val());
        formData.append('disable_flg', form.find('input[name="disable_flg"]').val());
        formData.append('title', form.find('input[name="title"]').val());
        formData.append('file_pdf', form.find('input[name="file_pdf"]')[0].files[0]);
        formData.append('display_start_date', form.find('input[name="display_start_date"]').val());
        formData.append('display_end_date', form.find('input[name="display_end_date"]').val());
        return formData;
    };

    // function to send AJAX to add news
    const addNewsAjax = function () {
        $.ajax({
            url: ADD_PDF_URL,
            type: 'POST',
            data: getFormData(),
            processData: false,
            contentType: false,
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
            file_pdf: {
                fileRequired: true,
                accept: 'application/pdf',
                filesize: 10,
            },
            display_start_date: {
                required: true,
                date: true,
            },
            display_end_date: {
                required: true,
                greaterThanEqual: '#add-pdf-modal input[name="display_start_date"]',
                date: true,
            },
        },
        messages: {
            display_end_date: {
                greaterThanEqual: $.validator.messages.greaterThanDate
            }
        },
        submitHandler: function() {
            if($(form).valid()){
                addNewsAjax();
            }
        }
    });
});