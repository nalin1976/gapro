var xmlHttpreq = [];
var xmlHttp;
var pub_fgoodGPPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];

var pub_url = pub_fgoodGPPath+"/production/washing_factoryGatepassListing/";

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

	xmlHttpreq[0].open("GET",pub_url+'finishGoodGP_xml.php?RequestType=loadStyle&factoryID='+ factoryID ,true);
	xmlHttpreq[0].send(null);
}
//------------------------------
function HandleStyle()
{
	if(xmlHttpreq[0].readyState == 4) 
	{
		if(xmlHttpreq[0].status == 200) 
		{
			 var XMLStyle = xmlHttpreq[0].responseXML.getElementsByTagName("style");
			 document.getElementById('cboStyle').innerHTML= "";
			 document.getElementById('cboStyle').innerHTML= XMLStyle[0].childNodes[0].nodeValue;
		}
	}		
}
//----------Load Grid--------------------------------------------------------------------------------------
//Load Events Existing for a Particular Customer & LeadTime
function LoadGrid(style)
{
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
	
	var url = pub_url+'finishGoodGP_xml.php?RequestType=LoadGrid&factoryID='+ factoryID + '&styleNo='+ styleNo + '&dateFrom='+ dateFrom + '&dateTo='+ dateTo;
	var htmlobj=$.ajax({url:url,async:false});
	HandleLoadGrid(htmlobj);
	}
}

function HandleLoadGrid(htmlobj)
{
	var XMLSerial 	 = htmlobj.responseXML.getElementsByTagName("Serial");
	var XMLYear 	 = htmlobj.responseXML.getElementsByTagName("Year");
	var XMLdtmDate 	 = htmlobj.responseXML.getElementsByTagName("date");
	var XMLTotQty 	 = htmlobj.responseXML.getElementsByTagName("TotQty");
	var XMLOrderNo 	 = htmlobj.responseXML.getElementsByTagName("OrderNo");
	var XMLStyleNo 	 = htmlobj.responseXML.getElementsByTagName("StyleNo");
	var XMLToFactory = htmlobj.responseXML.getElementsByTagName("ToFactory");
	
	var tableText = "<table width=\"100%\" border=\"0\" class=\"main_border_line\" id=\"tableGatePass\">"+
		"<tr>"+
			"<td height=\"20\" colspan=\"9\" class=\"sub_containers\">Gate Pass</td>"+
		"</tr>"+
		"<tr>"+
			"<td width=\"82\" class=\"grid_header\">Transf No</td>"+
			"<td width=\"157\" class=\"grid_header\">To Factory </td>"+
			"<td width=\"123\" class=\"grid_header\">Order No </td>"+
			"<td width=\"135\" class=\"grid_header\">Style No </td>"+
			"<td width=\"72\" class=\"grid_header\">Date</td>"+
			"<td width=\"72\" class=\"grid_header\">Total Qty</td>"+
			"<td width=\"56\" class=\"grid_header\">View</td>"+
			"<td width=\"67\" class=\"grid_header\">Report</td>"+
		"</tr>";
	
	for ( var loop = 0; loop < XMLSerial.length; loop ++)
	{
		if((loop%2)==0)
			var rowClass="grid_raw";
		else
			var rowClass="grid_raw2";	
	
		tableText +=" <tr class=\"" + rowClass + "\">" +
		" <td class=\"normalfntMid\" id=\"" + XMLSerial[loop].childNodes[0].nodeValue + "\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../factoryGatepasses/factoryGatepass.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"&amp;id=1\">"+XMLYear[loop].childNodes[0].nodeValue+"/"+XMLSerial[loop].childNodes[0].nodeValue+"</a></td>"+
		" <td class=\"normalfnt\" > "+ XMLToFactory[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfnt\" > "+ XMLOrderNo[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfnt\" > "+ XMLStyleNo[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntMid\" id=\"" + XMLdtmDate[loop].childNodes[0].nodeValue + "\" > "+ XMLdtmDate[loop].childNodes[0].nodeValue +"</td>"+
		" <td class=\"normalfntRite\" id=\"" + XMLTotQty[loop].childNodes[0].nodeValue + "\" > "+ XMLTotQty[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
		" <td class=\"normalfntMid\" id=\"\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../washing_factoryGatepass/factoryGatepass.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"&amp;id=1\"><img src=\"../../images/view2.png\" height=\"18\" border=\"0\"/></a></td>"+
		" <td class=\"normalfntMid\" id=\"\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../washing_factoryGatepass/rptFactoryGatepass.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"\"><img src=\"../../images/report.png\" height=\"18\" border=\"0\"/></a></td>"+
		" </tr>";
	}
	tableText += "</table>";
	document.getElementById('divcons').innerHTML=tableText;  
}

function ValidateForm()
{
	if((document.getElementById('txtDateFrom').value.trim()!=='') && (document.getElementById('txtDateTo').value.trim()!==''))
	{
		var fromdate=document.getElementById('txtDateFrom').value.trim().split("/");
		var todate=document.getElementById('txtDateTo').value.trim().split("/");
		fromdate=fromdate[2]+fromdate[1]+fromdate[0];
		todate=todate[2]+todate[1]+todate[0];
		if(fromdate > todate)
		{
			alert("\"Date From\" cannot be greater than the \"Date To\".");
			document.getElementById('txtDateFrom').focus();
			return false;
		}
		else
		return true;
	}
	else
		return true;	
}

function selectStyle(obj){
	var path="finishGoodGP_xml.php?RequestType=loadStyleNo&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var sNo=htmlobj.responseXML.getElementsByTagName("sNo");
	if(sNo.length>0)
		document.getElementById('cboStyleNo').value= sNo[0].childNodes[0].nodeValue;
	else
		document.getElementById('cboStyleNo').value='';
}
function selectPo(obj){
	var path="finishGoodGP_xml.php?RequestType=loadPoNo&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var sNo=htmlobj.responseXML.getElementsByTagName("sNo");
	if(sNo.length>0)
		document.getElementById('cboStyle').value= sNo[0].childNodes[0].nodeValue;
	else
		document.getElementById('cboStyle').value='';
}

function clearForm(){
	document.getElementById('cboFactory').value='';
	document.getElementById('cboStyle').value='';
	document.getElementById('cboStyleNo').value='';
	document.getElementById('txtDateFrom').value='';
	document.getElementById('txtDateTo').value='';
}