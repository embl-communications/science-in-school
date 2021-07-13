function buildBinaryTable(word, asker) {
    var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZÇÃÕÊÁÂÓÉÀÔÍÚÄÅÆÈËÌÍÎÏÑÒÖØÙÛÜÝßŸČĆŠŽŘ";
    var table = document.getElementById("binary-table");
    for (character of word) {
        var index = letters.indexOf(character) + 1;
        var row = table.insertRow();

        if (asker == "professor") {
            var empty_cell = row.insertCell();
            empty_cell.style = "padding:0";
            var padding_cell = row.insertCell();
            padding_cell.style = "border-width:0px;"
            empty_cell.innerHTML =
                "<div style='background: #ffffff; width:40pt; height:30pt'></div>";
        } else if (asker == "estudante") {
            var empty_cell = row.insertCell();
            empty_cell.style = "padding:0";
            empty_cell.innerHTML =
                "<input class='input char' maxlength=1 style='width: 46pt !important'>";
        }

        binaryStr = index.toString(2);
        if (binaryStr.length < 6) {
            binaryStr = Array(6 - binaryStr.length + 1).join("0") + binaryStr;
        }
        for (binaryDigit of binaryStr) {
            if (binaryDigit == "1") {
                new_cell = row.insertCell();
                new_cell.style = "padding:0";
                new_cell.innerHTML =
                    "<div style='background: #ffffff; width:40pt; height:30pt'></div>";
            } else {
                new_cell = row.insertCell();
                new_cell.style = "padding:0";
                new_cell.innerHTML =
                    "<div style='background: #000000; width:40pt; height:30pt'></div>";
            }
        }
    }
}

function destroyPreviousTable() {
    var table_old = document.getElementById("binary-table");
    var new_tbody = document.createElement("tbody");
    new_tbody.id = "binary-table";
    table_old.parentNode.replaceChild(new_tbody, table_old);
}
