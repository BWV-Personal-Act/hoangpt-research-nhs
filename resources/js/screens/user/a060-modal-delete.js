$(function() {
    var modal = $('#modal-delete'),
    idElm = modal.find('.user-id'),
    nameElm = modal.find('.user-name'), 
    emailElm = modal.find('.user-email'), 
    lastLoginElm =  modal.find('.user-last-login');
    
    // Update data on open Modal 
    var selectedRow = null;
    $('#users [data-toggle="modal"]').click(function (e) {
        selectedRow = $(e.target).closest('tr');
        idElm.text(selectedRow.find('.user-id').text().trim());
        nameElm.text(selectedRow.find('.user-name').text().trim());
        emailElm.text(selectedRow.find('.user-email').text().trim());
        lastLoginElm.text(selectedRow.find('.user-last-login').text().trim());
    });

    // Call AJAX to delete user
    modal.find('[data-action="delete"]').click(function (e) {
        $.ajax({
            url: DELETE_URL,
            type: 'POST',
            data: {
                userId: selectedRow.data('id')
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