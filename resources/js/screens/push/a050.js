$(document).ready(function () {
    $('#search-push').validate({
        rules: {
            from_delivery_time: {
                date: true,
            },
            to_delivery_time: {
                date: true,
            },
        },
    });
});