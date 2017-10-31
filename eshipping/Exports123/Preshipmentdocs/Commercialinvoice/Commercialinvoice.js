
var xmlHttp =[];
var position=0;
var count=0;
var pub_window=[];

$(document).ready(function() 
{

  		var url1				='commercialinvoiceDB.php?REQUEST=load_invoice_auto';
		var pub_xml_http_obj1	=$.ajax({url:url1,async:false});
		var pub_inv_arr		    =pub_xml_http_obj1.responseText.split("|");
		
		$( "#txtLoadPreInvoiceNo" ).autocomplete({
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

function loadPreInvNo(obj,evt)
{
	if (evt.keyCode == 13)
	{	
		document.getElementById('cboInvoiceNo').value = obj.value;
		//alert(document.getElementById('cboInvoiceNo').value);
		getInvoceData('pre');
		document.getElementById('txtLoadPreInvoiceNo').value='';
	}
}

function filterInvoice()
{

//alert("filtered data");

}


function getInvoceData(obj)
{
	if(obj=='pre')
	{
		var ele_id="cboInvoiceNo";
		var table="invoiceheader";
		document.getElementById("cboFinalInvoice").value="";
		$('#txtPreInvoiceNo').val($('#cboInvoiceNo').val());
	}
	else
	{
		var ele_id="cboFinalInvoice";
		var table="commercial_invoice_header";
		document.getElementById("cboInvoiceNo").value="";
		document.getElementById("cboInvoiceNo").disabled =true;
		retrv_po_wise_ci();
	}
	
	//getInvoiceDetail();
	if(document.getElementById(ele_id).value!="")
	{
	var invoiceno=document.getElementById(ele_id).value; 
	createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'commercialinvoiceDB.php?REQUEST=getData&invoiceno=' + URLEncode(invoiceno)+'&table='+table,true);
	xmlHttp[0].send(null);
	}
	else
	pageReload();
}

function getCustomerDetail()
{
	

}

function freezFinalInvoice()
{
	document.getElementById("txtInvoiceNo").readOnly=true;
}

function setExchangeRates(rate)
{
document.getElementById("txtExchangeRate").value=rate;

}


function stateChanged()
{
if(xmlHttp[0].readyState==4 && xmlHttp[0].status==200)

{
//alert(xmlHttp[0].responseText);
document.getElementById("txtInvoiceDate").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceDate")[0].childNodes[0].nodeValue;	
//document.getElementById("txtInvoiceNo").disabled=true;
document.getElementById("txtInvoiceNo").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
document.getElementById("cboShipper").value=xmlHttp[0].responseXML.getElementsByTagName("CompanyID")[0].childNodes[0].nodeValue;
document.getElementById("cboConsignee").value=xmlHttp[0].responseXML.getElementsByTagName("BuyerID")[0].childNodes[0].nodeValue;
document.getElementById("cboNotoify1").value=xmlHttp[0].responseXML.getElementsByTagName("NotifyID1")[0].childNodes[0].nodeValue;
document.getElementById("cboNotoify2").value=xmlHttp[0].responseXML.getElementsByTagName("NotifyID2")[0].childNodes[0].nodeValue;
document.getElementById("txtLC").value=xmlHttp[0].responseXML.getElementsByTagName("LCNo")[0].childNodes[0].nodeValue;
document.getElementById("txtLcDate").value=xmlHttp[0].responseXML.getElementsByTagName("dtmLCDate")[0].childNodes[0].nodeValue;
document.getElementById("cboLCBank").value=xmlHttp[0].responseXML.getElementsByTagName("LCBankID")[0].childNodes[0].nodeValue;
document.getElementById("txtLoading").value=xmlHttp[0].responseXML.getElementsByTagName("PortOfLoading")[0].childNodes[0].nodeValue;
document.getElementById("txtCarrier").value=xmlHttp[0].responseXML.getElementsByTagName("Carrier")[0].childNodes[0].nodeValue;
document.getElementById("cboDestination").value=xmlHttp[0].responseXML.getElementsByTagName("FinalDest")[0].childNodes[0].nodeValue;
document.getElementById("txtVoyageeNo").value=xmlHttp[0].responseXML.getElementsByTagName("VoyegeNo")[0].childNodes[0].nodeValue;
document.getElementById("cboCurrency").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text=xmlHttp[0].responseXML.getElementsByTagName("Currency")[0].childNodes[0].nodeValue;
//document.getElementById("txtUnitPrice").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
/*document.getElementById("txtNoCartoons").value=xmlHttp[0].responseXML.getElementsByTagName("NoOfCartons")[0].childNodes[0].nodeValue;*/
document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;
//document.getElementById("txtExchangeRate").value=xmlHttp[0].responseXML.getElementsByTagName("rates")[0].childNodes[0].nodeValue;

document.getElementById("txtSailing").value=xmlHttp[0].responseXML.getElementsByTagName("SailingDate")[0].childNodes[0].nodeValue;


document.getElementById("cboTransMode").value=xmlHttp[0].responseXML.getElementsByTagName("TransportMode")[0].childNodes[0].nodeValue;
//document.getElementById("cboTransMode").disabled=true;
document.getElementById("cboUnit").value=0;
//document.getElementById("cboUnit").disabled=true;
document.getElementById("txtInvoiceDetail").value=xmlHttp[0].responseXML.getElementsByTagName("InvoiceNo")[0].childNodes[0].nodeValue;
document.getElementById("txtManufacDate").value=xmlHttp[0].responseXML.getElementsByTagName("ManufactDate")[0].childNodes[0].nodeValue;
document.getElementById("txtDeliveryTerm").value=xmlHttp[0].responseXML.getElementsByTagName("Incoterms")[0].childNodes[0].nodeValue;
document.getElementById("txtETA").value=xmlHttp[0].responseXML.getElementsByTagName("eta")[0].childNodes[0].nodeValue;
document.getElementById("cboComInvFormat").value=xmlHttp[0].responseXML.getElementsByTagName("ComInvFormat")[0].childNodes[0].nodeValue;
if($('#cboInvoiceNo').val()==""){
document.getElementById("txtPreInvoiceNo").value=xmlHttp[0].responseXML.getElementsByTagName("PreInvoiceNo")[0].childNodes[0].nodeValue;
document.getElementById("cboAccountee").value=xmlHttp[0].responseXML.getElementsByTagName("AccounteeId")[0].childNodes[0].nodeValue;
document.getElementById("cboCSC").value=xmlHttp[0].responseXML.getElementsByTagName("CSCId")[0].childNodes[0].nodeValue;
document.getElementById("cboSoldTo").value=xmlHttp[0].responseXML.getElementsByTagName("DeliverTo")[0].childNodes[0].nodeValue;
document.getElementById("cboComInvFormat").value=xmlHttp[0].responseXML.getElementsByTagName("ComInvFormat")[0].childNodes[0].nodeValue;
document.getElementById("txtAuthorizeby").value=xmlHttp[0].responseXML.getElementsByTagName("AuthorizedPerson")[0].childNodes[0].nodeValue;
document.getElementById("cboPayterms").value=xmlHttp[0].responseXML.getElementsByTagName("PayTerm")[0].childNodes[0].nodeValue;
document.getElementById("cboInvoiceType").value=xmlHttp[0].responseXML.getElementsByTagName("invoiceType")[0].childNodes[0].nodeValue;
document.getElementById("cboForwader").value=xmlHttp[0].responseXML.getElementsByTagName("forwader")[0].childNodes[0].nodeValue;
document.getElementById("cboBank").value=xmlHttp[0].responseXML.getElementsByTagName("intBankId")[0].childNodes[0].nodeValue;
document.getElementById("txtProInvNo").value=xmlHttp[0].responseXML.getElementsByTagName("strProInvoiceNo")[0].childNodes[0].nodeValue;

		}

}

}

function setRates()
{
//document
}


function validateForm()
{

/*if(document.getElementById("txtPreInvoiceNo").value==document.getElementById("txtInvoiceNo").value)
{
	alert("Please check the 'Final Invoice No'.");
	document.getElementById("txtInvoiceNo").focus();
	return false;
}*/

if(document.getElementById("txtInvoiceNo").value=="")
{
alert("Please enter an invoice number.")
document.getElementById("txtInvoiceNo").focus();
return false;
}

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

var currency=document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text;
if(currency=="")
{
alert("Please select the currency.")
return false;
}

if(document.getElementById("cboForwader").value=="")
{
alert("Please select a Forwader.")
return false;
}

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
	if (document.getElementById("cboFinalInvoice").value!="" )
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

function loadPreInvoice(obj)
{
	var preInvoiceNo = obj.value;
	document.getElementById('cboInvoiceNo').value=preInvoiceNo;
	getInvoceData('pre');
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
					load_inv_nos(invoiceno)
				}
		}
	
	}
	xmlHttp[3].open("GET",'commercialinvoiceDB.php?REQUEST=checkDB&invoiceno=' + invoiceno,true);
	xmlHttp[3].send(null);

}


function updateDB(edit)
{

showPleaseWait();

var number			=document.getElementById("txtInvoiceNo").value;
var invoicedate		=document.getElementById("txtInvoiceDate").value;
var shipper			=document.getElementById("cboShipper").value;
var consignee		=document.getElementById("cboConsignee").value;
var notify1			=document.getElementById("cboNotoify1").value;
var notify2			=document.getElementById("cboNotoify2").value;
var lc				=document.getElementById("txtLC").value;
var lcdate			=document.getElementById("txtLcDate").value;
var bank			=document.getElementById("cboLCBank").value;
var loading			=document.getElementById("txtLoading").value;
var carrier			=document.getElementById("txtCarrier").value;
var destination		=document.getElementById("cboDestination").value;
var voyageeno		=document.getElementById("txtVoyageeNo").value;
var currency		=document.getElementById("cboCurrency").options[document.getElementById("cboCurrency").selectedIndex].text;
var exchangerate	=document.getElementById("txtExchangeRate").value;
//var nocartoons		=document.getElementById("txtNoCartoons").value;

var sailing			=document.getElementById("txtSailing").value;
var TransMode		=document.getElementById("cboTransMode").value;
var manufactdate	=document.getElementById("txtManufacDate").value;
var incoterm		=document.getElementById("txtDeliveryTerm").value;
var inveta			=document.getElementById("txtETA").value;
var preinvno		=document.getElementById("txtPreInvoiceNo").value;
var csc				=document.getElementById("cboCSC").value;
var accountee		=document.getElementById("cboAccountee").value;
var soldto			=document.getElementById("cboSoldTo").value;
var invFormat		=document.getElementById("cboComInvFormat").value;
var autorizedPerson =document.getElementById("txtAuthorizeby").value;
var payterm			=document.getElementById("cboPayterms").value;
var invoiceType		=document.getElementById("cboInvoiceType").value;
var forwader		=document.getElementById("cboForwader").value;
var buyerBank		=document.getElementById("cboBank").value;

/* --------------------------- modify 03/05/2010   lahiru ----------------- */
var proInvNo		=document.getElementById("txtProInvNo").value;


var discount			=empty_handle_dbl(document.getElementById("txtDiscount").value);
var discountType		=document.getElementById("cboPrecentageValue").value;


if(edit){
createNewXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange=function()
	{
	if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200)
	{
		alert(xmlHttp[1].responseText);
		hidePleaseWait();
		//pageReload();
	}
	}
	xmlHttp[1].open("GET",'commercialinvoiceDB.php?REQUEST=editDB&invoiceno=' + URLEncode(number)+ '&invoicedate=' +invoicedate+
	 '&shipper='+ shipper + '&consignee=' +consignee+ '&notify1='+notify1+ '&notify2='+notify2+	'&lc=' +lc+ '&lcdate=' +lcdate
	 + '&bank=' +bank+ '&loading=' +loading+ '&carrier=' +carrier+ '&destination=' +destination+'&voyageeno=' +voyageeno+
	  '&currency=' +currency+ '&edit=' +edit+ '&sailing=' +sailing+'&exchangerate=' +exchangerate+ '&TransMode=' +TransMode+
	   '&manufactdate=' +manufactdate+ '&incoterm=' +URLEncode(incoterm)+ '&inveta=' +inveta+ '&preinvno=' +URLEncode(preinvno)+
	    '&csc=' +csc+ '&soldto=' +soldto+ '&accountee=' +accountee+ '&invFormat=' +invFormat+ '&autorizedPerson=' 
		+autorizedPerson+ '&payterm=' +payterm+ '&invoiceType=' +invoiceType+ '&discount=' +discount+'&discountType=' +discountType+ '&forwader=' +forwader+ '&buyerBank=' 
		+buyerBank+ '&proInvNo=' +URLEncode(proInvNo),true);
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
	
/*$(document).ready(function(){
	$("#butNew1").click(function(){
  				$("#txtLoading").val("COLOMBO");
				});
});*/

function load_inv_nos(obj){
	var myOptions = {
		obj	 : 	obj,
		};
	$.each(myOptions, function(val, text) {
		$('#cboFinalInvoice').append(
			$('<option></option>').val(text).html(text)
		);
	});
	document.getElementById('cboFinalInvoice').value=obj;
	freezFinalInvoice();
}

function set_default_date()
{
	$('#txtSailing').val($('#txtInvoiceDate').val())
}

function loadFormat()
{
	var format_id	=$('#cboComInvFormat').val()
	var url			="commercialinvoiceDB.php?REQUEST=loadFormat&format_id=" + format_id;
	var http_request=$.ajax({url:url,async:false});
	document.getElementById("cboConsignee").value=http_request.responseXML.getElementsByTagName("Buyer")[0].childNodes[0].nodeValue;
	document.getElementById("cboNotoify1").value=http_request.responseXML.getElementsByTagName("PTnotify1")[0].childNodes[0].nodeValue;
	document.getElementById("cboNotoify2").value=http_request.responseXML.getElementsByTagName("PTnotify2")[0].childNodes[0].nodeValue;
	document.getElementById("cboAccountee").value=http_request.responseXML.getElementsByTagName("Accountee")[0].childNodes[0].nodeValue;
	document.getElementById("cboCSC").value=http_request.responseXML.getElementsByTagName("CSC")[0].childNodes[0].nodeValue;
	document.getElementById("cboSoldTo").value=http_request.responseXML.getElementsByTagName("Deliveryto")[0].childNodes[0].nodeValue;
	document.getElementById("txtDeliveryTerm").value=http_request.responseXML.getElementsByTagName("Incoterm")[0].childNodes[0].nodeValue;
	document.getElementById("cboDestination").value=http_request.responseXML.getElementsByTagName("Destination")[0].childNodes[0].nodeValue;
	document.getElementById("cboLCBank").value=http_request.responseXML.getElementsByTagName("BuyerBank")[0].childNodes[0].nodeValue;
	document.getElementById("cboPayterms").value=http_request.responseXML.getElementsByTagName("PTline1")[0].childNodes[0].nodeValue;
	document.getElementById("cboBank").value=http_request.responseXML.getElementsByTagName("PTline2")[0].childNodes[0].nodeValue;
	document.getElementById("cboForwader").value=http_request.responseXML.getElementsByTagName("Forwader")[0].childNodes[0].nodeValue;
	
	
}

function prit_straight()
{
	var invoiceno	    =URLEncode($('#cboFinalInvoice').val());
	window.open("movingCo.php?InvoiceNo="+invoiceno,"CO");
	window.open("aptaCO.php?InvoiceNo="+invoiceno,"APTA CO");
	window.open("isftaCO.php?InvoiceNo="+invoiceno,"ISFTA CO")
	try{
			for(var i=0;i<pub_window.length;i++)
			{
					pub_window[i].close();
			}
		}
	catch(err){}
	 var performa=''
	 if($('#cboInvoiceType').val()=='P')
		  performa='&proforma=PROFORMA';
	 
	 var url		    = "commercialinvoiceDB.php?REQUEST=prit_straight&invoiceno="+invoiceno;
	 var xml_http_obj   =$.ajax({url:url,async:false});
	 var xml_url		=xml_http_obj.responseXML.getElementsByTagName('Url');
	 for(var j=0;j<xml_url.length;j++)
	 	{
			pub_window[j]=window.open(xml_url[j].childNodes[0].nodeValue+"?InvoiceNo="+invoiceno+performa,"rep"+j)
		}
		
	
}

function closeCross()
{
	closeWindow();	
}



function viewPOPUPDetail()
{
		createNewXMLHttpRequest(20);
		xmlHttp[20].onreadystatechange=function()
		{	
			if(xmlHttp[20].readyState==4 && xmlHttp[20].status==200)
   		 {
        		
				drawPopupArea(950,390,'frmNewOrganize');
				document.getElementById('frmNewOrganize').innerHTML=xmlHttp[20].responseText;
						
		 }
			
		}
		
		var po = "";
		xmlHttp[20].open("GET",'pl_plugin_search.php?po='+po,true);
		xmlHttp[20].send(null);
		
}

function setPL(obj)
{
	if(obj.checked)
	{
		var pl = obj.parentNode.parentNode.cells[1].innerHTML.trim();
		var po = obj.parentNode.parentNode.cells[3].innerHTML.trim();
		
		closeWindow();	
		
		//document.getElementById('txtPLno').value = pl;
		//document.getElementById('txtPLno').onchange();
		var url	 		=	"commercialinvoiceDB.php?REQUEST=addSizePrice&plno="+pl+"&po="+po;
		var http_obj	=	$.ajax({url:url,async:false});
		//alert(http_obj.responseText);
		
	var detailGrid=document.getElementById("tblDescriptionOfGood");	
	var invdtlno=document.getElementById("cboInvoiceNo").value;
	var StyleID=http_obj.responseXML.getElementsByTagName('StyleID');
	var PL=http_obj.responseXML.getElementsByTagName('PL');
	var ItemNo=http_obj.responseXML.getElementsByTagName('ItemNo');
	var BuyerPONo=http_obj.responseXML.getElementsByTagName('BuyerPONo');
	var DescOfGoods=http_obj.responseXML.getElementsByTagName('DescOfGoods');
	var Quantity=http_obj.responseXML.getElementsByTagName('Quantity');
	var UnitID=http_obj.responseXML.getElementsByTagName('UnitID');
	var UnitPrice=http_obj.responseXML.getElementsByTagName('UnitPrice');
	var lCMP=http_obj.responseXML.getElementsByTagName('lCMP');
	var Amount=http_obj.responseXML.getElementsByTagName('Amount');	
	var HSCode=http_obj.responseXML.getElementsByTagName('HSCode');
	var GrossMass=http_obj.responseXML.getElementsByTagName('GrossMass');
	var NetMass=http_obj.responseXML.getElementsByTagName('NetMass');
	var PriceUnitID=http_obj.responseXML.getElementsByTagName('PriceUnitID');
	var NoOfCTns=http_obj.responseXML.getElementsByTagName('NoOfCTns');
	var Category=http_obj.responseXML.getElementsByTagName('Category');
	var ProcedureCode=http_obj.responseXML.getElementsByTagName('ProcedureCode');
	var dblUMOnQty1=http_obj.responseXML.getElementsByTagName('dblUMOnQty1');
	var dblUMOnQty2=http_obj.responseXML.getElementsByTagName('dblUMOnQty2');
	var dblUMOnQty3=http_obj.responseXML.getElementsByTagName('dblUMOnQty3');
	var dblUMOnUnit1=http_obj.responseXML.getElementsByTagName('UMOQtyUnit1');
	var dblUMOnUnit2=http_obj.responseXML.getElementsByTagName('UMOQtyUnit2');
	var dblUMOnUnit3=http_obj.responseXML.getElementsByTagName('UMOQtyUnit3');
	var ISD=http_obj.responseXML.getElementsByTagName('ISD');
	var Fabric=http_obj.responseXML.getElementsByTagName('Fabrication');
	var color=http_obj.responseXML.getElementsByTagName('Color');
	var CBM=http_obj.responseXML.getElementsByTagName('CBM');	
	var netnet=http_obj.responseXML.getElementsByTagName('netnet');
	//alert(invdtlno.length);
	
	
	
	var pos=detailGrid.rows.length-1;
		for(var loop=0;loop<StyleID.length;loop++)
		{	
		
		var existData=0;
	
			for(var t=1;t<detailGrid.rows.length;t++)
			{
				if((detailGrid.rows[t].cells[5].childNodes[0].nodeValue==PL[loop].childNodes[0].nodeValue) && (detailGrid.rows[t].cells[6].childNodes[0].nodeValue==color[loop].childNodes[0].nodeValue))
				{
					existData=1;
					break;
				}
			}
		if(existData==0)
		{
			
			var lastRow 		= detailGrid.rows.length;	
		var row 			= detailGrid.insertRow(lastRow);
		pos++;
		//row.onclick	= rowclickColorChangeIou;	
		//if(loop % 2 ==0)
					row.className ="bcgcolor-tblrow mouseover";
				//else
					//row.className ="bcgcolorred mouseover";
			
			//row.className="mouseover";	
			row.ondblclick=editItems;
		
		var cellDelete = row.insertCell(0); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = "<img src=\"../../../images/del.png\" alt=\"del\" width=\"15\" height=\"15\" id=\"delItem\" onclick=\"RemoveItem(this);\"/>";	
		
		
		var rowCell = row.insertCell(1);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="<input type=\"checkbox\" class=\"txtbox\"  />";
				rowCell.id=BuyerPONo[loop].childNodes[0].nodeValue;
		
		
		var rowCell = row.insertCell(2);
				rowCell.className ="normalfnt";			
				rowCell.innerHTML =empty_handle_str(StyleID[loop].childNodes[0].nodeValue)
							
		var rowCell = row.insertCell(3);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(BuyerPONo[loop].childNodes[0].nodeValue);
								
		var rowCell = row.insertCell(4);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(ISD[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(5);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(PL[loop].childNodes[0].nodeValue);
		
		//alert(color[loop].childNodes[0].nodeValue);
		var rowCell = row.insertCell(6);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(color[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(7);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(DescOfGoods[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(8);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(Fabric[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(9);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML ="n/a";
				
		var rowCell = row.insertCell(10);
				rowCell.className ="normalfntMid";			
				rowCell.innerHTML =empty_handle_str(HSCode[loop].childNodes[0].nodeValue);
	 
		var rowCell = row.insertCell(11);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(UnitPrice[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(12);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_str(PriceUnitID[loop].childNodes[0].nodeValue);		
				
		var rowCell = row.insertCell(13);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Quantity[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(14);
				rowCell.className ="normalfntRite";			
			rowCell.innerHTML =empty_handle_str(UnitID[loop].childNodes[0].nodeValue);				
				
		var rowCell = row.insertCell(15);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(Amount[loop].childNodes[0].nodeValue);
				
		var rowCell = row.insertCell(16);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(GrossMass[loop].childNodes[0].nodeValue);	
				
		var rowCell = row.insertCell(17);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(NetMass[loop].childNodes[0].nodeValue);
		
		var rowCell = row.insertCell(18);
				rowCell.className ="normalfntRite";			
				rowCell.innerHTML =empty_handle_dbl(netnet[loop].childNodes[0].nodeValue);
								
		var cellDelete = row.insertCell(19); 
				cellDelete.className ="normalfntMid";	
				cellDelete.innerHTML = empty_handle_dbl(NoOfCTns[loop].childNodes[0].nodeValue);		
		}
		}
	}
}
