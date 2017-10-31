// JavaScript Document

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


function validateDataToLoadGrid()
{
	var forwaderId = document.getElementById('cboForwader').value;
	var dateFrom   = document.getElementById('txtDateFrom').value;
	var dateTo     = document.getElementById('txtDateTo').value;
	
	var splitDateFrom = dateFrom.split("/");
	var splitDateTo = dateTo.split("/");
	
	if(forwaderId==0)
		alert("Please Select a Forwader");
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
			loadData();
		}
	}
	else
	{
		clearGrid();
		loadData();
	}
}

function loadData()
{
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	
	if(document.getElementById('chk_dateRange').checked==true)
		var searchDate=1;
	else
		var searchDate=0;
	
	var forwaderId = document.getElementById('cboForwader').value;
	var dateFrom   = document.getElementById('txtDateFrom').value;
	var dateTo     = document.getElementById('txtDateTo').value;
	
	var url ="payment-db.php?id=loadGrid";
		url+="&forwaderId="+forwaderId;
		url+="&searchDate="+searchDate;
		url+="&dateFrom="+dateFrom;
		url+="&dateTo="+dateTo;
		
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	//alert(xmlhttp_obj.responseText);
		
	var XMLInvoiceNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
	var XMLInvDate 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvDate");
	var XMLAmount	  = xmlhttp_obj.responseXML.getElementsByTagName("Amount");
	
	for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
			
			var newRow			 	    = tblPaymentDetails.insertRow(x+1);
				newRow.className			= 'bcgcolor-tblrowWhite';
		
			
			var newCellSelectPl         = tblPaymentDetails.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" id=\""+x+"\" onclick=\"calculateAmt();\" />";
			
			
			var newCellInvoiceNo        = tblPaymentDetails.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfntMid";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			
			var newCellDate             = tblPaymentDetails.rows[x+1].insertCell(2);
			newCellDate.className       = "normalfntMid";
			newCellDate.align           = "center";
			newCellDate.innerHTML       = XMLInvDate[x].childNodes[0].nodeValue;
			
			var newCellAmount           = tblPaymentDetails.rows[x+1].insertCell(3);
			newCellAmount.className     = "normalfntMid";
			newCellAmount.align         = "center";
			newCellAmount.innerHTML     = XMLAmount[x].childNodes[0].nodeValue;
			
			/*var newCellChequeNo         = tblPaymentDetails.rows[x+1].insertCell(4);
			newCellChequeNo.className   ="normalfntMid";
			newCellChequeNo.align       ="center";
			newCellChequeNo.innerHTML   = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center\" maxlength=\"20\" />";*/
			
			var newCellNetAmount        = tblPaymentDetails.rows[x+1].insertCell(4);
			newCellNetAmount.className  = "normalfntMid";
			newCellNetAmount.align      = "center";
			newCellNetAmount.innerHTML  = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center; width:98%; height:15px\" maxlength=\"20\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\" onkeyup=\"calculatePayingAmt(this);\"  value=\""+XMLAmount[x].childNodes[0].nodeValue+"\"/>";
			
			var newCellSvatAmount        = tblPaymentDetails.rows[x+1].insertCell(5);
			newCellSvatAmount.className  = "normalfntMid";
			newCellSvatAmount.align      = "center";
			newCellSvatAmount.innerHTML  = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center; width:98%; height:15px\" maxlength=\"20\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\" onkeyup=\"calculatePayingAmt(this);\" value='0' />";
			
			var newCellPayingAmount        = tblPaymentDetails.rows[x+1].insertCell(6);
			newCellPayingAmount.className  = "normalfntMid";
			newCellPayingAmount.align      = "center";
			newCellPayingAmount.innerHTML  = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center; width:98%; height:15px\" maxlength=\"20\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\"  value=\""+XMLAmount[x].childNodes[0].nodeValue+"\" disabled='disabled'/>";
		}
		//payment_fix_header();
		/*if(tblPaymentDetails.rows.length>1)
		{
			var lastRow = tblPaymentDetails.rows.length;
			var newRow			 	    = tblPaymentDetails.insertRow(lastRow);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellTotal        = tblPaymentDetails.rows[lastRow].insertCell(0);
			newCellTotal.className  = "normalfntMid";
			newCellTotal.align      = "center";
			newCellTotal.colSpan    = 4;
			newCellTotal.innerHTML  = "Toatl";
			
			var newCellNetTotal        = tblPaymentDetails.rows[lastRow].insertCell(1);
			newCellNetTotal.className  = "normalfntMid";
			newCellNetTotal.align      = "center";
			newCellNetTotal.innerHTML  = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center; width:98%; height:15px\" maxlength=\"20\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\" value='0' disabled='disabled' />";
			
			var newCellSvatTotal        = tblPaymentDetails.rows[lastRow].insertCell(2);
			newCellSvatTotal.className  = "normalfntMid";
			newCellSvatTotal.align      = "center";
			newCellSvatTotal.innerHTML  = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center; width:98%; height:15px\" maxlength=\"20\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\" value='0' disabled='disabled' />";
			
			var newCellPayingAmtTotal        = tblPaymentDetails.rows[lastRow].insertCell(3);
			newCellPayingAmtTotal.className  = "normalfntMid";
			newCellPayingAmtTotal.align      = "center";
			newCellPayingAmtTotal.innerHTML  = "<input type=\"text\" align=\"center\" class=\"txtbox\" size=\"10\" style=\"text-align:center; width:98%; height:15px\" maxlength=\"20\" onkeypress=\"return CheckforValidDecimal(this.value,4,event);\"  disabled='disabled'/>";
		}*/
}

function calculateAmt()
{
	//var rowIndex=Number(obj.id)+1;
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	var fullAmt=0;
	var fullNetAmt=0;
//alert(tblPaymentDetails.rows[1].cells[4].childNodes[0].value);
	for(var x=1;x<tblPaymentDetails.rows.length;x++)
	{
		if((tblPaymentDetails.rows[x].cells[0].childNodes[0].checked)==true)
		{
			fullAmt=parseFloat(fullAmt)+parseFloat(tblPaymentDetails.rows[x].cells[6].childNodes[0].value);
			//fullNetAmt=parseFloat(fullNetAmt)+parseFloat(tblPaymentDetails.rows[x].cells[4].childNodes[0].value);
		}
		else
		{
			tblPaymentDetails.rows[x].cells[6].childNodes[0].value=parseFloat(tblPaymentDetails.rows[x].cells[4].childNodes[0].value);
		}
	}
	
	//tblPaymentDetails.rows[tblPaymentDetails.rows.length-1].cells[1].childNodes[0].value=fullNetAmt;
	document.getElementById('txtFullAmount').value=fullAmt;
}

function calculatePayingAmt(obj)
{
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	var rowIndex=obj.parentNode.parentNode.rowIndex;
	var svat=tblPaymentDetails.rows[rowIndex].cells[5].childNodes[0].value;
	
	if(tblPaymentDetails.rows[rowIndex].cells[5].childNodes[0].value=='')
		svat=0;
	
	if((document.getElementById('chk_svat').checked)==true)
		tblPaymentDetails.rows[rowIndex].cells[6].childNodes[0].value=parseFloat(tblPaymentDetails.rows[rowIndex].cells[4].childNodes[0].value);
	else
	{
		tblPaymentDetails.rows[rowIndex].cells[6].childNodes[0].value=parseFloat(tblPaymentDetails.rows[rowIndex].cells[4].childNodes[0].value)+parseFloat(svat);
	}
	calculateAmt();
}

function clearGrid()
{
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	for(var x=tblPaymentDetails.rows.length-1;x>0;x--)
		tblPaymentDetails.deleteRow(x);
	
}


function validateData()
{
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	var forwaderId = document.getElementById('cboForwader').value;
	var chequeNo   = document.getElementById('txtChequeNo').value;
	var invId=0;
	var chequeValue=0;
	
	var selectCount=0;
		var tblPaymentDetails=document.getElementById('tblPaymentDetails');
			if(tblPaymentDetails.rows.length>1)
			{
				for(var x=1;x<tblPaymentDetails.rows.length;x++)
				{
					if((tblPaymentDetails.rows[x].cells[0].childNodes[0].checked)==true)
					{
						selectCount=1;
						break;
					}
				}
			}
		if(chequeNo=='')
			alert("Please Enter a Cheque No");
		else
		{
			if(selectCount==0)
				alert("Please select an Invoice No");
			else if(selectCount==1)
			{
				for(var x=1;x<tblPaymentDetails.rows.length;x++)
					{
						if((tblPaymentDetails.rows[x].cells[0].childNodes[0].checked)==true)
						{
							if( tblPaymentDetails.rows[x].cells[4].childNodes[0].value<=0)
							{
								invId=tblPaymentDetails.rows[x].cells[1].childNodes[0].nodeValue;
								chequeValue=1;
								break;
							}
						}
					}
					saveData();
			}
			/*else if(chequeNo==1)
				alert("Invoice No "+invId+" should contain a cheque No");*/
			else if(chequeValue==1)
				alert("Invoice No "+invId+" should contain a amount");
			
			else
				saveData();
		}
}

function saveData()
{
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	var forwaderId = document.getElementById('cboForwader').value;
	
	for(var x=1;x<tblPaymentDetails.rows.length;x++)
	{
		if((tblPaymentDetails.rows[x].cells[0].childNodes[0].checked)==true)
		{
			var url ="payment-db.php?id=saveGrid";
				url+="&forwaderId="+forwaderId;
				url+="&invId="+tblPaymentDetails.rows[x].cells[1].childNodes[0].nodeValue;
				url+="&chequeNo="+document.getElementById('txtChequeNo').value;
				url+="&chequeValue="+tblPaymentDetails.rows[x].cells[6].childNodes[0].value;
				
			var xmlhttp_obj	  = $.ajax({url:url,async:false})
			//alert(xmlhttp_obj.responseText);
		}
	}
	alert("Saved Successfully");	
	clearForm();
}

function clearForm()
{
	window.location.reload();
}

function changeAmount(obj)
{
	var tblPaymentDetails=document.getElementById('tblPaymentDetails');
	if(tblPaymentDetails.rows.length>1)
	{
		if(obj.checked==true)
		{
			for(var x=1;x<tblPaymentDetails.rows.length;x++)
			{
				if(tblPaymentDetails.rows[x].cells[0].childNodes[0].checked==true)
					tblPaymentDetails.rows[x].cells[6].childNodes[0].value=parseFloat(tblPaymentDetails.rows[x].cells[4].childNodes[0].value);
			}
		}
		else
		{
			for(var x=1;x<tblPaymentDetails.rows.length;x++)
			{
				if(tblPaymentDetails.rows[x].cells[0].childNodes[0].checked==true)
					tblPaymentDetails.rows[x].cells[6].childNodes[0].value=parseFloat(tblPaymentDetails.rows[x].cells[4].childNodes[0].value)+parseFloat(tblPaymentDetails.rows[x].cells[5].childNodes[0].value);
			}
		}
		calculateAmt();
	}
}

function payment_fix_header()
{
	$("#tblPaymentDetails").fixedHeader({
	width: 530,height: 200
	});	
}