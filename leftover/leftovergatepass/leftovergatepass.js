var xmlHttp;
var altxmlHttp;
var xmlHttp2 			= [];
var xmlHttp5			= [];
var Materials 			= [];


var mainArrayIndex 		= 0;
var ReqGatePassQty 		= 0;
var mainRw				= 0;
var gatePassNo 			= 0;
var gatePassYear 		= 0;
var validateCount 		= 0;
var validateBinCount 	= 0;
var state 				= 0;
var checkLoop		 	= 0;

var Pub_PopUprowIndex	= 0;
var Pub_popUoRollIndex	= 0;
var gatePassStatus      = 0;

var pub_commonBin		= 0;
//Start-ClearForm
function ClearForm()
{	
	setTimeout("location.reload(true);",0);
	
}
//End-ClearForm

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

//start - configuring HTTP1 request
function createXMLHttpRequest1() 
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
//start - configuring HTTP1 request

//start - configuring HTTP2 request
function createXMLHttpRequest2(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}
//End - configuring HTTP2 request

// start - configuring ALTHTTP request
function createAltXMLHttpRequest() 
{
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}
// End - configuring ALTHTTP request

function createXMLHttpRequest5(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp5[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp5[index] = new XMLHttpRequest();
    }
}

//Start -Get GetXmlHttpObject
function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
 	{
 	// Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
 	}
	catch (e)
 	{
 	// Internet Explorer
 		try
  		{
  			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		}
 	catch (e)
  	{
  		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
 	}
return xmlHttp;
}
//End -Get GetXmlHttpObject

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

//Start - Clear table data
function RemoveAllRows(tableName)
{
	var tbl = document.getElementById(tableName);
	for ( var loop = tbl.rows.length-1 ;loop >= 1 ; loop -- )
	{
		 tbl.deleteRow(loop);
	}	
}
//End - Clear table data

//Start - restrict to type only numeric value
var AllowableCharators=new Array("38","37","39","40","8");
 function isNumberKey(evt)
  {
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
//End - restrict to type only numeric value

function showBackGroundBalck()
{
	var popupbox = document.createElement("div");
   popupbox.id = "divBackGroundBalck";
   popupbox.style.position = 'absolute';
   popupbox.style.zIndex = 5;
   popupbox.style.left = 0 + 'px';
   popupbox.style.top = 0 + 'px'; 
   popupbox.style.background="#000000"; 
   popupbox.style.width = screen.width + 'px';
   popupbox.style.height = screen.height + 'px';
   popupbox.style.MozOpacity = 0.5;
   popupbox.style.color = "#FFFFFF";
	
	document.body.appendChild(popupbox);
}

function hideBackGroundBalck()
{
	try
	{
		var box = document.getElementById('divBackGroundBalck');
		box.parentNode.removeChild(box);
	}
	catch(err)
	{        
	}	
}

//Start-Delete selected table row from the Table issue.php
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
//End-Delete selected table row from the Table issue.php

function DeleteRow(obj)
{
	var GatePassNO =document.getElementById("cboGatePassNo").value;
	var rw=obj.parentNode.parentNode.parentNode;
	
	var styleId 	= rw.cells[3].id;
	var buyerPoNo 	= rw.cells[4].childNodes[0].nodeValue;
	var color 		= rw.cells[5].childNodes[0].nodeValue;
	var size 		= rw.cells[6].childNodes[0].nodeValue;
	var matDetailId = rw.cells[2].id;
	var grnNo 		= rw.cells[12].childNodes[0].nodeValue;
	var grnYear 	= rw.cells[13].childNodes[0].nodeValue;
	var grnType 	= rw.cells[14].id;
	
	createXMLHttpRequest();
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=DeleteRow&GatePassNO=' +GatePassNO+ '&styleId=' +URLEncode(styleId)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&matDetailId=' +matDetailId+'&grnNo='+grnNo+'&grnYear='+grnYear+ '&GrnType=' +grnType ,true);
	xmlHttp.send(null);
}


function closeWindow()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}
}


//Start - LoadDestination wise data  
function LoadDestination()
{
	if (document.getElementById('optIn').checked==true)
	{
		LoadInternalDestination();
	}
	else 
	{
		LoadExternalDestination();
	}
}

function LoadInternalDestination()
{
	createXMLHttpRequest();
	RomoveData("cboDestination")
	xmlHttp.onreadystatechange = LoadInternalDestinationRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=LoadInternalDestination' ,true);
	xmlHttp.send(null);
}
	
	function LoadInternalDestinationRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLMainID =xmlHttp.responseXML.getElementsByTagName("MainID");
				var XMLName =xmlHttp.responseXML.getElementsByTagName("Name");
				
					var opt = document.createElement("option");
						opt.text = "Select Destination";						
						document.getElementById("cboDestination").options.add(opt);	
										
					for ( var loop = 0; loop < XMLName.length; loop ++)
			 		{	
						
						var opt = document.createElement("option");
						opt.text = XMLName[loop].childNodes[0].nodeValue;
						opt.value = XMLMainID[loop].childNodes[0].nodeValue;
						document.getElementById("cboDestination").options.add(opt);			
			 		}
			}
		}	
	}
function LoadExternalDestination()
{
	createXMLHttpRequest();
	RomoveData("cboDestination")
	xmlHttp.onreadystatechange = LoadExternalDestinationRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=LoadExternalDestinationRequest' ,true);
	xmlHttp.send(null);
}
	function LoadExternalDestinationRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)	
			{
				var XMLSubContractorID =xmlHttp.responseXML.getElementsByTagName("SubContractorID");
				var XMLName =xmlHttp.responseXML.getElementsByTagName("Name");
				
					var opt = document.createElement("option");
						opt.text = "Select Destination";						
						document.getElementById("cboDestination").options.add(opt);	
										
					for ( var loop = 0; loop < XMLSubContractorID.length; loop ++)
			 		{	
						
						var opt = document.createElement("option");
						opt.text = XMLName[loop].childNodes[0].nodeValue;
						opt.value = XMLSubContractorID[loop].childNodes[0].nodeValue;
						document.getElementById("cboDestination").options.add(opt);			
			 		}
			}
		}	
	}
//End - LoadDestination wise data 

function LoadSCNO(){
	//var StyleID =document.getElementById('cboOrderNo').options[document.getElementById('cboOrderNo').selectedIndex].text;
	var StyleID =document.getElementById('cboOrderNo').value;
	document.getElementById('cboScNo').value =StyleID;	
}

function LoadStyleID(obj){
	
	document.getElementById('cboOrderNo').value =obj.value;	
}

//Start -Load Buyer PONO TO Combo
function LoadBuyerPoNo(obj)
{	

	document.getElementById('cboScNo').value = obj.value;
	var styleId = document.getElementById('cboOrderNo').value;
	createXMLHttpRequest();
	RomoveData("cboBuyerPoNo")
	xmlHttp.onreadystatechange=LoadBuyerPoNoRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=LoadBuyetPoNo&styleId=' + URLEncode(styleId) ,true);
	xmlHttp.send(null);
}
	function LoadBuyerPoNoRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
			
				var XMLBuyerPoNo =xmlHttp.responseXML.getElementsByTagName("BuyerPoNo");
				var XMLBuyerPoName =xmlHttp.responseXML.getElementsByTagName("BuyerPoName");
					for ( var loop = 0; loop < XMLBuyerPoNo.length; loop ++)
			 		{							
						var opt = document.createElement("option");
						opt.value = XMLBuyerPoNo[loop].childNodes[0].nodeValue;
						opt.text = XMLBuyerPoName[loop].childNodes[0].nodeValue;						
						document.getElementById("cboBuyerPoNo").options.add(opt);			
			 		}
			}
		}
	}
//End -Load Buyer PONO To Combo

//Start - Load Gate Pass Item form using PopUp Window
function LoadGatePassItems()
{	
	
	var BuyerPoNo 	= document.getElementById("cboBuyerPoNo").value;
	var StyleId 	= document.getElementById("cboOrderNo").value;
	var mainStore 	= document.getElementById("cboMainStore").value;
	
	if(StyleId=="")
	{
		alert("Please select the 'Order No'.");
		document.getElementById('cboOrderNo').focus();
		return;
	}
	else if(BuyerPoNo=="")
	{
		alert("Please select the 'Buyer PONo'.");
		document.getElementById('cboBuyerPoNo').focus();
		return;
	}
	else if(mainStore=="")
	{
		alert("Please select the 'Main Store'.");
		document.getElementById('cboMainStore').focus();
		return;
	}
	
		drawPopupArea(956,413,'frmStyleGatePassItems');
		var HTMLText = "<table width=\"950\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
			  "<tr>"+
				"<td><?php include 'Header.php'; ?></td>"+
			  "</tr>"+
			  "<tr>"+
				"<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
				  "<tr>"+
					"<td height=\"17\" class=\"mainHeading\"><div align=\"center\">Gatepass Items</div></td>"+
					"</tr>"+
				 "<tr>"+
					"<td><div id=\"divGatePassItems\" style=\"overflow:scroll; height:350px; width:950px;\">"+
					  "<table id=\"tblGatePassItems\" width=\"932\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
						"<tr class=\"mainHeading4\">"+
						  "<td width=\"1%\" height=\"25\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"SelectAll(this);\"/></td>"+
						"<td width=\"8%\">Main Materials</td>"+
						"<td width=\"20%\">Item Description</td>"+
						"<td width=\"6%\">Color</td>"+
						"<td width=\"5%\">Size</td>"+
						"<td width=\"4%\">Unit</td>"+
						"<td width=\"3%\">Stock Bal</td>"+
						"<td width=\"2%\"></td>"+
						"<td width=\"5%\">GRN No</td>"+
						"<td width=\"4%\">GRN Year</td>"+
						"<td width=\"4%\">GRN Type</td>"+
						  "</tr>"+
					  "</table>"+
					"</div></td>"+
				  "</tr>"+
				"</table></td>"+
			  "</tr>"+
			  "<tr>"+
				"<td ><table width=\"100%\" border=\"0\">"+
				  "<tr>"+
					"<td><table width=\"100%\" border=\"0\">"+
					  "<tr>"+
					  "</tr>"+
					"</table></td>"+
					"<td>"+
					"<div align=\"center\"><img src=\"../../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" onclick=\"LoadDetalisToMainPage();\"/>"+
					"<img src=\"../../images/close.png\" alt=\"close\" width=\"97\" height=\"24\" onclick=\"closeWindow();\" /></div></td>"+
				  "</tr>"+
				"</table></td>"+
			  "</tr>"+
			"</table>";			
		loca = -1;
		var frame = document.createElement("div");
		frame.id = "itemselectwindow";
		document.getElementById('frmStyleGatePassItems').innerHTML=HTMLText;
		LoadDetails();
		
}
//End- Load Gate Pass Item form using PopUp Window

function LoadDetails()
{	
	var StyleId 	= document.getElementById("cboOrderNo").value;
	var BuyerPONO 	= document.getElementById("cboBuyerPoNo").value;	
	var mainStoreId = document.getElementById("cboMainStore").value;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadDetailsRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=LoadDetails&StyleId=' + URLEncode(StyleId) + '&BuyerPONO=' + URLEncode(BuyerPONO) + '&mainStoreId=' +mainStoreId ,true);
	xmlHttp.send(null);	
}
	function LoadDetailsRequest()
	{
		if(xmlHttp.readyState == 4)
		{
			if(xmlHttp.status == 200)
			{				
				var XMLDescription = xmlHttp.responseXML.getElementsByTagName("Description");
				var XMLItemDescription = xmlHttp.responseXML.getElementsByTagName("ItemDescription");
				var XMLMatDetailId = xmlHttp.responseXML.getElementsByTagName("MatDetailId");
				var XMLColor = xmlHttp.responseXML.getElementsByTagName("Color");
				var XMLSize = xmlHttp.responseXML.getElementsByTagName("Size");
				var XMLUnit = xmlHttp.responseXML.getElementsByTagName("Unit");
				var XMLActualQty = xmlHttp.responseXML.getElementsByTagName("actualQty");
				var XMLGRNno = xmlHttp.responseXML.getElementsByTagName("GRNno");
				var XMLGRNYear = xmlHttp.responseXML.getElementsByTagName("GRNYear");
				var XMLGRNTypeId = xmlHttp.responseXML.getElementsByTagName("GRNTypeId");
				var XMLGRNType = xmlHttp.responseXML.getElementsByTagName("GRNType");
				
				var strText ="<table id=\"tblGatePassItems\" width=\"932\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
						 "<tr class=\"mainHeading4\">"+
						  "<td width=\"1%\" height=\"25\"><input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"SelectAll(this);\"/></td>"+
						  "<td width=\"8%\">Main Materials</td>"+
						  "<td width=\"20%\">Item Description</td>"+
						  "<td width=\"6%\">Color</td>"+
						  "<td width=\"5%\">Size</td>"+
						  "<td width=\"4%\">Unit</td>"+
						  "<td width=\"3%\">Stock Bal</td>"+
						  "<td width=\"2%\"></td>"+
						  "<td width=\"5%\">GRN No</td>"+
						  "<td width=\"4%\">GRN Year</td>"+
						  "<td width=\"4%\">GRN Type</td>"+
						 "</tr>";
				for (var loop =0; loop < XMLActualQty.length; loop ++)
				{	
					var classtext = "";
					if (loop % 2 == 0)
						classtext = "class=\"bcgcolor-tblrowWhite\"";
					else
					 	classtext = "class=\"bcgcolor-tblrowWhite\"";
					strText += "<tr "+classtext+"  onmouseover=\"this.style.background ='#D6E7F5';\" onmouseout=\"this.style.background='';\">"+
						  "<td class=\"normalfntRite\"><div align=\"center\">"+
							  "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" />"+
						  "</div></td>"+
						  "<td class=\"normalfnt\">"+XMLDescription[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfnt\" id=\""+XMLMatDetailId[loop].childNodes[0].nodeValue+"\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfntMid\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfntMid\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>"+

						  "<td class=\"normalfntMid\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfntRite\">"+XMLActualQty[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfntMid\"><div align=\"center\"><img src=\"../../images/house.png\" onClick=\"setStockTransaction(this)\" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
						   "<td class=\"normalfntRite\">"+XMLGRNno[loop].childNodes[0].nodeValue+"</td>"+
						    "<td class=\"normalfntRite\">"+XMLGRNYear[loop].childNodes[0].nodeValue+"</td>"+
							"<td class=\"normalfntRite\" id=\""+XMLGRNTypeId[loop].childNodes[0].nodeValue+"\">"+XMLGRNType[loop].childNodes[0].nodeValue+"</td>"+
						 "</tr>";
				}
				strText += "</table>";
				document.getElementById("divGatePassItems").innerHTML=strText;
						  
			}
		}
	}
	
function LoadDetalisToMainPage()
{
	var tbl =document.getElementById("tblGatePassItems");
	
	for (loop=1;loop<tbl.rows.length;loop++)
	{
		var chkBox =tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked;
		if (chkBox==true)
		{	
			var StyleId 		= document.getElementById("cboOrderNo").value;
			var StyleName 		= document.getElementById("cboOrderNo").options[document.getElementById("cboOrderNo").selectedIndex].text;
			var BuyerPoNo 		= document.getElementById("cboBuyerPoNo").value;
			var BuyerPoName 	= document.getElementById("cboBuyerPoNo").options[document.getElementById("cboBuyerPoNo").selectedIndex].text;	
			var mainCategory 	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var matDetails 		= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var matDetailId 	= tbl.rows[loop].cells[2].id;
			var color 			= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var size 			= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var units 			= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			var qty 			= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var grnNo 			= tbl.rows[loop].cells[8].childNodes[0].nodeValue;
			var grnYear 		= tbl.rows[loop].cells[9].childNodes[0].nodeValue;
			var grnTypeId 		= tbl.rows[loop].cells[10].id;
			var grnType 		= tbl.rows[loop].cells[10].childNodes[0].nodeValue;
			
			var tblMain =document.getElementById("tblGatePassMain");
			var booCheck =false;
				for(var mainLoop=1;mainLoop<tblMain.rows.length;mainLoop++)
				{
					var mainStyle 		= tblMain.rows[mainLoop].cells[3].id;
					var mainBuyerPoNo 	= tblMain.rows[mainLoop].cells[4].id;
					var mainColor 		= tblMain.rows[mainLoop].cells[5].lastChild.nodeValue;
					var mainSize 		= tblMain.rows[mainLoop].cells[6].lastChild.nodeValue;
					var mainMatId 		= tblMain.rows[mainLoop].cells[2].id;
					var mainGRNno 		= tblMain.rows[mainLoop].cells[12].lastChild.nodeValue;
					var mainGRNYear 	= tblMain.rows[mainLoop].cells[13].lastChild.nodeValue;
					var mainGRNTypeId 	= tblMain.rows[mainLoop].cells[14].id;
					var mainGRNType 	= tblMain.rows[mainLoop].cells[14].lastChild.nodeValue;
					
					if ((mainStyle==StyleId) && (mainBuyerPoNo==BuyerPoNo) && (mainMatId==matDetailId) && (mainColor==color) && (mainSize==size) && (grnNo == mainGRNno) && (grnYear == mainGRNYear) && (grnTypeId == mainGRNTypeId))	
					{
						booCheck =true;
						alert ("Style : "+StyleId +"\nBuyerPoNo : "+ BuyerPoNo +"\nItem : "+ matDetails +"\nColor : "+color+"\nSize : "+size+ "\nGRN No :"+ grnNo+"/"+grnYear +"\n GRN Type :"+mainGRNType+"\nalready added");
					}				
				}				
			if (booCheck == false)
			{
				var lastRow 			= tblMain.rows.length;	
				var row 				= tblMain.insertRow(lastRow);
				row.className 			= "bcgcolor-tblrowWhite";
				
				var cellDelete 			= row.insertCell(0);
				cellDelete.id			= 0;
				cellDelete.innerHTML 	= "<div align=\"center\"><img src=\"../../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
				
				var cellIssuelist 		= row.insertCell(1);
				cellIssuelist.className = "normalfnt";	
				cellIssuelist.id		= mainArrayIndex;
				cellIssuelist.innerHTML = mainCategory;
				
				var cellIssuelist 		= row.insertCell(2);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id		= matDetailId;
				cellIssuelist.innerHTML = matDetails;
				
				var cellIssuelist 		= row.insertCell(3);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id 		= StyleId;
				cellIssuelist.innerHTML = StyleName;
				
				var cellIssuelist 		= row.insertCell(4);
				cellIssuelist.className = "normalfnt";		
				cellIssuelist.id 		= BuyerPoNo;
				cellIssuelist.innerHTML = BuyerPoName;
				
				var cellIssuelist 		= row.insertCell(5);
				cellIssuelist.className = "normalfnt";		
				cellIssuelist.innerHTML = color;
				
				var cellIssuelist 		= row.insertCell(6);
				cellIssuelist.className = "normalfnt";		
				cellIssuelist.innerHTML = size;
				
				var cellIssuelist 		= row.insertCell(7);
				cellIssuelist.className = "normalfnt";		
				cellIssuelist.innerHTML = units;
				
				var cellIssuelist 		= row.insertCell(8);
				cellIssuelist.className = "normalfntRite";		
				cellIssuelist.innerHTML = qty;
				
				var cellIssuelist 		= row.insertCell(9);			
				cellIssuelist.innerHTML = "<input type=\"text\" size=\"8\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+qty+"\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onfocus=\"GetQty(this);\" onkeydown=\"removeBinColor(this);\" onkeyup=\"ValidateQty(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\"/>";
				
				var cellIssuelist 		= row.insertCell(10);
				cellIssuelist.className = "normalfntMid";	
				cellIssuelist.innerHTML = "<input type=\"checkbox\"  id=\"chkRtn\" name=\"chkRtn\" size=\"1\" onclick=\"SetRtn(this," + mainArrayIndex  + ");\">";
				var cellIssuelist 		= row.insertCell(11);
				cellIssuelist.className = "normalfntMid";
				cellIssuelist.innerHTML = "<img src=\"../../images/plus_16.png\" alt=\"add\" onclick=\"LoadBinDetails(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\" onfocus=\"GetQty(this);\"/>";

				var cellGRNNo 			= row.insertCell(12);
				cellGRNNo.className 	= "normalfntRite";		
				cellGRNNo.innerHTML 	= grnNo;
				
				var cellGRNYear 		= row.insertCell(13);
				cellGRNYear.className 	= "normalfntRite";		
				cellGRNYear.innerHTML 	= grnYear;
				
//BEGIN - Adding grn type S = Style , B = Bulk
				var cellGRNYear 		= row.insertCell(14);
				cellGRNYear.className 	= "normalfntRite";		
				cellGRNYear.id 			= grnTypeId;
				cellGRNYear.innerHTML 	= grnType;
//END - Adding grn type S = Style , B = Bulk	
				
//BEGIN - Adding details to the main array.
				var details = [];
				details[0]  = matDetailId; 		// Mat ID
				details[1]  = color; 			// Color
				details[2]  = size ;			// Size
				details[3]  = BuyerPoNo; 		// Buyer PO
				details[4]  = parseFloat(qty); 	// Default Qty
				details[6]  = units; 			// units
				details[7]  = StyleId; 			// StyleID			
				details[8]  = 0;       			// RTN
				details[10] = grnNo; 			// GRN No
				details[11] = grnYear;  		// GRN Year
				details[12] = grnTypeId;  		// GRN Type S = Style , B = Bulk
				Materials[mainArrayIndex] = details;
				mainArrayIndex ++ ;
//END - Adding details to the main array.
			}
		}		
	}
closeWindow();	
}

function SetRtn(obj,index)
{
		var rw = obj.parentNode.parentNode;
		var StockQty =rw.cells[8].childNodes[0].nodeValue;	
		Materials[index][8] = 	(rw.cells[10].childNodes[0].checked==true ? "1":"0");
		
		if(rw.cells[10].childNodes[0].checked==true){
			rw.cells[9].childNodes[0].value=StockQty;
		}
}

function SetItemQuantity(obj,index)
{
		var rw = obj.parentNode.parentNode;
		Materials[index][4] = parseInt(rw.cells[9].childNodes[0].value);		
}

function LoadBinDetails(rowNo,index)
{	
	var mainStore = document.getElementById("cboMainStore").value;
	if(mainStore == '')
	{
		alert('Please select \'Main Store \'');
		document.getElementById("cboMainStore").focus();
		return false;
	}
	if(pub_commonBin==1){alert("Common Bin System Activated.\nNo need to add bins.\nAll the bin details will save to Common Bin automatically.");return;}
	var rw=rowNo.parentNode.parentNode;
	mainRw = rowNo.parentNode.parentNode.rowIndex;
	ReqGatePassQty = parseFloat(rw.cells[9].childNodes[0].value);
	var stockQty =parseFloat(rw.cells[8].childNodes[0].nodeValue);
	
	if (ReqGatePassQty=="" || ReqGatePassQty==0 || ReqGatePassQty==isNaN)
	{
		alert ("GatePass Qty can't be '0' or empty.");
		rw.cells[9].childNodes[0].value=stockQty
		 return false;
	}	
	else if (ReqGatePassQty > stockQty)
	{
		alert ("Can't issue more than stock balance.");
		rw.cells[9].childNodes[0].value =stockQty;
		return false;
	}
	
	
	var styleId 	= rw.cells[3].id;
	var buyerPoNo 	= rw.cells[4].id;
	var color 		= rw.cells[5].childNodes[0].nodeValue;
	var size 		= rw.cells[6].childNodes[0].nodeValue;
	var matDetailId = rw.cells[2].id;
	var grnNo 		= rw.cells[12].childNodes[0].nodeValue;
	var grnYear 	= rw.cells[13].childNodes[0].nodeValue;
	var grnType 	= rw.cells[14].id;

	createXMLHttpRequest();
	xmlHttp.index = index;
	xmlHttp.onreadystatechange=LoadBinDetailsRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=LoadBinDetails&styleId=' +URLEncode(styleId)+ '&buyerPoNo=' +URLEncode(buyerPoNo)+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size) + '&mainStore='+mainStore+ '&GrnNo='+grnNo+ '&GrnYear='+grnYear+ '&GrnType=' +grnType , true);
	xmlHttp.send(null);
}

function LoadBinDetailsRequest()
{
	if (xmlHttp.readyState==4)
	{
		if (xmlHttp.status==200)
		{	
			var index = xmlHttp.index;
			
			var XMLMainStoresID		= xmlHttp.responseXML.getElementsByTagName("MainStoresID");
			var XMLSubStores		= xmlHttp.responseXML.getElementsByTagName("SubStores");
			var XMLLocation			= xmlHttp.responseXML.getElementsByTagName("Location");
			var XMLBin				= xmlHttp.responseXML.getElementsByTagName("Bin");
			var XMLstockBal			= xmlHttp.responseXML.getElementsByTagName("stockBal");
			
			var XMLBinName			= xmlHttp.responseXML.getElementsByTagName("BinName");
			var XMLMainStoreName	= xmlHttp.responseXML.getElementsByTagName("MainStoreName");
			var XMLSubStoresName	= xmlHttp.responseXML.getElementsByTagName("SubStoresName");
			var XMLLocationName		= xmlHttp.responseXML.getElementsByTagName("LocationName");
			var XMLMatSubCateoryId	= xmlHttp.responseXML.getElementsByTagName("MatSubCateoryId");
			
			drawPopupArea(612,410,'divGatePassBinItem');
			var strText ="<table width=\"75%\" border=\"0\" bgcolor=\"#FFFFFF\">"+
            "<tr>"+
              "<td height=\"16\" class=\"mainHeading\">Bin Items</td>"+
            "</tr>"+
            "<tr>"+
             "<td height=\"17\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >"+
                  "<tr>"+
                    "<td width=\"4%\" height=\"25\">&nbsp;</td>"+
                    "<td width=\"23%\" class=\"normalfnt\">GatePass Qty</td>"+
                    "<td width=\"55%\"><input name=\"txReqGatePassQty\" type=\"text\" class=\"txtbox\" id=\"txReqGatePassQty\" size=\"31\" value=\""+ReqGatePassQty+"\" readonly=\"\" style=\"text-align:right\" /></td>"+
                    "<td width=\"18%\">&nbsp;</td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"74\"><table width=\"100%\" height=\"141\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                  "<tr class=\"bcgl1\">"+
                    "<td width=\"100%\" height=\"141\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                        "<tr>"+
                          "<td colspan=\"3\">"+
					"<div id=\"divGatePassBinItem\" style=\"overflow:scroll; height:217px; width:604px;\" class=\"tableBorder\">"+
					"<table id=\"tblGatePassBinItem\" width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
						"<tr class=\"mainHeading4\">"+
						  "<td width=\"25%\" height=\"25\" >Main Stores</td>"+
						  "<td width=\"20%\" >Sub Stores</td>"+
						  "<td width=\"20%\" >Location</td>"+
						  "<td width=\"15%\" >Bin ID</td>"+
						  "<td width=\"10%\" >AVI Qty</td>"+
						  "<td width=\"8%\" >Req Qty</td>"+
						  "<td width=\"2%\" >Add</td>"+
                        "</tr>";
			
			for (loop=0;loop<XMLMainStoresID.length;loop++)
			{				
			strText  +="<tr class=\"bcgcolor-tblrowWhite\">"+
						  "<td class=\"normalfnt\" id=\""+XMLMainStoresID[loop].childNodes[0].nodeValue+"\">"+XMLMainStoreName[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfnt\" id=\""+XMLSubStores[loop].childNodes[0].nodeValue+"\">"+XMLSubStoresName[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfnt\" id=\""+XMLLocation[loop].childNodes[0].nodeValue+"\">"+XMLLocationName[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfnt\" id=\""+XMLBin[loop].childNodes[0].nodeValue+"\">"+XMLBinName[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfntRite\" id=\""+XMLMatSubCateoryId[loop].childNodes[0].nodeValue+"\">"+XMLstockBal[loop].childNodes[0].nodeValue+"</td>"+
						  "<td class=\"normalfntRite\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" value=\"0\" /></td>"+
						  "<td class=\"normalfnt\"><div align=\"center\">"+
						  "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"GetStockQty(this);\" />"+
						  "</div></td>"+
						 "</tr>";
			}
			strText +="</table>"+
						"</div></td>"+
                        "</tr>"+
                    "</table></td>"+
                  "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
              "<td height=\"32\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">"+
                "<tr >"+
                  "<td width=\"28%\">&nbsp;</td>"+
                  "<td width=\"18%\"><img src=\"../../images/ok.png\" alt=\"ok\" width=\"86\" height=\"24\" onclick=\"SetBinItemQuantity(this," + index  + ");\"/></td>"+
                  "<td width=\"6%\">&nbsp;</td>"+
                  "<td width=\"20%\"><img src=\"../../images/close.png\" width=\"97\" height=\"24\" onclick=\"closeWindow();\" /></td>"+
                  "<td width=\"28%\">&nbsp;</td>"+
                "</tr>"+
				//Start - view already allocated data
				"<tr >"+
					"<td colspan=\"5\"><div id=\"divGatePassBinItem\" style=\"overflow:scroll; height:105px; width:600px;\" class=\"tableBorder\">"+
					"<table id=\"tblGatePassBinItem\" width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
						"<tr class=\"mainHeading4\">"+
						  "<td width=\"25%\" height=\"25\">Main Stores</td>"+
						  "<td width=\"20%\" >Sub Stores</td>"+
						  "<td width=\"20%\" >Location</td>"+
						  "<td width=\"15%\" >Bin ID</td>"+
						  "<td width=\"10%\" >Allocated Qty</td>"+
                        "</tr>";
			
			var details = Materials[index] ;
			var binArray	= details[5];
			
			try{
				for (loop=0;loop<binArray.length;loop++)
				{			
				var Bindetails 			= binArray[loop];
				
				var url ="leftovergatepassXML.php?RequestType=GetAllocatedBinQty";
				url +="&msId="+ Bindetails[0];
				url +="&ssId="+ Bindetails[1];
				url +="&locId="+ Bindetails[2];
				url +="&binId="+ Bindetails[3];				
				htmlobj=$.ajax({url:url,async:false});
				var XMLMainStore= htmlobj.responseXML.getElementsByTagName('MainStore');
				var XMLSubStore	= htmlobj.responseXML.getElementsByTagName('SubStore');
				var XMLLocation	= htmlobj.responseXML.getElementsByTagName('Location');
				var XMLBin		= htmlobj.responseXML.getElementsByTagName('Bin');

				strText  +="<tr class=\"bcgcolor-tblrowWhite\">"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[0]+"\">"+XMLMainStore[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[1]+"\">"+XMLSubStore[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[2]+"\">"+XMLLocation[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfnt\" id=\""+Bindetails[3]+"\">"+XMLBin[0].childNodes[0].nodeValue+"</td>"+
							  "<td class=\"normalfntRite\" id=\""+Bindetails[4]+"\">"+Bindetails[4]+"</td>"+
							 "</tr>";
				}
			}
			catch(err){
			}
			strText +="</table>"+
						"</div></td>"+
				"</tr>"+
				// End - view already allocated data
              "</table></td>"+
            "</tr>"+
          "</table>";	
		document.getElementById("divGatePassBinItem").innerHTML=strText;		
		}
	}
}

function GetQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var stockBal =rw.cells[8].childNodes[0].nodeValue;	
	var GatePassQty = rw.cells[9].childNodes[0].value;
			
	if ((GatePassQty=="") ||(GatePassQty==0))
	{
		rw.cells[9].childNodes[0].value =stockBal;
	}
}
//Start - bin qty validate part
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblGatePassBinItem');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[6].childNodes[0].childNodes[0].checked)
	{	
	    totReqQty = parseFloat(document.getElementById('txReqGatePassQty').value);	
		var reqQty = parseFloat(rw.cells[4].lastChild.nodeValue);
		var issueQty = rw.cells[5].childNodes[0].value;
		
		rw.cells[5].childNodes[0].value = 0;
		var GPLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (tbl.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
					{		
						GPLoopQty +=  parseFloat(tbl.rows[loop].cells[5].childNodes[0].value);
					}
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(GPLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[5].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[5].childNodes[0].value = reduceQty;
					}					
	}	
	else 
		rw.cells[5].childNodes[0].value = 0;
}
//End - bin qty validate part

function SetBinItemQuantity(obj,index)
{	
	var tblMain =document.getElementById("tblGatePassMain");				
	var tblBin = document.getElementById('tblGatePassBinItem');
	var totReqQty = parseFloat(document.getElementById('txReqGatePassQty').value);	
	var GPLoopQty = 0;	
	
		for (loop =1; loop < tblBin.rows.length; loop++)
		{
			if (tblBin.rows[loop].cells[6].childNodes[0].childNodes[0].checked)
			{		
					GPLoopQty +=  parseFloat(tblBin.rows[loop].cells[5].childNodes[0].value);
			}	
		}
	
	if (GPLoopQty == totReqQty )
	{	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tblBin.rows.length ; loop ++ )
			{
				var check =tblBin.rows[loop].cells[6].childNodes[0].childNodes[0];				
				if (check.checked)
				{					
						var Bindetails = [];
							Bindetails[0] =   tblBin.rows[loop].cells[0].id; // MainStores
							Bindetails[1] =   tblBin.rows[loop].cells[1].id; // SubStores
							Bindetails[2] =   tblBin.rows[loop].cells[2].id; // Location
							Bindetails[3] =   tblBin.rows[loop].cells[3].id; // Bin ID
							Bindetails[4] =   tblBin.rows[loop].cells[5].childNodes[0].value; // IssueQty								
							Bindetails[5] =   tblBin.rows[loop].cells[4].id; //  MatSubCategoryId
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;
						
				}
			}
		Materials[index][5] = BinMaterials;				
		tblMain.rows[mainRw].className = "osc2";
		tblMain.rows[mainRw].cells[0].id =1;
		closeWindow();		
	}
	else 
	{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + GPLoopQty +"\nVariance is =" +(totReqQty-GPLoopQty));
		return false;
	}
	
}
function removeBinColor(rowNo)
{	
	var tblMain =document.getElementById("tblGatePassMain");
	Rw = rowNo.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";
	tblMain.rows[Rw].cells[0].id =0;
}

function SaveValidation(obj)
{		
	state = obj;
	var tblMain =document.getElementById("tblGatePassMain");	 
	var Destination = document.getElementById("cboDestination").value;
	var styleNo =document.getElementById("cboOrderNo").value;
	
	
	if(Destination==""){
		alert ("Please select the 'Destination'.");
		document.getElementById("cboDestination").focus();
		return;
	}
	
	
	
	if (tblMain.rows.length<2){alert ("No details to save.");return false;}
	
		for (loop = 1 ;loop < tblMain.rows.length; loop++){
			var issueQty = parseFloat(tblMain.rows[loop].cells[9].childNodes[0].value);
			var stockQty = parseFloat(tblMain.rows[loop].cells[8].childNodes[0].nodeValue);
		
			var checkBinAllocate = tblMain.rows[loop].cells[0].id
			
				if(stockQty<issueQty){
					alert("Issue qty can't exceed stock qty.")
					return false;
				}
				if ((issueQty=="")  || (issueQty==0)){
					alert ("Issue qty can't be '0' or empty.")
					return false;				
				}
				if(pub_commonBin == 0){
					if (checkBinAllocate==0){
						alert ("Cannot save without allocating bin \nPlease allocate the bin in line no : " + [loop] +"." )
						return false;				
					}			
				}
		}
	showBackGroundBalck();	
	LoadGatePassNo();	
}

function LoadGatePassNo()
{
	var GPNO = document.getElementById("cboGatePassNo").value
	if (GPNO=="")
	{		
		var url = 'leftovergatepassXML.php?RequestType=LoadGatePassNo';
		var htmlobj=$.ajax({url:url,async:false});
		var XMLGatePassNo =htmlobj.responseXML.getElementsByTagName("GatePassNo")[0].childNodes[0].nodeValue;
		var XMLGatePassYear =htmlobj.responseXML.getElementsByTagName("GatePassYear")[0].childNodes[0].nodeValue;
		gatePassNo =parseInt(XMLGatePassNo);
		gatePassYear = parseInt(XMLGatePassYear);
		document.getElementById("cboGatePassNo").value=gatePassYear + "/" + gatePassNo;			
		SaveGatePassDetails();
	}
	else
	{		
		GPNO = GPNO.split("/");		
		gatePassNo =parseInt(GPNO[1]);
		gatePassYear = parseInt(GPNO[0]);
		SaveGatePassDetails();
	}
}

function SaveGatePassDetails()
{
	validateCount 		= 0;
	validateBinCount	= 0;
	var Destination 	= document.getElementById("cboDestination").value;	
	var remarks 		= document.getElementById('txtRemarks').value;		  
	var attention 		= document.getElementById('txtAttention').value;
	var category		= (document.getElementById('optInternal').checked==true ? "I":"E");
	var mainStoreId 	= document.getElementById('cboMainStore').value;
	var noOfPackages	= (document.getElementById('txtNoOfPackages').value == "" ? 0:document.getElementById('txtNoOfPackages').value);
	
	var url = 'leftovergatepassXML.php?RequestType=SaveHeaderDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&Destination=' +Destination+ '&remarks=' +URLEncode(remarks) + '&state=' + state + '&attention=' +URLEncode(attention)+ '&category=' +category+ '&noOfPackages=' +noOfPackages;
	var htmlobj=$.ajax({url:url,async:false});

	//start 2010-12-28 delete stock temp data before save
	var url1 = 'leftovergatepassXML.php?RequestType=deleteStockTemp&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear;
	var htmlobj=$.ajax({url:url1,async:false});
	
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{
		var details = Materials[loop] ;
		if 	(details!=null)		
		{
				var matDetailId 		= details[0]; // Mat ID
				var color 				= details[1]; // Color
				var size 				= details[2];// Size
				var buyerPoNo 			= details[3]; // Buyer PO\					
				var Qty 				= details[4]; // Default Qty
				var binArray 			= details[5] ;
				var units 				= details[6]; //units
				var StyleId 			= details[7]; //StyleID
				var rtn					= details[8];  //RTN
				var FabricRollArray		= details[9];

				var grnNo 				= details[10];
				var grnYear 			= details[11];
				var grnType 			= details[12];
				validateCount++;

				var urlDet = 'leftovergatepassXML.php?RequestType=SaveDetails&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&StyleId=' +URLEncode(StyleId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&Qty=' +Qty+ '&units=' +units+ '&validateCount=' +validateCount+ '&rtn=' +rtn +'&grnNo='+grnNo+ '&grnYear='+grnYear+'&state=' +state+'&pub_commonBin='+pub_commonBin+ '&GrnType='+grnType;
				var htmlobj=$.ajax({url:urlDet,async:false});

			try{
				
				if(pub_commonBin == 0)	
				{
					
					for (i = 0; i < binArray.length; i++)
					{
						var Bindetails 			= binArray[i];
						var mainStores 			= Bindetails[0]; // MainStores
						var subStores 			= Bindetails[1]; // SubStores
						var location 			= Bindetails[2];// Location
						var binId				= Bindetails[3]; // Bin ID
						var issueBinQty 		= Bindetails[4]; // IssueQty
						var matSubCategoryId 	= Bindetails[5]; // MatSubCategoryId
						validateBinCount++;
						
						var url = 'leftovergatepassXML.php?RequestType=SaveBinDetails&mainStores=' +mainStores+ '&subStores=' +subStores+ '&location=' +location+ '&binId=' +binId+ '&StyleId=' +URLEncode(StyleId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&issueBinQty=' +issueBinQty+ '&validateBinCount=' +validateBinCount+ '&state=' +state+ '&matSubCategoryId=' +matSubCategoryId+'&grnNo='+grnNo+'&grnYear='+grnYear+'&pub_commonBin='+pub_commonBin+'&mainStoreId='+mainStoreId+ '&GrnType='+grnType;
						
						var htmlobj=$.ajax({url:url,async:false});
					}
				}
				else 
				{
					validateBinCount++;
					var url = 'leftovergatepassXML.php?RequestType=SaveBinDetails&mainStores=' +mainStores+ '&subStores=' +subStores+ '&location=' +location+ '&binId=' +binId+ '&StyleId=' +URLEncode(StyleId)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&matDetailId=' +matDetailId+ '&color=' +URLEncode(color)+ '&size=' +URLEncode(size)+ '&units=' +units+ '&issueBinQty=' +Qty+ '&validateBinCount=' +validateBinCount+ '&state=' +state+ '&matSubCategoryId=' +matSubCategoryId+'&grnNo='+grnNo+'&grnYear='+grnYear+'&pub_commonBin='+pub_commonBin+'&mainStoreId='+mainStoreId+ '&GrnType='+grnType;					
					var htmlobj=$.ajax({url:url,async:false});				
				}
			}
			catch(err){
			}
	
		}
	}
	
	
	var url2 = 'leftovergatepassXML.php?RequestType=ResponseValidateGP&gatePassNo=' +gatePassNo+ '&gatePassYear=' +gatePassYear+ '&validateCount=' +validateCount+ '&validateBinCount=' +validateBinCount+ '&state=' +state;
	var htmlobj=$.ajax({url:url2,async:false});
	
	var gatePassHeader= htmlobj.responseXML.getElementsByTagName("recCountGatePassHeader")[0].childNodes[0].nodeValue;
	var gatePassDetails=htmlobj.responseXML.getElementsByTagName("recCountGatePassDetails")[0].childNodes[0].nodeValue;
	var binDetails= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;	
	
	if((gatePassHeader=="TRUE") && (gatePassDetails=="TRUE") && (binDetails=="TRUE"))
		{
			if(state==0){
			alert ("Gate Pass No : " + document.getElementById("cboGatePassNo").value +  " saved successfully.");
			RestrictInterface(0);
			hideBackGroundBalck();
			}
			else
			{
				
				RestrictInterface(0);
				
			}
			
		}
		else
		{
			alert("Error in saving.")
				RestrictInterface(0);
				hideBackGroundBalck();
		}
}

function RestrictInterface(Status){
	if (Status==1){
		document.getElementById("cmdSave").style.display    ="none";
		document.getElementById("cmdConfirm").style.display ="none";
		document.getElementById("cmdAutoBin").style.display ="none";
		document.getElementById("cmdAddNew").style.display  ="none";
	}
	else if (Status==10){
		document.getElementById("cmdSave").style.display    ="none";
		document.getElementById("cmdConfirm").style.display ="none";
		document.getElementById("cmdAddNew").style.display  ="none";
	}
	else if (Status==0){		
		document.getElementById("cmdAddNew").style.display  ="inline";
	}
}

function loadGatePassDetails(intGPNO,intGPYear,intStatus)
{
	Materials 		= [];
	mainArrayIndex  = 0;
	gatePassNo 		= intGPNO;
	gatePassYear 	= intGPYear;
	gatePassStatus  = intStatus;
	if (intGPNO=="")return false;

	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadHeaderDetailsRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=LoadHeaderDetails&intGPNO=' +intGPNO+ '&intGPYear=' +intGPYear ,true);
	xmlHttp.send(null);
	
	createXMLHttpRequest1();
	xmlHttp1.onreadystatechange=LoadGatePassDetailsRequest;
	xmlHttp1.open("GET",'leftovergatepassXML.php?RequestType=LoadGatePassDetails&intGPNO=' +intGPNO+ '&intGPYear=' +intGPYear +'&gatePassStatus='+gatePassStatus,true);
	xmlHttp1.send(null);
}

	function LoadHeaderDetailsRequest()
	{
		if (xmlHttp.readyState==4)
		{
			if (xmlHttp.status==200)
			{
				var XMLGPNO =xmlHttp.responseXML.getElementsByTagName("GPNO")[0].childNodes[0].nodeValue;
				var XMLGPDate =xmlHttp.responseXML.getElementsByTagName("formatedGPDate")[0].childNodes[0].nodeValue;				
				var XMLDestinationID =xmlHttp.responseXML.getElementsByTagName("DestinationID")[0].childNodes[0].nodeValue;			
				var XMLRemarks =xmlHttp.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
				var XMLAttention =xmlHttp.responseXML.getElementsByTagName("Attention")[0].childNodes[0].nodeValue;
				var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
				var XMLcategory = xmlHttp.responseXML.getElementsByTagName("category")[0].childNodes[0].nodeValue;
				var XMLpackages = xmlHttp.responseXML.getElementsByTagName("NoOfPackages")[0].childNodes[0].nodeValue;
				
				
				document.getElementById("cboGatePassNo").value =XMLGPNO;
				document.getElementById("gatePassDate").value=XMLGPDate;
				document.getElementById("txtRemarks").value =XMLRemarks;			
				document.getElementById("txtAttention").value =XMLAttention ;
				document.getElementById("txtNoOfPackages").value =XMLpackages ;
				if(XMLcategory=="I"){
					document.getElementById('optInternal').checked = true;
				}else if(XMLcategory=="E"){
					document.getElementById('optExternal').checked = true;
				}
				RestrictInterface(parseInt(XMLStatus));
				LoadStores1(XMLcategory,XMLDestinationID);			
				document.getElementById("cboDestination").value =XMLDestinationID ;
			}
		}
	}
	function LoadStores1(obj,category){
		
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadStores1Request;
	xmlHttp.index = category;
	xmlHttp.open("GET", 'leftovergatepassXML.php?RequestType=LoadStores&category='+ obj , true);
	xmlHttp.send(null);  
	
	}
	function LoadStores1Request(){
		if (xmlHttp.readyState==4 && xmlHttp.status==200){				
		var HTMLText=xmlHttp.responseText;
		var category = xmlHttp.index;
		
			document.getElementById('cboDestination').innerHTML=HTMLText;	
			document.getElementById('cboDestination').value = category ;
			loadCommonBin(1);
		}
	}
	
function LoadGatePassDetailsRequest()
{
	if (xmlHttp1.readyState==4)
	{
		if (xmlHttp1.status==200)
		{
			var tbl 				= document.getElementById("tblGatePassMain");
			var XMLStyleid 			= xmlHttp1.responseXML.getElementsByTagName("Styleid");
			var XMLStyleName 		= xmlHttp1.responseXML.getElementsByTagName("StyleName");
			var XMLMainCategory 	= xmlHttp1.responseXML.getElementsByTagName("MainCategory");
			var XMLMatDetailId 		= xmlHttp1.responseXML.getElementsByTagName("MatDetailId");
			var XMLItemDescription 	= xmlHttp1.responseXML.getElementsByTagName("ItemDescription");
			var XMLBuyerPONO 		= xmlHttp1.responseXML.getElementsByTagName("BuyerPONO");
			var XMLBuyerPOName 		= xmlHttp1.responseXML.getElementsByTagName("BuyerPOName");
			var XMLColor 			= xmlHttp1.responseXML.getElementsByTagName("Color");
			var XMLSize 			= xmlHttp1.responseXML.getElementsByTagName("Size");
			var XMLUnit 			= xmlHttp1.responseXML.getElementsByTagName("Unit");
			var XMLStockBal 		= xmlHttp1.responseXML.getElementsByTagName("StockBal");
			var XMLGPQTY 			= xmlHttp1.responseXML.getElementsByTagName("GPQTY");
			var XMLGRNno  			= xmlHttp1.responseXML.getElementsByTagName("GRNno");
			var XMLGRNYear 			= xmlHttp1.responseXML.getElementsByTagName("GRNYear");
			var XMLGRNTypeId 		= xmlHttp1.responseXML.getElementsByTagName("GRNTypeId");
			var XMLGRNType 			= xmlHttp1.responseXML.getElementsByTagName("GRNType");
			
			document.getElementById('cboStyles').value = XMLStyleName[0].childNodes[0].nodeValue;
			document.getElementById('cboOrderNo').value = XMLStyleid[0].childNodes[0].nodeValue;
			var opt = document.createElement("option");
			opt.text = XMLBuyerPONO[0].childNodes[0].nodeValue;
			opt.value = XMLBuyerPONO[0].childNodes[0].nodeValue;
			document.getElementById("cboBuyerPoNo").options.add(opt);
			document.getElementById('cboBuyerPoNo').value = XMLBuyerPONO[0].childNodes[0].nodeValue;
			document.getElementById('cboScNo').value      = XMLStyleid[0].childNodes[0].nodeValue;
			for (loop=0;loop<XMLStyleid.length;loop++)
			{
			var strInnerHtml="";	
				if(gatePassStatus == 1) 
				{
					strInnerHtml +="<td class=\"normalfnt\"><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" /></div></td>";	
				}
				else
				{
				strInnerHtml +="<td class=\"normalfnt\"><div align=\"center\"><img src=\"../../images/del.png\" alt=\"del\" width=\"15\" id=\"" + 1 + "\" height=\"15\" onclick=\"RemoveItem(this);\"/></div></td>";
				}
				strInnerHtml +="<td class=\"normalfnt\" id=\"" + mainArrayIndex + "\">"+XMLMainCategory[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfnt\" id=\""+XMLMatDetailId[loop].childNodes[0].nodeValue+"\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfnt\" id=\""+ XMLStyleid[loop].childNodes[0].nodeValue+"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfnt\" id=\""+XMLBuyerPONO[loop].childNodes[0].nodeValue+"\">"+XMLBuyerPOName[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfnt\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfnt\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfnt\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>";
				strInnerHtml +="<td class=\"normalfntRite\">"+XMLStockBal[loop].childNodes[0].nodeValue+"</td>";
				if(gatePassStatus == 1) 
				{
				strInnerHtml +="<td class=\"normalfntMid\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" value=\""+XMLGPQTY[loop].childNodes[0].nodeValue+"\" style=\"text-align:right\" readonly=\"readonly\" /> </td>";
				}
				else
				{
				strInnerHtml +="<td class=\"normalfntMid\"><input type=\"text\" name=\"txtIssueQty\" id=\"txtIssueQty\" class=\"txtbox\" size=\"8\" value=\""+XMLGPQTY[loop].childNodes[0].nodeValue+"\" style=\"text-align:right\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onfocus=\"GetQty(this);\" onkeydown=\"removeBinColor(this);\" onkeyup=\"ValidateQty(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\" /> </td>";	
				}
				if(gatePassStatus == 1) 
				{
				strInnerHtml +="<td class=\"normalfntMid\"><input type=\"checkbox\" id=\"chkRtn\" name=\"chkRtn\" size=\"1\" disabled=\"disabled\" /></td>";
				}
				else
				{
				strInnerHtml +="<td class=\"normalfntMid\"><input type=\"checkbox\" id=\"chkRtn\" name=\"chkRtn\" size=\"1\" onclick=\"SetRtn(this," + mainArrayIndex  + ");\" /></td>";
				}
				if(gatePassStatus == 1) 
				{
				strInnerHtml +="<td class=\"normalfntMid\"><img src=\"../../images/plus_16.png\" alt=\"add\" /></td>";
				}
				else
				{
				strInnerHtml +="<td class=\"normalfntMid\"><img src=\"../../images/plus_16.png\" alt=\"add\" onclick=\"LoadBinDetails(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\" onfocus=\"GetQty(this);\" /></td>";
				}
			strInnerHtml +="<td class=\"normalfntRite\">"+XMLGRNno[loop].childNodes[0].nodeValue+"</td>";
			strInnerHtml +="<td class=\"normalfntRite\">"+XMLGRNYear[loop].childNodes[0].nodeValue+"</td>";
			strInnerHtml +="<td class=\"normalfntRite\" id=\""+XMLGRNTypeId[loop].childNodes[0].nodeValue+"\">"+XMLGRNType[loop].childNodes[0].nodeValue+"</td>";
			// Saving Data
			var details = [];
			details[0]	= XMLMatDetailId[loop].childNodes[0].nodeValue; // Mat ID
			details[1] 	= XMLColor[loop].childNodes[0].nodeValue; 		// Color
			details[2] 	= XMLSize[loop].childNodes[0].nodeValue ;		// Size
			details[3] 	= XMLBuyerPONO[loop].childNodes[0].nodeValue; 	// Buyer PO
			details[4] 	= XMLGPQTY[loop].childNodes[0].nodeValue; 		// Default Qty
			details[6] 	= XMLUnit[loop].childNodes[0].nodeValue; 		// units
			details[7] 	= XMLStyleid[loop].childNodes[0].nodeValue; 	// StyleID			
			details[8] 	= 0; 											// RTN
			details[10] = XMLGRNno[loop].childNodes[0].nodeValue;
			details[11] = XMLGRNYear[loop].childNodes[0].nodeValue;
			details[12] = XMLGRNTypeId[loop].childNodes[0].nodeValue;
			Materials[mainArrayIndex] = details;			
					  
			var lastRow = tbl.rows.length;	
			var row = tbl.insertRow(lastRow);						
			tbl.rows[lastRow].innerHTML=  strInnerHtml ;
			tbl.rows[lastRow].id = lastRow;

			tbl.rows[lastRow].className="osc2";	//osc2:bcgcolor-tblrowLiteBlue
				var No 	= gatePassYear+"/"+gatePassNo;
				
				var BuyerPoNo =details[3];
				createXMLHttpRequest2(loop);					
				xmlHttp2[loop].onreadystatechange=LoadPendingConfirmBinDetailsRequest;
				xmlHttp2[loop].index = loop;
				xmlHttp2[loop].array = mainArrayIndex;
				xmlHttp2[loop].open("GET",'leftovergatepassXML.php?RequestType=LoadPendingConfirmBinDetails&gatePassNo=' +No+ '&styleId=' +URLEncode(details[7])+ '&buyerPoNo=' +URLEncode(BuyerPoNo)+ '&matDetailID=' +details[0]+ '&color=' +URLEncode(details[1])+ '&size=' +URLEncode(details[2])+'&gatePassStatus='+gatePassStatus+ '&GRNNo='+details[10]+ '&GRNYear='+details[11]+  '&GRNType='+details[12],true);
				xmlHttp2[loop].send(null);
				mainArrayIndex ++ ;					
			
			}		
		}
	}
}
	
function LoadPendingConfirmBinDetailsRequest()
{
	if (xmlHttp2[this.index].readyState==4)
	{
		if (xmlHttp2[this.index].status==200)
		{	
			var XMLBinQty 		= xmlHttp2[this.index].responseXML.getElementsByTagName("Qty");
			var XMLMainStoresID = xmlHttp2[this.index].responseXML.getElementsByTagName("MainStoresID");
			var XMLSubStores 	= xmlHttp2[this.index].responseXML.getElementsByTagName("SubStores");
			var XMLLocation 	= xmlHttp2[this.index].responseXML.getElementsByTagName("Location");
			var XMLBin 			= xmlHttp2[this.index].responseXML.getElementsByTagName("Bin");
			var XMLMatSubCatId 	= xmlHttp2[this.index].responseXML.getElementsByTagName("MatSubCatId");
			
			var tblMain 		= document.getElementById("tblGatePassMain");	
			var mainBinArrayIndex = 0;
			var BinMaterials = [];	
			for (loop=0;loop<XMLMainStoresID.length;loop++)
			{						
					var arrayIndex = xmlHttp2[this.index].array;					
										
					var Bindetails = [];
					Bindetails[0]  =   XMLMainStoresID[loop].childNodes[0].nodeValue; // MainStores
					
					Bindetails[1]  =   XMLSubStores[loop].childNodes[0].nodeValue; // SubStores
					Bindetails[2]  =   XMLLocation[loop].childNodes[0].nodeValue;// Location
					Bindetails[3]  =   XMLBin[loop].childNodes[0].nodeValue; // Bin ID
					Bindetails[4]  =   XMLBinQty[loop].childNodes[0].nodeValue; // IssueQty
					Bindetails[5]  =   XMLMatSubCatId[loop].childNodes[0].nodeValue; // MatSubCategoryId
					BinMaterials[mainBinArrayIndex] = Bindetails;
					mainBinArrayIndex ++ ;
					Materials[arrayIndex][5] = BinMaterials;	
					tblMain.rows[arrayIndex+1].className = "osc2";
					tblMain.rows[arrayIndex+1].cells[0].id =1;
			}
			document.getElementById('cboMainStore').value = XMLMainStoresID[0].childNodes[0].nodeValue;
		}
	}
}
	
//Start - confirming part
function Confirm()
{
	state = 1;
	var mainStore = document.getElementById("cboMainStore").value;
	if(mainStore == "")
	{
		alert ("Please select the 'Main Store'.");
		document.getElementById("cboMainStore").focus();
		return false;
	}
	var GPNO = document.getElementById("cboGatePassNo").value
	
	
	if(SaveValidation(1)==false)
		return;
	
	if(confirmGP() == false)
	{
		return;	
	}
	else
	{
		GatePassComfirm();	
		
	}
		
			
		
}
function GatePassComfirm()
{
	var GPNO = document.getElementById("cboGatePassNo").value
	if (GPNO)
	createXMLHttpRequest1();
	xmlHttp1.onreadystatechange=GatePassComfirmRequest;
	xmlHttp1.open("GET",'leftovergatepassXML.php?RequestType=GatePassComfirm&GPNO=' +GPNO ,true);
	xmlHttp1.send(null);
}
	function GatePassComfirmRequest()
	{
		if (xmlHttp1.readyState==4)
		{
			if (xmlHttp1.status==200)
			{
				
				var intConfirm = xmlHttp1.responseText;	
				
				if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
				{					
					alert ("Gate Pass No : " + document.getElementById("cboGatePassNo").value +  " confirmed successfully.");
				RestrictInterface(1);
				var gatePassNo = document.getElementById("cboGatePassNo").value.trim();
				if(gatePassNo != '')
				{
					var GPNo = gatePassNo.split("/")[1];
					var GPyear = gatePassNo.split("/")[0];	
				}
			
				RemoveAllRows('tblGatePassMain');
				loadGatePassDetails(GPNo,GPyear,1);
				hideBackGroundBalck();
				}
			}
		}
	}
//End - confirming part

//Start - Cancel part
function Cancel()
{	
	showBackGroundBalck();
	var GPNO = document.getElementById("cboGatePassNo").value;		
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=GatePassCancelRequest;
	xmlHttp.open("GET",'leftovergatepassXML.php?RequestType=GatePassCancel&GPNO=' +GPNO ,true);
	xmlHttp.send(null);
}

	function GatePassCancelRequest()
	{
		if (xmlHttp.readyState==4)
		{
		 	if (xmlHttp.status==200)
			{
				var intConfirm = xmlHttp.responseText;	
				
				if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
				{	
					alert ("Gate Pass No : " + document.getElementById("cboGatePassNo").value +  "  canceled successfully.");
					RestrictInterface(10);
					hideBackGroundBalck();
				}
				else
				{
					alert("Sorry!\nError occured while cancel the data. Please cancel it again.");
					hideBackGroundBalck();
				}
					
			}
		}
	}
	
//End - Cancel part
function ViewReport()
{
		var GPNO =document.getElementById("cboGatePassNo").value;
		if(GPNO==""){alert("Sorry!\nNo GatePass No to view.");return}
		GPNO = GPNO.split("/");
		
		gatePassNo =parseInt(GPNO[1]);
		gatePassYear =parseInt(GPNO[0]);
		
	newwindow=window.open('leftovergatepassrpt.php?GatePassNo=' +gatePassNo+ '&GatePassYear=' +gatePassYear ,'name');
	if (window.focus) {newwindow.focus()}
}
function ValidateQty(obj,index)
{
	var rw = obj.parentNode.parentNode;
	var Qty = rw.cells[9].childNodes[0].value;
	var StockQty =rw.cells[8].childNodes[0].nodeValue;	
	rw.cells[10].childNodes[0].checked="true";
	Materials[index][8] = 	(rw.cells[10].childNodes[0].checked==true ? "1":"0");
	if(parseInt(Qty)>parseInt(StockQty))
	{		
		rw.cells[9].childNodes[0].value=StockQty;
	}	
}

function setStockTransaction(obj)
{
	var styleID	= document.getElementById('cboOrderNo').value;
	var buyerPO	= URLEncode(document.getElementById('cboBuyerPoNo').value);	
	var row		= obj.parentNode.parentNode.parentNode;	 
	var matID	= row.cells[2].id;
	var color	= URLEncode(row.cells[3].childNodes[0].nodeValue);
	var size	= URLEncode(row.cells[4].childNodes[0].nodeValue);
	var grnNo	= row.cells[8].childNodes[0].nodeValue;
	var grnYear	= row.cells[9].childNodes[0].nodeValue;	
	var type 	= 'Leftover';
	var store 	= document.getElementById('cboMainStore').value;
	var grnType	= row.cells[10].id;	
	getGRNwiseStocktransactionDetails(type,styleID,buyerPO,store,matID,color,size,grnNo,grnYear,grnType);
}
 
  function handleStock()
 {
	 if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var type =xmlHttp.responseXML.getElementsByTagName("type")
			
			if(type.length>0)
			{
				createStockpopup();
			 for ( var loop = 0; loop < type.length; loop ++)
			 {
				 var typeInf=xmlHttp.responseXML.getElementsByTagName("type")[loop].childNodes[0].nodeValue;
				 var date=xmlHttp.responseXML.getElementsByTagName("date")[loop].childNodes[0].nodeValue;
				 var qty=xmlHttp.responseXML.getElementsByTagName("qty")[loop].childNodes[0].nodeValue;
				
				var tbl = document.getElementById('stockBalance');
				var lastRow = tbl.rows.length;
				var row = tbl.insertRow(lastRow);
			
				
						tbl.rows[loop].className = "";
						if ((loop % 2) == 1)
						{
							tbl.rows[loop].className="osc2";//osc2:bcgcolor-tblrowLiteBlue
						}
					
				
				var cellType=row.insertCell(0);
				cellType.className="normalfntSM";	
				cellType.innerHTML=typeInf;
				
				var cellDate=row.insertCell(1);
				cellDate.className="normalfntSM";
				cellDate.innerHTML=date;
				
				var cellQty=row.insertCell(2);
				cellQty.className="normalfntRite";
				cellQty.innerHTML=qty;
	
				 
			 }
			 var Total=xmlHttp.responseXML.getElementsByTagName("Total")[0].childNodes[0].nodeValue;
			  
			 document.getElementById('txtStock').innerHTML=Total;
			}
			else
			{
			alert("No stock transaction available for this item.(Not a instock item)");	
			}
		
		}
		
	}
	 	 
}

function createStockpopup()
 {
	 //drawPopupArea(370,250,'frmStockTrans');
	 drawPopupAreaLayer(512,260,'frmStockTrans',15);
	 var HTMLText="<table width=\"100%\" border=\"0\">"+
            "<tr>"+
            "<td width=\"100%\" height=\"16\"  class=\"TitleN2white\">"+
			"<table width=\"100%\"border=\"0\" bgcolor=\"#0E4874\">"+
                "<tr>"+
                  "<td width=\"93%\">Stock transaction</td>"+
                  "<td width=\"7%\">"+
		         "<img src=\"../../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" onClick=\"closeLayerByName('itemSub');\" "+
				 "onClick=\"closeLayer();\" />"+
				  "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
            "<tr>"+
          "<td height=\"0\" class=\"normalfnt\"><table width=\"100%\" border=\"0\" class=\"bcgl1\">"+
                "<tr>"+
                  "<td width=\"100%\"><div align=\"center\">"+
                    "<div id=\"divcons\" style=\"overflow:scroll; height:180px; width:500px;\">"+
                      "<table id=\"stockBalance\" width=\"480\" cellpadding=\"0\" cellspacing=\"0\">"+
                        "<tr>"+
                          "<td width=\"290\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Type</td>"+
             "<td width=\"140\"  height=\"15\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
                          "<td width=\"70\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Qty</td>"+
                          "</tr>"+
                        "</table>"+
                    "</div>"+
                  "</div></td>"+
                  "</tr>"+
              "</table></td>"+
              "</tr>"+
            "<tr>"+
              "<td height=\"21\" bgcolor=\"#d6e7f5\"><table width=\"100%\" border=\"0\">"+
                "<tr>"+
                  "<td width=\"31%\" class=\"normalfnBLD1\">Total Stock</td>"+
            "<td width=\"23%\" class=\"normalfntRiteTABb-ANS\"><label id=\"txtStock\"></label></td>"+
     "<td width=\"46%\"><div align=\"right\"><img src=\"../../images/close.png\" alt=\"close\" "+
	 "onClick=\"closeLayerByName('itemSub');\" width=\"97\" height=\"24\" /></div>"+
	 "</td>"+
                "</tr>"+
              "</table></td>"+
            "</tr>"+
          "</table>";
		  
     var frame = document.createElement("div");
     frame.id = "StockTransWindow";
	 document.getElementById('frmStockTrans').innerHTML=HTMLText;
	 document.getElementById('popupLayer').id="itemSub";	 
 }
 
 function OPenFabricRollInspection(obj,index){
	var rw = obj.parentNode.parentNode;	
	Pub_PopUprowIndex	= obj.parentNode.parentNode.rowIndex;
	Pub_popUoRollIndex	= index;
	var styleID =rw.cells[3].lastChild.nodeValue;
	var buyerPoNo =rw.cells[4].lastChild.nodeValue;
	var matdetailId = rw.cells[2].id;	
	var color = rw.cells[5].lastChild.nodeValue;
	var category="GATEPASS";
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'../fabricrollinspectionpopup/fabricrollinspectionpopup.php?StyleID=' +URLEncode(styleID)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&MatdetailID=' +matdetailId+ '&Color=' +URLEncode(color)+ '&category=' +category ,true);
	xmlHttp.send(null);
}

	function LoadStockDetailsRequest(){
		if (xmlHttp.readyState==4){
			if (xmlHttp.status==200){
				drawPopupArea(958,378,'frmMaterialTransfer');				
				var HTMLText=xmlHttp.responseText;
				document.getElementById('frmMaterialTransfer').innerHTML=HTMLText;						
			}
		}
	}
function SelectAll(obj)
{

	var tbl = document.getElementById('tblGatePassItems');
		
	for(loop = 1;loop<tbl.rows.length;loop++)
	{
		if(obj.checked){
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked = true;
		}
		else
			tbl.rows[loop].cells[0].childNodes[0].childNodes[0].checked= false;
			
	}
	
} 

function LoadStores(obj){
	createXMLHttpRequest();
    xmlHttp.onreadystatechange = LoadStoresRequest;
    xmlHttp.open("GET", 'leftovergatepassXML.php?RequestType=LoadStores&category='+ obj , true);
    xmlHttp.send(null);  
	 
}
	function LoadStoresRequest(){
	if (xmlHttp.readyState==4 && xmlHttp.status==200){				
			var HTMLText=xmlHttp.responseText;
			document.getElementById('cboDestination').innerHTML=HTMLText;						
		}
	}
	
function getCommonBinDetails(no)
{
	var strMainStores = document.getElementById('cboMainStore').value;
	
	var url="leftovergatepassXML.php";
					url=url+"?RequestType=getCommonBin";
					url += '&strMainStores='+strMainStores;
	var htmlobj=$.ajax({url:url,async:false});
	
	pub_commonBin = htmlobj.responseXML.getElementsByTagName("CommBinDetails")[0].childNodes[0].nodeValue;
	document.getElementById('commonBinID').title = pub_commonBin;
	
	var tbl = document.getElementById('tblGatePassMain');
	if(tbl.rows.length>1 && no=='0')
	{
		RemoveAllRows('tblGatePassMain');
		 Materials 			= [];
	}
}

function loadCommonBin(no)
{
	if(document.getElementById('optInternal').checked)
	{
		getCommonBinDetails(no);	
	}
}

function confirmGP()
{
	var GPNo = $("#cboGatePassNo").val();
	
	var url="leftovergatepassXML.php";
					url=url+"?RequestType=confirmGatePass";
					url += '&GPNo='+GPNo;
					url += '&validateBinCount='+validateBinCount;
					
	var htmlobj=$.ajax({url:url,async:false});
	
	var binres = htmlobj.responseXML.getElementsByTagName("stockValidation")[0].childNodes[0].nodeValue;
	if(binres == '')
	{
		var binCount = htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
		if(binCount == 'TRUE')
		{
			return true;	
		}
		else
		{
			alert('Error in saving bins');
			hideBackGroundBalck();
			return false;
			
		}
			
	}
	else
	{
		alert(binres);
		hideBackGroundBalck();
		return false;
	}
	
}
function autoBin()
{
	showBackGroundBalck();
	var mainstore = document.getElementById('cboMainStore').value;
	if(mainstore == '')
	{
		alert("Please select the 'Main Store'.");
		document.getElementById('cboMainStore').focus();
		hideBackGroundBalck();
		return;
	}
	var tbl = document.getElementById('tblGatePassMain');
	var rwCount = tbl.rows.length;
	if(rwCount==1)
	{
		alert('Please add item(s) to assign bin');
		hideBackGroundBalck();
		return;
	}
	
	for(var loop=1;loop<rwCount;loop++)
	{
		if(tbl.rows[loop].cells[0].id==0)	
		{
			var styleId = tbl.rows[loop].cells[3].id;
			var buyerPo = URLEncode(tbl.rows[loop].cells[4].id);
			var matId   = tbl.rows[loop].cells[2].id;
			var color = (tbl.rows[loop].cells[5].innerHTML);
			var size =  (tbl.rows[loop].cells[6].innerHTML);
			var grnNo = (tbl.rows[loop].cells[12].innerHTML)
			var grnYear = tbl.rows[loop].cells[13].innerHTML;
			var grnType = tbl.rows[loop].cells[14].id;
			var issueQty = tbl.rows[loop].cells[9].childNodes[0].value;
			var units = tbl.rows[loop].cells[7].innerHTML;
			var index =  tbl.rows[loop].cells[1].id
			
			var url = 'leftovergatepassXML.php?RequestType=getItemStockAvQty&mainstore='+mainstore+'&styleId='+styleId+'&buyerPo='+buyerPo+'&matId='+matId+'&color='+URLEncode(color)+'&size='+URLEncode(size)+'&grnNo='+grnNo+'&grnType='+grnType+'&issueQty='+issueQty+'&grnYear='+grnYear;
			
			var htmlobj=$.ajax({url:url,async:false});
			var resResult = htmlobj.responseXML.getElementsByTagName("Resresult")[0].childNodes[0].nodeValue;
		
			if(resResult == 'true')
			{
				var BinMaterials = [];
				var mainBinArrayIndex = 0;
				var Bindetails = [];
				Bindetails[0] =   mainstore; // MainStores
				Bindetails[1] =  htmlobj.responseXML.getElementsByTagName("SubStore")[0].childNodes[0].nodeValue; // SubStores
				Bindetails[2] =   htmlobj.responseXML.getElementsByTagName("Location")[0].childNodes[0].nodeValue; // Location
				Bindetails[3] =   htmlobj.responseXML.getElementsByTagName("Bin")[0].childNodes[0].nodeValue; // Bin ID
				Bindetails[4] =   issueQty; // IssueQty								
				Bindetails[5] =   htmlobj.responseXML.getElementsByTagName("subCategory")[0].childNodes[0].nodeValue; //  MatSubCategoryId
			
				BinMaterials[mainBinArrayIndex] = Bindetails;
				Materials[index][5] = BinMaterials;
				tbl.rows[loop].className = "osc2";
				tbl.rows[loop].cells[0].id=1;	
			}
			else
			{
				alert("Item :"+tbl.rows[loop].cells[2].innerHTML+" Color :"+color+" Size :"+size+" do not have stock");
			}
		}
	}
	hideBackGroundBalck();
}

//---------------------------------------------------------------------------------------------------------

function SeachStyle(obj)
{	

	document.getElementById("cboOrderNo").value =obj.value;
	LoadBuyerPoNo(obj);
}

//------------------------- 08/07/2011 ----------------------------------------------------------------------
function getStylewiseOrderNo(styleID)
{
	var url = 'leftovergatepassXML.php?RequestType=loadOrderNo&styleID='+URLEncode(styleID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboOrderNo').innerHTML = XMLItem;
	LoadSCNo(styleID);
}
function LoadSCNo(styleID)
{
	var url = 'leftovergatepassXML.php?RequestType=loadSCNo&styleID='+URLEncode(styleID);
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboScNo').innerHTML = XMLItem;
}
function SetSCNo(obj)
{
	$('#cboScNo').val(obj.value);
}
function setOrderNo(obj)
{
	$('#cboOrderNo').val(obj.value);
}
function LoadBulkGateDetails()
{
	document.frmLeftOverGPListing.submit();
}