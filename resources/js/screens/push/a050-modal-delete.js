$(function() {
    var modal = $('#modal-delete'),
        idElm = modal.find('.push-id'),
        titleElm = modal.find('.push-title'),
        deliveryTimeElm = modal.find('.push-delivery-time');

    // Update data on open Modal 
    var selectedRow = null;
    $('#push [data-toggle="modal"]').click(function(e) {
        selectedRow = $(e.target).closest('tr');
        idElm.text(selectedRow.find('.push-id').text().trim());
        titleElm.text(selectedRow.find('.push-title').text().trim());
        deliveryTimeElm.text(selectedRow.find('.push-delivery-time').text().trim());
    });

    // Call AJAX to delete news
    modal.find('[data-action="delete"]').click(function(e) {
        $.ajax({
            url: DELETE_PUSH_URL,
            type: 'POST',
            data: {
                pushId: selectedRow.data('id')
            },
            beforeSend: function() {
                _common.showLoading();
            },
            complete: function() {
                _common.showLoading(false);
            },
            success: () => {
                modal.modal('hide');
                window.location.reload();
            }
        });
    });
});