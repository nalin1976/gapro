// JavaScript Document



function printCheckList()
{
	var abc = new Array();
	var tblBankLetter=document.getElementById('tblBankLetter');
	for(var x=1;x<tblBankLetter.rows.length;x++)
		{
			if((tblBankLetter.rows[x].cells[0].childNodes[0].checked)==true)
			{
				var newCellInvoiceNo= tblBankLetter.rows[x].cells[1].childNodes[0].nodeValue;
				var date= tblBankLetter.rows[x].cells[2].childNodes[0].nodeValue;
				//alert(newCellInvoiceNo);
				abc.push(newCellInvoiceNo);
			}
		}
	
	
	var cboBuyer=document.getElementById('cboBuyer').value;
	//alert(cboBuyer);
	var tblCheckList=document.getElementById('tblCheckList');
	//alert(tblCheckList);
	
	var name_arr = [];
	var org_arr1 = [];
	var copy_arr1= [];
	var org_arr2 = [];
	var copy_arr2= [];
	var abc123 = "";
	for(var x=1;x<tblCheckList.rows.length;x++)
		{
				abc123 += '&name_arr[]='+URLEncode(tblCheckList.rows[x].cells[0].childNodes[0].nodeValue)+ '&org_arr1[]='+URLEncode(tblCheckList.rows[x].cells[1].childNodes[0].value)+ '&copy_arr1[]='+URLEncode(tblCheckList.rows[x].cells[2].childNodes[0].value)+ '&org_arr2[]='+URLEncode(tblCheckList.rows[x].cells[3].childNodes[0].value)+ '&copy_arr2[]='+URLEncode(tblCheckList.rows[x].cells[4].childNodes[0].value);
	
		}
		//alert(abc123);
		newwindow=window.open('../../Exports/Preshipmentdocs/Commercialinvoice/buyerwiseinvoices/documentchecklist.php?cboBuyer='+cboBuyer+ '&newCellInvoiceNo='+newCellInvoiceNo+ '&date='+date+ '&abc='+abc+abc123);
	if (window.focus) {newwindow.focus();}
		
	
}


/*function printCheckList()
{
	
	var cboBuyer=document.getElementById('cboBuyer').value;
	//alert(cboBuyer);
	var tblCheckList=document.getElementById('tblCheckList');
	//alert(tblCheckList);
	
	var name_arr = [];
	var org_arr1 = [];
	var copy_arr1= [];
	var org_arr2 = [];
	var copy_arr2= [];
	var abc123 = "";
	for(var x=1;x<tblCheckList.rows.length;x++)
		{
				abc123 += '&name_arr[]='+URLEncode(tblCheckList.rows[x].cells[0].childNodes[0].nodeValue)+ '&org_arr1[]='+URLEncode(tblCheckList.rows[x].cells[1].childNodes[0].value)+ '&copy_arr1[]='+URLEncode(tblCheckList.rows[x].cells[2].childNodes[0].value)+ '&org_arr2[]='+URLEncode(tblCheckList.rows[x].cells[3].childNodes[0].value)+ '&copy_arr2[]='+URLEncode(tblCheckList.rows[x].cells[4].childNodes[0].value);
	
		}
		//alert(abc123);
		newwindow=window.open('../../Exports/Preshipmentdocs/Commercialinvoice/buyerwiseinvoices/documentchecklist.php?cboBuyer='+cboBuyer+abc123);
	if (window.focus) {newwindow.focus();}
		
	
}*/
function clearForm()
{
	location.reload();
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
function validateDataForLoadGrid()
{
	
		if(document.getElementById('cboBuyer').value==0)
		{
			alert("Please Select a Buyer");
		}
		else
		{
			showPleaseWait();
			clearGrid();
			loadData();
			hidePleaseWait();
		}
	
}

function loadHeaderDetails()
{
	clearGrid();
	var tblBankLetter=document.getElementById('tblBankLetter');
	var serialNo=document.getElementById('cboSerialNo').value;
	document.getElementById('cboBuyer').value=0;
	
	var date = new Date();
	var d  = date.getDate();
	var day = (d < 10) ? '0' + d : d;
	var m = date.getMonth() + 1;
	var month = (m < 10) ? '0' + m : m;
	var yyyy = date.getFullYear();
	
	//document.getElementById('txtDate').value=day+"/"+month+"/"+yyyy;
	
	if(serialNo!=0)
	{
		//alert("xx");
		var url	="bankLetter-db.php?id=loadHeaderDetails";
			url+="&serialNo="+serialNo;
		var xmlhttp_obj	  = $.ajax({url:url,async:false});	
		
		var XMLBuyerCode 	  = xmlhttp_obj.responseXML.getElementsByTagName("BuyerCode");
		//var XMLFromDate 	  = xmlhttp_obj.responseXML.getElementsByTagName("FromDate");
		var XMLDate      	  = xmlhttp_obj.responseXML.getElementsByTagName("Date");
		var XMLInvNo 	      = xmlhttp_obj.responseXML.getElementsByTagName("InvNo");
		var XMLAmount 	      = xmlhttp_obj.responseXML.getElementsByTagName("Amount");
		var XMLInvDate        = xmlhttp_obj.responseXML.getElementsByTagName("InvDate");
		var XMLInvQty		  = xmlhttp_obj.responseXML.getElementsByTagName("InvQty");
		var XMLInvPoNo		  = xmlhttp_obj.responseXML.getElementsByTagName("InvPoNo");
		
		var totQty			  = 0;
		var totAmt			  = 0;
		

		
		//document.getElementById('cboBuyer').value=XMLBuyerCode[0].childNodes[0].nodeValue;
		//document.getElementById('txtDateFrom').value=XMLFromDate[0].childNodes[0].nodeValue;
		//document.getElementById('txtDate').value=XMLDate[0].childNodes[0].nodeValue;
		
		for(var x=0;x<XMLInvNo.length;x++)
		{	
			
			var newRow			 	    = tblBankLetter.insertRow(x+1);
			newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellSelectPl         = tblBankLetter.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfnt_size10";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML   = "<input type=\"checkbox\" align=\"center\" checked=\"checked\" disabled=\"disabled\" />";
			
			
			var newCellInvoiceNo        = tblBankLetter.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfnt_size10";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvNo[x].childNodes[0].nodeValue;
			
			
			var newCellDate           = tblBankLetter.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfnt_size10";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLDate[x].childNodes[0].nodeValue;
			
			var newPo             = tblBankLetter.rows[x+1].insertCell(3);
			newPo.className       = "normalfnt_size10";
			newPo.align           = "right";
			newPo.innerHTML       = XMLInvPoNo[x].childNodes[0].nodeValue;
			
			var newQty             = tblBankLetter.rows[x+1].insertCell(4);
			newQty.className       = "normalfnt_size10";
			newQty.align           = "right";
			newQty.innerHTML       = XMLInvQty[x].childNodes[0].nodeValue;
			

			totQty = totQty + parseFloat(XMLInvQty[x].childNodes[0].nodeValue);
			
			var newCellAmount             = tblBankLetter.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfnt_size10";
			newCellAmount.align           = "right";
			newCellAmount.innerHTML       = XMLAmount[x].childNodes[0].nodeValue;
			
			totAmt	= totAmt + parseFloat(XMLAmount[x].childNodes[0].nodeValue);
		

		}
		
		document.getElementById('txtInvoiceAmount').value=AddThousandSeparator(totAmt.toFixed(2));
		document.getElementById('txtInvoiceQty').value=AddThousandSeparator(totQty.toFixed(2));
	
	}
	
}
function clearGrids()
{
//alert("clearGrids");	
var tblChkList=document.getElementById('tblCheckList');
	for(var i=tblChkList.rows.length-1;i>0;i--)
		tblChkList.deleteRow(i);	
}


function loadInvFormats(style)
{
	var url = 'documentchecklist-db.php?id=loadInvFormats&cboBuyer='+URLEncode(style.trim());
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboInvoiceFormat').innerHTML  = htmlobj.responseText;
	
	
	//var cboBuyer =$('#cboBuyer').val();
//alert(cboBuyer);

//var url ="documentchecklist-db.php?id=loadInvFormats&cboBuyer=" + cboBuyer;
//var xml_http_obj = $.ajax

/*({
url:url ,success: function(obj)
{
$(obj).find("data").each(function()
{


$('#cboInvoiceFormat').val($(this).find("invFor").text());


});
}
});*/
}


function loadChkDataToGrid()
{
	
	var tblCheckList=document.getElementById('tblCheckList');
	var cboInvoiceFormat = document.getElementById('cboInvoiceFormat').value;
	//alert(cboInvoiceFormat);
	var url	="documentchecklist-db.php?id=loadChkDataToGrid";
			url+="&cboInvoiceFormat="+cboInvoiceFormat;
			
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(xmlhttp_obj.responseText);onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"
		
		var XMLdocId 	  = xmlhttp_obj.responseXML.getElementsByTagName("docId");
		
		for(var x=0;x<XMLdocId.length;x++)
		{
			var newRow			 	    = tblCheckList.insertRow(x+1);
			newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCelldocId        = tblCheckList.rows[x+1].insertCell(0);
			newCelldocId.className  = "normalfnt_size10";
			newCelldocId.align      = "center";
			newCelldocId.innerHTML  = XMLdocId[x].childNodes[0].nodeValue;
			//alert(newCelldocId );
			
			var rowCell = tblCheckList.rows[x+1].insertCell(1);
			rowCell.className ="normalfnt_size10";
			rowCell.innerHTML ="<input name=\"txtAmount\" type=\"text\" Value=\" \" class=\"txtbox\" id=\"txtAmount\"  size=\"8\"maxlength=\"20\" height=\"10\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"  style=\"text-align:right\" />";
			
			var rowCell1 = tblCheckList.rows[x+1].insertCell(2);
			rowCell1.className ="normalfnt_size10";
			rowCell1.innerHTML ="<input name=\"txtAmount\" type=\"text\" Value=\" \" class=\"txtbox\" id=\"txtAmount\"  size=\"8\"maxlength=\"20\" height=\"10\"  onkeypress=\"return CheckforValidDecimal(this.value,2,event)\" style=\"text-align:right\" />";
			
			var rowCell2 = tblCheckList.rows[x+1].insertCell(3);
			rowCell2.className ="normalfnt_size10";
			rowCell2.innerHTML ="<input name=\"txtAmount\" type=\"text\" Value=\" \" class=\"txtbox\" id=\"txtAmount\"  size=\"8\"maxlength=\"20\" height=\"10\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"  style=\"text-align:right\" />";
			
			var rowCell3 = tblCheckList.rows[x+1].insertCell(4);
			rowCell3.className ="normalfnt_size10";
			rowCell3.innerHTML ="<input name=\"txtAmount\" type=\"text\" Value=\" \" class=\"txtbox\" id=\"txtAmount\"  size=\"8\"maxlength=\"20\" height=\"10\" onkeypress=\"return CheckforValidDecimal(this.value,2,event)\"  style=\"text-align:right\" />";
		}
		
}


function loadData()
{
		
		var tblBankLetter=document.getElementById('tblBankLetter');
		var mainBuyerId = document.getElementById('cboBuyer').value;
		var total=0;
		var totSumQty= 0;
		var totSumAmt= 0;

	
		var url	="documentchecklist-db.php?id=loadGrid";
			url+="&mainBuyerId="+mainBuyerId;
			
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(xmlhttp_obj.responseText);
			
		var XMLInvoiceNo 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvoiceNo");
		var XMLInvAmount 	  = xmlhttp_obj.responseXML.getElementsByTagName("InvAmount");
		var XMLInvDate  	  = xmlhttp_obj.responseXML.getElementsByTagName("InvDate");
		var XMLInvQty		  = xmlhttp_obj.responseXML.getElementsByTagName("InvQty");
		var XMLInvPoNo		  = xmlhttp_obj.responseXML.getElementsByTagName("InvPoNo");
		
		for(var x=0;x<XMLInvoiceNo.length;x++)
		{	
		//alert("der");
			
			var newRow			 	    = tblBankLetter.insertRow(x+1);
			newRow.className			= 'bcgcolor-tblrowWhite';
			
			var newCellSelectPl         = tblBankLetter.rows[x+1].insertCell(0);
			newCellSelectPl.className   = "normalfnt_size10";	
			newCellSelectPl.width	    = "4%";
			newCellSelectPl.align 	    = "center";
			newCellSelectPl.innerHTML  = "<input type=\"checkbox\" align=\"center\" onclick=\"calculateSum(this);\"/>";
			
			
			var newCellInvoiceNo        = tblBankLetter.rows[x+1].insertCell(1);
			newCellInvoiceNo.className  = "normalfnt_size10";
			newCellInvoiceNo.align      = "center";
			newCellInvoiceNo.innerHTML  = XMLInvoiceNo[x].childNodes[0].nodeValue;
			//alert(newCellInvoiceNo );
			
			var newCellDate           = tblBankLetter.rows[x+1].insertCell(2);
			newCellDate.className     = "normalfnt_size10";
			newCellDate.align         = "center";
			newCellDate.innerHTML     = XMLInvDate[x].childNodes[0].nodeValue;
			
			var newPo             = tblBankLetter.rows[x+1].insertCell(3);
			newPo.className       = "normalfnt_size10";
			newPo.align           = "center";
			newPo.innerHTML       = XMLInvPoNo[x].childNodes[0].nodeValue;
			//alert(XMLInvPoNo );
			
			var newQty             = tblBankLetter.rows[x+1].insertCell(4);
			newQty.className       = "normalfnt_size10";
			newQty.align           = "center";
			newQty.innerHTML       = XMLInvQty[x].childNodes[0].nodeValue;
			
			var newCellAmount             = tblBankLetter.rows[x+1].insertCell(5);
			newCellAmount.className       = "normalfnt_size10";
			newCellAmount.align           = "center";
			newCellAmount.innerHTML       = XMLInvAmount[x].childNodes[0].nodeValue;
			
			
						
			totSumQty = totSumQty + parseFloat(XMLInvQty[x].childNodes[0].nodeValue);
			totSumAmt = totSumAmt + parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			//alert(totSumQty);
			//if(XMLInvAmount[x].childNodes[0].nodeValue!='')
			//total=parseFloat(total)+parseFloat(XMLInvAmount[x].childNodes[0].nodeValue);
			
		}
		document.getElementById('txTotInvoiceQty').value=AddThousandSeparator(totSumQty.toFixed(2));
		document.getElementById('txTotInvoiceAmount').value=AddThousandSeparator(totSumAmt.toFixed(2));
			//document.getElementById('tblBankLetter').value=total;	
}

function clearGrid()
{
	//alert("clearGrid");
	var tblBankLetter=document.getElementById('tblBankLetter');
	for(var i=tblBankLetter.rows.length-1;i>0;i--)
		tblBankLetter.deleteRow(i);	
}

function validateData()
{
	//alert("wer");
	var selectCount=0;
	var tblBankLetter=document.getElementById('tblBankLetter');
	
	if(document.getElementById('cboSerialNo').value==0)
	{
		if(tblBankLetter.rows.length>1)
				{
					for(var x=1;x<tblBankLetter.rows.length;x++)
					{
						if((tblBankLetter.rows[x].cells[0].childNodes[0].checked)==true)
						{
							selectCount=1;
							break;
						}
					}
				}
		if(selectCount==0)
			alert("Select a Bank No");
		else if(document.getElementById('cboBuyer').value==0)
			alert("Please Select a Buyer");
		
		else
			saveData();
	}
}

function saveData()
{
	//alert("lglg");
	var tblBankLetter=document.getElementById('tblBankLetter');
	var serialNo  = document.getElementById('cboSerialNo').value;
	var buyerCode = document.getElementById('cboBuyer').value;
	//var newDate  = document.getElementById('txtDate').value;
	
	/*if(serialNo!=0)
	{
		var url1="bankLetter-db.php?id=deleteSavedSerials";
			url1+="&serialNo="+serialNo;
		var htmlhttp_obj1	  = $.ajax({url:url1,async:false});
	}*/
		var url	="bankLetter-db.php?id=saveHeader";
			url+="&serialNo="+serialNo;
			url+="&buyerCode="+buyerCode;
			//url+="&newDate="+newDate;
			
		var htmlhttp_obj	  = $.ajax({url:url,async:false});
		//alert(htmlhttp_obj.responseText);
		if(htmlhttp_obj.responseText!=0)
		{
			for(var x=1;x<tblBankLetter.rows.length;x++)
			{
				if((tblBankLetter.rows[x].cells[0].childNodes[0].checked)==true)
				{
					var url2="bankLetter-db.php?id=saveDetail";
						url2+="&serialNo="+htmlhttp_obj.responseText;
						url2+="&invoiceNo="+tblBankLetter.rows[x].cells[1].childNodes[0].nodeValue;
						//url2+="&newDate="+newDate;
					var htmlhttp_obj2	  = $.ajax({url:url2,async:false})
				}
			}
			alert("Saved Successfully");
			clearForm();
		}
		else
			alert("Saving Failed");
}

function calculateSum(obj)
{
	var tblBankLetter=document.getElementById('tblBankLetter');
	var lastRow = tblBankLetter.rows.length;
	var rowNumber=obj.parentNode.parentNode.rowIndex;
	var fullInvAmt=0;
	var fullInvQty=0;
	//var fullNetAmt=0;
	/*if(obj.checked==true)
	{
		document.getElementById('txtInvoiceQty').value=parseFloat(document.getElementById('txtInvoiceQty').value)+parseFloat(tblBankLetter.rows[rowNumber].cells[3].innerHTML);
		
		
	}
	else
	{
		document.getElementById('txtInvoiceAmount').value=parseFloat(document.getElementById('txtInvoiceAmount').value)-parseFloat(tblBankLetter.rows[rowNumber].cells[3].innerHTML);
	}*/
	for(var i=1;i<tblBankLetter.rows.length;i++)
	{
		if(tblBankLetter.rows[i].cells[0].childNodes[0].checked==true)
		{
			fullInvAmt=fullInvAmt+parseFloat(tblBankLetter.rows[i].cells[5].childNodes[0].nodeValue);
			fullInvQty=fullInvQty+parseFloat(tblBankLetter.rows[i].cells[4].childNodes[0].nodeValue);
			//fullNetAmt=fullNetAmt+parseFloat(tblBankLetter.rows[i].cells[7].childNodes[0].nodeValue);
		}
	}
	document.getElementById('txtInvoiceAmount').value=AddThousandSeparator(fullInvAmt.toFixed(2));
	document.getElementById('txtInvoiceQty').value=AddThousandSeparator(fullInvQty.toFixed(2));
	//tblBankLetter.rows[lastRow].cells[1].innerHTML=fullInvAmt;
	//tblBankLetter.rows[lastRow].cells[2].innerHTML=fullInvQty;
	//tblBankLetter.rows[lastRow].cells[3].innerHTML=fullNetAmt;
	//document.getElementById('txtDiscountAmt').value=fullNetAmt;
	//document.getElementById('txtDiscountAmt').value=fullNetAmt;
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
			//var discountAmt = document.getElementById('txtDiscountAmt').value;
			//alert(cboSerialNo)
	var tblBankLetter=document.getElementById('tblBankLetter');
	if(cboSerialNo!=0)
	{
		//alert("check cbo");
	for(var x=0;x<tblBankLetter.rows.length;x++)
		{
			if((tblBankLetter.rows[x].cells[0].childNodes[0].checked)==true)
			{	
				
				var url1 ="bankLetter-db.php?id=CancelInv";
				url1+="&invoiceNo="+tblBankLetter.rows[x].cells[1].childNodes[0].nodeValue;
				url1+="&cboSerialNo="+cboSerialNo;
				

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

