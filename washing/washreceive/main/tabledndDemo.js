

function moveTR()
{
	rowOder();
var table = document.getElementById('tblMain');

var tableDnD = new TableDnD();
tableDnD.findDropTargetRow = function(y) {
    var rows = this.table.tBodies[0].rows;
    for (var i=0; i<rows.length; i++) {
        var row = rows[i];
        var rowY    = this.getPosition(row).y;
        var rowHeight = parseInt(row.offsetHeight)/2;
		if (row.offsetHeight == 0) {
			rowY = this.getPosition(row.firstChild).y;
			rowHeight = parseInt(row.firstChild.offsetHeight)/2;
		}
        if ((y > rowY - rowHeight) && (y < (rowY + rowHeight))) {
            return row;
        }
    }
    return null;
	
}

tableDnD.init(table);
}
