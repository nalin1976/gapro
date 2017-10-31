var xmlHttp;
var xmlHttp2 			= [];
var xmlHttp3 			= [];

var Materials 			= [];
var mainArrayIndex 		= 0;

var JobNo				= 0;
var JobYear				= 0;

var validateCount 		= 0;

var pub_TrasferInQty	= 0;
var pub_index			= 0;
var mainRw				= 0;
var pub_Status			= 0;

var pub_ActiveCommonBins=0;
var pub_AutomateBin =0;
var pub_strLocName = 0;
var pub_strBinName = 0;
var pub_strSubStoresName= 0;
var pub_strMainStoresName= 0;

function ClearForm()
{	
	setTimeout("location.reload(true);",0);
}

function createXMLHttpRequest(){
	if (window.ActiveXObject) 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp = new XMLHttpRequest();
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

function RemoveAllRows(tableName){
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}

var AllowableCharators=new Array("38","37","39","40","8");
 function isNumberKey(evt){
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 
	  for (x in AllowableCharators)
	  {
		  if (AllowableCharators[x] == charCode)
		  return true;		
	  }

	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }

function closeWindow2()
{
/*	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}*/
	
		try {
		var box = document.getElementById('popupLayer');
		box.parentNode.removeChild(box);
		loca = 0;		
	}catch(err){        
	}	
}

function RemoveItem(obj)
{
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;
		DeleteRow(obj);
	}
}

function DeleteRow(obj){
	var JobInNo =document.getElementById("txtJobNo").value;
	var rw=obj.parentNode.parentNode.parentNode;
	
	var matDetailId =rw.cells[1].id;	
	var buyerPoNo = rw.cells[2].childNodes[0].nodeValue;	
	var color = rw.cells[3].childNodes[0].nodeValue;
	var size = rw.cells[4].childNodes[0].nodeValue;
	
	var url = 'materialsTransferXml.php?RequestType=DeleteRow&JobInNo=' +JobInNo+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&matDetailId=' +matDetailId;
	var htmlobj=$.ajax({url:url,async:false});
}

function SeachFromStyle(obj)
{	
	document.getElementById("cboFrom").value =obj.value;
	LoadMerchandiser();
}

function SeachFromSC(obj)
{	
	document.getElementById('cboFromScno').value =obj.value;
	LoadMerchandiser();
}

function SeachToStyle(obj)
{
	document.getElementById("cboTo").value =obj.value;	
	GetToBuyerPoNo();
}

function SeachToSC(obj)
{
	document.getElementById('cboToScno').value =obj.value;
	GetToBuyerPoNo();
}

function GetToBuyerPoNo()
{
	var styleName	= document.getElementById("cboTo").options[document.getElementById("cboTo").selectedIndex].text;
	if(styleName=="Select One")return;
	RomoveData('cboToBuyerPoNo');
	var styleId = document.getElementById("cboTo").value;

	var url = 'materialsTransferXml.php?RequestType=GetToBuyerPoNo&styleId=' +URLEncode(styleId);
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboToBuyerPoNo').innerHTML = htmlobj.responseText;
}

function LoadMerchandiser()
{
	var styleName	= document.getElementById("cboFrom").options[document.getElementById("cboFrom").selectedIndex].text;
	if(styleName=="Select One")return;
	var styleId = document.getElementById("cboFrom").value;

	var url = 'materialsTransferXml.php?RequestType=LoadMerchandiser&styleId=' +URLEncode(styleId);
	var htmlobj=$.ajax({url:url,async:false});
	document.getElementById('txtMerchant').value=htmlobj.responseXML.getElementsByTagName("Name")[0].childNodes[0].nodeValue;
}

function LoadStockDetails()
{
	var fromStyleName		= document.getElementById('cboFrom').options[document.getElementById('cboFrom').selectedIndex].text;
	var toStyleName			= document.getElementById('cboTo').options[document.getElementById('cboTo').selectedIndex].text;
	var StoresId		= document.getElementById('cboMainStores').value;
	
	if(fromStyleName=="Select One")
	{
		alert("Please select the 'Transfer From Order No'");
		document.getElementById('cboFrom').focus();
		return;
	}
	if(toStyleName=="Select One")
	{
		alert("Please select the 'Transfer To Order No'");
		document.getElementById('cboTo').focus();
		return;
	}
	if(fromStyleName==toStyleName)
	{
		alert("Tranfering 'From Order No' and 'To Order No' should be different.");
		return;
	}
	if(StoresId=="")
	{
		alert("Please select the 'Main Stores'.");
		document.getElementById('cboMainStores').focus();
		return;
	}
	
	var fromStyleId		= document.getElementById('cboFrom').value;
	var toStyle			= document.getElementById('cboTo').value;
	var bpoNo 			= document.getElementById('cboToBuyerPoNo').value;

	var url = 'materialspopup.php?fromStyleId=' +URLEncode(fromStyleId)+ '&toStyle=' +URLEncode(toStyle)+ '&StoresId=' +StoresId+'&BuyerPONo='+URLEncode(bpoNo);
	var htmlobj=$.ajax({url:url,async:false});
	LoadStockDetailsRequest(htmlobj);
}

function LoadStockDetailsRequest(xmlHttp)
{
	//drawPopupArea(958,490,'frmMaterialTransfer');	
	drawPopupAreaLayer(958,490,'frmMaterialsPopUp',1);	
	var HTMLText=xmlHttp.responseText;
	document.getElementById('frmMaterialsPopUp').innerHTML=HTMLText;				
}
//End - open popup window
	
function LoadDetailsToMainPage()
{
	var tblPopUp = document.getElementById('tblMatPopUp');
	
	for(loop=1;loop<tblPopUp.rows.length;loop++)
	{
		var chkBx=tblPopUp.rows[loop].cells[0].childNodes[0].childNodes[1];
		if (chkBx.checked)
		{
			var itemDescription	=  tblPopUp.rows[loop].cells[2].childNodes[0].nodeValue;
			var itemDetailID 	=  tblPopUp.rows[loop].cells[2].id;
			var buyerPoNo 		=  tblPopUp.rows[loop].cells[3].id;
			var buyerPoName		=  tblPopUp.rows[loop].cells[3].childNodes[0].nodeValue;
			var color 			=  tblPopUp.rows[loop].cells[4].childNodes[0].nodeValue;
			var size 			=  tblPopUp.rows[loop].cells[5].childNodes[0].nodeValue;
			var units 			=  tblPopUp.rows[loop].cells[6].childNodes[0].nodeValue;
			var stockBal 		=  tblPopUp.rows[loop].cells[7].childNodes[0].nodeValue;
			var unitPrise 		=  tblPopUp.rows[loop].cells[4].id;
			var grnNo	 		=  tblPopUp.rows[loop].cells[8].childNodes[0].nodeValue;
			var grnTypeId 		=  tblPopUp.rows[loop].cells[9].id;
			var grnType	 		=  tblPopUp.rows[loop].cells[9].childNodes[0].nodeValue;
			
			var tblMain 		= document.getElementById('tblMain');			
			var booCheck =false;
				for (var mainLoop =0 ;mainLoop < tblMain.rows.length; mainLoop++ )
				{
					var mainMatDetaiId 	= tblMain.rows[mainLoop].cells[1].id;
					var mainBuyerPoNo 	= tblMain.rows[mainLoop].cells[2].id;
					var mainColor 		= tblMain.rows[mainLoop].cells[3].childNodes[0].nodeValue;
					var mainSize	 	= tblMain.rows[mainLoop].cells[4].childNodes[0].nodeValue;		
					var mainGrnNo 		= tblMain.rows[mainLoop].cells[9].childNodes[0].nodeValue;
					var mainGrnType		= tblMain.rows[mainLoop].cells[10].id;
				
					if ((mainMatDetaiId==itemDetailID) && (mainBuyerPoNo==buyerPoNo) && (mainColor==color) && (mainSize==size) && (mainGrnNo==grnNo) && (mainGrnType==grnTypeId))
					{
								booCheck =true;
					}	
				}
			if (booCheck == false)
			{
			var lastRow 		= tblMain.rows.length;	
			var row 			= tblMain.insertRow(lastRow);	
			row.className = "bcgcolor-tblrowWhite";
			
			var cellDelete = row.insertCell(0); 			
			cellDelete.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"" + mainArrayIndex + "\" height=\"15\" onclick=\"RemoveItem(this);\"/></div>";			
					
			var cellDescription = row.insertCell(1);
			cellDescription.className ="normalfnt";
			cellDescription.id =itemDetailID;
			cellDescription.innerHTML =itemDescription;
			
					
			var cellIBuyerPoNo = row.insertCell(2);
			cellIBuyerPoNo.className ="normalfntMid";
			cellIBuyerPoNo.id =buyerPoNo;
			cellIBuyerPoNo.innerHTML =buyerPoName;
			
					
			var cellColor = row.insertCell(3);
			cellColor.className ="normalfntMidSML";			
			cellColor.id =unitPrise;
			cellColor.innerHTML =color;
					
			var cellSize = row.insertCell(4);
			cellSize.className ="normalfntMidSML";			
			cellSize.innerHTML =size;
			
					
			var cellUnits = row.insertCell(5);
			cellUnits.className ="normalfntMidSML";			
			cellUnits.innerHTML =units;
			
					
			var cellQty = row.insertCell(6);
			cellQty.className ="normalfntRite";			
			cellQty.innerHTML =stockBal;
			
					
			var celltxt = row.insertCell(7);
			celltxt.className ="normalfntRite";	
			celltxt.innerHTML ="<input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+stockBal+"\" onkeyup=\"ValidateQty(this);SetItemQuantity(this," + mainArrayIndex  + ");\" />";		
			
			var cellLocation = row.insertCell(8);	
			cellLocation.id=0;
			cellLocation.innerHTML ="<div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\"  height=\"20\" onclick=\"ValidateBinBinDetails(this," + mainArrayIndex  + ");SetLocationItemQuantity(this," + mainArrayIndex  + ");\"/></div>";
			
			var cellQty = row.insertCell(9);
			cellQty.className ="normalfnt";			
			cellQty.innerHTML =grnNo;
			
			var cell = row.insertCell(10);
			cell.className = "normalfnt";			
			cell.id = grnTypeId;
			cell.innerHTML =grnType;
			
			//Start - array
			var details		= [];
				details[0]	= itemDetailID;
			    details[1]	= buyerPoNo;
			    details[2]	= color;
			    details[3]	= size;
				details[4]	= units;
				details[6]	= stockBal;
				details[7]	= unitPrise;
				details[8]	= grnNo;
				details[9]	= grnTypeId;
				
			Materials[mainArrayIndex]= details;
			mainArrayIndex++;
			//End - array		
			
			}
		}
	}
	closeWindow();
}
function SetItemQuantity(obj,index)
{		
		var rw=obj.parentNode.parentNode;
		Materials[index][6] = rw.cells[7].childNodes[0].value;		
}

function SetLocationItemQuantity(obj,index)
{		
		var rw=obj.parentNode.parentNode.parentNode;
		Materials[index][6] = rw.cells[7].childNodes[0].value;		
}

function ValidateQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var Qty = rw.cells[7].childNodes[0].value;
	var StockQty =rw.cells[6].childNodes[0].nodeValue;	
		
	if(parseInt(Qty)>parseInt(StockQty))
	{		
		rw.cells[7].childNodes[0].value=StockQty;
	}
}

function SelectAll(obj)
{
	var tbl 		= document.getElementById('tblMatPopUp');
	var booChecked = false;
	if(obj.checked)
		booChecked = true;
	for(loop=1;loop<tbl.rows.length;loop++)
	{
		tbl.rows[loop].cells[0].childNodes[0].childNodes[1].checked=booChecked;
	}
}

function RemoveData()
{
	RemoveAllRows('tblMain');
}

function SaveValidation()
{
	var tblMain =document.getElementById("tblMain");	
	if (tblMain.rows.length<1)
	{
		alert ("No details to save.");
		return false;
	}
	
		for (loop = 1 ;loop < tblMain.rows.length; loop++)
		{
			var issueQty = tblMain.rows[loop].cells[7].childNodes[0].value;
		
				if ((issueQty=="")  || (issueQty==0))
				{
					alert ("Issue Qty Can't Be '0' Or Empty.")
					return false;				
				}				
		}
	LoadJobNo();	
}
function LoadJobNo()
{
	var No = document.getElementById("txtJobNo").value
	if (No=="")
	{
		var url = 'materialsTransferXml.php?RequestType=LoadJobNo';
		var htmlobj=$.ajax({url:url,async:false});
		LoadJobNoRequest(htmlobj);
	}
	else
	{		
		No = No.split("/");
		
		JobNo 	= parseInt(No[1]);
		JobYear = parseInt(No[0]);
		Save();
	}
}

function LoadJobNoRequest(xmlHttp)
{
	var XMLAdmin	= xmlHttp.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;
	if(XMLAdmin=="TRUE")
	{
		var XMLJobNo 	= xmlHttp.responseXML.getElementsByTagName("JobNo")[0].childNodes[0].nodeValue;
		var XMLJobYear 	= xmlHttp.responseXML.getElementsByTagName("JobYear")[0].childNodes[0].nodeValue;
		JobNo 			= parseInt(XMLJobNo);
		JobYear 		= parseInt(XMLJobYear);
		document.getElementById("txtJobNo").value=JobYear + "/" + JobNo;			
		Save();
	}
	else
	{
		alert("Please contact system administrator to assign new Interjob No.");
	}	
}
	
function Save()
{
	validateCount =0;
	var fromStyleNo 	= document.getElementById("cboFrom").value;
	var toStyleNo 		= document.getElementById("cboTo").value;
	var remarks 		= document.getElementById('txtRemarks').value;
	var StoresId		= document.getElementById('cboMainStores').value;
	var toBuyerPoNo		= document.getElementById('cboToBuyerPoNo').value;

	var url = 'materialsTransferXml.php?RequestType=SaveHeader&JobNo=' +JobNo+ '&JobYear=' +JobYear+ '&fromStyleNo=' +URLEncode(fromStyleNo)+ '&toStyleNo=' +URLEncode(toStyleNo)+ '&remarks=' +URLEncode(remarks)+ '&StoresId=' +StoresId+ '&toBuyerPoNo=' +URLEncode(toBuyerPoNo);
	var htmlobj=$.ajax({url:url,async:false});
	
		for (loop = 0 ; loop < Materials.length ; loop ++)
		{	
			var details = Materials[loop] ;
			if 	(details!=null)
			{
					var itemDetailID 	= details[0]	// itemDetailID;
					var	BuyerPoNo 		= details[1]	// buyerPoNo;	
					var color			= details[2]	// color;
					var size			= details[3]	// size;
					var units			= details[4]	// units;
					var stockBal		= details[6]	// stockBal;
					var unitPrise		= details[7]	// unitPrise;
					var grnNo			= details[8]	// grnNo;
					var grnTypeId		= details[9]	// grnNo;
					
					validateCount++;
					
		var url = 'materialsTransferXml.php?RequestType=SaveDetails&JobNo=' +JobNo+ '&JobYear=' +JobYear+ '&BuyerPoNo=' +URLEncode(BuyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&Qty=' +stockBal+ '&unitPrise=' +unitPrise+ '&grnNo=' +grnNo+ '&grnTypeId='+grnTypeId;
		var htmlobj=$.ajax({url:url,async:false});
			}
		}
	ResponseValidate();
}

function ResponseValidate()
{
	var url = 'materialsTransferXml.php?RequestType=ResponseValidate&JobNo=' +JobNo+ '&JobYear=' +JobYear+ '&validateCount=' +validateCount;
	var htmlobj=$.ajax({url:url,async:false});
	ResponseValidateRequest(htmlobj);
}

function ResponseValidateRequest(xmlHttp)
{
	var gatePassHeader= xmlHttp.responseXML.getElementsByTagName("recCountInterJobHeader")[0].childNodes[0].nodeValue;
	var gatePassDetails= xmlHttp.responseXML.getElementsByTagName("recCountInterJobDetails")[0].childNodes[0].nodeValue;				
	
		if((gatePassHeader=="TRUE") && (gatePassDetails=="TRUE"))
		{
			alert ("Inter Job Transfer No : " + document.getElementById("txtJobNo").value +  " saved successfully.");
			RestrictInterface(0);
		}
		else 
		{
			alert("Error while saving details.Please seve it again");										
		}			
}

function Approved()
{	
	var No = document.getElementById("txtJobNo").value;
	if(No==""){
		alert("Error : ..\n           No Job No to Approved.");
		return;
	}
	var url = 'materialsTransferXml.php?RequestType=Approved&No=' +No;
	var htmlobj=$.ajax({url:url,async:false});
	ApprovedRequest(htmlobj);
}
function ApprovedRequest(xmlHttp)
{
	var Approved = xmlHttp.responseText;	
	if (Approved=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
	{
		alert ("Inter Job Transfer No : " + document.getElementById("txtJobNo").value +  " approved.");
		RestrictInterface(1);				
	}
}
	
function JobNoSearchPopUp()
{
	if(document.getElementById('jobSearch').style.visibility=="hidden")
	{
		document.getElementById('jobSearch').style.visibility = "visible";
		LoadPopUpJobNo();
	}
	else
	{
		document.getElementById('jobSearch').style.visibility="hidden";
		return;
	}	
}

function LoadPopUpJobNo()
{
	
	//RomoveData('cboJobNo');
	document.getElementById('jobSearch').style.visibility = "visible";	
	var state	= document.getElementById('cboState').value;
	var year	= document.getElementById('cboYear').value;
	
	var url = 'materialsTransferXml.php?RequestType=LoadPopUpJobNo&state='+state+'&year='+year;
	
    var htmlobj=$.ajax({url:url,async:false});
	
	
	document.getElementById('cboJobNo').innerHTML = htmlobj.responseText;	
}

function loadTransferIn()
{
	clearMainGrid(); 
	document.getElementById('jobSearch').style.visibility = "hidden";	
	var No=document.getElementById('cboJobNo').value;
	var Year=document.getElementById('cboYear').value;
	if (No=="")return false;	

	var url = 'materialsTransferXml.php?RequestType=LoadHeaderDetails&No=' +No+ '&Year=' +Year;
	var htmlobj=$.ajax({url:url,async:false});
	LoadHeaderDetailsRequest(htmlobj);
	
	var url = 'materialsTransferXml.php?RequestType=LoadDetails&No=' +No+ '&Year=' +Year;
	var htmlobj=$.ajax({url:url,async:false});
	LoadDetailsRequest(htmlobj);
}
	function LoadHeaderDetailsRequest(xmlHttp)
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var XMLJObNO =xmlHttp.responseXML.getElementsByTagName("JObNO")[0].childNodes[0].nodeValue;
				var XMLFromStyle =xmlHttp.responseXML.getElementsByTagName("FromStyle")[0].childNodes[0].nodeValue;
				var XMLToStyle =xmlHttp.responseXML.getElementsByTagName("ToStyle")[0].childNodes[0].nodeValue;
				var XMLFromStyleName =xmlHttp.responseXML.getElementsByTagName("FromStyleName")[0].childNodes[0].nodeValue;
				var XMLToStyleName =xmlHttp.responseXML.getElementsByTagName("ToStyleName")[0].childNodes[0].nodeValue;
				var XMLFromSr =xmlHttp.responseXML.getElementsByTagName("FromSr")[0].childNodes[0].nodeValue;
				var XMLToSr =xmlHttp.responseXML.getElementsByTagName("ToSr")[0].childNodes[0].nodeValue;
				var XMLStatus =parseInt(xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue);			
				var XMLRemarks =xmlHttp.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
				var XMLMainStoreID =xmlHttp.responseXML.getElementsByTagName("MainStoreID")[0].childNodes[0].nodeValue;
				var XMLToBuyerPoNo =xmlHttp.responseXML.getElementsByTagName("ToBuyerPoNo")[0].childNodes[0].nodeValue;
				var XMLToBuyerPoName =xmlHttp.responseXML.getElementsByTagName("ToBuyerPoName")[0].childNodes[0].nodeValue;
				
				var XMLOrderFromName =xmlHttp.responseXML.getElementsByTagName("OrderFromName")[0].childNodes[0].nodeValue;
				var XMLOrderToName =xmlHttp.responseXML.getElementsByTagName("OrderToName")[0].childNodes[0].nodeValue;
				
				
				document.getElementById("txtJobNo").value =XMLJObNO;
				//document.getElementById("cboFromScno").value =XMLFromStyle;	
				//document.getElementById("cboToScno").value =XMLToStyle;	
				document.getElementById("txtRemarks").value =XMLRemarks ;
				document.getElementById("cboMainStores").value =XMLMainStoreID ;
				var opt = document.createElement("option");
				opt.text = XMLToBuyerPoName;
				opt.value = XMLToBuyerPoNo;
				document.getElementById("cboToBuyerPoNo").options.add(opt);
				
				RomoveData('cboFromStyles');
				var opt1 = document.createElement("option");
				opt1.text = XMLFromStyleName;
				opt1.value = XMLFromStyle;
				document.getElementById("cboFromStyles").options.add(opt1);
				
				RomoveData('cboToStyles');
				var opt = document.createElement("option");
				opt.text = XMLToStyleName;
				opt.value = XMLToStyle;
				document.getElementById("cboToStyles").options.add(opt);
				
				
				RomoveData('cboFrom');
				var opt1 = document.createElement("option");
				opt1.text = XMLOrderFromName;
				opt1.value = XMLFromStyle;
				document.getElementById("cboFrom").options.add(opt1);
				
				RomoveData('cboTo');
				var opt = document.createElement("option");
				opt.text = XMLOrderToName;
				opt.value = XMLToStyle;
				document.getElementById("cboTo").options.add(opt);
				
				pub_Status	=XMLStatus;
				
				RestrictInterface(XMLStatus);
			}
		}		
	}
	
function LoadDetailsRequest(xmlHttp1)
{
	if (xmlHttp1.readyState==4)
	{
		if (xmlHttp1.status==200)
		{	
			RemoveAllRows('tblMain');
			var tbl 				= document.getElementById("tblMain");
			var XMLStyleid 			= xmlHttp1.responseXML.getElementsByTagName("Styleid");
			var XMLBuyerPONO 		= xmlHttp1.responseXML.getElementsByTagName("BuyerPONO");				
			var XMLBuyerPOName 		= xmlHttp1.responseXML.getElementsByTagName("BuyerPOName");				
			var XMLMatDetailId 		= xmlHttp1.responseXML.getElementsByTagName("MatDetailId");
			var XMLColor 			= xmlHttp1.responseXML.getElementsByTagName("Color");
			var XMLSize				= xmlHttp1.responseXML.getElementsByTagName("Size");
			var XMLItemDescription 	= xmlHttp1.responseXML.getElementsByTagName("ItemDescription");				
			var XMLUnit 			= xmlHttp1.responseXML.getElementsByTagName("Unit");
			var XMLStockBal 		= xmlHttp1.responseXML.getElementsByTagName("StockBal");
			var XMLQTY 				= xmlHttp1.responseXML.getElementsByTagName("QTY");
			var XMLUnitPrice 		= xmlHttp1.responseXML.getElementsByTagName("UnitPrice");
			var XMLGrnNo 			= xmlHttp1.responseXML.getElementsByTagName("GrnNo");
			var XMLGRNTypeId 		= xmlHttp1.responseXML.getElementsByTagName("GRNTypeId");
			var XMLGRNType 			= xmlHttp1.responseXML.getElementsByTagName("GRNType");
			Materials 				= [];
			mainArrayIndex			= 0;
			

			for (loop=0;loop<XMLBuyerPONO.length;loop++)
			{
			
			if(pub_Status==0){
				
			 var strInnerHtml="";
			 strInnerHtml+="<td><div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"" + mainArrayIndex + "\" height=\"15\" onclick=\"RemoveItem(this);\"/></div></td>";
			 strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLMatDetailId[loop].childNodes[0].nodeValue+"\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLBuyerPONO[loop].childNodes[0].nodeValue+"\">"+XMLBuyerPOName[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+XMLUnitPrice[loop].childNodes[0].nodeValue+"\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntRite\">"+XMLStockBal[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+XMLQTY[loop].childNodes[0].nodeValue+"\" onkeyup=\"ValidateQty(this);SetItemQuantity(this," + mainArrayIndex  + ");\" onkeydown=\"RemoveBinColor(this);\" /></td>";
			 strInnerHtml+="<td class=\"normalfntRite\" id=\"0\" ><div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\" height=\"20\" onclick=\"ValidateBinBinDetails(this," + mainArrayIndex  + ");SetLocationItemQuantity(this," + mainArrayIndex  + ");\"/></div></td>";
			 strInnerHtml+="<td class=\"normalfntRite\">"+XMLGrnNo[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLGRNTypeId[loop].childNodes[0].nodeValue+"\">"+XMLGRNType[loop].childNodes[0].nodeValue+"</td>";
			}
			else{
				 var strInnerHtml="";
					
				strInnerHtml+="<td><div align=\"center\"><img src=\"../images/del.png\" alt=\"del\" width=\"15\" id=\"" + mainArrayIndex + "\" height=\"15\" onclick=\"ConfirmRemoveItem();\"/></div></td>";
			 strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLMatDetailId[loop].childNodes[0].nodeValue+"\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLBuyerPONO[loop].childNodes[0].nodeValue+"\">"+XMLBuyerPOName[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntMidSML\" id=\""+XMLUnitPrice[loop].childNodes[0].nodeValue+"\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntMidSML\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>";
			 strInnerHtml+="<td class=\"normalfntRite\">"+XMLStockBal[loop].childNodes[0].nodeValue+"</td>";
			 //strInnerHtml+="<td class=\"normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+XMLQTY[loop].childNodes[0].nodeValue+"\" readonly=\"readonly\" onkeyup=\"ValidateQty(this);SetItemQuantity(this," + mainArrayIndex  + ");\" onkeydown=\"RemoveBinColor(this);\" /></td>";
			 strInnerHtml+="<td class=\"normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return isNumberKey(event);\" value=\""+XMLQTY[loop].childNodes[0].nodeValue+"\" onkeyup=\"ValidateQty(this);SetItemQuantity(this," + mainArrayIndex  + ");\" onkeydown=\"RemoveBinColor(this);\" /></td>";
			 strInnerHtml+="<td class=\"normalfntRite\" id=\"0\" ><div align=\"right\"><img src=\"../images/location.png\" alt=\"del\" width=\"80\" height=\"20\" onclick=\"ValidateBinBinDetails(this," + mainArrayIndex  + ");SetLocationItemQuantity(this," + mainArrayIndex  + ");\"/></div></td>";
			  strInnerHtml+="<td class=\"normalfntRite\">"+XMLGrnNo[loop].childNodes[0].nodeValue+"</td>";
			  strInnerHtml+="<td class=\"normalfnt\" id=\""+XMLGRNTypeId[loop].childNodes[0].nodeValue+"\">"+XMLGRNType[loop].childNodes[0].nodeValue+"</td>";
			}
			
			var details		= [];
			details[0]	= XMLMatDetailId[loop].childNodes[0].nodeValue;
			details[1]	= XMLBuyerPONO[loop].childNodes[0].nodeValue;
			details[2]	= XMLColor[loop].childNodes[0].nodeValue;
			details[3]	= XMLSize[loop].childNodes[0].nodeValue;
			details[4]	= XMLUnit[loop].childNodes[0].nodeValue;
			details[6]	= XMLQTY[loop].childNodes[0].nodeValue;
			details[7]	= parseFloat(XMLUnitPrice[loop].childNodes[0].nodeValue);
			details[8]	= XMLGrnNo[loop].childNodes[0].nodeValue;
			details[9]	= XMLGRNTypeId[loop].childNodes[0].nodeValue;
			
			Materials[mainArrayIndex]= details;
			mainArrayIndex++;
		
			var lastRow = tbl.rows.length;	
			var row = tbl.insertRow(lastRow);						
			tbl.rows[lastRow].innerHTML=  strInnerHtml ;
			tbl.rows[lastRow].id = lastRow;			
			tbl.rows[lastRow].className = "bcgcolor-tblrowWhite";
			}
		}
	}activeCommonBins();
}
	
function RestrictInterface(XMLStatus){
	
		switch (XMLStatus){
		case 0:
			if(canSaveInterjobTransfer)
			{
				document.getElementById("cmdSave").style.display="inline";
				if(canApproveInterjobTransfer)
					document.getElementById("cmdApproved").style.display="inline";
				document.getElementById("cmdAuthorise").style.display="none";
				document.getElementById("cmdConform").style.display="none";
				document.getElementById("cmdCancel").style.display="none";
				document.getElementById("cboMainStores").disabled=false;
				document.getElementById("cmdSearch").style.display="inline";
				document.getElementById("cboFrom").disabled=false;
				document.getElementById("cboTo").disabled=false;
				//document.getElementById("cboFromScno").disabled=false;
				//document.getElementById("cboToScno").disabled=false;
			}
			break;
		case 1:	
			if(canApproveInterjobTransfer)
			{
				document.getElementById("cmdSave").style.display="none";
				document.getElementById("cmdApproved").style.display="none";
				if(canAuthorizeInterjobTransfer)
					document.getElementById("cmdAuthorise").style.display="inline";
				document.getElementById("cmdConform").style.display="none";
				document.getElementById("cmdCancel").style.display="none";
				document.getElementById("cmdSearch").style.display="none";
				document.getElementById("cboFrom").disabled="disabled";
				document.getElementById("cboTo").disabled="disabled";
				//document.getElementById("cboFromScno").disabled="disabled";
				//document.getElementById("cboToScno").disabled="disabled";
				document.getElementById("cboToBuyerPoNo").disabled="disabled";
			}
			break;
		case 2:	
			if(canAuthorizeInterjobTransfer)
			{					
				document.getElementById("cmdSave").style.display="none";	
				document.getElementById("cmdApproved").style.display="none";	
				document.getElementById("cmdAuthorise").style.display="none";
				if (canConfirmInterjobTransfer)
					document.getElementById("cmdConform").style.display="inline";
				document.getElementById("cmdCancel").style.display="none";
				document.getElementById("cboMainStores").disabled="disabled";
				document.getElementById("cmdSearch").style.display="none";
				document.getElementById("cboFrom").disabled="disabled";
				document.getElementById("cboTo").disabled="disabled";
				//document.getElementById("cboFromScno").disabled="disabled";
				//document.getElementById("cboToScno").disabled="disabled";
				document.getElementById("cboToBuyerPoNo").disabled="disabled";
			}
			//ShowMainBin();
			break;					
		case 3:		
			if (canConfirmInterjobTransfer)
			{				
				document.getElementById("cmdSave").style.display="none";
				document.getElementById("cmdApproved").style.display="none";	
				document.getElementById("cmdAuthorise").style.display="none";											
				document.getElementById("cmdConform").style.display="none";
				if(canCancelInterjobTransfer)
					document.getElementById("cmdCancel").style.display="inline";
				document.getElementById("cboMainStores").disabled="disabled";					
				document.getElementById("cmdSearch").style.display="none";	
				document.getElementById("cboFrom").disabled="disabled";
				document.getElementById("cboTo").disabled="disabled";
				//document.getElementById("cboFromScno").disabled="disabled";
				//document.getElementById("cboToScno").disabled="disabled";
				document.getElementById("cboToBuyerPoNo").disabled="disabled";
			}
			break;
		case 10:	
			if(canCancelInterjobTransfer)
			{					
				document.getElementById("cmdSave").style.display="none";
				document.getElementById("cmdApproved").style.display="none";	
				document.getElementById("cmdAuthorise").style.display="none";											
				document.getElementById("cmdConform").style.display="none";
				document.getElementById("cmdCancel").style.display="none";	
				document.getElementById("cboMainStores").disabled="disabled";
				document.getElementById("cmdSearch").style.display="none";
				document.getElementById("cboFrom").disabled="disabled";
				document.getElementById("cboTo").disabled="disabled";
				///document.getElementById("cboFromScno").disabled="disabled";
				//document.getElementById("cboToScno").disabled="disabled";
				document.getElementById("cboToBuyerPoNo").disabled="disabled";
			}
			break;							
	}
}

function ConfirmRemoveItem()
{
	alert("You cannot remove item after Approved state....")
}
	
	
function Authorise()
{	
	var No = document.getElementById("txtJobNo").value
	if(No==""){
		alert("Error : ..\n           No Job No to Authorised.");
		return;
	}
	var url = 'materialsTransferXml.php?RequestType=Authorise&No=' +No;
	var htmlobj = $.ajax({url:url,async:false});
	AuthoriseRequest(htmlobj);
}

function AuthoriseRequest(xmlHttp)
{
	var Approved = xmlHttp.responseText;
	
	if (Approved=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
	{
		alert ("Inter Job Transfer No : " + document.getElementById("txtJobNo").value +  " Authorise.");
		RestrictInterface(2);
	}
}

function ShowMainBin()
{
	if(document.getElementById('ShowMainBin').style.visibility=="hidden")
	{
		document.getElementById('ShowMainBin').style.visibility = "visible";
		LoadMainStoresToPopUp();
	}
	else
	{
		document.getElementById('ShowMainBin').style.visibility="hidden";
		return;
	}	
}

function CloseMainBin()
{
	if(document.getElementById('ShowMainBin').style.visibility=="visible")
	{
		document.getElementById('ShowMainBin').style.visibility = "hidden";
	}
}

//End - BinAllocation

function LoadMainStoresToPopUp()
{
	RomoveData('cboMainStores');
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadMainStoresToPopUpRequest;
	xmlHttp.open("GET",'materialsTransferXml.php?RequestType=LoadMainStoresToPopUp' ,true);
	xmlHttp.send(null);
}
	function LoadMainStoresToPopUpRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{	
			 var XMLName= xmlHttp.responseXML.getElementsByTagName("Name");
			 var XMLID= xmlHttp.responseXML.getElementsByTagName("ID");
			 
			 var opt = document.createElement("option");
				opt.text = "Select MainStores";
				opt.value = "0";
				document.getElementById("cboMainStores").options.add(opt);
				
			 for ( var loop = 0; loop < XMLName.length; loop ++)
			 {			
				var opt = document.createElement("option");
				opt.text = XMLName[loop].childNodes[0].nodeValue;
				opt.value = XMLID[loop].childNodes[0].nodeValue;
				document.getElementById("cboMainStores").options.add(opt);
			 }
			}
		}
	}

function LoadPopUpSubStores()
{
	var MainStoresId =document.getElementById('cboMainStores').value;
	RomoveData('cboSubStores');
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadPopUpSubStoresRequest;
	xmlHttp.open("GET",'materialsTransferXml.php?RequestType=LoadPopUpSubStores&MainStoresId=' +MainStoresId ,true);
	xmlHttp.send(null);
}
	function LoadPopUpSubStoresRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{	
			 var XMLSubStoresName= xmlHttp.responseXML.getElementsByTagName("SubStoresName");
			 var XMLSubStoresID= xmlHttp.responseXML.getElementsByTagName("SubStoresID");
			 	
				var opt = document.createElement("option");
				opt.text = "Select SubStores";
				opt.value = "0";
				document.getElementById("cboSubStores").options.add(opt);
			 
			 for ( var loop = 0; loop < XMLSubStoresID.length; loop ++)
			 {			
				var opt = document.createElement("option");
				opt.text = XMLSubStoresName[loop].childNodes[0].nodeValue;
				opt.value = XMLSubStoresID[loop].childNodes[0].nodeValue;
				document.getElementById("cboSubStores").options.add(opt);
			 }
			}
		}
	}
function LoadPopUpLocations()
{
	var MainStoresId =document.getElementById('cboMainStores').value;
	var SubStoresId =document.getElementById('cboSubStores').value;
	
	RomoveData('cboLocation');
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadPopUpLocationsRequest;
	xmlHttp.open("GET",'materialsTransferXml.php?RequestType=LoadPopUpLocations&MainStoresId=' +MainStoresId+ '&SubStoresId=' +SubStoresId ,true);
	xmlHttp.send(null);
}
	function LoadPopUpLocationsRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{				
			 var XMLLocationName= xmlHttp.responseXML.getElementsByTagName("LocationName");
			 var XMLLocationID= xmlHttp.responseXML.getElementsByTagName("LocationID");		
			 
			var opt = document.createElement("option");
				opt.text = "Select Location";
				opt.value = "0";
				document.getElementById("cboLocation").options.add(opt);
				
			 for ( var loop = 0; loop < XMLLocationID.length; loop++)
			 {			
				var opt = document.createElement("option");
				opt.text = XMLLocationName[loop].childNodes[0].nodeValue;
				opt.value = XMLLocationID[loop].childNodes[0].nodeValue;
				document.getElementById("cboLocation").options.add(opt);
			 }
			}
		}
	}

function ValidateBinBinDetails(rowNo,index)
{
	pub_index=index;	
	var No = document.getElementById("txtJobNo").value
	var rw=rowNo.parentNode.parentNode.parentNode;
	mainRw = rowNo.parentNode.parentNode.parentNode.rowIndex;
	pub_TrasferInQty=0;
	pub_TrasferInQty =parseFloat(rw.cells[7].childNodes[0].value);
	var stockQty =parseFloat(rw.cells[6].childNodes[0].nodeValue);
	
	if(No==""){
		alert ("In the current step you cannot add bins");
		return false;
	}
	
	if (pub_TrasferInQty=="" || pub_TrasferInQty==0 || pub_TrasferInQty==isNaN)	{
		alert ("TransferIn Qty Can't be '0' Or Empty");
		rw.cells[7].childNodes[0].value=stockQty
		 return false;
	}
	else if (pub_TrasferInQty > stockQty){
		alert ("Can't allocate more than stockQty");
		rw.cells[7].childNodes[0].value =stockQty;
		return false;
	}
	createXMLHttpRequest();
	xmlHttp.index=rowNo;
	xmlHttp.onreadystatechange=ValidateBinBinDetailsRequest;
	xmlHttp.open("GET",'materialsTransferXml.php?RequestType=ValidateBinBinDetails&No=' +No ,true);
	xmlHttp.send(null);
}
	function ValidateBinBinDetailsRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{
				var rowNo = xmlHttp.index;				
				var XMLStatus =xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
				if(XMLStatus==2)
				{				
					loadBins(rowNo);
				}
				else
				{
					alert ("In the current step you cannot add bins.");
				}
			}
		}
	}
	
function loadBins(rowNo)
{
	var rw=rowNo.parentNode.parentNode.parentNode;
	
	
	var fromStyleId		= document.getElementById('cboFrom').value;//options[document.getElementById('cboFrom').selectedIndex].text;
	var matDetailId 	= rw.cells[1].id;
	var buyerPoNo 		= rw.cells[2].id;	
	var color 			= rw.cells[3].childNodes[0].nodeValue;
	var size 			= rw.cells[4].childNodes[0].nodeValue;
	var StoresId		= document.getElementById('cboMainStores').value;
	var grnNo 			= rw.cells[9].childNodes[0].nodeValue;
	var grnType			= rw.cells[10].id;
	
	var url = 'binitems.php?pub_TrasferInQty=' +pub_TrasferInQty+ '&pub_index=' +pub_index+ '&fromStyleId=' +URLEncode(fromStyleId)+ '&matDetailId=' +matDetailId+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&StoresId=' +StoresId+ '&GRNNo='+grnNo+ '&GRNType='+grnType;
	var htmlobj=$.ajax({url:url,async:false});
	LoadBinDetailsRequest(htmlobj);
}

function LoadBinDetailsRequest(xmlHttp)
{
	drawPopupArea(570,305,'frmMaterialTransfer');				
	var HTMLText=xmlHttp.responseText;
	document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;				
}
//Start - bin qty validate part
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[2].childNodes[0].childNodes[1].checked)
	{	
	    var totReqQty = document.getElementById('txtReqQty').value;	
		var reqQty = parseFloat(rw.cells[0].lastChild.nodeValue);		
		var issueQty = parseFloat(rw.cells[1].childNodes[0].value);		
		rw.cells[1].childNodes[0].value = 0;
		var GPLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (rw.cells[2].childNodes[0].childNodes[1].checked)
					{		
						GPLoopQty +=  parseFloat(tbl.rows[loop].cells[1].childNodes[0].value);						
					}
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(GPLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[1].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[1].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[1].childNodes[0].value = 0;
}
//End - bin qty validate part

function SetBinItemQuantity(obj,index)
{	
	var tblMain =document.getElementById("tblMain");				
	var tblBin = document.getElementById('tblBinItem');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var GPLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++)
		{
			if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked)
			{		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[1].childNodes[0].value);	
			}	
		}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ )
			{						
				if (tblBin.rows[loop].cells[2].childNodes[0].childNodes[1].checked)
				{					
						var Bindetails = [];
							Bindetails[0] =   tblBin.rows[loop].cells[1].childNodes[0].value; // IssueQty
							Bindetails[1] =   tblBin.rows[loop].cells[3].id; // MainStores
							Bindetails[2] =   tblBin.rows[loop].cells[4].id;// SubStores
							Bindetails[3] =   tblBin.rows[loop].cells[5].id; // Location
							Bindetails[4] =   tblBin.rows[loop].cells[6].id; // Bin Id							
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
						
				}
			}
		Materials[index][5] = BinMaterials;				
		tblMain.rows[mainRw].className = "bcgcolor-tblrowLiteBlue";//osc3,backcolorGreen,normalfnt2BITAB
		tblMain.rows[mainRw].cells[8].id =1;
		closeWindow();		
	}
	else 
	{
		alert ("Allocated Qty must Equal with Required Qty. \nReq Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}
	
}

function ConfirmValidation()
{
	var tblMain		= document.getElementById('tblMain');
	var No 			= document.getElementById("txtJobNo").value
		
	if(No=="")
	{
		alert ("No 'Job No' to confirm.");
		return false;
	}
	
	for (loop = 0 ;loop < tblMain.rows.length; loop++)
	{
		var issueQty 		 = parseFloat(tblMain.rows[loop].cells[7].childNodes[0].value);
		var stockQty 		 = parseFloat(tblMain.rows[loop].cells[6].childNodes[0].nodeValue);		
		var checkBinAllocate = tblMain.rows[loop].cells[8].id;
		
		if ((issueQty=="")  || (issueQty==0))
		{
			alert ("Issue Qty Can't Be '0' Or Empty.")
			return false;				
		} 
		if (pub_ActiveCommonBins==0 && checkBinAllocate ==0)		
		{
			alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +"." )
			return false;				
		}						
	}	
return true;
} 

function activeCommonBins(){
	var strMainStores = document.getElementById('cboMainStores').value;

	var url="materialsTransferXml.php";
					url=url+"?RequestType=getCommonBin";
					url += '&strMainStores='+strMainStores;
	var htmlobj=$.ajax({url:url,async:false});

	pub_ActiveCommonBins = htmlobj.responseXML.getElementsByTagName("commonbin")[0].childNodes[0].nodeValue;
	pub_AutomateBin = htmlobj.responseXML.getElementsByTagName("autoBin")[0].childNodes[0].nodeValue;
    pub_strLocName = htmlobj.responseXML.getElementsByTagName("strLocName")[0].childNodes[0].nodeValue;
	pub_strBinName = htmlobj.responseXML.getElementsByTagName("strBinName")[0].childNodes[0].nodeValue;
	pub_strSubStoresName= htmlobj.responseXML.getElementsByTagName("strSubStoresName")[0].childNodes[0].nodeValue;
	pub_strMainStoresName = strMainStores;
}

function Confirm()
{
	document.getElementById('cmdConform').style.display='none';
	if(!ConfirmValidation())
	{
		document.getElementById('cmdConform').style.display='inline';
		return;
	}
	validateCount 		= 0;
	validateBinCount	= 0;
	var No 				= document.getElementById("txtJobNo").value;
		No 				= No.split("/");

	var fromStyleNo 	= document.getElementById("cboFrom").value;
	var toStyleNo 		= document.getElementById("cboTo").value;
	var remarks 		= document.getElementById('txtRemarks').value;		
	var toBuyerPoNo 	= document.getElementById('cboToBuyerPoNo').value;	
	var count = 0;
	var url = 'materialsTransferXml.php?RequestType=updateHeader&JobNo=' +No[1]+ '&JobYear=' +No[0]+ '&remarks=' +URLEncode(remarks);
	var htmlobj=$.ajax({url:url,async:false});
	
		for (loop = 0 ; loop < Materials.length ; loop ++)
		{	
		    count++;
			var details = Materials[loop] ;
			if 	(details!=null)
			{
				var itemDetailID 	= details[0] ;	// itemDetailID;
				var	BuyerPoNo 		= details[1] ;	// buyerPoNo;	
				var color			= details[2] ;	// color;
				var size			= details[3] ;	// size;
				var units			= details[4] ;	// units;
				var binArray 		= details[5] ;
				var stockBal		= details[6] ;	// QTY;
				var unitPrise		= details[7] ;	// QTY;
				var grnNo			= details[8] ;	// QTY;
				var grnTypeId		= details[9] ;	// QTY;
					
				validateCount++;
					
		var url = 'materialsTransferXml.php?RequestType=ConfirmDetails&JobNo=' +No[1]+ '&JobYear=' +No[0]+ '&BuyerPoNo=' +URLEncode(BuyerPoNo)+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&Qty=' +stockBal+ '&unitPrise=' +unitPrise+ '&grnNo=' +grnNo+ '&grnTypeId='+grnTypeId;
		var htmlobj=$.ajax({url:url,async:false});
		if(pub_ActiveCommonBins == 0){
				
				for (i = 0; i < binArray.length; i++)
				{
					var Bindetails 		= binArray[i];
					var issueBinQty 	= Bindetails[0]; 		// IssueQty
					var mainStores  	= Bindetails[1]; 		// MainStores
					var subStores  		= Bindetails[2];		// subStores
					var location  		= Bindetails[3]; 		// location
					var binId 			= Bindetails[4]; 		// binId							
					validateBinCount++;
					if(issueBinQty>0){
						
					// ----------------- 08/20/2014 -------------------------------	
					// Add binwise qty to stocktransaction instead of deduct full qty from 
					// Replace 'stockBal' with 'issueBinQty'
					// ---------------------------------------------------------------------
						var url = 'materialsTransferXml.php?RequestType=SaveBinDetails&mainStores=' +mainStores+ '&subStores=' +subStores+ '&location=' +location+ '&binId=' +binId+ '&fromStyleNo=' +URLEncode(fromStyleNo)+ '&toStyleNo=' +URLEncode(toStyleNo)+ '&BuyerPoNo=' +URLEncode(BuyerPoNo)+ '&JobNo=' +No[1]+ '&JobYear=' +No[0]+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&Qty=' +issueBinQty+ '&validateBinCount=' +validateBinCount+ '&toBuyerPoNo=' +URLEncode(toBuyerPoNo)+ '&grnNo=' +grnNo+ '&grnTypeId=' +grnTypeId;
					var htmlobj=$.ajax({url:url,async:false});
					
					}
				}
		      }else{ 
				  	var url = 'materialsTransferXml.php?RequestType=SaveBinDetails&mainStores=' +pub_strMainStoresName+ '&subStores=' +pub_strSubStoresName+ '&location=' +pub_strLocName+ '&binId=' +pub_strBinName+ '&fromStyleNo=' +URLEncode(fromStyleNo)+ '&toStyleNo=' +URLEncode(toStyleNo)+ '&BuyerPoNo=' +URLEncode(BuyerPoNo)+ '&JobNo=' +No[1]+ '&JobYear=' +No[0]+ '&itemDetailID=' +itemDetailID+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&Qty=' +stockBal+ '&validateBinCount=' +validateBinCount+ '&toBuyerPoNo=' +URLEncode(toBuyerPoNo)+ '&grnNo=' +grnNo+ '&grnTypeId=' +grnTypeId;
					var htmlobj=$.ajax({url:url,async:false});
			  }
			}
		}
		if(document.getElementById("tblMain").rows.length == count){
		 alert ("Inter Job Transfer No : " + document.getElementById("txtJobNo").value +  " confirmed successfully.");		
		}
	//confirmValidate();
}

function confirmValidate()
{
	
	var No 				= document.getElementById("txtJobNo").value;
		No 				= No.split("/");
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = confirmValidateRequest;
	xmlHttp.open("GET",'materialsTransferXml.php?RequestType=confirmValidate&JobNo=' +No[1]+ '&JobYear=' +No[0]+ '&validateCount=' +validateCount+ '&validateBinCount=' +validateBinCount ,true);
	xmlHttp.send(null);
}
	function confirmValidateRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200)
			{				
				var jobHeader= xmlHttp.responseXML.getElementsByTagName("recCountInterJobHeader")[0].childNodes[0].nodeValue;
				var jobDetails= xmlHttp.responseXML.getElementsByTagName("recCountInterJobDetails")[0].childNodes[0].nodeValue;				
				var jobBinDetails= xmlHttp.responseXML.getElementsByTagName("recCountInterJobBinDetails")[0].childNodes[0].nodeValue;
				
					if((jobHeader=="TRUE") && (jobDetails=="TRUE") &&(jobBinDetails=="TRUE"))
					{
						alert ("Inter Job Transfer No : " + document.getElementById("txtJobNo").value +  " confirmed successfully.");							
						RestrictInterface(3);
						
					}
					else 
					{
						confirmValidate();											
					}			
			}
		}
	}

function RemoveBinColor(obj,index)
{
	var tblMain =document.getElementById("tblMain");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "normalfnt";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
	tblMain.rows[Rw].cells[0].id =0;
}

function ViewReport()
{
		var No =document.getElementById("txtJobNo").value;
		No = No.split("/");
		if(No==""){alert("No job no appear to view....");return}
		InterJobNo =parseInt(No[1]);
		InterJobYear =parseInt(No[0]);

	newwindow=window.open('interJobMaterialTransferNote.php?InterJobNo='+InterJobNo+ '&InterJobYear=' +InterJobYear ,'name');
			if (window.focus) {newwindow.focus()}
}
//Start - Cancel part
function Cancel()
{	
	var No = document.getElementById("txtJobNo").value;
	var url = 'materialsTransferXml.php?RequestType=Cancel&No=' +No;
	var htmlobj=$.ajax({url:url,async:false});
	GatePassCancelRequest(htmlobj);
}

function GatePassCancelRequest(xmlHttp)
{
	var intConfirm = xmlHttp.responseText;	
	
	if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
	{	
		alert ("Inter Job No : " + document.getElementById("txtJobNo").value +  " canceled successfully.");
		RestrictInterface(10);
	}					
}	
//End - Cancel part

function rowclickColorChange()
{
	var rowIndex = this.rowIndex;
	var tbl = document.getElementById('tblMain');
    for ( var i = 1; i < tbl.rows.length; i ++)
	{
		tbl.rows[i].className = "";
		if ((i % 2) == 1)
		{
			tbl.rows[i].className="bcgcolor-tblrow";
		}
		if( i == rowIndex)
		tbl.rows[i].className = "bcgcolor-highlighted";
	}
	
}

function hideButtons()
{
	document.getElementById('cmdAuthorise').style.display = "none";
	document.getElementById('cmdConform').style.display = "none";
	document.getElementById('cmdCancel').style.display = "none";
}

//-----------------------------------------------------------------------------------------------------------------------

function getStylewiseOrderNoNewFROM(type,cboValue,orderID)
{
   var stytleName = cboValue;
   var url="/gapro/commonPHP/styleNoOrderNoSCLoadingXML.php";
				url=url+"?RequestType="+type+"";
				    url += '&stytleName='+URLEncode(stytleName);
				
	var htmlobj=$.ajax({url:url,async:false});
	var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById(""+orderID+"").innerHTML =  OrderNo;
}

function getScNoFrom(type,id)
{
   var styleName = document.getElementById('cboFromStyles').value;
   var url=   "/gapro/commonPHP/styleNoOrderNoSCLoadingXML.php";
					url=url+"?RequestType="+type+"";
					    url += '&styleName='+styleName;
					
   var htmlobj=$.ajax({url:url,async:false});
   var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
   document.getElementById(''+id+'').innerHTML =  OrderNo;
	
}

function getStylewiseOrderNoNewTO(type,cboValue,orderID)
{
   var stytleName = cboValue;
   var url="/gapro/commonPHP/styleNoOrderNoSCLoadingXML.php";
				url=url+"?RequestType="+type+"";
				    url += '&stytleName='+URLEncode(stytleName);
				
	var htmlobj=$.ajax({url:url,async:false});
	var OrderNo = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById(""+orderID+"").innerHTML =  OrderNo;
}

function getScNoTo(type,id)
{ 
   var styleName = document.getElementById('cboToStyles').value;
   var url=   "/gapro/commonPHP/styleNoOrderNoSCLoadingXML.php";
					url=url+"?RequestType="+type+"";
					    url += '&styleName='+styleName;
					
   var htmlobj=$.ajax({url:url,async:false});
   var OrderNo = htmlobj.responseXML.getElementsByTagName("SCNO")[0].childNodes[0].nodeValue;
   document.getElementById(''+id+'').innerHTML =  OrderNo;
	
}

function getSC(cboSR,cboOrderNo)
{
	document.getElementById(''+cboSR+'').value = document.getElementById(''+cboOrderNo+'').value;
}

function getStyleNoFromSC(cboSR,cboOrderNo)
{
	var scNo = document.getElementById(''+cboSR+'').value;
	document.getElementById(''+cboOrderNo+'').value = scNo;
}

//----------------------------------------------------------------------------------------------------------------------------

function clearMainGrid(){ 
	var tblMain = document.getElementById('tblMain');
	var binCount2	=	tblMain.rows.length;
	for(var loop=0;loop<binCount2;loop++)
	{
			tblMain.deleteRow(loop);
			binCount2--;
			loop--;
	}
}
function loadStyleName()
{
	var scNo = document.getElementById("cboFromScno").value;
	var url = 'materialsTransferXml.php?RequestType=LoadStyleNames&scNo=' +scNo;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLstrStyle 	= htmlobj.responseXML.getElementsByTagName("strStyle")[0].childNodes[0].nodeValue;				
	
	document.getElementById("cboFromStyles").value =XMLstrStyle;
	
	
}
function loadStyleNameTo()
{
	var scNoTo = document.getElementById("cboToScno").value;
	var url = 'materialsTransferXml.php?RequestType=LoadStyleNamesTo&scNoTo=' +scNoTo;
	var htmlobj=$.ajax({url:url,async:false});
	
	var XMLstrStyleTo 	= htmlobj.responseXML.getElementsByTagName("strStyleTo")[0].childNodes[0].nodeValue;				
	
	document.getElementById("cboToStyles").value =XMLstrStyleTo;
}