$(document).ready(function () {
    // 上矢印ボタンがクリックされたときの処理
    $(".arrow-up").click(function () {
        var row = $(this).closest("tr");
        if (row.index() > 0) {
            var prevRow = row.prev();
            swapNumberValues(row, prevRow); // Swap values between the current row and the previous row
            row.insertBefore(prevRow);
            updateArrowButtons();
        }
    });

    // 下矢印ボタンがクリックされたときの処理
    $(".arrow-down").click(function () {
        var row = $(this).closest("tr");
        var numRows = $("table#table1 tbody tr").length;
        if (row.index() < numRows - 1) {
            var nextRow = row.next();
            swapNumberValues(row, nextRow); // Swap values between the current row and the next row
            row.insertAfter(nextRow);
            updateArrowButtons();
        }
    });

    // ボタンの状態を更新する関数
    function updateArrowButtons() {
        var rows = $("table#table1 tbody tr");
        rows.each(function (index) {
            var row = $(this);
            var arrows = row.find(".arrow");
            arrows.prop("disabled", false); // 全てのボタンを有効化
            if (index === 0) {
                arrows.eq(0).prop("disabled", true); // 最初の行の上矢印を無効化
            } else if (index === rows.length - 1) {
                arrows.eq(1).prop("disabled", true); // 最後の行の下矢印を無効化
            }
        });
    }

    // Swap number values between two rows
    function swapNumberValues(row1, row2) {
        var number1 = row1.find("[name^='number[']").val();
        var number2 = row2.find("[name^='number[']").val();

        row1.find("[name^='number[']").val(number2);
        row2.find("[name^='number[']").val(number1);
    }

    // ページロード時にボタンの状態を設定
    updateArrowButtons();
});
