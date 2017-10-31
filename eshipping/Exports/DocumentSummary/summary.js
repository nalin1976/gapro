// JavaScript Document

function showReport()
{
    var fromDate	=	$('#txtInvoiceFromDate').val();
	var toDate 		= 	$('#txtInvoiceToDate').val();
	//var array1;
	if(fromDate!=''&& toDate!='')
	{
		
		//array1=getpropertyArray();
		
		var tblbody = document.getElementById("tblProperty").tBodies[0];
		var numRows = tblbody.rows.length; // number of rows currently in the table.
		var dbFieldNames = new Array(); 
		var fieldGivenNames = new Array();
		
		var a = 0; // array index
		for(var i=0; i<numRows; i++){
			
			if(tblbody.rows[i].cells[0].childNodes[0].childNodes[0].checked){
				var id = tblbody.rows[i].cells[0].childNodes[0].childNodes[0].id; // get the id of the check biox
				var desc = tblbody.rows[i].cells[1].id;           // get the vale from the property
				
				dbFieldNames[a] = [id];
				fieldGivenNames[a] = [desc];
				a++;
			}
		}
				
		var numofelement = dbFieldNames.length;
		window.open("summaryReport.php?fromDate="+fromDate+"&toDate="+toDate+"&numofelement="+numofelement+"&dbFieldNames="+dbFieldNames+"&fieldGivenNames="+fieldGivenNames,"report");
	}
	else {
		alert("please select 'FROM DATE' and 'TO DATE' date");
		$('#txtInvoiceFromDate').val()==''?$('#txtInvoiceFromDate').focus():$('#txtInvoiceToDate').focus();
	}
	
}
	
function getpropertyArray(){
	
var tblbody = document.getElementById("tblProperty").tBodies[0];
var numRows = tblbody.rows.length; // number of rows currently in the table.
var dbFieldNames = new Array(); 
var fieldGivenNames = new Array();

var a = 0; // array index
for(var i=0; i<numRows; i++){
	
	if(tblbody.rows[i].cells[0].childNodes[0].childNodes[0].checked){
		var id = tblbody.rows[i].cells[0].childNodes[0].childNodes[0].id; // get the id of the check biox
		var desc = tblbody.rows[i].cells[1].id;           // get the vale from the property
		
		checkBoxid[a] = [id,desc]; // now it gets stored in the multi dementional Array.
		a++;
	}
}
return checkBoxid;
	
}