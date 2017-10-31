var xmlHttpreq = [];
var xmlHttp;
var pub_url = "/gapro/production/washRecevListing/";

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
	var path=pub_url+'washRcvListing_xml.php?RequestType=loadStyle&factoryID='+ factoryID ;
	
	htmlobj=$.ajax({url:path,async:false});

		 var XMLStyle = xmlHttpreq[0].responseXML.getElementsByTagName("style");
		 document.getElementById('cboStyle').innerHTML= "";
		 document.getElementById('cboStyle').innerHTML= XMLStyle[0].childNodes[0].nodeValue;
}
//----------Load Grid--------------------------------------------------------------------------------------
//Load Events Existing for a Particular Customer & LeadTime
function LoadGrid(style)
{
	
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
	
	var path=pub_url+'washRcvListing_xml.php?RequestType=LoadGrid&factoryID='+ factoryID + '&styleNo='+ styleNo + '&dateFrom='+ dateFrom + '&dateTo='+ dateTo;
	htmlobj=$.ajax({url:path,async:false});

			var XMLSerial = htmlobj.responseXML.getElementsByTagName("Serial");
			var XMLYear = htmlobj.responseXML.getElementsByTagName("Year");
			var XMLdtmDate = htmlobj.responseXML.getElementsByTagName("date");
			var XMLTotQty = htmlobj.responseXML.getElementsByTagName("TotQty");
			
			var tableText = "<table width=\"750\" border=\"0\" class=\"main_border_line\" id=\"tableGatePass\">"+
								"<tr>"+
								"<td height=\"20\" colspan=\"7\" class=\"sub_containers\">Wash Receive</td>"+
								"</tr>"+
                                "<tr>"+
                                  "<td width=\"79\" class=\"grid_header\">Serial No</td>"+
                                  "<td width=\"99\" class=\"grid_header\">Date</td>"+
                                  "<td width=\"83\" class=\"grid_header\">Total Qty</td>"+
                                  "<td width=\"69\" class=\"grid_header\">View</td>"+
                                  "<td width=\"104\" class=\"grid_header\">Report</td>"+
								  "</tr>";
								
			 for ( var loop = 0; loop < XMLSerial.length; loop ++)
			 {
				if((loop%2)==0){
				var rowClass="grid_raw"	
				}
				else{
				var rowClass="grid_raw2"	
				}
				
				tableText +=" <tr class=\"" + rowClass + "\">" +
							" <td class=\"normalfntMid\" id=\"" + XMLSerial[loop].childNodes[0].nodeValue + "\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../washReceive/washReceive.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"&amp;id=1\">"+XMLYear[loop].childNodes[0].nodeValue+"/"+XMLSerial[loop].childNodes[0].nodeValue+"</a></td>"+
							" <td class=\"normalfntMid\" id=\"" + XMLdtmDate[loop].childNodes[0].nodeValue + "\" > "+ XMLdtmDate[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntRite\" id=\"" + XMLTotQty[loop].childNodes[0].nodeValue + "\" > "+ XMLTotQty[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
							" <td class=\"normalfntMid\" id=\"\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../washReceive/washReceive.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"&amp;id=1\"><img src=\"../../images/view2.png\" height=\"18\" border=\"0\"/></a></td>"+
							" <td class=\"normalfntMid\" id=\"\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../washReceive/rptWashReceive.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"\"><img src=\"../../images/report.png\" height=\"18\" border=\"0\"/></a></td>"+
							" </tr>";
							
							
			 }
			tableText += "</table>";
		//	alert(tableText)
			document.getElementById('divcons').innerHTML=tableText;  
	//		document.getElementById('txtBundles').value= XMLSize.length;  
	//		getTotQty();

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
	else
		return true;
	
}

