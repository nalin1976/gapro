// js file fabric Recap

function printAsExcel()
{
	var path  = "excel_writer.php?req=writeExcel";
	htmlobj=$.ajax({url:path,async:false});
	var HTMLText=htmlobj.responseText
	alert(HTMLText);	
}