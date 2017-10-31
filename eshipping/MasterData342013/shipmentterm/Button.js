// JavaScript Document

var gbl_id=0;
function deleteRow(obj)
{
	var tbl_shipmentTerm=document.getElementById('tbl_shipmentTerm');
	var rowIndex=obj.id;
	
	var shipmentId=tbl_shipmentTerm.rows[rowIndex].cells[2].childNodes[0].nodeValue;
	
	var answer = confirm("Do you want to delete?")
	if (answer)
	{
		var url="Button.php?id=deleteRowData";
			url+="&shipmentId="+URLEncode(shipmentId);
			
		var html_obj	  = $.ajax({url:url,async:false});
		
		if(html_obj.responseText==1)
		{
			alert("Deleted Successfully");
			clearForm();
		}
		else
			alert("Delete Failed");
	}
}


function clearForm()
{
	window.location.reload();
}

function editRow(obj)
{
	var tbl_shipmentTerm=document.getElementById('tbl_shipmentTerm');
	var rowIndex=obj.id;
	
	gbl_id=tbl_shipmentTerm.rows[rowIndex].cells[2].childNodes[0].nodeValue;
	document.getElementById('txtShipmentTerms').value=tbl_shipmentTerm.rows[rowIndex].cells[3].childNodes[0].nodeValue.trim();
	document.getElementById('txtRemarks').value=tbl_shipmentTerm.rows[rowIndex].cells[4].childNodes[0].nodeValue.trim();
		
		
		
}

function validateData()
{
	if(document.getElementById('txtShipmentTerms').value=='')
	{
		alert("Please Enter Shipment Term");
		document.getElementById('txtShipmentTerms').focus();
	}
	else
	{
		var termName=document.getElementById('txtShipmentTerms').value;
		var url="Button.php?id=checkAvailbility";
		url+="&termId="+URLEncode(gbl_id);
		url+="&termName="+URLEncode(termName);
		
		var html_obj	  = $.ajax({url:url,async:false});
		//alert(html_obj.responseText);
		if(html_obj.responseText==1)
		{
			alert("Shipment Term Exists. Please Enter a different Shipment Term");
			document.getElementById('txtShipmentTerms').value='';
			document.getElementById('txtShipmentTerms').focus();
			
		}
		else
			saveData();
	}
}

function saveData()
{
	var termName=document.getElementById('txtShipmentTerms').value;
	var termDesc=document.getElementById('txtRemarks').value;
	
	var url="Button.php?id=saveData";
		url+="&termId="+URLEncode(gbl_id);
		url+="&termName="+URLEncode(termName);
		url+="&termRemarks="+URLEncode(termDesc);
		
	var html_obj	  = $.ajax({url:url,async:false});
	
	alert(html_obj.responseText);
	clearForm();
}


function focusTextBox()
{
	document.getElementById('txtShipmentTerms').focus();
}