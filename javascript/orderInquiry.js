// JavaScript Document
var xmlHttpreq = [];
var pubPreOrderRptURL = 'gapro/';
var xmlHttp;
var altxmlHttp;
var thirdxmlHttp;
var fourthxmlHttp;
var fifthxmlHttp;
var loca = -1;
var arrayLocation = 0;
var Mainvariations = [];
var shippos = 0;
var mainDataSaving = false;
var variationsCount = 0;
var currentUnit = "";
var approvalStatus=0;
var mainpagerequest = false;
var deliveryIndex = 0;
var leadposition = 0 ;
var previousUnit = "";
var sentToapprovalComments = "";
var pub_mill	 = 0;
//---------------------------------------
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

//-------------------------------------------------------------------------------------------------------------
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

// -----------------------------------------------------------

function SaveNewOrderInquiry()
{
	if (ValidateOrderInquiryComponents())
	{
		approvalStatus = 0;
		mainpagerequest = true;
		var styleId	= document.getElementById('cboOrderNo').value;
		var styleNo = document.getElementById('txtStyleNo').value.trim();
		var orderNo = document.getElementById('txtPoNo').value.trim();
		var colorCode = $("#cboColor option:selected").text();
		if(colorCode != "Select One")
			orderNo = orderNo+'-'+colorCode;
		if (document.getElementById('txtRepeatNo').value.trim() != "" && document.getElementById('txtRepeatNo').value.trim() != null)
			styleNo = document.getElementById('txtStyleNo').value.trim() + '-' + document.getElementById('txtRepeatNo').value.trim();
		createNewXMLHttpRequest(0);
		xmlHttpreq[0].onreadystatechange = HandleNewOrderInquiryStyleNO;
		xmlHttpreq[0].open("GET", 'preordermiddletire.php?RequestType=IsExistingOrderNoInOrderQuiry&orderNo=' + URLEncode(orderNo) + '&styleId=' +styleId, true);
		xmlHttpreq[0].send(null); 
	}
	else
	{
		return false;	
	}
}
//------------------------------------
function HandleNewOrderInquiryStyleNO()
{	
    if(xmlHttpreq[0].readyState == 4) 
    {
        if(xmlHttpreq[0].status == 200) 
        {
			//alert(xmlHttpreq[0].responseText);
			var XMLStyle = xmlHttpreq[0].responseXML.getElementsByTagName("Style");
			var styleNo = document.getElementById('cboStyleNoFind').value.trim();
			var orderNo =  document.getElementById('cboOrderNo').value.trim(); 
		//if((XMLStyle[0].childNodes[0].nodeValue == "True") && (styleNo=="Select One") && (orderNo=="Select One"))
			if((XMLStyle[0].childNodes[0].nodeValue == "True"))
			{
				alert("Sorry! The Order No already exists. Please try again.");
				document.getElementById('txtPoNo').focus();
				document.getElementById('txtPoNo').select();
			}
			else
			{
				SaveNewOrderInquirySheet();
			}
		}		
	}
}

//-----------------------------------------------------
function SaveNewOrderInquirySheet()
{
	var orderId	= document.getElementById('cboOrderNo').value;
	var StyleNo = document.getElementById('txtStyleNo').value.trim();
	if (document.getElementById('txtRepeatNo').value.trim() != "" && document.getElementById('txtRepeatNo').value.trim() != null)
		StyleNo = document.getElementById('txtStyleNo').value.trim() + '-' + document.getElementById('txtRepeatNo').value.trim();
	var RepeatNo = document.getElementById('txtRepeatNo').value.trim();
	var StyleName = document.getElementById('txtStyleName').value.trim();
	var BuyerID = document.getElementById('cboCustomer').value;
	var BuyingOfficeID = document.getElementById('cboBuyingOffice').value;
	var RefNo = document.getElementById('txtRefNo').value.trim();
	var Qty = document.getElementById('txtQTY').value;
	var DivisionID = document.getElementById('dboDivision').value;
	var SeasonID = document.getElementById('dboSeason').value;
	var color = document.getElementById('txtColorCode').value.trim();
	var dimention = document.getElementById('txtDimention').value.trim();
	var poDate = document.getElementById('adviceDate').value;
	var poNo = document.getElementById('txtPoNo').value.trim();
	var buyerOrderNo = document.getElementById('txtPoNo').value.trim();
	var colorCode = $("#cboColor option:selected").text();
		if(colorCode != "Select One")
			poNo = poNo+'-'+colorCode;
	var UserID = document.getElementById('txtUser').value;
	var Mill = document.getElementById('cboMill').value;
	var FabricRefNo  = document.getElementById('txtFabRefNo').value.trim();
	var Fabrication  = document.getElementById('txtFabrication').value.trim();
	
	var FinanceP = 0;
	var FinanceA = 0;
	var MaterialCost = 0;
	var SMV = 0;
	var SMVRate =0;
	var CMValue = 0;
	var TargetFOB =0;
	var UpCharge = 0;
	var ESC = 0;
	var facProfit = 0;
	var factoryID = 0;
	var orderType =  document.getElementById('cboOrderType').value;
	var orderColorCode = $("#cboColor").val();
	if(Mill==""){
	Mill=0;	
	}
	
	createNewXMLHttpRequest(1);
    xmlHttpreq[1].onreadystatechange = HandleNewOrderInquirySheet;
    xmlHttpreq[1].open("GET", 'preordermiddletire.php?RequestType=SaveOrderInquiry&StyleNo=' + URLEncode(StyleNo) + '&RepeatNo=' + URLEncode(RepeatNo) + '&StyleName=' + URLEncode(StyleName) + '&BuyerID=' + BuyerID + '&BuyingOfficeID=' + BuyingOfficeID + '&RefNo=' + URLEncode(RefNo) + '&Qty=' + Qty + '&DivisionID=' + DivisionID + '&SeasonID=' + SeasonID + '&FinanceP=' + FinanceP + '&FinanceA=' + FinanceA + '&MaterialCost=' + MaterialCost +'&SMV=' + SMV +'&SMVRate=' + SMVRate + '&CMValue=' + CMValue + '&TargetFOB=' + TargetFOB + '&UpCharge=' + UpCharge + '&ESC=' + ESC + '&factoryID=' + factoryID + '&UserID=' +  UserID + '&ApprovalStatus=' + approvalStatus +'&facProfit='+facProfit +'&color='+URLEncode(color) +'&dimention='+URLEncode(dimention) +'&poDate='+poDate +'&poNo='+URLEncode(poNo) +'&Mill='+Mill +'&FabricRefNo='+URLEncode(FabricRefNo) +'&Fabrication='+URLEncode(Fabrication)+ '&orderId=' +orderId+'&orderColorCode='+URLEncode(orderColorCode)+'&orderType='+orderType+"&buyerOrderNo="+URLEncode(buyerOrderNo), true);    
    xmlHttpreq[1].send(null); 	
}
//----------------------------------------------
function HandleNewOrderInquirySheet()
{
	if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200)
        {  	
				//	alert(xmlHttpreq[1].responseText);

			var XMLResult = xmlHttpreq[1].responseXML.getElementsByTagName("SaveState");	
		/*	var StyleNo = document.getElementById('txtStyleNo').value;
			if (document.getElementById('txtRepeatNo').value != "" && document.getElementById('txtRepeatNo').value != null)
				StyleNo = document.getElementById('txtStyleNo').value + '-' + document.getElementById('txtRepeatNo').value;
			
			var XMLStyleId = xmlHttpreq[1].responseXML.getElementsByTagName("StyleId")[0].childNodes[0].nodeValue;*/
			
			
			if (XMLResult[0].childNodes[0].nodeValue == "True")
			{
			alert("Saved successfully.")
				location = "orderInquiry.php?";
			}
			else if (XMLResult[0].childNodes[0].nodeValue.trim() == "Updated")
			{
			alert("Updated successfully.");
				location = "orderInquiry.php?";
				//ClearInquiryForm();
			}
			else
			{
				alert("Save failed.")
			}
		}
	}
}
//-----------------------------------------------------------------------------------------------------------------------------
function ValidateOrderInquiryComponents()
{
	var orderNo = document.getElementById('txtPoNo').value.trim();
	var color = $("#cboColor option:selected").text();
	var orderLen=parseInt(orderNo.length)
	if(color != "Select One" )
		orderLen += parseInt(color.length)

	if (document.getElementById('txtStyleNo').value.trim() == null || document.getElementById('txtStyleNo').value.trim() == "")
	{
		alert("Please enter the \"Style No\".");
		document.getElementById('txtStyleNo').focus();
		document.getElementById('txtStyleNo').select();
		return false;
	}
	else if (document.getElementById('txtPoNo').value.trim() == null || document.getElementById('txtPoNo').value.trim() == "")
	{
		alert("Please enter the \"Order No.\"");
		document.getElementById('txtPoNo').focus();
		document.getElementById('txtPoNo').select();
		return false;
	}
	else if (document.getElementById('adviceDate').value <= 0)
	{
		alert("Please enter \"Order Date\".");
		document.getElementById('adviceDate').focus();
		return false;
	}
	else if (document.getElementById('txtStyleName').value.trim() == null || document.getElementById('txtStyleName').value.trim() == "")
	{
		alert("Please enter the \"Style Name\".");
		document.getElementById('txtStyleName').focus();
		document.getElementById('txtStyleName').select();
		return false;
	}
	else if (document.getElementById('txtQTY').value == null || document.getElementById('txtQTY').value == "")
	{
		alert("Please enter the \"Original PO Qty\".");
		document.getElementById('txtQTY').focus();
		return false;
	}
	else if (document.getElementById('txtQTY').value <= 0)
	{
		alert("Please enter correct \"Original PO Qty\".");
		document.getElementById('txtQTY').focus();
		return false;
	}
	else if (document.getElementById('cboCustomer').value == "")
	{
		alert("Please select the \"Buyer\".");
		document.getElementById('cboCustomer').focus();
		return false;
	}
	else if(document.getElementById('dboDivision').value == "Null")
	{
		alert("Please select the \"Buyer Division\".");
		document.getElementById('dboDivision').focus();
		return false;	
	}
	else if(orderLen>=35)
	{
		alert("Exceed the maximum length of \"Order No\" with Color");	
		document.getElementById('txtPoNo').focus();
		return false;
	}
	else
	{
		return true;	
	}
	return true;	
}
//--------------------------------------------------------------------
function showPopUpEditStyle()
{
if(document.getElementById('FindStyle').style.visibility == "visible")	
{
	document.getElementById('FindStyle').style.visibility = "hidden";
}
else
{
	document.getElementById('FindStyle').style.visibility = "visible";
	LoadStyleCustomer();
}
	
}
//------------------------------------------------------------------------
function LoadStyleCustomer()
{
	clearDropDown('cboStyleNoFind');
	
	var buyerID=document.getElementById('cboBuyerFind').value;
	
	var url="preordermiddletire.php";
					url=url+"?RequestType=getStyleCustomer";
					url += '&buyerID='+URLEncode(buyerID);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboStyleNoFind').innerHTML =  OrderNo;
 	/*createThirdXMLHttpRequest();
    thirdxmlHttp.onreadystatechange = HandlePOSupVice;
    thirdxmlHttp.open("GET", 'preordermiddletire.php?RequestType=getStyleCustomer&buyerID='+buyerID, true);
    thirdxmlHttp.send(null);  */
}

//start 2010-10-16 get buyer wise order details
function loadBuyerwiseOrderNo()
{
	clearDropDown('cboOrderNo');
	var buyerID=document.getElementById('cboBuyerFind').value;
	
	var url="preordermiddletire.php";
					url=url+"?RequestType=getBuyerOrderNo";
					url += '&buyerID='+URLEncode(buyerID);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
}
//------------------------------------
function clearDropDown(controName) {  
 
 var theDropDown = document.getElementById(controName)  
 var numberOfOptions = theDropDown.options.length  
 for (i=0; i<numberOfOptions; i++) {  
   theDropDown.remove(0)  
 }
 }
//----------------------------------------
function HandlePOSupVice()
{

    if(thirdxmlHttp.readyState == 4) 
    {
        if(thirdxmlHttp.status == 200) 
        {  
	     //	alert(thirdxmlHttp.responseText);
		/*var opt = document.createElement("option");
				opt.text = "Select One";
				opt.value = "";
				document.getElementById("cboStyleNoFind").options.add(opt);
	
			 var poNo= thirdxmlHttp.responseXML.getElementsByTagName("StyleNo");
			 for ( var loop = 0; loop < poNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = poNo[loop].childNodes[0].nodeValue;
				opt.value = poNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboStyleNoFind").options.add(opt);
			 }
			 */
			 document.getElementById("cboStyleNoFind").innerHTML = thirdxmlHttp.responseXML.getElementsByTagName("StyleNo")[0].childNodes[0].nodeValue;
		}
	}
}
//----------------------------
function setValuetoStyleBox()
{
	//var StyleNo=document.getElementById("cboStyleNoFind").value;
	var StyleNo=document.getElementById("cboOrderNo").value;
	
	loadDetailsForStyle(StyleNo);
	//alert(StyleNo);
}
//------------------------------------------------------
function loadDetailsForStyle(StyleNo)
{
	//var StyleNo=StyleNo;
	
//	alert('preordermiddletire.php?RequestType=loadDetailsForStyle&StyleNo='+StyleNo);
	createNewXMLHttpRequest(2);
    xmlHttpreq[2].onreadystatechange = HandleloadDetailsForStyle;
    xmlHttpreq[2].open("GET", 'preordermiddletire.php?RequestType=loadDetailsForStyle&StyleNo='+StyleNo, true);
    xmlHttpreq[2].send(null); 	
}
//----------------------------------------------
function HandleloadDetailsForStyle()
{
	if(xmlHttpreq[2].readyState == 4) 
    {
        if(xmlHttpreq[2].status == 200)
        {  	
		//	alert(xmlHttpreq[2].responseText);
			var XMLstrStyleNo = xmlHttpreq[2].responseXML.getElementsByTagName("strStyleNo");
			var XMLstrStyle = xmlHttpreq[2].responseXML.getElementsByTagName("strStyle");
			var XMLcustomer = xmlHttpreq[2].responseXML.getElementsByTagName("customer");
			var XMLbuyingOffice = xmlHttpreq[2].responseXML.getElementsByTagName("buyingOffice");
			var XMLDevision = xmlHttpreq[2].responseXML.getElementsByTagName("Devision");
			var XMLreffer = xmlHttpreq[2].responseXML.getElementsByTagName("reffer");
			var XMLfabReffer = xmlHttpreq[2].responseXML.getElementsByTagName("fabReffer");
			var XMLpoNo = xmlHttpreq[2].responseXML.getElementsByTagName("poNo");
			var XMLPoDate = xmlHttpreq[2].responseXML.getElementsByTagName("PoDate");
			var XMLorgPoQty = xmlHttpreq[2].responseXML.getElementsByTagName("orgPoQty");
			var XMLseason = xmlHttpreq[2].responseXML.getElementsByTagName("season");
			var XMLcolor = xmlHttpreq[2].responseXML.getElementsByTagName("color");
			var XMLdimension = xmlHttpreq[2].responseXML.getElementsByTagName("dimension");
			var XMLmill = xmlHttpreq[2].responseXML.getElementsByTagName("mill");
			var XMLfabrication = xmlHttpreq[2].responseXML.getElementsByTagName("fabrication");
			var XMLRepeatNo = xmlHttpreq[2].responseXML.getElementsByTagName("RepeatNo");
			var XMLOrderColorCode = xmlHttpreq[2].responseXML.getElementsByTagName("orderColorCode");
		}
			document.getElementById('txtStyleNo').value= XMLstrStyleNo[0].childNodes[0].nodeValue;  
			document.getElementById('txtStyleName').value= XMLstrStyle[0].childNodes[0].nodeValue;
			document.getElementById('txtRepeatNo').value= XMLRepeatNo[0].childNodes[0].nodeValue; 
			document.getElementById('cboCustomer').value= XMLcustomer[0].childNodes[0].nodeValue;  
			document.getElementById('txtRefNo').value= XMLreffer[0].childNodes[0].nodeValue;  
			document.getElementById('txtFabRefNo').value= XMLfabReffer[0].childNodes[0].nodeValue;  
			document.getElementById('txtPoNo').value= XMLpoNo[0].childNodes[0].nodeValue;  
			document.getElementById('adviceDate').value= XMLPoDate[0].childNodes[0].nodeValue;  
			document.getElementById('txtQTY').value= XMLorgPoQty[0].childNodes[0].nodeValue;  
			document.getElementById('dboSeason').value= XMLseason[0].childNodes[0].nodeValue;  
			document.getElementById('txtColorCode').value= XMLcolor[0].childNodes[0].nodeValue;  
			document.getElementById('txtDimention').value= XMLdimension[0].childNodes[0].nodeValue;  
			document.getElementById('cboMill').value= XMLmill[0].childNodes[0].nodeValue;  
			document.getElementById('txtFabrication').value= XMLfabrication[0].childNodes[0].nodeValue; 
			if(XMLOrderColorCode[0].childNodes[0].nodeValue != '')
				document.getElementById('cboColor').value= XMLOrderColorCode[0].childNodes[0].nodeValue;
			else
				document.getElementById('cboColor').value = '';
			var cusId	= document.getElementById('cboCustomer').value;
			GetOIDivisions(cusId);
			GetOIBuyingOffices(cusId);
			document.getElementById('cboBuyingOffice').value= XMLbuyingOffice[0].childNodes[0].nodeValue;  
			document.getElementById('dboDivision').value= XMLDevision[0].childNodes[0].nodeValue;
			document.getElementById('cboOrderType').value = xmlHttpreq[2].responseXML.getElementsByTagName("orderType")[0].childNodes[0].nodeValue; 

}
}

function ClearInquiryForm()
{
	document.frm_main.reset();
	document.getElementById('txtStyleNo').focus();
	document.getElementById('cboBuyingOffice').innerHTML="";
	document.getElementById('dboDivision').innerHTML="";
	LoadStyleCustomer();
	loadBuyerwiseOrderNo();
}

function changeOrderNo()
{
	var stytleName = document.getElementById('cboStyleNoFind').value.trim();
	var url="preordermiddletire.php";
					url=url+"?RequestType=getStyleWiseOrderNoOrderinquiry";
					url += '&stytleName='+URLEncode(stytleName);
					
		var htmlobj=$.ajax({url:url,async:false});
		var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
		document.getElementById('cboOrderNo').innerHTML =  OrderNo;
}

function GetOIDivisions(obj)
{
document.getElementById('dboDivision').innerHTML="";
var url = 'preordermiddletire.php?RequestType=GetDivision&CustID='+obj;
var htmlobj=$.ajax({url:url,async:false});
var XMLDivisionID = htmlobj.responseXML.getElementsByTagName("DivisionID");
var XMLDivisionName = htmlobj.responseXML.getElementsByTagName("Division");
	
	for ( var loop = 0; loop < XMLDivisionID.length; loop ++)
	{
		var opt = document.createElement("option");
		opt.text = XMLDivisionName[loop].childNodes[0].nodeValue;
		opt.value = XMLDivisionID[loop].childNodes[0].nodeValue;
		document.getElementById("dboDivision").options.add(opt);
	}
}

function GetOIBuyingOffices(obj)
{
document.getElementById('cboBuyingOffice').innerHTML="";
var url = 'preordermiddletire.php?RequestType=GetBuyingOffice&CustID='+obj;
var htmlobj=$.ajax({url:url,async:false});
var XMLID = htmlobj.responseXML.getElementsByTagName("BuyingOfficeID");
var XMLName = htmlobj.responseXML.getElementsByTagName("BOffice");
	for ( var loop = 0; loop < XMLID.length; loop ++)
	{
		var opt = document.createElement("option");
		opt.text = XMLName[loop].childNodes[0].nodeValue;
		opt.value = XMLID[loop].childNodes[0].nodeValue;
		document.getElementById("cboBuyingOffice").options.add(opt);
	}
}

function GetFabricRefNo(obj)
{
	if(obj==""){
		document.getElementById('txtFabRefNo').value = "";
		return;
	}
	
	var url = 'preordermiddletire.php?RequestType=GetFabricRefNo&MillId='+obj;
	var htmlobj=$.ajax({url:url,async:false});
	var XMLFabricRefNo = htmlobj.responseXML.getElementsByTagName("FabricRefNo");
	document.getElementById('txtFabRefNo').value = XMLFabricRefNo[0].childNodes[0].nodeValue;		
}