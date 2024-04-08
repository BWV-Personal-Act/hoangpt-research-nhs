const importCSVForm = $('form#importCSVForm');
const inputFileCSV = $('input#inputFileCSV');

$(function () {
    $.fn.groupList.validate();
    $.fn.groupList.register();
});

$.fn.extend({
    groupList: {
        register: function () {
            $(document).on('click', '#btnImportCSV', function () {
                inputFileCSV.trigger('click');
                inputFileCSV.on('change', function () {
                    if (!importCSVForm.valid()) {
                        return;
                    }

                    const formData = new FormData();
                    formData.append("file", inputFileCSV[0].files[0]);

                    $.ajax({
                        url: IMPORT_CSV_URL,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            _common.showLoading();
                        },
                        complete: function() {
                            inputFileCSV.val('');
                            _common.showLoading(false);
                        },
                        success: function() {
                            sessionStorage.setItem('importSuccess', 'Success');
                            window.location.reload();
                        },
                        error: function (err) {
                            const errorMessages = err.responseJSON.errors;

                            $('#modal-import .modal-body').html('');
                            $('#modal-import').modal('show');

                            errorMessages.forEach((errorMessage) => {
                              $('#modal-import .modal-body').append(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 0px">
                                    ${errorMessage}
                                </div>
                              `);
                            });
                        },
                        contentType: false,
                        processData: false,

                    });
                });
            });

            const message = sessionStorage.getItem('importSuccess');

            if (message) {
                $('.content .row:first').before((`
                    <div class="alert alert-success" role="alert">
                        ${ICL097}
                    </div>
                `));

                sessionStorage.removeItem('importSuccess');
            }
        },
        validate: function () {
            importCSVForm.validate({
                rules: {
                    inputFileCSV: {
                        filesize: 2,
                        accept: 'csv'
                    }
                }
            });
        }
    }
});
