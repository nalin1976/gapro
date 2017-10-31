//updated from roshan 2009-10-12
var th = ['','thousand and','million', 'billion','trillion'];
var amtInWords="";
var dg = ['zero','one','two','three','four', 'five','six','seven','eight','nine']; var tn = ['ten','eleven','twelve','thirteen', 'fourteen','fifteen','sixteen', 'seventeen','eighteen','nineteen']; var tw = ['twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

var strPaymentType=""

function pageRefresh()
{
	document.getElementById("frmPayment").submit();
}
function pageRefreshSearch()
{
	document.getElementById("frmPayment_search").submit();
}
function CreateXMLHttpForBank() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpBank = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpBank = new XMLHttpRequest();
    }
}

function CreateXMLHttpForTotal()
{
    if (window.ActiveXObject) 
    {
        xmlHttpTotal = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpTotal = new XMLHttpRequest();
    }
}

function CreateXMLHttpForPVoucher() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPV = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPV = new XMLHttpRequest();
    }
}

function CreateXMLHttpForPVoucherPrint() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPVPrint = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPVPrint = new XMLHttpRequest();
    }
}


function CreateXMLHttpForPVoucherDetails() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPVDetails = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPVDetails = new XMLHttpRequest();
    }
}

function CreateXMLHttpForPayVoucherNo() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPVNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPVNo = new XMLHttpRequest();
    }
}



function CreateXMLHttpForCurrency() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpCurrency = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpCurrency = new XMLHttpRequest();
    }
}

function CreateXMLHttpForSchds() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSch = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSch = new XMLHttpRequest();
    }
}

function CreateXMLHttpForSupplier() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpSup = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpSup = new XMLHttpRequest();
    }
}


function CreateXMLHttpForSaveChequeHeader() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpCheque = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpCheque = new XMLHttpRequest();
    }
}

function CreateXMLHttpForSaveChequeDetails() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpChqDetails = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpChqDetails = new XMLHttpRequest();
    }
}

function CreateXMLHttpChequeDetails() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpChqDetails = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpChqDetails = new XMLHttpRequest();
    }
}

function CreateXMLHttpChequeRefTask() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpChqRefNo = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpChqRefNo = new XMLHttpRequest();
    }
}

function CreateXMLHttpPayMode() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpPayMode = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpPayMode = new XMLHttpRequest();
    }
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

function getBank()
{
	var batchId=document.getElementById("cboBatchNo").value;
	CreateXMLHttpForBank();
	xmlHttpBank.onreadystatechange = HandleSupInvoice;
    xmlHttpBank.open("GET", 'paymentVoucherDB.php?DBOprType=getBank&batchID='+ batchId , true);
	xmlHttpBank.send(null); 
	
}

function HandleSupInvoice()
{	
	if(xmlHttpBank.readyState == 4) 
    {
	   if(xmlHttpBank.status == 200) 
        {  
			var XMLbankID = xmlHttpBank.responseXML.getElementsByTagName("bankID");
			var XMLbank = xmlHttpBank.responseXML.getElementsByTagName("bankName");
			var bankID = XMLbankID[0].childNodes[0].nodeValue;
			var bank = XMLbank[0].childNodes[0].nodeValue;

			document.getElementById("txtBank").value=bankID;
			//document.getElementById("txtBank").value=bank;
		}
	}
}

function clearPayementVoucherIF()
{
		document.getElementById("cboSupliers").value=0;
		document.getElementById("cboBatchNo").value=0;
		document.getElementById("txtBankCode").value="";
		document.getElementById("txtBank").value="";
		document.getElementById("txtDescription").value="Being Payment of ";
		document.getElementById("txtAccPacID").value="";
		document.getElementById("txtChequeNo").value="";
		document.getElementById("cbosearch6").value=0;
		document.getElementById("txtAmount").value="CLER";
		document.getElementById("cboCurrency").value=0;
		document.getElementById("txtTaxCode").value="";
		document.getElementById("txtTotalAmont").value="";
		
		clearSelectControl("cboSchedual");
		
		var strtable="<table width=\"930\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoice\">"+
					"<tr class='mainHeading4'>"+
					"<td width=\"5%\" height=\"20\" >#</td>"+
					"<td width=\"14%\" bgcolor=\"\" >Invoice No</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Total Amount</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Paid Amount</td>"+
					"<td width=\"17%\" bgcolor=\"\" >Balance</td>"+
					"<td width=\"18%\" bgcolor=\"\" >Pay Amount</td>"+
					"<td width=\"15%\" bgcolor=\"\" >Advance</td>"+
					"<td width=\"15%\" bgcolor=\"\" >Currency</td>"+
					"</tr>"+
					"</table>"
		document.getElementById("divInvsList").innerHTML=strtable;
		//getAdvPaymentNo(1)
		document.getElementById("cboSupliers").focus();
}

function getScheduals()
{
	var supID=document.getElementById("cboSupliers").value;
	if(supID==0){return;}

/*		var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';*/
		
		var type = document.getElementById("cboPaymentType").value;
		
	
	CreateXMLHttpForSupplier();
	xmlHttpSup.onreadystatechange = HandleSupData;
    xmlHttpSup.open("GET", 'paymentVoucherDB.php?DBOprType=getSupData&strPaymentType=' + type + '&supID=' + supID, true);
	xmlHttpSup.send(null); 
	
	CreateXMLHttpForSchds();
	xmlHttpSch.onreadystatechange = HandleScheduals;
    xmlHttpSch.open("GET", 'paymentVoucherDB.php?DBOprType=getScheduals&strPaymentType=' + type + '&supID=' + supID, true);
	xmlHttpSch.send(null); 

}
function getDets(){
	//loadInvoiceSchedual();
	var supID=document.getElementById("cboSupliers").value;
	var schdNo=document.getElementById("cboSchedual").value;
	
	/*var type = '';

	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';
	*/
	var type = document.getElementById("cboPaymentType").value;
			
	var path='paymentVoucherDB.php?DBOprType=getInvoiceSchedual&strPaymentType=' + type + '&schdNo=' + schdNo + '&supid=' + supID;
	htmlobj=$.ajax({url:path,async:false});

	
	var XMLInvNo = htmlobj.responseXML.getElementsByTagName("invNo");
	var XMLAmount = htmlobj.responseXML.getElementsByTagName("amount");
	var XMLPaidAmt = htmlobj.responseXML.getElementsByTagName("paidAmt");
	var XMLadvPaidAmt = htmlobj.responseXML.getElementsByTagName("advpaidAmt");
	

	var strIvnsTable="<table width=\"930\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoice\">"+
					"<tr class='mainHeading4'>"+
					"<td width=\"5%\" height=\"20\" >#</td>"+
					"<td width=\"14%\" bgcolor=\"\" >Invoice No</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Total Amount</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Paid Amount</td>"+
					"<td width=\"17%\" bgcolor=\"\" >Balance</td>"+
					"<td width=\"18%\" bgcolor=\"\" >Pay Amount</td>"+
					"<td width=\"15%\" bgcolor=\"\" >Advance</td>"+
					/*"<td width=\"15%\" bgcolor=\"\" >Currency</td>"+*/
					"</tr>"
					
	
	if(XMLInvNo.length==0)
	{
		var xname=document.getElementById("cboSchedual");
		//var sss=xname.options[document.getElementById("cboSchedual").selectedIndex].text;
		//alert("There is no any Invoice with " + sss);
		strIvnsTable+="</table>"
		document.getElementById("divInvsList").innerHTML=strIvnsTable;
		return;
		
	}
	
	for ( var loop = 0; loop < XMLInvNo.length; loop ++)
	 {
		var invNo = XMLInvNo[loop].childNodes[0].nodeValue;
		var amount = XMLAmount[loop].childNodes[0].nodeValue;
			amount = new Number(amount).toFixed(4);
		var paidAmount = XMLPaidAmt[loop].childNodes[0].nodeValue;
			paidAmount = new Number(paidAmount).toFixed(4);
		var advPaidAmt = XMLadvPaidAmt[loop].childNodes[0].nodeValue;
			advPaidAmt = new Number(advPaidAmt).toFixed(4);
		var balance = parseFloat(amount)- (parseFloat(paidAmount)+parseFloat(advPaidAmt));
			balance = new Number(balance).toFixed(4);
			
			var cls;
			(loop%2==1)?cls='grid_raw':cls='grid_raw2';
		strIvnsTable+="<tr class=\""+cls+"\">"+
						"<td class=\""+cls+"\"><input type=\"checkbox\" onmouseover=\"highlight(this.parentNode)\" name=\"checkbox\" id=\"checkbox\"  checked=\"checked\"   onclick=\"calculetTheTotalAmount()\"/></td>"+
						"<td class=\""+cls+"\"><div align=\"center\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + invNo + "</div></td>"+
						"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + amount + "</td>"+
						"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + paidAmount + "</td>"+
						
						"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + balance + "</td>"+
						"<td class=\""+cls+"\"><input name=\"txtPayAmt\" type=\"text\" id=\"txtPayAmt\" class=\"txtbox\" style=\"text-align:right\" value=\"" + balance  +  "\"  onkeyup=\"checkPayAmount(this)\" onmouseover=\"highlight(this.parentNode)\" onfocus=\"setSelect(this)\" /></td>"+
						
						"<td class=\""+cls+"\" style=\"text-align:right;\">" + advPaidAmt + "</td>"+
						//"<td class=\"normalfntRite\">" +  + "</td>"+
						//"<td colspan=\"2\" class=\"normalfntRite\">" +  + "</td>"+
					  "</tr>" 

	 }
	  strIvnsTable+="</table>"
	  
	 document.getElementById("divInvsList").innerHTML=strIvnsTable;
	 calculetTheTotalAmount();
	 //======
}

function HandleScheduals()
{	
	if(xmlHttpSch.readyState == 4) 
    {
	   if(xmlHttpSch.status == 200)
        {  
			var XMLSchNo = xmlHttpSch.responseXML.getElementsByTagName("schNo");
			
			
			clearSelectControl("cboSchedual");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			
			document.getElementById("cboSchedual").options.add(optFirst);
			
			if(XMLSchNo.length==0)
			{
				var supname=document.getElementById("cboSupliers");
				//var sss=supname.options[document.getElementById("cboSupliers").selectedIndex].text;
				//alert("There is no any Schedual for " + sss);	
				
				var strIvnsTable="<table width=\"930\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoice\">"+
					"<tr class='mainHeading4'>"+
					"<td width=\"5%\" height=\"20\" >#</td>"+
					"<td width=\"14%\" bgcolor=\"\" >Invoice No</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Total Amount</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Paid Amount</td>"+
					"<td width=\"17%\" bgcolor=\"\" >Balance</td>"+
					"<td width=\"18%\" bgcolor=\"\" >Pay Amount</td>"+
					"<td width=\"15%\" bgcolor=\"\" >Advance</td>"+
					"<td width=\"15%\" bgcolor=\"\" >Currency</td>"+
					"</tr>"+
					"</table>";
				document.getElementById("divInvsList").innerHTML=	strIvnsTable	
				document.getElementById("txtTotalAmont").value=	0;
				
				
				return;
			}
			
			for ( var loop = 0; loop < XMLSchNo.length; loop ++)
			 {
				var SchNo = XMLSchNo[loop].childNodes[0].nodeValue;
						
				var optSchNo = document.createElement("option");
				optSchNo.text =SchNo ;
				optSchNo.value = SchNo;
				
				document.getElementById("cboSchedual").options.add(optSchNo);
			 }
			 document.getElementById("cboSchedual").value=0;
		}
	}
}

function HandleSupData()
{	
	var accPacID="";
	document.getElementById("txtAccPacID").value="";
	if(xmlHttpSup.readyState == 4) 
    {
	   if(xmlHttpSup.status == 200) 
       {  
			var XMLaccPacID = xmlHttpSup.responseXML.getElementsByTagName("accPacID");
			if(XMLaccPacID.length!=0)
			{
				accPacID = XMLaccPacID[0].childNodes[0].nodeValue;
				document.getElementById("txtAccPacID").value=accPacID;
			}
		}
	}
}

function modeSet()
{	
	var row=document.getElementById("tblMain").getElementsByTagName("TR");
	var cell=row[0].getElementsByTagName("TD"); 
	
	var mode=parseInt(document.getElementById("cboPaymentMode").value)

	CreateXMLHttpPayMode();
	xmlHttpPayMode.onreadystatechange = HandlePayees;

	switch(mode)
	{
		case 1:
			cell[1].innerHTML="Supplier"
			xmlHttpPayMode.open("GET", 'paymentVoucherDB.php?DBOprType=findPayees&payeeCat=S', true);
			xmlHttpPayMode.send(null); 
			break;
		case 2:
			cell[1].innerHTML="Payee"
			xmlHttpPayMode.open("GET", 'paymentVoucherDB.php?DBOprType=findPayees&payeeCat=P', true);
			xmlHttpPayMode.send(null); 
			break;
		case 3:
			cell[1].innerHTML="Supplier"
			xmlHttpPayMode.open("GET", 'paymentVoucherDB.php?DBOprType=findPayees&payeeCat=S', true);	
			xmlHttpPayMode.send(null); 
			break;
	}
}

function HandlePayees()
{	
	if(xmlHttpPayMode.readyState == 4) 
    {
	   if(xmlHttpPayMode.status == 200) 
        {  
			var XMLPayeeID = xmlHttpPayMode.responseXML.getElementsByTagName("PayeeID");
			var XMLPayee = xmlHttpPayMode.responseXML.getElementsByTagName("Payee");
			
			clearSelectControl("cboSuppliers");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			document.getElementById("cboSuppliers").options.add(optFirst);
				
			for ( var loop = 0; loop < XMLPayeeID.length; loop ++)
			 {
				var PayeeID = XMLPayeeID[loop].childNodes[0].nodeValue;
				var Payee = XMLPayee[loop].childNodes[0].nodeValue;
				
				var optPayee = document.createElement("option");
				optPayee.text =Payee ;
				optPayee.value =PayeeID ;
				document.getElementById("cboSuppliers").options.add(optPayee);
			 }
			 document.getElementById("cboSuppliers").value=0;
			 document.getElementById("txtPayee").value="";
		}
	}
}



function loadCurrencyType()
{
	CreateXMLHttpForCurrency();
	xmlHttpCurrency.onreadystatechange = HandleCurrency;
    xmlHttpCurrency.open("GET", 'advancepaymentDB.php?DBOprType=getTypeOfCurrency', true);
	xmlHttpCurrency.send(null); 
}

function HandleCurrency()
{	
	if(xmlHttpCurrency.readyState == 4) 
    {
	   if(xmlHttpCurrency.status == 200) 
        {  
			var XMLCurrType = xmlHttpCurrency.responseXML.getElementsByTagName("currType");
			var XMLCurrRate = xmlHttpCurrency.responseXML.getElementsByTagName("currRate");
			
			clearSelectControl("cboCurrency");
			
			var optFirst = document.createElement("option");			
			optFirst.text = "";
			optFirst.value = 0;
			
			document.getElementById("cboCurrency").options.add(optFirst);
				
			for ( var loop = 0; loop < XMLCurrType.length; loop ++)
			 {
				var currType = XMLCurrType[loop].childNodes[0].nodeValue;
				var currRate = XMLCurrRate[loop].childNodes[0].nodeValue;
				
				var optCurr = document.createElement("option");
				optCurr.text =currType ;
				optCurr.value = currType;
				//optCurr.value = currRate;
				
				document.getElementById("cboCurrency").options.add(optCurr);
			 }
			 document.getElementById("cboCurrency").value=0;
		}
	}
}

function clearSelectControl(cboid)
{
   var select=document.getElementById(cboid);
   if(select!=null)
   {
	   var options=select.getElementsByTagName("option");
	   var aa=0;
	   for (aa=select.options.length-1;aa>=0;aa--)
	   {
			select.remove(aa);
	   }
   }
}


function loadInvoiceSchedual()
{
	var schdNo=document.getElementById("cboSchedual").value;
	var supID=document.getElementById("cboSupliers").value;
	
/*		var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';*/
var type = document.getElementById("cboPaymentType").value;
CreateXMLHttpForSchds();
xmlHttpSch.onreadystatechange = HandleSchedualData;
xmlHttpSch.open("GET", 'paymentVoucherDB.php?DBOprType=getInvoiceSchedual&strPaymentType=' + type + '&schdNo=' + schdNo + '&supid=' + supID, true);
xmlHttpSch.send(null); 
	
	calculetTheTotalAmount();
}

function HandleSchedualData()
{	
	if(xmlHttpSch.readyState == 4) 
    {
	   if(xmlHttpSch.status == 200) 
        {  
			var XMLInvNo = xmlHttpSch.responseXML.getElementsByTagName("invNo");
			var XMLAmount = xmlHttpSch.responseXML.getElementsByTagName("amount");
			var XMLPaidAmt = xmlHttpSch.responseXML.getElementsByTagName("paidAmt");
			var XMLadvPaidAmt = xmlHttpSch.responseXML.getElementsByTagName("advpaidAmt");
			

			var strIvnsTable="<table width=\"930\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblInvoice\">"+
					"<tr class='mainHeading4'>"+
					"<td width=\"5%\" height=\"20\" >#</td>"+
					"<td width=\"14%\" bgcolor=\"\" >Invoice No</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Total Amount</td>"+
					"<td width=\"16%\" bgcolor=\"\" >Paid Amount</td>"+
					"<td width=\"17%\" bgcolor=\"\" >Balance</td>"+
					"<td width=\"18%\" bgcolor=\"\" >Pay Amount</td>"+
					"<td width=\"15%\" bgcolor=\"\" >Advance</td>"+
					/*"<td width=\"15%\" bgcolor=\"\" >Currency</td>"+*/
					"</tr>";
							
			
			if(XMLInvNo.length==0)
			{
				var xname=document.getElementById("cboSchedual");
				//var sss=xname.options[document.getElementById("cboSchedual").selectedIndex].text;
				//alert("There is no any Invoice with " + sss);
				strIvnsTable+="</table>"
				document.getElementById("divInvsList").innerHTML=strIvnsTable;
				return;
				
			}
			
			for ( var loop = 0; loop < XMLInvNo.length; loop ++)
			 {
				var invNo = XMLInvNo[loop].childNodes[0].nodeValue;
				var amount = XMLAmount[loop].childNodes[0].nodeValue;
					amount = new Number(amount).toFixed(4);
				var paidAmount = XMLPaidAmt[loop].childNodes[0].nodeValue;
					paidAmount = new Number(paidAmount).toFixed(4);
				var advPaidAmt = XMLadvPaidAmt[loop].childNodes[0].nodeValue;
					advPaidAmt = new Number(advPaidAmt).toFixed(4);
				var balance = parseFloat(amount)- (parseFloat(paidAmount)+parseFloat(advPaidAmt));
					balance = new Number(balance).toFixed(4);
					
					var cls;
					(loop%2==1)?cls='grid_raw':cls='grid_raw2';
				strIvnsTable+="<tr class=\""+cls+"\">"+
								"<td class=\""+cls+"\"><input type=\"checkbox\" onmouseover=\"highlight(this.parentNode)\" name=\"checkbox\" id=\"checkbox\"  checked=\"checked\"   onclick=\"calculetTheTotalAmount()\"/></td>"+
								"<td class=\""+cls+"\"><div align=\"center\" onmouseover=\"highlight(this.parentNode)\" >" + invNo + "</div></td>"+
								"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + amount + "</td>"+
								"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + paidAmount + "</td>"+
								
								"<td class=\""+cls+"\" onmouseover=\"highlight(this.parentNode)\" style=\"text-align:right;\">" + balance + "</td>"+
								"<td class=\""+cls+"\"><input name=\"txtPayAmt\" type=\"text\" id=\"txtPayAmt\" class=\"txtbox\" style=\"text-align:right\" value=\"" + balance  +  "\"  onkeyup=\"checkPayAmount(this)\" onmouseover=\"highlight(this.parentNode)\" onfocus=\"setSelect(this)\" /></td>"+
								
								"<td class=\""+cls+"\" style=\"text-align:right;\">" + advPaidAmt + "</td>"+
								//"<td class=\"normalfntRite\">" +  + "</td>"+
								//"<td colspan=\"2\" class=\"normalfntRite\">" +  + "</td>"+
							  "</tr>" 

			 }
			  strIvnsTable+="</table>"
			  
			 document.getElementById("divInvsList").innerHTML=strIvnsTable;
			 calculetTheTotalAmount()
		}
	}
}

function checkPayAmount(obj)
{
	var theRows=obj.parentNode.parentNode
	var theCell=theRows.getElementsByTagName("TD");
	var balance=parseFloat(theCell[4].innerHTML)
	var payAmt=parseFloat(theCell[5].firstChild.value)
	
	if(isNaN(payAmt)==true)
	{
		alert("Invalid Value")
		theCell[5].firstChild.value=balance;
		return false
	}
	else
	{
		balance=parseFloat(balance);
		payAmt=parseFloat(payAmt);
		
	}
	
	if(balance<payAmt)
	{
		alert("The pay amount should be equal or less than the balance of invoice")	
		theCell[5].firstChild.value=balance;
		return false
	}
	else
	{
		calculetTheTotalAmount()
	}
}

function setSelect(obj)
{
	obj.select();
}

function calculetTheTotalAmount()
{
var totAmount=0;
var payAmt=0
var theRow=document.getElementById("tblInvoice").getElementsByTagName("TR")

	for(var i=1;i<theRow.length;i++)
	{
		var cells=theRow[i].getElementsByTagName("TD");

		if(cells[0].firstChild.checked==true)
		{
		
			payAmt=cells[5].firstChild.value
			//	alert(payAmt)
			//payAmt = new Number(payAmt).toFixed(2);
			payAmt=parseFloat(payAmt)
			totAmount=parseFloat(totAmount)+payAmt
			//totAmount = new Number(totAmount).toFixed(2);
			
		}
	}
		
	document.getElementById("txtTotalAmont").value=totAmount.toFixed(2);

}


function paymentVoucherSave()
{
	if(document.getElementById("txtDate").value=="")
	{
		alert("Please select the Date of Payment");
		document.getElementById("txtDate").focus();
		return false;
	}
	if(document.getElementById("cboSupliers").value==0)
	{
		alert("Please select a Supplier");
		document.getElementById("cboSupliers").focus();
		return false;
	}
	
	if(document.getElementById("cboBatchNo").value==0)
	{
		alert("Please select a Accpac Batch No ");
		document.getElementById("cboBatchNo").focus();
		return false;
	}
	
	if(document.getElementById("txtDescription").value=="")
	{
		alert("Please enter the Description");
		document.getElementById("txtDescription").value="Being Payment Of";
		return false;
	}
	if(document.getElementById("txtAccPacID").value==0)
	{
		alert("Can not be blank the Accpak ID");
		document.getElementById("txtAccPacID").focus();
		return false;
	}
	

	if(document.getElementById("cboSchedual").value==0)
	{
		alert("Please select a payment Schedule");
		document.getElementById("cboSchedual").focus();
		return false;
	}
	
	if(document.getElementById("cboCurrency").value==0)
	{
		alert("Please select a type of currency");
		document.getElementById("cboCurrency").focus();
		return false;
	}
	
	if(document.getElementById("txtTaxCode").value=='-')
	{
		alert("Can not be blank the Tax Code");
		document.getElementById("txtTaxCode").focus();
		return false;
	}
	
	if(parseFloat(document.getElementById("txtTotalAmont").value)==0)
	{
		alert("Total Amount of Payment voucher shouldn't be 0.Please select a  invoice to arrange a payment voucher");
		document.getElementById("tblInvoice").focus();
		return false;
	}
	
	
	
	
	var voucherNo='';//document.getElementById("txtPayVoucherNo").value
	var description=document.getElementById("txtDescription").value
	var batchNo=document.getElementById("cboBatchNo").value	
	var bankCode=document.getElementById("txtBankCode").value	
	var schedualeNo=document.getElementById("cboSchedual").value
	var supID=document.getElementById("cboSupliers").value
	var chequeNo=document.getElementById("txtChequeNo").value
	

	var payDate=document.getElementById("txtDate").value	
	//alert(payDate);
	//var payDate=strYear + "/" + strMonth + "/" +  strDay;

	var amount=document.getElementById("txtTotalAmont").value;
	var currencyObj=document.getElementById("cboCurrency");
	var currency=currencyObj.options[document.getElementById("cboCurrency").selectedIndex].text;
	var rate=document.getElementById("cboCurrency").value;
	var accpakID=document.getElementById("txtAccPacID").value;
	var userid='';//document.getElementById("txtUserID").value;

	//strPaymentType=document.getElementById("cboPymentType").value
/*			var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';*/
	var type = document.getElementById("cboPaymentType").value;
	strPaymentType = type;
	
	CreateXMLHttpForPVoucher() 
	xmlHttpPV.onreadystatechange = HandleSavePaymentVoucher;
    xmlHttpPV.open("GET", 'paymentVoucherDB.php?DBOprType=saveNewPaymentVoucher&strPaymentType=' + strPaymentType + '&voucherNo=' + voucherNo + '&schedualeNo=' + schedualeNo + '&description=' + description + '&batchNo=' + batchNo + '&bankCode=' + bankCode + '&supID=' + supID + '&chequeNo=' + chequeNo + '&datex=' + payDate + '&amount=' + amount + '&currency=' + currency + '&rate=' + rate + '&accpakID=' + accpakID +'&userid=' + userid, true);
	xmlHttpPV.send(null); 
	
}

function HandleSavePaymentVoucher()
{	
	if(xmlHttpPV.readyState == 4) 
    {
	   if(xmlHttpPV.status == 200) 
        {
			var XMLResult = xmlHttpPV.responseXML.getElementsByTagName("Result");
			var XMLvoucher = xmlHttpPV.responseXML.getElementsByTagName("voucherNo");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
				var theRow=document.getElementById("tblInvoice").getElementsByTagName("TR")
				for(var i=1;i<theRow.length;i++)
				{
					var cells=theRow[i].getElementsByTagName("TD");
					if(cells[0].firstChild.checked==true)
					{
						var voucherNo=XMLvoucher[0].childNodes[0].nodeValue;
						var invoiceNo=cells[1].firstChild.innerHTML
						var amount=cells[2].innerHTML
						var balance=cells[4].innerHTML
						var paidAmount=cells[5].firstChild.value
						//strPaymentType=document.getElementById("cboPymentType").value
						/*
						var type = '';
						if(document.getElementById("rdoStyle").checked)
							type = 'S';
						else if(document.getElementById("rdoBulk").checked)
							type = 'B';
						else if(document.getElementById("rdoGeneral").checked)
							type = 'G';
						else if(document.getElementById("rdoWash").checked)
							type = 'W';*/
						var type = document.getElementById("cboPaymentType").value;
						strPaymentType = type;
	
						CreateXMLHttpForPVoucherDetails()					
						xmlHttpPVDetails.onreadystatechange = HandleSavePaymentVoucherDetails;
						xmlHttpPVDetails.open("GET", 'paymentVoucherDB.php?DBOprType=saveNewPaymentVoucherDetails&strPaymentType=' + strPaymentType + '&voucherNo=' + voucherNo + '&invoiceNo=' + invoiceNo + '&amount=' + amount + '&balance=' + balance + '&paidAmount=' + paidAmount, true);
						xmlHttpPVDetails.send(null);
						//alert(invoiceNo);
					}
				}				
				
				
				
				
				alert("New Payment Voucher Saved Successfully. Voucher no is "+voucherNo);
				clearPayementVoucherIF()
				//getAdvPaymentNo()
				//document.getElementById("cboPymentType").value="S";
				
			}
			else
			{
				alert("Save Process Failed.");
			}
		}
	}
}

function HandleSavePaymentVoucherDetails()
{	
	if(xmlHttpPVDetails.readyState == 4) 
    {
	   if(xmlHttpPVDetails.status == 200) 
        {
			var XMLResult = xmlHttpPVDetails.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
			}
		}
	}
}

function setDefaultDateofFinder()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(year + "/" + month + "/" +day );
	document.getElementById("txtDateFrom").value=ddate
	document.getElementById("txtDateTo").value=ddate
}


function setDefaultDateOfChequePrinter()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(year + "/" + month + "/" +day );
	document.getElementById("txtDate").value=ddate
	geChequeRefTask(1)
}


function geChequeRefTask(task)
{					

	CreateXMLHttpChequeRefTask();
	xmlHttpChqRefNo.onreadystatechange = HandleChqRefNo;
    xmlHttpChqRefNo.open("GET", 'paymentVoucherDB.php?DBOprType=ChequeReferenceTask&task=' + task , true);
	xmlHttpChqRefNo.send(null); 
}

function HandleChqRefNo()
{
	if(xmlHttpChqRefNo.readyState == 4) 
    {
	   if(xmlHttpChqRefNo.status == 200) 
        {  
			var XMLChRefNo = xmlHttpChqRefNo.responseXML.getElementsByTagName("dblChequeRefNo");
			if(XMLChRefNo.length==0)
			{
				alert("Please configer the system cheque reference range of syscontrol")
				return
			}
			chRef = XMLChRefNo[0].childNodes[0].nodeValue;
			document.getElementById("txtChequeRef").value=chRef;
		}
	}
}



function paymentVoucherPrint()
{
	amtInWords=""
	//strPaymentType=document.getElementById("cboPymentType").value
	
	/*
		var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';*/
		
			var type = document.getElementById("cboPaymentType").value;	
		
	var selectedPaymentNo =  document.getElementById("txtPayVoucherNo").value-1;
	getTotalInWords(selectedPaymentNo)
	window.open('rptChequePaymentVoucher.php?PayVoucherNo=' + selectedPaymentNo + '&strPaymentType=' + type + '&amt=' + amtInWords)
	window.open('rptPaymentSchedule.php?PayVoucherNo=' + selectedPaymentNo + '&strPaymentType=' + type )
	
}

function fillAvailablePaymentDataToPrint()
{
	
	var supID=document.getElementById("cboSuppliers").value;
	
	document.getElementById("txtPayee").value=document.getElementById("cboSuppliers").options[document.getElementById("cboSuppliers").selectedIndex].text;
	
	strPaymentType="S"
	
	var payeeCat=parseInt(document.getElementById("cboPaymentMode").value);
	
	CreateXMLHttpForPVoucherPrint() 
	xmlHttpPVPrint.onreadystatechange = HandlePaymentVoucherToPrint;
    xmlHttpPVPrint.open("GET", 'paymentVoucherDB.php?DBOprType=getPaymentVouchersToPrint&supID=' + supID + '&payeeCat=' + payeeCat + '&strPaymentType=' + strPaymentType , true);
	xmlHttpPVPrint.send(null); 
}

function HandlePaymentVoucherToPrint()
{
	if(xmlHttpPVPrint.readyState == 4) 
	{
	   if(xmlHttpPVPrint.status == 200) 
		{
			var XMLpayVoucherNo = xmlHttpPVPrint.responseXML.getElementsByTagName("payVoucherNo");
			var XMLdatex = xmlHttpPVPrint.responseXML.getElementsByTagName("datex");
			var XMLDescription = xmlHttpPVPrint.responseXML.getElementsByTagName("description");
			var XMLamount = xmlHttpPVPrint.responseXML.getElementsByTagName("amount");
			var XMLTax= xmlHttpPVPrint.responseXML.getElementsByTagName("tax");
			var XMLType= xmlHttpPVPrint.responseXML.getElementsByTagName("type");
			
			
			var strPVoucher="<table id=\"tblPVData\" width=\"922\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
							"<tr>"+
							"<td width=\"2%\" height=\"25\" bgcolor=\"\" class=\"grid_header\">*</td>"+
							"<td width=\"11%\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Voucher No</td>"+
							"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">Date</td>"+
							"<td width=\"21%\" bgcolor=\"\" class=\"grid_header\">Description</td>"+
							"<td width=\"11%\" bgcolor=\"\" class=\"grid_header\">Amount</td>"+
							"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">Tax</td>"+
							"<td width=\"12%\" bgcolor=\"\" class=\"grid_header\">Total Amount</td>"+
							"<td width=\"7%\" bgcolor=\"\" class=\"grid_header\"></td>"+
							"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">Voucher</td>"+
							"<td width=\"9%\" bgcolor=\"\" class=\"grid_header\">Schedule</td>"+
							"</tr>"
			
			if(XMLpayVoucherNo.length==0)
			{
				alert("No Voucher to arrange a Cheque")	
			}
			for ( var loop = 0; loop < XMLpayVoucherNo.length; loop ++)
			 {
				var VoucherNo = XMLpayVoucherNo[loop].childNodes[0].nodeValue;
				var datex = XMLdatex[loop].childNodes[0].nodeValue;
				var description= XMLDescription[loop].childNodes[0].nodeValue;
				
				var	amount=XMLamount[loop].childNodes[0].nodeValue;
					amount = new Number(amount).toFixed(2);
										
				var tax=XMLTax[loop].childNodes[0].nodeValue;
					tax = new Number(tax).toFixed(2);
					amount=amount-tax
					
				var totAmt=parseFloat(amount)+parseFloat(tax)
				    totAmt = new Number(totAmt).toFixed(2);
										
				var type=XMLType[loop].childNodes[0].nodeValue;
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				
					strPVoucher+="<tr>"+
		"<td height=\"20\"  onmouseover=\"highlight(this.parentNode)\" class=\"normalfnt\"><input type=\"checkbox\" name=\"checkbox\" value=\"checkbox\"  onclick=\"calTatolAmt()\" /></td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\">" + VoucherNo + "</td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\">" + datex + "</td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:left\">" + description + "</td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right\">" + amount + "</td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right\">" + tax + "</td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right\">" + totAmt + "</td>"+
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:center\">" + type + "</td>"+
								
		"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onmouseover=\"highlight(this.parentNode)\" onclick=\"previewReportPVfromChequePrint(this)\"/></div></td>"+
		"<td height=\"20\" class=\""+cls+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onmouseover=\"highlight(this.parentNode)\" onclick=\"previewReportPSfromChequePrint(this)\"/></div></td>"+
		"</tr>"
				
			}
			strPVoucher+="</table>"
			document.getElementById("divPayVoucherData").innerHTML=strPVoucher
			
		}
	}
}

function calTatolAmt()
{
	var totAmt=0;
	var theRow=document.getElementById("tblPVData").getElementsByTagName("TR")
	for(var i=1;i<theRow.length;i++)
	{
		var cells=theRow[i].getElementsByTagName("TD");

		if(cells[0].firstChild.checked==true)
		{
			totAmt=parseFloat(totAmt)+parseFloat(cells[6].innerHTML)
			totAmt = new Number(totAmt).toFixed(2);
		}
	}
	document.getElementById("txtTotAmt").value=totAmt
		
}


function fillAvailablePaymentData()
{
	
	var supID=document.getElementById("cboSuppliers").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
	var dateTo=document.getElementById("txtDateTo").value;
	var voucherNo=document.getElementById("txtVoucherNo").value;
	var invoiceNo=document.getElementById("txtInvoiceNo").value;
	
	//strPaymentType=document.getElementById("cboPymentType").value
	/*	var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';*/
		
	var type = document.getElementById("cboPaymentType").value;
	strPaymentType = type;
	
	CreateXMLHttpForPVoucher() 
	xmlHttpPV.onreadystatechange = HandlePaymentVoucher;
    xmlHttpPV.open("GET", 'paymentVoucherDB.php?DBOprType=getPaymentVouchers&strPaymentType=' + strPaymentType + '&supID=' + supID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo + '&voucherNo=' +voucherNo+ '&invoiceNo=' +invoiceNo , true);
	xmlHttpPV.send(null); 
}

function HandlePaymentVoucher()
{
	if(xmlHttpPV.readyState == 4) 
	{
	   if(xmlHttpPV.status == 200) 
		{
			var XMLpaySupId = xmlHttpPV.responseXML.getElementsByTagName("strSupCode");
			var XMLpayVoucherNo = xmlHttpPV.responseXML.getElementsByTagName("payVoucherNo");
			var XMLdatex = xmlHttpPV.responseXML.getElementsByTagName("datex");
			var XMLamount = xmlHttpPV.responseXML.getElementsByTagName("amount");
			var XMLchequeNo= xmlHttpPV.responseXML.getElementsByTagName("chequeNo");
			var XMLType= xmlHttpPV.responseXML.getElementsByTagName("type");
			
			//strPaymentType=document.getElementById("cboPymentType").value
			
			//alert(strPaymentType)
			RemoveAllRows('tblPVData');
			var strPVoucher="<table id=\"tblPVData\" width=\"922\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"\">"+
						"<tr>"+
						"<td width=\"10%\" height=\"29\" bgcolor=\"\" class=\"grid_header\">Sup ID</td>"+
						"<td width=\"16%\" height=\"29\" bgcolor=\"\" class=\"grid_header\">Voucher No</td>"+
						"<td width=\"16%\" bgcolor=\"\" class=\"grid_header\">Date</td>"+
						"<td width=\"18%\" bgcolor=\"\" class=\"grid_header\">Amount </td>"+
						"<td width=\"18%\" bgcolor=\"\" class=\"grid_header\">Cheque No</td>"+
						"<td width=\"1%\" bgcolor=\"\" class=\"grid_header\">Type</td>"+
						"<td width=\"11%\" bgcolor=\"\" class=\"grid_header\">View Voucher</td>"+
		                "<td width=\"12%\" bgcolor=\"\" class=\"grid_header\">View Schedule</td>"+
						"</tr>"
			
			if(XMLpayVoucherNo.length<=0){
				alert("No data found in a selected options.");
				return;
			}
			for ( var loop = 0; loop < XMLpayVoucherNo.length; loop ++)
			 {
				var cls;
				(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				var supid		= XMLpaySupId[loop].childNodes[0].nodeValue;
				var VoucherNo 	= XMLpayVoucherNo[loop].childNodes[0].nodeValue;
				var datex 		= XMLdatex[loop].childNodes[0].nodeValue;
				var	amount		=XMLamount[loop].childNodes[0].nodeValue;
					//amount=Math.round(amount*100)/100;
					amount 		= new Number(amount).toFixed(2);
				var chequeNo	=XMLchequeNo[loop].childNodes[0].nodeValue;
				var type		=XMLType[loop].childNodes[0].nodeValue;
				
				//<input type=\"checkbox\" name=\"checkbox\" value=\"checkbox\" />
				
					strPVoucher+="<tr class=\"bcgcolor-tblrowWhite\" onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background=''\">"+
								"<td height=\"20\" class=\""+ cls +"\">" + supid + "</td>"+
								"<td height=\"20\" class=\""+ cls +"\">" + VoucherNo + "</td>"+
								"<td height=\"20\" class=\""+ cls +"\">" + datex + "</td>"+
								"<td height=\"20\" class=\""+ cls +"\" style=\"text-align:right\">" + amount + "</td>"+
								"<td height=\"20\" class=\""+ cls +"\" style=\"text-align:center\">" + chequeNo + "</td>"+
								"<td height=\"20\" class=\""+ cls +"\" style=\"text-align:center\">" + type + "</td>"+
								"<td height=\"20\" class=\""+ cls +"\"><div align=\"center\"><img src=\"../images/view.png\" onclick=\"previewReportPV(this,strPaymentType)\"/></div></td>"+
								"<td height=\"20\" class=\""+ cls +"\"><div align=\"center\"><img src=\"../images/view.png\" onclick=\"previewReportPS(this,strPaymentType)\"/></div></td>"+
								"</tr>"
				
				
				
			}
			strPVoucher+="</table>"
			document.getElementById("divPayVoucherData").innerHTML=strPVoucher
			
		}
	}
}

function saveChequeDetails()
{
	if(document.getElementById("txtChequeRef").value=="")
	{
		alert("Please contact the SysAdmin to configer the Cheque Reference according to the company.")
		return;
	}
	if(document.getElementById("txtTotAmt").value=="0.00")
	{
		alert("Please select a supplier and select the voucher to arrange a cheque.")
		document.getElementById("cboSuppliers").focus();
		return;
	}

	var payee=document.getElementById("txtPayee").value;
		//payee=payee.trim();
	
	if(payee=="")
	{
		alert("Can not be blank the Payee of Cheque.");
		document.getElementById("txtPayee").value=document.getElementById("cboSuppliers").options[document.getElementById("cboSuppliers").selectedIndex].text;
	
		document.getElementById("txtPayee").focus();
		return;
	}
	
	if(document.getElementById("cboBanks").value==0)
	{
		alert("Can not be blank the Bank of Cheque.");
		document.getElementById("cboBanks").focus();
		return;
	}
	
	
	
	var chequeRefNo=document.getElementById("txtChequeRef").value
	var supID=document.getElementById("cboSuppliers").value
	var datex=document.getElementById("txtDate").value
	var bankID=document.getElementById("cboBanks").value
	var chkFormtat=document.getElementById("chequeType").value
	
	if(document.getElementById("optCross").checked==true)
	{
		var chequeType="CROSS"
	}
	else if(document.getElementById("optPayee").checked==true)
	{
		var chequeType="ACCPAYEE"
	}
	var chequeAmount=document.getElementById("txtTotAmt").value
	

	CreateXMLHttpForSaveChequeHeader();
	xmlHttpCheque.onreadystatechange = HandleChaques;
	xmlHttpCheque.open("GET", 'paymentVoucherDB.php?DBOprType=saveChequePrinterHeader&chequeRefNo=' + chequeRefNo + '&supID=' + supID + '&chDate=' + datex + '&payee=' + payee + '&bankID=' + bankID + '&chequeType=' + chequeType + '&totalAmount=' + chequeAmount + '&chkFormtat=' + chkFormtat , true);
	xmlHttpCheque.send(null); 	
	
	
}

function HandleChaques()
{
	if(xmlHttpCheque.readyState == 4) 
	{
	   if(xmlHttpCheque.status == 200) 
		{
			var XMLChequeHeadData = xmlHttpCheque.responseXML.getElementsByTagName("Result");
			var row=document.getElementById("tblPVData").getElementsByTagName("TR")
			if(XMLChequeHeadData[0].childNodes[0].nodeValue=="True")
			{
				for(var i=1;i<row.length;i++)
				{
					var cells=row[i].getElementsByTagName("TD");
			
					if(cells[0].firstChild.checked==true)
					{
						var chequeRefNo=document.getElementById("txtChequeRef").value
						var voucherNo=cells[1].innerHTML
						var strDescription=cells[3].innerHTML
						var amount=cells[4].innerHTML
						var taxamount=cells[5].innerHTML
						var mode=parseInt(document.getElementById("cboPaymentMode").value)
						switch(mode)
						{
							case 1:
								var chqMode="PO"
								break;
							case 2:
								var chqMode="WPO"
								break;
							case 3:
								var chqMode="ADVP"
								break;
						}
						
						CreateXMLHttpForSaveChequeDetails();
						xmlHttpChqDetails.onreadystatechange = HandleChaqueDetails;
						xmlHttpChqDetails.open("GET", 'paymentVoucherDB.php?DBOprType=saveChequePrinterDetails&chequeRefNo=' + chequeRefNo + '&voucherNo=' + voucherNo + '&amount=' + amount + '&taxamount=' + taxamount + '&chqMode=' + chqMode + '&Description='+ strDescription, true);
						xmlHttpChqDetails.send(null); 	
					
					}
				}
				alert("Cheque Details Saved Successfully.")

				geChequeRefTask(2)
				clearChequePrint()
				return;
			}
		}
	}
}


function HandleChaqueDetails()
{
	if(xmlHttpChqDetails.readyState == 4) 
	{
	   if(xmlHttpChqDetails.status == 200) 
		{
			var XMLChequeDetails = xmlHttpChqDetails.responseXML.getElementsByTagName("Result");

			if(XMLChequeDetails[0].childNodes[0].nodeValue=="False")
			{
				alert("Cheque Details Save Process Fail.")
				return
			}
		}
	}
}

function clearChequePrint()
{
	document.getElementById("txtPayee").value="";
	document.getElementById("cboBanks").value=0;
	document.getElementById("txtTotAmt").value="0.00";
	document.getElementById("cboSuppliers").value=0
	document.getElementById("chequeType").value=1
	
	document.getElementById("optCross").checked=true
	var strPVoucher="<table id=\"tblPVData\" width=\"922\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >"+
					"<tr>"+
					"<td width=\"2%\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">*</td>"+
					"<td width=\"11%\" height=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Voucher No</td>"+
					"<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
					"<td width=\"21%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Description</td>"+
					"<td width=\"11%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Amount</td>"+
					"<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Tax</td>"+
					"<td width=\"12%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Total Amount</td>"+
					"<td width=\"7%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\"></td>"+
					"<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Voucher</td>"+
					"<td width=\"9%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Schedule</td>"+
					"</tr></Table>"
					
					
	document.getElementById("divPayVoucherData").innerHTML=strPVoucher
	setDefaultDateOfChequePrinter()
}

function findChequeDetails()
{
	var supID=document.getElementById("cboSuppliers").value;
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
	
	CreateXMLHttpChequeDetails();
	xmlHttpChqDetails.onreadystatechange = HandleAvlChaqueDetails;
	xmlHttpChqDetails.open("GET", 'paymentVoucherDB.php?DBOprType=findChequeDetails&supID=' + supID + '&dateFrom=' + dateFrom + '&dateTo=' + dateTo, true);
	xmlHttpChqDetails.send(null); 	

}

function HandleAvlChaqueDetails()
{
	if(xmlHttpChqDetails.readyState == 4) 
	{
	   if(xmlHttpChqDetails.status == 200) 
		{
			var XMLChequeRef = xmlHttpChqDetails.responseXML.getElementsByTagName("chequeRefNo");
			var XMLChequeDate = xmlHttpChqDetails.responseXML.getElementsByTagName("chDate");
			var XMLChequeAmount = xmlHttpChqDetails.responseXML.getElementsByTagName("totalAmount");
			var XMLChequeType = xmlHttpChqDetails.responseXML.getElementsByTagName("chequeType");
			var XMLChequeBank = xmlHttpChqDetails.responseXML.getElementsByTagName("bankName");
			var XMLChequeFormatID = xmlHttpChqDetails.responseXML.getElementsByTagName("chqFormatID");
			var XMLChequeFormat = xmlHttpChqDetails.responseXML.getElementsByTagName("strFromat");
			var XMLisChequePrinted = xmlHttpChqDetails.responseXML.getElementsByTagName("isChequePrinted");

			var strChqData="<table id=\"tblChequeData\" width=\"922\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
							"<tr>"+
							"<td width=\"11%\" height=\"25\" bgcolor=\"\" class=\"grid_header\">Cheque Ref. No</td>"+
							"<td width=\"12%\" bgcolor=\"\" class=\"grid_header\">Date</td>"+
							"<td width=\"10%\" bgcolor=\"\" class=\"grid_header\">Amount</td>"+
							"<td width=\"13%\" bgcolor=\"\" class=\"grid_header\">Cheque Type</td>"+
							"<td width=\"40%\" bgcolor=\"\" class=\"grid_header\">Bank</td>"+
							"<td width=\"7%\" bgcolor=\"\" class=\"grid_header\">Format</td>"+
							"<td width=\"0%\" bgcolor=\"\" class=\"grid_header\"></td>"+
							"<td width=\"5%\" bgcolor=\"\" class=\"grid_header\">View</td>"+
							"</tr>"
			
			for ( var loop = 0; loop < XMLChequeRef.length; loop ++)
			{
				var chequeRef 	=XMLChequeRef[loop].childNodes[0].nodeValue;
				var datex 		=XMLChequeDate[loop].childNodes[0].nodeValue;
				var	amount		=XMLChequeAmount[loop].childNodes[0].nodeValue;
					//amount		=Math.round(amount*100)/100;
					amount = new Number(amount).toFixed(2);
				var chequeType	=XMLChequeType[loop].childNodes[0].nodeValue;
				var chequeBank	=XMLChequeBank[loop].childNodes[0].nodeValue;
				var chequeFID	=XMLChequeFormatID[loop].childNodes[0].nodeValue;
				var chequeFromat=XMLChequeFormat[loop].childNodes[0].nodeValue;
				var isChequePrinted=XMLisChequePrinted[loop].childNodes[0].nodeValue;
			var cls;
			(loop%2==0)?cls="grid_raw":cls="grid_raw2";
				if(isChequePrinted==1)
				{
					strChqData+="<tr>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\">" + chequeRef + "</td>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + datex + "</td>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right\">" + amount + "</td>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:center\">" + chequeType + "</td>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + chequeBank + "</td>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + chequeFromat + "</td>"+
					"<td height=\"20\"  bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + chequeFID + "</td>"+
					"<td height=\"20\" bgcolor=\"#DFFFBF\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\"></div></td>"+
					"</tr>"
					
				}
				else
				{
					strChqData+="<tr>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\">" + chequeRef + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + datex + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:right\">" + amount + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" style=\"text-align:center\">" + chequeType + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + chequeBank + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + chequeFromat + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\" >" + chequeFID + "</td>"+
					"<td height=\"20\" onmouseover=\"highlight(this.parentNode)\" class=\""+cls+"\"><div align=\"center\"><img src=\"../images/butt_1.png\" width=\"15\" height=\"15\" onclick=\"printCheque(this)\" /></div></td>"+
					"</tr>"
				}
			}
			 strChqData+="</table>"
			 document.getElementById("divChequeData").innerHTML=strChqData
		}
	}
}

function printCheque(obj)
{
	var row=obj.parentNode.parentNode.parentNode

	var chequeRefNo =  row.cells[0].innerHTML;
	var amount=  row.cells[2].innerHTML;
	var format=  parseInt(row.cells[6].innerHTML);
	var amtWords=toWords(parseFloat(amount))
	amtInWords="**"+amtWords.toUpperCase()+"**";
	//alert(format)
	
	switch(format)
	{
	case 1:
		window.open('rptChequeBOC1.php?&chequeRefNo=' + chequeRefNo + '&amtInWords=' + amtInWords )
		findChequeDetails()
		break;
	case 2:
		window.open('rptChequeBOC2.php?&chequeRefNo=' + chequeRefNo + '&amtInWords=' + amtInWords )
		findChequeDetails()
		break;
	case 3:
		window.open('rptChequeHNB.php?&chequeRefNo=' + chequeRefNo + '&amtInWords=' + amtInWords )
		findChequeDetails()
		break;
	case 4:
		window.open('rptChequeHNB.php?&chequeRefNo=' + chequeRefNo + '&amtInWords=' + amtInWords )
		findChequeDetails()
		break;
	case 5:
		window.open('rptChequeHNB.php?&chequeRefNo=' + chequeRefNo + '&amtInWords=' + amtInWords )
		findChequeDetails()
		break;
	case 6:
		window.open('rptChequeCommercial.php?&chequeRefNo=' + chequeRefNo + '&amtInWords=' + amtInWords )
		findChequeDetails()
		break;
	}

	
	
}


// Removes leading whitespaces
function LTrim( value ) 
{
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
}
// Removes ending whitespaces
function RTrim( value ) 
{
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
}

// Removes leading and ending whitespaces
function trim( value ) 
{	
	return LTrim(RTrim(value));	
}



function paymentVoucherReport()
{
	
	location = "paymentVoucherFinder.php";
	return;
}

function previewReportPV(obj,strPaymentType)
{
	var row					=	obj.parentNode.parentNode.parentNode
	var selectedPaymentNo 	=  	row.cells[1].innerHTML;
	
	getTotalInWords(selectedPaymentNo)
	window.open('rptChequePaymentVoucher.php?&strPaymentType=' + strPaymentType + '&PayVoucherNo=' + selectedPaymentNo + '&amt=' + amtInWords )
}

function previewReportPS(obj,strPaymentType)
{
	var row=obj.parentNode.parentNode.parentNode
	var supid				=  row.cells[0].innerHTML;
	var selectedPaymentNo 	=  row.cells[1].innerHTML;
	window.open('rptPaymentSchedule.php?&strPaymentType=' + strPaymentType + '&PayVoucherNo=' + selectedPaymentNo + '&supid=' + supid )
}


function previewReportPVfromChequePrint(obj)
{
	var mode=parseInt(document.getElementById("cboPaymentMode").value);
	var row=obj.parentNode.parentNode.parentNode
	var selectedPaymentNo =  row.cells[1].innerHTML;
	
	getTotalInWords(selectedPaymentNo)
	switch(mode)
	{
	case 1:
		window.open('rptChequePaymentVoucher.php?&strPaymentType=' + strPaymentType + '&PayVoucherNo=' + selectedPaymentNo + '&amt=' + amtInWords )
		break;
	case 2:
		window.open('../PaymetsWithoutPO/rptWPOChequePaymentVoucher.php?PayVoucherNo=' + selectedPaymentNo )
		break;
	case 3:
		window.open('rptAdvancePaymentReport.php?PayNo=' + selectedPaymentNo + '&strPaymentType=' + strPaymentType   )	
		break;
	}
}
function previewReportPSfromChequePrint(obj)
{
	var mode=parseInt(document.getElementById("cboPaymentMode").value);
	var row=obj.parentNode.parentNode.parentNode
	var selectedPaymentNo =  row.cells[1].innerHTML;
	switch(mode)
	{
	case 1:
		window.open('rptPaymentSchedule.php?&strPaymentType=' + strPaymentType + '&PayVoucherNo=' + selectedPaymentNo )
		break;
	case 2:
		window.open('../PaymetsWithoutPO/rptWPOPaymentSchedule.php?PayVoucherNo=' + selectedPaymentNo )
		break;
	case 3:
		alert("There is no Schedule to Advance Payment")
		break;
	}
}


function setDefaultDate()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(day + "/" + month + "/" + year);
	document.getElementById("txtDate").value=ddate
	//getAdvPaymentNo(1)
}

function highlight(o)
{
	var p = o.parentNode;
	
	while( p.tagName != "TABLE")
	{
		p=p.parentNode;
	}
	for( var i=0; i < p.rows.length; ++i)
	{
		p.rows[i].className="";
	}
	while(o.tagName !="TR")
	o=o.parentNode
	o.className="backcolorYellow";
}

function getAdvPaymentNo()
{
	//strPaymentType=document.getElementById("cboPymentType").value
		/*	var type = '';
	
	if(document.getElementById("rdoStyle").checked)
		type = 'S';
	else if(document.getElementById("rdoBulk").checked)
		type = 'B';
	else if(document.getElementById("rdoGeneral").checked)
		type = 'G';
	else if(document.getElementById("rdoWash").checked)
		type = 'W';*/
			var type = document.getElementById("cboPaymentType").value;	
	strPaymentType = type;
	CreateXMLHttpForPayVoucherNo();
	xmlHttpPVNo.onreadystatechange = HandleAdvanceNo;
    xmlHttpPVNo.open("GET", 'paymentVoucherDB.php?DBOprType=PaymentVoucherNoTask&strPaymentType=' + strPaymentType + '&task=' + task, true);
	xmlHttpPVNo.send(null); 
}

function HandleAdvanceNo()
{
	if(xmlHttpPVNo.readyState == 4) 
    {
	   if(xmlHttpPVNo.status == 200) 
        {  
			var XMLPayVoucherNo = xmlHttpPVNo.responseXML.getElementsByTagName("paymentVoucherNo");
	
			if(XMLPayVoucherNo.length>0)
			{
				var PayVoucherNo = XMLPayVoucherNo[0].childNodes[0].nodeValue;
			}
			else
			{
				var PayVoucherNo ='1000'
			}
			document.getElementById("txtPayVoucherNo").value=PayVoucherNo;
		}
	}
}

function getTotalInWords(payNo,strPaymentType)
{
	amtInWords=""
	//strPaymentType=document.getElementById("cboPymentType").value
	CreateXMLHttpForTotal();
	xmlHttpTotal.onreadystatechange = HandleTotalAmt;
    xmlHttpTotal.open("GET", 'paymentVoucherDB.php?DBOprType=PaymentAmt&strPaymentType=' + strPaymentType + '&payNo=' + payNo, true);
	xmlHttpTotal.send(null); 
}

function HandleTotalAmt()
{
	amtWords=""
	amt=0

	if(xmlHttpTotal.readyState == 4) 
    {
	   if(xmlHttpTotal.status == 200) 
        {  
			var XMLPayAmt = xmlHttpTotal.responseXML.getElementsByTagName("paymentAmt");

			for ( var loop = 0; loop < XMLPayAmt.length; loop ++)
			{
				amtInWords=""
				var amt= XMLPayAmt[loop].childNodes[0].nodeValue;
			}

			var amtWords=toWords(parseFloat(amt))
			amtInWords=amtWords.toUpperCase()+"ONLY.";
			//alert(amtInWords)
		}
	}
}



function toWords(s)
{
	var str = ''; 
	s = s.toString(); 
	s = s.replace(/[\, ]/g,''); 
	if (s != String(parseFloat(s))) 
	return 'not a number'; 
	var x = s.indexOf('.'); 
	var fullValue=0;
	var decValue=0;
	
	if(x>0)
	{
		fullValue=s.substring(0,x)		
		decValue=s.substring(x+1)	
		//alert(decValue);
	}
	else if(x==-1)
	{
		fullValue=s
	}
	
	if (fullValue!=0)
	{
		x = fullValue.length; 
		if (x > 15)
		{
		return 'too big'; 
		}
		else
		{
			var n = fullValue.split(''); 
			var sk = 0; 
			for (var i=0; i < x; i++) 
			{
				if ((x-i)%3==2) 
				{
					if (n[i] == '1') 
					{
						str += tn[Number(n[i+1])] + ' '; 
						i++; 
						sk=1;
					} 
					else if (n[i]!=0) 
					{
						str += tw[n[i]-2] + ' ';
						sk=1;
					}
				} 
				else if (n[i]!=0) 
				{
					str += dg[n[i]] +' '; 
					if ((x-i)%3==0)
					{
					str += 'hundred ';
					sk=1;
					}
					if ((x-i)%4==0)
					{
					//str += 'thousand ';
					sk=1;
					}
					if ((x-i)%3==1) 
					{
						if (sk) 
						str += th[(x-i-1)/3] + ' ';
						sk=0;
					}
				}
		 	}
		}
	}


	if (decValue !=0)
	{
		x = decValue.length; 
		if (x > 15)
		{
		return 'too big'; 
		}
		else
		{
			var n = decValue.split(''); 
			//
			var sk = 0;
			str +='and '
			for (var i=0; i < x; i++) 
			{
				if ((x-i)%3==2) 
				{
					if (n[i] == '1') 
					{
						str += tn[Number(n[i+1])] + ' '; 
						i++; 
						sk=1;
					} 
					else if (n[i]!=0) 
					{
						str += tw[n[i]-2] + ' ';
						sk=1;
					}
				} 
				else if (n[i]!=0) 
				{
					str += dg[n[i]] +' '; 
					if ((x-i)%3==0)
					{
					str += 'hundred ';
					sk=1;
					} 
					if ((x-i)%3==1) 
					{
						if (sk) 
						str += th[(x-i-1)/3] + ' ';
						sk=0;
					}
				}
		 	}
		}
	str +='cents'
	}

			//if (x != s.length) 
//			{
//				var y = s.length; 
//				str += 'and '; 
//				var intx=0;
//				for (var i=x+1; i<y; i++) 
//				{
//					if(intx==1)
//					{
//						str += dg[n[i]] +' ';
//					}
//					if(intx==0)
//					{
//						str += tw[n[i]] +' ';
//						intx=intx+1
//					}
//				}
//				str += 'cents';
//			} 



	
			return str.replace(/\s+/g,' ');
}














//Calander Functions
function toggleCalendar()
{	
	var txtObj=document.getElementById("txtDate")
	cObj = txtObj.myCalendar;

	if (!cObj) {
		cObj = new CalendarDisplay(txtObj);
		document.body.appendChild(cObj.cDiv);
		txtObj.myCalendar = cObj;
	}
	
	cObj.toggle();
}

CalendarDisplay = function(txtObj) {
	this.txtObj = txtObj;
	this.tBox = this.txtObj;
	this.cDiv = document.createElement('div');
	this.cDiv.style.position = 'absolute';
	this.cDiv.style.display = 'none';
}

CalendarDisplay.prototype.MONTHS_CALENDAR = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
CalendarDisplay.prototype.DAYS_1_CALENDAR = new Array("S", "M", "T", "W", "T", "F", "S");
CalendarDisplay.prototype.DAYS_2_CALENDAR = new Array("Su", "Mo", "Tu", "We", "Th", "Fr", "Sa");

CalendarDisplay.prototype.toggle = function() {
	if (this.cDiv.style.display == 'none') {
		this.adjustPosition();
		this.fillCalendar(this.grabDate());
		this.cDiv.style.display = 'block';
	} else {
		this.cDiv.style.display = 'none';
	}
}

CalendarDisplay.prototype.grabDate = function() {
	var tempDate = new Date(this.tBox.value);
	if (!tempDate.getYear()) {
		tempDate = new Date();
	}
	return tempDate;
}

CalendarDisplay.prototype.fillCalendar = function(theDate) {
	if (this.cDiv.firstChild) {
		this.cDiv.removeChild(this.cDiv.firstChild);
	}
	this.adjustPosition();
	this.cDiv.appendChild(this.getCalendar(theDate));
}

CalendarDisplay.prototype.adjustPosition = function() {
	this.cDiv.style.top = this.tBox.offsetHeight + this.findPosY(this.tBox) + 'px';

	this.cDiv.style.left = this.findPosX(this.tBox) + 'px';
}

CalendarDisplay.prototype.getCalendar = function(theDate) {
	var theYear = theDate.getFullYear();
	var theMonth = theDate.getMonth();
	var theDay = theDate.getDate();

	var theTable = document.createElement('table');
	theTable.id = 'calendartable';
	var theTHead = theTable.createTHead();
	var theTBody = document.createElement('tbody');
	theTable.appendChild(theTBody);
	
	var monthRow = theTHead.insertRow(0);
	var navLeftCell = monthRow.insertCell(0);
	var monthCell = monthRow.insertCell(1);
	var navRightCell = monthRow.insertCell(2);
	monthCell.colSpan = 5;
	monthCell.appendChild(document.createTextNode(this.MONTHS_CALENDAR[theMonth] + ', ' + theYear));
	var leftLink = document.createElement('a');
	leftLink.href = '#';
	this.setCalendarPrevious(leftLink, this.txtObj, theYear, theMonth, theDay);
	leftLink.appendChild(document.createTextNode('-'));
	navLeftCell.appendChild(leftLink);
	var rightLink = document.createElement('a');
	rightLink.href = '#';
	this.setCalendarNext(rightLink, this.txtObj, theYear, theMonth, theDay);
	rightLink.appendChild(document.createTextNode('+'));
	navRightCell.appendChild(rightLink);
	
	var weeksRow = theTHead.insertRow(1);
	for (var i=0; i<7; i++) {
		var tempWeeksCell = weeksRow.insertCell(i);
		tempWeeksCell.appendChild(document.createTextNode(this.DAYS_2_CALENDAR[i]));
	}
	
	var temporaryDate1 = new Date(theYear, theMonth, 1);
	var startDayOfWeek = temporaryDate1.getDay();
	var temporaryDate2 = new Date(theYear, theMonth + 1, 0);
	var lastDateOfMonth = temporaryDate2.getDate();
	var dayCount = 1;
		
	for (var r=0; r<6; r++) {
		var tempDaysRow = theTable.tBodies[0].insertRow(r);
		tempDaysRow.className = 'dayrow';
		for (var c=0; c<7; c++) {
			var tempDaysCell = tempDaysRow.insertCell(c);
			var mysteryNode;
			if ((r > 0 || c >= startDayOfWeek) && dayCount <= lastDateOfMonth) {
				tempDaysCell.className = 'yestext';
				var mysteryNode = document.createElement('a');
				mysteryNode.href = '#';
				this.setCalendarClick(mysteryNode, this.txtObj, theYear, theMonth, dayCount);
				mysteryNode.appendChild(document.createTextNode(dayCount));
				dayCount++;
			} else {
				tempDaysCell.className = 'notext';
				mysteryNode = document.createTextNode('');
			}
			tempDaysCell.appendChild(mysteryNode);
		}
	}
	
	return theTable;
}
CalendarDisplay.prototype.setCalendarClick = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {fillInFields(theObj, theYear, (theMonth + 1), theDay); return false;}
}
CalendarDisplay.prototype.setCalendarPrevious = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showPrevious(theObj, theYear, theMonth, theDay); return false;}
}
CalendarDisplay.prototype.setCalendarNext = function (node, theObj, theYear, theMonth, theDay) {
	node.onclick = function() {showNext(theObj, theYear, theMonth, theDay); return false;}
}
	


CalendarDisplay.prototype.findPosX = function(obj) {
	var curleft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	}
	else if (obj.x) {
		curleft += obj.x;
	}
	return curleft;
}


CalendarDisplay.prototype.findPosY = function(obj) {
	var curtop = 0;
	if (obj.offsetParent)	{
		while (obj.offsetParent) {
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	}
	else if (obj.y) {
		curtop += obj.y;
	}
	return curtop;
}

function fillInFields(obj, year, month, day)
{
	obj.value = (month < 10 ? '0'+month : month) + '/' + (day < 10 ? '0'+day : day) + '/' + year;
	cObj = obj.myCalendar;
	cObj.toggle();
}

function showPrevious(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var lastMonth = new Date(year, month - 1, day)
	cObj.fillCalendar(lastMonth);
}
function showNext(obj, year, month, day)
{
	cObj = obj.myCalendar;
	var nextMonth = new Date(year, month + 1, day)
	cObj.fillCalendar(nextMonth);
}












// CALANDER ===============================================================

var oldLink = null;
// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}

function showFlatCalendar() {
  var parent = document.getElementById("display");

  // construct a calendar giving only the "selected" handler.
  var cal = new Calendar(0, null, flatSelected);

  // hide week numbers
  cal.weekNumbers = false;

  // We want some dates to be disabled; see function isDisabled above
  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  // this call must be the last as it might use data initialized above; if
  // we specify a parent, as opposite to the "showCalendar" function above,
  // then we create a flat calendar -- not popup.  Hidden, though, but...
  cal.create(parent);

  // ... we can show it here.
  cal.show();
}
