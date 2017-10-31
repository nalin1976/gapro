var xmlHttp;
var mainArrayIndex 		= 0;
var Materials 			= [];
var xmlHttp2 			= [];
var xmlHttp4			= [];
var xmlHttp5			= [];

var issueNo 			= 0;
var issueYear 			= 0;
var validateCount 		= 0;
var validateBinCount 	= 0;
var mainRw 				= 0;
var Pub_PopUprowIndex	= 0;
var Pub_popUoRollIndex	= 0;
var checkLoop 			= 0;

var pub_binStatus		= 0;
var pub_commonBin		= 0;

var pub_IssueUrl = "/gapro/issue/";


function createAltXMLHttpRequest(){
    if (window.ActiveXObject) 
    {
        altxmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        altxmlHttp = new XMLHttpRequest();
    }
}

function createXMLHttpRequest2(index){
    if (window.ActiveXObject) 
    {
        xmlHttp2[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2[index] = new XMLHttpRequest();
    }
}

function createXMLHttpRequest4(index){
    if (window.ActiveXObject) 
    {
        xmlHttp4[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp4[index] = new XMLHttpRequest();
    }
}

function createXMLHttpRequest5(index){
    if (window.ActiveXObject) 
    {
        xmlHttp5[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp5[index] = new XMLHttpRequest();
    }
}

function backtopage(){
	window.location.href="main.php";
}

function ClearForm(){	
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

function createXMLHttpRequest1(){
	if (window.ActiveXObject) 
	{
		xmlHttp1 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp1 = new XMLHttpRequest();
	}
}

function GetXmlHttpObject(){
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

function closeWindow(){
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
		// alert(1);
	}	
}

function RemoveItem(obj){
	if(confirm('Are you sure you want to remove this item?'))
	{
		obj.parentNode.parentNode.parentNode;

		var td = obj.parentNode;
		var tro = td.parentNode;
		var tt=tro.parentNode;		
		tt.parentNode.removeChild(tt);	
		Materials[obj.id] = null;		
	}
}

function LoadSCNO(obj){
	
	document.getElementById('cboScNo').value = obj.value;
	//LoadBuyerPoNo();
	
}

function LoadStyleID(obj){
	/*var ScNo =document.getElementById('cboScNo').options[document.getElementById('cboScNo').selectedIndex].text;
	document.getElementById('cboorderno').value =ScNo;*/
	document.getElementById('cboorderno').value = obj.value;
	LoadBuyerPoNo();
}
function loadstyleName(){
	var cboScNo = document.getElementById('cboScNo').value;
	var mainStore = document.getElementById('cboMainStores').value;
   	var url = 'issuexml.php?RequestType=loadScWiseStyleNo&cboScNo='+cboScNo+'&mainStore='+URLEncode(mainStore);
    var htmlobj=$.ajax({url:url,async:false});
		var XMLSTYLEno = htmlobj.responseXML.getElementsByTagName('STYLEno')[0].childNodes[0].nodeValue;				
				document.getElementById('cboStyleNo').value = XMLSTYLEno;	
}

//Start - Popup Issueitems.php form
function ShowItems()
{
	if(document.getElementById('cboMainStores').value=="")
	{
		alert("Please select the 'Main Store'.");
		document.getElementById('cboMainStores').focus();
		return;
	}
	
	drawPopupArea(958,450,'frmItems');
	var HTMLText = 	"<table width=\"950\" border=\"0\" align=\"center\" bgcolor=\"#FFFFFF\">"+
    				"<tr>"+
   "<td class=\"mainHeading\">MRN Details</td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\">"+
      "<tr>"+
        "<td width=\"100%\"><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bcgl1\">"+
          "<tr>"+
		  "<td width=\"7%\" height=\"24\" class=\"normalfnt\">Style No</td>"+
			"<td width=\"9%\" class=\"normalfnt\"><select name=\"cboStyleNo\" class=\"txtbox\" id=\"cboStyleNo\" style=\"width:80px\" onchange=\"LoadStyles(this.value);\">"+
			"</select>            </td>"+
			"<td width=\"7%\" height=\"24\" class=\"normalfnt\">Order No</td>"+
			"<td width=\"9%\" class=\"normalfnt\"><select name=\"cboorderno\" class=\"txtbox\" id=\"cboorderno\" style=\"width:80px\" onchange=\"LoadBuyerPoNo();LoadSCNO(this);\">"+
			"</select>            </td>"+
			"<td width=\"5%\" class=\"normalfnt\">SC No</td>"+
			"<td width=\"7%\" class=\"normalfnt\"><select name=\"cboScNo\" type=\"text\" class=\"txtbox\" id=\"cboScNo\" style=\"width:50px\" onchange=\"LoadStyleID(this);\">"+
			"</select></td>"+
			"<td width=\"10%\" class=\"normalfnt\">Buyer PO No</td>"+
			"<td width=\"12%\" class=\"normalfnt\"><select name=\"cbobuyerpono\" class=\"txtbox\" id=\"cbobuyerpono\" style=\"width:80px\" onchange=\"LoadMrnNo();\">"+
			"</select></td>"+
			"<td width=\"6%\" class=\"normalfnt\">Material</td>"+
			"<td width=\"10%\" class=\"normalfnt\"><select name=\"cbomaterial\" class=\"txtbox\" id=\"cbomaterial\" style=\"width:80px\">"+
			"</select></td>"+
			"<td width=\"7%\" class=\"normalfnt\">MRN No</td>"+
			"<td width=\"14%\" class=\"normalfnt\"><select name=\"cbomrnno\" class=\"txtbox\" id=\"cbomrnno\" style=\"width:80px\" onchange=\"loadMrnDetailsToGrid();\">"+
			"</select></td>"+
			"<td width=\"15%\" class=\"normalfnt\"><img src=\"../images/search.png\" alt=\"search\" width=\"80\" height=\"24\" onclick=\"loadMrnDetailsToGrid();\" /></td>"+
          "</tr>"+
        "</table></td>"+
        "</tr>"+
    "</table></td>"+
  "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
      "<tr>"+
        "<td height=\"21\" class=\"mainHeading2\"><div align=\"center\">Issue Items</div></td>"+
        "</tr>"+
      "<tr>"+
        "<td class=\"normalfnt\"><div id=\"divIssueItem\" style=\"overflow:scroll; height:332px; width:950px;\">"+
          "<table id=\"IssueItem\" width=\"1000\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
            "<tr class=\"mainHeading4\">"+
              "<td width=\"2%\" height='25'><input type=\"checkbox\" name=\"chksel\" id=\"chksel\" onclick=\"SelectAll(this);\"/></td>"+
              "<td width=\"25%\" >Details</td>"+
              "<td width=\"11%\" >Color</td>"+
              "<td width=\"7%\" >Size</td>"+
              "<td width=\"4%\" >Unit</td>"+
              "<td width=\"7%\" >Req Qty</td>"+
              "<td width=\"7%\" >GRN Balance</td>"+
              "<td width=\"2%\" >&nbsp;</td>"+
              "<td width=\"10%\" >Order No</td>"+
			  "<td width=\"10%\" >Buyer PoNo</td>"+
			  "<td width=\"2%\" >&nbsp;</td>"+
              "</tr>"+  
          "</table>"+
        "</div></td>"+
        "</tr>"+
    "</table></td>"+
 "</tr>"+
  "<tr>"+
    "<td><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">"+
      "<tr>"+
        "<td width=\"32%\" height=\"29\">&nbsp;</td>"+
        "<td width=\"12%\"><img src=\"../images/ok.png\" width=\"86\" height=\"24\" onclick=\"LoaddetailsTomainPage();\"/></td>"+ 
        "<td width=\"10%\"><img src=\"../images/close.png\" width=\"97\" height=\"24\" border=\"0\" onClick=\"closeWindow();\" /></td>"+
        "<td width=\"32%\">&nbsp;</td>"+
      "</tr>"+
   "</table></td>"+
  "</tr>"+
"</table>";
	
	
	loca = -1;
	var frame = document.createElement("div");
    frame.id = "itemselectwindow";
	document.getElementById('frmItems').innerHTML=HTMLText;
	LoadStyles();
	LoadMaterials();
	RemoveAllRows("IssueItem");
	LoadMrnNoDirectly();
	LoadStyleNo();
}
//End - Popup Issueitems.php form

//
function LoadStyleNo()
{
	var mainStore = document.getElementById('cboMainStores').value;
	var url='issuexml.php?RequestType=LoadStyleNo&mainStore='+mainStore;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboStyleNo').innerHTML = htmlobj.responseText;
}

//

//Start - load mrn no with out any condition(LoadMrnNoDirectly)
function LoadMrnNoDirectly()
{    
	var mainStore = document.getElementById('cboMainStores').value;
   	var url = 'issuexml.php?RequestType=LoadMrnNoDirectly&mainStore='+mainStore;
    var htmlobj=$.ajax({url:url,async:false});
	LoadMrnNoDirectlyRequest(htmlobj);
}

function LoadMrnNoDirectlyRequest(xmlHttp1)
{			 
	document.getElementById("cbomrnno").innerHTML = xmlHttp1.responseText;
}
//End - load mrn no with out any condition(LoadMrnNoDirectly)

//Start -Load Styles 
function LoadStyles()
{    
	RomoveData("cboorderno");
	RomoveData("cboScNo");
	var mainStore = document.getElementById('cboMainStores').value;
	var styleNo = document.getElementById('cboStyleNo').value;
	var url = 'issuexml.php?RequestType=loadStyle&mainStore='+mainStore+'&styleNo='+URLEncode(styleNo);
   	var htmlobj=$.ajax({url:url,async:false});
	StylesRequest(htmlobj);
}

function StylesRequest(xmlHttp)
{	
	var XMLSRNO 		= xmlHttp.responseXML.getElementsByTagName("SRNO");
	var XMLStyleID 		= xmlHttp.responseXML.getElementsByTagName("StyleID");
	var XMLStyleName  	= xmlHttp.responseXML.getElementsByTagName("StyleName");
	var XMLCommonBin 	= xmlHttp.responseXML.getElementsByTagName("CommonBin");
	pub_commonBin		= XMLCommonBin[0].childNodes[0].nodeValue;
	
	var opt = document.createElement("option");
	opt.text 	= "";	
	opt.value 	= "";
	document.getElementById("cboorderno").options.add(opt);	

	document.getElementById("cboScNo").innerHTML = XMLSRNO[0].childNodes[0].nodeValue;	
			
	for ( var loop = 0; loop < XMLStyleID.length; loop ++)
	{			
		var opt = document.createElement("option");
		opt.text = XMLStyleName[loop].childNodes[0].nodeValue;
		opt.value = XMLStyleID[loop].childNodes[0].nodeValue;
		document.getElementById("cboorderno").options.add(opt);		
	}
}
//End -Load Styles 

//Start -Load Materials 
function LoadMaterials()
{	
	var url = 'issuexml.php?RequestType=LoadMaterial';
	var htmlobj=$.ajax({url:url,async:false});
	MaterialsRequest(htmlobj);
}

function MaterialsRequest(altxmlHttp)
{	
	document.getElementById("cbomaterial").innerHTML = altxmlHttp.responseText;
}
//End -Load Materials 	

//Start -LoadBuyer PoNo after click style id
function LoadBuyerPoNo()
{	
	RomoveData("cbobuyerpono");
	RomoveData("cbomrnno");
	RemoveAllRows("IssueItem");
	var strStyleName=document.getElementById('cboorderno').value;
	
	var url = 'issuexml.php?RequestType=LoadBuyerPoNo&strStyleName=' + URLEncode(strStyleName);
	var htmlobj=$.ajax({url:url,async:false});
	BuyerPoNoRequest(htmlobj);
}

function BuyerPoNoRequest(xmlHttp)
{	
	var XMLBuyerPONO 	= xmlHttp.responseXML.getElementsByTagName("BuyerPOid");
	var XMLBuyerPOName 	= xmlHttp.responseXML.getElementsByTagName("BuyerPOName");	
	for ( var loop = 0; loop < XMLBuyerPONO.length; loop ++)
	{							
		var opt = document.createElement("option");
		opt.value = XMLBuyerPONO[loop].childNodes[0].nodeValue;
		opt.text = XMLBuyerPOName[loop].childNodes[0].nodeValue;						
		document.getElementById("cbobuyerpono").options.add(opt);			
	}
	LoadMrnNo();
}
//End -LoadBuyer PoNo after click style id

//Start -Load MrnNo PoNo when click BuyerPoNo
function LoadMrnNo()
{
	RemoveAllRows("IssueItem");	
	var strStyleName =document.getElementById('cboorderno').value;
	var strBuyerPoNo =document.getElementById('cbobuyerpono').value;
	var strMainStore = document.getElementById('cboMainStores').value;
	
	var url = 'issuexml.php?RequestType=LoadMrnNo&strStyleName=' + URLEncode(strStyleName) + '&strBuyerPoNo=' + URLEncode(strBuyerPoNo)+'&strMainStore='+strMainStore;	
    var htmlobj=$.ajax({url:url,async:false});
	LoadMrnNoRequest(htmlobj);
}

function LoadMrnNoRequest(xmlHttp)
{	
	document.getElementById("cbomrnno").innerHTML = xmlHttp.responseText;
}
//End -Load MrnNo PoNo when click BuyerPoNo

//Start -Load MrnNo Details to Body
function loadMrnDetailsToGrid()
{	
/*	if(document.getElementById('cboorderno').value=="")
	{
		alert("Please select the 'Order No'.");
		document.getElementById('cboorderno').focus();
		return;
	}*/
	if(document.getElementById('cbomrnno').value=="")
	{
		alert("Please select the 'MRN No'.");
		document.getElementById('cbomrnno').focus();
		return;
	}
	if(document.getElementById('cboMainStores').value=="")
	{
		alert("Please select the 'Main Store'.");
		document.getElementById('cboMainStores').focus();
		return;
	}
	ClearTable("IssueItem");
	
	var StyleId =document.getElementById('cboorderno').value;
	var BuyerPoNo =document.getElementById('cbobuyerpono').value;
	
	var strMrnNo =document.getElementById('cbomrnno').options[document.getElementById('cbomrnno').selectedIndex].text;
	var MatId =document.getElementById('cbomaterial').value;
	
	var strobj = strMrnNo.split("/");
	//var MrnNo = (strMrnNo.substring(5,11));
	var mrnYear = (strobj[0]);
	var mrnNo =(strobj[1]);
		
	var mainStoreId = document.getElementById('cboMainStores').value;
	createXMLHttpRequest();
	
	/*xmlHttp.onreadystatechange = loadMrnDetails;
	xmlHttp.open("GET", 'issuexml.php?RequestType=loadMrnDetailsToGrid&StyleId=' + URLEncode(StyleId) + '&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&mrnNo=' + mrnNo + '&mrnYear=' + mrnYear + '&MatId=' + MatId+'&mainStoreId='+mainStoreId , true);	
    xmlHttp.send(null); */
	var url = 'issuexml.php?RequestType=loadMrnDetailsToGrid&StyleId=' + URLEncode(StyleId) + '&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&mrnNo=' + mrnNo + '&mrnYear=' + mrnYear + '&MatId=' + MatId+'&mainStoreId='+mainStoreId;
	htmlobj=$.ajax({url:url,async:false});
	CreatePopUpItemGrid(htmlobj);
}

function CreatePopUpItemGrid(htmlobj)
{
	var XMLItemDescription 	= htmlobj.responseXML.getElementsByTagName("ItemDescription");
	var XMLMatDetailID 		= htmlobj.responseXML.getElementsByTagName("MatDetailID");
	var XMLColor 			= htmlobj.responseXML.getElementsByTagName("Color");
	var XMLSize 			= htmlobj.responseXML.getElementsByTagName("Size");
	var XMLUnit 			= htmlobj.responseXML.getElementsByTagName("Unit");
	var XMLBalQty 			= htmlobj.responseXML.getElementsByTagName("BalQty");
	var XMLMatMainID 		= htmlobj.responseXML.getElementsByTagName("MatMainID");
	var XMLStockQty 		= htmlobj.responseXML.getElementsByTagName("StockQty");
	var XMLStyleNo 			= htmlobj.responseXML.getElementsByTagName("StyleNo");
	var XMLBuyerPONO 		= htmlobj.responseXML.getElementsByTagName("BuyerPONO");
	var XMLStyleName 		= htmlobj.responseXML.getElementsByTagName("StyleName");
	var XMLBuyerPOName 		= htmlobj.responseXML.getElementsByTagName("BuyerPOName");
	var XMLSCNO 			= htmlobj.responseXML.getElementsByTagName("SCNO");
	var XMLGRNno 			= htmlobj.responseXML.getElementsByTagName("GRNno");
	var XMLGRNyear 			= htmlobj.responseXML.getElementsByTagName("GRNyear");	
	var XMLGRNType 			= htmlobj.responseXML.getElementsByTagName("grnType");	
	var XMLstrGRNType 		= htmlobj.responseXML.getElementsByTagName("strGRNType");
	var tbl 		= document.getElementById('IssueItem');
	for(loop=0;loop<XMLMatDetailID.length;loop++)
	{
		var lastRow = tbl.rows.length;	
		var row = tbl.insertRow(lastRow);
		row.className = "bcgcolor-tblrowWhite";
		
		var cell = row.insertCell(0);
		cell.className ="normalfntMid";
		cell.setAttribute('height','20');
		cell.innerHTML = "<input name=\"checkbox\" type=\"checkbox\" id=\"chksel\" >";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.id = XMLMatDetailID[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLItemDescription[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(2);
		cell.className ="normalfnt";
		cell.id = XMLMatMainID[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLColor[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(3);
		cell.className ="normalfnt";
		cell.id = XMLSCNO[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLSize[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(4);
		cell.className ="normalfnt";
		cell.innerHTML = XMLUnit[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(5);
		cell.className ="normalfntRite";
		cell.innerHTML = XMLBalQty[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(6);
		cell.className ="normalfntRite";
		cell.innerHTML = XMLStockQty[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(7);
		cell.className ="normalfntMid";
		cell.innerHTML = "<div align=\"center\"><img src=\"../images/house.png\" onClick=\"setStockTransaction(this)\" alt=\"del\" width=\"15\" height=\"15\" /></div>";
		
		var cell = row.insertCell(8);
		cell.className ="normalfnt";
		cell.id =XMLStyleNo[loop].childNodes[0].nodeValue
		cell.innerHTML = XMLStyleName[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(9);
		cell.className ="normalfnt";
		cell.id =XMLBuyerPONO[loop].childNodes[0].nodeValue
		cell.innerHTML = XMLBuyerPOName[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(10);
		cell.className ="normalfntRite";
		cell.innerHTML = XMLGRNno[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(11);
		cell.className ="normalfntRite";
		cell.innerHTML = XMLGRNyear[loop].childNodes[0].nodeValue;
		
		var cell = row.insertCell(12);
		cell.className ="normalfnt";
		cell.id = XMLGRNType[loop].childNodes[0].nodeValue;
		cell.innerHTML = XMLstrGRNType[loop].childNodes[0].nodeValue;
	}
}
	function loadMrnDetails()
	{	
		
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  		
				
			 	var XMLItemDescription 	= xmlHttp.responseXML.getElementsByTagName("ItemDescription");
				var XMLMatDetailID 		= xmlHttp.responseXML.getElementsByTagName("MatDetailID");
				var XMLColor 			= xmlHttp.responseXML.getElementsByTagName("Color");
				var XMLSize 			= xmlHttp.responseXML.getElementsByTagName("Size");
				var XMLUnit 			= xmlHttp.responseXML.getElementsByTagName("Unit");
				var XMLBalQty 			= xmlHttp.responseXML.getElementsByTagName("BalQty");
				var XMLMatMainID 		= xmlHttp.responseXML.getElementsByTagName("MatMainID");
				var XMLStockQty 		= xmlHttp.responseXML.getElementsByTagName("StockQty");
				var XMLStyleNo 			= xmlHttp.responseXML.getElementsByTagName("StyleNo");
				var XMLBuyerPONO 		= xmlHttp.responseXML.getElementsByTagName("BuyerPONO");
				var XMLStyleName 		= xmlHttp.responseXML.getElementsByTagName("StyleName");
				var XMLBuyerPOName 		= xmlHttp.responseXML.getElementsByTagName("BuyerPOName");
				var XMLSCNO 			= xmlHttp.responseXML.getElementsByTagName("SCNO");
				var XMLGRNno 			= xmlHttp.responseXML.getElementsByTagName("GRNno");
				var XMLGRNyear 			= xmlHttp.responseXML.getElementsByTagName("GRNyear");
				
				
				/*var strText = "<table id=\"IssueItem\" width=\"1000\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
							  "<tr class=\"mainHeading4\">"+
							  "<td width=\"2%\" height=\"25\" ><input type=\"checkbox\" name=\"chksel\" id=\"chksel\" onclick=\"SelectAll(this);\"/></td>"+
								  "<td width=\"23%\" >Details</td>"+
								  "<td width=\"10%\" >Color</td>"+
								  "<td width=\"7%\" >Size</td>"+
								  "<td width=\"4%\" >Unit</td>"+
								  "<td width=\"7%\" >Req Qty</td>"+
								  "<td width=\"7%\" >GRN Balance</td>"+
								  "<td width=\"2%\" ></td>"+
								  "<td width=\"10%\" >Order No</td>"+
								  "<td width=\"8%\" >Buyer PoNo</td>"+
								  "<td width=\"4%\" >GRN No</td>"+
								  "<td width=\"3%\" >GRN Year</td>"+
							  "</tr>";*/
						
				for (var loop =0; loop < XMLItemDescription.length; loop ++)
				{
					/*var bpoName = XMLBuyerPOName[loop].childNodes[0].nodeValue;
					var bpoID   = XMLBuyerPONO[loop].childNodes[0].nodeValue;
						strText += 	  "<tr class=\"bcgcolor-tblrowWhite\">"+
									  "<td><div align=\"center\">"+
									  "<input type=\"checkbox\" name=\"chksel\" id=\"chksel\" />"+
									  "</div></td>"+
									      "<td class=\"normalfnt\" id=\"" +  XMLMatDetailID[loop].childNodes[0].nodeValue + "\">"+XMLItemDescription[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\" id =\""+ XMLMatMainID[loop].childNodes[0].nodeValue +"\">"+XMLColor[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\" id=\""+XMLSCNO[loop].childNodes[0].nodeValue+"\">"+XMLSize[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntRite\">"+XMLBalQty[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntRite\">"+XMLStockQty[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntMid\"><div align=\"center\"><img src=\"../images/house.png\" onClick=\"setStockTransaction(this)\" alt=\"del\" width=\"15\" height=\"15\" /></div></td>"+
										  "<td class=\"normalfnt\" id =\""+ XMLStyleNo[loop].childNodes[0].nodeValue +"\">"+XMLStyleName[loop].childNodes[0].nodeValue+"</td>"+
										  "<td class=\"normalfntRite\" id=\""+bpoID+"\">"+bpoName+"</td>"+
										  "<td class=\"normalfntRite\">"+ XMLGRNno[loop].childNodes[0].nodeValue+"</td>"+
										   "<td class=\"normalfntRite\">"+ XMLGRNyear[loop].childNodes[0].nodeValue+"</td>"+
									  "</tr>";*/
				}

							 // strText += "</table>";
				document.getElementById("divIssueItem").innerHTML=strText;
							  
			}
		}
	}
//End -Load MrnNo Details to Body

//Start - Load details from frame to main issue page
function LoaddetailsTomainPage()
{	
	//pub_commonBin		= document.getElementById('commonBinID').title;
	var tbl 			= document.getElementById('IssueItem');
	
	for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
  	{		
		var chkBx = tbl.rows[loop].cells[0].childNodes[0];
		
		if (chkBx.checked)
		{
//start - issueItems.php 			
			var itemdDetail 	= tbl.rows[loop].cells[1].childNodes[0].nodeValue;
			var itemdDetailID 	= tbl.rows[loop].cells[1].id;
			var mainMatName 	= tbl.rows[loop].cells[2].id;
			var color 			= tbl.rows[loop].cells[2].childNodes[0].nodeValue;
			var size			= tbl.rows[loop].cells[3].childNodes[0].nodeValue;
			var Unit 			= tbl.rows[loop].cells[4].childNodes[0].nodeValue;
			var Req_Qty 		= tbl.rows[loop].cells[5].childNodes[0].nodeValue;
			//alert(Req_Qty);
			var GrnQty 			= tbl.rows[loop].cells[6].childNodes[0].nodeValue;
			var BuyerPoName		= tbl.rows[loop].cells[9].childNodes[0].nodeValue;
			var BuyerPoNo 		= tbl.rows[loop].cells[9].id;
			var mrnno 			=document.getElementById('cbomrnno').options[document.getElementById('cbomrnno').selectedIndex].text;
			var StyleName 		= tbl.rows[loop].cells[8].childNodes[0].nodeValue;
			var StyleID 		= tbl.rows[loop].cells[8].id;
			var SCNO 			= tbl.rows[loop].cells[3].id;
			var  tblIssueList = document.getElementById('tblIssueList');
			var testBin = 0 ;
			
			//add GRN no & GRN year ---------------------------
			var grnNo = tbl.rows[loop].cells[11].childNodes[0].nodeValue + '/' + tbl.rows[loop].cells[10].childNodes[0].nodeValue;
			var grnType 	= tbl.rows[loop].cells[12].id;
			var strGRNtype = tbl.rows[loop].cells[12].childNodes[0].nodeValue;
			//end ---------------------------------------------
			
//End - issueItems.php
//start -issue.php
				var booCheck =false;
				for (var mainLoop =1 ;mainLoop < tblIssueList.rows.length; mainLoop++ )
				{
					var mainStyle =tblIssueList.rows[mainLoop].cells[12].id;
					var mainBuyerPoNO =tblIssueList.rows[mainLoop].cells[11].id;
					var mainItemDetailId = tblIssueList.rows[mainLoop].cells[3].id;
					var mainColor = tblIssueList.rows[mainLoop].cells[4].lastChild.nodeValue;
					var mainSize =tblIssueList.rows[mainLoop].cells[5].lastChild.nodeValue;						
					var mainMrnNo = tblIssueList.rows[mainLoop].cells[10].lastChild.nodeValue;					
					var mainGRNno = tblIssueList.rows[mainLoop].cells[14].lastChild.nodeValue;
					var mainGRNtype = tblIssueList.rows[mainLoop].cells[15].id;
					if ((mainStyle==StyleID) && (mainBuyerPoNO==BuyerPoNo) && (mainItemDetailId==itemdDetailID) && (mainColor==color) && (mainSize==size) && (mainMrnNo==mrnno) && (grnNo == mainGRNno) && (mainGRNtype == grnType))
						{
							booCheck =true;
						}			
				}
//End -issue.php
			
			if (booCheck == false)
			{
				var lastRow = tblIssueList.rows.length;	
				var row = tblIssueList.insertRow(lastRow);
				row.className = "bcgcolor-tblrowWhite";	
				
	/*			if(xml_FabricRollInspectionAllow=="true" && mainMatName=="FABRIC"){
				var celledit = row.insertCell(position);
				celledit.id=mainArrayIndex;
				celledit.innerHTML = "<img src=\"../images/add.png\" alt=\"edit\" width=\"15\" height=\"15\"  onclick=\"OPenFabricRollInspection(this," + mainArrayIndex  + ");\" />";		
				position++;
				}
				else{
					var celledit = row.insertCell(position);
				celledit.id=mainArrayIndex;
				celledit.innerHTML = "";	
				position++;
				}*/
				
				if(xml_FabricRollInspectionAllow=="true"){
					if(mainMatName=="FABRIC"){
						var celledit = row.insertCell(0);
						celledit.id=mainArrayIndex;
						celledit.innerHTML = "<img src=\"../images/add.png\" alt=\"edit\" width=\"15\" height=\"15\"  onclick=\"OPenFabricRollInspection(this," + mainArrayIndex  + ");\" />";		
					
						}
						else{
							var celledit = row.insertCell(0);
						celledit.id=mainArrayIndex;
						celledit.innerHTML = "";						
						}
				}
				else{
					var celledit = row.insertCell(0);
					celledit.id=mainArrayIndex;
					celledit.innerHTML = "";
				}
				
				var cellDelete = row.insertCell(1);  
				cellDelete.id = mainArrayIndex;
				cellDelete.innerHTML = "<div align=\"left\"><img src=\"../images/del.png\" id=\"" + mainArrayIndex + "\" alt=\"del\" width=\"15\" height=\"15\" onclick=\"RemoveItem(this);\" /></div>";
			
				
				var cellIssuelist = row.insertCell(2);
				cellIssuelist.className ="normalfnt";
				cellIssuelist.id =testBin;
				cellIssuelist.innerHTML =mainMatName;
				
				var cellIssuelist = row.insertCell(3);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id=itemdDetailID;
				cellIssuelist.innerHTML = itemdDetail;
				
				var cellIssuelist = row.insertCell(4);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =color;
				
				var cellIssuelist = row.insertCell(5);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =size;
	
				var cellIssuelist = row.insertCell(6);
				cellIssuelist.id=GrnQty;
				cellIssuelist.innerHTML="<input type=\"text\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+Req_Qty+"\" style=\"width:81px;text-align:right\" onfocus=\"GetQty(this);\" onkeydown=\"RemoveBinColor(this);\" onkeypress=\"return CheckforValidDecimal(this.value, 4,event);\" onkeyup=\"ValidateQty(this);SetQuantity(this," + mainArrayIndex  + ")\"/>";
				
			//	if(pub_commonBin==0)
			//	{
				var celladd = row.insertCell(7);
				celladd.innerHTML = "<img src=\"../images/plus_16.png\" alt=\"add\" onclick=\"GetQty(this);ShowBinItems(this," + mainArrayIndex  + ");LoadBindetails(this," + mainArrayIndex  + ");SetItemQuantity(this," + mainArrayIndex  + ");\"/>";
			//	}
			//	else 
			//	{
			//		var celladd = row.insertCell(7);
			//		celladd.innerHTML="Common Bin";
			//	}
				
				var cellIssuelist = row.insertCell(8);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.innerHTML =Req_Qty;
				
				var cellIssuelist = row.insertCell(9);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =Unit;
				
				var cellIssuelist = row.insertCell(10);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =mrnno;
				
				var cellIssuelist = row.insertCell(11);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id =BuyerPoNo;
				cellIssuelist.innerHTML =BuyerPoName;
				
				
				var cellIssuelist = row.insertCell(12);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id =StyleID;
				cellIssuelist.innerHTML =StyleName;
				
				var cellIssuelist = row.insertCell(13);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =SCNO;
				
				var cellIssuelist = row.insertCell(14);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =grnNo;
				
				var cellIssuelist = row.insertCell(15);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.id = grnType;
				cellIssuelist.innerHTML =strGRNtype;
				// Saving Data
				var details = [];
				details[0] =   itemdDetailID; // Mat ID
				details[1] =   color; // Color
				details[2] =   size ;// Size
				details[3] =   BuyerPoNo; // Buyer PO
				details[4] = 	parseFloat(Req_Qty); //  Qty
				details[6] = mrnno; //mrnNo
				details[7] = StyleID; //StyleID			
				details[8] = Unit;
				details[10] = grnNo;
				details[11] = grnType;
				Materials[mainArrayIndex] = details;
				mainArrayIndex ++ ;
		
				}
		}
	}
	loadProductionLineNo();
CloseOSPopUp('popupLayer1');

}
//End - Load details from frame to main issue page

function loadProductionLineNo()
{	
	var mrnno =document.getElementById('cbomrnno').options[document.getElementById('cbomrnno').selectedIndex].text;
	
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = loadProductionLineNoRequest;
	xmlHttp.open("GET", 'issuexml.php?RequestType=loadProductionLineNo&mrnno=' + mrnno , true);	
    xmlHttp.send(null); 
}

	function loadProductionLineNoRequest()
	{	
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  			 
			 	var XMLDepartment = xmlHttp.responseXML.getElementsByTagName('Department')[0].childNodes[0].nodeValue;				
				document.getElementById('cboprolineno').value = XMLDepartment;				
			}
		}		
	}

function ValidateQty(obj)
{
	var rw 			= obj.parentNode.parentNode;
	var Qty 		= parseFloat(rw.cells[6].childNodes[0].value);
	var GrnQty 		= parseFloat(rw.cells[6].id);
	var MrnQty 	= parseFloat(rw.cells[8].childNodes[0].nodeValue);	
	
	if(Qty>GrnQty)
	{		
		rw.cells[6].childNodes[0].value=GrnQty;
	}
	if(Qty>MrnQty){
		rw.cells[6].childNodes[0].value=MrnQty;
	}
}

function SetQuantity(obj,index){
		var rw=obj.parentNode.parentNode;
		Materials[index][4] = parseFloat(rw.cells[6].childNodes[0].value);		
}

function SetItemQuantity(obj,index)
{
	//PRASAD
	//Materials[index][4] = obj.value;
//	alert (obj.value);
		var rw = obj.parentNode.parentNode;
		Materials[index][4] = parseFloat(rw.cells[6].childNodes[0].value);		
}

//****************************************************BIN PART**************************************************************************
//Start-Show Bin Item form after click add bin button in main issue.php form
function ShowBinItems(obj,index)
{	

//alert(pub_commonBin);
	//pub_commonBin		= document.getElementById('commonBinID').title;
	if(pub_commonBin==1)
	{
		alert("CommonStock Bin System Activated\nAll the Bin Details Save to common Bins");
		return;
	}
	
	var rw = obj.parentNode.parentNode;
	
	var txtValue = parseFloat(rw.cells[6].childNodes[0].value);
	var reqQty = parseFloat(rw.cells[8].lastChild.nodeValue);
	
	if (txtValue=="" || txtValue==0)
	{
		alert ("Issue qty can't be '0' or empty");
		 return false;
	}	
	else if (txtValue > reqQty)
	{
		alert ("Issue qty can't exceed MRN Qty");
		rw.cells[6].childNodes[0].value =reqQty;
		return false;
	}		

	drawPopupArea(513,340,'frmBinItems');
	
	var HTMLText = "<table width=\"75%\" border=\"0\" bgcolor=\"#FFFFFF\">"+
          "<tr>"+
            "<td height=\"16\" class=\"mainHeading\">Bin Items</td>"+
          "</tr>"+
          "<tr>"+
            "<td height=\"17\"><table width=\"100%\" border=\"0\">"+
              "<tr>"+
                "<td width=\"19%\">&nbsp;</td>"+
                "<td width=\"25%\" class=\"normalfnt\">Required Quantity</td>"+
                "<td width=\"56%\"><input type=\"text\" name=\"txtReqQty\" id=\"txtReqQty\"  value=\"" + txtValue + "\"  readonly=\"true\"/></td>"+
              "</tr>"+
            "</table></td>"+
          "</tr>"+
          "<tr>"+
            "<td height=\"165\"><form id=\"frmcategories\" name=\"form1\" method=\"post\"  action=\"\">"+
              "<table width=\"100%\" height=\"165\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">"+
                "<tr class=\"bcgl1\">"+
                  "<td width=\"100%\"><table width=\"93%\" border=\"0\" class=\"tableBorder\">"+
                   "<tr>"+
                      "<td colspan=\"3\"><div id=\"divBinItems\" style=\"overflow:scroll; height:240px; width:500px;\">"+
          "<table id=\"tblBinItems\" width=\"900\" cellpadding=\"0\" cellspacing=\"0\" >"+          
          "</table>"+
        "</div></td>"+
                      "</tr>"+                    
                  "</table></td>"+
                "</tr>"+
                "<tr>"+
                  "<td ><table width=\"100%\" border=\"0\" class=\"tableBorder\">"+
                   "<tr>"+
                      "<td width=\"33%\">&nbsp;</td>"+
                      "<td width=\"17%\" class=\"normalfntp2\"><img src=\"../images/save.png\" alt=\"Save\" width=\"84\" height=\"24\" onClick=\"saveBinDetails();SetBinItemQuantity(this," + index  + ");\" /></td>"+                     
               "<td width=\"30%\"><class=\"normalfntp2\"><img src=\"../images/close.png\" alt=\"close\" width=\"97\" height=\"24\"  onClick=\"closeWindow();\"/></td>"+
					  "<td width=\"20%\">&nbsp;</td>"+
                    "</tr>"+
                  "</table></td>"+
                "</tr>"+
              "</table>"+
              "</form> </td>"+
          "</tr>"+
       "</table>";
	   
	var frame = document.createElement("div");
    frame.id = "itemselectwindow";
	document.getElementById('frmBinItems').innerHTML=HTMLText;
	
}
//End-Show Bin Item form after click add bin button in main issue.php form

function GetQty(obj)
{
	var rw = obj.parentNode.parentNode;
	var reqQty = rw.cells[8].lastChild.nodeValue;
	var issueQty =rw.cells[6].childNodes[0].value;			
	if ((issueQty=="") ||(issueQty==0))
	{
		rw.cells[6].childNodes[0].value =reqQty;
	}
}

function LoadBindetails(obj,index)
{
	var rw = obj.parentNode.parentNode;
	mainRw = obj.parentNode.parentNode.rowIndex;
	var styleId =rw.cells[12].id
	var buyerPoNo =rw.cells[11].id

	var matdetailId = rw.cells[3].id;	
	var color = rw.cells[4].lastChild.nodeValue;
	var size = rw.cells[5].lastChild.nodeValue;
	var grnNo = rw.cells[14].lastChild.nodeValue;
	var grnType = rw.cells[15].id;
	
if(pub_commonBin !=1){
	var mainStoreId = document.getElementById('cboMainStores').value
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadBInDetailsRequest;	
	xmlHttp.index = index;
	xmlHttp.open("GET" ,'issuexml.php?RequestType=GetBinDetails&styleId=' + URLEncode(styleId) + '&buyerPoNo=' + URLEncode(buyerPoNo) + '&matdetailId=' + matdetailId + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) +'&mainStoreId='+mainStoreId+'&grnNo='+URLEncode(grnNo)+'&grnType='+grnType, true);
	xmlHttp.send(null);
}
	
}

	function LoadBInDetailsRequest()
	{		
		if(xmlHttp.readyState == 4) 
		{			
			if(xmlHttp.status == 200)
			{					
				var XMLBin = xmlHttp.responseXML.getElementsByTagName("Bin");
				var XMLstockBal = xmlHttp.responseXML.getElementsByTagName("stockBal");
				var XMLMainStores = xmlHttp.responseXML.getElementsByTagName("MainStoresID");
				var XMLSubStore = xmlHttp.responseXML.getElementsByTagName("SubStore");
				var XMLLocation = xmlHttp.responseXML.getElementsByTagName("Location");
				var XMLUnit = xmlHttp.responseXML.getElementsByTagName("Unit");
				var XMLMatSubCatID = xmlHttp.responseXML.getElementsByTagName("MatSubCatID");
				
				var XMLBinName = xmlHttp.responseXML.getElementsByTagName("BinName");
				var XMLMainStoreName = xmlHttp.responseXML.getElementsByTagName("MainStoreName");
				var XMLSubStoresName = xmlHttp.responseXML.getElementsByTagName("SubStoresName");
				var XMLLocationName = xmlHttp.responseXML.getElementsByTagName("LocationName");
				
				var strBinText = "<table id=\"tblBinItems\" width=\"900\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCFF\">"+
								 "<tr class=\"mainHeading4\">"+
									  "<td width=\"7%\" height='25' >Bin ID</td>"+
									  "<td width=\"5%\"  >Avl Qty</td>"+
									  "<td width=\"5%\"  >Req Qty</td>"+
									  "<td width=\"2%\"  >Add</td>"+
									  "<td width=\"12%\"  >Main Stores</td>"+
									  "<td width=\"10%\"  >Sub Stores</td>"+
									  "<td width=\"10%\"  >Location</td>"+
									  "<td width=\"5%\"  >Unit</td>"+
								 "</tr>";
			
				for (var loop = 0; loop < XMLBin.length ; loop ++)
				{
					var mainIndex =0;

					strBinText +="<tr class=\"bcgcolor-tblrowWhite\">"+
									  "<td class=\"normalfntMid\" id=\""+XMLBin[loop].childNodes[0].nodeValue+"\">"+XMLBinName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntRite\">"+XMLstockBal[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntMid\"><input type=\"text\" size=\"10\" class=\"txtbox\" name=\"txtIssueBinQty\" value=\"" + mainIndex + "\" id=\"txtIssueBinQty\" style=\"text-align:right\" onkeyup =\"validateStockWithBinQty(this);\" value=\"0\" onkeypress=\"return isNumberKey(event);\" ></td>"+
									  "<td class=\"normalfntMid\"><div align=\"center\">"+
									  "<input type=\"checkbox\" name=\"chkBin\" id=\"chkBin\" onclick=\"GetStockQty(this);\"/>"+
									  "</div></td>"+
									  "<td class=\"normalfntMid\" id=\""+XMLMainStores[loop].childNodes[0].nodeValue+"\">"+XMLMainStoreName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntMid\" id=\""+XMLSubStore[loop].childNodes[0].nodeValue+"\">"+XMLSubStoresName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntMid\" id=\""+XMLLocation[loop].childNodes[0].nodeValue+"\">"+XMLLocationName[loop].childNodes[0].nodeValue+"</td>"+
									  "<td class=\"normalfntMid\" id=\""+XMLMatSubCatID[loop].childNodes[0].nodeValue+"\">"+XMLUnit[loop].childNodes[0].nodeValue+"</td>"+
								 "</tr>";
								
				}
				strBinText += "</table>";
				document.getElementById("divBinItems").innerHTML=strBinText;
				
			}
		}		
	}

function SetBinItemQuantity(obj,index)
{	
	var tblIssueList =document.getElementById("tblIssueList");			
	var tbl = document.getElementById('tblBinItems');
	var totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
	var issueLoopQty = 0;	
	
		for (loop =1; loop < tbl.rows.length; loop++)
		{
			if (tbl.rows[loop].cells[3].childNodes[0].childNodes[0].checked)
			{		
					issueLoopQty +=  parseFloat(tbl.rows[loop].cells[2].childNodes[0].value);
			}	
		}
	
	if (issueLoopQty == totReqQty )
	{	
		var tbl = document.getElementById('tblBinItems');	
		var tblIssueList =document.getElementById("tblIssueList");	
		var BinMaterials = [];
		var mainBinArrayIndex = 0;
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				var check =tbl.rows[loop].cells[3].childNodes[0].childNodes[0];
				if (check.checked)
				{					
						var Bindetails = [];
							Bindetails[0] =   tbl.rows[loop].cells[0].id; // binId
							Bindetails[1] =   tbl.rows[loop].cells[4].id; // mainStores
							Bindetails[2] =   tbl.rows[loop].cells[5].id;// subStores
							Bindetails[3] =   tbl.rows[loop].cells[6].id; // location
							Bindetails[4] =   tbl.rows[loop].cells[2].childNodes[0].value; // issueQty
							Bindetails[6] =   tbl.rows[loop].cells[7].childNodes[0].nodeValue; //units
							Bindetails[7] =   tbl.rows[loop].cells[7].id; //Sub category id
							BinMaterials[mainBinArrayIndex] = Bindetails;
							mainBinArrayIndex ++ ;							
				}
			}
		Materials[index][5] = BinMaterials;		
		closeWindow();
		tblIssueList.rows[mainRw].className = "bcgcolor-tblrowLiteBlue";//osc3,backcolorGreen
		tblIssueList.rows[mainRw].cells[2].id =1;
	}
	else 
	{
		alert ("Allocated qty must equal with Issue Qty. \nIssue Qty =" + totReqQty + "\nAllocated Qty =" + issueLoopQty );
		return false;
	}
	
}
function RemoveBinColor(obj)
{
	if(pub_commonBin==1)return;
	var tblMain =document.getElementById("tblIssueList");	
	var Rw = obj.parentNode.parentNode.rowIndex;
	tblMain.rows[Rw].className = "bcgcolor-tblrowWhite";//osc3,backcolorGreen,normalfnt2BITAB,backcolorYellow
	tblMain.rows[Rw].cells[2].id =0;
}

//Start - bin qty validate part
function GetStockQty(objbin)
{
	var tbl = document.getElementById('tblBinItems');
	var rw = objbin.parentNode.parentNode.parentNode;
	
	if (rw.cells[3].childNodes[0].childNodes[0].checked)
	{
	
	    totReqQty = parseFloat(document.getElementById('txtReqQty').value);	
		var reqQty = parseFloat(rw.cells[1].lastChild.nodeValue);
		var issueQty = rw.cells[2].childNodes[0].value;
		
		rw.cells[2].childNodes[0].value = 0;
		var issueLoopQty = 0 ;
		
			for ( var loop = 1 ;loop < tbl.rows.length ; loop ++ )
			{
				if (tbl.rows[loop].cells[3].childNodes[0].childNodes[0].checked)
					{		
						issueLoopQty +=  parseFloat(tbl.rows[loop].cells[2].childNodes[0].value);
					}				
			}	
		
				var reduceQty = parseFloat(totReqQty) - parseFloat(issueLoopQty) ;

					if (reqQty <= reduceQty )
					{
						rw.cells[2].childNodes[0].value = reqQty ;
					}
					else 
					{
						 rw.cells[2].childNodes[0].value = reduceQty;
					}
					
	}
	
	else 
		rw.cells[2].childNodes[0].value = 0;
}
//End - bin qty validate part
function validateStockWithBinQty(obj)
{
	var tbl = document.getElementById('tblBinItems');
	var rw = obj.parentNode.parentNode;
	var reqQty = parseFloat(obj.value);
	var avBinQty = parseFloat(rw.cells[1].lastChild.nodeValue);
	//alert(reqQty + ' ' +avBinQty)
	if(reqQty>avBinQty)
	{
		//alert(rw.cells[1].lastChild.nodeValue)
		rw.cells[2].childNodes[0].value='';
		rw.cells[2].childNodes[0].value = avBinQty	
	}
	rw.cells[3].childNodes[0].childNodes[0].checked = true;	
	
	if(obj.value=='')
		rw.cells[3].childNodes[0].childNodes[0].checked = false;	
		//obj.value = avBinQty;
}
//start validate bin qty with available bin qty
	
//end validate bin qty with available bin qty
//END-*****************************************************************BIN PART**************************************************************************************

//Start - Load saved details in when click Search button in issues list.php form
function LoadSavedDetails()
{
	var strIssueNoFrom = document.getElementById('cboissuenofrom').options[document.getElementById('cboissuenofrom').selectedIndex].text;
	var strObjFrom = strIssueNoFrom.split("/");
	var issueYearFrom  = (strObjFrom[0]);
	var issueNoFrom =(strObjFrom[1]);

	var strIssueNoTo =document.getElementById('cboissuenoto').options[document.getElementById('cboissuenoto').selectedIndex].text;
	var strObjTo = strIssueNoTo.split("/");
	var issueYearTo = (strObjTo[0]);
	var issueNoTo =(strObjTo[1]);

	var issueDateFrom = document.getElementById('issuedatefrom').value;
	var issueDateTo = document.getElementById('issuedateto').value;
		
	var chkbox = document.getElementById('chkdate').checked;
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadsaveDetailsRequest;
	xmlHttp.open("GET",'issuexml.php?RequestType=GetLoadSavedDetails&issueNoFrom=' + issueNoFrom + '&issueYearFrom=' + issueYearFrom + '&issueNoTo=' + issueNoTo + '&issueYearTo=' + issueYearTo + '&issueDateFrom=' + issueDateFrom + '&issueDateTo=' + issueDateTo + '&chkbox=' + chkbox , true);
	xmlHttp.send(null);
}

	function LoadsaveDetailsRequest()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
				var XMLIssueNo = xmlHttp.responseXML.getElementsByTagName("IssueNo");						
				var XMLIssuedDate = xmlHttp.responseXML.getElementsByTagName("IssuedDate");
				var XMLSecurityNo = xmlHttp.responseXML.getElementsByTagName("SecurityNo");
				var XMLintStatus = xmlHttp.responseXML.getElementsByTagName("intStatus");
								
				 var strText =  "<table id=\"tblIssueDetails\" width=\"932\" cellpadding=\"0\" cellspacing=\"0\">"+
								"<tr>"+
								  "<td width=\"21%\" height=\"33\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Issue No</td>"+
								  "<td width=\"37%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Date</td>"+
								  "<td width=\"42%\" bgcolor=\"#498CC2\" class=\"normaltxtmidb2\">Security No</td>"+
								 "</tr>";
				for (var loop =0; loop < XMLIssueNo.length; loop ++)	
				{
					strText +="<tr>"+
								  "<td class=\"normalfntMid\"><a target=\"_blank\" href=\"issuenote.php?issueNo=" + XMLIssueNo[loop].childNodes[0].nodeValue + "\">"+XMLIssueNo[loop].childNodes[0].nodeValue+"</a></td>"+
								  "<td class=\"normalfntMid\">"+XMLIssuedDate[loop].childNodes[0].nodeValue+"</td>"+
								  "<td class=\"normalfnt\">"+XMLSecurityNo[loop].childNodes[0].nodeValue+"</td>"+
								  "</tr>";
				}
				strText += "</table>";
				document.getElementById("divtblIssueDetails").innerHTML=strText;
			}
		}		
	}
//End - Load saved details in when click Search button in issues list.php form

//Start -Save part with arrays
function saveBinDetails()
{
	//alert ("Bin Allocated!!!!");
}

function saveIssuedetails()
{	
mainStores=document.getElementById('cboMainStores').value;

	validateCount = 0;
	validateBinCount = 0;
	var productionId = document.getElementById('cboprolineno').value;
	var securityNo = document.getElementById('txtSecurityNo').value;
	
	
		//hem-30/09/2010-----------------
		var url=pub_IssueUrl+"issuexml.php";
		url=url+"?RequestType=SaveIssueHeader";
		url += '&issueNo='+issueNo;
		url += '&issueYear='+issueYear;
		url += '&productionId='+productionId;
		url += '&securityNo='+URLEncode(securityNo);
		
		var htmlobj=$.ajax({url:url,async:false});
		//-------------------------------
	
	
	/*hem-30/09/2010
	createXMLHttpRequest();
	xmlHttp.open("GET" ,'issuexml.php?RequestType=SaveIssueHeader&issueNo=' + issueNo + '&issueYear=' + issueYear + '&productionId=' + productionId + '&securityNo=' +securityNo   ,true)
	xmlHttp.send(null);	 */
	
	
	
	
	for (loop = 0 ; loop < Materials.length ; loop ++)
	{
		var details = Materials[loop] ;
		
		if 	(details!=null)
		{
			//var details = Materials[loop] ;
			var itemdDetailID = details[0] ; // Mat ID
			var color = details[1]; // Color
			var size = details[2] ;// Size
			var BuyerPoNo = details[3]; // Buyer PO

			var qty = details[4] ; // Default Qty
			var binArray = details[5] ;
			var mrnNo  =details[6] ;
			var styleId  =details[7] ; 
			var Unit  =details[8];
			var FabricRollArray		= details[9];
			var grnNo = details[10];
			var grnType = details[11];
			validateCount++;

			
			//hem-30/09/2010-----------------
			var url=pub_IssueUrl+"issuexml.php";
			url=url+"?RequestType=SaveIssueDetails";
			url += '&issueNo='+issueNo;
			url += '&issueYear='+issueYear;
			url += '&mrnNo='+mrnNo;
			url += '&styleId='+URLEncode(styleId);
			url += '&BuyerPoNo='+URLEncode(BuyerPoNo);
			url += '&itemdDetailID='+itemdDetailID;
			url += '&color='+URLEncode(color);
			url += '&size='+URLEncode(size);
			url += '&qty='+qty;
			url += '&grnNo='+grnNo;
			url += '&grnType='+grnType;
			
			var htmlobj=$.ajax({url:url,async:false});
			//-------------------------------
		
				/*hem-30/09/2010
				createXMLHttpRequest2(loop);
				xmlHttp2[loop].open("GET",'issuexml.php?RequestType=SaveIssueDetails&issueNo=' + issueNo + '&issueYear=' + issueYear + '&mrnNo=' + mrnNo + '&styleId=' + URLEncode(styleId) +'&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&itemdDetailID=' + itemdDetailID + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&qty=' + qty , true);
				xmlHttp2[loop].send(null);*/
				
//Start-fabric roll Save part
try{
		for(var rollLoop=0;rollLoop < FabricRollArray.length;rollLoop++)
		{
			var fabricRolldetails 	= FabricRollArray[rollLoop];
			var rollSerialNo	= fabricRolldetails[0];
			var rollNo			= fabricRolldetails[1];
			var batchNo			= fabricRolldetails[2];
			var rollIssueQty 	= fabricRolldetails[3];
			
			//hem-30/09/2010-----------------
			var url=pub_IssueUrl+"issuexml.php";
			url=url+"?RequestType=SaveFabricRollDetails";
			url += '&issueNo='+issueNo;
			url += '&issueYear='+issueYear;
			url += '&mrnNo='+mrnNo;
			url += '&rollSerialNo='+rollSerialNo;
			url += '&rollNo='+rollNo;
			url += '&styleId='+URLEncode(styleId);
			url += '&BuyerPoNo='+URLEncode(BuyerPoNo);
			url += '&itemdDetailID='+itemdDetailID;
			url += '&color='+URLEncode(color);
			url += '&size='+URLEncode(size);
			url += '&batchNo='+batchNo;
			url += '&rollIssueQty='+rollIssueQty;
			
			var htmlobj=$.ajax({url:url,async:false});
			//-------------------------------
		
				/*hem-30/09/2010
				createXMLHttpRequest5(rollLoop);
				xmlHttp5[rollLoop].open("GET",'issuexml.php?RequestType=SaveFabricRollDetails&issueNo='+issueNo+ '&issueYear='+issueYear+ '&mrnNo='+mrnNo+ '&rollSerialNo='+rollSerialNo+ '&rollNo='+rollNo+ '&styleId='+URLEncode(styleId)+ '&BuyerPoNo='+URLEncode(BuyerPoNo)+ '&itemdDetailID='+itemdDetailID+ '&color='+URLEncode(color)+ '&size='+URLEncode(size)+ '&batchNo='+batchNo+ '&rollIssueQty='+rollIssueQty, true);
				xmlHttp5[rollLoop].send(null);*/
		}
}
	catch(err)
	{
	}
	
//End-fabric roll Save part

			if(pub_commonBin==0){		
				for (i = 0; i < binArray.length; i++)
				{					
						var Bindetails 	= binArray[i];
						var binId 		= Bindetails[0]; // binId
						var mainStores 	= Bindetails[1]; // mainStores
						var subStores 	= Bindetails[2];// subStores
						var location 	= Bindetails[3]; // location
						var issueQty 	= Bindetails[4]; // issueQty
						var units    	= Bindetails[6];
						var subCatID    = Bindetails[7]; //SubCategory
						validateBinCount++;
						
						
			//hem-30/09/2010-----------------
			var url=pub_IssueUrl+"issuexml.php";
			url=url+"?RequestType=SaveBinDetails";
			url += '&issueNo='+issueNo;
			url += '&Year='+issueYear;
			url += '&mainStores='+mainStores;
			url += '&subStores='+subStores;
			url += '&location='+location;
			url += '&binId='+binId;
			url += '&styleId='+URLEncode(styleId);
			url += '&BuyerPoNo='+URLEncode(BuyerPoNo);
			url += '&itemdDetailID='+itemdDetailID;
			url += '&color='+URLEncode(color);
			url += '&size='+URLEncode(size);
			url += '&issueQty='+issueQty;
			url += '&units='+units;
			url += '&subCatID='+subCatID;
			url += '&grnNo='+grnNo;
			url += '&grnType='+grnType
			var htmlobj=$.ajax({url:url,async:false});
			//-------------------------------
		
				/*hem-30/09/2010
						createXMLHttpRequest4(i);					
						xmlHttp4[i].open("GET",'issuexml.php?RequestType=SaveBinDetails&issueNo=' + issueNo + '&Year=' + issueYear + '&mainStores=' + mainStores + '&subStores=' + subStores + '&location=' + location + '&binId=' + binId + '&styleId=' + URLEncode(styleId) + '&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&itemdDetailID=' + itemdDetailID + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&issueQty=' + issueQty + '&units=' + units + '&subCatID=' +subCatID , true);
						xmlHttp4[i].send(null);*/
				}
			}
			else{
			//hem-30/09/2010-----------------
			var url=pub_IssueUrl+"issuexml.php";
			url=url+"?RequestType=SaveBinDetails";
			url += '&issueNo='+issueNo;
			url += '&Year='+issueYear;
			url += '&mainStores='+mainStores;
			url += '&subStores='+subStores;
			url += '&location='+location;
			url += '&binId='+binId;
			url += '&styleId='+URLEncode(styleId);
			url += '&BuyerPoNo='+URLEncode(BuyerPoNo);
			url += '&itemdDetailID='+itemdDetailID;
			url += '&color='+URLEncode(color);
			url += '&size='+URLEncode(size);
			url += '&issueQty='+qty;
			url += '&units='+Unit;
			url += '&commonBin='+pub_commonBin;
			url += '&subCatID='+subCatID;
			url += '&grnNo='+grnNo;
			url += '&grnType='+grnType
			
			var htmlobj=$.ajax({url:url,async:false});
			//-------------------------------
		
				/*hem-30/09/2010
						createXMLHttpRequest4(1);						
						xmlHttp4[1].open("GET",'issuexml.php?RequestType=SaveBinDetails&issueNo=' + issueNo + '&Year=' + issueYear + '&mainStores=' + mainStores + '&subStores=' + subStores + '&location=' + location + '&binId=' + binId + '&styleId=' + URLEncode(styleId) + '&BuyerPoNo=' + URLEncode(BuyerPoNo) + '&itemdDetailID=' + itemdDetailID + '&color=' + URLEncode(color) + '&size=' + URLEncode(size) + '&issueQty=' + qty + '&units=' + Unit+ '&commonBin=' +pub_commonBin+ '&subCatID=' +subCatID , true);
						xmlHttp4[1].send(null);*/
						validateBinCount++;
			}
		}
	}	
	ResponseValidate();	
}
//End -Save part with arrays

//Start -Get new Issue No from setting tables 
function getIssueNo()
{
	document.getElementById("Save").style.visibility="hidden";
	
	var tbl =document.getElementById('tblIssueList');
	
	if (document.getElementById("cboprolineno").value=="")	
	{
		alert ("Please select \"Production Line No\".");
		document.getElementById("cboprolineno").focus();
		document.getElementById("Save").style.visibility="visible";
		return false;
	}
	
	if(tbl.rows.length<=1) {
		alert("No details to save.");
		document.getElementById("Save").style.visibility="visible";
		document.getElementById("cmdAddNew").focus();

		return false;
	}
	
	for (loop = 1 ;loop < tbl.rows.length; loop++)
	{
		
		var issueQty = tbl.rows[loop].cells[6].childNodes[0].value;
		
		if(pub_commonBin==0){
		var checkBinAllocate = tbl.rows[loop].cells[2].id			
			if (checkBinAllocate==0)		
			{
				alert ("Cannot save without allocation bin \nPlease allocate the bin in Line No : " + [loop] +".");
				document.getElementById("Save").style.visibility="visible";
				return false;
				break;
			}
		}
		
			if ((issueQty=="")  || (issueQty==0))
			{
				alert ("Issue qty can't be '0' or empty in Line No : " + [loop] +".");
				document.getElementById("Save").style.visibility="visible";
				return false;
				break;
			}			
	}
	showBackGroundBalck();
	checkLoop = 0;
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = LoadIssueNoRequest;
	xmlHttp.open("GET" ,'issuexml.php?RequestType=LoadIssueno' ,true);
	xmlHttp.send(null);	
}
	function LoadIssueNoRequest()
	{	
    	if(xmlHttp.readyState == 4) 
    	{
        	if(xmlHttp.status == 200) 
        	{  		
				var XMLAdmin	= xmlHttp.responseXML.getElementsByTagName("admin")[0].childNodes[0].nodeValue;			 	
				  
				if(XMLAdmin=="TRUE")
				{
					var XMLissueNo = xmlHttp.responseXML.getElementsByTagName("issueNo");
					var XMLissueYear = xmlHttp.responseXML.getElementsByTagName("issueYear");
					issueNo = parseInt(XMLissueNo[0].childNodes[0].nodeValue);				
					issueYear = parseInt(XMLissueYear[0].childNodes[0].nodeValue);
					document.getElementById("txtissueNo").value = issueYear +  "/"  + issueNo ;			
					saveIssuedetails();
				}
				else
				{
					alert("Please contact system administrator to assign new Issue No.");
					hideBackGroundBalck();
					document.getElementById("Save").style.visibility="visible";
				}
			}
		}		
	}
//End -Load MrnNo PoNo when click BuyerPoNo

//Start-Validate save datails
function ResponseValidate()
{
	
			//hem-30/09/2010-----------------
			var url=pub_IssueUrl+"issuexml.php";
			url=url+"?RequestType=ResponseValidate";
			url += '&issueNo='+issueNo;
			url += '&Year='+issueYear;
			url += '&validateCount='+validateCount;
			url += '&validateBinCount='+validateBinCount;
			
			var htmlobj=$.ajax({url:url,async:false});
			//-------------------------------
	
	/*hem-30/09/2010
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange = ResponseValidateRequest;
	xmlHttp.open("GET" ,'issuexml.php?RequestType=ResponseValidate&issueNo=' + issueNo + '&Year=' + issueYear + '&validateCount=' + validateCount + '&validateBinCount=' + validateBinCount ,true);
	xmlHttp.send(null);*/
	
	
	
/*hem-30/09/2010}
	function ResponseValidateRequest()
	{*/
			//alert(htmlobj.responseText);
	var issueHeader= htmlobj.responseXML.getElementsByTagName("recCountIssueHeader")[0].childNodes[0].nodeValue;
	var issueDetails= htmlobj.responseXML.getElementsByTagName("recCountIssueDetails")[0].childNodes[0].nodeValue;
	var binDetails= htmlobj.responseXML.getElementsByTagName("recCountBinDetails")[0].childNodes[0].nodeValue;
	
		if((issueHeader=="TRUE") && (issueDetails=="TRUE") && (binDetails=="TRUE"))
		{
			alert ("Issue No :" + document.getElementById("txtissueNo").value +  " saved successfully.");						
			document.getElementById("Save").style.visibility="hidden";
			document.getElementById("cmdAddNew").style.visibility="hidden";	
			document.getElementById("cmdAutoBin").style.visibility="hidden";	
			hideBackGroundBalck();
		}
		else 
		{
			checkLoop++;
			if(checkLoop>10){
				alert("Sorry!\nError occured while saving the data. Please save it again.");
				document.getElementById("Save").style.visibility="visible";
				hideBackGroundBalck();
				checkLoop = 0;
				return;
			}
			else{							
				ResponseValidate();							
			}
		}			
}
//End-Validate save datails

//Start - open report usimg popup window 
function ReportPopup()
{
if(document.getElementById('gotoReport').style.visibility=="hidden")
{
	document.getElementById('gotoReport').style.visibility = "visible";
	LoadPopUpIssueNo();
}
	else
	{
	document.getElementById('gotoReport').style.visibility="hidden";
	return;
	}
	
}
function LoadPopUpIssueNo()
{
	RomoveData('cboRptIssueNo');
	document.getElementById('gotoReport').style.visibility = "visible";	
	var state=document.getElementById('cboReportState').value;
	var year=document.getElementById('cboReportYear').value;
	
 	createXMLHttpRequest();
    xmlHttp.onreadystatechange = LoadPopUpIssueNoInRequest;
    xmlHttp.open("GET", 'issuexml.php?RequestType=LoadPopUpIssueNo&state='+state+'&year='+year, true);
    xmlHttp.send(null);  
}

function LoadPopUpIssueNoInRequest()
{

    if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboRptIssueNo").options.add(opt);
	
			 var XMLIssueNo= xmlHttp.responseXML.getElementsByTagName("IssueNo");
			 for ( var loop = 0; loop < XMLIssueNo.length; loop ++)
			 {
			
				var opt = document.createElement("option");
				opt.text = XMLIssueNo[loop].childNodes[0].nodeValue;
				opt.value = XMLIssueNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboRptIssueNo").options.add(opt);
			 }
			 
		}
	}
}

function showReport()
{
	var IssueNo		= document.getElementById('txtissueNo').value;
	if(IssueNo==""){alert("Sorry!\nNo saved details appear to view.");return;}
	if(IssueNo!="0"){			
		newwindow=window.open('issuenote.php?issueNo='+IssueNo,'name');
			if (window.focus) {newwindow.focus()}
	}
}

function PrintSticker()
{	
	var IssueNo		= document.getElementById('txtissueNo').value;
	if(IssueNo==""){alert("Sorry!\nNo saved details appear to view.");return;}
	if(IssueNo!="0"){			
		newwindow=window.open('rptrollloadingslip.php?issueNo='+IssueNo,'name');
			if (window.focus) {newwindow.focus()}
	}
}
 function setStockTransaction(obj)
 {	
	 var row		= obj.parentNode.parentNode.parentNode;	 
	 var matID		= row.cells[1].id;
	 var color		= URLEncode(row.cells[2].childNodes[0].nodeValue);
	 var size		= URLEncode(row.cells[3].childNodes[0].nodeValue);
 	 var styleID	= row.cells[8].id;
	 var buyerPO	= URLEncode(row.cells[9].childNodes[0].nodeValue);
	 var grnNo 		= row.cells[10].childNodes[0].nodeValue;
	 var grnYear	= row.cells[11].childNodes[0].nodeValue;
	 var type 		= 'ISSUE';
	 var store 		= document.getElementById('cboMainStores').value;
	 var grnType    = row.cells[15].id; 
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
				 
				 
				// createStockRow(typeInf,date,qty);
				
				var tbl = document.getElementById('stockBalance');
				var lastRow = tbl.rows.length;
				var row = tbl.insertRow(lastRow);
			
				
						tbl.rows[loop].className = "";
						if ((loop % 2) == 1)
						{
							tbl.rows[loop].className="odd"; ///normalfnt2BITAB/backcolorGreen
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
		         "<img src=\"../images/cross.png\" alt=\"close\" width=\"17\" height=\"17\" class=\"mouseover\" "+
				 "onClick=\"closeLayerByName('itemSub');\" />"+
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
     "<td width=\"46%\"><div align=\"right\"><img src=\"../images/close.png\" alt=\"close\" "+
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
 
function SearchPopUp()
{	
if(document.getElementById('NoSearch').style.visibility=="hidden")
{
	document.getElementById('NoSearch').style.visibility = "visible";
	LoadPopUpNo();
}
	else
	{
	document.getElementById('NoSearch').style.visibility="hidden";
	return;
	}	
}

function LoadPopUpNo()
{	
	RomoveData('cboNo');
	document.getElementById('NoSearch').style.visibility = "visible";	
	var state=document.getElementById('cboState').value;
	var year=document.getElementById('cboYear').value;
	
 	createXMLHttpRequest();
    xmlHttp.onreadystatechange = LoadPopUpJobNoRequest;
    xmlHttp.open("GET", 'issuexml.php?RequestType=LoadPopUpIssueNo&state='+state+'&year='+year, true);
    xmlHttp.send(null); 
	
}

function LoadPopUpJobNoRequest(){
	if(xmlHttp.readyState == 4){
        if(xmlHttp.status == 200){  
		
				var opt = document.createElement("option");
				opt.text = "Select";
				opt.value = "0";
				document.getElementById("cboNo").options.add(opt);
	
			 var XMLIssueNo= xmlHttp.responseXML.getElementsByTagName('IssueNo');
			 for ( var loop = 0; loop < XMLIssueNo.length; loop ++){
			
				var opt = document.createElement("option");
				opt.text = XMLIssueNo[loop].childNodes[0].nodeValue;
				opt.value = XMLIssueNo[loop].childNodes[0].nodeValue;
				document.getElementById("cboNo").options.add(opt);
			 }			 
		}
	}
}

function loadPopUpReturnToStores(){

	document.getElementById('NoSearch').style.visibility = "hidden";	
	var No=document.getElementById('cboNo').value;
	var Year=document.getElementById('cboYear').value;
	if (No=="")return false;	
	
	createXMLHttpRequest2(1);
	xmlHttp2[1].onreadystatechange=LoadHeaderDetailsRequest;
	xmlHttp2[1].open("GET",'issuexml.php?RequestType=LoadPopUpHeaderDetails&No=' +No+ '&Year=' +Year ,true);
	xmlHttp2[1].send(null);
	
	createXMLHttpRequest2(2);
	xmlHttp2[2].onreadystatechange=LoadDetailsRequest;
	xmlHttp2[2].open("GET",'issuexml.php?RequestType=LoadPopUpDetails&No=' +No+ '&Year=' +Year ,true);
	xmlHttp2[2].send(null);
}
	function LoadHeaderDetailsRequest(){
		if (xmlHttp2[1].readyState==4){
			if (xmlHttp2[1].status==200){
				
			var XMLIssueNo 		= xmlHttp2[1].responseXML.getElementsByTagName("IssueNo")[0].childNodes[0].nodeValue;				
			var XMLStatus 		= parseInt(xmlHttp2[1].responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue);
			var XMLProdLineNo 	= xmlHttp2[1].responseXML.getElementsByTagName('ProdLineNo')[0].childNodes[0].nodeValue;				
			var XMLformatedDate = xmlHttp2[1].responseXML.getElementsByTagName('formatedDate')[0].childNodes[0].nodeValue;
			var XMLSecurityNo	= xmlHttp2[1].responseXML.getElementsByTagName('SecurityNo')[0].childNodes[0].nodeValue;
				
				document.getElementById("txtissueNo").value =XMLIssueNo;
				document.getElementById('txtSecurityNo').value =XMLSecurityNo ;
				document.getElementById('cboprolineno').value =XMLProdLineNo ;
				
				switch (XMLStatus){						
					case 1:	
						document.getElementById("Save").style.visibility="hidden";
						document.getElementById("cmdAutoBin").style.visibility="hidden";	
						document.getElementById("cmdAddNew").style.visibility="hidden";	
						break;				
					case 10:						
						document.getElementById("Save").style.visibility="hidden";
						document.getElementById("cmdAddNew").style.visibility="hidden";	
						break;							
				}
			}
		}		
	}
	
	function LoadDetailsRequest()
	{
		if (xmlHttp2[2].readyState==4)
		{
			if (xmlHttp2[2].status==200)
			{	
				RemoveAllRows('tblIssueList');
				var tbl 				= document.getElementById('tblIssueList');
			//	pub_commonBin		= document.getElementById('commonBinID').title;
				var XMLDescription 		= xmlHttp2[2].responseXML.getElementsByTagName('Description');
				var XMLItemDescription 	= xmlHttp2[2].responseXML.getElementsByTagName('ItemDescription');				
				var XMLColor 			= xmlHttp2[2].responseXML.getElementsByTagName('Color');
				var XMLSize 			= xmlHttp2[2].responseXML.getElementsByTagName('Size');
				var XMLIssueQty 		= xmlHttp2[2].responseXML.getElementsByTagName('IssueQty');
				var XMLMatDetailID 		= xmlHttp2[2].responseXML.getElementsByTagName('MatDetailID');				
				var XMLMrnNo 			= xmlHttp2[2].responseXML.getElementsByTagName('MrnNo');
				var XMLMrnYear 			= xmlHttp2[2].responseXML.getElementsByTagName('MrnYear');
				var XMLBuyerPONO 		= xmlHttp2[2].responseXML.getElementsByTagName('BuyerPONO');
				var XMLStyleId 			= xmlHttp2[2].responseXML.getElementsByTagName('StyleId');
				var XMLMrnQty 			= xmlHttp2[2].responseXML.getElementsByTagName('MrnQty');
				var XMLunit				= xmlHttp2[2].responseXML.getElementsByTagName('Unit');
				var XMLSCno				= xmlHttp2[2].responseXML.getElementsByTagName('SCNo');
				var XMLGRNno				= xmlHttp2[2].responseXML.getElementsByTagName('grnNo');
				var XMLstrGRNType				= xmlHttp2[2].responseXML.getElementsByTagName('strGRNType');
				
				for (loop=0;loop<XMLStyleId.length;loop++)
				{
					
				var lastRow = tbl.rows.length;	
				var row = tbl.insertRow(lastRow);
				
				row.className = "bcgcolor-tblrowLiteBlue";	
				
				var celledit = row.insertCell(0);
				celledit.id=mainArrayIndex;
				celledit.innerHTML = "";
				
				var cellDelete = row.insertCell(1);   
				cellDelete.innerHTML = "<div align=\"center\"><img src=\"../images/del.png\" disabled=\"disabled\" alt=\"del\" width=\"15\" height=\"15\" /></div>";
				
				var cellIssuelist = row.insertCell(2);
				cellIssuelist.className ="normalfnt";
				cellIssuelist.id =0;
				cellIssuelist.innerHTML =XMLDescription[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(3);
				cellIssuelist.className = "normalfnt";
				cellIssuelist.id=XMLMatDetailID[loop].childNodes[0].nodeValue;
				cellIssuelist.innerHTML = XMLItemDescription[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(4);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =XMLColor[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(5);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =XMLSize[loop].childNodes[0].nodeValue;
	
				var cellIssuelist = row.insertCell(6);			
				cellIssuelist.innerHTML="<input type=\"text\" style=\"width:81px;text-align:right\" class=\"txtbox\" name=\"txtIssueQty\" id=\"txtIssueQty\" value =\""+XMLIssueQty[loop].childNodes[0].nodeValue+"\" readonly=\"readonly\"/>";
				
			//	if(pub_commonBin==0)
			//	{
				var celladd = row.insertCell(7);
				celladd.innerHTML = "<img src=\"../images/plus_16.png\" alt=\"add\" disabled=\"disabled\"/>";
			//	}
			//	else 
			//	{
			//		var celladd = row.insertCell(7);
			//		celladd.innerHTML="Common Bin";
			//	}
				
				var cellIssuelist = row.insertCell(8);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.innerHTML =XMLMrnQty[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(9);
				cellIssuelist.className ="normalfntRite";
				cellIssuelist.innerHTML =XMLunit[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(10);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =XMLMrnYear[loop].childNodes[0].nodeValue+"/"+XMLMrnNo[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(11);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =XMLBuyerPONO[loop].childNodes[0].nodeValue;
				
				var cellIssuelist = row.insertCell(12);
				cellIssuelist.className ="normalfntMid";
				cellIssuelist.innerHTML =XMLStyleId[loop].childNodes[0].nodeValue;
				
				var cellSCno = row.insertCell(13);
				cellSCno.className ="normalfntMid";
				cellSCno.innerHTML =XMLSCno[loop].childNodes[0].nodeValue;
				
				var cellGRNno = row.insertCell(14);
				cellGRNno.className ="normalfntMid";
				cellGRNno.innerHTML =XMLGRNno[loop].childNodes[0].nodeValue;
				
				var cellGRNno = row.insertCell(15);
				cellGRNno.className ="normalfnt";
				cellGRNno.innerHTML =XMLstrGRNType[loop].childNodes[0].nodeValue;
				
				}
			}
		}
	}

function Cancel()
{	
	var No = document.getElementById("txtissueNo").value;
	
	createXMLHttpRequest2(4);
	xmlHttp2[4].onreadystatechange=CancelRequest;
	xmlHttp2[4].open("GET",'issuexml.php?RequestType=Cancel&No=' +No ,true);
	xmlHttp2[4].send(null);
}

	function CancelRequest()
	{
		if (xmlHttp2[4].readyState==4)
		{
		 	if (xmlHttp2[4].status==200)
			{
				var intConfirm = xmlHttp2[4].responseText;
				
				if (intConfirm=="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n1")
				{	
					alert ("Return No : " + document.getElementById("txtissueNo").value +  "  canceled successfully.");
					document.getElementById("Save").style.visibility="hidden";						
					document.getElementById("cmdCancel").style.visibility="hidden";	
				}
					
			}
		}
	}
	
function OPenFabricRollInspection(obj,index){
	var rw = obj.parentNode.parentNode;	
	Pub_PopUprowIndex	= obj.parentNode.parentNode.rowIndex;
	Pub_popUoRollIndex	= index;
	/*var styleID =rw.cells[12].lastChild.nodeValue;
	var buyerPoNo =rw.cells[11].lastChild.nodeValue;
*/
	var styleID =rw.cells[12].id;
	var buyerPoNo =rw.cells[11].id;

	var matdetailId = rw.cells[3].id;	
	var color = rw.cells[4].lastChild.nodeValue;
	var category="ISSUE";
	createXMLHttpRequest();	
	xmlHttp.onreadystatechange=LoadStockDetailsRequest;
	xmlHttp.open("GET",'../fabricrollinspectionpopup/fabricrollinspectionpopup.php?StyleID=' +URLEncode(styleID)+ '&BuyerPoNo=' +URLEncode(buyerPoNo)+ '&MatdetailID=' +matdetailId+ '&Color=' +URLEncode(color)+ '&category=' +URLEncode(category) ,true);
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

	var tbl = document.getElementById('IssueItem');
		
	for(loop = 1;loop<tbl.rows.length;loop++)
	{
		if(obj.checked){
			tbl.rows[loop].cells[0].childNodes[0].checked = true;
		}
		else
			tbl.rows[loop].cells[0].childNodes[0].checked= false;
			
	}	
}

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
	//popupbox.innerHTML = "<p align=\"center\">Please wait.....</p>",
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
//------------hem-29/09/2010-----------
function closeFindPO()
{
	document.getElementById('NoSearch').style.visibility = "hidden";	
}

function ClearMainGrid(obj)
{
	var tbl = document.getElementById('tblIssueList');
	if(tbl.rows.length>1)
	{
		//if(confirm('This action will clear your grid data.\nAre you sure you want to proceed this.'))
			RemoveAllRows('tblIssueList');	
			//document.getElementById('cboMainStores').value= obj;
	}
	
}

function ShowPopItems()
{
	if(document.getElementById('cboMainStores').value=="")
	{
		alert("Please select the 'Main Store'.");
		document.getElementById('cboMainStores').focus();
		return;
	}
	showBackGround('divBG',0);
	var url = "issuePopItem.php?";
		
	htmlobj=$.ajax({url:url,async:false});
	drawPopupBox(954,442,'frmPopItem',1);
	document.getElementById('frmPopItem').innerHTML = htmlobj.responseText;	
	
	LoadStyles();
	LoadMaterials();
	ClearTable("IssueItem");
	LoadMrnNoDirectly();
	LoadStyleNo();
}
function CloseOSPopUp(LayerId)
{
	try
	{
		var box = document.getElementById(LayerId);
		box.parentNode.removeChild(box);
		hideBackGround('divBG');
	}
	catch(err)
	{        
	}	
}
function ClearTable(tblName)
{
	$("#"+tblName+" tr:gt(0)").remove();
}

function autoBin()
{
	showBackGroundBalck();
	var mainstore = document.getElementById('cboMainStores').value;
	if(mainstore=="")
	{
		alert("Please select the 'Main Store'.");
		document.getElementById('cboMainStores').focus();
		hideBackGroundBalck();
		return;
	}
	
	var tbl = document.getElementById('tblIssueList');
	var rwCount = tbl.rows.length;
	if(rwCount==1)
	{
		alert('Please add item(s) to assign bin');
		hideBackGroundBalck();
		return;
	}
	
	for(var loop=1;loop<rwCount;loop++)
	{
		if(tbl.rows[loop].cells[2].id==0)	
		{
			var styleId = tbl.rows[loop].cells[12].id;
			var buyerPo = URLEncode(tbl.rows[loop].cells[11].id);
			var matId   = tbl.rows[loop].cells[3].id;
			var color = (tbl.rows[loop].cells[4].innerHTML);
			var size =  (tbl.rows[loop].cells[5].innerHTML);
			var grnNo = URLEncode(tbl.rows[loop].cells[14].innerHTML)
			var grnType = tbl.rows[loop].cells[15].id;
			var issueQty = tbl.rows[loop].cells[6].childNodes[0].value;
			var units = tbl.rows[loop].cells[9].innerHTML;
			var index =  tbl.rows[loop].cells[1].id
			var url = 'issuexml.php?RequestType=getItemStockQty&mainstore='+mainstore+'&styleId='+styleId+'&buyerPo='+buyerPo+'&matId='+matId+'&color='+URLEncode(color)+'&size='+URLEncode(size)+'&grnNo='+grnNo+'&grnType='+grnType+'&issueQty='+issueQty;
			var htmlobj=$.ajax({url:url,async:false});
			
			var resResult = htmlobj.responseXML.getElementsByTagName("result")[0].childNodes[0].nodeValue;
			if(resResult == 'true')
			{
				var BinMaterials = [];
				var mainBinArrayIndex = 0;
				var Bindetails = [];
				Bindetails[0] =   htmlobj.responseXML.getElementsByTagName("Bin")[0].childNodes[0].nodeValue; // binId
				Bindetails[1] =   mainstore; // mainStores
				Bindetails[2] =   htmlobj.responseXML.getElementsByTagName("SubStore")[0].childNodes[0].nodeValue;// subStores
				Bindetails[3] =  htmlobj.responseXML.getElementsByTagName("Location")[0].childNodes[0].nodeValue; // location
				Bindetails[4] =  issueQty; // issueQty
				Bindetails[6] =  units; //units
				Bindetails[7] = htmlobj.responseXML.getElementsByTagName("subCategory")[0].childNodes[0].nodeValue; //Sub category id
				BinMaterials[mainBinArrayIndex] = Bindetails;
				Materials[index][5] = BinMaterials;
				tbl.rows[loop].className = "bcgcolor-tblrowLiteBlue";
				tbl.rows[loop].cells[2].id=1;	
			}
			else
			{
				alert("Item :"+tbl.rows[loop].cells[3].innerHTML+" Color :"+color+" Size :"+size+" do not have stock");
			}
		}
	}
	hideBackGroundBalck();
}