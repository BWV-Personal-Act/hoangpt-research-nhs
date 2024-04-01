$(function () {
    $.fn.userList.register();
    $.fn.userList.validate();
});

$.fn.extend({
    userList: {
        register: function () {
            if (window.location.search) {
                $('#result').removeClass('d-none');
            }

            $(document).on('click', '#btnExportCSV', function () {
                const searchParams = $('#searchParams').val();

                $.ajax({
                    url: '/user/export-csv',
                    type: 'GET',
                    data: JSON.parse(searchParams),
                    beforeSend: function() {
                        _common.showLoading();
                    },
                    complete: function() {
                        _common.showLoading(false);
                    },
                    success: function (res) {
                        const blob = new Blob([res], { type: "text/csv" });
                        const url = window.URL.createObjectURL(blob);
                        const a = $("<a>");

                        const date = moment();
                        const dateStr = date.format("YYYYMMDDHHmmss");
                        const filename = `list_user_${dateStr}.csv`;

                        a.attr({ href: url, download: filename });

                        $("body").append(a);
                        a[0].click();

                        window.URL.revokeObjectURL(url);

                    },
                    error: (response) => {
                        alert(response.responseText);
                    },
                });
            });
        },
        validate: function () {
            $('#searchForm').validate({
                rules: {
                    user_name: {
                        maxlength: 100,
                    },
                    started_date_to: {
                        greaterThanEqual: 'input#started_date_from'
                    }
                }
            });
        }
    }
});
