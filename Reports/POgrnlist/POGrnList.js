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
	var url  = "POGrnListDB.php?Opperation=URLLoadDetailsWhenChangePoNo";
		url += "&PoNo="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	var XMLOrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboOrderNo').innerHTML =  XMLOrderNo;
	
	var XMLStyleNo = htmlobj.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboStyle').innerHTML =  XMLStyleNo;
	
	var XMLGRNNo = htmlobj.responseXML.getElementsByTagName("GRNNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboGRN').innerHTML =  XMLGRNNo;
	
	var XMLInvoNo = htmlobj.responseXML.getElementsByTagName("InvoNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboInvoice').innerHTML =  XMLInvoNo;
	
	var XMLInvoNo = htmlobj.responseXML.getElementsByTagName("Supplier")[0].childNodes[0].nodeValue;
	document.getElementById('cboSupplier').innerHTML =  XMLInvoNo;
	hideBackGround('divBG');
}
function loadSuppliers(obj)
{
	var url  = "POGrnListDB.php?Opperation=URLLoadSuppliers&invoiceNo="+obj.value;
	htmlobj=$.ajax({url:url,async:false});
	var XMLSuppliers = htmlobj.responseXML.getElementsByTagName("Supplier")[0].childNodes[0].nodeValue;
	document.getElementById('cboSupplier').innerHTML =  XMLSuppliers;
}

function ViewReport(obj)
{
	if(obj=='0')
		var reportName = "rptPOGrnList.php";
	else if(obj=='1')
		var reportName = "rptExcellpogrn.php";
		
	var url  = reportName+"?";
		//url += "&cboPONo="+document.getElementById('cboPONo').value;
		//url += "&cboOrderNo="+URLEncode(document.getElementById('cboOrderNo').value); 
		//url += "&cboStyle="+URLEncode(document.getElementById('cboStyle').value); 
		//url += "&cboGRN="+document.getElementById('cboGRN').value; 
		url += "&cboInvoice="+URLEncode(document.getElementById('cboInvoice').value);
		url += "&cboSupplier="+URLEncode(document.getElementById('cboSupplier').value); 
		//url += "&txtSupplier="+URLEncode(document.getElementById('txtSupplier').value.trim()); 
		url += "&txtInvoiceNo="+URLEncode(document.getElementById('txtInvoiceNo').value.trim()); 
		url += "&txtPONo="+URLEncode(document.getElementById('txtPONo').value.trim()); 
		url += "&txtGRNNo="+URLEncode(document.getElementById('txtGRNNo').value.trim()); 
		url += "&txtOrderNo="+URLEncode(document.getElementById('txtOrderNo').value.trim()); 
		url += "&txtStyleNo="+URLEncode(document.getElementById('txtStyleNo').value.trim());
		url += "&DateCheck="+(document.getElementById('chkDate').checked ? 1:0); 
		url += "&FromDate="+document.getElementById('txtFromDate').value; 
		url += "&ToDate="+document.getElementById('txtToDate').value; 
	window.open(url,reportName)
}