$(document).ready(function() {
    var modal = $('#add-push-modal'),
        form = modal.find('.modal-form');
    // function to get modal form data
    const getFormData = function() {
        return {
            title: form.find('input[name="title"]').val(),
            content: form.find('textarea[name="content"]').val(),
            delivery_date: form.find('input[name="delivery_date"]').val(),
            delivery_hour: form.find('select[name="delivery_hour"]').val(),
            delivery_minute: form.find('select[name="delivery_minute"]').val(),
        };
    };

    // function to send AJAX to add push
    const addNewsAjax = function() {
        $.ajax({
            url: ADD_PUSH_URL,
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
                maxlength: 100,
                checkCharset: true,
            },
            content: {
                required: true,
                maxlength: 255,
            },
            delivery_date: {
                required: true,
                date: true,
                futureDate: true,
            },
            delivery_hour: {
                required: true,
            },
            delivery_minute: {
                required: true,
            },
        },
        messages: {
            delivery_date: {
                futureDate: function(p, e) {
                    return $.validator.format(
                        '{0}は本日以降の年月日を選択してください。 ', [$(e).data('label-furture-date')]
                    );
                },
            }
        },
        errorPlacement:
            function (error, element) {
                if (element.attr("name") == "delivery_hour" || element.attr("name") == "delivery_minute") {
                    $('.errorMessageHourMinute').html(error)
                } else if (element.attr("name") == "delivery_date") {
                    $('.errorMessageDate').append(error)
                } else {
                    error.insertAfter(element);
                }
            },
        // send ajax to add push
        submitHandler: function() {
            if ($(form).valid()) {
                addNewsAjax();
            }
        }
    });
    // catch the change event of delivery_hour, delivery_minute
    const deliveryHour = $('select[name="delivery_hour"]');
    const deliveryMinute = $('select[name="delivery_minute"]');
    deliveryHour.change(function () {
        $('select[name="delivery_minute"]').valid();
    });
    deliveryMinute.change(function () {
        $('select[name="delivery_hour"]').valid();
    });
});