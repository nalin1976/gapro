var xmlHttp;
var xmlHttp1 = [];
var xmlHttp2;
var xmlHttp3 = [];

var mainArrayIndex = 0;
var Materials = [];

var mainRw=0;
var subCatID;

var gatePassNo = 0;
var gatePassYear =0;

var validateCount = 0;
var validateBinCount =0;

var pub_commonBin		= 0;
var pub_mainStoreID		= 0;
var pub_subStoreID		= 0;

function ClearFormGP()
{	
	/*$("#frmGPTranferIn")[0].reset();
	$("#tblTransInMain tr:gt(0)").remove();
	$("#cboSubStores").html('');
	document.getElementById('cmdSave').style.display='inline';
	loadGPnolist();	*/
	
	 location = "gentranferin.php";
}

function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}
//start - configuring HTTP request
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
//End - configuring HTTP request

//start - configuring HTTP1 array request
function createXMLHttpRequest1(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp1[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP1 array request


//Start - Public remove data function
function RomoveData(data)
{
		var index = document.getElementById(data).options.length;
		while(document.getElementById(data).options.length > 0) 
		{
			index --;
			document.getElementById(data).options[index] = null;
		}
}
//End - Public remove data function

//Start-Delete selected table row from the Table issue.php
function RemoveItem(obj,id)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[id] = null;
	}
}
//End-Delete selected table row from the Table issue.php


function loadGrnFrom(intGrnNo,intYear,category)
{
	
	//alert(intGrnNo +" "+ intYear  +" "+ category );
	if ((intGrnNo!=0)||(intYear!=0))
	{
		if(category==1)
		{
			document.getElementById("cmdSave").style.display="none";
			document.getElementById("butCancel").style.displat="inline";
			//alert(1);
			document.getElementById("cboGPTransInNo").value = intYear +"/"+ intGrnNo;
			
			createXMLHttpRequest();
			xmlHttp.onreadystatechange = grnHeaderRequest;
			var url  = "gentranferinXml.php?RequestType=LoadPopUpHeaderDetails";
				url += "&intGrnNo="+intGrnNo;
				url += "&intYear="+intYear;
				xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
			var url = 'gentranferinXml.php?RequestType=LoadPopUpDetails&intGrnNo='+intGrnNo+'&intYear='+intYear;
			htmlobj=$.ajax({url:url,async:false});
			grnDetailRequest(htmlobj);
			
		}
		else if(category==10)
		{
			document.getElementById("cmdSave").style.display="none";
			document.getElementById("butCancel").style.display="none";
			
			document.getElementById("cboGPTransInNo").value = intYear +"/"+ intGrnNo;
			
			createXMLHttpRequest();
			xmlHttp.onreadystatechange = grnHeaderRequest;
			var url  = "gentranferinXml.php?RequestType=LoadPopUpHeaderDetails";
				url += "&intGrnNo="+intGrnNo;
				url += "&intYear="+intYear;
				xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
	
			var url = 'gentranferinXml.php?RequestType=LoadPopUpDetails&intGrnNo='+intGrnNo+'&intYear='+intYear;
			htmlobj=$.ajax({url:url,async:false});
			grnDetailRequest(htmlobj);
		}
		else if(category==0)
		{
			document.getElementById("butCancel").style.display="none";
		}
		
	}	
	else
	{
		document.getElementById("cmdSave").style.display="inline";
		document.getElementById("butCancel").style.display="none";
	}
}

function grnHeaderRequest()
{
    if(xmlHttp.readyState == 4)
    {
        if(xmlHttp.status == 200) 
        { 
		XMLGatepassNo = xmlHttp.responseXML.getElementsByTagName("GatePassNo")[0].childNodes[0].nodeValue;
		var title_txt="<input type=\"text\" class=\"txtbox\" name=\"textTitle\" id=\"txtTitle\" width=\"width:175px\" value=\""+XMLGatepassNo+"\" readonly=\"\" >";
		$('#Gatepassno_cell').html(title_txt);
			
			document.getElementById("txtRemarks").value = xmlHttp.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
			document.getElementById("cboGPTransInNo").value = xmlHttp.responseXML.getElementsByTagName("GpTranferNo")[0].childNodes[0].nodeValue;
			document.getElementById("cboGatePassNo2").value = xmlHttp.responseXML.getElementsByTagName("formatedDate")[0].childNodes[0].nodeValue;
		}
	}
	
}

function grnDetailRequest(xmlHttp3)
{
   
			var tbl						= document.getElementById('tblTransInMain');
			var MatDetailID				= xmlHttp3.responseXML.getElementsByTagName("MatDetailID");
			
			for (var loop =0; loop < MatDetailID.length; loop ++)
			{
		
				var XMLMatDetailID		= MatDetailID[loop].childNodes[0].nodeValue;
				var XMLItemDesc			= xmlHttp3.responseXML.getElementsByTagName("itemDiscription")[loop].childNodes[0].nodeValue;
			var XMLUnit				= xmlHttp3.responseXML.getElementsByTagName("strUnit")[loop].childNodes[0].nodeValue;
			var XMLQty				= xmlHttp3.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
			var XMLGRNno 			= xmlHttp3.responseXML.getElementsByTagName("grnNo")[loop].childNodes[0].nodeValue;
			var XMLGRNyear 			= xmlHttp3.responseXML.getElementsByTagName("grnYear")[loop].childNodes[0].nodeValue;
			var XMLBalQty 			= xmlHttp3.responseXML.getElementsByTagName("balQty")[loop].childNodes[0].nodeValue;
			var XMLCostCenterId 	= xmlHttp3.responseXML.getElementsByTagName("costCenterId")[loop].childNodes[0].nodeValue;
			var XMLCostCenterDes 	= xmlHttp3.responseXML.getElementsByTagName("costCenterDes")[loop].childNodes[0].nodeValue;
			var XMLglAlloId 		= xmlHttp3.responseXML.getElementsByTagName("glAlloId")[loop].childNodes[0].nodeValue;
			var XMLGLCode			= xmlHttp3.responseXML.getElementsByTagName("glCode")[loop].childNodes[0].nodeValue;
			
				var lastRow 	= tbl.rows.length;	
				var row 		= tbl.insertRow(lastRow);
				row.className 	= "bcgcolor-tblrowWhite";
				
				var cell 		= row.insertCell(0);
				cell.className 	= "normalfnt";
				cell.innerHTML 	= "<div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" id=\"0\" height=\"15\"/></div>";
				
				/*var cell 		= row.insertCell(1);
				cell.className 	= "normalfntMid";
				cell.innerHTML 	= "<input type=\"checkbox\" name=\"checkbox2\" id=\"checkbox2\" disabled=\"disabled\"/>";*/
				
				var cell 		= row.insertCell(1);
				cell.className 	= "normalfnt";
				cell.id 		= XMLMatDetailID;
				cell.innerHTML	= XMLItemDesc;
				
				var cell 		= row.insertCell(2);
				cell.className 	= "normalfnt";
				cell.innerHTML	= XMLUnit;
				
				var cell 		= row.insertCell(3);
				cell.className 	= "normalfntRite";
				cell.innerHTML	= XMLBalQty;
				
				var cell 		= row.insertCell(4);
				cell.className 	= "normalfntRite";
				cell.innerHTML	= XMLQty;
				
				
				var cell 		= row.insertCell(5);
				cell.className 	= "normalfntRite";
				cell.innerHTML	= XMLGRNno;
				
				var cell 		= row.insertCell(6);
				cell.className 	= "normalfntRite";
				cell.innerHTML	= XMLGRNyear;
				
				var cell 		= row.insertCell(7);
				cell.className 	= "normalfnt";
				cell.id			= XMLCostCenterId;
				cell.innerHTML	= XMLCostCenterDes;
				
				var cell 		= row.insertCell(8);
				cell.className 	= "normalfnt";
				cell.id			= XMLglAlloId;
				cell.innerHTML	= XMLGLCode;

	}
}


function LoadGatePassDetails()
{	
	ClearTable('tblTransInMain');
	Materials = [];
	mainArrayIndex = 0
	var gatePassNo = document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text;
	var url = 'gentranferinXml.php?RequestType=LoadGatePassDetails&gatePassNo=' +gatePassNo;
	htmlobj=$.ajax({url:url,async:false});
	LoadGatePassDetailsRequest(htmlobj);
	document.getElementById('cmdSave').style.display='inline';
}

function LoadGatePassDetailsRequest(xmlHttp)
{
	var tbl						= document.getElementById('tblTransInMain');
	var MatDetailID				= xmlHttp.responseXML.getElementsByTagName("MatDetailID");

	for (var loop =0; loop < MatDetailID.length; loop ++)
	{
		
		var XMLMatDetailID		= MatDetailID[loop].childNodes[0].nodeValue;
		var XMLItemDesc			= xmlHttp.responseXML.getElementsByTagName("ItemDescription")[loop].childNodes[0].nodeValue;
		var XMLUnit				= xmlHttp.responseXML.getElementsByTagName("Unit")[loop].childNodes[0].nodeValue;
		var XMLQty				= xmlHttp.responseXML.getElementsByTagName("Qty")[loop].childNodes[0].nodeValue;
		var XMLGRNno 			= xmlHttp.responseXML.getElementsByTagName("GRNno")[loop].childNodes[0].nodeValue;
		var XMLGRNyear 			= xmlHttp.responseXML.getElementsByTagName("GRNYear")[loop].childNodes[0].nodeValue;
		var XMLCostCenterId 	= xmlHttp.responseXML.getElementsByTagName("CostCenterId")[loop].childNodes[0].nodeValue;
		var XMLcostCenterDes 	= xmlHttp.responseXML.getElementsByTagName("costCenterDes")[loop].childNodes[0].nodeValue;
		var XMLGLAlloId			=  xmlHttp.responseXML.getElementsByTagName("glAlloId")[loop].childNodes[0].nodeValue;
		var XMLglCode			=  xmlHttp.responseXML.getElementsByTagName("glCode")[loop].childNodes[0].nodeValue;
//BEGIN - Add data to the main grid
		CreateMainGrid(tbl,XMLMatDetailID,XMLItemDesc,XMLUnit,XMLQty,XMLGRNno,XMLGRNyear,XMLCostCenterId,XMLcostCenterDes,XMLGLAlloId,XMLglCode);
//END	- Add data to the main grid
	
//BEGIN -  Add details to the main array
		var details = [];
		details[0] 	= XMLMatDetailID; 	// Mat ID
		details[1] 	= XMLQty; 			// Default Qty
		details[2] 	= XMLUnit; 			// Units				
		details[3]	= 0; 				// Add click
		details[4] = XMLGRNno;
		details[5] = XMLGRNyear;
		details[6] = XMLCostCenterId;
		details[7] = XMLGLAlloId;
		Materials[mainArrayIndex] = details;
		mainArrayIndex++;
//END -  Add details to the main array
	}
}

function CreateMainGrid(tbl,XMLMatDetailID,XMLItemDesc,XMLUnit,XMLQty,XMLGRNno,XMLGRNyear,XMLCostCenterId,XMLcostCenterDes,XMLGLAlloId,XMLglCode)
{
	var lastRow 	= tbl.rows.length;	
	var row 		= tbl.insertRow(lastRow);
	row.className 	= "bcgcolor-tblrowWhite";
	
	var cell 		= row.insertCell(0);
	cell.className 	= "normalfnt";
	cell.innerHTML 	= "<div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" id=\"0\" height=\"15\" onclick=\"RemoveItem(this,"+mainArrayIndex+");\" /></div>";
	
	/*var cell 		= row.insertCell(1);
	cell.className 	= "normalfntMid";
	cell.innerHTML 	= "<input type=\"checkbox\" name=\"checkbox2\" id=\"checkbox2\" onclick=\"RemoveBinColor(this,"+mainArrayIndex+");setAdd(this,"+mainArrayIndex+");\" />";*/
	
	var cell 		= row.insertCell(1);
	cell.className 	= "normalfnt";
	cell.id 		= XMLMatDetailID;
	cell.innerHTML	= XMLItemDesc;
	
	var cell 		= row.insertCell(2);
	cell.className 	= "normalfnt";
	cell.innerHTML	= XMLUnit;
	
	var cell 		= row.insertCell(3);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= XMLQty;
	
	var cell 		= row.insertCell(4);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= "<input type=\"text\" id=\"txtTransInQty\" name=\"txtTransInQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+XMLQty+"\" onkeydown=\"RemoveBinColor(this);\" onkeyup=\"ValidateQty(this);SetQty(this," + mainArrayIndex  + ");\">";
	
	
	var cell 		= row.insertCell(5);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= XMLGRNno;
	
	var cell 		= row.insertCell(6);
	cell.className 	= "normalfntRite";
	cell.innerHTML	= XMLGRNyear;
	
	var cell 		= row.insertCell(7);
	cell.className 	= "normalfnt";
	cell.id			= XMLCostCenterId;
	cell.innerHTML	= XMLcostCenterDes;
	
	var cell 		= row.insertCell(8);
	cell.className 	= "normalfnt";
	cell.id			= XMLGLAlloId;
	cell.innerHTML	= XMLglCode;
}

 function ValidateQty(obj)
 {
	var rw 				= obj.parentNode.parentNode;
	var GatePass 		= parseFloat(rw.cells[3].childNodes[0].nodeValue);
	var TransInQty		= parseFloat(rw.cells[4].childNodes[0].value);
	
	if(GatePass<TransInQty)
	{		
		rw.cells[4].childNodes[0].value=GatePass;
	}
}

function SetQty(obj,index)
{
		var rw = obj.parentNode.parentNode;		
		Materials[index][1] = parseFloat(rw.cells[4].childNodes[0].value);	
}
function setAdd(obj,index)
{	
	var rw = obj.parentNode.parentNode;	
	Materials[index][3]=(rw.cells[1].childNodes[0].checked==true ? 1:0);
}
function setAdd1(obj,index)
{	
	var rw = obj.parentNode.parentNode;	
	Materials[index][9]=0;
}

function RemoveBinColor(obj,index)
{
	var tblMain =document.getElementById("tblTransInMain");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
	tblMain.rows[Rw].cells[0].id =0;
}

//Start-Save part
function SaveValidation()
{
	showPleaseWait();
	document.getElementById('cmdSave').style.display = 'none';
	var tblMain 			= document.getElementById("tblTransInMain")
	gatepassNo				= $("#cboGatePassNo option:selected").text();
	
	if(!SaveValidate(tblMain))
	{
		document.getElementById('cmdSave').style.display = 'inline';
		hidePleaseWait();
		return;
	}
	LoadGPTransferInNo();
	
}

function LoadGPTransferInNo()
{		
	var TansferIn = document.getElementById("cboGPTransInNo").value;
	if (TansferIn=="")
	{
		var url = 'gentranferinXml.php?RequestType=LoadGPTransferInNo';
		htmlobj=$.ajax({url:url,async:false});
		LoadGPTransferInNoRequest(htmlobj);
	}
	else
	{	
		transferIn		= TansferIn.split("/");		
		transferInNo 	= parseInt(transferIn[1]);
		transferInYear 	= parseInt(transferIn[0]);
		SaveHeader();
	}
}

function LoadGPTransferInNoRequest(xmlHttp)
{
	var XMLGatePassNo 	= xmlHttp.responseXML.getElementsByTagName("TransferInNo")[0].childNodes[0].nodeValue;
	var XMLGatePassYear = xmlHttp.responseXML.getElementsByTagName("TransferInYear")[0].childNodes[0].nodeValue;
	transferIn 			= parseInt(XMLGatePassNo);
	transferInYear 		= parseInt(XMLGatePassYear);
	document.getElementById("cboGPTransInNo").value=transferInYear + "/" + transferIn;			
	SaveHeader();
}
	
function SaveHeader()
{	
	var GatePassNo =document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text;
	var remarks =document.getElementById("txtRemarks").value;

	var url = 'gentranferinXml.php?RequestType=SaveHeaderDetails&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+  '&GatePassNo=' +GatePassNo+ '&remarks=' +URLEncode(remarks);
	htmlobj=$.ajax({url:url,async:false});
	SaveDetails();
}

function SaveDetails()
{	
validateCount 	 = 0;
validateBinCount = 0;
var GatePassNo 	 = document.getElementById("cboGatePassNo").options[document.getElementById("cboGatePassNo").selectedIndex].text;

	for (loop=0;loop<Materials.length;loop++)
	{
		var details = Materials[loop];
		//var Add     = details[3];
		if 	(details!=null)
		{
			var MatDetailID = details[0];  // Mat ID
			var Qty         = details[1];  // Default Qty
			var Unit        = details[2];  //units		
			//var Add         = details[3];  //Add click
			var grnNo       = details[4]; //GRN No    2010-11-08
			var grnYear 	= details[5]; //GRN year
			var costCenterId = details[6];
			var glAlloId = details[7];
			validateCount++;
				
			var url = 'gentranferinXml.php?RequestType=SaveDetails&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+'&MatDetailID=' +MatDetailID+ '&Qty=' +Qty+ '&Unit=' +Unit+ '&grnNo='+grnNo+'&grnYear='+grnYear+ '&GatePassNo='+GatePassNo+ '&costCenterId='+costCenterId+'&glAlloId='+glAlloId;
			var htmlobj=$.ajax({url:url,async:false});
			
		}
	}	
	ResponseValidate();
}

function ResponseValidate()
{
	var url = 'gentranferinXml.php?RequestType=ResponseValidate&transferIn=' +transferIn+ '&transferInYear=' +transferInYear+ '&validateCount=' +validateCount;
	var htmlobj=$.ajax({url:url,async:false});	
	var Header		= htmlobj.responseXML.getElementsByTagName("recCountHeader")[0].childNodes[0].nodeValue;
	var Details		= htmlobj.responseXML.getElementsByTagName("recCountDetails")[0].childNodes[0].nodeValue;
	var binDetails	= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;	
		
	if((Header=="TRUE") && (Details=="TRUE") && (binDetails=="TRUE"))
	{
		alert ("TransferIn No : " + document.getElementById("cboGPTransInNo").value +  " saved successfully.");
		document.getElementById('cmdSave').style.display = 'none';
		hidePleaseWait();
	}
	else
	{
		alert("Error in saving.Please save it again.");
		document.getElementById('cmdSave').style.display = 'inline';
		hidePleaseWait();
	}					
}	
//End-Save part

function reportPopup()
{
	if(document.getElementById('gotoReport').style.display=="none")
	{
		document.getElementById('gotoReport').style.display = "inlnie";
		LoadPopUpTransIn();
	}
	else
	{
		document.getElementById('gotoReport').style.display="none";
		return;
	}	
}

function ReportPopOut()
{
	if(document.getElementById('gotoReport').style.display=="inlnie")
	{
		document.getElementById('gotoReport').style.display="none";
		return;
	}
}

function LoadPopUpTransIn()
{
	RomoveData('cboRptTransIn');
	document.getElementById('gotoReport').style.display = "inlnie";	
	var state=document.getElementById('cboReportState').value;
	var year=document.getElementById('cboReportYear').value;
	
 	createXMLHttpRequest();
    xmlHttp.onreadystatechange = LoadPopUpTransInRequest;
    xmlHttp.open("GET", 'gentranferinXml.php?RequestType=LoadPopUpTransIn&state='+state+'&year='+year, true);
    xmlHttp.send(null);  
}

function LoadPopUpTransInRequest()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboRptTransIn").options.add(opt);
	
			 var XMLTransIn= xmlHttp.responseXML.getElementsByTagName("TransIn");
			 for ( var loop = 0; loop < XMLTransIn.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = XMLTransIn[loop].childNodes[0].nodeValue;
				opt.value = XMLTransIn[loop].childNodes[0].nodeValue;
				document.getElementById("cboRptTransIn").options.add(opt);
			 }
			 
		}
	}
}
function showReport()
{
	showPleaseWait();
	var No			= document.getElementById('cboGPTransInNo').value;
	if(No=="")
	{
		alert("No \"Transfer In No\" to generate report.");
		hidePleaseWait();
		return;
	}
	var NoArray		= No.split("/");
	var year		= NoArray[0];
	var TransInNo	= NoArray[1];
	if(TransInNo!="0")
	{		
		newwindow=window.open('gentranferinreport.php?TransferInNo='+TransInNo+'&TransferInYear='+year,'name');
			if (window.focus) {newwindow.focus()}	
			hidePleaseWait();
	}
}


function SaveValidate(tblMain)
{
	if(gatepassNo=="")
	{
		alert("Please select the 'Gatepass No'.");
		document.getElementById('cboGatePassNo').focus();
		return false;
	}
	
	else if(tblMain.rows.length<=1)
	{	alert ("No details appear to save.");
		return false;
	}
	
	var tblLen = tblMain.rows.length-1;
	for(loop=1;loop<tblMain.rows.length;loop++)
		{
			if(tblMain.rows[loop].cells[1].childNodes[0].checked == false)
				tblLen--;				
		}
		
	if(tblLen == 0)
	{
		alert('Please select at least one item(s).');
		return false;
	}
	
return true;
}

function checkAll(obj)
{
	var tbl = 	document.getElementById('tblTransInMain')
	for(var i=1;i<tbl.rows.length;i++)
	{
		if(obj.checked)
			tbl.rows[i].cells[1].childNodes[0].checked = true;
		else
			tbl.rows[i].cells[1].childNodes[0].checked = false;
	}
}