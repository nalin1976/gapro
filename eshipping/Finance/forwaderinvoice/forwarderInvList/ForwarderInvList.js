// JavaScript Document

function loadSavedInvoices()
{
	clearGrid();
	
	if(document.getElementById('cboForwader').value!=0)
	{
		document.getElementById('cboInvoice').disabled=false;
		
		var url="ForwarderInvList-db.php?id=loadInvoiceCombo";
			url+="&forwaderId="+document.getElementById('cboForwader').value;
		var html_obj	  = $.ajax({url:url,async:false});
		document.getElementById('cboInvoice').innerHTML=html_obj.responseText;
	}
	else
	{
		document.getElementById('cboInvoice').disabled=true;
		document.getElementById('cboInvoice').value=0;
	}
}

function enableDateRange(obj)
{
	if(obj.checked==true)
	{
		document.getElementById('txtDateFrom').disabled=false;
		document.getElementById('txtDateTo').disabled=false;
	}
	else
	{
		document.getElementById('txtDateFrom').disabled=true;
		document.getElementById('txtDateTo').disabled=true;
	}
}


function validateData()
{
	var dateFrom = document.getElementById('txtDateFrom').value;
	var dateTo = document.getElementById('txtDateTo').value;
	
	var splitDateFrom = dateFrom.split("/");
	var splitDateTo = dateTo.split("/");
	
	if(document.getElementById('cboForwader').value==0)
		alert("Please Select a Forwarder");
	else if(document.getElementById('chk_dateRange').checked==true)
	{
		if(splitDateFrom[2]>splitDateTo[2])
			alert("Date From should be less than Date To");
		else if(splitDateFrom[1]>splitDateTo[1])
			alert("Date From should be less than Date To");
		else if(splitDateFrom[0]>splitDateTo[0])
			alert("Date From should be less than Date To");
		else
		{
			clearGrid();
			loadGrid();
		}
	}
	else
	{
		clearGrid();
		loadGrid();
	}
}

function loadGrid()
{
	var date = new Date();
	var d  = date.getDate();
	var day = (d < 10) ? '0' + d : d;
	var m = date.getMonth() + 1;
	var month = (m < 10) ? '0' + m : m;
	var yyyy = date.getFullYear();
	
	var today=day+"/"+month+"/"+yyyy;
	
	if(document.getElementById('chk_dateRange').checked==true)
		var searchDate=1;
	else
		var searchDate=0;
	var url="ForwarderInvList-db.php?id=loadGrid";
		url+="&forwaderId="+document.getElementById('cboForwader').value;
		url+="&invoiceNo="+document.getElementById('cboInvoice').value;
		url+="&accSubmitted="+document.getElementById('cboAccSubmitted').value;
		url+="&searchDate="+searchDate;
		url+="&dateFrom="+document.getElementById('txtDateFrom').value;
		url+="&dateTo="+document.getElementById('txtDateTo').value;
		
	var xmlhttp_obj	  = $.ajax({url:url,async:false});
	//alert(xmlhttp_obj.responseText);
		var XMLInvoiceNo	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		var XMLDate	  		  = xmlhttp_obj.responseXML.getElementsByTagName("Date");
		var XMLAmouont		  = xmlhttp_obj.responseXML.getElementsByTagName("Amount");
		var XMLChequeNo		  = xmlhttp_obj.responseXML.getElementsByTagName("ChequeNo");
		var XMLPaidAmount	  = xmlhttp_obj.responseXML.getElementsByTagName("PaidAmount");
		var XMLSubmitStatus	  = xmlhttp_obj.responseXML.getElementsByTagName("SubmitStatus");
		var XMLSubmitDate	  = xmlhttp_obj.responseXML.getElementsByTagName("SubmitDate");
		
		var tblForwarderInv=document.getElementById('tblForwarderInv');
			
		for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
			
			var newRow			 	    = tblForwarderInv.insertRow(x+1);
			
			var newCellSelectPl         = tblForwarderInv.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			
			var newCellDate        = tblForwarderInv.rows[x+1].insertCell(1);
			newCellDate.className  = "normalfntMid";
			newCellDate.align      = "center";
			newCellDate.innerHTML  = XMLDate[x].childNodes[0].nodeValue;
			
			
			var newCellAmount             = tblForwarderInv.rows[x+1].insertCell(2);
			newCellAmount.className       = "normalfntMid";
			newCellAmount.align           = "center";
			newCellAmount.innerHTML       = XMLAmouont[x].childNodes[0].nodeValue;
			
			var newCellChequeNo           = tblForwarderInv.rows[x+1].insertCell(3);
			newCellChequeNo.className     = "normalfntMid";
			newCellChequeNo.align         = "center";
			newCellChequeNo.innerHTML     = XMLChequeNo[x].childNodes[0].nodeValue;
			
			var newCellPaidAmount           = tblForwarderInv.rows[x+1].insertCell(4);
			newCellPaidAmount.className     = "normalfntMid";
			newCellPaidAmount.align         = "center";
			newCellPaidAmount.innerHTML     = XMLPaidAmount[x].childNodes[0].nodeValue;
			
			var newCellSubmitStatus       = tblForwarderInv.rows[x+1].insertCell(5);
			newCellSubmitStatus.className     = "normalfntMid";
			newCellSubmitStatus.align         = "center";
			
			if(XMLSubmitStatus[x].childNodes[0].nodeValue==0)
			{
				newCellSubmitStatus.innerHTML     = "<input type=\"checkbox\" id=\"chk_forInvSubmit\" name=\"chk_forInvSubmit\" />";
				
				var newCellSubmitDate           = tblForwarderInv.rows[x+1].insertCell(6);
				newCellSubmitDate.className     = "normalfntMid";
				newCellSubmitDate.align         = "center";
				newCellSubmitDate.innerHTML     = '';
			}
			else
			{
				
				newCellSubmitStatus.innerHTML     = "<input type=\"checkbox\" id=\"chk_forInvSubmit\" name=\"chk_forInvSubmit\" checked=\"checked\" />";
				var newCellSubmitDate           = tblForwarderInv.rows[x+1].insertCell(6);
				newCellSubmitDate.className     = "normalfntMid";
				newCellSubmitDate.align         = "center";
				newCellSubmitDate.innerHTML     = XMLSubmitDate[x].childNodes[0].nodeValue;
			}
			
			var newView           = tblForwarderInv.rows[x+1].insertCell(7);
			newView.className     = "normalfntMid";
			newView.align         = "center";
			newView.innerHTML     = "<img src=\"../../../images/view.png\" onclick=\"viewData(this);\" class=\"mouseover\" />";
			
		}
		
}

function clearGrid()
{
	var tblForwarderInv=document.getElementById('tblForwarderInv');
	for(var i=tblForwarderInv.rows.length-1;i>0;i--)
		tblForwarderInv.deleteRow(i);	
}

function viewData(obj)
{
	var tblForwarderInv=document.getElementById('tblForwarderInv');
	var rwIndex=obj.parentNode.parentNode.rowIndex;
	
	var invoiceNo= tblForwarderInv.rows[rwIndex].cells[0].innerHTML;
	var forwarderId = document.getElementById('cboForwader').value;
	
	window.open("../ForwarderInvoice.php?invoiceNo="+invoiceNo+"&forwarderId="+forwarderId,"_self");	
}

function showReport()
{
	var forwarderId = document.getElementById('cboForwader').value;
	var invoiceNo	= document.getElementById('cboInvoice').value;
	var accSubmitted= document.getElementById('cboAccSubmitted').value;
	var DateFrom	= document.getElementById('txtDateFrom').value;
	var DateTo	= document.getElementById('txtDateTo').value;
	if(forwarderId!=0)
		window.open("ForwarderInvListReport.php?forwarderId="+forwarderId+"&accSubmitted="+accSubmitted+"&DateFrom="+DateFrom+"&DateTo="+DateTo+"&invoiceNo="+invoiceNo,"_self");
}
