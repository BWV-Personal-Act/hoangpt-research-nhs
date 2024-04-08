$(function() {
    $.fn.addEditDelete.validate();
    $.fn.addEditDelete.register();
    $.fn.addEditDelete.handleDelete();
});

$.fn.extend({
    addEditDelete: {
        register: function () {
            const USER_CREATE_PATH = '/user/create';

            const isAddScreen = window.location.pathname === USER_CREATE_PATH;
            const passwordElement = $('input[name="password"]');
            const passwordConfirmationElement = $('input[name="password_confirmation"]');

            if (isAddScreen) {
                passwordElement.rules("add", {
                    required: true,
                });

                passwordConfirmationElement.rules("add", {
                    required: true,
                });
            } else {
                passwordConfirmationElement.rules("add", {
                    required: function () {
                        return passwordElement.val() !== '';
                    }
                });
            }
        },
        validate: function () {
            $('#addEditForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100,
                    },
                    email: {
                        required: true,
                        checkValidEmailRFC: true,
                        maxlength: 255
                    },
                    group_id: {
                        required: true,
                    },
                    started_date: {
                        required: true,
                        date: true,
                    },
                    position_id: {
                        required: true,
                    },
                    password: {
                        checkCharacterlatin: true,
                        minlength: 8,
                        maxlength: 20,
                    },
                    password_confirmation: {
                        checkCharacterlatin: true,
                        equalTo: '#password',
                    },
                }
            });
        },
        handleDelete: function () {
            const userId = window.location.href.split("/").pop();

            $(document).on('click', 'button#btnDelete', function () {
                if (userId === LOGIN_USER_ID) {
                    return alert(EBT086);
                }
                const isConfirm = confirm('このユーザーを削除してもいいですか？');

                if (!isConfirm) {
                    return;
                }

                $.ajax({
                    url: DELETE_URL,
                    type: 'POST',
                    data: {
                        id: userId,
                    },
                    beforeSend: function() {
                        _common.showLoading();
                    },
                    complete: function() {
                        _common.showLoading(false);
                    },
                    success: (result) => {
                        if (result.status === 200) {
                            sessionStorage.setItem("deleteSuccess", result.message);
                            window.location.href = USER_LIST_URL;
                        } else {
                            alert(result.message);
                        }
                    }
                });
            });
        }
    }
});
