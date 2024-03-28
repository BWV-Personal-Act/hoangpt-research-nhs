$(function() {
    // Jquery validation
    var rules = {
        title: {
            required: true,
            maxlength: 50,
            checkCharset: true,
        },
        display_start_date: {
            required: true,
            date:true,
        },
        display_end_date: {
            required: true,
            date:true,
            greaterThanEqual: 'input[name="display_start_date"]',
        },
    };

    var type = $('input[name="type"]').val();
    if (type == NEWS_TYPE_TEXT) {
        rules.content_text = {
            required: true,
            maxlength: 1000,
            checkCharset: true,
        };
    }
    else if (type == NEWS_TYPE_PDF) {
        rules.file_pdf = {
            fileRequired: true,
            accept: 'application/pdf',
            filesize: 10,
        };
    }
    
    $('#news-detail').validate({ 
        rules,
        messages: {
            display_end_date: {
                greaterThanEqual: $.validator.messages.greaterThanDate
            }
        }
    });
});