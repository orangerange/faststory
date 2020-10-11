// 背景オブジェクト複製
function copyObjects() {
    var objects = document.querySelectorAll(".objects");
    if (objects) {
        // 行複製
        for(var obsIndex = 0; obsIndex < objects.length; obsIndex++) {
            // 列複製
            var row = objects[obsIndex].firstElementChild;
            var columnNum = row.dataset.column_num;
            var columnHtml = row.innerHTML;
            var columnsHtml = "";
            for (var columnCount=1; columnCount<=columnNum; columnCount++) {
                columnsHtml += columnHtml;
            }
            row.innerHTML = columnsHtml;
            // 行複製
            var rowNum = objects[obsIndex].dataset.row_num;
            var rowHtml = objects[obsIndex].innerHTML;
            var rowsHtml = "";
            for (var rowCount=1; rowCount<=rowNum; rowCount++) {
                rowsHtml += rowHtml;
            }
            objects[obsIndex].innerHTML = rowsHtml;
        }
    }
}
