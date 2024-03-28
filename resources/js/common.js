$(function () {
    // Force reload page when click back button in Safari, Chrome (IOS/MacOS)
    window.onpageshow = function (event) {
        if (event.persisted) {
            // If page load from cache
            window.location.reload();
        }
    };

    // common Ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    /**
     * main common object
     * include all common function and variables
     */
    var _common = {};

    // bind to window variable, make it usable everywhere
    $.extend(window, {
        _common: _common,
    });

    /**
     * Show loading
     * @param {*} isShow
     */
    function showLoading(isShow = true,) {
        if (isShow) {
            $('#loading').show();
        } else {
            $('#loading').hide();
        }
    }
    _common.showLoading = showLoading;

    /**
     * Clear form inputs & reset to default data
     * @param {*} form 
     */
    function clearForm(form) {
        form = $(form);
        var radioElement = form.find('.i-radio');
        var dateElement = form.find('.datepicker');
        form.trigger('reset');
        form.find('input:text, input:password, input:file, textarea').val('');
        form.find('.i-radio, .i-checkbox').closest('div').removeClass('checked');
        form.find('.i-radio, .i-checkbox').removeAttr('checked');
        form.find('select').each(function () {
            var optVal = $(this).find('option:first').val();
            $(this).val(optVal);
            $(this).trigger('change');
            $(this).trigger('chosen:updated');
        });
        form.find('.select-with-search').val(''); // default checked for radio input

        if (radioElement.closest('.check').data('default')) {
            radioElement.each(function () {
                if ($(this).val() == radioElement.closest('.check').data('default')) {
                    $(this).attr('checked', true);
                    $(this).closest('div').addClass('checked');
                    $(this).trigger('change');
                }
            });
        } 
        
        // default data for date input
        dateElement.each(function () {
            if ($(this).data('default') && $(this).data('is-default')) {
                $(this).val($(this).data('default'));
                $(this).datepicker('update');
            } else {
                $(this).val('');
            }
        });

        $(form).validate().resetForm();
        $(form).find('input.error-message').removeClass('error-message');
    }
    _common.clearForm = clearForm;

    /* Events handling */
    
    // hidden session messages when change input
    $('input').keypress(function () {
        $('.alert').hide();
    });

    // handle init file name for file-single component
    $('.form-control.file-single').change(function (e) {
        $(e.target).removeAttr('init-file-name');
    });

    // trigger validation on file select
    $('input[type="file"]').change(function(e) { 
        if ($(e.target).valid) {
            $(e.target).valid(); 
        }
    });

    // clear search form
    $('.btn-clear-search').click(function () {
        var closestForm = $(this).closest('form');
        clearForm(closestForm);
        // clear url query string
        window.history.replaceState({}, document.title, window.location.href.split('?')[0]);
    }); 

    // clear form on show modal
    $('.modal-component').on('show.bs.modal', function (e) {
        var modalForm = $(e.target).find('.modal-form')[0];
        if (modalForm) {
            _common.clearForm(modalForm);
        }
    });

    // datepicker
    $('.datepicker').datepicker({
        autoHide: true,
        language: 'ja-JP',
        format: 'yyyy/mm/dd',
        months: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        date: new Date(),
    }).on('change', function () {
        $(this).valid();
    });

    // data table
    $('.custom-data-table').each(function() {
        let scrollYVal = '';
        let scrollXVal = false;
        const numRecord2Scroll = 10;
        let trInDataTable = $(this).find('tbody tr');
        let numRowsInDataTable = trInDataTable.length;

        if (numRowsInDataTable > numRecord2Scroll) {
            scrollYVal = 0;
            for (let i = 0; i < numRecord2Scroll; i++) {
                scrollYVal += trInDataTable.eq(i).height();
            }
            scrollYVal += 15;
            scrollXVal = true;
            $(this).closest('.table-responsive').removeClass('table-responsive');
        }

        $(this).DataTable({
            scrollY: scrollYVal,
            scrollX: scrollXVal,
            paging: false,
            searching: false,
            bInfo: false,
            ordering: false,
            autoWidth: false,
            language: {
                sEmptyTable: '該当するデータがありません。',
            }
        });
    });

    // whitespace is not allow in password.
    // also, it is not rendered as password character in .text-password input
    $('.text-password').keydown(function (e) {
        if (String.fromCharCode(e.keyCode) === ' ' ) {
            return false;
        }
    });

    //textareaの要素を取得
    $('.textarea-elastic').each(function () {
        //textareaのデフォルトの要素の高さを取得
        let clientHeight = this.clientHeight;
        //textareaのinputイベント
        this.addEventListener('input', () => {
            //textareaの要素の高さを設定（rows属性で行を指定するなら「px」ではなく「auto」で良いかも！）
            this.style.height = clientHeight + 'px';
            //textareaの入力内容の高さを取得
            let scrollHeight = this.scrollHeight;
            //textareaの高さに入力内容の高さを設定
            this.style.height = scrollHeight + 'px';
        });
    });
});
