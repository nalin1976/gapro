var xmlHttp = [];

var pub_No	= 0 ;
var pub_Year			= 0;
var headerCheckLoop		= 0;
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

function ClearForm(){	
	setTimeout("location.reload(true);",0);
}

function RomoveData(data){
	var index = document.getElementById(data).options.length;
	while(document.getElementById(data).options.length > 0) 
	{
		index --;
		document.getElementById(data).options[index] = null;
	}
}

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}
function closeList()
{
	try
	{
		var box = document.getElementById('stylelist');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

function curLeft(obj){
	toreturn = 0;
	while(obj){
		toreturn += obj.offsetLeft;
		obj = obj.offsetParent;
	}
	return toreturn;
}

function curTop(obj){
	toreturn = 0;
	while(obj){
		toreturn += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return toreturn;
}
function ItemListKeyHandler(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if(charCode == 13) closeList();
}
function rowclickColorChange(obj,tbl)
{
	var rowIndex = obj.rowIndex;
	var tbl = document.getElementById(tbl);
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		else
		{
			tbl.rows[i].className="bcgcolor-tblrowWhite";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function VisibleFCLCombo(obj)
{
	if(obj.checked)
	{
		document.getElementById('txtFcl').disabled=false;
		document.getElementById('cboFcl').disabled=false;
		document.getElementById('cboFcl').value=20;
		document.getElementById('txtFcl').value=1;
	}
	else
	{
		document.getElementById('txtFcl').disabled=true;
		document.getElementById('cboFcl').disabled=true;
		document.getElementById('cboFcl').value=0;
		document.getElementById('txtFcl').value="";
	}
}
function GetOtherCountryAuto(obj)
{	
	document.getElementById('cboExCountry').value = obj.value;
	document.getElementById('cboLastConsiCity').value = obj.value;
	document.getElementById('cboTradingCountry').value = obj.value;
}
function SaveValidation(obj)
{	

if(document.getElementById('cboExporter').value==""){
	alert("Please select the Exporter");	
	return;
	}
if(document.getElementById('cboConsignee').value==""){
	alert("Please select the Consignee");
	return;
}
if(document.getElementById('txtAuthorizedBy').value==""){
	alert("Please select the Authorized user");
	return;
}
if(document.getElementById('cboForwaders').value==""){
	alert("Please select the Forwader");
	return;	
}
if(document.getElementById('cboWalfCleark').value==""){
	alert("Please select the WalfCleark");
	return;
}
if(document.getElementById('txtVoyageDate').value==""){
	alert("Please select the Voyage Date.");
	return;
}
if(document.getElementById('txtInvoAmount').value==""){
	alert("Please fill the invoice amount");
	document.getElementById('txtInvoAmount').focus();
	return;
}
var currency = document.getElementById('cboCurrency').options[document.getElementById('cboCurrency').selectedIndex].text
if(currency==""){
	alert("Please select the currency.");
	return;
}
if(document.getElementById('txtNoOfPackages').value==""){
	alert("Please fill the NoOf Packages.");
	return;
}
if(document.getElementById('txtDeliveryTerm').value==""){
	alert("Please select the Delivery terms");
	return;
}
showPleaseWait();
pub_No = document.getElementById('txtDeliveryNo').value;
if(pub_No=="")
		CheckPreviousDocsAvailable();
	else
		Save();
}
//Start - check document no 
function CheckPreviousDocsAvailable()
{
	var previousDocs = document.getElementById('txtPreviousDoc').value;
	createXMLHttpRequest(5);	
	xmlHttp[5].onreadystatechange = CheckPreviousDocsAvailableRequest;
	xmlHttp[5].index = previousDocs;
	xmlHttp[5].open("GET" ,'cusdecxml.php?RequestType=CheckPreviousDocsAvailable&previousDocs=' +previousDocs ,true);
	xmlHttp[5].send(null);
}
	function CheckPreviousDocsAvailableRequest()
	{	
    	if(xmlHttp[5].readyState == 4 && xmlHttp[5].status == 200) 
        	{  
        		var XMLCheck	= xmlHttp[5].responseXML.getElementsByTagName("check")[0].childNodes[0].nodeValue;
        		if(XMLCheck!="TRUE"){			 					
					LoadDeliveryNo();
				}				
				else{
					var XMLDeliveryNo = xmlHttp[5].responseXML.getElementsByTagName("DeliveryNo")[0].childNodes[0].nodeValue;
					alert("Sorry !\nPrevious Document No : " +xmlHttp[5].index+ " already saved in Delivery No: " +XMLDeliveryNo);
					hidePleaseWait();
				}
			}
	}		
	
//End - check document no 
function LoadDeliveryNo()
{	
	createXMLHttpRequest(1);	
	xmlHttp[1].onreadystatechange = LoadIssueNoRequest;
	xmlHttp[1].open("GET" ,'cusdecxml.php?RequestType=LoadDeliveryNo' ,true);
	xmlHttp[1].send(null);	
}
	function LoadIssueNoRequest()
	{	
    	if(xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200) 
        	{  
        		var XMLAdmin	= xmlHttp[1].responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
        		if(XMLAdmin=="TRUE"){		 
			 	var XMLNo = xmlHttp[1].responseXML.getElementsByTagName("No");	
				  pub_No 	= parseInt(XMLNo[0].childNodes[0].nodeValue);				 
				
						document.getElementById("txtDeliveryNo").value =pub_No ;			
						Save();
				}				
				else{
					alert("Please contact system administrator to Assign New Delivery No....");
					hidePleaseWait();
				}
			}
	}		
	
function Save()
{	
	var recType 				= document.getElementById('txtDeliveryNo').parentNode.value;
	var mode					= document.getElementById('cboMode').value;
	var invoice					= document.getElementById('txtInvoice').value;
	var invoiceDate				= document.getElementById('txtDate').value;
	
	var exporter 				= document.getElementById('cboExporter').value;
	var consignee				= document.getElementById('cboConsignee').value;
	var consigneeRefCode		= document.getElementById('txtConsigneeRetCode').value;
	var originCountry			= document.getElementById('cboOrignCountry').value;
	var exCountry				= document.getElementById('cboExCountry').value;
	var lastConsiCity			= document.getElementById('cboLastConsiCity').value;
	var tradingCountry			= document.getElementById('cboTradingCountry').value;
	
	var vessel					= document.getElementById('txtVessel').value;
	var deliveryTerm			= document.getElementById('txtDeliveryTerm').value;
	var fcl						= (document.getElementById('chkFcl').checked == true ? 1:0);	
	var cboFcl					= document.getElementById('cboFcl').value;
	var txtFcl					= document.getElementById('txtFcl').value;
	var VoyageNo				= document.getElementById('txtVoyageNo').value;
	var containerNo				= document.getElementById('txtContainerNo').value;	
	var voyageDate				= document.getElementById('txtVoyageDate').value;	
	
	var currency 				= document.getElementById('cboCurrency').options[document.getElementById('cboCurrency').selectedIndex].text;	
	var exRate					= document.getElementById('txtExRate').value;	
	var invoAmount				= document.getElementById('txtInvoAmount').value;
	var bank					= document.getElementById('cboBank').value;
	var previousDoc				= document.getElementById('txtPreviousDoc').value;
	var lcNo					= document.getElementById('txtLcNo').value;
	var bankRefNo				= document.getElementById('txtBankRefNo').value;
	var termsOfPayment			= document.getElementById('cboTermsOfPayment').value;
	var weight1					= (document.getElementById('txtWeight1').value=="" ? 0:document.getElementById('txtWeight1').value);
	var weight2					= document.getElementById('txtWeight2').value;
	var officeEntry				= document.getElementById('txtOfficeEntry').value;
	var buyerID					= document.getElementById('cboBuyer').value;
	var TQBNo					= document.getElementById('txtTQBNo').value;
	var authorizedBy			= document.getElementById('txtAuthorizedBy').value;
	
	var noOfPackages			= (document.getElementById('txtNoOfPackages').value);
	var marks					= document.getElementById('txtMarks').value;
	var packageType				= document.getElementById('cboPackageType').value;
	
	var FOB						= document.getElementById('txtFOB').value;
	var Insurance				= document.getElementById('txtInsurance').value;
	var Freight					= document.getElementById('txtFreight').value;
	var Other					= document.getElementById('txtOther').value;
	
	var forwaders				= document.getElementById('cboForwaders').value;
	var merchandiser			= document.getElementById('txtMerchandiser').value;
	var walfCleark				= document.getElementById('cboWalfCleark').value;
	
	var preferenceCode			= document.getElementById('txtPreferenceCode').value;
	var licenceNo				= document.getElementById('txtLicenceNo').value;
	var placeOfLoading			= document.getElementById('txtPlaceOfLoading').value;
	
	createXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=SaveRequest;
	xmlHttp[2].open("GET" ,'cusdecdb.php?RequestType=SaveDeliveryHeader&DeliveryNo=' +pub_No+ '&mode=' +mode+ '&invoice=' +URLEncode(invoice)+ 
	'&exporter=' +exporter+ '&consignee=' +consignee+ '&consigneeRefCode=' +consigneeRefCode+ 
	'&originCountry=' +originCountry+ '&exCountry=' +exCountry+ 
	'&lastConsiCity=' +lastConsiCity+ '&tradingCountry=' +tradingCountry+ '&vessel=' +URLEncode(vessel)+ '&deliveryTerm=' +URLEncode(deliveryTerm)+ 
	'&fcl=' +fcl+ '&cboFcl=' +cboFcl+ '&VoyageNo=' +VoyageNo+ '&containerNo=' +URLEncode(containerNo)+ 
	'&exRate=' +exRate+ '&currency=' +currency+ '&invoAmount=' +invoAmount+ '&bank=' +bank+ '&previousDoc=' +URLEncode(previousDoc)+ 
	'&lcNo=' +lcNo+ '&termsOfPayment=' +termsOfPayment+ '&weight1=' +weight1+ '&weight2=' +URLEncode(weight2)+
	'&officeEntry=' +URLEncode(officeEntry)+ '&buyerID=' +buyerID+ '&TQBNo=' +TQBNo+ '&authorizedBy=' +URLEncode(authorizedBy)+ 
	'&noOfPackages=' +noOfPackages+ '&marks=' +URLEncode(marks)+ '&packageType=' +packageType+ 
	'&FOB=' +FOB+ '&Insurance=' +Insurance+ '&Freight=' +Freight+ '&Other=' +Other+
	'&forwaders=' +forwaders+ '&merchandiser=' +URLEncode(merchandiser)+ '&walfCleark=' +walfCleark+ '&voyageDate=' +voyageDate+ '&recType=' +recType+ '&txtFcl=' +txtFcl+ '&preferenceCode=' +URLEncode(preferenceCode)+ '&licenceNo=' +URLEncode(licenceNo)+ '&placeOfLoading=' +URLEncode(placeOfLoading)+ '&bankRefNo=' +URLEncode(bankRefNo)+ '&invoiceDate=' +invoiceDate ,true);
	xmlHttp[2].send(null);
}

	function SaveRequest()
	{
		if(xmlHttp[2].readyState==4  && xmlHttp[2].status==200)
		{
			if(xmlHttp[2].responseText==1)
			{
				alert("Header in Cusdec No :"+pub_No+" saved successfully..");
				document.getElementById('optBoi').disabled="true";
				document.getElementById('optGenaral').disabled="true";
				hidePleaseWait();
			}
			else
			{
				
				headerCheckLoop++;
				if(headerCheckLoop>=10)
				{
					alert("Sorry!\nError occured while saving the data. Please Save it again.");
					headerCheckLoop = 0;
					hidePleaseWait();
					return;
					
				}
				else
				{
					Save();
				}
			}
		}
	}

function OpenItemPoPup()
{	
	createXMLHttpRequest(3);	
	xmlHttp[3].onreadystatechange=LoadStockDetailsRequest;
	xmlHttp[3].open("GET",'itempopup.php?',true);
	xmlHttp[3].send(null);
}

	function LoadStockDetailsRequest(){
		if (xmlHttp[3].readyState==4){
			if (xmlHttp[3].status==200){
				drawPopupArea(600,383,'frmMaterialTransfer');				
				var HTMLText=xmlHttp[3].responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;						
			}
		}
	}
	
function closeWindowDialog()
{
	hideBackGroundBalck();
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
	
	}
	catch(err)
	{        
	}	
}
//Start open pop up & ther part related with serach popup 
function SearchPopUp()
{	
if(document.getElementById('NoSearch').style.visibility=="hidden")
{
	document.getElementById('NoSearch').style.visibility = "visible";
	LoadPopUpDeliveryNo();
}
	else
	{
	document.getElementById('NoSearch').style.visibility="hidden";
	return;
	}	
}
function CloseSearchPopUp()
{	
if(document.getElementById('NoSearch').style.visibility=="visible")
{
	document.getElementById('NoSearch').style.visibility = "hidden";	
}	
}
//End open pop up & ther part related with serach popup
function LoadPopUpDeliveryNo()
{
	var recType 				= document.getElementById('txtDeliveryNo').parentNode.value;
	createXMLHttpRequest(4);	
	xmlHttp[4].onreadystatechange = LoadPopUpDeliveryNoRequest;
	xmlHttp[4].open("GET",'cusdecxml.php?RequestType=LoadPopUpDeliveryNo&recType=' +recType ,true);
	xmlHttp[4].send(null);
}
	function LoadPopUpDeliveryNoRequest()
	{
		if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
		{
			document.getElementById('cboNo').innerHTML = xmlHttp[4].responseText;
		}
	}

function LoadPopUpDeliveryNoToPage(deliveryNo)
{
	
	createXMLHttpRequest(4);	
	xmlHttp[4].onreadystatechange = LoadPopUpDeliveryNoToPageRequest;
	xmlHttp[4].open("GET",'cusdecxml.php?RequestType=loadPopUpDeliveryNoToPage&deliveryNo=' +deliveryNo ,true);
	xmlHttp[4].send(null);
}

function LoadPopUpDeliveryNoToPageRequest()
{
	if(xmlHttp[4].readyState==4 && xmlHttp[4].status==200)
	{
		var XMLDeliveryNo	= xmlHttp[4].responseXML.getElementsByTagName('DeliveryNo')[0].childNodes[0].nodeValue;
			document.getElementById('txtDeliveryNo').value = XMLDeliveryNo;
		
		var XMLInvoiceNo	= xmlHttp[4].responseXML.getElementsByTagName('InvoiceNo')[0].childNodes[0].nodeValue;		
			document.getElementById('txtInvoice').value = XMLInvoiceNo;
		
		var XMLMode	= xmlHttp[4].responseXML.getElementsByTagName('Mode')[0].childNodes[0].nodeValue;		
			document.getElementById('cboMode').value = XMLMode;
		
		var XMLExporterID	= xmlHttp[4].responseXML.getElementsByTagName('ExporterID')[0].childNodes[0].nodeValue;		
			document.getElementById('cboExporter').value = XMLExporterID;
		
		var XMLCustomerID	= xmlHttp[4].responseXML.getElementsByTagName('CustomerID')[0].childNodes[0].nodeValue;		
			document.getElementById('cboConsignee').value = XMLCustomerID;
			
		var XMLCtryOfOrigin	= xmlHttp[4].responseXML.getElementsByTagName('CtryOfOrigin')[0].childNodes[0].nodeValue;		
			document.getElementById('cboOrignCountry').value = XMLCtryOfOrigin;
			
		var XMLConsigneeRefCode	= xmlHttp[4].responseXML.getElementsByTagName('ConsigneeRefCode')[0].childNodes[0].nodeValue;		
			document.getElementById('txtConsigneeRetCode').value = XMLConsigneeRefCode;
			
		var XMLCtryOfExp	= xmlHttp[4].responseXML.getElementsByTagName('CtryOfExp')[0].childNodes[0].nodeValue;		
			document.getElementById('cboExCountry').value = XMLCtryOfExp;
			
		var XMLCityCode	= xmlHttp[4].responseXML.getElementsByTagName('CityCode')[0].childNodes[0].nodeValue;		
			document.getElementById('cboLastConsiCity').value = XMLCityCode;
			
		var XMLTradingCtry	= xmlHttp[4].responseXML.getElementsByTagName('TradingCtry')[0].childNodes[0].nodeValue;		
			document.getElementById('cboTradingCountry').value = XMLTradingCtry;
			
		var XMLVessel	= xmlHttp[4].responseXML.getElementsByTagName('Vessel')[0].childNodes[0].nodeValue;		
			document.getElementById('txtVessel').value = XMLVessel;
			
		var XMLDeliveryTerms	= xmlHttp[4].responseXML.getElementsByTagName('DeliveryTerms')[0].childNodes[0].nodeValue;		
			document.getElementById('txtDeliveryTerm').value = XMLDeliveryTerms;
			
		var XMLVoyageNo	= xmlHttp[4].responseXML.getElementsByTagName('VoyageNo')[0].childNodes[0].nodeValue;		
			document.getElementById('txtVoyageNo').value = XMLVoyageNo;
			
		var XMLContainerNo	= xmlHttp[4].responseXML.getElementsByTagName('ContainerNo')[0].childNodes[0].nodeValue;		
			document.getElementById('txtContainerNo').value = XMLContainerNo;
			
		var XMLCurrency	= xmlHttp[4].responseXML.getElementsByTagName('Currency')[0].childNodes[0].nodeValue;		
			document.getElementById('cboCurrency').options[document.getElementById('cboCurrency').selectedIndex].text = XMLCurrency;
			
		var XMLExRate	= xmlHttp[4].responseXML.getElementsByTagName('ExRate')[0].childNodes[0].nodeValue;		
			document.getElementById('txtExRate').value = XMLExRate;
		
		var XMLTotalInvoiceAmount	= xmlHttp[4].responseXML.getElementsByTagName('TotalInvoiceAmount')[0].childNodes[0].nodeValue;		
			document.getElementById('txtInvoAmount').value 	= XMLTotalInvoiceAmount;
			
		var XMLTotalAmount	= xmlHttp[4].responseXML.getElementsByTagName('TotalAmount')[0].childNodes[0].nodeValue;		
			document.getElementById('txtFOB').value 		= XMLTotalAmount;
			
		var XMLBankCode	= xmlHttp[4].responseXML.getElementsByTagName('BankCode')[0].childNodes[0].nodeValue;		
			document.getElementById('cboBank').value = XMLBankCode;
		
		var XMLPrevDoc	= xmlHttp[4].responseXML.getElementsByTagName('PrevDoc')[0].childNodes[0].nodeValue;		
			document.getElementById('txtPreviousDoc').value = XMLPrevDoc;
		
		var XMLLCNO	= xmlHttp[4].responseXML.getElementsByTagName('LCNO')[0].childNodes[0].nodeValue;		
			document.getElementById('txtLcNo').value = XMLLCNO;
			
		var XMLBankRefNo	= xmlHttp[4].responseXML.getElementsByTagName('BankRefNo')[0].childNodes[0].nodeValue;		
			document.getElementById('txtBankRefNo').value = XMLBankRefNo;
			
		var XMLTermsOfPayMent	= xmlHttp[4].responseXML.getElementsByTagName('TermsOfPayMent')[0].childNodes[0].nodeValue;		
			document.getElementById('cboTermsOfPayment').value = XMLTermsOfPayMent;
			
		var XMLWeight1	= xmlHttp[4].responseXML.getElementsByTagName('Weight1')[0].childNodes[0].nodeValue;		
			document.getElementById('txtWeight1').value = XMLWeight1;
			
		var XMLWeight2	= xmlHttp[4].responseXML.getElementsByTagName('Weight2')[0].childNodes[0].nodeValue;		
			document.getElementById('txtWeight2').value = XMLWeight2;
			
		var XMLOfficeOfEntry	= xmlHttp[4].responseXML.getElementsByTagName('OfficeOfEntry')[0].childNodes[0].nodeValue;		
			document.getElementById('txtOfficeEntry').value = XMLOfficeOfEntry;
			
		var XMLBuyerId	= xmlHttp[4].responseXML.getElementsByTagName('BuyerId')[0].childNodes[0].nodeValue;		
			document.getElementById('cboBuyer').value = XMLBuyerId;
			
		var XMLTQBNo	= xmlHttp[4].responseXML.getElementsByTagName('TQBNo')[0].childNodes[0].nodeValue;		
			document.getElementById('txtTQBNo').value = XMLTQBNo;
			
		var XMLAuthorizedBy	= xmlHttp[4].responseXML.getElementsByTagName('AuthorizedBy')[0].childNodes[0].nodeValue;		
			document.getElementById('txtAuthorizedBy').value = XMLAuthorizedBy;
			
		var XMLPackages	= xmlHttp[4].responseXML.getElementsByTagName('Packages')[0].childNodes[0].nodeValue;		
			document.getElementById('txtNoOfPackages').value = XMLPackages;
			
		var XMLMarks	= xmlHttp[4].responseXML.getElementsByTagName('Marks')[0].childNodes[0].nodeValue;		
			document.getElementById('txtMarks').value = XMLMarks;
			
		//var XMLFormula	= xmlHttp[4].responseXML.getElementsByTagName('Formula')[0].childNodes[0].nodeValue;		
			//document.getElementById('txtFormula').value = XMLFormula;
			
		var XMLPackType	= xmlHttp[4].responseXML.getElementsByTagName('PackType')[0].childNodes[0].nodeValue;		
			document.getElementById('cboPackageType').value = XMLPackType;
			
		var XMLInsurance	= xmlHttp[4].responseXML.getElementsByTagName('Insurance')[0].childNodes[0].nodeValue;		
			document.getElementById('txtInsurance').value = XMLInsurance;
			
		var XMLFreight	= xmlHttp[4].responseXML.getElementsByTagName('Freight')[0].childNodes[0].nodeValue;		
			document.getElementById('txtFreight').value = XMLFreight;
			
		var XMLOther	= xmlHttp[4].responseXML.getElementsByTagName('Other')[0].childNodes[0].nodeValue;		
			document.getElementById('txtOther').value = XMLOther;
			
		var XMLForwarder	= xmlHttp[4].responseXML.getElementsByTagName('Forwarder')[0].childNodes[0].nodeValue;		
			document.getElementById('cboForwaders').value = XMLForwarder;
			
		var XMLMerchandiser	= xmlHttp[4].responseXML.getElementsByTagName('Merchandiser')[0].childNodes[0].nodeValue;		
			document.getElementById('txtMerchandiser').value = XMLMerchandiser;
			
		var XMLWharfClerk	= xmlHttp[4].responseXML.getElementsByTagName('WharfClerk')[0].childNodes[0].nodeValue;		
			document.getElementById('cboWalfCleark').value = XMLWharfClerk;			
		
		var XMLformatedVoyageDate	= xmlHttp[4].responseXML.getElementsByTagName('formatedVoyageDate')[0].childNodes[0].nodeValue;		
			document.getElementById('txtVoyageDate').value = XMLformatedVoyageDate;
			
		var XMLFcl					= xmlHttp[4].responseXML.getElementsByTagName('Fcl')[0].childNodes[0].nodeValue;
			document.getElementById('chkFcl').checked=(XMLFcl == 1 ? "checked":"");
			document.getElementById('cboFcl').disabled=(XMLFcl == 1 ? false:true);
			document.getElementById('txtFcl').disabled=(XMLFcl == 1 ? false:true);
			
		var XMLFeet					= xmlHttp[4].responseXML.getElementsByTagName('Feet')[0].childNodes[0].nodeValue;
			document.getElementById('cboFcl').value = XMLFeet;
			
		var XMLCountOfContainer					= xmlHttp[4].responseXML.getElementsByTagName('CountOfContainer')[0].childNodes[0].nodeValue;
			document.getElementById('txtFcl').value = XMLCountOfContainer;
			
		var XMLPreferenceCode					= xmlHttp[4].responseXML.getElementsByTagName('PreferenceCode')[0].childNodes[0].nodeValue;
			document.getElementById('txtPreferenceCode').value = XMLPreferenceCode;
		
		var XMLLicenceNo					= xmlHttp[4].responseXML.getElementsByTagName('LicenceNo')[0].childNodes[0].nodeValue;
			document.getElementById('txtLicenceNo').value = XMLLicenceNo;
			
		var XMLPlaceOfLoading					= xmlHttp[4].responseXML.getElementsByTagName('PlaceOfLoading')[0].childNodes[0].nodeValue;
			document.getElementById('txtPlaceOfLoading').value = XMLPlaceOfLoading;
		
		var XMLformatedInvoiceDate= xmlHttp[4].responseXML.getElementsByTagName('formatedInvoiceDate')[0].childNodes[0].nodeValue;
			var invoiceDate				= document.getElementById('txtDate').value = XMLformatedInvoiceDate;
	}
	document.getElementById('NoSearch').style.visibility="hidden";
	document.getElementById('optBoi').disabled="true";
	document.getElementById('optGenaral').disabled="true";
}

function PrintCusdec()
{
	var No =document.getElementById("txtDeliveryNo").value;
	if(No=="" || No=="0"){
		alert("No delivery no appear to view..");
		return false;
	}
	
	newwindow=window.open('cusdecReport.php?deliveryNo='+No ,'name');
	if (window.focus) {newwindow.focus()}
}
function PrintOtherReport()
{
	var No =document.getElementById("txtDeliveryNo").value;
	if(No=="" || No=="0"){
		alert("No delivery no appear to view..");
		return false;
	}
	
	newwindow=window.open('customreport/examinationofcontainercargo.php?deliveryNo='+No ,'PrintOtherReport1');
	if (window.focus) {newwindow.focus()}
	
	newwindow=window.open('customreport/examinationofcontainercargo_back.php?deliveryNo='+No ,'PrintOtherReport2');
	if (window.focus) {newwindow.focus()}
	
	newwindow=window.open('customreport/customvaluedeclaration.php?deliveryNo='+No ,'PrintOtherReport3');
	if (window.focus) {newwindow.focus()}
	
	newwindow=window.open('customreport/customvaluedeclaration_back.php?deliveryNo='+No ,'PrintOtherReport4');
	if (window.focus) {newwindow.focus()}
}

function CancelCusdec()
{
	var No =document.getElementById("txtDeliveryNo").value;
	if(confirm("Are u sure you want to cancel Cusdec No : "+No+" ?"))
	{
		createXMLHttpRequest(5);
		xmlHttp[5].onreadystatechange = CancelCusdecRequest;
		xmlHttp[5].index	= No;
		xmlHttp[5].open("GET",'cusdecxml.php?RequestType=CancelCusdec&deliveryNo=' +No ,true);
		xmlHttp[5].send(null);
	}
}

function CancelCusdecRequest()
{
	if(xmlHttp[5].readyState==4 && xmlHttp[5].status==200)
	{
		
		if(xmlHttp[5].responseText=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
			alert("Cusdec No :"+xmlHttp[5].index+" Canceled.");
		else		
			CancelCusdec();
		
	}
}

function SetFOBValue(obj)
{
	document.getElementById('txtFOB').value = obj.value;
}

function SetOptionValue(obj)
{
	if(document.getElementById('optBoi').checked)
	{
		document.getElementById('txtDeliveryNo').parentNode.value = document.getElementById('optBoi').value;
	}
	else if(document.getElementById('optGenaral').checked)
	{
		document.getElementById('txtDeliveryNo').parentNode.value = document.getElementById('optGenaral').value;
	}
}
function GetTQBNo(obj)
{
	var CustomerID	= obj.value;
	createXMLHttpRequest(6);	
	xmlHttp[6].onreadystatechange = GetTQBNoRequest;
	xmlHttp[6].open("GET" ,'cusdecxml.php?RequestType=GetTQBNo&CustomerID=' +CustomerID ,true);
	xmlHttp[6].send(null);
}
	function GetTQBNoRequest()
	{
		if(xmlHttp[6].readyState==4 && xmlHttp[6].status==200)
		{
			document.getElementById('txtTQBNo').value = "";
			var XMLTQBNo	= xmlHttp[6].responseXML.getElementsByTagName('TQBNo')[0].childNodes[0].nodeValue;		
			document.getElementById('txtTQBNo').value = XMLTQBNo;
		}
	}

function GetCurrencyRate(obj)
{
	var CurrencyCode	= obj.value;
	createXMLHttpRequest(7);	
	xmlHttp[7].onreadystatechange = GetCurrencyRateRequest;
	xmlHttp[7].open("GET" ,'cusdecxml.php?RequestType=GetCurrencyRate&CurrencyCode=' +CurrencyCode ,true);
	xmlHttp[7].send(null);
}
	function GetCurrencyRateRequest()
	{
		if(xmlHttp[7].readyState==4 && xmlHttp[7].status==200)
		{
			document.getElementById('txtExRate').value = "";
			var XMLCurrencyRate	= xmlHttp[7].responseXML.getElementsByTagName('CurrencyRate')[0].childNodes[0].nodeValue;		
			document.getElementById('txtExRate').value = XMLCurrencyRate;
		}
	}
	
function AutoCompleteAuthorizeName(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode == 40)
	{
		document.getElementById("lstStyleNos").focus();
		return ;
	}
	//RemoveCurrentStyleList();
	var text = document.getElementById('txtAuthorizedBy').value;
	if (trim(text) == "" || trim(text) == null ||  charCode == 27 )
	{
		closeList();
		return;
	}
	
	createXMLHttpRequest(8);
   	xmlHttp[8].onreadystatechange = AutoCompleteAuthorizeNameRequest;
    xmlHttp[8].open("GET", 'cusdecxml.php?RequestType=GetAuthorizeName&InputLatter=' + URLEncode(text), true);
    xmlHttp[8].send(null);     
}
function AutoCompleteAuthorizeNameRequest()
{
	if(xmlHttp[8].readyState==4 && xmlHttp[8].status==200) 
        {  
			
			if (document.getElementById("lstStyleNos") == null)
			{
				var html = "<div id=\"listDiv\" style=\"width:200px; height:150px\">" +
							"<select name=\"select\" size=\"1\" id=\"lstStyleNos\" onkeydown=\"ItemListKeyHandler(event)\" onchange=\"ShowSelectedStyleNo();\" style=\"width:200px; height:150px\" multiple=\"multiple\" class=\"normalfnt\" onblur=\"closeList();\"></select></div>";
				
				var popupbox = document.createElement("div");
				 popupbox.id = "stylelist";
				 popupbox.style.position = 'absolute';
				 popupbox.style.zIndex = 2;
				 popupbox.style.left = curLeft(document.getElementById('txtAuthorizedBy')) + "px";
				 popupbox.style.top = eval(curTop(document.getElementById('txtAuthorizedBy')) + document.getElementById('txtAuthorizedBy').offsetHeight) + "px"; 
				 popupbox.innerHTML = html;     
				 popupbox.ondblclick = closeList;
				 document.body.appendChild(popupbox);
			}
			 
			 var available = false;
			 var XMLAuthorizeName = xmlHttp[8].responseXML.getElementsByTagName("AuthorizeName");
			 RomoveData('lstStyleNos');
			 for ( var loop = 0; loop < XMLAuthorizeName.length; loop ++)
			 {
				 available = true;
				 var opt = document.createElement("option");
				opt.text = XMLAuthorizeName[loop].childNodes[0].nodeValue;
				opt.value = XMLAuthorizeName[loop].childNodes[0].nodeValue;
				document.getElementById("lstStyleNos").options.add(opt);				
			 }
			 
			 if (available == false)
			 	closeList();			
		}
}
function ShowSelectedStyleNo()
{
	document.getElementById('txtAuthorizedBy').value = document.getElementById("lstStyleNos").value;
}