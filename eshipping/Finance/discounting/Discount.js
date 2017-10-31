// JavaScript Document

function loadBanks()
{
	var tblDiscountData=document.getElementById('tblDiscountData');
	clearGrid();
	
	var buyerId=document.getElementById('cboBuyer').value;
	
	var url ="Discount-db.php?id=loadBanks";
		url+="&buyerId="+buyerId;
		
	var htmlobj	  = $.ajax({url:url,async:false})
	
	document.getElementById('cboBank').innerHTML=htmlobj.responseText;
}

function loadBuyers()
{
	var bankId=document.getElementById('cboBank').value;
	
	var url ="Discount-db.php?id=loadBuyer";
		url+="&bankId="+bankId;
		
	var htmlobj	  = $.ajax({url:url,async:false})
	
	//alert(htmlobj.responseText);
	
	document.getElementById('cboBuyer').innerHTML=htmlobj.responseText;
}

function validateGrid()
{
	var bankId=document.getElementById('cboBank').value;
	var buyerId=document.getElementById('cboBuyer').value;
	
	if(buyerId==0)
		alert("Please Select a Buyer");
	else
		loadGrid();
}

function loadGrid()
{
	var bankId=document.getElementById('cboBank').value;
	var buyerId=document.getElementById('cboBuyer').value;
	
	var tblDiscountData=document.getElementById('tblDiscountData');
	
	clearGrid();
	
	if(buyerId!=0)
	{
		showPleaseWait();
		var url ="Discount-db.php?id=loadGrid";
			url+="&buyerId="+buyerId;
			url+="&bankId="+bankId;
		
		var xmlhttp_obj	  = $.ajax({url:url,async:false})
		//alert(xmlhttp_obj.responseText);
		var XMLInvoiceNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		var XMLInvAmount 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvAmount");
		var XMLInvDate  	  = xmlhttp_obj.responseXML.getElementsByTagName("InvDate");
		var XMLDiscountAmt    = xmlhttp_obj.responseXML.getElementsByTagName("Discount");
		var XMLDiscountType   = xmlhttp_obj.responseXML.getElementsByTagName("DiscountType");
		var XMLStyleId		  = xmlhttp_obj.responseXML.getElementsByTagName("StyleId");
		var XMLBuyerPoNo      = xmlhttp_obj.responseXML.getElementsByTagName("BuyerPoNo");
		var totInvSum = 0;
		var totDisSum = 0;
		var totNetSum = 0;
		
		
		for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
			
			var newRow			 	    = tblDiscountData.insertRow(x+1);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellSelectPl         = tblDiscountData.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" onclick=\"calculateSum(this);\"/>";
			
			
			var newCellInvoiceNo        = tblDiscountData.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfntMid";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblDiscountData.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLInvDate[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblDiscountData.rows[x+1].insertCell(3);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLStyleId[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblDiscountData.rows[x+1].insertCell(4);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLBuyerPoNo[x].childNodes[0].nodeValue;
			
			
			var newCellAmount             = tblDiscountData.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLInvAmount[x].childNodes[0].nodeValue;
			
			totInvSum = totInvSum + parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			totDisSum = totDisSum + parseFloat((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100);
			totNetSum = totNetSum + parseFloat(XMLInvAmount[x].childNodes[0].nodeValue-XMLDiscountAmt[x].childNodes[0].nodeValue);
			
			

			//alert ("totDisSum");
			
			if(XMLDiscountType[x].childNodes[0].nodeValue=='value')
			{
				var newCellDate           = tblDiscountData.rows[x+1].insertCell(6);
				newCellDate.className     = "normalfntMid2";
				newCellDate.align         = "right";
				newCellDate.innerHTML     = XMLDiscountAmt[x].childNodes[0].nodeValue;
			
				var newCellDate           = tblDiscountData.rows[x+1].insertCell(7);
				newCellDate.className     = "normalfntMid2";
				newCellDate.align         = "right";
				newCellDate.innerHTML     = XMLInvAmount[x].childNodes[0].nodeValue-XMLDiscountAmt[x].childNodes[0].nodeValue;
			}
			else
			{
				var newCellDate           = tblDiscountData.rows[x+1].insertCell(6);
				newCellDate.className     = "normalfntMid2";
				newCellDate.align         = "right";
				newCellDate.innerHTML     = ((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100).toFixed(2);
			
				var newCellDate           = tblDiscountData.rows[x+1].insertCell(7);
				newCellDate.className     = "normalfntMid2";
				newCellDate.align         = "right";
				newCellDate.innerHTML     = (XMLInvAmount[x].childNodes[0].nodeValue-((XMLInvAmount[x].childNodes[0].nodeValue*XMLDiscountAmt[x].childNodes[0].nodeValue)/100)).toFixed(2);
			}
			
		}
		
		
/*		if(tblDiscountData.rows.length>1)
		{
			var lastRow = tblDiscountData.rows.length;
			var newRow			 	    = tblDiscountData.insertRow(lastRow);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellTotal        = tblDiscountData.rows[lastRow].insertCell(0);
			newCellTotal.className  = "normalfntMid";
			newCellTotal.align      = "center";
			newCellTotal.colSpan    = 5;
			newCellTotal.style.backgroundColor  ="#CCCCCC"
			newCellTotal.innerHTML  = "Total";
			
			var newCellInvTotal        = tblDiscountData.rows[lastRow].insertCell(1);
			newCellInvTotal.className  = "normalfntMid";
			newCellInvTotal.align      = "center";
			newCellInvTotal.style.backgroundColor="#CCCCCC"
			newCellInvTotal.innerHTML  = "";
			
			var newCellDisTotal        = tblDiscountData.rows[lastRow].insertCell(2);
			newCellDisTotal.className  = "normalfntMid";
			newCellDisTotal.align      = "center";
			newCellDisTotal.style.backgroundColor="#CCCCCC"
			newCellDisTotal.innerHTML  = "";
			
			var newCellNetTotal        = tblDiscountData.rows[lastRow].insertCell(3);
			newCellNetTotal.className  = "normalfntMid";
			newCellNetTotal.align      = "center";
			newCellNetTotal.style.backgroundColor="#CCCCCC"
			newCellNetTotal.innerHTML  = "";
		}
		*/
		
		hidePleaseWait();
	}
	
			
			//alert(totDisSum);

			document.getElementById('txtSumInvoiceAmt').value=AddThousandSeparator(totInvSum.toFixed(2));
			document.getElementById('txtSumDiscountAmt').value=AddThousandSeparator(totDisSum.toFixed(2));
			document.getElementById('txtSumNetAmt').value=AddThousandSeparator(totNetSum.toFixed(2));
}


function calculateSum(obj)
{
	var tblDiscountData=document.getElementById('tblDiscountData');
	var lastRow = tblDiscountData.rows.length-1;
	var rowNumber=obj.parentNode.parentNode.rowIndex;
	var fullInvAmt=0;
	var fullDisAmt=0;
	var fullNetAmt=0;
	
	for(var i=1;i<tblDiscountData.rows.length;i++)
	{
		if(tblDiscountData.rows[i].cells[0].childNodes[0].checked==true)
		{
			fullInvAmt=fullInvAmt+parseFloat(tblDiscountData.rows[i].cells[5].childNodes[0].nodeValue);
			fullDisAmt=fullDisAmt+parseFloat(tblDiscountData.rows[i].cells[6].childNodes[0].nodeValue);
			fullNetAmt=fullNetAmt+parseFloat(tblDiscountData.rows[i].cells[7].childNodes[0].nodeValue);
		}
	}
	
	//tblDiscountData.rows[lastRow].cells[1].innerHTML=fullInvAmt;
	//tblDiscountData.rows[lastRow].cells[2].innerHTML=fullDisAmt;
	//tblDiscountData.rows[lastRow].cells[3].innerHTML=fullNetAmt;
	
	document.getElementById('txtTotDiscountAmt').value=AddThousandSeparator(fullDisAmt.toFixed(2));
	document.getElementById('txtTotInvoiceAmt').value=AddThousandSeparator(fullInvAmt.toFixed(2));
	document.getElementById('txtTotNetAmt').value=AddThousandSeparator(fullNetAmt.toFixed(2));
	
	document.getElementById('txtDiscountAmt').value=AddThousandSeparator(fullDisAmt.toFixed(2));
}

function clearGrid()
{
	var tblDiscountData=document.getElementById('tblDiscountData');
	for(var i=tblDiscountData.rows.length-1;i>0;i--)
		tblDiscountData.deleteRow(i);
		
}

function loadSavedData()
{
	clearGrid();
	var refNo=document.getElementById('cboRefNo').value;
	if(refNo=='')
	{
		document.getElementById('txtRefNo').disabled=false;
		document.getElementById('txtRefNo').value='';
		document.getElementById('cboBank').disabled=false;
		document.getElementById('cboBank').value=0;
		document.getElementById('cboBuyer').disabled=false;
		document.getElementById('cboBuyer').value=0;
		document.getElementById('txtDiscountAmt').value=0;
		document.getElementById('txtGrantedAmt').disabled=true;
		document.getElementById('txtGrantedAmt').value=0;
		document.getElementById('txtInterest').disabled=true;
		document.getElementById('txtInterest').value=0;
	}
	else
	{
		document.getElementById('txtRefNo').disabled=true;
		document.getElementById('cboBank').disabled=true;
		document.getElementById('cboBuyer').disabled=true;
		document.getElementById('txtGrantedAmt').disabled=false;
		document.getElementById('txtInterest').disabled=false;
		loadSavedDataToGrid();
	}
}

function loadSavedDataToGrid()
{
	var tblDiscountData=document.getElementById('tblDiscountData');
	var total=0;
	var totalInv = 0;
	var totalDis = 0;
	var refNo=URLEncode(document.getElementById('cboRefNo').value);
	
	
	var url ="Discount-db.php?id=loadSavedDataToGrid";
		url+="&refNo="+refNo;
	
	var xmlhttp_obj	  = $.ajax({url:url,async:false})
	
	var XMLInvoiceNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
	var XMLInvAmount 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvAmount");
	var XMLBankId 	      = xmlhttp_obj.responseXML.getElementsByTagName("BankId");
	var XMLBuyerId  	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerId");
	var XMLGrantedAmt 	  = xmlhttp_obj.responseXML.getElementsByTagName("GrantedAmt");
	var XMLInterest 	  = xmlhttp_obj.responseXML.getElementsByTagName("Interest");
	var XMLInvDate  	  = xmlhttp_obj.responseXML.getElementsByTagName("InvDate");
	var XMLDiscountAmt	  = xmlhttp_obj.responseXML.getElementsByTagName("DiscountAmt");
	var XMLNetAmt		  = xmlhttp_obj.responseXML.getElementsByTagName("NetAmt");
	
	var XMLInvStyle		  = xmlhttp_obj.responseXML.getElementsByTagName("Style");
	var XMLInvPo		  = xmlhttp_obj.responseXML.getElementsByTagName("PoNo");
	
	
	
	document.getElementById('txtRefNo').value=document.getElementById('cboRefNo').value;
	document.getElementById('cboBank').value=XMLBankId[0].childNodes[0].nodeValue;
	document.getElementById('cboBuyer').value=XMLBuyerId[0].childNodes[0].nodeValue;
	document.getElementById('txtGrantedAmt').value=XMLGrantedAmt[0].childNodes[0].nodeValue;
	document.getElementById('txtInterest').value=XMLInterest[0].childNodes[0].nodeValue;
	
	for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
			
			var newRow			 	    = tblDiscountData.insertRow(x+1);
				newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellSelectPl         = tblDiscountData.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfntMid";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" onclick=\"calculateSum(this);\" disabled=\"disabled\" checked=\"checked\"/>";
			
			
			var newCellInvoiceNo        = tblDiscountData.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfntMid";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblDiscountData.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     =  XMLInvDate[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblDiscountData.rows[x+1].insertCell(3);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     =  XMLInvStyle[x].childNodes[0].nodeValue;
			
			var newCellDate           = tblDiscountData.rows[x+1].insertCell(4);
			newCellDate.className     = "normalfntMid";
			newCellDate.align         = "center";
			newCellDate.innerHTML     =  XMLInvPo[x].childNodes[0].nodeValue;
			
			
			var newCellAmount             = tblDiscountData.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLInvAmount[x].childNodes[0].nodeValue;
			
			if(XMLInvAmount[x].childNodes[0].nodeValue!='')
				totalInv=parseFloat(totalInv)+parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			
			var newCellAmount             = tblDiscountData.rows[x+1].insertCell(6);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLDiscountAmt[x].childNodes[0].nodeValue;
			
			if(XMLDiscountAmt[x].childNodes[0].nodeValue!='')
				totalDis=parseFloat(totalDis)+parseFloat(XMLDiscountAmt[x].childNodes[0].nodeValue);
			
			var newCellAmount             = tblDiscountData.rows[x+1].insertCell(7);
			newCellAmount.className       = "normalfntMid2";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLNetAmt[x].childNodes[0].nodeValue;
			
				if(XMLNetAmt[x].childNodes[0].nodeValue!='')
			total=parseFloat(total)+parseFloat(XMLNetAmt[x].childNodes[0].nodeValue);
		}
	document.getElementById('txtDiscountAmt').value=AddThousandSeparator(total.toFixed(2));
	
	document.getElementById('txtTotNetAmt').value=AddThousandSeparator(total.toFixed(2));
	document.getElementById('txtTotDiscountAmt').value=AddThousandSeparator(totalDis.toFixed(2));
	document.getElementById('txtTotInvoiceAmt').value=AddThousandSeparator(totalInv.toFixed(2));
}


function validateData()
{
	var bankId=document.getElementById('cboBank').value;
	var buyerId=document.getElementById('cboBuyer').value;
	var refNo=document.getElementById('txtRefNo').value;
	var selectCount=0;
	var tblDiscountData=document.getElementById('tblDiscountData');
	
	if(tblDiscountData.rows.length>1)
			{
				for(var x=1;x<tblDiscountData.rows.length;x++)
				{
					if((tblDiscountData.rows[x].cells[0].childNodes[0].checked)==true)
					{
						selectCount=1;
						break;
					}
				}
			}

	if(buyerId==0)
		alert("Please Select a Buyer");
	else if(bankId==0)
		alert("Please Select a Bank");
	else if(selectCount==0)
		alert("Please select an Invoice No");
	else
		saveData();
}

function saveData()
{
	var bankId		= document.getElementById('cboBank').value;
	var buyerId		= document.getElementById('cboBuyer').value;
	//var refNo		= URLEncode(document.getElementById('txtRefNo').value);
	var discountAmt = document.getElementById('txtDiscountAmt').value;
	var grantedAmt	= document.getElementById('txtGrantedAmt').value;
	var interest	= document.getElementById('txtInterest').value;
	var cboRefNo=document.getElementById('cboRefNo').value;
	
	var url_ref ="Discount-db.php?id=getRefNo";
	var htmlhttp_obj_ref	  = $.ajax({url:url_ref,async:false});
	var refNo=htmlhttp_obj_ref.responseText;
	
	//alert(htmlhttp_obj_ref.responseText);
	
	var tblDiscountData=document.getElementById('tblDiscountData');
	
	var url ="Discount-db.php?id=saveHeader";
		url+="&bankId="+bankId;
		url+="&buyerId="+buyerId;
		url+="&refNo="+refNo;
		url+="&discountAmt="+discountAmt;
		url+="&grantedAmt="+grantedAmt;
		url+="&interest="+interest;
		url+="&cboRefNo="+cboRefNo;
		
	var htmlhttp_obj	  = $.ajax({url:url,async:false});
	//alert(htmlhttp_obj.responseText);
	
	if(htmlhttp_obj.responseText==1)
	{
		for(var x=1;x<tblDiscountData.rows.length-1;x++)
		{
			if((tblDiscountData.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url1 ="Discount-db.php?id=saveDetail";
					url1+="&refNo="+refNo;
					url1+="&invoiceNo="+tblDiscountData.rows[x].cells[1].childNodes[0].nodeValue;
					url1+="&invoiceAmt="+tblDiscountData.rows[x].cells[5].childNodes[0].nodeValue;
					url1+="&invoiceDate="+tblDiscountData.rows[x].cells[2].childNodes[0].nodeValue;
					url1+="&discountAmt="+tblDiscountData.rows[x].cells[6].childNodes[0].nodeValue;				
					url1+="&netAmt="+tblDiscountData.rows[x].cells[7].childNodes[0].nodeValue;
					url1+="&styleid="+tblDiscountData.rows[x].cells[3].childNodes[0].nodeValue;
					url1+="&bankId="+bankId;
					url1+="&buyerId="+buyerId;
				var htmlhttp_obj1 = $.ajax({url:url1,async:false})
				//alert(htmlhttp_obj1.responseText);
				
			}
		}
		alert("Saved Successfully");
		
		clearForm();
	}
	else
		alert("Saving Failed");
}

function CancelInv()
{
	var cboRefNo=document.getElementById('cboRefNo').value;
	//var discountAmt = document.getElementById('txtDiscountAmt').value;
	var bankId		= document.getElementById('cboBank').value;
	var buyerId		= document.getElementById('cboBuyer').value;
	//var refNo		= URLEncode(document.getElementById('txtRefNo').value);
	var discountAmt = document.getElementById('txtDiscountAmt').value;
	var grantedAmt	= document.getElementById('txtGrantedAmt').value;
	var interest	= document.getElementById('txtInterest').value;
	var txtDate	= document.getElementById('txtDate').value;
	//alert(txtDate);
			
	
	var tblDiscountData=document.getElementById('tblDiscountData');
	if(cboRefNo!=0)
	{
		//alert("check cbo");
	for(var x=0;x<tblDiscountData.rows.length;x++)
		{
			if((tblDiscountData.rows[x].cells[0].childNodes[0].checked)==true)
			{	
				
				var url1 ="Discount-db.php?id=CancelInv";
				
					//url1+="&serialNo="+serialNo;
					//url1+="&invoiceNo="+tblDiscountData.rows[x].cells[1].childNodes[0].nodeValue;
					url1+="&invoiceAmt="+tblDiscountData.rows[x].cells[5].childNodes[0].nodeValue;
					url1+="&invoiceDate="+tblDiscountData.rows[x].cells[2].childNodes[0].nodeValue;
					url1+="&invoiceDiscount="+tblDiscountData.rows[x].cells[4].childNodes[0].nodeValue;
					//url1+="&invoiceNetAmt="+tblDiscountData.rows[x].cells[5].childNodes[0].nodeValue;
					url1+="&netAmt="+tblDiscountData.rows[x].cells[7].childNodes[0].nodeValue;
					url1+="&styleid="+tblDiscountData.rows[x].cells[3].childNodes[0].nodeValue;
					url1+="&bankId="+bankId;
					url1+="&buyerId="+buyerId;
					url1+="&txtDate="+txtDate;
					//url1+="&date="+date;
				
				url1+="&invoiceNo="+tblDiscountData.rows[x].cells[1].childNodes[0].nodeValue;
				url1+="&cboRefNo="+cboRefNo;
				

				var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
				//alert(htmlhttp_obj1.responseText);
		
				
			}
		}
		alert("Successfully Deleted !");
	}
	else
		alert("Please Select a Reaference No");
		
		location.reload();
}

function clearForm()
{
	window.location.reload();
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


function deleteFromMS()
{
	var bankId		= document.getElementById('cboBank').value;
	var buyerId		= document.getElementById('cboBuyer').value;
	//var refNo		= URLEncode(document.getElementById('txtRefNo').value);
	var discountAmt = document.getElementById('txtDiscountAmt').value;
	var grantedAmt	= document.getElementById('txtGrantedAmt').value;
	var interest	= document.getElementById('txtInterest').value;
	var cboRefNo=document.getElementById('cboRefNo').value;
	
	var tblDiscountData=document.getElementById('tblDiscountData');
	if(cboRefNo!=0)
	{
	for(var x=0;x<tblDiscountData.rows.length;x++)
		{
			if((tblDiscountData.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var url1 ="Discount-db.php?id=deleteFromMs";
					url1+="&serialNo="+serialNo;
					url1+="&invoiceNo="+tblDiscountData.rows[x].cells[1].childNodes[0].nodeValue;
					url1+="&invoiceAmt="+tblDiscountData.rows[x].cells[3].childNodes[0].nodeValue;
					url1+="&invoiceDate="+tblDiscountData.rows[x].cells[2].childNodes[0].nodeValue;
					url1+="&invoiceDiscount="+tblDiscountData.rows[x].cells[4].childNodes[0].nodeValue;
					url1+="&invoiceNetAmt="+tblDiscountData.rows[x].cells[5].childNodes[0].nodeValue;
					url1+="&bankId="+bankId;
					url1+="&buyerId="+buyerId;
					url1+="&date="+date;
				var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
				//alert(htmlhttp_obj1.responseText);
			}
		}
	}
	else
		alert("Please Select a Reaference No");
}
