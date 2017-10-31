var xmlHttp =[];
var pub_loop=0;
var pub_loop_length=0;

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
	var tbl = document.getElementById(this.id);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		
		
		
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
		else tbl.rows[i].className="bcgcolor-tblrowWhite";		
	}
	
}


function viewIOU()
{
	var custimerid=document.getElementById("cmbCustomer").value;
	
	
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=function()
		{	
			if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
						 { 
					
					
								
									var XMLIOUNo		= xmlHttp[0].responseXML.getElementsByTagName('IOUNo');
									var XMLRTotAmt		= xmlHttp[0].responseXML.getElementsByTagName('amount');
									
									var tblioulst		= document.getElementById('tblIOUlist');
									var no	=1;
									
							deleterows('tblIOUlist');			
							deleterows('tbliouadvance');	
							for(var loop=0;loop<XMLIOUNo.length;loop++)
								{
									var lastRow 		= tblioulst.rows.length;	
									var row 			= tblioulst.insertRow(lastRow);
									
									row.className ="bcgcolor-tblrowWhite";			
									row.id='tblIOUlist';
									row.onclick	= rowclickColorChangetbl;
																	
									var rowCell = row.insertCell(0);
									rowCell.className ="normalfnt";
									rowCell.height="18";
									rowCell.innerHTML =XMLIOUNo[loop].childNodes[0].nodeValue;
									
									var rowCell = row.insertCell(1);
									rowCell.className ="normalfntRite";			
									rowCell.innerHTML =XMLRTotAmt[loop].childNodes[0].nodeValue;
									
								
																																					
									no++;
								}
								
					}
		
											
				 }				
		
		xmlHttp[0].open("GET",'advanceallocationdb.php?request=getData&customerid='+custimerid,true);
		xmlHttp[0].send(null);	
	
}

function addtogrid()
{
	var tbl=document.getElementById("tblIOUlist");
	var tbliouadvance=document.getElementById("tbliouadvance");
	for ( var i = 1; i < tbl.rows.length; i ++)
	{		
		if(tbl.rows[i].className =="bcgcolor-highlighted" && i<tbl.rows.length)
		{
			
			
			 						var lastRow 		= tbliouadvance.rows.length;	
									var rowadv 			= tbliouadvance.insertRow(lastRow);
									
									rowadv.id='tbliouadvance';
									rowadv.className ="bcgcolor-tblrowWhite";			
									
									rowadv.onclick	= rowclickColorChangetbl;
																	
									var rowCelladv = rowadv.insertCell(0);
									rowCelladv.className ="normalfnt";
									rowCelladv.height="18";
									rowCelladv.innerHTML =tbl.rows[i].cells[0].childNodes[0].nodeValue;
									
									var rowCelladv = rowadv.insertCell(1);
									rowCelladv.className ="normalfntRite";			
									rowCelladv.innerHTML ="<input name=\"txtCommodity3\" type=\"text\"class=\"txtbox\"id=\"txtCommodity3\"onblur=\"setBalance(this);\"style=\"width:100px; text-align:right;\"maxlength=\"20\"onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\"0\"/>";
										if(i<tbl.rows.length-1)
											tbl.rows[i+1].className ="bcgcolor-highlighted";
										else if(i>1)
											tbl.rows[i-1].className ="bcgcolor-highlighted";
								    tbl.deleteRow(i);		
		}
	}
}

function setbalance()
{
	document.getElementById("txtBalance").value=document.getElementById("txtAmount").value;	
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
	document.getElementById("txtAmount").disabled=false;
	document.getElementById("cellsave").innerHTML="<img src=\"../../../images/save-confirm.png\"alt=\"save\"width=\"174\"height=\"24\"class=\"mouseover\"onclick=\"saveReceiptHeader();\"/>";
	deleterows('tblIOUlist');			
	deleterows('tbliouadvance');			
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
	xmlHttp[8].open("GET","advanceallocationdb.php?request=newNo",true);
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
	var rcptSerial=document.getElementById("txtSerialNo").value;
	if (validateForm())
	{		
			document.getElementById("cellsave").innerHTML="<img src=\"../../../images/save-confirm_fade.png\"/>";
			showBackGroundBalck();	
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
			xmlHttp[9].open("GET","advanceallocationdb.php?request=saveHeader&rcptdate="+rcptdate+'&balance='+balance+'&type='+type+'&bank='+bank+'&chequerefno='+chequerefno+'&customer='+customer+'&amount='+amount+'&rcptSerial='+rcptSerial,true);
			xmlHttp[9].send(null);	
	}
}

function validateForm()
{
	if(document.getElementById("cmbCustomer").value=="" ){
		alert("Please select a customer.");
		document.getElementById("cmbCustomer").focus();
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

function saveReceiptDetail()
{ 
	var tbl=document.getElementById("tbliouadvance"); 
	var length=tbl.rows.length;
	
	
	
	for(var loop=1; loop<length; loop++)
	{
				
		
		var receiptSerialNo=document.getElementById("txtSerialNo").value;
		var received=tbl.rows[loop].cells[1].childNodes[0].value;
		var iouno=tbl.rows[loop].cells[0].childNodes[0].nodeValue;
			if(received!="" && parseFloat(received)>0){
						createNewXMLHttpRequest(9);
						pub_loop_length++;
						xmlHttp[9].onreadystatechange=function()
						{
							if(xmlHttp[9].readyState==4 && xmlHttp[9].status==200)
								{
									
										
								}
							
						}	
						xmlHttp[9].open("GET","advanceallocationdb.php?request=saveDetails&receiptSerialNo="+receiptSerialNo+'&received='+received+'&iouno='+iouno,true);
						xmlHttp[9].send(null);			
			}
		
	}			
	
	hideBackGroundBalck();										
	alert("Successfully saved!");
	var customer=document.getElementById("cmbCustomer").value;
	
	//newTransactionNo();
}	

function backtolist()
{
	var tbl=document.getElementById("tbliouadvance");
	var tbliouadvance=document.getElementById("tblIOUlist");
	for ( var i = 1; i < tbl.rows.length; i ++)
	{		
		if(tbl.rows[i].className =="bcgcolor-highlighted" && i<tbl.rows.length)
		{
			
			
			 						var lastRow 		= tbliouadvance.rows.length;	
									var rowadv 			= tbliouadvance.insertRow(lastRow);
									
									rowadv.id='tblIOUlist';
									rowadv.className ="bcgcolor-tblrowWhite";			
									
									rowadv.onclick	= rowclickColorChangetbl;
																	
									var rowCelladv = rowadv.insertCell(0);
									rowCelladv.className ="normalfnt";
									rowCelladv.height="18";
									rowCelladv.innerHTML =tbl.rows[i].cells[0].childNodes[0].nodeValue;
									
									var rowCelladv = rowadv.insertCell(1);
									rowCelladv.className ="normalfntRite";			
									rowCelladv.innerHTML =tbl.rows[i].cells[1].childNodes[0].value;
									if(tbl.rows[i].cells[1].childNodes[0].value!="")
									document.getElementById("txtBalance").value=parseFloat(document.getElementById("txtBalance").value)+parseFloat(tbl.rows[i].cells[1].childNodes[0].value);
									if(i<tbl.rows.length-1)
											tbl.rows[i+1].className ="bcgcolor-highlighted";
										else if(i>1)
											tbl.rows[i-1].className ="bcgcolor-highlighted";
								    tbl.deleteRow(i);			
		}
	}
}

function setBalance(dz)
{
	if(document.getElementById("txtBalance").value!="" && parseFloat(document.getElementById("txtBalance").value)>0)
	{	
			document.getElementById("txtAmount").disabled=true;
			document.getElementById("txtBalance").value=parseFloat(document.getElementById("txtBalance").value)-parseFloat(dz.value);
		
	}
}

function printForm()
{
	var serial_no=document.getElementById("txtSerialNo").value;
	window.open('receipt.php?serial_no='+serial_no,'r');	
}