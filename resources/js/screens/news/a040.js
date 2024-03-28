$(function() {
    // jquery validation
    $('#search-form').validate({
        rules: {
            search_display_start_date: {
                date: true,
            },
            search_display_end_date: {
                greaterThanEqual: '#add-pdf-modal input[name="display_start_date"]',
                date: true,
            },
        },
        messages: {
            display_end_date: {
                greaterThanEqual: $.validator.messages.greaterThanDate
            }
        },
    });

    // Handle pdf view
    $('.news-pdf-name > a').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(e.target).data('check-url'),
            type: 'GET',
            beforeSend: function() {
                _common.showLoading();
            },
            complete: function() {
                _common.showLoading(false);
            },
            success: () => {
                window.open($(e.target).attr('href'), '_blank');
            },
            error: (response) => {
                alert(response.responseText);
            },
        });
    });

    // Switch disable flag
    $('input[name="disable_flg"]').change(function(e) {
        var checked = $(e.target).prop('checked');
            validVal = $(e.target).data('valid-val'),
            invalidVal = $(e.target).data('invalid-val');
        $.ajax({
            url: $(e.target).data('url'),
            type: 'POST',
            data: {
                disable_flg: checked ? validVal : invalidVal,
            },
            beforeSend: function() {
                _common.showLoading();
            },
            complete: function() {
                _common.showLoading(false);
            },
            error: function() {
                $(e.target).prop('checked', !checked);
            }
        });
    });
});