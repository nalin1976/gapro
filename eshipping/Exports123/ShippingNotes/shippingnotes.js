var xmlHttp = [];

$(document).ready(function() 
{
		
		var url					='middle.php?RequestType=load_shippingLine';
		var pub_xml_http_obj	=$.ajax({url:url,async:false});
		var shipping_arr			=pub_xml_http_obj.responseText.split("|");
		
		$( "#txtShippingLine" ).autocomplete({
			source: shipping_arr
		});
		
		var url1					='middle.php?RequestType=load_carrier';
		var pub_xml_http_obj1	=$.ajax({url:url1,async:false});
		var carrier_arr			=pub_xml_http_obj1.responseText.split("|");
		
		$( "#txtVessal" ).autocomplete({
			source: carrier_arr
		});

});


function createXMLHttpRequest(index){
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function ClearForm()
{
	window.location.reload();	
}

function LoadDetails(){
	var invoiceNo = document.getElementById('cboInvoiceNo').value;
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = LoadDetailsRequest;
	xmlHttp[1].open("GET",'middle.php?RequestType=LoadDetails&invoiceNo=' +invoiceNo ,true);
	xmlHttp[1].send(null);
}
	function LoadDetailsRequest(){
		if(xmlHttp[1].readyState==4 && xmlHttp[1].status==200){
			
			document.getElementById('txtDate').value =xmlHttp[1].responseXML.getElementsByTagName("formatedShippingNoteDate")[0].childNodes[0].nodeValue;
			RomoveData('cboCustomer');
			var XMLCompanyID				= xmlHttp[1].responseXML.getElementsByTagName('CompanyID');
			var XMLCustomerName			= xmlHttp[1].responseXML.getElementsByTagName('CustomerName');
				var opt 		= document.createElement("option");
				opt.text 	= XMLCustomerName[0].childNodes[0].nodeValue;
				opt.value 	= XMLCompanyID[0].childNodes[0].nodeValue;
				document.getElementById("cboCustomer").options.add(opt);
				
			RomoveData('cboNotifyParty');
			var XMLNotifyIDParty			= xmlHttp[1].responseXML.getElementsByTagName('NotifyIDParty');
			var XMLNotifyIDPartyName	= xmlHttp[1].responseXML.getElementsByTagName('NotifyIDPartyName');
				var opt 		= document.createElement("option");
				opt.text 	= XMLNotifyIDPartyName[0].childNodes[0].nodeValue;
				opt.value 	= XMLNotifyIDParty[0].childNodes[0].nodeValue;
				document.getElementById("cboNotifyParty").options.add(opt);
			
			RomoveData('cboConsignee');
			var XMLBuyerID					= xmlHttp[1].responseXML.getElementsByTagName('BuyerID');
			var XMLBuyerName				= xmlHttp[1].responseXML.getElementsByTagName('BuyerName');
				var opt 		= document.createElement("option");
				opt.text 	= XMLBuyerName[0].childNodes[0].nodeValue;
				opt.value 	= XMLBuyerID[0].childNodes[0].nodeValue;
				document.getElementById("cboConsignee").options.add(opt);
				
			var XMLVoyegeNo 				= xmlHttp[1].responseXML.getElementsByTagName('VoyegeNo');
				document.getElementById('txtVoyageNo').value = XMLVoyegeNo[0].childNodes[0].nodeValue;
				
			var XMLFormatedVoyageDate 	= xmlHttp[1].responseXML.getElementsByTagName('FormatedVoyageDate');
				document.getElementById('txtVoyageDate').value = XMLFormatedVoyageDate[0].childNodes[0].nodeValue;
			
			var XMLCarrier 				= xmlHttp[1].responseXML.getElementsByTagName('Carrier');
				document.getElementById('txtVessal').value = XMLCarrier[0].childNodes[0].nodeValue;
				
			var XMLFinalDest 				= xmlHttp[1].responseXML.getElementsByTagName('FinalDest');
			var XMLCityName 				= xmlHttp[1].responseXML.getElementsByTagName('CityName');
				
				document.getElementById('txtPortDischarge').value = XMLFinalDest[0].childNodes[0].nodeValue;
				
				//document.getElementById('txtPlaceOfDelivery').value = XMLCityName[0].childNodes[0].nodeValue;
				
			var XMLCBM				= xmlHttp[1].responseXML.getElementsByTagName('dblCBM');
				document.getElementById('txtCBM').value = XMLCBM[0].childNodes[0].nodeValue;				
			
			//var XMLNetMass 				= xmlHttp[1].responseXML.getElementsByTagName('NetMass');
				//document.getElementById('txtNetWeight').value = parseFloat(XMLNetMass[0].childNodes[0].nodeValue);
				
			//var XMLMarksAndNos			= xmlHttp[1].responseXML.getElementsByTagName('MarksAndNos');
				//document.getElementById('txtMarksNo').value = XMLMarksAndNos[0].childNodes[0].nodeValue;
				
			//var XMLGenDesc					= xmlHttp[1].responseXML.getElementsByTagName('GenDesc');
				//document.getElementById('txtDescription').value = XMLGenDesc[0].childNodes[0].nodeValue;
			
			document.getElementById('txtWareHouse').value =xmlHttp[1].responseXML.getElementsByTagName("strWarehouseNo")[0].childNodes[0].nodeValue;
			//document.getElementById('txtPlaceAcceptance').value =xmlHttp[1].responseXML.getElementsByTagName("strPlcOfAcceptence")[0].childNodes[0].nodeValue;
			document.getElementById('txtVSLOprCode').value =xmlHttp[1].responseXML.getElementsByTagName("strVslOprCode")[0].childNodes[0].nodeValue;
			document.getElementById('txtShippingLine').value =xmlHttp[1].responseXML.getElementsByTagName("strShippingLineName")[0].childNodes[0].nodeValue;
			document.getElementById('txtCTNOprCode').value =xmlHttp[1].responseXML.getElementsByTagName("strCtnOprCode")[0].childNodes[0].nodeValue;
			document.getElementById('txtCustomerEntry').value =xmlHttp[1].responseXML.getElementsByTagName("strCustomEntryNo")[0].childNodes[0].nodeValue;
			document.getElementById('txtSLPANo').value =xmlHttp[1].responseXML.getElementsByTagName("SLPANo")[0].childNodes[0].nodeValue;
			document.getElementById('txtDeclrent').value =xmlHttp[1].responseXML.getElementsByTagName("NameOfDeclarent")[0].childNodes[0].nodeValue;
			//document.getElementById('txtCBM').value =xmlHttp[1].responseXML.getElementsByTagName("CBM")[0].childNodes[0].nodeValue;
			document.getElementById('txtSNBNNO').value =xmlHttp[1].responseXML.getElementsByTagName("BLNo")[0].childNodes[0].nodeValue;
			
	        document.getElementById('txtEntryNo').value =xmlHttp[1].responseXML.getElementsByTagName("strEntryNo")[0].childNodes[0].nodeValue;
			document.getElementById('txtEntryRec').value =xmlHttp[1].responseXML.getElementsByTagName("strEntryReceive")[0].childNodes[0].nodeValue;
			document.getElementById('txtContainerType').value =xmlHttp[1].responseXML.getElementsByTagName("strContainerType")[0].childNodes[0].nodeValue;
			document.getElementById('txtAscycuda').value =xmlHttp[1].responseXML.getElementsByTagName("strAscycuda")[0].childNodes[0].nodeValue;
		}
	}
	
function SaveValidation(){
	//alert(document.getElementById('txtPlaceOfDelivery').parentNode.value);
}


function saveData()
{	if(document.getElementById('cboInvoiceNo').value!=""){
	var invoiceNo = document.getElementById('cboInvoiceNo').value;
	//var net=document.getElementById('txtNetWeight').value;
	//var gross=document.getElementById('txtGrossWeight').value;
	var vessel=document.getElementById('txtVessal').value;
	var VoyageNo=document.getElementById('txtVoyageNo').value;
	var voyagedate=document.getElementById('txtVoyageDate').value;
	var portdischaarge=document.getElementById('txtPortDischarge').value;
	var warehouse=document.getElementById('txtWareHouse').value ;
	var snbno=document.getElementById('txtSNBNNO').value ;
	//var PlaceAcceptance=document.getElementById('txtPlaceAcceptance').value;
	var ShippingLine=document.getElementById('txtShippingLine').value;
	var VSLOprCode=document.getElementById('txtVSLOprCode').value;
	var CTNOprCode=document.getElementById('txtCTNOprCode').value;
	var CustomerEntry=document.getElementById('txtCustomerEntry').value;
	var SLPANo=document.getElementById('txtSLPANo').value;
	var SNBNNO=document.getElementById('txtSNBNNO').value;
	var Declrent=document.getElementById('txtDeclrent').value;
	//var CBM=document.getElementById('txtCBM').value;
	var SnDate=document.getElementById('txtDate').value;
	//var PlaceOfDelivery=document.getElementById('txtPlaceOfDelivery').value;
	//var MarksNo=document.getElementById('txtMarksNo').value;
		//MarksNo=URLEncode(MarksNo);
	//var Description=document.getElementById('txtDescription').value;
		//Description=URLEncode(Description);
		
		var EntryNo=document.getElementById('txtEntryNo').value;
		var EntryReceive=document.getElementById('txtEntryRec').value;
		var ContainerType=document.getElementById('txtContainerType').value;
		var Ascycuda=document.getElementById('txtAscycuda').value;
		var CBM = document.getElementById('txtCBM').value;
	createXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange = function()
	{	
		if(xmlHttp[2].readyState==4 && xmlHttp[2].status==200)	
		alert(xmlHttp[2].responseText);
	}
	xmlHttp[2].open("GET",'middle.php?RequestType=editDB&invoiceNo=' +invoiceNo + '&vessel='+vessel
					+ '&VoyageNo='+VoyageNo+ '&voyagedate='+voyagedate+ '&portdischaarge='+portdischaarge+ '&warehouse='+warehouse
					+ '&snbno='+snbno+ '&ShippingLine='+ShippingLine+ '&VSLOprCode='+VSLOprCode+ '&CTNOprCode='+CTNOprCode
					+ '&CustomerEntry='+CustomerEntry+ '&cbm=' + CBM +'&SLPANo='+SLPANo+ '&SNBNNO='+SNBNNO+ '&Declrent='+Declrent+ '&EntryNo='+EntryNo+'&EntryReceive='+EntryReceive+'&ContainerType='+ContainerType+'&Ascycuda='+Ascycuda+ '&SnDate='+SnDate
					,true);
	xmlHttp[2].send(null);	
}
	
}

function printReport()
{
	if (document.getElementById("cboInvoiceNo").value!="" )
	{
	var invoiceno=document.getElementById("cboInvoiceNo").value;
	var newwindow=window.open('rptShippingNote.php?invoiceno='+invoiceno ,'name');
	if (window.focus) {newwindow.focus();}
	}
}

function loadInvoiceDetails()
{
	if(document.getElementById('cboInvoiceNo').value!='')
		LoadDetails();
}
