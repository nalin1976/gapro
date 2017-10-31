var xmlHttp =[];
var current_node="";
var current_iouino="";
var current_payable=0;
var current_allocated=0;
var current_received=0;

var pub_loop_length=0;
var pub_loop=0;
function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}


function viewReceipt()
{
	var custimerid=document.getElementById("cmbCustomer").value;
	//alert(custimerid);
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=function()
		{	
			if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
						 { 
					
					//alert(xmlHttp[0].responseText);
									var XMLInvoiceNo	= xmlHttp[0].responseXML.getElementsByTagName('InvoiceNo');
									var XMLIOUNo		= xmlHttp[0].responseXML.getElementsByTagName('IOUNo');
									var XMLCustomerID	= xmlHttp[0].responseXML.getElementsByTagName('CustomerID');
									var XMLidate		= xmlHttp[0].responseXML.getElementsByTagName('idate');
									var XMLSerialNo		= xmlHttp[0].responseXML.getElementsByTagName('SerialNo');
									var XMLRTotAmt		= xmlHttp[0].responseXML.getElementsByTagName('RTotAmt');
									var XMLPayableAmt	= xmlHttp[0].responseXML.getElementsByTagName('PayableAmt');
									var XMLTotalAmount	= xmlHttp[0].responseXML.getElementsByTagName('TotalAmount');
									var XMLAdvanceAllo	= xmlHttp[0].responseXML.getElementsByTagName('AdvanceAllo');
									var XMLreceived		= xmlHttp[0].responseXML.getElementsByTagName('received');
									var tblReceipt		= document.getElementById('tblReceipt');
									var no	=1;
									
									deleterows('tblReceipt');			
					
							for(var loop=0;loop<XMLInvoiceNo.length;loop++)
								{
									var lastRow 		= tblReceipt.rows.length;	
									var row 			= tblReceipt.insertRow(lastRow);
									
									row.className ="bcgcolor-tblrowWhite";			
									
									row.onclick	= rowclickColorChangetbl;
									
									
									var rowCell = row.insertCell(0);
									rowCell.className ="normalfntMid";			
									rowCell.id=XMLCustomerID[loop].childNodes[0].nodeValue;
									rowCell.height=20;
									if(parseFloat(XMLPayableAmt[loop].childNodes[0].nodeValue)>0) 
									rowCell.innerHTML ="<input type=\"checkbox\"class=\"txtbox\"value=\"hh\"onchange=\"includeinvoice(this);\"/>" ;
									else
									rowCell.innerHTML ="<img src=\"../../../images/eok.png\"/>";
									
									var rowCell = row.insertCell(1);
									rowCell.className ="normalfntMid";			
									rowCell.innerHTML =XMLInvoiceNo[loop].childNodes[0].nodeValue;
									
									var rowCell = row.insertCell(2);
									rowCell.className ="normalfntMid";			
									rowCell.innerHTML =XMLIOUNo[loop].childNodes[0].nodeValue;
									
									var rowCell = row.insertCell(3);
									rowCell.className ="normalfntMid";			
									rowCell.innerHTML =XMLidate[loop].childNodes[0].nodeValue;
									
									
									var rowCell = row.insertCell(4);
									rowCell.className ="normalfntMid";			
									rowCell.innerHTML =XMLAdvanceAllo[loop].childNodes[0].nodeValue;
									
									
									var rowCell = row.insertCell(5);
									rowCell.className ="normalfntMid";			
									rowCell.innerHTML =XMLTotalAmount[loop].childNodes[0].nodeValue;
									
									
									var rowCell = row.insertCell(6);
									rowCell.className ="normalfntMid";			
									rowCell.id=XMLCustomerID[loop].childNodes[0].nodeValue;
									rowCell.innerHTML =XMLPayableAmt[loop].childNodes[0].nodeValue;
									
									
									var rowCell = row.insertCell(7);
									rowCell.className ="normalfntMid";			
									rowCell.innerHTML ="<input name=\"txtCommodity3\" type=\"text\"class=\"txtbox\"id=\"txtCommodity3\"style=\"width:100px; text-align:right;\"maxlength=\"20\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+ XMLreceived[loop].childNodes[0].nodeValue+"\"/>";
									
																																					
									no++;
								}
								
					}
		
											
				 }				
		
		xmlHttp[0].open("GET",'customerreceiptdb.php?request=getData&customerid='+custimerid,true);
		xmlHttp[0].send(null);	
	
}


function	deleterows(tableName)
	{	
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
		{
			 tbl.deleteRow(loop);
		}		
	
	}	

function rowclickColorChangetbl()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblReceipt');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		
		
		
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
		else tbl.rows[i].className="bcgcolor-tblrowWhite";		
	}
	
}


function payAdvance(nod)
{
	var invoiceno=nod.parentNode.parentNode.childNodes[0].childNodes[0].nodeValue;
	var payable=nod.parentNode.parentNode.childNodes[7].childNodes[0].nodeValue;
	current_iouino=invoiceno;
	
	current_node=nod;
	//alert(payable);
	//var customerid=nod.parentNode.parentNode.childNodes[0].id;
	var customerid=document.getElementById("cmbCustomer").value;
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
		{	
			if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
				{
					drawPopupArea(580,200,'frmNewOrganize');
					document.getElementById('frmNewOrganize').innerHTML=xmlHttp[1].responseText;
				}
		}
	xmlHttp[1].open("GET",'popAdvancePay.php?customerid='+customerid+'&invoiceno='+invoiceno+'&payable='+payable,true);
	xmlHttp[1].send(null);	
}


function doPay(nodPay)
{
	var invoiceno=nodPay.parentNode.parentNode.childNodes[0].childNodes[0].nodeValue;
	var customerid=nodPay.parentNode.parentNode.childNodes[0].id;
	var payable=nodPay.parentNode.parentNode.childNodes[7].childNodes[0].nodeValue;
	current_node=nodPay;
	current_iouino=nodPay.parentNode.parentNode.childNodes[0].childNodes[0].nodeValue;
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=function()
		{	
			if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)
				{
					drawPopupArea(300,120,'frmNewOrganize');
					document.getElementById('frmNewOrganize').innerHTML=xmlHttp[2].responseText;
				}
		}
	xmlHttp[2].open("GET",'popPay.php?customerid='+customerid+'&invoiceno='+invoiceno+'&payable='+parseFloat(payable,2),true);
	xmlHttp[2].send(null);	
	
}


function newAdvance()
{
	var customerid=document.getElementById("cmbCustomer").value;
	createNewXMLHttpRequest(3);
	xmlHttp[3].onreadystatechange=function()
		{	
			if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200)
				{
					drawPopupArea(600,289,'frmNewOrganize');
					document.getElementById('frmNewOrganize').innerHTML=xmlHttp[3].responseText;
				}
		}
	xmlHttp[3].open("GET",'CustomerAdvancePay.php?customerid='+customerid,true);
	xmlHttp[3].send(null);	
	
}

function saveAdvanceReceived()
{
	var customerid=document.getElementById("cmbCustomer").value;
	var Amount=document.getElementById("txtAmount").value;
	var Description=document.getElementById("txtDescription").value;
	createNewXMLHttpRequest(4);
	xmlHttp[4].onreadystatechange=function()
		{	
			if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
				{
					
					alert(xmlHttp[4].responseText);
					closeWindow();
					newAdvance();
					
				}
		}
	xmlHttp[4].open("GET",'customerreceiptdb.php?request=saveReceipt&customerid='+customerid+'&Amount='+Amount+'&Description='+Description,true);
	xmlHttp[4].send(null);	
	
}

function saveAdvanceAllocation(nod)
{
	
	var advserialno=nod.parentNode.parentNode.parentNode.childNodes[1].childNodes[0].nodeValue;
	var date=nod.parentNode.parentNode.parentNode.childNodes[3].childNodes[0].nodeValue;
	var amount=nod.parentNode.parentNode.parentNode.childNodes[5].childNodes[0].nodeValue;	
	var amtallocated=nod.parentNode.parentNode.parentNode.childNodes[7].childNodes[0].nodeValue;
	var allocatingamt=parseFloat(nod.parentNode.parentNode.parentNode.childNodes[9].childNodes[0].value);
	var payable=parseFloat(document.getElementById("txtPendingPayable").value);
	
	var customerid=document.getElementById("cmbCustomer").value;
	if(allocatingamt>=payable)
		allocatingamt=payable;
	//allocatingamt=document.getElementById("txtPendingPayable").value;
	
	createNewXMLHttpRequest(5);
	xmlHttp[5].onreadystatechange=function()
		{	
			if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
				{
								
					current_node.parentNode.parentNode.childNodes[7].childNodes[0].nodeValue=payable-allocatingamt;
					current_node.parentNode.parentNode.childNodes[3].childNodes[0].nodeValue=parseFloat(current_node.parentNode.parentNode.childNodes[3].childNodes[0].nodeValue)+allocatingamt;
					current_node.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue=parseFloat(current_node.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue)+allocatingamt;
					//alert(xmlHttp[5].responseText);
					closeWindow();
					payAdvance(current_node);
					window.open('cstReceipt.php?customerid='+customerid+'&advserialno='+advserialno+'&date='+date+'&amount='+amount+'&amtallocated='+amtallocated+'&allocatingamt='+allocatingamt+'&invoiceno='+current_iouino);
					
					
				}
		}
	xmlHttp[5].open("GET",'customerreceiptdb.php?request=saveAdvanceAllocation&customerid='+customerid+'&advserialno='+parseFloat(advserialno)+'&date='+date+'&amount='+amount+'&amtallocated='+amtallocated+'&allocatingamt='+allocatingamt+'&invoiceno='+current_iouino,true);
	xmlHttp[5].send(null);	
}

function funkAlert(nod)
{
	var allocatingamt=parseFloat(nod.parentNode.parentNode.childNodes[9].childNodes[0].value);
	var amtallocated=parseFloat(nod.parentNode.parentNode.childNodes[7].childNodes[0].nodeValue);
	var amount=parseFloat(nod.parentNode.parentNode.childNodes[5].childNodes[0].nodeValue);

	if (allocatingamt>=amount-amtallocated){
		nod.parentNode.parentNode.childNodes[9].childNodes[0].value=amount-amtallocated;
	alert("Sorry, you cannot exeed the remaining amount");
	}
}

function savePay()
{
	
	createNewXMLHttpRequest(7);
	var directReceive=parseFloat(document.getElementById("txtDirectReceive").value);
	var payable=parseFloat(document.getElementById("txtDirPayable").value);
	var customerid=document.getElementById("cmbCustomer").value;											   
	if(directReceive>payable)
	{
		directReceive=payable;		
	}
	xmlHttp[7].onreadystatechange=function()
		{	
			if(xmlHttp[7].readyState==4 && xmlHttp[7].status==200)
				{
					current_node.parentNode.parentNode.childNodes[7].childNodes[0].nodeValue=payable-directReceive;
					current_node.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue=parseFloat(current_node.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue)+directReceive;
					closeWindow();
					doPay(current_node);
					window.open('cstReceipt.php?customerid='+customerid+'&allocatingamt='+directReceive+'&invoiceno='+current_iouino);
					
					
						
				}
		}
	xmlHttp[7].open("GET",'customerreceiptdb.php?request=saveDirectPay&directReceive='+directReceive+'&current_iouino='+current_iouino,true);
	xmlHttp[7].send(null);	

	
}


/*function funcCheckAmt()
{
	
	var directReceive=parseFloat(document.getElementById("txtDirectReceive").value;
	var payable=parseFloat(document.getElementById("txtDirPayable").value;
	if(directReceive>payable)
	{
			
		
	}

}*/

function setbalance()
{
	
	document.getElementById("txtBalance").value=document.getElementById("txtAmount").value;	
	
}

function includeinvoice(dz)
{	
	if(document.getElementById("txtAmount").value!=""&& document.getElementById("txtBalance").value>0)
		{
			document.getElementById("txtAmount").disabled=true;	
			if(dz.checked==true  )
			{	
			var bal=document.getElementById("txtBalance").value;
			document.getElementById("txtBalance").value=
			parseFloat(document.getElementById("txtBalance").value)-parseFloat(dz.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue);
				if(document.getElementById("txtBalance").value>=0){
						
						dz.parentNode.parentNode.childNodes[7].childNodes[0].value=dz.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue;
						dz.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue=
						parseFloat(dz.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue)-parseFloat(dz.parentNode.parentNode.childNodes[7].childNodes[0].value);
						}
				else{
				dz.parentNode.parentNode.childNodes[7].childNodes[0].value=bal;document.getElementById("txtBalance").value=0}
 			}
			 
	}
	else 
			dz.checked=false;
			
			if(dz.checked==false)
	{
	document.getElementById("txtBalance").value=parseFloat(document.getElementById("txtBalance").value)+parseFloat(dz.parentNode.parentNode.childNodes[7].childNodes[0].value);
	dz.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue=parseFloat(dz.parentNode.parentNode.childNodes[6].childNodes[0].nodeValue)+parseFloat(dz.parentNode.parentNode.childNodes[7].childNodes[0].value);
	dz.parentNode.parentNode.childNodes[7].childNodes[0].value="0";
	}
}


function  nwRcptFrm()
{
	
	document.getElementById("txtDate").value="";
	document.getElementById("txtBalance").value="0";
	document.getElementById("cmbType").value="";
	document.getElementById("cmbBank").value="";
	document.getElementById("txtChequeRefNo").value="";
	document.getElementById("cmbCustomer").value="";
	document.getElementById("txtAmount").value="";
	document.getElementById("txtCreditNote").value="";
	document.getElementById("txtAmount").disabled=false;
	document.getElementById("cellsave").innerHTML="<img src=\"../../../images/save-confirm.png\"alt=\"save\"width=\"174\"height=\"24\"class=\"mouseover\"onclick=\"saveReceiptHeader();\"/>";
	deleterows('tblReceipt');			
	newTransactionNo();
}


function newTransactionNo()
{
	createNewXMLHttpRequest(8);
	xmlHttp[8].onreadystatechange=function()
	{
		if(xmlHttp[8].readyState==4 && xmlHttp[8].status==200)
			{
				document.getElementById("txtSerialNo").value="CPR"+xmlHttp[8].responseText;
				
			}
		
	}	
	xmlHttp[8].open("GET","customerreceiptdb.php?request=newNo",true);
	xmlHttp[8].send(null);	
}


function saveReceiptHeader()
{
	var rcptdate=document.getElementById("txtDate").value;
	var balance=document.getElementById("txtBalance").value;
	var type=document.getElementById("cmbType").value;
	var bank=document.getElementById("cmbBank").value;
	var chequerefno=document.getElementById("txtChequeRefNo").value;
	var customer=document.getElementById("cmbCustomer").value;
	var amount=document.getElementById("txtAmount").value;
	var creditnote=document.getElementById("txtCreditNote").value;
	var rcptSerial=document.getElementById("txtSerialNo").value;
	if (validateForm())
	{		
			document.getElementById("cellsave").innerHTML="<img src=\"../../../images/save-confirm_fade.png\"/>";
			createNewXMLHttpRequest(9);
			xmlHttp[9].onreadystatechange=function()
					{
						if(xmlHttp[9].readyState==4 && xmlHttp[9].status==200)
							{
								if(xmlHttp[9].responseText!="")
								{
									saveReceiptDetail();
								
								}
							}
						
					}	
			xmlHttp[9].open("GET","customerreceiptdb.php?request=saveHeader&rcptdate="+rcptdate+'&balance='+balance+'&type='+type+'&bank='+bank+'&chequerefno='+chequerefno+'&customer='+customer+'&amount='+amount+'&creditnote='+creditnote+'&rcptSerial='+rcptSerial,true);
			xmlHttp[9].send(null);	
	}
}

function saveReceiptDetail()
{ 
	var tbl=document.getElementById("tblReceipt");
	var length=tbl.rows.length;
	showBackGroundBalck();	
	for(var loop=1; loop<length; loop++)
	{
		
		if(tbl.rows[loop].cells[0].childNodes[0].checked==true)
		{
			pub_loop_length++;
		var receiptSerialNo=document.getElementById("txtSerialNo").value;
		var received=tbl.rows[loop].cells[7].childNodes[0].value;
		var iouno=tbl.rows[loop].cells[2].childNodes[0].nodeValue;
		var iouinvoice=tbl.rows[loop].cells[1].childNodes[0].nodeValue;
						createNewXMLHttpRequest(9);
						xmlHttp[9].onreadystatechange=function()
						{
							if(xmlHttp[9].readyState==4 && xmlHttp[9].status==200)
								{
									pub_loop++;
									if(pub_loop==pub_loop_length){
										hideBackGroundBalck();
										pub_loop=0;
										pub_loop_length=0;
										alert("Saved successfully!");
											
										}
								}
							
						}	
						xmlHttp[9].open("GET","customerreceiptdb.php?request=saveDetails&receiptSerialNo="+receiptSerialNo+'&received='+received+'&iouno='+iouno+'&iouinvoice='+iouinvoice,true);
						xmlHttp[9].send(null);			
		
		}
}
}

function validateForm()
{
	if(document.getElementById("cmbType").value=="" ){
		alert("Please select the type.");
		document.getElementById("cmbType").focus();
		return false;
	}
	if(document.getElementById("cmbBank").value=="" ){
		alert("Please select a Bank.");
		document.getElementById("cmbBank").focus();
		return false;
	}
	
	if(document.getElementById("cmbCustomer").value=="" ){
		alert("Please select a customer.");
		document.getElementById("cmbCustomer").focus();
		return false;
	}
	if(document.getElementById("txtDate").value=="" ){
		alert("Date is empty.");
		document.getElementById("txtDate").focus();
		return false;
	}
	if(document.getElementById("txtChequeRefNo").value=="" ){
		alert("Please enter a cheque or referenceno.");
		document.getElementById("txtChequeRefNo").focus();
		return false;
	}
	if(document.getElementById("txtAmount").value=="" || document.getElementById("txtAmount").value==0){
		alert("Please enter the amount.");
		document.getElementById("txtAmount").focus();
		return false;
	}
	if(document.getElementById("txtBalance").value=="" || document.getElementById("txtBalance").value!=0 ){
		var continuesv=confirm("The balance amount is not zero, Do you want to continue?");
		if(continuesv)
		return true;
		else
		return false;
	}
	else 
		return true;
}

function printForm()
{
	var serial_no=document.getElementById("txtSerialNo").value;
	window.open('receipt.php?serial_no='+serial_no,'n');	
	
}