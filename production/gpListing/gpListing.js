var xmlHttpreq = [];
var xmlHttp;
var pub_url = "/gapro/production/gpListing/";

function ReloadPage()
{
	document.frmGPListing.submit();
}

function ClearDate(obj)
{
	if(obj.checked)
	{
		GetCurrentDate();
	}
	else
	{
		document.getElementById('txtDateFrom').value = "";
		document.getElementById('txtDateTo').value = "";
	}
}

function GetCurrentDate()
{
	var url = "gpListing_xml.php?RequestType=URLGetCurrentDate";
	var htmlobj = $.ajax({url:url,async:false});
	var XMLCurrentDate = htmlobj.responseXML.getElementsByTagName("CurrentDate");
	document.getElementById('txtDateFrom').value = XMLCurrentDate[0].childNodes[0].nodeValue;
	document.getElementById('txtDateTo').value = XMLCurrentDate[0].childNodes[0].nodeValue;
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
//------------------------------------------------------------------------------------------------------------
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
//----------Load Po No & Style-------------------------------------------------------------------------------------
function loadStyle()
{

	var factoryID=document.getElementById("cboFactory").value;
	createNewXMLHttpRequest(0);
	xmlHttpreq[0].onreadystatechange = HandleStyle;

	xmlHttpreq[0].open("GET",pub_url+'gpListing_xml.php?RequestType=loadStyle&factoryID='+ factoryID ,true);
	xmlHttpreq[0].send(null);
}
//------------------------------
function HandleStyle()
{
	if(xmlHttpreq[0].readyState == 4) 
	{
		if(xmlHttpreq[0].status == 200) 
		{
			//alert(xmlHttpreq[0].responseText);
		 var XMLStyle = xmlHttpreq[0].responseXML.getElementsByTagName("style");
			 document.getElementById('cboStyle').innerHTML= "";
		//	clearFirstGrid();  
		//	clearSecondGrid();  
			 document.getElementById('cboStyle').innerHTML= XMLStyle[0].childNodes[0].nodeValue;
		}
	}		
}
//----------Load Grid--------------------------------------------------------------------------------------
//Load Events Existing for a Particular Customer & LeadTime
function LoadGrid(style)
{
	//alert(style);
	xmlHttp2=GetXmlHttpObject();
	if (xmlHttp2==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	
	if(ValidateForm())
	{	
	var factoryID=document.getElementById("cboFactory").value;
	if(style==""){
	var styleNo=style;	
	}
	else{
	var styleNo=document.getElementById("cboStyle").value;
	}
	var dateFrom=document.getElementById("txtDateFrom").value;
	var dateTo=document.getElementById("txtDateTo").value;
	var gpFrom=document.getElementById("txtGoNoFrom").value;
	var gpTo=document.getElementById("txtGoNoTo").value;
	
	createNewXMLHttpRequest(1);
	xmlHttpreq[1].onreadystatechange = HandleLoadGrid ;
	xmlHttpreq[1].open("GET",pub_url+'gpListing_xml.php?RequestType=LoadGrid&factoryID='+ factoryID + '&dateFrom='+ dateFrom + '&dateTo='+ dateTo + '&gpFrom='+ gpFrom + '&gpTo='+ gpTo + '&styleNo='+ styleNo ,true);
	xmlHttpreq[1].send(null);
	}
}
//------------------------------------
function HandleLoadGrid()
{
	if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        { 
			var XMLGPnumber 	= xmlHttpreq[1].responseXML.getElementsByTagName("GPnumber");
			var XMLGPYear 		= xmlHttpreq[1].responseXML.getElementsByTagName("GPYear");
			var XMLdtmDate 		= xmlHttpreq[1].responseXML.getElementsByTagName("dtmDate");
			var XMLTotQty 		= xmlHttpreq[1].responseXML.getElementsByTagName("TotQty");
			var XMLTofactory 	= xmlHttpreq[1].responseXML.getElementsByTagName("Tofactory");
			var XMLFromfactory 	= xmlHttpreq[1].responseXML.getElementsByTagName("Fromfactory");
			var XMLOrderNo 		= xmlHttpreq[1].responseXML.getElementsByTagName("OrderNo");
			var XMLStyleNo 		= xmlHttpreq[1].responseXML.getElementsByTagName("StyleNo");
			
			var tableText = "<table width=\"750\" border=\"0\" class=\"main_border_line\" id=\"tableGatePass\">"+
						"<tr>"+
							"<td height=\"20\" colspan=\"9\" class=\"sub_containers\">Gate Pass</td>"+
							"</tr>"+
							"<tr>"+
							"<td width=\"65\" class=\"grid_header\">GP No</td>"+
							"<td width=\"127\" class=\"grid_header\">To Factory</td>"+
							"<td width=\"111\" class=\"grid_header\">Order No </td>"+
							"<td width=\"123\" class=\"grid_header\">Style No </td>"+
							"<td width=\"72\" class=\"grid_header\">Date</td>"+
							"<td width=\"84\" class=\"grid_header\">Total Qty</td>"+
							"<td width=\"61\" class=\"grid_header\">View</td>"+
							"<td width=\"71\" class=\"grid_header\">Report</td>"+
						"</tr>";
								
			 for ( var loop = 0; loop < XMLFromfactory.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				
				tableText +=" <tr class=\"" + rowClass + "\">" +
							" <td class=\"normalfnt\" id=\"" + XMLGPnumber[loop].childNodes[0].nodeValue + "\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../cutting/gatepass/gatepass.php?gpnumber="+XMLGPnumber[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLGPYear[loop].childNodes[0].nodeValue+"\">"+XMLGPYear[loop].childNodes[0].nodeValue+"/"+XMLGPnumber[loop].childNodes[0].nodeValue+"</a></td>"+
							" <td class=\"normalfnt\" id=\"" + XMLFromfactory[loop].childNodes[0].nodeValue + "\" > "+ XMLFromfactory[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfnt\" > "+ XMLOrderNo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfnt\" > "+ XMLStyleNo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfnt\" id=\"" + XMLdtmDate[loop].childNodes[0].nodeValue + "\" > "+ XMLdtmDate[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntRite\" id=\"" + XMLTotQty[loop].childNodes[0].nodeValue + "\" > "+ XMLTotQty[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" id=\"\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../cutting/gatepass/gatepass.php?gpnumber="+XMLGPnumber[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLGPYear[loop].childNodes[0].nodeValue+"\"><img src=\"../../images/view2.png\" height=\"18\" border=\"0\"/></a></td>"+
							" <td class=\"normalfntMid\" id=\"\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../cutting/gatepass/rptgatepass.php?gpnumber="+XMLGPnumber[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLGPYear[loop].childNodes[0].nodeValue+"\"><img src=\"../../images/report.png\" height=\"18\" border=\"0\"/></a></td>"+
							" </tr>";
							
							
			 }
			tableText += "</table>";
		//	alert(tableText)
			document.getElementById('divcons').innerHTML=tableText;  
	//		document.getElementById('txtBundles').value= XMLSize.length;  
	//		getTotQty();

		}		
	}
}
//-------------------------------------------------------------------------------
function ValidateForm(){

	if((document.getElementById('txtDateFrom').value.trim()!=='') && (document.getElementById('txtDateTo').value.trim()!==''))
	{
		var fromdate=document.getElementById('txtDateFrom').value.trim().split("/");
		var todate=document.getElementById('txtDateTo').value.trim().split("/");
		fromdate=fromdate[2]+fromdate[1]+fromdate[0];
		todate=todate[2]+todate[1]+todate[0];
		if(fromdate > todate){
		alert("\"Date From\" cannot be greater than the \"Date To\".");
		document.getElementById('txtDateFrom').focus();
		return false;
		}
		else
		return true;
	}
	else if((document.getElementById('txtGoNoFrom').value.trim()!=='') && (document.getElementById('txtGoNoTo').value.trim()!==''))
	{
		if(document.getElementById('txtGoNoFrom').value.trim() > document.getElementById('txtGoNoTo').value.trim()){
		alert("\"GP No From\" cannot be greater than the \"GP No To\".");
		document.getElementById('txtGoNoFrom').focus();
		return false;
		}
		else
		return true;
	}
	else
		return true;
	
}
