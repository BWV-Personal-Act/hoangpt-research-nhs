$(document).ready(function () {
    $("#type").chosen();

    var modal = $("#add-priority-modal"),
        form = modal.find(".modal-form");

    const getFormData = function () {
        return {
            type: form.find('select[name="type"]').val(),
            code: form.find('input[name="code"]').val(),
            name: form.find('input[name="name"]').val(),
            number: form.find('input[name="number"]').val(),
        };
    };

    // function to send AJAX to add priority
    const addPriorityAjax = function () {
        $.ajax({
            url: ADD_PRIORITY_URL,
            type: 'POST',
            data: getFormData(),
            dataType: 'json',
            beforeSend: function () {
                _common.showLoading();
            },
            complete: function () {
                _common.showLoading(false);
            },
            success: (result) => {
                if (result.status) {
                    window.location.reload();
                }
                else {
                    let codeErrElm = '<div id="code-not-exist-error" class="error-message">' + result.message + '</div>';
                    $('#code').after(codeErrElm);
                }
                
            },
        });
    };

    $("#type, #type_chosen").on("change focusout", () => {
        $("#type").valid();
    });

    $("#code").on("change focusout", () => {
        $("#code-not-exist-error").remove();
    });

    // handle modal form
    form.on("submit", (e) => e.preventDefault());

    form.validate({
        rules: {
            type: {
                required: true,
            },
            code: {
                required: true,
                maxlength: 25,
            },
            name: {
                required: true,
                maxlength: 40,
            },
            number: {
                checkNumeric: true,
                maxlength: 3,
                checkValueInRange: [PRIORITY_NUMBER_RANGE.min, PRIORITY_NUMBER_RANGE.max + 1],
            }
        },
        submitHandler: function () {
            if ($(form).valid()) {
                addPriorityAjax();
            }
        },
    });
});
