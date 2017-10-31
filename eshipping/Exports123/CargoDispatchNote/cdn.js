var xmlHttp =[];

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


function viewCDN()
{
//alert ("pass");

if (document.getElementById("cboInvoice").value!="" )
	{
	var invoiceno=document.getElementById("cboInvoice").value;
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=setInvoiceDetail;
	xmlHttp[0].open("GET",'cdndb.php?REQUEST=getInvoice&invoiceno=' + invoiceno,true);
	xmlHttp[0].send(null);
	/*var invoiceno=document.getElementById("cboInvoice").value;
	createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=setCDNdetail;
	xmlHttp[1].open("GET",'cdndb.php?REQUEST=getCDN&invoiceno=' + invoiceno,true);
	xmlHttp[1].send(null);*/
	}
	else
		ClearForm()

}

function setInvoiceDetail()
{
		if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)
		{
			//alert(xmlHttp[0].responseText);
			
			document.getElementById("txtDate").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;	
			document.getElementById("txtDate").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;	
			//document.getElementById("txtShipper").value=xmlHttp[0].responseXML.getElementsByTagName("customername")[0].childNodes[0].nodeValue;
			//document.getElementById("txtConsignee").value=xmlHttp[0].responseXML.getElementsByTagName("buyername")[0].childNodes[0].nodeValue;
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;
			document.getElementById("txtVoyage").value=xmlHttp[0].responseXML.getElementsByTagName("VoyegeNo")[0].childNodes[0].nodeValue;
			document.getElementById("txtVoyegeDate").value=xmlHttp[0].responseXML.getElementsByTagName("SailingDate")[0].childNodes[0].nodeValue;
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;
			document.getElementById("txtDischarge").value=xmlHttp[0].responseXML.getElementsByTagName("FinalDest")[0].childNodes[0].nodeValue;	
			document.getElementById("txtLorry").value=xmlHttp[0].responseXML.getElementsByTagName("LorryNo")[0].childNodes[0].nodeValue;	
			document.getElementById("txtBL").value=xmlHttp[0].responseXML.getElementsByTagName("BLNo")[0].childNodes[0].nodeValue;	
			document.getElementById("txtTareWt").value=xmlHttp[0].responseXML.getElementsByTagName("TareWt")[0].childNodes[0].nodeValue;	
			document.getElementById("txtSeal").value=xmlHttp[0].responseXML.getElementsByTagName("SealNo")[0].childNodes[0].nodeValue;	
			document.getElementById("txtCustomerEntry").value=xmlHttp[0].responseXML.getElementsByTagName("CustomerEntry")[0].childNodes[0].nodeValue;	
			document.getElementById("txtDeclarent").value=xmlHttp[0].responseXML.getElementsByTagName("DeclarentName")[0].childNodes[0].nodeValue;	
			document.getElementById("txtDriver").value=xmlHttp[0].responseXML.getElementsByTagName("DriverName")[0].childNodes[0].nodeValue;	
			document.getElementById("txtCleaner").value=xmlHttp[0].responseXML.getElementsByTagName("CleanerName")[0].childNodes[0].nodeValue;	
			document.getElementById("txtSignatroy").value=xmlHttp[0].responseXML.getElementsByTagName("strAuthorisedS")[0].childNodes[0].nodeValue;	
			document.getElementById("txtOthers").value=xmlHttp[0].responseXML.getElementsByTagName("Othres")[0].childNodes[0].nodeValue;	
			document.getElementById("txtGross").value=xmlHttp[0].responseXML.getElementsByTagName("GrossWt")[0].childNodes[0].nodeValue;	
			document.getElementById("txtTemperature").value=xmlHttp[0].responseXML.getElementsByTagName("Temperature")[0].childNodes[0].nodeValue;	
			document.getElementById("txtCBM").value=xmlHttp[0].responseXML.getElementsByTagName("CBM")[0].childNodes[0].nodeValue;	
			document.getElementById("txtDelivery").value=xmlHttp[0].responseXML.getElementsByTagName("Delivery")[0].childNodes[0].nodeValue;
			document.getElementById("txtCNT").value=xmlHttp[0].responseXML.getElementsByTagName("CNTOPRCode")[0].childNodes[0].nodeValue;	
			document.getElementById("txtVSLOPR").value=xmlHttp[0].responseXML.getElementsByTagName("VSLOPRCode")[0].childNodes[0].nodeValue;	
			document.getElementById("txtLength").value=xmlHttp[0].responseXML.getElementsByTagName("Length")[0].childNodes[0].nodeValue;	
			document.getElementById("txtHeight").value=xmlHttp[0].responseXML.getElementsByTagName("Hieght")[0].childNodes[0].nodeValue;	
			document.getElementById("txtType").value=xmlHttp[0].responseXML.getElementsByTagName("Type")[0].childNodes[0].nodeValue;
			document.getElementById("txtPlaceofReceipt").value=xmlHttp[0].responseXML.getElementsByTagName("Reciept")[0].childNodes[0].nodeValue;
			document.getElementById("txtRemarks").value=xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
			document.getElementById("txtShipper").options[document.getElementById("txtShipper").selectedIndex].text=xmlHttp[0].responseXML.getElementsByTagName("customername")[0].childNodes[0].nodeValue;
			document.getElementById("txtConsignee").options[document.getElementById("txtConsignee").selectedIndex].text=xmlHttp[0].responseXML.getElementsByTagName("buyername")[0].childNodes[0].nodeValue;
			document.getElementById("txtExVessel").value=xmlHttp[0].responseXML.getElementsByTagName("strExVesel")[0].childNodes[0].nodeValue;
			document.getElementById("txtNet").value=xmlHttp[0].responseXML.getElementsByTagName("NetWt")[0].childNodes[0].nodeValue;
		}
}


/*function setCDNdetail()
{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
		{
			alert(xmlHttp[1].responseText);
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;		
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;	
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;	
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;	
			document.getElementById("txtVessel").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;	
		}	
}*/




function saveCDN()
{
if (document.getElementById("cboInvoice").value!="" ){	
var invoiceno=document.getElementById("cboInvoice").value;
var lorry=document.getElementById("txtLorry").value;
var voyage=document.getElementById("txtVoyage").value;
var voyagedate=document.getElementById("txtVoyegeDate").value;
var seal=document.getElementById("txtSeal").value;
var customerEntry=document.getElementById("txtCustomerEntry").value;
var declarent=document.getElementById("txtDeclarent").value;
var driver=document.getElementById("txtDriver").value;
var cleaner=document.getElementById("txtCleaner").value;
var signatroy=document.getElementById("txtSignatroy").value;
var others=document.getElementById("txtOthers").value;
var gross=(document.getElementById("txtGross").value=="" ? 0:document.getElementById("txtGross").value);
var net=(document.getElementById("txtNet").value=="" ? 0:document.getElementById("txtNet").value);
var temperature=document.getElementById("txtTemperature").value;
var CBM=document.getElementById("txtCBM").value;
var delivery=document.getElementById("txtDelivery").value;
var txtCNT=document.getElementById("txtCNT").value;
var delivery=document.getElementById("txtDelivery").value;
var placeofReceipt=document.getElementById("txtPlaceofReceipt").value;
var height=(document.getElementById("txtHeight").value=="" ? 0:document.getElementById("txtHeight").value);
var length=(document.getElementById("txtLength").value=="" ? 0:document.getElementById("txtLength").value);
var discharge=document.getElementById("txtDischarge").value;
var type=document.getElementById("txtType").value;
var remarks=document.getElementById("txtRemarks").value;
var VSLOPR=document.getElementById("txtVSLOPR").value; 
var TareWt=(document.getElementById("txtTareWt").value=="" ? 0:document.getElementById("txtTareWt").value);
var BL=document.getElementById("txtBL").value;
var Vessel=document.getElementById("txtVessel").value;
var ExVessel=document.getElementById("txtExVessel").value;
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=editDB;
	xmlHttp[2].open("GET",'cdndb.php?REQUEST=editDB&invoiceno=' + invoiceno+ '&lorry='+lorry+ '&seal='+seal+ '&customerEntry='+customerEntry
	+ '&declarent='+declarent+ '&driver='+driver+ '&cleaner='+cleaner+ '&signatroy='+signatroy+ '&others='+others+ '&gross='+gross+ 
	'&temperature='+temperature	+ '&CBM='+CBM+ '&delivery='+delivery+ '&placeofReceipt='+placeofReceipt+ '&height='+height+ '&length='+length+ 
	'&type='+type+ '&remarks='+remarks+'&TareWt='+TareWt+'&txtCNT='+txtCNT+'&VSLOPR='+VSLOPR+'&BL='+BL+'&Vessel='+Vessel+'&voyage='+voyage+'&voyagedate='+voyagedate+'&discharge='+discharge+'&ExVessel='+ExVessel+'&net='+net,true);
	xmlHttp[2].send(null);
	
}

}


function editDB()
{
if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)
	{
		alert(xmlHttp[2].responseText) 
	}

}

function ClearForm()
{
	document.getElementById("txtDate").value="";
	document.getElementById("txtShipper").value="";
	document.getElementById("txtConsignee").value="";
	document.getElementById("txtVessel").value="";
	document.getElementById("txtVoyage").value="";
	document.getElementById("txtVessel").value="";
	document.getElementById("txtDischarge").value="";
	document.getElementById("txtLorry").value="";
	document.getElementById("txtBL").value="";
	document.getElementById("txtTareWt").value="";
	document.getElementById("cboInvoice").value="";
	document.getElementById("txtSeal").value="";
	document.getElementById("txtCustomerEntry").value="";
	document.getElementById("txtDeclarent").value="";
	document.getElementById("txtDriver").value="";
	document.getElementById("txtCleaner").value="";
	document.getElementById("txtSignatroy").value="";
	document.getElementById("txtOthers").value="";
	document.getElementById("txtGross").value="";
	document.getElementById("txtTemperature").value="";
	document.getElementById("txtCBM").value="";
	document.getElementById("txtDelivery").value="";
	document.getElementById("txtCNT").value="";
	document.getElementById("txtDelivery").value="";
	document.getElementById("txtPlaceofReceipt").value="";
	document.getElementById("txtHeight").value="";
	document.getElementById("txtLength").value="";
	document.getElementById("txtType").value="";
	document.getElementById("txtRemarks").value="";
	document.getElementById("txtVSLOPR").value="";
	document.getElementById("txtExVessel").value="";
	document.getElementById("txtNet").value="";
	document.getElementById("txtShipper").options[document.getElementById("txtShipper").selectedIndex].text="";
			document.getElementById("txtConsignee").options[document.getElementById("txtConsignee").selectedIndex].text="";
}

function printReport()
{
	if (document.getElementById("cboInvoice").value!="" )
	{
	var invoiceno=document.getElementById("cboInvoice").value;
	var newwindow=window.open('rptCDN.php?invoiceno='+invoiceno ,'name');
	if (window.focus) {newwindow.focus();}
	}
}


function viewDescription()
{

if (document.getElementById("cboInvoice").value!="" )
	{
	var invoiceno=document.getElementById("cboInvoice").value;
	var newwindow=window.open('listing.php?invoiceno='+invoiceno ,'name');
	if (window.focus) {newwindow.focus();}
	}
	
}

function getMarksNDesc()
{
	
	
	
		if (document.getElementById("cboInvoice").value!="" )
	{
		
		var invoiceno=document.getElementById("cboInvoice").value;
		createNewXMLHttpRequest(13);
		xmlHttp[13].onreadystatechange=function()
		{
			if(xmlHttp[13].readyState==4 && xmlHttp[13].status==200)
			{
				
				document.getElementById("txtDescarea").value=xmlHttp[13].responseXML.getElementsByTagName("genDesc")[0].childNodes[0].nodeValue;	
				document.getElementById("txtMarksnnosarea").value=xmlHttp[13].responseXML.getElementsByTagName("marksNos")[0].childNodes[0].nodeValue;	
			
			}
			
		}		
		xmlHttp[13].open("GET",'cdndb.php?REQUEST=getMrksDSC&invoiceno=' + invoiceno,true);
		xmlHttp[13].send(null);	
	}
	
}


function saveMarksDesc()
{
	
	if (document.getElementById("cboInvoice").value!="" )
	{
			var desc=URLEncode(document.getElementById("txtDescarea").value);
			var marks=	URLEncode(document.getElementById("txtMarksnnosarea").value);
			var invoiceno=URLEncode(document.getElementById("cboInvoice").value);
		createNewXMLHttpRequest(14);
		xmlHttp[14].onreadystatechange=function()
		{
			if(xmlHttp[14].readyState==4 && xmlHttp[14].status==200)
			{
				
				alert(xmlHttp[14].responseText); 
			
			}
			
		}		
		xmlHttp[14].open("GET",'cdndb.php?REQUEST=updateMrksDSC&invoiceno=' + invoiceno+ '&desc='+desc+ '&marks='+marks,true);
		xmlHttp[14].send(null);	
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

function rowclickColorChangeIou2()
{	
	var rowIndex = this.rowIndex;
	
	
	var tbl = document.getElementById('tblDescription_po');
	
	
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow mouseover";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite mouseover";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted mouseover";
	}
	
}

function load_po_desc()
{
	if (document.getElementById("cboInvoice").value=="" )
	return false;
	
	
		var invoiceno=URLEncode(document.getElementById("cboInvoice").value);
		createNewXMLHttpRequest(15);
		deleterows("tblDescription_po");
		xmlHttp[15].onreadystatechange=function()
		{
			if(xmlHttp[15].readyState==4 && xmlHttp[15].status==200)
			{
				var tbl =document.getElementById("tblDescription_po");
				var InvoiceNo=xmlHttp[15].responseXML.getElementsByTagName('InvoiceNo');
				var BuyerPONo=xmlHttp[15].responseXML.getElementsByTagName('BuyerPONo');
				var ISDno=xmlHttp[15].responseXML.getElementsByTagName('ISDno');
				var DescOfGoods=xmlHttp[15].responseXML.getElementsByTagName('DescOfGoods');
				var ctns=xmlHttp[15].responseXML.getElementsByTagName('ctns');
				var PCS=xmlHttp[15].responseXML.getElementsByTagName('PCS');
				var NetMass=xmlHttp[15].responseXML.getElementsByTagName('NetMass');
				var GrossMass=xmlHttp[15].responseXML.getElementsByTagName('GrossMass');
				var CBM=xmlHttp[15].responseXML.getElementsByTagName('CBM');
				for(var loop=0;loop<InvoiceNo.length;loop++)				
				{
					
					var lastRow 		= tbl.rows.length;	
					var row 			= tbl.insertRow(lastRow);
					
					row.onclick	= rowclickColorChangeIou2;	
					//row.ondblclick	= edit_po_wise;	
					
					if(lastRow % 2 ==1)
						row.className ="bcgcolor-tblrow mouseover";
					else
						row.className ="bcgcolor-tblrowWhite mouseover";
					
							
					var rowCell = row.insertCell(0);
					rowCell.className ="normalfntMid";
					rowCell.height='20';
					rowCell.innerHTML = "<img src=\"../../images/folder_green_printer.png\" alt=\"del\" width=\"30\" height=\"30\" onclick=\"print_po_wise_cdn(this);\"id=\""+BuyerPONo[loop].childNodes[0].nodeValue;+"\"/>";	
					
					var rowCell = row.insertCell(1);
					rowCell.innerHTML =BuyerPONo[loop].childNodes[0].nodeValue;		
					
					var rowCell = row.insertCell(2);
					rowCell.innerHTML =ISDno[loop].childNodes[0].nodeValue;		
					
					var rowCell = row.insertCell(3);
					rowCell.innerHTML =DescOfGoods[loop].childNodes[0].nodeValue;	
					
					var rowCell = row.insertCell(4);
					rowCell.className ="normalfntMid";
					rowCell.innerHTML ="<input type=\"text\"class=\"txtbox\"maxlength=\"10\"style=\"text-align:right;width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+ctns[loop].childNodes[0].nodeValue;+"\"/>";	
					
					var rowCell = row.insertCell(5);
					rowCell.className ="normalfntMid";
					rowCell.innerHTML ="<input type=\"text\"class=\"txtbox\"maxlength=\"10\"style=\"text-align:right;width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+PCS[loop].childNodes[0].nodeValue;+"\"/>";	
					
					var rowCell = row.insertCell(6);
					rowCell.className ="normalfntMid";
					rowCell.innerHTML ="<input type=\"text\"class=\"txtbox\"maxlength=\"10\"style=\"text-align:right;width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+NetMass[loop].childNodes[0].nodeValue;+"\"/>";	
					
					var rowCell = row.insertCell(7);
					rowCell.className ="normalfntMid";
					rowCell.innerHTML ="<input type=\"text\"class=\"txtbox\"maxlength=\"10\"style=\"text-align:right;width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+GrossMass[loop].childNodes[0].nodeValue;+"\"/>";	
					
					var rowCell = row.insertCell(8);
					rowCell.className ="normalfntMid";
					rowCell.innerHTML ="<input type=\"text\"class=\"txtbox\"maxlength=\"10\"style=\"text-align:right;width:80px;\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\"value=\""+CBM[loop].childNodes[0].nodeValue;+"\"/>";	
				}
			
			}
			
		}		
		xmlHttp[15].open("GET",'cdndb.php?REQUEST=load_po_desc&invoiceno=' + invoiceno,true);
		xmlHttp[15].send(null);	
	
}

function save_po_wise_cdn()
{	showBackGroundBalck();
	if (document.getElementById("cboInvoice").value=="" )
	return false;
	createNewXMLHttpRequest(69);
	var InvoiceNo=document.getElementById("cboInvoice").value
	xmlHttp[69].onreadystatechange=function()
		{			
			if(xmlHttp[69].readyState==4 && xmlHttp[69].status==200)
				{	
					save_to_db_cdn();
					
				}				
		}
	xmlHttp[69].open("GET",'cdndb.php?REQUEST=delete_po_wise_cdn&InvoiceNo=' + InvoiceNo  ,true);
	xmlHttp[69].send(null);	
}

function save_to_db_cdn()
{

	
	
	var InvoiceNo=document.getElementById("cboInvoice").value
	var tbl=document.getElementById("tblDescription_po");
	
	for(var loop=1;loop<tbl.rows.length;loop++)
	{	
		var row				=tbl.rows[loop];
		var BuyerPONo		=row.cells[1].childNodes[0].nodeValue;
		var ISDno			=row.cells[2].childNodes[0].nodeValue;
		var DescOfGoods		=row.cells[3].childNodes[0].nodeValue;
		var ctns			=row.cells[4].childNodes[0].value;
		var PCS				=row.cells[5].childNodes[0].value;
		var NetMass			=row.cells[6].childNodes[0].value;
		var GrossMass		=row.cells[7].childNodes[0].value;
		var CBM				=row.cells[8].childNodes[0].value;
		createNewXMLHttpRequest(71);
		xmlHttp[71].onreadystatechange=function()
		{
			
			
		if(xmlHttp[71].readyState==4 && xmlHttp[71].status==200)
			{	
			
				
			}	
			
		}
		xmlHttp[71].open("GET",'cdndb.php?REQUEST=save_to_db_cdn&InvoiceNo=' + InvoiceNo + '&BuyerPONo=' +BuyerPONo+ '&ISDno=' +ISDno+ '&ctns=' +ctns+ '&PCS=' +PCS+ '&NetMass=' +NetMass+ '&GrossMass=' +GrossMass+ '&CBM=' +CBM,true);
		xmlHttp[71].send(null);
	}
	alert("Successfully saved.");
	hideBackGroundBalck();
}

function print_po_wise_cdn(obj)
{
	if (document.getElementById("cboInvoice").value!="" )
	{
		var invoiceno=document.getElementById("cboInvoice").value;
		var newwindow=window.open('rpt_cdn_orit.php?invoiceno='+invoiceno+'&pono='+obj.id ,'name');
		if (window.focus) {newwindow.focus();}
	}
}