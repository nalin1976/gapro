// JavaScript Document
function add_row(obj)
{
		
	var tbl				=$('#tblSizes tbody')
	//deleterows('tblPL');
	var lastRow 		= $('#tblSizes tr').length;	
	var indx			=obj.parentNode.parentNode.rowIndex;
	
	if(indx!=lastRow-1)
	return
	
	var row 			= tbl[0].insertRow(lastRow);	
	
	row.bgColor			='#ffffff';
	 
		var rowCell 		= row.insertCell(0);
		rowCell.height	  	='25';
		rowCell.className	='normalfntMid'
		rowCell.innerHTML   ="<img src=\"../images/del.png\"onclick=\"remove_detail_from_grid(this);\"alt=\"del\"width=\"15\"height=\"15\"maxlength=\"15\"class=\mouseover\"/>";
		
		var rowCell 		= row.insertCell(1);
		rowCell.height	  	='20';
		rowCell.className	='normalfntMid'
		rowCell.innerHTML   ="<input  type=\"text\" class=\"txtbox\"tabindex=\"3\"  style=\"text-align:center; width:85px; \" id=\"txtGarments\"  maxlength=\"10\"  />";
				
		var rowCell 		= row.insertCell(2);
		rowCell.className	='normalfntMid'
		rowCell.innerHTML   ="<input  type=\"text\" class=\"txtbox\"tabindex=\"3\"  style=\"text-align:center; width:85px; \" id=\"txtGarments\"  maxlength=\"100\"  />";
		
		var rowCell 		= row.insertCell(3);
		rowCell.className	='normalfntMid'
		rowCell.innerHTML   ="<input  type=\"text\" class=\"txtbox\"tabindex=\"3\"  style=\"text-align:center; width:55px; \" id=\"txtGarments\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  maxlength=\"10\"  />";
		
		var rowCell 		= row.insertCell(4);
		rowCell.className	='normalfntMid'
		rowCell.innerHTML   ="<input  type=\"text\" class=\"txtbox\"tabindex=\"3\"  style=\"text-align:center; width:55px; \" id=\"txtGarments\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"  maxlength=\"10\"  />";
		
		var rowCell 		= row.insertCell(5);
		rowCell.className	='normalfntMid'
		rowCell.innerHTML   ="<input  type=\"text\" class=\"txtbox\"tabindex=\"3\"  style=\"text-align:center; width:100px; \" id=\"txtGarments\"  maxlength=\"10\"onblur=\"add_row(this)\"  />";
		
		focus_cell(lastRow);
		$("#sizeratio_grid").tableDnD();
		
}

function save_ratio()
{
	
	var style			=$('#txtStyle').val();
	if(style==""&&style==null)
	return;
	var row 			= $('#tblSizes tbody tr');
	
	for(var loop_row=1;loop_row<row.length;loop_row++)
	{
		
			var size				=row[loop_row].cells[1].childNodes[0].value;
			if(size=="")
				continue;			
			var desc				=row[loop_row].cells[5].childNodes[0].value;
			var pcs					=row[loop_row].cells[3].childNodes[0].value;
			pcs						=(pcs==""?0:pcs)
			var color				=row[loop_row].cells[2].childNodes[0].value;			
			var net					=row[loop_row].cells[4].childNodes[0].value;
			net						=(net==""?0:net)
			var url					='styleratioplplugindb.php?request=save_ratio&style='+style+'&size='+size+'&desc='+desc+'&color='+color+'&net='+net+'&pcs='+pcs;
			var xml_http_obj		=$.ajax({url:url,async:false});			
		
	}
	alert("Saved successfully.");
}

function delete_first()
{
	var style				=$('#txtStyle').val();
	var url					='styleratioplplugindb.php?request=delete_first&style='+style;
	var xml_http_obj		=$.ajax({url:url,async:false});	
	save_ratio();
}

function remove_detail_from_grid(obj)
{	
	var rowindex	=obj.parentNode.parentNode.rowIndex
	if(rowindex<=1)
		return
	$('#tblSizes tbody')[0].deleteRow(rowindex);
}

 function focus_cell(obj)
{
	 $('#tblSizes tbody tr')[obj].cells[1].childNodes[0].focus();
}

function next_step()
{
	location.href = "shipmentpackinglist.php";
}