
var xmlHttp =[];
var position=0;
var count=0;
var prev_desc	="";
var prev_fabric	="";
$(document).ready(function() 
{
		
		var url					='commercialinvoiceDB.php?REQUEST=load_carrier';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var pub_carrier_arr		=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtCarrier" ).autocomplete({
			source: pub_carrier_arr
		});
		
		var url2					='commercialinvoiceDB.php?REQUEST=load_po_auto';
		var pub_xml_http_obj2	    = $.ajax({url:url2,async:false});
		var pub_po_arr				=pub_xml_http_obj2.responseText.split("|");
		
		$( "#txtInvoicePoNo" ).autocomplete({
			source: pub_po_arr
		});

		var url4				='commercialinvoiceDB.php?REQUEST=loadpreInvFab';
		var pub_xml_http_obj4	=$.ajax({url:url4,async:false});
		var pub_fb_arr			=pub_xml_http_obj4.responseText.split("|");
		
		$( "#txtFabric" ).autocomplete({
			source: pub_fb_arr
		});
				var url3				='commercialinvoiceDB.php?REQUEST=loadpreInvDesc';
		var pub_xml_http_obj3	=$.ajax({url:url3,async:false});
		var pub_dec_arr			=pub_xml_http_obj3.responseText.split("|");
		
		$( "#txtareaDisc" ).autocomplete({
			source: pub_dec_arr
		});

  		var url1				='commercialinvoiceDB.php?REQUEST=load_invoice_auto';
		var pub_xml_http_obj1	=$.ajax({url:url1,async:false});
		var pub_inv_arr		    =pub_xml_http_obj1.responseText.split("|");
		
		$( "#txtInvoiceNo2" ).autocomplete({
			source: pub_inv_arr
		});
		
		


});

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

function changePreInvCombo(obj,evt)
{
	if (evt.keyCode == 13)
	{	
		document.getElementById('cboInvoiceNo').value = obj.value;
		getInvoceData('pre');
		document.getElementById('txtInvoiceNo2').value='';
		
	}
}

//function changePrefabCombo(obj,evt)
//{
//	if (evt.keyCode == 13)
//	{	
//		document.getElementById('cboInvoiceNo').value = obj.value;
//		//getInvoceData('pre');
//		//document.getElementById('txtInvoiceNo2').value='';
//		
//	}
//}






function changePreInvStyle(obj,evt)
{
	if (evt.keyCode == 13)
	{	
		var style = document.getElementById('txtStyle').value;
		//getInvoceData('pre');
		//alert(style);
		var url     = "commercialinvoiceDB.php?REQUEST=loadStyleDescToPreInv&style="+style;
		var htmlobj = $.ajax({url:url,async:false});
		
	   document.getElementById('txtareaDisc').value=htmlobj.responseXML.getElementsByTagName("DescOfGoods")[0].childNodes[0].nodeValue;
		document.getElementById('txtFabric').value=htmlobj.responseXML.getElementsByTagName("Fabrication")[0].childNodes[0].nodeValue;
		
	}
}




function changePrePoInvCombo(obj,evt)
{
	if (evt.keyCode == 13)
	{
		var url     = "commercialinvoiceDB.php?REQUEST=loadPreToInv&poNo="+obj.value;
		var htmlobj = $.ajax({url:url,async:false});
		
		document.getElementById('cboInvoiceNo').value = htmlobj.responseText;
		if(htmlobj.responseText!="fail")
			getInvoceData('pre');
			
		document.getElementById('txtInvoicePoNo').value='';
	}
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

function setExchangeRates(rate)
{
document.getElementById("txtExchangeRate").value=rate;

}


function stateChanged()
{
if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)

{
//alert(xmlHttp[0].responseText);

		document.getElementById("txtDeliveryTerm2").value = xmlHttp[0].responseXML.getElementsByTagName("intMarchantId")[0].childNodes[0].nodeValue;
		document.getElementById("cboShipper2").value = xmlHttp[0].responseXML.getElementsByTagName("intManufacturerId")[0].childNodes[0].nodeValue;
		var sts = xmlHttp[0].responseXML.getElementsByTagName("intShellBox")[0].childNodes[0].nodeValue;
		
		if(sts==1)
		{
			document.getElementById("chkShellBox").checked = true; 
		}
		else if(sts==0)
		{
			document.getElementById("chkShellBox").checked = false;
		}
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
document.getElementById("cboCurrency").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text=xmlHttp[0].responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
//document.getElementById("txtUnitPrice").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtNoCartoons").value=xmlHttp[0].responseXML.getElementsByTagName("NoOfCartons")[0].childNodes[0].nodeValue;
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtDiscription").value=xmlHttp[0].responseXML.getElementsByTagName("GenDesc")[0].childNodes[0].nodeValue;
document.getElementById("txtSailing").value=xmlHttp[0].responseXML.getElementsByTagName("SailingDate")[0].childNodes[0].nodeValue;
document.getElementById("txtMarksofPKGS").value=xmlHttp[0].responseXML.getElementsByTagName("MarksAndNos")[0].childNodes[0].nodeValue;
document.getElementById("txtDeliveryTerm").value=xmlHttp[0].responseXML.getElementsByTagName("txtDeliveryTerm")[0].childNodes[0].nodeValue;
//document.getElementById("cboInvoiceType").value=1;

document.getElementById("cboTransMode").value=xmlHttp[0].responseXML.getElementsByTagName("TransportMode")[0].childNodes[0].nodeValue;
//document.getElementById("cboTransMode").disabled=true;

//document.getElementById("cboUnit").disabled=true;
document.getElementById("txtInvoiceDetail").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
document.getElementById("cboSoldTo").value=xmlHttp[0].responseXML.getElementsByTagName("SoldTo")[0].childNodes[0].nodeValue;
document.getElementById("cboComInvFormat").value=xmlHttp[0].responseXML.getElementsByTagName("txtFormat")[0].childNodes[0].nodeValue;
document.getElementById("cboCollect").value=xmlHttp[0].responseXML.getElementsByTagName("Collect")[0].childNodes[0].nodeValue;
document.getElementById("txtPreDocNo").value=xmlHttp[0].responseXML.getElementsByTagName("PredocumentNo")[0].childNodes[0].nodeValue;
}

}

function setRates()
{
//document
}


function validateForm()
{
/*
if(document.getElementById("cboInvoiceType").value=="")
{
alert("Please select an invoice type.");
return false;
}

if(document.getElementById("txtInvoiceNo").value=="")
{
alert("Please enter an invoice number.")
document.getElementById("txtInvoiceNo").focus();
return false;
}
*/
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
/*
if(document.getElementById("cboNotoify1").value=="")
{
alert("Please select notify part one.")
return false;
}

if(document.getElementById("txtLC").value=="")
{
alert("Please enter a LC number.")
document.getElementById("txtLC").focus();
return false;
}

if(document.getElementById("cboNotoify2").value=="")
{
alert("Please select notify part two.")
return false;
}

if(document.getElementById("txtLcDate").value=="")
{
alert("Please enter the LC date.")
document.getElementById("txtLcDate").focus();
return false;
}

if(document.getElementById("cboBank").value=="")
{
alert("Please select the bank.")
return false;
}

if(document.getElementById("txtLoading").value=="")
{
alert("Please enter the port of loading.")
document.getElementById("txtLoading").focus();
return false;
}


if(document.getElementById("cboDestination").value=="")
{
alert("Please select the destination.")
return false;
}

if(document.getElementById("txtCarrier").value=="")
{
alert("Please enter the carrier.")
document.getElementById("txtCarrier").focus();
return false;
}

if(document.getElementById("txtVoyageeNo").value=="")
{
alert("Please enter the VoyageeNo.")
document.getElementById("txtVoyageeNo").focus();
return false;
}

if(document.getElementById("txtVoyageeNo").value=="")
{
alert("Please enter the VoyageeNo.")
document.getElementById("txtVoyageeNo").focus();
return false;
}

if(document.getElementById("txtSailing").value=="")
{
alert("Please set sailing on or about.")
document.getElementById("txtSailing").focus();
return false;
}
*/
/*if(document.getElementById("cboCurrency").value=="")
{
alert("Please select the currency.")
return false;
}*/

/*if(document.getElementById("txtNoCartoons").value=="")
{
alert("Please enter number of cartoons.")
document.getElementById("txtNoCartoons").focus();
return false;
}*/
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


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function rowupdater(){
	var cancelInv = confirm("Are you sure you want to cancel ?");
	
	
	if(cancelInv==true)
	{
		cancelInvoice();
		location.reload();
	}
	
} 
	
function cancelInvoice()
{
	
	var InvoiceNo				= $('#cboInvoiceNo').val();
	//alert(InvoiceNo);
	
	var url = 'commercialinvoiceDB.php?REQUEST=updateCancelInvo&invoicenum='+URLEncode(InvoiceNo);
	htmlobj = $.ajax({url:url,async:false});
	alert(htmlobj.responseText);
}



function updateDB(edit)
{

showPleaseWait();
var format = document.getElementById("cboComInvFormat").value; 
var ofPKGS=document.getElementById("txtMarksofPKGS").value.trim();
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
var currency=document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text;
var exchangerate=document.getElementById("txtExchangeRate").value;

var predocno=document.getElementById("txtPreDocNo").value;

//var nocartoons=document.getElementById("txtNoCartoons").value;
var des=URLEncode(description);
var MarksofPKGS=URLEncode(ofPKGS);
var sailing=document.getElementById("txtSailing").value;
var TransMode=document.getElementById("cboTransMode").value;
var SoldTo=document.getElementById("cboSoldTo").value;

var SoldTo2= URLEncode(document.getElementById("txtDeliveryTerm").value);

var marchant = document.getElementById("txtDeliveryTerm2").value;
var manufac  = document.getElementById("cboShipper2").value;
var collect  = document.getElementById("cboCollect").value;
var ShellBox = 0;
if(document.getElementById("chkShellBox").checked)
{
	ShellBox = 1;
}

if(edit){
createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
		if(xmlHttp[1].responseText!="Sorry,Operation Failed!")
		{
			if($("#txtInvoiceNo").val()==""){
			var invoiceid=xmlHttp[1].responseText
			$("#txtInvoiceNo").val(invoiceid)	
			var opt = document.createElement("option");
			
			// Assign text and value to Option object
			opt.text = invoiceid;
			opt.value = invoiceid;
			document.getElementById("cboInvoiceNo").options.add(opt);
			document.getElementById("cboInvoiceNo").value=invoiceid;
			}
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
	'&voyageeno=' +voyageeno+ '&marchant=' +marchant+'&manufac='+ manufac+ '&SoldTo2=' + SoldTo2 +'&ShellBox='+ShellBox+ '&currency=' +currency+ '&edit=' +edit+ '&sailing=' +sailing+ '&MarksofPKGS=' +MarksofPKGS+'&format=' + format + '&exchangerate=' +exchangerate+ '&predocno=' +predocno+ '&nocartoons=' + '&TransMode=' +TransMode+ '&SoldTo=' +SoldTo+ '&collect=' +collect,true);
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

function setEditable(obj)
{
	
}
function loadFormat()
{
	
	var format_id	=$('#cboComInvFormat').val();
	
	
	var url			="commercialinvoiceDB.php?REQUEST=loadFormat&format_id=" + format_id;
	var http_request=$.ajax({url:url,async:false});
	var strText = "";
	
	document.getElementById("cboConsignee").value=http_request.responseXML.getElementsByTagName("Buyer")[0].childNodes[0].nodeValue;
	//alert(http_request.responseXML.getElementsByTagName("Buyer")[0].childNodes[0].nodeValue);
	document.getElementById("cboNotoify1").value=http_request.responseXML.getElementsByTagName("PTnotify1")[0].childNodes[0].nodeValue;
	document.getElementById("cboNotoify2").value=http_request.responseXML.getElementsByTagName("PTnotify2")[0].childNodes[0].nodeValue;
	document.getElementById("cboDestination").value=http_request.responseXML.getElementsByTagName("Destination")[0].childNodes[0].nodeValue;
	document.getElementById("txtDeliveryTerm").value=http_request.responseXML.getElementsByTagName("Incoterm")[0].childNodes[0].nodeValue;
	document.getElementById("cboTransMode").value=http_request.responseXML.getElementsByTagName("Transport")[0].childNodes[0].nodeValue;
	document.getElementById("cboTransMode").value=http_request.responseXML.getElementsByTagName("Transport")[0].childNodes[0].nodeValue;
	
	document.getElementById("cboCurrency").value=http_request.responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
	document.getElementById("txtExchangeRate").value=http_request.responseXML.getElementsByTagName("Rates")[0].childNodes[0].nodeValue;
	

	strText+=http_request.responseXML.getElementsByTagName("MMline1")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("MMline2")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("MMline3")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("MMline4")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("MMline5")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("MMline6")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("MMline7")[0].childNodes[0].nodeValue+"\n";	
	strText+=http_request.responseXML.getElementsByTagName("SMline1")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("SMline2")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("SMline3")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("SMline4")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("SMline5")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("SMline6")[0].childNodes[0].nodeValue+"\n";
	strText+=http_request.responseXML.getElementsByTagName("SMline7")[0].childNodes[0].nodeValue+"\n";
	
	document.getElementById("txtMarksofPKGS").value = 	strText;
	
	
}

function loadFabricDescCat(obj)
{
	if(obj.value!='')
	{
		var url="commercialinvoiceDB.php?REQUEST=loadFabricDescCat";
			url+="&hsCode="+URLEncode(obj.value);
			
		var xmlhttpobj=$.ajax({url:url,async:false});
		document.getElementById("txtareaDisc").value=xmlhttpobj.responseXML.getElementsByTagName("Description")[0].childNodes[0].nodeValue;
	document.getElementById("txtFabric").value=xmlhttpobj.responseXML.getElementsByTagName("Fabric")[0].childNodes[0].nodeValue;
	document.getElementById("cboCategory").value=xmlhttpobj.responseXML.getElementsByTagName("CatNo")[0].childNodes[0].nodeValue;
	}
	else
	{
		document.getElementById("txtareaDisc").value='';
		document.getElementById("txtFabric").value='';
		document.getElementById("cboCategory").value='';
	}
}



function addDetailsToGrid()
{


		var dsc=document.getElementById('txtareaDisc').value;
		var HsCode=document.getElementById('txtHS').value;
		var Fabric=document.getElementById('txtFabric').value;
		var PoNo=document.getElementById('txtBuyerPO').value;
		var UnitPrice=document.getElementById('txtUnitPrice').value;
		
		
			if(HsCode!='')
			{
				
					var tblDesOfGood = document.getElementById('tblDescription');
				for(var x=1; x<tblDesOfGood.rows.length; x++)
				{
					
			
						var poNum	   = tblDesOfGood.rows[x].cells[2].childNodes[0].nodeValue;
						var Price	   = tblDesOfGood.rows[x].cells[7].childNodes[0].nodeValue;
				
					
					if(PoNo==poNum && UnitPrice==Price)
					{
						//alert("if test..");
						tblDesOfGood.rows[x].cells[14].innerHTML  = HsCode
						tblDesOfGood.rows[x].cells[5].innerHTML  = Fabric
						tblDesOfGood.rows[x].cells[4].innerHTML  = dsc
							
							
							
					}
					
				
				}
				saveGrid();	
				addToGrid();
				cleardata();
			}
		else
			alert("Please Select HS Code!");
}

function saveGrid()

{
	
		var tblData     = document.getElementById("tblDescription");
	var invoiceno   = document.getElementById("txtInvoiceDetail").value;
	//var cdn         = document.getElementById("cboCDNNo").value;
	
//	var url1	 		=	'cdndb.php?request=delData&cdn='+cdn;
	//var url_pl=$.ajax({url:url1,async:false});
	//alert (url_pl.responseText);
	
	for(var x=1;x<tblData.rows.length;x++)
	{	
		//var invoiceno   = URLEncode(tblData.rows[x].cells[1].childNodes[0].nodeValue);
		var url	 		=	'cdndb.php?request=saveData&desc='+desc+'&invoiceno='+invoiceno;
			
			var desc			= URLEncode(tblData.rows[x].cells[4].childNodes[0].nodeValue);
			var style			= URLEncode(tblData.rows[x].cells[1].childNodes[0].nodeValue);
			var unit1			= URLEncode(tblData.rows[x].cells[10].childNodes[0].nodeValue);
			var unitprice		= URLEncode(tblData.rows[x].cells[7].childNodes[0].nodeValue);
			var gross			= URLEncode(tblData.rows[x].cells[12].childNodes[0].nodeValue);
			var ctns			= URLEncode(tblData.rows[x].cells[15].childNodes[0].nodeValue);
			var net				= URLEncode(tblData.rows[x].cells[13].childNodes[0].nodeValue);
			var bpo				= URLEncode(tblData.rows[x].cells[2].childNodes[0].nodeValue);
			var unitqty			= URLEncode(tblData.rows[x].cells[8].childNodes[0].nodeValue);
			var qty				= URLEncode(tblData.rows[x].cells[9].childNodes[0].nodeValue);		
			var hs				= URLEncode(tblData.rows[x].cells[14].childNodes[0].nodeValue);
			var category		= URLEncode(tblData.rows[x].cells[1].id);
			var procedurecode	= URLEncode(tblData.rows[x].cells[4].id);
			var umoqty1			= URLEncode(tblData.rows[x].cells[16].childNodes[0].nodeValue);
			var umoqty2			= URLEncode(tblData.rows[x].cells[17].childNodes[0].nodeValue);
			var umoqty3			= URLEncode(tblData.rows[x].cells[18].childNodes[0].nodeValue);
			var val				= URLEncode(calValue(unitprice,unit1,qty,unitqty,1));
			var umoUnit1		= URLEncode(tblData.rows[x].cells[16].id);
			var umoUnit2		= URLEncode(tblData.rows[x].cells[17].id);
			var umoUnit3		= URLEncode(tblData.rows[x].cells[18].id);
			var ISDNo			= URLEncode(tblData.rows[x].cells[19].childNodes[0].nodeValue);
			var fabrication		= URLEncode(tblData.rows[x].cells[5].childNodes[0].nodeValue);
			var PL				= URLEncode(tblData.rows[x].cells[3].childNodes[0].nodeValue);
			var Color			= URLEncode(tblData.rows[x].cells[6].childNodes[0].nodeValue);
			var CBM			    = URLEncode(tblData.rows[x].cells[20].childNodes[0].nodeValue);
			
			url+= '&style='+style+'&value='+val+ '&unit=' +unit1+ '&unitprice='+unitprice;
			url+='&gross=' +gross+ '&ctns=' +ctns+  '&net=' +net+'&bpo=' +bpo+ '&unitqty=' +unitqty;
			url+='&procedurecode=' +procedurecode+'&hs=' +hs;
			url+='&qty=' +qty+ '&category=' +category+ '&umoqty1='+umoqty1+ '&umoqty2='+umoqty2+'&umoqty3='+umoqty3;
			url+='&PL='+PL+ '&umoUnit1='+umoUnit1+ '&umoUnit2='+umoUnit2+ '&umoUnit3='+umoUnit3+ '&ISDNo='+ISDNo;
			url+='&fabrication='+fabrication+'&Color='+Color+'&cbm='+CBM;
		

		var http_obj	=	$.ajax({url:url,async:false});
		
	}
	
}

function printReport()
{
	save_Data()
	
	if (document.getElementById("cboInvoiceNo").value!="" )
	{
	var invoiceno=document.getElementById("cboInvoiceNo").value;
	var newwindow=window.open('rptShippingNote.php?invoiceno='+invoiceno ,'name');
	if (window.focus) {newwindow.focus();}
	}
}




function calTot()
{
	
	
		var tblData     = document.getElementById("tblDescription");
	var invoiceno   = document.getElementById("txtInvoiceDetail").value;
	
	var unitprice=0;
	var qty=0;
	var val=0;
	
for(var x=1;x<tblData.rows.length;x++)
	{

		
			unitprice=unitprice+parseFloat(tblData.rows[x].cells[7].childNodes[0].nodeValue);
			qty=qty+parseFloat(tblData.rows[x].cells[9].childNodes[0].nodeValue);
			val=val+parseFloat(tblData.rows[x].cells[11].childNodes[0].nodeValue);
		
	}
	
	//tblDiscountData.rows[lastRow].cells[1].innerHTML=fullInvAmt;
	//tblDiscountData.rows[lastRow].cells[2].innerHTML=fullDisAmt;
	//tblDiscountData.rows[lastRow].cells[3].innerHTML=fullNetAmt;
	
	document.getElementById('txtTotalPrice').value=unitprice.toFixed(2);
	document.getElementById('txtTotalQty').value=qty.toFixed(2);
	document.getElementById('txtTotalAmount').value=val.toFixed(2);
	
		
}

function save_Data()
{
	if(validateForm())
	{
		if (document.getElementById("cboInvoiceNo").value!="" )
		{	
			if(confirm("Do you want to Print a Report?")) 
			updateDB('update');
		}
		else 
		{		
			checkDB();
		}
	}
}






function preToCdn()
//http://localhost/eshippingeam//Exports/cdn/cdn.php
{	
//alert("kgj");
		window.open("../../cdn/cdn.php?InvoiceNo=" + URLEncode(document.getElementById("txtInvoiceNo").value)+'&id='+(id=1));
		//window.open("shippingnotes.php");
		//alert (document.getElementById("cboInvoiceNo").value);
		//alert (document.getElementById("txtCDNDocNo").value);
		//var txtDocNo=document.getElementById("cboInvoiceNo").value;
		//var CDNDocNo=document.getElementById("txtCDNDocNo").value;
		//alert(CDNDocNo);
		//alert(document.getElementById("txtCDNNo").value);
		//document.getElementById("txtDocNo").value=txtDocNo;
		//document.getElementById("txtCDNNo").value=CDNDocNo;
}
