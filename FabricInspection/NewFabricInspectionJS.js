// JavaScript Document

//S.C.B.Herath
//2009-06-19


var xmlHttp;
var xmlHttp1;
var xmlHttpLot;
var xmlHttpInspection;
var xmlHttpLotSave;
var xmlHttpDeleteInspection;
var xmlHttpIC;
var xmlHttpItem;

var xmlHttpDeleteLot;

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

function createXMLHttpInspection()
{
    if (window.ActiveXObject) 
    {
        xmlHttpInspection = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpInspection = new XMLHttpRequest();
    }
}

function createXMLHttpLotSave() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpLotSave = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpLotSave = new XMLHttpRequest();
    }
}

function CreateXMLHttpForLoadLot() 
{
    if (window.ActiveXObject) 
    {
        xmlHttpLot = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpLot = new XMLHttpRequest();
    }
}

function createXMLHttpDeleteInspection()
{
    if (window.ActiveXObject) 
    {
        xmlHttpDeleteInspection = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpDeleteInspection = new XMLHttpRequest();
    }
}

function createXMLHttpIC()
{
    if (window.ActiveXObject) 
    {
        xmlHttpIC = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpIC = new XMLHttpRequest();
    }
}

function createXMLHttpItem()
{
    if (window.ActiveXObject) 
    {
        xmlHttpItem = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttpItem = new XMLHttpRequest();
    }
}


function createXMLHttpDeleteLot()
{	
	if (window.ActiveXObject)
	{
		xmlHttpDeleteLot = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest)  
	{
		xmlHttpDeleteLot = new XMLHttpRequest();
	}
}


function createXMLHttp1()
{
    if (window.ActiveXObject) 
    {
        xmlHttp1 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp1 = new XMLHttpRequest();
    }
}

function saveFabric()
{	

var strInvoice						= 	document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;
var SupplierID						= 	document.getElementById('cboInvoice').value;
var intItemSerial					= 	document.getElementById('cboDescription').value;
var strStyle						= 	document.getElementById('txtStyleID').value;
var strColor 						= 	document.getElementById('cboColor').options[document.getElementById('cboColor').selectedIndex].text;
var receivedDate					= 	document.getElementById('dtmRecievedDate').value;
var receivedQty 					= 	document.getElementById('txtReceivedQty').value;

var swatImformedDate				= 	document.getElementById('dtmAppSWATImformedDate').value;
var swatReceivedDate				= 	document.getElementById('dtmAppSWATReceivedDate').value;
var srinkageLength 					= 	toNum(document.getElementById('txtSinkAgeLegth').value);
var srinkageWidth					= 	toNum(document.getElementById('txtSinkAgeWidth').value);
var orderWidth						= 	toNum(document.getElementById('txtOrderWidth').value);
var cuttableWidth					= 	toNum(document.getElementById('txtCuttableWidth').value);
var lessWidthSampleSendDate			= 	document.getElementById('dtmLessWidthSampleSendDate').value;
var gatepassNo1						= 	toNum(document.getElementById('txtGatepassNo1').value);
var inspectedQty					= 	toNum(document.getElementById('txtInspectedQty').value);
var inspected						= 	document.getElementById('txtInspectedRate').value;
var defected						= 	document.getElementById('txtDefectiveRate').value;
var gatepassNo2						= 	document.getElementById('txtGatepassNo2').value;
var defectSentDate					= 	document.getElementById('dtmDefectSentDate').value;
var defectApproved					= 	document.getElementById('optDefectApprovaedYes').checked;
if(defectApproved)
	defectApproved=1;
else
	defectApproved=0;
	
var defectivePanelReplace			= 	document.getElementById('txtDefectivePannelRep').value;
var inrollShortage					= 	document.getElementById('txtInrollShortages').value;
var totalYardsWeNeeded				= 	document.getElementById('txtTotalQty').value;
var claimReportUpDate				= 	document.getElementById('optClaimReportUpDateYES').checked;
if(claimReportUpDate)
	claimReportUpDate=1;
else
	claimReportUpDate=0;
	
var mailedDate						= 	document.getElementById('dtmMailedDate').value;
var shadeBandSendDate				= 	document.getElementById('dtmShadeBandSendDate').value;
var gatepassNo3						= 	document.getElementById('txtGatepassNo3').value;
var shadeBandApproval				= 	document.getElementById('optShadeBandApprovaleYES').checked;
if(shadeBandApproval)
	shadeBandApproval=1;
else
	shadeBandApproval=0;

var matchingLabdip					= 	document.getElementById('txtCLRMatchingLabdip').value;
var sendDate1						= 	document.getElementById('dtmCLRMatchingLabdipSentDate').value;
var gatepassNo4						= 	document.getElementById('txtGatepassNo4').value;
var colorApproval					= 	document.getElementById('optColourApprovalYES').checked;
if(colorApproval)
	colorApproval=1;
else
	colorApproval=0;
	
var skewingBowing					= 	document.getElementById('txtSkewingBowingRate').value;
var sendDate2						= 	document.getElementById('dtmSkewingBowingDate').value;
var gatepassNo5						= 	document.getElementById('txtGatepassNo5').value;
var BowingskeyApproval				= 	document.getElementById('optBowingskeyApprovalYes').value;
if(BowingskeyApproval)
	BowingskeyApproval=1;
else
	BowingskeyApproval=0;
var ClrShading						= 	document.getElementById('txtClrShading').value;
var ClrShadingDate					= 	document.getElementById('dtmClrShadingDate').value;
var GatepassNo6						= 	document.getElementById('txtGatepassNo6').value;

var shadingApproval					= 	document.getElementById('optShadingApprovalYes').value;
if(shadingApproval)
	shadingApproval=1;
else
	shadingApproval=0;
	
	
var fabricWay						= 	document.getElementById('optFabricWayYes').value;//optFabricWay
if(fabricWay)
	fabricWay=1;
else
	fabricWay=0;
	
	
var grade							= 	document.getElementById('cboGrade').value;
var status							= 	document.getElementById('cboStatus').value;
var invoiceNo2						= 	document.getElementById('txtInvoiceNo2').value;
var supplierId2						= 	document.getElementById('txtSupplier2').value;
var styleNo2						= 	document.getElementById('txtStyleNo2').value;
var Po_Pi2							= 	document.getElementById('txtPOPI2').value;
var Buyer2							= 	document.getElementById('txtBuyer2').value;
var strColor2						= 	document.getElementById('txtColour2').value;
var receivedQty2					= 	toNum(document.getElementById('txtRecQty2').value);

		
	if (isValid ())
	{		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = HandleSaveFabric;		
		var url = 'NewFabricInspectionDB.php?RequestType=Save';

		url += '&strInvoice						= '+URLEncode(strInvoice);
		url += '&intSupplierId					= '+SupplierID;
		url += '&intItemSerial					= '+intItemSerial;
		url += '&strStyle						= '+URLEncode(strStyle);
		url += '&strColor						= '+URLEncode(strColor);
		url += '&receivedDate					= '+receivedDate;
		url += '&receivedQty					= '+receivedQty;
		url += '&swatImformedDate				= '+swatImformedDate;
		url += '&swatReceivedDate				= '+swatReceivedDate;
		//url += '&srinkageLength 				= '+srinkageLength;
		url += '&srinkageLength					= '+srinkageLength;
		url += '&srinkageWidth					= '+srinkageWidth;
		url += '&orderWidth						= '+orderWidth;
		url += '&cuttableWidth					= '+cuttableWidth;
		url += '&lessWidthSampleSendDate		= '+lessWidthSampleSendDate;
		url += '&gatepassNo1					= '+gatepassNo1;
		url += '&inspectedQty					= '+inspectedQty;
		url += '&inspected						= '+inspected;
		url += '&defected						= '+defected;
		url += '&gatepassNo2					= '+gatepassNo2;
		url += '&defectSentDate					= '+defectSentDate;
		//url += '&defectSentDate					= '+defectSentDate;
		url += '&defectApproved					= '+defectApproved;
		url += '&defectivePanelReplace			= '+defectivePanelReplace;
		url += '&inrollShortage					= '+inrollShortage;
		url += '&totalYardsWeNeeded				= '+totalYardsWeNeeded;
		url += '&claimReportUpDate				= '+claimReportUpDate;
		url += '&mailedDate						= '+mailedDate;
		url += '&shadeBandSendDate				= '+shadeBandSendDate;
		url += '&gatepassNo3					= '+gatepassNo3;
		url += '&shadeBandApproval				= '+shadeBandApproval;
		url += '&matchingLabdip					= '+matchingLabdip;
		url += '&sendDate1						= '+sendDate1;
		url += '&gatepassNo4					= '+gatepassNo4;
		url += '&colorApproval					= '+colorApproval;
		url += '&skewingBowing					= '+skewingBowing;
		url += '&sendDate2						= '+sendDate2;
		url += '&gatepassNo5					= '+gatepassNo5;

		url += '&BowingskeyApproval				= '+BowingskeyApproval;
		url += '&ClrShading						= '+ClrShading;
		url += '&ClrShadingDate					= '+ClrShadingDate;
		url += '&GatepassNo6					= '+GatepassNo6;

		url += '&shadingApproval				= '+shadingApproval;
		url += '&fabricWay						= '+fabricWay;
		url += '&grade							= '+grade;
		url += '&status							= '+status;
		url += '&invoiceNo2						= '+URLEncode(invoiceNo2);
		url += '&supplierId2					= '+supplierId2;
		url += '&styleNo2						= '+URLEncode(styleNo2);
		url += '&Po_Pi2							= '+Po_Pi2;
		url += '&Buyer2							= '+Buyer2;
		url += '&strColor2						= '+Buyer2;
		url += '&receivedQty2					= '+receivedQty2;

		
		xmlHttp.open("GET",url, true);	
		xmlHttp.send(null);

	}
}

function HandleSaveFabric()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
        {  
			var text = xmlHttp.responseText;
			if (text ==1)
			{
				alert("Details successfully saved.")
			}
			else
			{
				alert("Details successfully updated.")
			}
		}
	}
}

function LoadFabricDetails()
{
	
	var intSupplier		= document.getElementById('cboInvoice').value;
	var invoiceNo 		= document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;	
	var intItemSerial	= document.getElementById('cboDescription').value;
	var strColor 		= document.getElementById('cboColor').value;
	//alert(invoiceNo);
	createXMLHttpInspection();		
	xmlHttpInspection.onreadystatechange = HandleFabricInspection;		
	xmlHttpInspection.open("GET",'NewFabricInspectionDB.php?RequestType=getInvoiceDetails&invoiceNo='+invoiceNo+'&intSupplier='+intSupplier+'&intItemSerial='+intItemSerial+'&strColor='+strColor, true);	
	xmlHttpInspection.send(null);		
}

function  HandleFabricInspection()
{
	
	if(xmlHttpInspection.readyState == 4) 
    {
        if(xmlHttpInspection.status == 200)
        {  		
		
			/*var XMLSuppliersName=xmlHttpInspection.responseXML.getElementsByTagName("suppliersName");
			var suppliersName=XMLSuppliersName[0].childNodes[0].nodeValue;
			document.getElementById('txtSupplier').value = suppliersName;*/
			
			var XMLQty=xmlHttpInspection.responseXML.getElementsByTagName("dblQty");
			var dblQty=XMLQty[0].childNodes[0].nodeValue;

			if (dblQty=='') dblQty=0;			
			document.getElementById('txtReceivedQty').value	= dblQty;
			//alert(dblQty);
		document.getElementById('dtmRecievedDate').value =  xmlHttpInspection.responseXML.getElementsByTagName("date")[0].childNodes[0].nodeValue;
			var XMLUnit=xmlHttpInspection.responseXML.getElementsByTagName("strUnit");
			var strUnit=XMLUnit[0].childNodes[0].nodeValue;

			if (strUnit=='') strUnit=0;
			document.getElementById('cmbUnits').value			= strUnit;

			/*var XMLStyleID=xmlHttpInspection.responseXML.getElementsByTagName("intStyleId");
			var StyleID=XMLStyleID[0].childNodes[0].nodeValue;
			document.getElementById('txtStyleID').value			= StyleID;

			var XMLUnitPrice=xmlHttpInspection.responseXML.getElementsByTagName("dblUnitPrice");
			var UnitPrice=XMLUnitPrice[0].childNodes[0].nodeValue;*/
			//if (UnitPrice=='') UnitPrice=0;
			//document.getElementById('txtPrice').value	= UnitPrice;
			
			
		//NewFabricInspection();
			var XMLDetails = xmlHttpInspection.responseXML.getElementsByTagName("Item");
			var Details=XMLDetails[0].childNodes[0].nodeValue;
		
		//document.getElementById('dtmRecievedDate').value		= XMLDetails[5].childNodes[0].nodeValue;
		//document.getElementById('txtReceivedQty').value			= XMLDetails[6].childNodes[0].nodeValue;
		document.getElementById('dtmAppSWATImformedDate').value	= XMLDetails[7].childNodes[0].nodeValue;
		document.getElementById('dtmAppSWATReceivedDate').value	= XMLDetails[8].childNodes[0].nodeValue;
		document.getElementById('txtSinkAgeLegth').value		= XMLDetails[9].childNodes[0].nodeValue;
		document.getElementById('txtSinkAgeWidth').value		= XMLDetails[10].childNodes[0].nodeValue;
		document.getElementById('txtOrderWidth').value			= XMLDetails[11].childNodes[0].nodeValue;
		document.getElementById('txtCuttableWidth').value		= XMLDetails[12].childNodes[0].nodeValue;
		document.getElementById('dtmLessWidthSampleSendDate').value = XMLDetails[13].childNodes[0].nodeValue;
		document.getElementById('txtGatepassNo1').value	 		= XMLDetails[14].childNodes[0].nodeValue;
		document.getElementById('txtInspectedQty').value		= XMLDetails[15].childNodes[0].nodeValue;
		document.getElementById('txtInspectedRate').value		= XMLDetails[16].childNodes[0].nodeValue;
		document.getElementById('txtDefectiveRate').value		= XMLDetails[17].childNodes[0].nodeValue;
		document.getElementById('txtGatepassNo2').value			= XMLDetails[18].childNodes[0].nodeValue;
		document.getElementById('dtmDefectSentDate').value		= XMLDetails[19].childNodes[0].nodeValue;
		document.getElementById('optDefectApprovaedYes').checked= bool(XMLDetails[20].childNodes[0].nodeValue);
		document.getElementById('txtDefectivePannelRep').value	= XMLDetails[21].childNodes[0].nodeValue;
		document.getElementById('txtInrollShortages').value		= XMLDetails[22].childNodes[0].nodeValue;
		document.getElementById('txtTotalQty').value			= XMLDetails[23].childNodes[0].nodeValue;
		document.getElementById('optClaimReportUpDateYES').checked= bool(XMLDetails[24].childNodes[0].nodeValue);
		document.getElementById('dtmMailedDate').value			= XMLDetails[25].childNodes[0].nodeValue;
		document.getElementById('dtmShadeBandSendDate').value	= XMLDetails[26].childNodes[0].nodeValue;
		document.getElementById('txtGatepassNo3').value			= XMLDetails[27].childNodes[0].nodeValue;
		document.getElementById('optShadeBandApprovaleYES').checked= bool(XMLDetails[28].childNodes[0].nodeValue);
		document.getElementById('txtCLRMatchingLabdip').value	= XMLDetails[29].childNodes[0].nodeValue;
		document.getElementById('dtmCLRMatchingLabdipSentDate').value= XMLDetails[30].childNodes[0].nodeValue;
		document.getElementById('txtGatepassNo4').value			= XMLDetails[31].childNodes[0].nodeValue;
		document.getElementById('optColourApprovalYES').checked	= bool(XMLDetails[32].childNodes[0].nodeValue);
		document.getElementById('txtSkewingBowingRate').value	= XMLDetails[33].childNodes[0].nodeValue;
		document.getElementById('dtmSkewingBowingDate').value	= XMLDetails[34].childNodes[0].nodeValue;
		document.getElementById('txtGatepassNo5').value			= XMLDetails[35].childNodes[0].nodeValue;

		document.getElementById('optBowingskeyApprovalYes').checked= bool(XMLDetails[36].childNodes[0].nodeValue);
		document.getElementById('txtClrShading').value			= XMLDetails[37].childNodes[0].nodeValue;
		document.getElementById('dtmClrShadingDate').value		= XMLDetails[38].childNodes[0].nodeValue;
		document.getElementById('txtGatepassNo6').value			= XMLDetails[39].childNodes[0].nodeValue;
		
		document.getElementById('optShadingApprovalYes').checked= bool(XMLDetails[40].childNodes[0].nodeValue);
		document.getElementById('txtFabricWayYes').checked		= bool(XMLDetails[41].childNodes[0].nodeValue);
		document.getElementById('cboGrade').value				= XMLDetails[42].childNodes[0].nodeValue;
		document.getElementById('cboStatus').value				= XMLDetails[43].childNodes[0].nodeValue;
		document.getElementById('txtInvoiceNo2').value			= XMLDetails[44].childNodes[0].nodeValue;
		document.getElementById('txtSupplier2').value			= XMLDetails[45].childNodes[0].nodeValue;
		document.getElementById('txtStyleNo2').value			= XMLDetails[46].childNodes[0].nodeValue;
		document.getElementById('txtPOPI2').value				= XMLDetails[47].childNodes[0].nodeValue;
		document.getElementById('txtBuyer2').value				= XMLDetails[48].childNodes[0].nodeValue;
		document.getElementById('txtColour2').value				= XMLDetails[49].childNodes[0].nodeValue;
		document.getElementById('txtRecQty2').value				= XMLDetails[50].childNodes[0].nodeValue;
		
					
				}
			}
		}
		
		function NewFabricInspection ()
		{
			//var now = new date();
			
		document.getElementById('dtmRecievedDate').value		='';
		document.getElementById('txtReceivedQty').value			= 0;
		document.getElementById('dtmAppSWATImformedDate').value	= '';
		document.getElementById('dtmAppSWATReceivedDate').value	= '';
		document.getElementById('txtSinkAgeLegth').value		= '';
		document.getElementById('txtSinkAgeWidth').value		= '';
		document.getElementById('txtOrderWidth').value			= '';
		document.getElementById('txtCuttableWidth').value		= '';
		document.getElementById('dtmLessWidthSampleSendDate').value = '';
		document.getElementById('txtGatepassNo1').value	 		= '';
		document.getElementById('txtInspectedQty').value		= '';
		document.getElementById('txtInspectedRate').value		= '';
		document.getElementById('txtDefectiveRate').value		='';
		document.getElementById('txtGatepassNo2').value			= '';
		document.getElementById('dtmDefectSentDate').value		= '';
		document.getElementById('optDefectApprovaedYes').checked= false;
		document.getElementById('txtDefectivePannelRep').value	= '';
		document.getElementById('txtInrollShortages').value		= '';
		document.getElementById('txtTotalQty').value			= '';
		document.getElementById('optClaimReportUpDateYES').checked= false;
		document.getElementById('dtmMailedDate').value			= '';
		document.getElementById('dtmShadeBandSendDate').value	='';
		document.getElementById('txtGatepassNo3').value			= '';
		document.getElementById('optShadeBandApprovaleYES').checked= false;
		document.getElementById('txtCLRMatchingLabdip').value	= '';
		document.getElementById('dtmCLRMatchingLabdipSentDate').value= '';
		document.getElementById('txtGatepassNo4').value			= '';
		document.getElementById('optColourApprovalYES').checked	= '';
		document.getElementById('txtSkewingBowingRate').value	= '';
		document.getElementById('dtmSkewingBowingDate').value	= '';
		document.getElementById('txtGatepassNo5').value			= '';
		document.getElementById('txtBowingSkewApproval').value	= '' ;
		document.getElementById('txtFabricWay').value			= '';
		document.getElementById('cboGrade').value				= '' ;
		document.getElementById('cboStatus').value				= '';
		document.getElementById('txtInvoiceNo2').value			= '';
		document.getElementById('txtSupplier2').value			= '';
		document.getElementById('txtStyleNo2').value			= '' ;
		document.getElementById('txtPOPI2').value				= '' ;
		document.getElementById('txtBuyer2').value				= '';
		document.getElementById('txtColour2').value				= '';
		document.getElementById('txtRecQty2').value				= '' ;
}

function isValid()
{
	if (document.getElementById('cboInvoice').value == 0 || document.getElementById('cboInvoice').value == null)
	{
		alert("Please select the Invoice.");
		document.getElementById('cboInvoice').focus();
		return false;
	}
	else if (document.getElementById('cboDescription').value == 0 || document.getElementById('cboDescription').value == null)
	{
		alert("Please select the Item.");
		document.getElementById('cboDescription').focus();
		return false;
	}
	else if (document.getElementById('cboColor').value == 0 || document.getElementById('cboColor').value == null)
	{
		alert("Please select the Color.");
		document.getElementById('cboColor').focus();
		return false;
	}
	return true;
}

//Lot section
function LotInterface ()
{
				var interface="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tblLot\">"+
				"<tr>"+
				"<td width=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">DEL</td>"+
				"<td width=\"15\" height=\"30\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Lot Number </td>"+
				"<td width=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Roll Number </td>"+
				"<td width=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Quantity</td>"+
				"<td width=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pass Rate</td>"+
				"<td width=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pass Status</td>"+
				"<td width=\"35\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
				"<td width=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+				
				"</tr>";
					interface+="<tr>"+
				"<td width=\"15\"<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\"  height=\"15\" class=\"mouseover\" onclick=\"delRow(this)\"/></div> </td>"+
				"<td class=\"normalfnt\" "+                 
				"<input type=\"text\" name=\"textfield\" class=\"txtbox\" id=\"textfield\" size=\"30\" maxlength=\"20\" /></td>"+
				"<td class=\"normalfnt\" <input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"25\" maxlength=\"20\" /> </td>"+
				"<td class=\"normalfnt\" <input type=\"text\"  class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"15\" maxlength=\"15\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\" /></td>"+
				"<td class=\"normalfnt\"<input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"15\" maxlength=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\"  /></td>"+
				"<td align=\"center\"<input type=\"checkbox\" name=\"\" id=\"textfield\" value=\"checkbox\" /></td>"+
				"<td class=\"normalfnt\" <input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"47\" maxlength=\"20\" /> </td>"+
				"<td><div align=\"center\"><img src=\"../images/add.png\" alt=\"del\" class=\"mouseover\" size=\"20\" onclick=\"addRow()\"/></div></td>"+								
				"</tr> </table>";				
			document.getElementById("divLotInterface").innerHTML=interface
}

function delRow (obj)
{	
	var tbl   = document.getElementById('tblLot');
	var nRows = document.getElementById('tblLot').rows.length-1;
	var tr = obj.parentNode.parentNode.parentNode	
	if (nRows>1)
	{
		tr.parentNode.removeChild(tr);	 
	}
	else 
	{
		LotInterface();
		//alert("Can't remove this row.");	
	}
}
	
function addRow (obj)
{	
	var tbl = document.getElementById('tblLot');			
    var lastRow = tbl.rows.length;
	var row = tbl.insertRow(lastRow);

	var cellDelete = row.insertCell(0);
	cellDelete.height = 10;
	cellDelete.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"10\" height=\"15\" class=\"mouseover\" onclick=\"delRow(this)\"/></div>" ;
	
	var cellLotNumber  = row.insertCell(1);	
	cellLotNumber.height = 10;
	cellLotNumber.innerHTML ="<input type=\"text\" name=\"textfield\" class=\"txtbox\" id=\"textfield\" size=\"20\"  maxlength=\"20\" />";
		
	var cellRollNumber = row.insertCell(2);
	cellRollNumber.height = 10;
	cellRollNumber.innerHTML = "<input type=\"text\"  class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"17\" maxlength=\"20\" /> ";
	
	var cellQuantity   = row.insertCell(3);
	cellQuantity.height = 10;
	cellQuantity.innerHTML = "<input type=\"text\"  class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"10\" maxlength=\"15\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\" />";
	
	var cellPassRate   = row.insertCell(4);
	cellPassRate.height = 10;
	cellPassRate.innerHTML = "<input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"10\" maxlength=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\" />";
	
	var cellPassStatus   = row.insertCell(5);
	cellPassStatus.height = 10;
	cellPassStatus.align="center";
	cellPassStatus.innerHTML="<input type=\"checkbox\" name=\"\" id=\"textfield\" value=\"checkbox\" />";
	
	var cellRemarks    = row.insertCell(6);
	cellRemarks.height = 10;
	cellRemarks.innerHTML = "<input type=\"text\"  class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"32\" maxlength=\"150\" />";
	
	var cellAdd  	   = row.insertCell(7);
	cellAdd.height = 10;
	cellAdd.innerHTML  = "<div align=\"center\"><img src=\"../images/add.png\" alt=\"del\" class=\"mouseover\" size=\"10\" onclick=\"addRow(this)\"/></div>";	
	
}

function saveLot ()
{	
	var cell;
	var strLotNumber;
	var strRollNumber;
	var dblQty;
	var strRemarks;
	var dblPassRate;
	var intStatus;
	
	if (isValidLot ())
	{	
		var intSupplier	  = document.getElementById('cboInvoice').value;
		var strInvoice 	  = document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;
		var intItemSerial = document.getElementById('cboDescription').value;
		var strColor 	  = document.getElementById('cboColor').value;
		var rows=document.getElementById('tblLot').getElementsByTagName("TR");
		var obj;
		
		DeleteLot(intSupplier,strInvoice,intItemSerial,strColor);
		
		for ( var loop = 1 ;loop < rows.length ; loop ++ )
		{
			cell 			= rows[loop].getElementsByTagName("TD")		
			strLotNumber	= cell[1].firstChild.value;
			strRollNumber	= cell[2].firstChild.value;
			dblQty			= cell[3].firstChild.value;
			dblPassRate		= cell[4].firstChild.value;
			obj				= cell[5].childNodes[0];	
			intStatus		= obj.checked;
			strRemarks		= cell[6].firstChild.value;	

			if (intStatus==true) 
			{ 
				intStatus=1;
			}
			else 
			{ 
				intStatus=0;
			}
			if (dblQty>0) 
			{
				createXMLHttpLotSave();
				xmlHttpLotSave.onreadystatechange = HandleSaveLot;
				xmlHttpLotSave.open("GET",'NewFabricInspectionDB.php?RequestType=SaveLot&strInvoice='+strInvoice+'&intSupplier='+intSupplier+'&dblQty='+dblQty+'&strLotNumber='+strLotNumber +'&strRollNumber='+strRollNumber+'&strRemarks='+strRemarks+'&intItemSerial='+intItemSerial+'&strColor='+strColor+'&dblPassRate='+dblPassRate+'&intStatus='+intStatus, true);	
				xmlHttpLotSave.send(null);
			}
		}
	}
}


function HandleSaveLot()
{
	if(xmlHttpLotSave.readyState == 4) 
    {
        if(xmlHttpLotSave.status == 200)
        {  
			var XMLResult = xmlHttpLotSave.responseXML.getElementsByTagName("Result");
			/*if (XMLResult[0].childNodes[0].nodeValue != "-2")
			{
				//alert("Lot Successfully Saved.")
			}
			else
			{
				//alert("Lot Successfully Updated.")
			}*/
		}
	}
}

function isValidLot()
{	
	var rows=document.getElementById('tblLot').getElementsByTagName("TR");	
	//alert('lot saved');
	if (rows.length>2)
	{	
		for ( var loop = 1 ;loop < rows.length ; loop ++ )
		{
			cell 			= rows[loop].getElementsByTagName("TD");		
			strLotNumber	= cell[1].firstChild.value;
			strRollNumber	= cell[2].firstChild.value;	
			if ((strLotNumber.length==0) || (strRollNumber.length==0))
			{
				if (strLotNumber.length==0)	
				{
					alert("Lot Number Can't be blank.");	
				}
				else if (strRollNumber.length==0)
				{
					alert("Roll Number Can't be blank.");
				}
				return false;
			}
		}
	}	
	return true;	
}

function DeleteLot(intSupplier,strInvoice,intItemSerial,strColor)
{
	createXMLHttpDeleteLot();
	//xmlHttpLotSave.onreadystatechange = HandleSaveLot;
	xmlHttpDeleteLot.open("GET",'NewFabricInspectionDB.php?RequestType=DeleteLot&strInvoice='+strInvoice+'&intSupplier='+intSupplier+'&intItemSerial='+intItemSerial+'&strColor='+strColor, true);	
	xmlHttpDeleteLot.send(null);	
}


function LoadLotDetails()
{
	var intSupplier	  = document.getElementById('cboInvoice').value;
	var strInvoice 	  = document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;
	var intItemSerial = document.getElementById('cboDescription').value;
	var strColor 	  = document.getElementById('cboColor').value;
		
	CreateXMLHttpForLoadLot();
	xmlHttpLot.onreadystatechange = HandleLotLoad;
    xmlHttpLot.open("GET",'NewFabricInspectionDB.php?RequestType=LoadLotDetails&strInvoice='+strInvoice+'&intSupplier='+intSupplier+'&intItemSerial='+intItemSerial+'&strColor='+strColor, true);
	xmlHttpLot.send(null); 	
}

function HandleLotLoad()
{	
	if(xmlHttpLot.readyState == 4) 
    {
		if(xmlHttpLot.status == 200) 
       	{
			getStyles();
				var XMLLotNo	= xmlHttpLot.responseXML.getElementsByTagName("strLotNo");
				var XMLRollNo	= xmlHttpLot.responseXML.getElementsByTagName("strRollNo");
				var XMLQty		= xmlHttpLot.responseXML.getElementsByTagName("dblQty");
				var XMLRemarks	= xmlHttpLot.responseXML.getElementsByTagName("strRemarks");
				var XMLPassRate	= xmlHttpLot.responseXML.getElementsByTagName("dblPassRate");
				var XMLStatus	= xmlHttpLot.responseXML.getElementsByTagName("intStatus");

var interface="<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" id=\"tblLot\">"+
				"<tr>"+
				"<td width=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">DEL</td>"+
				"<td width=\"15\" height=\"30\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Lot Number </td>"+
				"<td width=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Roll Number </td>"+
				"<td width=\"25\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Quantity</td>"+
				"<td width=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pass Rate</td>"+
				"<td width=\"20\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Pass Status</td>"+
				"<td width=\"35\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Remarks</td>"+
				"<td width=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Add</td>"+				
				"</tr>";

				if (XMLLotNo.length==0) 
				{
					interface+="<tr>"+
				"<td width=\"15\"<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\"  height=\"15\" class=\"mouseover\" onclick=\"delRow(this)\"/></div> </td>"+
				"<td class=\"normalfnt\" "+                 
				"<input type=\"text\" name=\"textfield\" class=\"txtbox\" id=\"textfield\" size=\"30\" maxlength=\"20\" /></td>"+
				"<td class=\"normalfnt\" <input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"25\" maxlength=\"20\" /> </td>"+
				"<td class=\"normalfnt\" <input type=\"text\"  class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"15\" maxlength=\"15\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\" /></td>"+
				"<td class=\"normalfnt\"<input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"15\" maxlength=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\"  /></td>"+
				"<td align=\"center\"<input type=\"checkbox\" name=\"\" id=\"textfield\" value=\"checkbox\" /></td>"+
				"<td class=\"normalfnt\" <input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"47\" maxlength=\"20\" /> </td>"+
				"<td><div align=\"center\"><img src=\"../images/add.png\" alt=\"del\" class=\"mouseover\" size=\"20\" onclick=\"addRow()\"/></div></td>"+								
				"</tr>";
				}
				else
				{					
					for (var loop=0; loop<XMLLotNo.length; loop++)
					{
						var strLotNo	= XMLLotNo[loop].childNodes[0].nodeValue;
						var strRollNo	= XMLRollNo[loop].childNodes[0].nodeValue;
						var dblQty		= XMLQty[loop].childNodes[0].nodeValue;
						var strRemarks	= XMLRemarks[loop].childNodes[0].nodeValue;
						var dblPassRate	= XMLPassRate[loop].childNodes[0].nodeValue;
						var intStatus	= XMLStatus[loop].childNodes[0].nodeValue;
						
					interface+="<tr>"+
				"<td width=\"15\"<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\"  height=\"15\" class=\"mouseover\" onclick=\"delRow(this)\"/></div> </td>"+
				"<td class=\"normalfnt\" "+                 
				"<input type=\"text\" name=\"textfield\" class=\"txtbox\" id=\"textfield\" size=\"30\" maxlength=\"20\" value=\""+strLotNo+"\" /></td>"+
				"<td class=\"normalfnt\" <input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"25\" maxlength=\"20\" value=\""+strRollNo+"\" /> </td>"+
				"<td class=\"normalfnt\" <input type=\"text\"  class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"15\"  maxlength=\"15\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\" value=\""+dblQty+"\" /></td>"+
				"<td class=\"normalfnt\"<input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"15\" maxlength=\"10\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event)\" value=\""+dblPassRate+"\"  /></td>";
				if (intStatus==1)
				{					
					interface+="<td align=\"center\"<input type=\"checkbox\" name=\"\" id=\"checkbox1\" checked=cheched\" /></td>";
				}
				else
				{
					interface+="<td align=\"center\"<input type=\"checkbox\" name=\"\" id=\"checkbox1\"  /></td>";
				}
				interface+="<td class=\"normalfnt\" <input type=\"text\" class=\"txtbox\" name=\"textfield\" id=\"textfield\" size=\"47\" maxlength=\"20\" value=\""+strRemarks+"\" /> </td>"+
				"<td><div align=\"center\"><img src=\"../images/add.png\" alt=\"del\" class=\"mouseover\" size=\"20\" onclick=\"addRow()\"/></div></td>"+								
				"</tr>";
					}
				}
				interface+="</table>";
				document.getElementById("divLotInterface").innerHTML=interface;		
		}
	}
}

function DeleteInspection()
{
	var intSupplier	= document.getElementById('cboInvoice').value;
	var strInvoice 	= document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;	
	var intItemSerial = document.getElementById('cboDescription').value;
	var strColor 	  = document.getElementById('cboColor').value;
	
	createXMLHttpDeleteInspection();
	xmlHttpDeleteInspection.onreadystatechange = HandleDeleteInspection;
	xmlHttpDeleteInspection.open("GET",'NewFabricInspectionDB.php?RequestType=DeleteInspectin&strInvoice='+strInvoice+'&intSupplier='+intSupplier+'&intItemSerial='+intItemSerial+'&strColor='+strColor, true);	
	xmlHttpDeleteInspection.send(null);		
}

function HandleDeleteInspection()
{	
	if(xmlHttpDeleteInspection.readyState == 4) 
    {        
		if(xmlHttpDeleteInspection.status == 200)
        {  		
			var XMLResult = xmlHttpDeleteInspection.responseXML.getElementsByTagName("Result");
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{				
				alert("Delete Inspection Successfully Completed.")
			}
		}
	}
}

function SaveFabricInspection()
{
	if (isValidLot())
	{
		saveFabric(); 
		saveLot();
	}
}

function FabricInspectionReport()
{
	var intSupplierId	= document.getElementById('cboInvoice').value;
	var strInvoiceNo 	= document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;	
	var intItemSerial = document.getElementById('cboDescription').value;
	var strColor 	  = document.getElementById('cboColor').value;
	
	//if (isValid())
	//{		//location='FabricInspectionReport.php?strInvoiceNo='+strInvoiceNo+'&intSupplierId='+intSupplierId+'&intItemSerial='+intItemSerial+'&strColor='+strColor;		
		window.open('FabricInspectionDetailReport.php?strInvoiceNo='+strInvoiceNo+'&intSupplierId='+intSupplierId+'&intItemSerial='+intItemSerial+'&strColor='+strColor);
		
	//}
}

function FabricInspectionList()
{	
	
	//window.open('FabricInspectionDetailReport.php?id=1&strInvoiceNo='+strInvoiceNo+'&intSupplierId='+intSupplierId+'&intItemSerial='+intItemSerial+'&strColor='+strColor);		
}
	
function SearchDetails()
{
	if (isValid())
	{
		LoadFabricDetails();
		LoadLotDetails();
	}
}

function LoadItem()
{
	var intSupplier		= document.getElementById('cboInvoice').value;
	var strInvoiceNo 	= document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;	
	createXMLHttpItem();
	xmlHttpItem.onreadystatechange = HandleItem;		
	xmlHttpItem.open("GET",'NewFabricInspectionDB.php?RequestType=getItem&strInvoiceNo='+strInvoiceNo+'&intSupplier='+intSupplier, true);	
	xmlHttpItem.send(null);

}

function HandleItem()
{
	if(xmlHttpItem.readyState == 4) 
    {
        if(xmlHttpItem.status == 200)
        {  		
			var itemString = xmlHttpItem.responseText;
			document.getElementById("cboDescription").innerHTML = itemString;
/*			var XMLItemSerial	= xmlHttpItem.responseXML.getElementsByTagName("intItemSerial");
			var XMLDescription	= xmlHttpItem.responseXML.getElementsByTagName("strDescription");
			//var XMLColor		= xmlHttpIC.responseXML.getElementsByTagName("strColor");
			
			var interfaceI ="<select name=\"cboDescription\" onchange=\"LoadItemAndColour();\" class=\"txtbox\" id=\"cboDescription\" style=\"width:220px\"><option value=\"0\" selected=\"selected\">Select One</option>";
			//var interfaceC ="<select name=\"cboColor\" class=\"txtbox\" id=\"cboColor\" style=\"width:133px\"><option value=\"0\" selected=\"selected\">Select One</option>";
			//alert('k');
			//alert(XMLItemSerial.length);
			for (var loop=0; loop<XMLItemSerial.length; loop++)
			{
				var intItemSerial	= XMLItemSerial[loop].childNodes[0].nodeValue;
				var strDescription	= XMLDescription[loop].childNodes[0].nodeValue;
				//var strColor		= XMLColor[loop].childNodes[0].nodeValue;	
				interfaceI+="<option value=\""+intItemSerial+"\">"+strDescription+"</option>";
				//interfaceC+="<option value=\""+strColor+"\">"+strColor+"</option>";
			}			
			interfaceI+="</select>";
			//interfaceC+="</select>";
			//alert(interfaceI);
			document.getElementById("divDescription").innerHTML=interfaceI;		*/
			//document.getElementById("divColor").innerHTML=interfaceC;					
		}
	}
}


function LoadItemAndColour()
{
	var intSupplier		= document.getElementById('cboInvoice').value;
	var strInvoiceNo 	= document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;
	var intItemNo 		= document.getElementById('cboDescription').value;
	//alert(intItemNo);	
	createXMLHttpIC();
	xmlHttpIC.onreadystatechange = HandleItemAndColour;		
	xmlHttpIC.open("GET",'NewFabricInspectionDB.php?RequestType=getColor&strInvoiceNo='+strInvoiceNo+'&intSupplier='+intSupplier+"&intItemNo="+intItemNo, true);	
	xmlHttpIC.send(null);
}

function HandleItemAndColour()
{
	if(xmlHttpIC.readyState == 4) 
    {
        if(xmlHttpIC.status == 200)
        {  			
			var colorString = xmlHttpIC.responseText;
			document.getElementById("cboColor").innerHTML = colorString;
			/*var XMLItemSerial	= xmlHttpIC.responseXML.getElementsByTagName("intItemSerial");
			//var XMLDescription	= xmlHttpIC.responseXML.getElementsByTagName("strDescription");
			var XMLColor		= xmlHttpIC.responseXML.getElementsByTagName("strColor");
			
			//var interfaceI ="<select name=\"cboDescription\" class=\"txtbox\" id=\"cboDescription\" style=\"width:220px\"><option value=\"0\" selected=\"selected\">Select One</option>";
			var interfaceC ="<select name=\"cboColor\" class=\"txtbox\" id=\"cboColor\" style=\"width:133px\"><option value=\"0\" selected=\"selected\">Select One</option>";
			for (var loop=0; loop<XMLItemSerial.length; loop++)
			{
				var intItemSerial	= XMLItemSerial[loop].childNodes[0].nodeValue;
				//var strDescription	= XMLDescription[loop].childNodes[0].nodeValue;
				var strColor		= XMLColor[loop].childNodes[0].nodeValue;	
				//interfaceI+="<option value=\""+intItemSerial+"\">"+strDescription+"</option>";
				interfaceC+="<option value=\""+strColor+"\">"+strColor+"</option>";
			}			
			//interfaceI+="</select>";
			interfaceC+="</select>";
			
			//document.getElementById("divDescription").innerHTML=interfaceI;		
			document.getElementById("divColor").innerHTML=interfaceC;		*/			
		}
	}
}

function setDefaultDate()
{
	var d=new Date();
	var day=d.getDate();
	day=day+''
	if(day.length==1)
	{
		day="0" + day
	}
	var month=d.getMonth() + 1;
	month=month+''
	if(month.length==1)
	{
		month="0" + month
	}
	var year=d.getFullYear();
	
	var ddate=(year + "-" + month + "-" + day);
	document.getElementById("dtmRecievedDate").value=ddate   
	document.getElementById("dtmAppSWATImformedDate").value=ddate
	document.getElementById("dtmAppSWATReceivedDate").value=ddate
	document.getElementById("dtmLessWidthSampleSendDate").value=ddate
	document.getElementById("dtmDefectSentDate").value=ddate
	document.getElementById("dtmClrShadingDate").value=ddate
	document.getElementById("dtmMailedDate").value=ddate
	document.getElementById("dtmShadeBandSendDate").value=ddate
	document.getElementById("dtmCLRMatchingLabdipSentDate").value=ddate
	document.getElementById("dtmSkewingBowingDate").value=ddate
	
}

function getStyles()
{
	var invNo		= document.getElementById('cboInvoice').options[document.getElementById('cboInvoice').selectedIndex].text;
	var itemNo		= document.getElementById('cboDescription').value;
	var strColor	= document.getElementById('cboColor').value;
	//alert(intItemNo);	
	createXMLHttp1();
	xmlHttp1.onreadystatechange = getStylesRequest;		
	var url = 'NewFabricInspectionDB.php?RequestType=getStyles&invNo='+invNo+'&itemNo='+itemNo+"&strColor="+strColor;
	xmlHttp1.open("GET",url, true);	
	xmlHttp1.send(null);
	//alert(url);
}

function getStylesRequest()
{
	if(xmlHttp1.readyState == 4 && xmlHttp1.status == 200) 
    {
		var text = xmlHttp1.responseText;
		 document.getElementById("txtStyleID").value = text.split('<A>')[0];
		 document.getElementById("txtSupplier").value = text.split('<A>')[1].split('<B>')[1];
	}
}

function bool(value)
{
	if(value == 1)
		return true;
	else
		return false;
}
function toNum(value)
{
	if(value=='' || isNaN(parseFloat(value)))
			return 0;
	else
		return value;
}