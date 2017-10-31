// JavaScript Document
function clearForm()
{
	window.location.reload();
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

function loadBanks()
{
	//var tblreceipt=document.getElementById('tblreceipt');
	clearGrid();
	
	var buyerId=document.getElementById('cboBuyer').value;
	
	if(buyerId!=0)
	{
		document.getElementById('cboBankLetterNo').disabled=false;
	}
	else
	{
		//document.getElementById('cboBank').disabled=true;
		document.getElementById('cboBankLetterNo').disabled=false;
	}
		var url ="receipt-db.php?id=loadBankLetter";
			url+="&buyerId="+buyerId;
		
		var htmlobj	  = $.ajax({url:url,async:false})
	
		document.getElementById('cboBankLetterNo').innerHTML=htmlobj.responseText;
}

function validateDataToLoadGrid()
{
	var dateFrom = document.getElementById('txtDateFrom').value;
	var dateTo = document.getElementById('txtDateTo').value;
	
	var splitDateFrom = dateFrom.split("/");
	var splitDateTo = dateTo.split("/");
	
	if(document.getElementById('cboSerialNo').value==0)
	{
		if(document.getElementById('cboBuyer').value==0)
			alert("Please Select a Buyer");
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
				showPleaseWait();
				clearGrid();
				loadGrid();
				hidePleaseWait();
			}
		}
		else
		{
			clearGrid();
			showPleaseWait();
			loadGrid();
			hidePleaseWait();
		}
	}
}
function clearGrid()
{
	var tblreceipt=document.getElementById('tblreceipt');
	for(var i=tblreceipt.rows.length-1;i>0;i--)
		tblreceipt.deleteRow(i);	
}

function loadGrid()
{
	//var tblreceipt=document.getElementById('tblreceipt');
	var tblreceipt=document.getElementById('tblreceipt');
		var masterbuyerCode = document.getElementById('cboBuyer').value;
		var bankCode = document.getElementById('cboBank').value;
		var bankLetterNo = document.getElementById('cboBankLetterNo').value;
		var dateFrom  = document.getElementById('txtDateFrom').value;
		var dateTo	  = document.getElementById('txtDateTo').value;
		
		if(document.getElementById('chk_dateRange').checked==true)
			var chk_val=1;
			
		else
			var chk_val=0;
			//chk_val=0;
	
		var url	="receipt-db.php?id=loadGrid";
			url+="&masterbuyerCode="+masterbuyerCode;
			url+="&bankCode="+bankCode;
			url+="&chk_val="+chk_val;
			url+="&dateFrom="+dateFrom;
			url+="&dateTo="+dateTo;
			url+="&bankLetterNo="+bankLetterNo;
			
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(xmlhttp_obj.responseText);
		
		var XMLInvoiceNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		var XMLInvAmount 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvAmount");
		var XMLInvDate  	  = xmlhttp_obj.responseXML.getElementsByTagName("InvDate");
		var XMLDiscountAmt    = xmlhttp_obj.responseXML.getElementsByTagName("Discount");
		var XMLDiscountType   = xmlhttp_obj.responseXML.getElementsByTagName("DiscountType");
		var XMLBuyerPoNo   	  = xmlhttp_obj.responseXML.getElementsByTagName("PoNo");
		var XMLBuyerStyleId   = xmlhttp_obj.responseXML.getElementsByTagName("Style");
		var XMLwfxid		  = xmlhttp_obj.responseXML.getElementsByTagName("wfxid");
		
		var totInvAmt=0;
		var totDisAmt=0;
		var totNetAmt=0;
		
		tblreceipt.className='scriptBgClr';
		for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
			
			var newRow			 	    = tblreceipt.insertRow(x+1);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellSelectPl         = tblreceipt.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" onclick='calculateAmt();' />";
			
			
			var newCellInvoiceNo        = tblreceipt.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfntMid";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblreceipt.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLInvDate[x].childNodes[0].nodeValue;
			
			var newCellStyle              = tblreceipt.rows[x+1].insertCell(3);
			newCellStyle.className       = "normalfntMid";
			newCellStyle.align           = "center";
			newCellStyle.innerHTML       = XMLBuyerStyleId[x].childNodes[0].nodeValue;
			
			var newCellPoNo             = tblreceipt.rows[x+1].insertCell(4);
			newCellPoNo.className       = "normalfntMid";
			newCellPoNo.align           = "center";
			newCellPoNo.innerHTML       = XMLBuyerPoNo[x].childNodes[0].nodeValue;
			
			
			var newCellAmount             = tblreceipt.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLInvAmount[x].childNodes[0].nodeValue;
			
			
		
			
			
			
			totInvAmt=totInvAmt + parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			totDisAmt=totDisAmt + parseFloat((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100);
			totNetAmt=totNetAmt + parseFloat(XMLInvAmount[x].childNodes[0].nodeValue-((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100));
			
			
			if(XMLDiscountType[x].childNodes[0].nodeValue=='value')
			{
				var newCellDiscount           = tblreceipt.rows[x+1].insertCell(6);
				newCellDiscount.className     = "normalfntMid2";
				newCellDiscount.align         = "right";
				newCellDiscount.innerHTML     = XMLDiscountAmt[x].childNodes[0].nodeValue;
			
				var newCellNetAmt           = tblreceipt.rows[x+1].insertCell(7);
				newCellNetAmt.className     = "normalfntMid2";
				newCellNetAmt.align         = "right";
				newCellNetAmt.innerHTML     = XMLInvAmount[x].childNodes[0].nodeValue-XMLDiscountAmt[x].childNodes[0].nodeValue;
				
					
			var newCellWfxId             = tblreceipt.rows[x+1].insertCell(8);
			newCellWfxId .className       = "normalfntMid2";
			newCellWfxId .align           = "right";
			newCellWfxId .innerHTML       = XMLwfxid[x].childNodes[0].nodeValue;
			}
			else
			{
				var newCellDiscount           = tblreceipt.rows[x+1].insertCell(6);
				newCellDiscount.className     = "normalfntMid2";
				newCellDiscount.align         = "right";
				newCellDiscount.innerHTML     = ((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100).toFixed(2);
			
				var newCellNetAmt           = tblreceipt.rows[x+1].insertCell(7);
				newCellNetAmt.className     = "normalfntMid2";
				newCellNetAmt.align         = "right";
				newCellNetAmt.innerHTML     = (XMLInvAmount[x].childNodes[0].nodeValue-((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100)).toFixed(2);
				
					
			var newCellWfxId             = tblreceipt.rows[x+1].insertCell(8);
			newCellWfxId .className       = "normalfntMid2";
			newCellWfxId .align           = "right";
			newCellWfxId .innerHTML       = XMLwfxid[x].childNodes[0].nodeValue;
			}
			
		}
		
		/*if(tblreceipt.rows.length>0)
		{
			var lastRow = tblreceipt.rows.length;
			var newRow			 	    = tblreceipt.insertRow(lastRow);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellTotal        = tblreceipt.rows[lastRow].insertCell(0);
			newCellTotal.className  = "normalfntMid";
			newCellTotal.align      = "center";
			newCellTotal.colSpan    = 5;
			newCellTotal.style.backgroundColor  ="#CCCCCC"
			newCellTotal.innerHTML  = "Total";
			
			var newCellInvTotal        = tblreceipt.rows[lastRow].insertCell(1);
			newCellInvTotal.className  = "normalfntMid";
			newCellInvTotal.align      = "center";
			newCellInvTotal.style.backgroundColor="#CCCCCC"
			newCellInvTotal.innerHTML  = "";
			
			var newCellDisTotal        = tblreceipt.rows[lastRow].insertCell(2);
			newCellDisTotal.className  = "normalfntMid";
			newCellDisTotal.align      = "center";
			newCellDisTotal.style.backgroundColor="#CCCCCC"
			newCellDisTotal.innerHTML  = "";
			
			var newCellNetTotal        = tblreceipt.rows[lastRow].insertCell(3);
			newCellNetTotal.className  = "normalfntMid";
			newCellNetTotal.align      = "center";
			newCellNetTotal.style.backgroundColor="#CCCCCC"
			newCellNetTotal.innerHTML  = "";
			
		}
		*/
		document.getElementById('txtTotInvoice').value=AddThousandSeparator(totInvAmt.toFixed(2));
		document.getElementById('txtDiscount').value=AddThousandSeparator(totDisAmt.toFixed(2));
		document.getElementById('txtTotNet').value=AddThousandSeparator(totNetAmt.toFixed(2));
		
}



function saveData()
{
	showPleaseWait();
	var bankId		= document.getElementById('cboBank').value;
	var buyerId		= document.getElementById('cboBuyer').value;
	var serialNo	= document.getElementById('cboSerialNo').value;
	var buyerClaim  = document.getElementById('txtBuyerClaim').value;
	if(document.getElementById('txtBuyerClaim').value=='')
		buyerClaim=0;
	var remarks		= document.getElementById('txtRemarks').value;
		
	//var refNo		= URLEncode(document.getElementById('txtRefNo').value);
	var date = document.getElementById('txtDate').value;
	
	
	var tblreceipt=document.getElementById('tblreceipt');
	
			
	
	
	var url ="receipt-db.php?id=saveHeader";
		url+="&serialNo="+serialNo;
		url+="&bankId="+bankId;
		url+="&buyerId="+buyerId;
		url+="&date="+date;
		url+="&buyerClaim="+buyerClaim;
		url+="&remarks="+URLEncode(remarks);
		
	var htmlhttp_obj	  = $.ajax({url:url,async:false});
	//alert(htmlhttp_obj.responseText);
	
	var txtNetReceiptAmt1	= document.getElementById('txtNetReceiptAmt').value;
	var txtTotNetAmt1	= document.getElementById('txtTotNetAmt').value;
	var txtNetReceiptAmt= txtNetReceiptAmt1.replace(/[ ,]/g, "");
	var txtTotNetAmt= txtTotNetAmt1.replace(/[ ,]/g, "");
	//alert(txtNetReceiptAmt);
	//alert(txtNetReceiptAmt1);
	
			//	alert(parseFloat(txtNetReceiptAmt));
			//alert(parseFloat(txtTotNetAmt));
			
			//alert(txtTotNetAmt+txtNetReceiptAmt);
	
	//var XMLwfxid		  = xmlhttp_obj1.responseXML.getElementsByTagName("wfxid");
	
	if(htmlhttp_obj.responseText!=0)
	{
		for(var x=1;x<tblreceipt.rows.length;x++)
		{
			if((tblreceipt.rows[x].cells[0].childNodes[0].checked)==true)
			{
						var totfinvoiceamt=(parseFloat(txtNetReceiptAmt)/parseFloat(txtTotNetAmt)*parseFloat(tblreceipt.rows[x].cells[7].childNodes[0].nodeValue));
		//var finvoiceamt=AddThousandSeparator(totfinvoiceamt.toFixed(2));
		var finvoiceamt = (totfinvoiceamt.toFixed(2));
		//alert(finvoiceamt.toFixed(2))
		
		//var totfinvoiceamt=AddThousandSeparator(finvoiceamt.toFixed(2));
		//alert(finvoiceamt);
				
				var url1 ="receipt-db.php?id=saveDetail";
					url1+="&serialNo="+htmlhttp_obj.responseText;
					url1+="&invoiceNo="+tblreceipt.rows[x].cells[1].childNodes[0].nodeValue;
					url1+="&invoiceAmt="+tblreceipt.rows[x].cells[5].childNodes[0].nodeValue;
					url1+="&invoiceDate="+tblreceipt.rows[x].cells[2].childNodes[0].nodeValue;
					url1+="&invoiceDiscount="+tblreceipt.rows[x].cells[6].childNodes[0].nodeValue;
					url1+="&invoiceNetAmt="+tblreceipt.rows[x].cells[7].childNodes[0].nodeValue;
					url1+="&styleid="+tblreceipt.rows[x].cells[8].childNodes[0].nodeValue;
					url1+="&bankId="+bankId;
					url1+="&buyerId="+buyerId;
					url1+="&date="+date;
							
					url1+="&finvoiceamt="+finvoiceamt;
					url1+="&txtNetReceiptAmt="+txtNetReceiptAmt;
					url1+="&txtTotNetAmt="+txtTotNetAmt;
				var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
				//alert(htmlhttp_obj1.responseText);
				//alert(tblreceipt.rows[x].cells[8].childNodes[0].nodeValue);
				
			}
		}
		alert("Saved Successfully");
		//clearForm();
	}
	else
		alert("Saving Failed");
	hidePleaseWait();
	location.reload();
}

function validateData()
{
	var selectCount=0;
	var tblreceipt=document.getElementById('tblreceipt');
	
	//if(document.getElementById('cboSerialNo').value==0)
	//{
		if(tblreceipt.rows.length>1)
				{
					for(var x=0;x<tblreceipt.rows.length;x++)
					{
						if((tblreceipt.rows[x].cells[0].childNodes[0].checked)==true)
						{
							selectCount=1;
							break;
						}
					}
				}
		if(selectCount==0)
			alert("Select an Invoice No");
		else if(document.getElementById('cboBuyer').value==0)
			alert("Please Select a Buyer");
		else if(document.getElementById('cboBank').value==0)
			alert("Please Select a Bank");
		else if(document.getElementById('txtDateFrom').value>document.getElementById('txtDateTo').value)
			alert("Date From should be less than Date To");
		else
			saveData();
	//}
}

function loadHeaderDetails()
{
	//location.reload();
	clearGrid();
	showPleaseWait();
	if(document.getElementById('cboSerialNo').value!=0)
	{
		document.getElementById('cboBank').disabled=true;
		document.getElementById('cboBuyer').disabled=true;
		
		//var tblreceipt=document.getElementById('tblreceipt');
		var tblreceipt=document.getElementById('tblreceipt');
		var serialNo=document.getElementById('cboSerialNo').value;
		
		var url	="receipt-db.php?id=loadSavedHeader";
			url+="&serialNo="+serialNo;
			
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(xmlhttp_obj.responseText);
		
		var XMLBuyerCode	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerCode");
		var XMLBankCode 	  = xmlhttp_obj.responseXML.getElementsByTagName("BankCode");
		var XMLReceiptDate    = xmlhttp_obj.responseXML.getElementsByTagName("ReceiptDate");
		var XMLBuyerClaim  	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerClaim");
		var XMLRemarks  	  = xmlhttp_obj.responseXML.getElementsByTagName("Remarks");
		
		document.getElementById('cboBank').value=XMLBankCode[0].childNodes[0].nodeValue;
	    document.getElementById('cboBuyer').value=XMLBuyerCode[0].childNodes[0].nodeValue;
		document.getElementById('txtDate').value=XMLReceiptDate[0].childNodes[0].nodeValue;
		document.getElementById('txtBuyerClaim').value=XMLBuyerClaim[0].childNodes[0].nodeValue;
		document.getElementById('txtRemarks').value=XMLRemarks[0].childNodes[0].nodeValue;
		//location.reload();
		
		var url1	="receipt-db.php?id=loadSavedDetail";
			url1   +="&serialNo="+serialNo;
		var xmlhttp_obj1  = $.ajax({url:url1,async:false});
		
		var XMLInvoiceNo	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNo");
		var XMLInvAmount 	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvAmt");
		var XMLInvDate  	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvDate");
		var XMLInvDiscAmt	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvDiscAmt");
		var XMLInvNetAmt	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNetAmt");
		var XMLBuyerPoNo   	  = xmlhttp_obj1.responseXML.getElementsByTagName("PoNo");
		var XMLBuyerStyleId   = xmlhttp_obj1.responseXML.getElementsByTagName("Style");
		var XMLwfxid		  = xmlhttp_obj1.responseXML.getElementsByTagName("wfxid");
		//alert(XMLwfxid);
		//var XMLInvBuyer	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNetAmt");
		var invAmtTot		  = 0;
		var invDisTot		  = 0;
		var invNetTot		  = 0;
		tblreceipt.className='scriptBgClr';
		for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
				
			var newRow			 	    = tblreceipt.insertRow(x+1);
				newRow.className			= 'bcgcolor-tblrowWhite';
				
			var newCellSelectPl         = tblreceipt.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" checked=\"checked\" disabled=\"disabled\" onclick='calculateAmt();' />";
			
			
			var newCellInvoiceNo        = tblreceipt.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfntMid";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblreceipt.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLInvDate[x].childNodes[0].nodeValue;
			
			var newCellStyle              = tblreceipt.rows[x+1].insertCell(3);
			newCellStyle.className       = "normalfntMid";
			newCellStyle.align           = "center";
			newCellStyle.innerHTML       = XMLBuyerStyleId[x].childNodes[0].nodeValue;
			
			var newCellPoNo             = tblreceipt.rows[x+1].insertCell(4);
			newCellPoNo.className       = "normalfntMid";
			newCellPoNo.align           = "center";
			newCellPoNo.innerHTML       = XMLBuyerPoNo[x].childNodes[0].nodeValue;
			
			var newCellAmount             = tblreceipt.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLInvAmount[x].childNodes[0].nodeValue;
			invAmtTot+=parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			
			var newCellDisc             = tblreceipt.rows[x+1].insertCell(6);
			newCellDisc.className       = "normalfntMid2";
			newCellDisc.align           = "right";
			newCellDisc.innerHTML       = XMLInvDiscAmt[x].childNodes[0].nodeValue;
			invDisTot+=parseFloat(XMLInvDiscAmt[x].childNodes[0].nodeValue);
			
			var newCellNet             = tblreceipt.rows[x+1].insertCell(7);
			newCellNet.className       = "normalfntMid2";
			newCellNet.align           = "right";
			newCellNet.innerHTML       = XMLInvNetAmt[x].childNodes[0].nodeValue;
			invNetTot+=parseFloat(XMLInvNetAmt[x].childNodes[0].nodeValue);
			
			
			var newCellWfxId             = tblreceipt.rows[x+1].insertCell(8);
			newCellWfxId .className       = "normalfntMid2";
			newCellWfxId .align           = "right";
			newCellWfxId .innerHTML       = XMLwfxid[x].childNodes[0].nodeValue;
			
				//alert(XMLwfxid[x].childNodes[0].nodeValue);
////ok//
		
		document.getElementById('txtTotInvoiceAmt').value=AddThousandSeparator(invAmtTot.toFixed(2));
		document.getElementById('txtDiscountAmt').value=AddThousandSeparator(invDisTot.toFixed(2));
		document.getElementById('txtTotNetAmt').value=AddThousandSeparator(invNetTot.toFixed(2));
		
	document.getElementById('txtNetReceiptAmt').value = AddThousandSeparator((invNetTot - XMLBuyerClaim[0].childNodes[0].nodeValue).toFixed(2));
		}
		/*
		if(tblreceipt.rows.length>0)
		{
			var lastRow = tblreceipt.rows.length;
			var newRow			 	    = tblreceipt.insertRow(lastRow);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellTotal        = tblreceipt.rows[lastRow].insertCell(0);
			newCellTotal.className  = "normalfntMid";
			newCellTotal.align      = "center";
			newCellTotal.colSpan    = 5;
			newCellTotal.style.backgroundColor  ="#CCCCCC"
			newCellTotal.innerHTML  = "Total";
			
			var newCellInvTotal        = tblreceipt.rows[lastRow].insertCell(1);
			newCellInvTotal.className  = "normalfntMid";
			newCellInvTotal.align      = "center";
			newCellInvTotal.style.backgroundColor="#CCCCCC"
			newCellInvTotal.innerHTML  = AddThousandSeparator(invAmtTot.toFixed(2));
			
			var newCellDisTotal        = tblreceipt.rows[lastRow].insertCell(2);
			newCellDisTotal.className  = "normalfntMid";
			newCellDisTotal.align      = "center";
			newCellDisTotal.style.backgroundColor="#CCCCCC"
			newCellDisTotal.innerHTML  = AddThousandSeparator(invDisTot.toFixed(2));
			
			var newCellNetTotal        = tblreceipt.rows[lastRow].insertCell(3);
			newCellNetTotal.className  = "normalfntMid";
			newCellNetTotal.align      = "center";
			newCellNetTotal.style.backgroundColor="#CCCCCC"
			newCellNetTotal.innerHTML  = AddThousandSeparator(invNetTot.toFixed(2)); 
			
		}
		*/
		//document.getElementById('txtTotInvoiceAmt').value=invAmtTot.toFixed(2);
		//document.getElementById('txtTotDiscountAmt').value=invDisTot.toFixed(2);
		//document.getElementById('txtTotNetAmt').value=invNetTot.toFixed(2);
	}
	else
		clearHeader();
	hidePleaseWait();
}

function clearHeader()
{
	var date = new Date();
	var d  = date.getDate();
	var day = (d < 10) ? '0' + d : d;
	var m = date.getMonth() + 1;
	var month = (m < 10) ? '0' + m : m;
	var yyyy = date.getFullYear();
	
	document.getElementById('cboBank').value=0;
	document.getElementById('cboBank').disabled=false;
	document.getElementById('cboBuyer').disabled=false;
	document.getElementById('cboBankLetterNo').disabled=true;
	document.getElementById('cboBuyer').value=0;
	  document.getElementById('txtDate').value=day+"/"+month+"/"+yyyy;
	 document.getElementById('txtBuyerClaim').value=0;
	 document.getElementById('txtRemarks').value='';
}

function calculateAmt()
{
	
	var tblreceipt=document.getElementById('tblreceipt');
	var lastRow = tblreceipt.rows.length-1;
	//var rowNumber=obj.parentNode.parentNode.rowIndex;
	var fullInvAmt=0;
	var fullDisAmt=0;
	var fullNetAmt=0;
	for(var i=0;i<tblreceipt.rows.length-1;i++)
	{
		if(tblreceipt.rows[i].cells[0].childNodes[0].checked==true)
		{
			fullInvAmt=fullInvAmt+parseFloat(tblreceipt.rows[i].cells[5].childNodes[0].nodeValue);
			fullDisAmt=fullDisAmt+parseFloat(tblreceipt.rows[i].cells[6].childNodes[0].nodeValue);
			fullNetAmt=fullNetAmt+parseFloat(tblreceipt.rows[i].cells[7].childNodes[0].nodeValue);
		}
	}
	//ok//
	document.getElementById('txtTotInvoiceAmt').value=AddThousandSeparator(fullInvAmt.toFixed(2));
	document.getElementById('txtDiscountAmt').value=AddThousandSeparator(fullDisAmt.toFixed(2));
	document.getElementById('txtTotNetAmt').value=AddThousandSeparator(fullNetAmt.toFixed(2));
	
	if(document.getElementById('txtBuyerClaim').value=='')
		var totNetRecAmt = fullNetAmt;
	else
		var totNetRecAmt = fullNetAmt - parseFloat(document.getElementById('txtBuyerClaim').value);
	document.getElementById('txtNetReceiptAmt').value=AddThousandSeparator(totNetRecAmt.toFixed(2));
	
	tblreceipt.rows[lastRow].cells[1].innerHTML=AddThousandSeparator(fullInvAmt.toFixed(2));
	tblreceipt.rows[lastRow].cells[2].innerHTML=AddThousandSeparator(fullDisAmt.toFixed(2));
	tblreceipt.rows[lastRow].cells[3].innerHTML=AddThousandSeparator(fullNetAmt.toFixed(2));
}





function cancelReceipt()
{
	var tblreceipt=document.getElementById('tblreceipt');
	if(document.getElementById('cboSerialNo').value!=0)
	{
		var url	="receipt-db.php?id=cancelReceipt";
			url+="&serialNo="+document.getElementById('cboSerialNo').value;
			
		var http_obj	  = $.ajax({url:url,async:false});
		
		//alert(http_obj.responseText);
		//deleteFromMS();
		
		clearForm();
	}
}

function deleteFromMS()
{
	var bankId		= document.getElementById('cboBank').value;
	var buyerId		= document.getElementById('cboBuyer').value;
	var serialNo	= document.getElementById('cboSerialNo').value;
	var date = document.getElementById('txtDate').value;
	var tblreceipt=document.getElementById('tblreceipt');
	for(var x=0;x<tblreceipt.rows.length;x++)
		{
			if((tblreceipt.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url1 ="receipt-db.php?id=deleteFromMs";
					url1+="&serialNo="+serialNo;
					url1+="&invoiceNo="+tblreceipt.rows[x].cells[1].childNodes[0].nodeValue;
					url1+="&invoiceAmt="+tblreceipt.rows[x].cells[3].childNodes[0].nodeValue;
					url1+="&invoiceDate="+tblreceipt.rows[x].cells[2].childNodes[0].nodeValue;
					url1+="&invoiceDiscount="+tblreceipt.rows[x].cells[4].childNodes[0].nodeValue;
					url1+="&invoiceNetAmt="+tblreceipt.rows[x].cells[5].childNodes[0].nodeValue;
					url1+="&bankId="+bankId;
					url1+="&buyerId="+buyerId;
					url1+="&date="+date;
				var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
				//alert(htmlhttp_obj1.responseText);
			}
		}
}

function AddThousandSeparator(str, thousandSeparator, decimalSeparator) {
var sRegExp = new RegExp('(-?[0-9]+)([0-9]{3})'),
sValue = str + "", // to be sure we are dealing with a string
arrNum = [];

if (thousandSeparator === undefined) {thousandSeparator = ","; }
if (decimalSeparator === undefined) {decimalSeparator = "."; }

arrNum = sValue.split(decimalSeparator);
// let's be focused first only on the integer part
sValue = arrNum[0];

while(sRegExp.test(sValue)) {
sValue = sValue.replace(sRegExp, '$1' + thousandSeparator + '$2');
}

// time to add back the decimal part
if (arrNum.length > 1) {
sValue = sValue + decimalSeparator + arrNum[1];
}
return sValue;
}

function CancelInv()

{
			var cboSerialNo=document.getElementById('cboSerialNo').value;
			var bankLetterNo = document.getElementById('cboBankLetterNo').value;
			//var discountAmt = document.getElementById('txtDiscountAmt').value;
			
			var bankId		= document.getElementById('cboBank').value;
			var buyerId		= document.getElementById('cboBuyer').value;
		  // var serialNo=document.getElementById('cboSerialNo').value;
			var date = document.getElementById('txtDate').value;
			var txtDate	= document.getElementById('txtDate').value;
			
			
	var txtNetReceiptAmt1	= document.getElementById('txtNetReceiptAmt').value;
	var txtTotNetAmt1	= document.getElementById('txtTotNetAmt').value;
	var txtNetReceiptAmt= txtNetReceiptAmt1.replace(/[ ,]/g, "");
	var txtTotNetAmt= txtTotNetAmt1.replace(/[ ,]/g, "");		

			
			//alert(cboSerialNo)
			
	//alert(bankLetterNo);
	var tblreceipt=document.getElementById('tblreceipt');
	if(cboSerialNo!=0)
	{
		//alert("check cbo");
	for(var x=0;x<tblreceipt.rows.length;x++)
		{
		//var finvoiceamt=(parseFloat(txtNetReceiptAmt)/parseFloat(txtTotNetAmt)*parseFloat(tblreceipt.rows[x].cells[7].childNodes[0].nodeValue));
		
			if((tblreceipt.rows[x].cells[0].childNodes[0].checked)==true)
			{	
			
		var totfinvoiceamt=(parseFloat(txtNetReceiptAmt)/parseFloat(txtTotNetAmt)*parseFloat(tblreceipt.rows[x].cells[7].childNodes[0].nodeValue));
		var finvoiceamt = (totfinvoiceamt.toFixed(2));
		//var finvoiceamt=AddThousandSeparator(totfinvoiceamt.toFixed(2));
		//var totfinvoiceamt=AddThousandSeparator(finvoiceamt.toFixed(2));
		//alert(totfinvoiceamt);
				
				var url1 ="receipt-db.php?id=CancelInv";
				url1+="&invoiceNo="+tblreceipt.rows[x].cells[1].childNodes[0].nodeValue;
				//url1+="&serialNo="+serialNo;
				//url1+="&bankLetterNo="+bankLetterNo;
			url1+="&invoiceAmt="+tblreceipt.rows[x].cells[3].childNodes[0].nodeValue;
					url1+="&invoiceDate="+tblreceipt.rows[x].cells[2].childNodes[0].nodeValue;
					url1+="&invoiceDiscount="+tblreceipt.rows[x].cells[4].childNodes[0].nodeValue;
					url1+="&invoiceNetAmt="+tblreceipt.rows[x].cells[7].childNodes[0].nodeValue;
					url1+="&styleid="+tblreceipt.rows[x].cells[8].childNodes[0].nodeValue;
					url1+="&bankId="+bankId;
					url1+="&buyerId="+buyerId;
					url1+="&date="+date;
					url1+="&txtDate="+txtDate;
					url1+="&cboSerialNo="+cboSerialNo;
					
					url1+="&finvoiceamt="+finvoiceamt;
					url1+="&txtNetReceiptAmt="+txtNetReceiptAmt;
					url1+="&txtTotNetAmt="+txtTotNetAmt;

				var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
				//alert(tblreceipt.rows[x].cells[8].childNodes[0].nodeValue);
				//alert(htmlhttp_obj1.responseText);
			//	alert(tblreceipt.rows[x].cells[3].childNodes[0].nodeValue);
					
			}
		}
		alert("Successfully Deleted !");
	}
	else
		alert("Please Select a Reaference No");
		
		location.reload();
}

/*
function upload_po()
{
	var frmTuka=document.getElementById('frmTuka').value;
	alert("frmTuka");
	if(document.getElementById("sample_po_sheet").value=='')
	{
		alert("There is no file to upload. Please select the specific file.")	
		document.getElementById("sample_po_sheet").focus();
		return false;
	}
	document.frmTuka.submit();
}


function view_orderspec()
{
	var h_orderid=document.getElementById("h_orderid").value;
	location.href="../../order/orderspec/orderspec.php?orderno="+h_orderid; 	
}


function view_xlorderspec(obj)
{
	
	location.href="list_pos.php?batch="+obj; 
}*/


function uploadFileValidation()
{
	
	var selectCount=0;
	var tblreceipt=document.getElementById('tblreceipt');
	
	//if(document.getElementById('cboSerialNo').value==0)
	//{
		if(tblreceipt.rows.length>1)
				{
					for(var x=1;x<tblreceipt.rows.length;x++)
					{
					var GInvoiceNo=tblreceipt.rows[x].cells[1].childNodes[0].nodeValue;
					var GpoNo=tblreceipt.rows[x].cells[4].childNodes[0].nodeValue;
					
					var url1 ="receipt-db.php?id=uploadFile";
					//url1+="&invoiceNo="+tblreceipt.rows[x].cells[1].childNodes[0].nodeValue;
					//url1+="&poNo="+tblreceipt.rows[x].cells[4].childNodes[0].nodeValue;
					url1+="&GpoNo="+GpoNo;
					url1+="&GInvoiceNo="+GInvoiceNo;
		
					var xmlhttp_obj1	  = $.ajax({url:url1,async:false});
					//alert(xmlhttp_obj1.responseText);
					

		var XMLinvoiceNo  	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNo");
			//alert(XMLinvoiceNo);
			
			for(var n=0;n<XMLinvoiceNo.length;n++)
					{
						var invoiceNO = XMLinvoiceNo[n].childNodes[0].nodeValue;
						
					
							if(GInvoiceNo == invoiceNO)
							{
								if(tblreceipt.rows[x].cells[0].childNodes[0].checked == 0)
								{
									tblreceipt.rows[x].cells[0].childNodes[0].checked = 1;
								}
								else
								{
									tblreceipt.rows[x].cells[0].childNodes[0].checked = 0;
								}
								//var chkbx=tblreceipt.rows[x].cells[0].childNodes[0].checked ;
								//alert(chkbx);
									selectCount=1;
									break;
								
							}
							
						}
						
				}
				 calculateAmt()
				checkerror()
			}
		else
		alert("Please Load Grid!");
	
	
//showPleaseWait();
}

function checkerror()
{
var cboSerialNo=document.getElementById('cboSerialNo').value;
var tblreceipt=document.getElementById('tblreceipt');
	
	//if(document.getElementById('cboSerialNo').value==0)
	//{
		var url1 ="receipt-db.php?id=chkerror";
					url1+="&cboSerialNo="+cboSerialNo;
					var url1 ="receipt-db.php?id=chkerror";
					var htmlhttp_obj1	  = $.ajax({url:url1,async:false});	
					//alert(htmlhttp_obj1.responseText);
					var nofitem=htmlhttp_obj1.responseText;
					//alert(nofitem);
					if(nofitem !=0 )
					{
					alert("Please Check Error Report");
					}
					else
					{
						alert("Successfully Uploaded.");	
					}
					
	}



				
function loadDeleteDetails()
{	
		//var tblreceipt=document.getElementById('tblreceipt');
		var tblreceipt=document.getElementById('tblreceipt');
		var serialNo=document.getElementById('cboSerialNo3').value;
		//alert(serialNo);
		
		var url	="receipt-db.php?id=loadDeleteHeader";
			url+="&serialNo="+serialNo;
			
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(xmlhttp_obj.responseText);
		
		var XMLBuyerCode	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerCode");
		var XMLBankCode 	  = xmlhttp_obj.responseXML.getElementsByTagName("BankCode");
		var XMLReceiptDate    = xmlhttp_obj.responseXML.getElementsByTagName("ReceiptDate");
		var XMLBuyerClaim  	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerClaim");
		var XMLRemarks  	  = xmlhttp_obj.responseXML.getElementsByTagName("Remarks");
		
		document.getElementById('cboBank').value=XMLBankCode[0].childNodes[0].nodeValue;
	    document.getElementById('cboBuyer').value=XMLBuyerCode[0].childNodes[0].nodeValue;
		document.getElementById('txtDate').value=XMLReceiptDate[0].childNodes[0].nodeValue;
		document.getElementById('txtBuyerClaim').value=XMLBuyerClaim[0].childNodes[0].nodeValue;
		document.getElementById('txtRemarks').value=XMLRemarks[0].childNodes[0].nodeValue;
		//location.reload();
		
		var url1	="receipt-db.php?id=loadSavedDetail";
			url1   +="&serialNo="+serialNo;
		var xmlhttp_obj1  = $.ajax({url:url1,async:false});
		//alert(xmlhttp_obj1.responseText);
		
		var XMLInvoiceNo	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNo");
		var XMLInvAmount 	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvAmt");
		var XMLInvDate  	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvDate");
		var XMLInvDiscAmt	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvDiscAmt");
		var XMLInvNetAmt	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNetAmt");
		var XMLBuyerPoNo   	  = xmlhttp_obj1.responseXML.getElementsByTagName("PoNo");
		var XMLBuyerStyleId   = xmlhttp_obj1.responseXML.getElementsByTagName("Style");
		var XMLwfxid		  = xmlhttp_obj1.responseXML.getElementsByTagName("wfxid");
		//alert(XMLwfxid);
		//var XMLInvBuyer	  = xmlhttp_obj1.responseXML.getElementsByTagName("InvNetAmt");
		var invAmtTot		  = 0;
		var invDisTot		  = 0;
		var invNetTot		  = 0;
		tblreceipt.className='scriptBgClr';
		for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
				
			var newRow			 	    = tblreceipt.insertRow(x+1);
				newRow.className			= 'bcgcolor-tblrowWhite';
				
			var newCellSelectPl         = tblreceipt.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" checked=\"checked\" disabled=\"disabled\" onclick='calculateAmt();' />";
			
			
			var newCellInvoiceNo        = tblreceipt.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfntMid";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblreceipt.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLInvDate[x].childNodes[0].nodeValue;
			
			var newCellStyle              = tblreceipt.rows[x+1].insertCell(3);
			newCellStyle.className       = "normalfntMid";
			newCellStyle.align           = "center";
			newCellStyle.innerHTML       = XMLBuyerStyleId[x].childNodes[0].nodeValue;
			
			var newCellPoNo             = tblreceipt.rows[x+1].insertCell(4);
			newCellPoNo.className       = "normalfntMid";
			newCellPoNo.align           = "center";
			newCellPoNo.innerHTML       = XMLBuyerPoNo[x].childNodes[0].nodeValue;
			
			var newCellAmount             = tblreceipt.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLInvAmount[x].childNodes[0].nodeValue;
			invAmtTot+=parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			
			var newCellDisc             = tblreceipt.rows[x+1].insertCell(6);
			newCellDisc.className       = "normalfntMid2";
			newCellDisc.align           = "right";
			newCellDisc.innerHTML       = XMLInvDiscAmt[x].childNodes[0].nodeValue;
			invDisTot+=parseFloat(XMLInvDiscAmt[x].childNodes[0].nodeValue);
			
			var newCellNet             = tblreceipt.rows[x+1].insertCell(7);
			newCellNet.className       = "normalfntMid2";
			newCellNet.align           = "right";
			newCellNet.innerHTML       = XMLInvNetAmt[x].childNodes[0].nodeValue;
			invNetTot+=parseFloat(XMLInvNetAmt[x].childNodes[0].nodeValue);
			
			
			var newCellWfxId             = tblreceipt.rows[x+1].insertCell(8);
			newCellWfxId .className       = "normalfntMid2";
			newCellWfxId .align           = "right";
			newCellWfxId .innerHTML       = XMLwfxid[x].childNodes[0].nodeValue;
			
				//alert(XMLwfxid[x].childNodes[0].nodeValue);
////ok//
		
		document.getElementById('txtTotInvoiceAmt').value=AddThousandSeparator(invAmtTot.toFixed(2));
		document.getElementById('txtDiscountAmt').value=AddThousandSeparator(invDisTot.toFixed(2));
		document.getElementById('txtTotNetAmt').value=AddThousandSeparator(invNetTot.toFixed(2));
		
	document.getElementById('txtNetReceiptAmt').value = AddThousandSeparator((invNetTot - XMLBuyerClaim[0].childNodes[0].nodeValue).toFixed(2));
		}
		/*
		if(tblreceipt.rows.length>0)
		{
			var lastRow = tblreceipt.rows.length;
			var newRow			 	    = tblreceipt.insertRow(lastRow);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellTotal        = tblreceipt.rows[lastRow].insertCell(0);
			newCellTotal.className  = "normalfntMid";
			newCellTotal.align      = "center";
			newCellTotal.colSpan    = 5;
			newCellTotal.style.backgroundColor  ="#CCCCCC"
			newCellTotal.innerHTML  = "Total";
			
			var newCellInvTotal        = tblreceipt.rows[lastRow].insertCell(1);
			newCellInvTotal.className  = "normalfntMid";
			newCellInvTotal.align      = "center";
			newCellInvTotal.style.backgroundColor="#CCCCCC"
			newCellInvTotal.innerHTML  = AddThousandSeparator(invAmtTot.toFixed(2));
			
			var newCellDisTotal        = tblreceipt.rows[lastRow].insertCell(2);
			newCellDisTotal.className  = "normalfntMid";
			newCellDisTotal.align      = "center";
			newCellDisTotal.style.backgroundColor="#CCCCCC"
			newCellDisTotal.innerHTML  = AddThousandSeparator(invDisTot.toFixed(2));
			
			var newCellNetTotal        = tblreceipt.rows[lastRow].insertCell(3);
			newCellNetTotal.className  = "normalfntMid";
			newCellNetTotal.align      = "center";
			newCellNetTotal.style.backgroundColor="#CCCCCC"
			newCellNetTotal.innerHTML  = AddThousandSeparator(invNetTot.toFixed(2)); 
			
		}
		*/
		//document.getElementById('txtTotInvoiceAmt').value=invAmtTot.toFixed(2);
		//document.getElementById('txtTotDiscountAmt').value=invDisTot.toFixed(2);
		//document.getElementById('txtTotNetAmt').value=invNetTot.toFixed(2);
	

	
	
}

















