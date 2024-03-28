$(function() {
    // Jquery validation
    $('#priority-detail').validate({
        rules: {
            number: {
                required: true,
                checkNumeric: true,
                maxlength: 3,
                checkValueInRange: [PRIORITY_NUMBER_RANGE.min, PRIORITY_NUMBER_RANGE.max],
            },
            name: {
                required: true,
                maxlength: 40,
            },
        }
    });
});
