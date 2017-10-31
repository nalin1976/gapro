function SearchDetails()
{
	document.frmStylePOGRNList.submit();
}

function ClearForm()
{
	document.frmStylePOGRNList.reset();
	ClearTable('tblGRNDetails');
}

function ClearTable(tableName)
{
	$("#"+tableName+" tr:gt(0)").remove();
}

function LoadDetailsWhenChangePoNo(obj)
{
	showBackGround('divBG',0);
	var url  = "genPOGrnListDB.php?Opperation=URLLoadDetailsWhenChangePoNo";
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
	if(obj=='0')
		var reportName = "rptgenPOGrnList.php";
	else if(obj=='1')
		var reportName = "rptExcellgenpogrn.php";
		
	var url  = reportName+"?";
		url += "&cboPONo="+document.getElementById('cboPONo').value;
		url += "&cboGRN="+document.getElementById('cboGRN').value; 
		url += "&cboInvoice="+document.getElementById('cboInvoice').value; 
		url += "&txtInvoiceNo="+URLEncode(document.getElementById('txtInvoiceNo').value.trim()); 
		url += "&txtPONo="+URLEncode(document.getElementById('txtPONo').value.trim()); 
		url += "&txtGRNNo="+URLEncode(document.getElementById('txtGRNNo').value.trim()); 
	window.open(url,reportName)
}