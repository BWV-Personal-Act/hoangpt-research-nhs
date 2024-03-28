$(document).ready(function() {

    // use AJAX create,update recommend_item
    $('.switch input').change(function(e) {
        var checkbox = e.target;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            type: 'POST',
            url: $('#route').data('handle-db-a030'),
            data: {
                item_code: checkbox.value,
                checked: checkbox.checked,
            },
            dataType: 'json',
            beforeSend: function() {
                _common.showLoading();
            },
            complete: function() {
                _common.showLoading(false);
            },
            success: function(res) {
            },
        });
    });
});
