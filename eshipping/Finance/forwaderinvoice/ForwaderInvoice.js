function loadGrid()
{
	showPleaseWait();
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	for(var i=tbl_forwaderInvDetails.rows.length;i>1;i--)
		tbl_forwaderInvDetails.deleteRow(i-1);
	
	var forwaderId=document.getElementById('cboForwader').value;
	
	var carrierName=document.getElementById('cboCarrier').value;
	
	if(forwaderId!=0 || carrierName!='')
	{
		var url="ForwaderInvoice-db.php?id=loadGrid";
		   url+="&forwaderId="+forwaderId;
		   url+="&carrierName="+carrierName;
		  
		   
		var xmlhttp_obj	  = $.ajax({url:url,async:false})
		//alert(xmlhttp_obj.responseText);
		
		var cusdecNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("CusdecNo");
		var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
		var XMLInvNo	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		
		
		for(var x=0;x<cusdecNo.length;x++)
		{	
			
			var newRow			 	  = tbl_forwaderInvDetails.insertRow(x+1);
		
			
			var newCellSelectPl       = tbl_forwaderInvDetails.rows[x+1].insertCell(0);
			newCellSelectPl.className ="normalfntMid";	
			newCellSelectPl.width	  ="4%";
			newCellSelectPl.align 	  ="center";
			newCellSelectPl.innerHTML = "<input type=\"checkbox\" align=\"center\" />";
			
			
			var newCellCusdecNo        = tbl_forwaderInvDetails.rows[x+1].insertCell(1);
			newCellCusdecNo.className ="normalfntMid";
			newCellCusdecNo.align      ="center";
			newCellCusdecNo.innerHTML  = cusdecNo[x].childNodes[0].nodeValue;
			
			
			var newCellBPONo       = tbl_forwaderInvDetails.rows[x+1].insertCell(2);
			newCellBPONo.className ="normalfntMid";
			newCellBPONo.align     ="center";
			newCellBPONo.innerHTML = XMLBPONo[x].childNodes[0].nodeValue;
			
			var newCellInvNo        = tbl_forwaderInvDetails.rows[x+1].insertCell(3);
			newCellInvNo.className ="normalfntMid";
			newCellInvNo.align      ="center";
			newCellInvNo.innerHTML  = XMLInvNo[x].childNodes[0].nodeValue;
			
		}
	
	}
	
	//deleteExists();
	hidePleaseWait();
}

function deleteExists()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	var forwaderId=document.getElementById('cboForwader').value;
	
	var url="ForwaderInvoice-db.php?id=checkExists";
		url+="&forwaderId="+forwaderId;
		   
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
	for(var x=0;x<XMLBPONo.length;x++)
	{
		for(var i=1;i<tbl_forwaderInvDetails.rows.length;i++)
		{
			if(tbl_forwaderInvDetails.rows[i].cells[2].innerHTML==XMLBPONo[x].childNodes[0].nodeValue)
				tbl_forwaderInvDetails.deleteRow(i);
		}
	}
}


function validateData()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	
	var forwaderInvNo=document.getElementById('txtForInvNo').value;
	var forwaderId=document.getElementById('cboForwader').value;
	var carrierName=document.getElementById('cboCarrier').value;
	var amount=document.getElementById('txtAmount').value;
	var forInvDate=document.getElementById('txtDate').value;
	var selectCount=0;
	
	if(document.getElementById('cboSearchForwader').value==0)
	{
		if(forwaderId==0)
			alert("Please Select a Forwader");
		else if(forwaderInvNo=='')
			alert("Please specify a Forwader Invoice Number");
		else if(amount=='')
			alert("Please Specify Amount");
		else
		{
			if(tbl_forwaderInvDetails.rows.length>1)
				{
					for(var x=1;x<tbl_forwaderInvDetails.rows.length;x++)
					{
						if((tbl_forwaderInvDetails.rows[x].cells[0].childNodes[0].checked)==true)
						{
							selectCount=1;
							break;
						}
					}
				}
			if(selectCount==0)
				alert("Please select a row");	
			else
			{
				showPleaseWait();
				saveData();
				hidePleaseWait();
			}
		}
	}
	else
	{
		if(document.getElementById('cboSearchInv').value==0)
			alert("Please Search an Invoice");
		else if(document.getElementById('txtPaidAmt').value!=0)
		{
			alert("Amount has been paid.You can't update");
			clearForm();
		}
		else
		{
			if(tbl_forwaderInvDetails.rows.length>1)
				{
					for(var x=1;x<tbl_forwaderInvDetails.rows.length;x++)
					{
						if((tbl_forwaderInvDetails.rows[x].cells[0].childNodes[0].checked)==true)
						{
							selectCount=1;
							break;
						}
					}
				}
			if(selectCount==0)
				alert("Please select a row");	
			else
			{
				showPleaseWait();
				updateData();
				hidePleaseWait();
			}
		}
	}
}

function saveData()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	
	var forwaderInvNo=document.getElementById('txtForInvNo').value;
	var forwaderId=document.getElementById('cboForwader').value;
	var carrierName=document.getElementById('cboCarrier').value;
	var amount=document.getElementById('txtAmount').value;
	var forInvDate=document.getElementById('txtDate').value;
	var submitStatus=0;
	var submitDate='';
	
	if(document.getElementById('chk_forInvSubmit').checked==true)
	{
		submitStatus=1;
		submitDate=document.getElementById('txtSubInvDate').value;
	}
		
	var url="ForwaderInvoice-db.php?id=saveHeader";
		url+="&forwaderId="+forwaderId;
		url+="&carrierName="+carrierName;
		url+="&forwaderInvNo="+forwaderInvNo;
		url+="&amount="+amount;
		url+="&forInvDate="+forInvDate;
		url+="&submitStatus="+submitStatus;
		url+="&submitDate="+submitDate;
		   
	var html_httpobj	  = $.ajax({url:url,async:false})
	//alert(html_httpobj.responseText);
	
	if(html_httpobj.responseText==1)
	{
		for(var x=1;x<tbl_forwaderInvDetails.rows.length;x++)
		{
			var cusdecNo           =tbl_forwaderInvDetails.rows[x].cells[1].innerHTML;
			var bpoNo    		   =tbl_forwaderInvDetails.rows[x].cells[2].innerHTML;
			var commercialInvoiceNo=tbl_forwaderInvDetails.rows[x].cells[3].innerHTML;
		
			if((tbl_forwaderInvDetails.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url="ForwaderInvoice-db.php?id=saveDetail";
					url+="&forwaderId="+forwaderId;
					url+="&forwaderInvNo="+forwaderInvNo;
					url+="&cusdecNo="+cusdecNo;
					url+="&bpoNo="+bpoNo;
					url+="&commercialInvoiceNo="+commercialInvoiceNo;
				var html_obj	  = $.ajax({url:url,async:false});
				//alert(html_obj.responseText);
			}
		}

	alert("Saved Successfully!!!");
	clearForm();		
	}
	else
		alert("Saving Failed");
}

function clearForm()
{
	window.location.href='ForwarderInvoice.php';
}

function loadSavedInvoices()
{
	clearGrid();
	if(document.getElementById('cboSearchForwader').value!=0)
	{
		document.getElementById('cboForwader').disabled=true;
		document.getElementById('cboForwader').value=0;
		document.getElementById('cboCarrier').disabled=true;
		document.getElementById('cboCarrier').value='';
		
		document.getElementById('cboSearchInv').disabled=false;
		var url="ForwaderInvoice-db.php?id=loadInvoiceCombo";
			url+="&forwaderId="+document.getElementById('cboSearchForwader').value;
		var html_obj	  = $.ajax({url:url,async:false});
		document.getElementById('cboSearchInv').innerHTML=html_obj.responseText;
	}
	else
	{
		document.getElementById('cboForwader').disabled=false;
		document.getElementById('cboCarrier').disabled=false;
		
		document.getElementById('cboSearchInv').value=0;
		document.getElementById('cboSearchInv').disabled=true;
		clearGrid();
		clearHeader();
	}
}

function loadSavedData()
{
	clearGrid();
	var invoiceNo=document.getElementById('cboSearchInv').value;
	var forwaderId=document.getElementById('cboSearchForwader').value;
	
	if(invoiceNo!=0)
	{
		
		var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
		var url="ForwaderInvoice-db.php?id=loadSavedInvoiceDetail";
			url+="&invoiceNo="+URLEncode(invoiceNo);
			url+="&forwaderId="+forwaderId;
		
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(xmlhttp_obj.responseText);
		var savedDate 	  = xmlhttp_obj.responseXML.getElementsByTagName("Date");
		var ChequeNO 	  = xmlhttp_obj.responseXML.getElementsByTagName("ChequeNO");
		var PaidAmount	  = xmlhttp_obj.responseXML.getElementsByTagName("PaidAmount");
		var Amount	      = xmlhttp_obj.responseXML.getElementsByTagName("Amount");
		var SubmitStatus  = xmlhttp_obj.responseXML.getElementsByTagName("SubmitStatus");
		var SubmitDate	  = xmlhttp_obj.responseXML.getElementsByTagName("SubmitDate");
		
		var cusdecNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("CusdecNo");
		var XMLBPONo 	  = xmlhttp_obj.responseXML.getElementsByTagName("BPONo");
		var XMLInvNo	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		
		document.getElementById('txtForInvNo').disabled=true;
		document.getElementById('txtForInvNo').value=invoiceNo;
		document.getElementById('txtDate').value=savedDate[0].childNodes[0].nodeValue;
		document.getElementById('txtAmount').value=Amount[0].childNodes[0].nodeValue;
		document.getElementById('txtChequeNo').value=ChequeNO[0].childNodes[0].nodeValue;
		document.getElementById('txtPaidAmt').value=PaidAmount[0].childNodes[0].nodeValue;
		
		if(SubmitStatus[0].childNodes[0].nodeValue==1)
		{
			document.getElementById('chk_forInvSubmit').checked=true;
			document.getElementById('txtSubInvDate').value=SubmitDate[0].childNodes[0].nodeValue;
		}
		else
		{
			/*var date = new Date();
			var d  = date.getDate();
			var day = (d < 10) ? '0' + d : d;
			var m = date.getMonth() + 1;
			var month = (m < 10) ? '0' + m : m;
			var yyyy = date.getFullYear();
	
			document.getElementById('txtSubInvDate').value=day+"/"+month+"/"+yyyy;*/
			
			document.getElementById('chk_forInvSubmit').checked=false;
			//document.getElementById('txtSubInvDate').value=SubmitDate[0].childNodes[0].nodeValue;
		}
		
		
		for(var x=0;x<cusdecNo.length;x++)
		{	
			
			var newRow			 	  = tbl_forwaderInvDetails.insertRow(x+1);
		
			
			var newCellSelectPl       	 = tbl_forwaderInvDetails.rows[x+1].insertCell(0);
			newCellSelectPl.className 	 = "normalfntMid";	
			newCellSelectPl.width	 	 = "4%";
			newCellSelectPl.align 	  	 = "center";
			newCellSelectPl.innerHTML	 = "<input type=\"checkbox\" align=\"center\" checked=\"checked\" />";
			
			
			var newCellCusdecNo       	 = tbl_forwaderInvDetails.rows[x+1].insertCell(1);
			newCellCusdecNo.className 	 = "normalfntMid";
			newCellCusdecNo.align      	 = "center";
			newCellCusdecNo.innerHTML  	 = cusdecNo[x].childNodes[0].nodeValue;
			
			
			var newCellBPONo       		 = tbl_forwaderInvDetails.rows[x+1].insertCell(2);
			newCellBPONo.className 		 = "normalfntMid";
			newCellBPONo.align     		 = "center";
			newCellBPONo.innerHTML  	 = XMLBPONo[x].childNodes[0].nodeValue;
			
			var newCellInvNo        	 = tbl_forwaderInvDetails.rows[x+1].insertCell(3);
			newCellInvNo.className 		 = "normalfntMid";
			newCellInvNo.align    		 = "center";
			newCellInvNo.innerHTML		 = XMLInvNo[x].childNodes[0].nodeValue;
			
		}
		
	}
	else
	{	
		clearGrid();
		document.getElementById('txtForInvNo').disabled=false;
		clearHeader();
	}
}

function clearHeader()
{
	var date = new Date();
	var d  = date.getDate();
	var day = (d < 10) ? '0' + d : d;
	var m = date.getMonth() + 1;
	var month = (m < 10) ? '0' + m : m;
	var yyyy = date.getFullYear();
	
	document.getElementById('txtDate').value=day+"/"+month+"/"+yyyy;
	document.getElementById('txtForInvNo').disabled=false;
	document.getElementById('chk_forInvSubmit').checked=false;
	document.getElementById('txtForInvNo').value='';
	document.getElementById('txtAmount').value='';
	document.getElementById('txtChequeNo').value='';
	document.getElementById('txtPaidAmt').value='';
}

function clearGrid()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	for(var i=tbl_forwaderInvDetails.rows.length;i>1;i--)
		tbl_forwaderInvDetails.deleteRow(i-1);
}

function updateData()
{
	var tbl_forwaderInvDetails=document.getElementById('tbl_forwaderInvDetails');
	var forwaderInvNo=document.getElementById('cboSearchInv').value;
	var forwaderId=document.getElementById('cboSearchForwader').value;
	var newDate=document.getElementById('txtDate').value;
	var newAmount=document.getElementById('txtAmount').value;
	var submitStatus=0;
	var submitDate='';
	
	if(document.getElementById('chk_forInvSubmit').checked==true)
	{
		submitStatus=1;
		submitDate=document.getElementById('txtSubInvDate').value;
	}
	
	var url="ForwaderInvoice-db.php?id=updateHeader";
		url+="&forwaderId="+forwaderId;
		url+="&invoiceNo="+forwaderInvNo;
		url+="&newDate="+newDate;
		url+="&newAmount="+newAmount;
		url+="&submitStatus="+submitStatus;
		url+="&submitDate="+submitDate;
		
	var html_httpobj	  = $.ajax({url:url,async:false})
	
	if(html_httpobj.responseText==1)
	{
		for(var x=1;x<tbl_forwaderInvDetails.rows.length;x++)
		{
			var cusdecNo            = tbl_forwaderInvDetails.rows[x].cells[1].innerHTML;
			var bpoNo    		    = tbl_forwaderInvDetails.rows[x].cells[2].innerHTML;
			var commercialInvoiceNo = tbl_forwaderInvDetails.rows[x].cells[3].innerHTML;
		
			if((tbl_forwaderInvDetails.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url="ForwaderInvoice-db.php?id=saveDetail";
					url+="&forwaderId="+forwaderId;
					url+="&forwaderInvNo="+forwaderInvNo;
					url+="&cusdecNo="+cusdecNo;
					url+="&bpoNo="+bpoNo;
					url+="&commercialInvoiceNo="+commercialInvoiceNo;
				var html_obj	  = $.ajax({url:url,async:false});
				//alert(html_obj.responseText);
			}
		}

	alert("Updated Successfully!!!");
	clearForm();		
	}
	else
		alert("Update Failed");
}

function loadListData(forwarderId,invoiceNo)
{
	document.getElementById('cboSearchForwader').value = forwarderId;
	document.getElementById('cboSearchForwader').disabled=true;
	
	loadSavedInvoices();
	document.getElementById('cboSearchInv').value = invoiceNo;
	document.getElementById('cboSearchInv').disabled=true;
	loadSavedData();
}