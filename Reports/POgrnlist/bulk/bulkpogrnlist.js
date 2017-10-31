function SearchDetails()
{
	document.frmBulkPOGRNList.submit();
}

function ClearForm()
{
	document.frmBulkPOGRNList.reset();
	ClearTable('tblGRNDetails');
}

function ClearTable(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();
}

function LoadDetailsWhenChangePoNo(obj)
{
	showBackGround('divBG',0);
	var url  = "bulkpogrnlistxml.php?Opperation=URLLoadDetailsWhenChangePoNo";
		url += "&PoNo="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLGRNNo = htmlobj.responseXML.getElementsByTagName("GRNNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboGRN').innerHTML =  XMLGRNNo;
	
	var XMLInvoNo = htmlobj.responseXML.getElementsByTagName("InvoNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboInvoice').innerHTML =  XMLInvoNo;
	hideBackGround('divBG');
}

function ViewReport(obj)
{
	showPleaseWait();
	var tbl = document.getElementById("tblGRNDetails");
	if(tbl.rows.length<=1)
	 {
		 alert("No data available in the grid.");
		 hidePleaseWait();
		 return;
		 
	 }
	if(obj=='0')
		var reportName = "rptBulkPOGrnList.php";
	else if(obj=='1')
		var reportName = "rptExcellBulkpogrn.php";
		
	var url  = reportName+"?";
		url += "&cboPONo="+document.getElementById('cboPONo').value;
		url += "&cboGRN="+document.getElementById('cboGRN').value; 
		url += "&cboInvoice="+URLEncode(document.getElementById('cboInvoice').value); 
		url += "&txtInvoiceNo="+URLEncode(document.getElementById('txtInvoiceNo').value.trim()); 
		url += "&txtPONo="+URLEncode(document.getElementById('txtPONo').value.trim()); 
		url += "&txtGRNNo="+URLEncode(document.getElementById('txtGRNNo').value.trim()); 
	window.open(url,reportName)
	hidePleaseWait();
}