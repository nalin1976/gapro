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

function SetSC(obj)
{
	document.getElementById('cboScNo').value =obj.value;
	LoadOtherDetails();
}

function SetStyle(obj)
{
	document.getElementById('cboOrderNo').value =obj.value;
	LoadOtherDetails();
}

function LoadOtherDetails(){
	loadBuyerPONo();
	loadMaterial();
	loadSubCategory();
	//loadItemDetails();
}

function ShowReport()
{
	var strStyleNo		= document.getElementById('cboScNo').value;
	 //document.getElementById('cboStyleNo').options[document.getElementById('cboStyleNo').selectedIndex].text;
	var strBPo 			= document.getElementById('cboBPo').value;	
	var intMeterial 	= document.getElementById('cboMeterial').value;
	var intCategory 	= document.getElementById('cboCategory').value;
	var intDescription 	= document.getElementById('cboDescription').value;
	var intSupplier 	= document.getElementById('cboSupplier').value;
	var intBuyer 	  	= document.getElementById('cboBuyer').value;
	var dtmDateFrom	  	= document.getElementById('dtmDateFrom').value;
	var dtmDateTo 	  	= document.getElementById('dtmDateTo').value;	
	var intSupplier		= document.getElementById('cboSupplier').value;	 
	var intBuyer		= document.getElementById('cboBuyer').value;	 
	var intCompany 		= document.getElementById('cboProductCompany').value;	 
	var noFrom 		= document.getElementById('txtponofrom').value;	
	var noTo	 		= document.getElementById('txtponoto').value;	
	var txtMatItem 		= trim(document.getElementById('txtMatItem').value);
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
	else if(ReportId == 'radOpenPO')
	{
		//var reportName	= "reports/rptOpenPo.php?";	
		var reportName	= "rptOpenPOList.php?";		
	}
	
	else if(ReportId == 'radCompPo')
	{
		var reportName	= "rptCompletePOList.php?";		
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
	
	else if (ReportId=='radConGatePassTrIn' || ReportId=='radCancelGatPassTrIn')													//Gate Pass Transfer In Report
	{
		var reportName	= "reports/rptgatepasstransferin.php?";
	}
	
	else if ((ReportId=='radSaveIntJobTrns')||(ReportId=='radApprIntJobTrns')||(ReportId=='radAuthIntJobTrns')||(ReportId=='radConfIntJobTrns')||(ReportId=='radCanIntJobTrns'))												//Style to style Transfer Report
	{
		var reportName	= "reports/rptinterjobtransfer.php?";
	}
	else if(ReportId=='radConMRN' || ReportId=='radPenMRN')
		var reportName	= "reports/rptMRN.php?";
	//URLEncode(strStyleNo)
	
		newwindow=window.open(reportName+'strStyleNo='+strStyleNo+'&strBPo='+URLEncode(strBPo)+'&intMeterial='+intMeterial+'&intCategory='+intCategory+'&intDescription='+intDescription+'&intSupplier='+intSupplier+'&intBuyer='+intBuyer+'&dtmDateFrom='+dtmDateFrom+'&dtmDateTo='+dtmDateTo+'&status='+stateID+'&intCompany='+intCompany+ '&noFrom=' +noFrom+ '&noTo=' +noTo+'&txtMatItem='+URLEncode(txtMatItem), 'report');	
	if (window.focus) {newwindow.focus()}
}

function ShowExcelReport()
{
	var strStyleNo		= document.getElementById('cboOrderNo').value;
	var strBPo 			= document.getElementById('cboBPo').value;	
	var intMeterial 	= document.getElementById('cboMeterial').value;
	var intCategory 	= document.getElementById('cboCategory').value;
	var intDescription 	= document.getElementById('cboDescription').value;
	var intSupplier 	= document.getElementById('cboSupplier').value;
	var intBuyer 	  	= document.getElementById('cboBuyer').value;
	var dtmDateFrom	  	= document.getElementById('dtmDateFrom').value;
	var dtmDateTo 	  	= document.getElementById('dtmDateTo').value;	
	var intSupplier		= document.getElementById('cboSupplier').value;	 
	var intBuyer		= document.getElementById('cboBuyer').value;	 
	var intCompany 		= document.getElementById('cboProductCompany').value;	 
	var noFrom 		= document.getElementById('txtponofrom').value;	
	var noTo	 		= document.getElementById('txtponoto').value;	
	var txtMatItem 		= trim(document.getElementById('txtMatItem').value);
	//alert(intCompany);
	var ReportId = getReportId();

	if (ReportId=='-1') 
	{
		alert('Please select a one option.');
		return;
	}
	
	else if ((ReportId=='radConPO')||(ReportId=='radPenPO')||(ReportId=='radCanPO') || (ReportId=='radOpenPO') ||(ReportId=='radCompPo'))			// Po Report
	{
		var reportName	= "reportxcel/rptxcelpurchaseorders.php?";		
	}
	
	else if ((ReportId=='radConGRN')||(ReportId=='radPenGRN')||(ReportId=='radCanGRN'))			//GRN Report
	{
		var reportName	= "reportxcel/rptexcelgrn.php?";
	}
	
	else if (ReportId=='radConIssue')															//Issue Report
	{
		var reportName	= "reportxcel/rptexcelissues.php?";
	}
	
	else if ((ReportId=='radConRetToSto')||(ReportId=='radCanRetToSto'))						//Return To Stores Report
	{
		var reportName	= "reportxcel/rptexcelreturntostores.php?";
	}
	
	else if ((ReportId=='radConRetToSup')||(ReportId=='radCanRetToSup'))						//Return To Supplier Report
	{
		var reportName	= "reportxcel/rptexcelreturntosupplier.php?";
	}
	
	else if (ReportId=='radConGatePass')														//Gate Pass Report
	{
		var reportName	= "reportxcel/rptexcelgatepass.php?";
	}	
	
	else if (ReportId=='radConGatePassTrIn')													//Gate Pass Transfer In Report
	{
		var reportName	= "reportxcel/rptexcelgatepasstranferIn.php?";
	}
	
	else if ((ReportId=='radSaveIntJobTrns')||(ReportId=='radApprIntJobTrns')||(ReportId=='radAuthIntJobTrns')||(ReportId=='radConfIntJobTrns')||(ReportId=='radCanIntJobTrns'))												//Style to style Transfer Report
	{
		var reportName	= "reportxcel/rptexcelinterjob.php?";
	}
	else if ((ReportId=='radConMRN')||(ReportId=='radPenMRN'))						//Return To Supplier Report
	{
		var reportName	= "reportxcel/rptexcelMRN.php?";
	}
	
		newwindow=window.open(reportName+'strStyleNo='+URLEncode(strStyleNo)+'&strBPo='+URLEncode(strBPo)+'&intMeterial='+intMeterial+'&intCategory='+intCategory+'&intDescription='+intDescription+'&intSupplier='+intSupplier+'&intBuyer='+intBuyer+'&dtmDateFrom='+dtmDateFrom+'&dtmDateTo='+dtmDateTo+'&status='+stateID+'&intCompany='+intCompany+ '&noFrom=' +noFrom+ '&noTo=' +noTo+'&txtMatItem='+txtMatItem+'&ReportId='+ReportId, 'report');	
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

function loadBuyerPONo()
{
	RemoveBuyerPOs();
	var styleID = document.getElementById('cboScNo').value;
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

function loadMaterial()
{
	RemoveMaterial();
	var styleID	=  document.getElementById('cboScNo').value;
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

function loadSubCategory()
{
	RemoveCategory();
	var styleID	= document.getElementById('cboScNo').value;
	var materialNo = document.getElementById('cboMeterial').value;	
	createNewXMLHttpRequest(3);
	xmlHttpreq[3].onreadystatechange = HandleCategory;
	xmlHttpreq[3].open("GET",'reportMiddleTire.php?RequestType=getCategory&styleID='+URLEncode(styleID)+'&materialNo='+materialNo, true);	
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
	/*var index = document.getElementById("cboCategory").options.length;
	while(document.getElementById("cboCategory").options.length > 0) 
	{
		index --;
		document.getElementById("cboCategory").options[index] = null;
	}*/
	//document.getElementById('cboCategory').innerHTML = '';
}


// Item Details ----------------------------------------------------------------------
 
function loadItemDetails()
{
	RemoveItemDetails();
	var styleID	= document.getElementById('cboScNo').value;
	var materialNo = document.getElementById('cboMeterial').value;
	var categoryNo = document.getElementById('cboCategory').value;
	var matItem =  document.getElementById('txtMatItem').value;
	createNewXMLHttpRequest(4);
	xmlHttpreq[4].onreadystatechange = HandleItemDetails;
	xmlHttpreq[4].open("GET",'reportMiddleTire.php?RequestType=getItemDetails&styleID='+URLEncode(styleID)+'&materialNo='+materialNo+'&categoryNo='+categoryNo+'&matItem='+URLEncode(matItem), true);	
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
	var inht = document.getElementById('cboDescription').innerHTML;
	inht = '';
}

function GetStyleWiseOrderNo(obj)
{	
	var status = "11,13";
	var booUser	= false;
	var url = "reportMiddleTire.php?RequestType=GetStyleWiseOrderNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML  = htmlobj.responseText;
}
function GetStyleWiseScNo(obj)
{	
	var status = "11,13";
	var booUser	= false;
	var url = "reportMiddleTire.php?RequestType=GetStyleWiseScNoInReports&styleNo=" +obj+ '&status='+status+ '&booUser=' +booUser;
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboScNo').innerHTML  = htmlobj.responseText;
}

function enableEnterLooadItems(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//alert(charCode);
			 if (charCode == 13)
				loadItemDetails();
}