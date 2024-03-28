$(document).ready(function() {
    $('#type-search').chosen();

    $("#type-search").change(function () {
        _common.showLoading();
        $("#search-form").submit();
    });
});
