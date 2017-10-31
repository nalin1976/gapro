// JavaScript Document

var xmlHttp;
var xmlHttpreq = [];
var reportName = "";
var stateID = 0;

function setReport(rpt,status)
{
	reportName = rpt;
	stateID = status;	
}

function createXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp = new XMLHttpRequest();
    }
}

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttpreq[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpreq[index] = new XMLHttpRequest();
    }
}

function Clear(obj){
	if(obj.checked){
		document.getElementById('dtmDateFrom').disabled = false;
		document.getElementById('dtmDateTo').disabled = false;	
	}
	else{
		document.getElementById('dtmDateFrom').disabled = true;
		document.getElementById('dtmDateTo').disabled = true;	
		document.getElementById('dtmDateFrom').value = "";
		document.getElementById('dtmDateTo').value = "";	
	}
}
function SetSC(){
	var StyleID =document.getElementById('cboStyleNo').options[document.getElementById('cboStyleNo').selectedIndex].text;
	document.getElementById('cboScNo').value =StyleID;
	LoadOtherDetails();
}

function SetStyle(){
	var ScNo =document.getElementById('cboScNo').options[document.getElementById('cboScNo').selectedIndex].text;
	document.getElementById('cboStyleNo').value =ScNo;
	LoadOtherDetails();
}

function LoadOtherDetails(){
	loadBuyerPONo();
	loadMaterial();
	loadSubCategory();
	loadItemDetails();
}

function ShowReport()
{
	var intMeterial 	= document.getElementById('cboMeterial').value;
	var intCategory 	= document.getElementById('cboCategory').value;
	var intDescription 	= document.getElementById('cboDescription').value;
	var intSupplier 	= document.getElementById('cboSupplier').value;
	var dtmDateFrom	  	= document.getElementById('dtmDateFrom').value;
	var dtmDateTo 	  	= document.getElementById('dtmDateTo').value;	
	var intSupplier		= document.getElementById('cboSupplier').value;	 
	var intCompany 		= document.getElementById('cboCompany').value;	 
	var noFrom 		= document.getElementById('txtponofrom').value;	
	var noTo	 		= document.getElementById('txtponoto').value;	
	
	//alert(intCompany);
	var ReportId = getReportId();

	if (ReportId=='-1') 
	{
		alert('Please select a one option.');
		return;
	}
	
	else if ((ReportId=='radConPO')||(ReportId=='radPenPO')||(ReportId=='radCanPO'))			// Po Report
	{
		var reportName	= "reports/rptpurchaseorder.php?";		
	}
	
	else if ((ReportId=='radConGRN')||(ReportId=='radPenGRN')||(ReportId=='radCanGRN'))			//GRN Report
	{
		var reportName	= "reports/rptgrn.php?";
	}
	
	else if (ReportId=='radConIssue')															//Issue Report
	{
		var reportName	= "reports/rptissues.php?";
	}
	
	else if ((ReportId=='radConRetToSto')||(ReportId=='radCanRetToSto'))						//Return To Stores Report
	{
		var reportName	= "reports/rptreturntostores.php?";
	}
	
	else if ((ReportId=='radConRetToSup')||(ReportId=='radCanRetToSup'))						//Return To Supplier Report
	{
		var reportName	= "reports/rptreturntosupplier.php?";
	}
	
	else if (ReportId=='radConGatePass')														//Gate Pass Report
	{
		var reportName	= "reports/rptgatepass.php?";
	}	
	
	else if (ReportId=='radConGatePassTrIn')													//Gate Pass Transfer In Report
	{
		var reportName	= "reports/rptgatepasstransferin.php?";
	}
	
	else if ((ReportId=='radSaveIntJobTrns')||(ReportId=='radApprIntJobTrns')||(ReportId=='radAuthIntJobTrns')||(ReportId=='radConfIntJobTrns')||(ReportId=='radCanIntJobTrns'))												//Style to style Transfer Report
	{
		var reportName	= "reports/rptinterjobtransfer.php?";
	}
	
		newwindow=window.open(reportName+'intMeterial='+intMeterial+'&intCategory='+intCategory+'&intDescription='+intDescription+'&intSupplier='+intSupplier+'&dtmDateFrom='+dtmDateFrom+'&dtmDateTo='+dtmDateTo+'&status='+stateID+'&intCompany='+intCompany+ '&noFrom=' +noFrom+ '&noTo=' +noTo, 'report');	
	if (window.focus) {newwindow.focus()}
}

function ShowExcelReport()
{
	var intMeterial 	= document.getElementById('cboMeterial').value;
	var intCategory 	= document.getElementById('cboCategory').value;
	var intDescription 	= document.getElementById('cboDescription').value;
	var intSupplier 	= document.getElementById('cboSupplier').value;
	var dtmDateFrom	  	= document.getElementById('dtmDateFrom').value;
	var dtmDateTo 	  	= document.getElementById('dtmDateTo').value;	
	var intCompany 		= document.getElementById('cboCompany').value;	 
	var noFrom 			= document.getElementById('txtponofrom').value;	
	var noTo	 		= document.getElementById('txtponoto').value;	
	
	//alert(intCompany);
	var ReportId = getReportId();

	if (ReportId=='-1') 
	{
		alert('Please select a one option.');
		return;
	}
	
	else if ((ReportId=='radConPO')||(ReportId=='radPenPO')||(ReportId=='radCanPO'))			// Po Report
	{
		var reportName	= "reportxcel/rptxcelpurchaseorders.php?";		
	}
	
	else if ((ReportId=='radConGRN')||(ReportId=='radPenGRN')||(ReportId=='radCanGRN'))			//GRN Report
	{
		var reportName	= "reportxcel/rptgrn.php?";
	}
	
	else if (ReportId=='radConIssue')															//Issue Report
	{
		var reportName	= "reportxcel/rptissues.php?";
	}
	
	else if ((ReportId=='radConRetToSto')||(ReportId=='radCanRetToSto'))						//Return To Stores Report
	{
		var reportName	= "reportxcel/rptreturntostores.php?";
	}
	
	else if ((ReportId=='radConRetToSup')||(ReportId=='radCanRetToSup'))						//Return To Supplier Report
	{
		var reportName	= "reportxcel/rptreturntosupplier.php?";
	}
	
	else if (ReportId=='radConGatePass')														//Gate Pass Report
	{
		var reportName	= "reportxcel/rptgatepass.php?";
	}	
	
	else if (ReportId=='radConGatePassTrIn')													//Gate Pass Transfer In Report
	{
		var reportName	= "reportxcel/rptgatepasstransferin.php?";
	}
	
	else if ((ReportId=='radSaveIntJobTrns')||(ReportId=='radApprIntJobTrns')||(ReportId=='radAuthIntJobTrns')||(ReportId=='radConfIntJobTrns')||(ReportId=='radCanIntJobTrns'))												//Style to style Transfer Report
	{
		var reportName	= "reportxcel/rptinterjobtransfer.php?";
	}
	
		newwindow=window.open(reportName+'&intMeterial='+intMeterial+'&intCategory='+intCategory+'&intDescription='+intDescription+'&intSupplier='+intSupplier+'&dtmDateFrom='+dtmDateFrom+'&dtmDateTo='+dtmDateTo+'&status='+stateID+'&intCompany='+intCompany+ '&noFrom=' +noFrom+ '&noTo=' +noTo, 'report');	
	if (window.focus) {newwindow.focus()}
}

function getReportId()
{
	var buttonCount = document.frmStyleReport.radio.length;
	var selected = '';
	for (count=0; count<buttonCount; count++)
	{
		if (document.frmStyleReport.radio[count].checked) selected = document.frmStyleReport.radio[count].value;
	}
	if (selected=='') return -1; 
	else return selected; 
}


// Buyer PO -------------------------------------------------------------------
function loadBuyerPONo()
{
	
	RemoveBuyerPOs();
	var styleID	= document.getElementById('cboStyleNo').options[document.getElementById('cboStyleNo').selectedIndex].text;
	createNewXMLHttpRequest(1);
	xmlHttpreq[1].onreadystatechange = HandleBuyerPOs;	
	xmlHttpreq[1].open("GET",'reportMiddleTire.php?RequestType=getBuyerPO&styleID='+URLEncode(styleID), true);	
	xmlHttpreq[1].send(null);		
}

function HandleBuyerPOs()
{
    if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        {  
			document.getElementById('cboBPo').innerHTML = xmlHttpreq[1].responseText;
		}
	}
}

function RemoveBuyerPOs()
{
	var index = document.getElementById("cboBPo").options.length;
	while(document.getElementById("cboBPo").options.length > 0) 
	{
		index --;
		document.getElementById("cboBPo").options[index] = null;
	}
}

// Material ----------------------------------------------------------------------
 
function loadMaterial()
{
	RemoveMaterial();
	var styleID	= document.getElementById('cboStyleNo').options[document.getElementById('cboStyleNo').selectedIndex].text;
	createNewXMLHttpRequest(2);
	xmlHttpreq[2].onreadystatechange = HandleMaterial;
	xmlHttpreq[2].open("GET",'reportMiddleTire.php?RequestType=getMaterial&styleID='+URLEncode(styleID), true);	
	xmlHttpreq[2].send(null);	
}

function HandleMaterial()
{
    if(xmlHttpreq[2].readyState == 4) 
    {
        if(xmlHttpreq[2].status == 200) 
        {  
			document.getElementById('cboMeterial').innerHTML = xmlHttpreq[2].responseText;
		}
	}
}

function RemoveMaterial()
{
	var index = document.getElementById("cboMeterial").options.length;
	while(document.getElementById("cboMeterial").options.length > 0) 
	{
		index --;
		document.getElementById("cboMeterial").options[index] = null;
	}
}

// Sub Category ----------------------------------------------------------------------
 
 function loadSubCategory()
{
	RemoveCategory();
	//var styleID	= document.getElementById('cboStyleNo').options[document.getElementById('cboStyleNo').selectedIndex].text;
	var materialNo = document.getElementById('cboMeterial').value;	
	//alert (materilNo);
	createNewXMLHttpRequest(3);
	xmlHttpreq[3].onreadystatechange = HandleCategory;
	xmlHttpreq[3].open("GET",'reportMiddleTire.php?RequestType=getCategory&materialNo='+materialNo, true);	
	xmlHttpreq[3].send(null);	
}

function HandleCategory()
{
    if(xmlHttpreq[3].readyState == 4) 
    {
        if(xmlHttpreq[3].status == 200) 
        {  
			document.getElementById('cboCategory').innerHTML = xmlHttpreq[3].responseText;
		}
	}
}

function RemoveCategory()
{
	var index = document.getElementById("cboCategory").options.length;
	while(document.getElementById("cboCategory").options.length > 0) 
	{
		index --;
		document.getElementById("cboCategory").options[index] = null;
	}
}


// Item Details ----------------------------------------------------------------------
 
function loadItemDetails()
{
	RemoveItemDetails();
//	var styleID	= document.getElementById('cboStyleNo').options[document.getElementById('cboStyleNo').selectedIndex].text;
	var materialNo = document.getElementById('cboMeterial').value;
	var categoryNo = document.getElementById('cboCategory').value;	
	createNewXMLHttpRequest(4);
	xmlHttpreq[4].onreadystatechange = HandleItemDetails;
	xmlHttpreq[4].open("GET",'reportMiddleTire.php?RequestType=getItemDetails&materialNo='+materialNo+'&categoryNo='+categoryNo, true);	
	xmlHttpreq[4].send(null);	
}

function HandleItemDetails()
{
    if(xmlHttpreq[4].readyState == 4) 
    {
        if(xmlHttpreq[4].status == 200) 
        {  
			document.getElementById('cboDescription').innerHTML = xmlHttpreq[4].responseText;
		}
	}
}

function RemoveItemDetails()
{
	var index = document.getElementById("cboDescription").options.length;
	while(document.getElementById("cboDescription").options.length > 0) 
	{
		index --;
		document.getElementById("cboDescription").options[index] = null;
	}
}