// JavaScript Document

var xmlHttp =[];
var position=0;
var count=0;

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



function filterInvoice()
{

//alert("filtered data");

}


function getInvoceData()
{
	if(document.getElementById("cboInvoiceNo").value!="")
	{
	var invoiceno=document.getElementById("cboInvoiceNo").value; 
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'commercialinvoiceDB.php?REQUEST=getData&invoiceno=' + invoiceno,true);
	xmlHttp[0].send(null);
	}
	else
	pageReload();
}

function getCustomerDetail()
{


}

/*
rdoGeneral
rdoDeclarent
rdoBOI
cboInvoiceNo
txtInvoiceDate
cboInvoiceType
txtInvoiceNo
cboShipper
cboBank
txtSaling
txtVoyageeNo
cboConsignee
txtLC
cboNotoify1
cboNotoify2
txtNoCartoons
txtCarrier
cboTransMode
txtUnitPrice
txtLoading
cboDestination
txtVoyageeNo
txtExchangeRate
txtSailing
txtUnitPrice
txtNoCartoons
*/

/*function setExchangeRates(rate)
{
document.getElementById("txtExchangeRate").value=rate;

}*/


function stateChanged()
{
if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)

{
//alert(xmlHttp[0].responseText);
document.getElementById("txtInvoiceDate").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;	
document.getElementById("txtInvoiceNo").disabled=true;
document.getElementById("txtInvoiceNo").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
document.getElementById("cboShipper").value=xmlHttp[0].responseXML.getElementsByTagName("CompanyID")[0].childNodes[0].nodeValue;
document.getElementById("cboConsignee").value=xmlHttp[0].responseXML.getElementsByTagName("BuyerID")[0].childNodes[0].nodeValue;
document.getElementById("cboNotoify1").value=xmlHttp[0].responseXML.getElementsByTagName("NotifyID1")[0].childNodes[0].nodeValue;
document.getElementById("cboNotoify2").value=xmlHttp[0].responseXML.getElementsByTagName("NotifyID2")[0].childNodes[0].nodeValue;
document.getElementById("txtLC").value=xmlHttp[0].responseXML.getElementsByTagName("LCNo")[0].childNodes[0].nodeValue;
document.getElementById("txtLcDate").value=xmlHttp[0].responseXML.getElementsByTagName("dtmLCDate")[0].childNodes[0].nodeValue;
document.getElementById("cboBank").value=xmlHttp[0].responseXML.getElementsByTagName("LCBankID")[0].childNodes[0].nodeValue;
document.getElementById("txtLoading").value=xmlHttp[0].responseXML.getElementsByTagName("PortOfLoading")[0].childNodes[0].nodeValue;
document.getElementById("txtCarrier").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;
document.getElementById("cboDestination").value=xmlHttp[0].responseXML.getElementsByTagName("FinalDest")[0].childNodes[0].nodeValue;
document.getElementById("txtVoyageeNo").value=xmlHttp[0].responseXML.getElementsByTagName("VoyegeNo")[0].childNodes[0].nodeValue;
//document.getElementById("cboCurrency").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text=xmlHttp[0].responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
//document.getElementById("txtUnitPrice").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtNoCartoons").value=xmlHttp[0].responseXML.getElementsByTagName("NoOfCartons")[0].childNodes[0].nodeValue;
//document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtDiscription").value=xmlHttp[0].responseXML.getElementsByTagName("GenDesc")[0].childNodes[0].nodeValue;
document.getElementById("txtSailing").value=xmlHttp[0].responseXML.getElementsByTagName("SailingDate")[0].childNodes[0].nodeValue;
document.getElementById("txtMarksofPKGS").value=xmlHttp[0].responseXML.getElementsByTagName("MarksAndNos")[0].childNodes[0].nodeValue;
document.getElementById("cboInvoiceType").value=1;

//document.getElementById("cboTransMode").value=xmlHttp[0].responseXML.getElementsByTagName("TransportMode")[0].childNodes[0].nodeValue;
//document.getElementById("cboTransMode").disabled=true;

//document.getElementById("cboUnit").disabled=true;
document.getElementById("txtInvoiceDetail").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
document.getElementById("cboSoldTo").value=xmlHttp[0].responseXML.getElementsByTagName("SoldTo")[0].childNodes[0].nodeValue;
}

}

function setRates()
{
//document
}


function validateForm()
{

if(document.getElementById("cboShipper").value=="")
{
alert("Please select a shipper.")
return false;
}

if(document.getElementById("cboConsignee").value=="")
{
alert("Please select a consignee.")
return false;
}


else
{
	return true;
}



} 


function saveData()
{
if(validateForm())
	{
	if (document.getElementById("cboInvoiceNo").value!="" )
		{	
		if(confirm("Do you realy want to update?")) 
		updateDB('update');
		}
	else 
		{		
		checkDB();
		}
	}
}



function pageReload()
{
setTimeout("location.reload(true)",100);
}

function clearForm()
{


}

function deleteInvoice()
{
if(document.getElementById("txtInvoiceNo").value=="")
{
	if(confirm("Are you sure you want to delete?")){
	var invoiceno=document.getElementById("cboInvoiceNo").value 
	createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=function()
	{
	if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)
		{
		}
	}
	xmlHttp[2].open("GET",'commercialinvoiceDB.php?REQUEST=deleteData&invoiceno=' + invoiceno,true);
	xmlHttp[2].send(null);
}
}
}


function checkDB()
{
	var invoiceno=document.getElementById("txtInvoiceNo").value; 
	//alert(invoiceno);	
	createNewXMLHttpRequest(3);
	
	xmlHttp[3].onreadystatechange=function()
	{
	if(xmlHttp[3].readyState==4 && xmlHttp[3].status==200)
		{
	//alert(xmlHttp[3].responseText);
		if (xmlHttp[3].responseText=='cant')
				{	
					//alert("Sorry! Invoice number already exist.");
					return false;	
				}
		else 
				{
					updateDB('insert');
				}
		}
	
	}
	xmlHttp[3].open("GET",'commercialinvoiceDB.php?REQUEST=checkDB&invoiceno=' + invoiceno,true);
	xmlHttp[3].send(null);

}


function updateDB(edit)
{

showPleaseWait();
var ofPKGS=document.getElementById("txtMarksofPKGS").value;
var number=document.getElementById("txtInvoiceNo").value;
var description=document.getElementById("txtDiscription").value;
var invoicedate=document.getElementById("txtInvoiceDate").value;
var shipper=document.getElementById("cboShipper").value;
var consignee=document.getElementById("cboConsignee").value;
var notify1=document.getElementById("cboNotoify1").value;
var notify2=document.getElementById("cboNotoify2").value;
var lc=document.getElementById("txtLC").value;
var lcdate=document.getElementById("txtLcDate").value;
var bank=document.getElementById("cboBank").value;
var loading=document.getElementById("txtLoading").value;
var carrier=document.getElementById("txtCarrier").value;
var destination=document.getElementById("cboDestination").value;
var voyageeno=document.getElementById("txtVoyageeNo").value;
var des=URLEncode(description);
var MarksofPKGS=URLEncode(ofPKGS);
var sailing=document.getElementById("txtSailing").value;
var SoldTo=document.getElementById("cboSoldTo").value;


if(edit){
createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
		if(xmlHttp[1].responseText!="Sorry,Operation Failed!")
		{
			if($("#txtInvoiceNo").val()=="")
			$("#txtInvoiceNo").val(xmlHttp[1].responseText)	
		alert("Successfully saved.");
		hidePleaseWait();
		}//pageReload();
		else
		{
			alert(xmlHttp[1].responseText);
			hidePleaseWait();
			
		}
	}
	}
	xmlHttp[1].open("GET",'commercialinvoiceDB.php?REQUEST=editDB&invoiceno=' + number+ '&description=' + des +
	'&invoicedate=' +invoicedate+ '&shipper='+ shipper + '&consignee=' +consignee+ '&notify1='+notify1+ '&notify2='+notify2+
	'&lc=' +lc+ '&lcdate=' +lcdate+ '&bank=' +bank+ '&loading=' +loading+ '&carrier=' +carrier+ '&destination=' +destination+
	'&voyageeno=' +voyageeno+ '&edit=' +edit+ '&sailing=' +sailing+ '&MarksofPKGS=' +MarksofPKGS+ '&SoldTo=' +SoldTo,true);
	xmlHttp[1].send(null);
}
}

function copyMarksNos()
{

		createNewXMLHttpRequest(15);
		xmlHttp[15].onreadystatechange=function()
		{	
			if(xmlHttp[15].readyState==4 && xmlHttp[15].status==200)
   		 {
        		
				drawPopupArea(320,185,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHttp[15].responseText;
				
			
		 }
			
		}
		xmlHttp[15].open("GET",'popupcopymarks.php?',true);
		xmlHttp[15].send(null);

	
}

function copyGeneralDesc()
{
createNewXMLHttpRequest(16);
		xmlHttp[16].onreadystatechange=function()
		{	
			if(xmlHttp[16].readyState==4 && xmlHttp[16].status==200)
   		 {
        		
				drawPopupArea(320,185,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHttp[16].responseText;
				
			
		 }
			
		}
		xmlHttp[16].open("GET",'popupGeneralDescription.php?',true);
		xmlHttp[16].send(null);	
	
}

function getMarksAndNos()
{
	if(document.getElementById("cboinvoicecopy").value!="")
	{
	var invoiceno=document.getElementById("cboinvoicecopy").value; 
	createNewXMLHttpRequest(17);
	xmlHttp[17].onreadystatechange=function()
		{	
			if(xmlHttp[17].readyState==4 && xmlHttp[17].status==200)
				{
						
					document.getElementById("txtMarkCopy").value=xmlHttp[17].responseXML.getElementsByTagName("MarksAndNos")[0].childNodes[0].nodeValue;
					
				}
		}
	xmlHttp[17].open("GET",'commercialinvoiceDB.php?REQUEST=getMarks&invoiceno=' + invoiceno,true);
	xmlHttp[17].send(null);
	}
	
	
}


function getGenDesc()
{
	if(document.getElementById("cboinvoicecopy").value!="")
	{
	var invoiceno=document.getElementById("cboinvoicecopy").value; 
	createNewXMLHttpRequest(18);
	xmlHttp[18].onreadystatechange=function()
		{	
			if(xmlHttp[18].readyState==4 && xmlHttp[18].status==200)
				{
						
					document.getElementById("txtDescCopy").value=xmlHttp[18].responseXML.getElementsByTagName("GenDesc")[0].childNodes[0].nodeValue;
					
				}
		}
	xmlHttp[18].open("GET",'commercialinvoiceDB.php?REQUEST=getgenDesc&invoiceno=' + invoiceno,true);
	xmlHttp[18].send(null);
	}
	
	
}

function setGenralDesc()
{
	document.getElementById("txtDiscription").value=document.getElementById("txtDescCopy").value;
	closeWindow();
	
	}

function setMarksAndNos()
{
	document.getElementById("txtMarksofPKGS").value=document.getElementById("txtMarkCopy").value;
	closeWindow();
	
}

function copy_invoice()
{
	var previous_invoice=$('#cboInvoiceNo').val();
	if(previous_invoice=="")
		return;
	if(!(confirm("Are you sure you want copy invoice?")))
		return
		//	newinvoice=prompt("Please enter a invoice number.");
	//alert(newinvoice);
	//return	
	
	var url				="commercialinvoiceDB.php?REQUEST=copy_inv&previous_invoice="+previous_invoice;
	var xmlhttpobj=$.ajax({url:url,async:false})
	alert("Saved successfully.");
	location.reload();
}