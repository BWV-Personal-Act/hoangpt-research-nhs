$(function() {
    var modal = $('#modal-delete'),
    idElm = modal.find('.news-id'),
    titleElm = modal.find('.news-title'), 
    pdfFileElm =  modal.find('.news-pdf-name');
    
    // Update data on open Modal 
    var selectedRow = null;
    $('#news [data-toggle="modal"]').click(function (e) {
        selectedRow = $(e.target).closest('tr');
        idElm.text(selectedRow.find('.news-id').text().trim());
        titleElm.text(selectedRow.find('.news-title').text().trim());
        pdfFileElm.text(selectedRow.find('.news-pdf-name').text().trim());
    });

    // Call AJAX to delete news
    modal.find('[data-action="delete"]').click(function (e) {
        $.ajax({
            url: DELETE_URL,
            type: 'POST',
            data: {
                newsId: selectedRow.data('id')
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