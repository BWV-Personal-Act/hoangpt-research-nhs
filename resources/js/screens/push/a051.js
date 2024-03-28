$(document).ready(function () {
    $('#push-detail').validate({
        rules: {
            title: {
                required: true,
                maxlength: 100,
                checkCharset: true,
            },
            content: {
                required: true,
                maxlength: 255
            },
            delivery_date: {
                required: true,
                date: true,
            },
            delivery_hour: {
                required: true,
            },
            delivery_minute: {
                required: true,
            },
        },
        messages: {},
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