//----------------------hem--------------------------------------------------------------------------------

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
//----------------------------------------------------------------------------------------------------
function createXMLHttpRequest2() 
{

    if (window.ActiveXObject) 
    {
        xmlHttp2 = new ActiveXObject("Microsoft.XMLHTTP");
		
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp2 = new XMLHttpRequest();
    }
}

//-----------------------------------------------------------------------------------------------------------
function loadStyle()
{
var pub_url = "/gapro/production/cutPc/";

	var styleID = document.getElementById("cboPONo").value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleLoadStyle ;
	xmlHttp.open("GET",pub_url+'xml.php?RequestType=LoadStyle&styleID='+ styleID ,true);
	xmlHttp.send(null);
}

//-----------------------------------------------------------------------------------------------------------
function HandleLoadStyle()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
		    //		alert(xmlHttp.responseText);

			var XMLStyle = xmlHttp.responseXML.getElementsByTagName("style");
		     document.getElementById('cboStyle').innerHTML = XMLStyle[0].childNodes[0].nodeValue;
		}
	}		
}

//---------------------------------------------------------------------------------------
function getGridDetails()
{
var pub_url = "/gapro/production/cutPc/";
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboStyle').value.trim()=='')
	{
	//	clearFields();
		return false;
		//setTimeout("location.reload(true);",0);
	}
	
	var year = document.getElementById("txtYear").value;
	//var style = document.getElementById("cboPONo").value;
	var style = document.getElementById("cboStyle").value;
	var TrnfInNote = document.getElementById("cboTrnfInNote").value;

	createXMLHttpRequest2();
	xmlHttp2.onreadystatechange = HandleDetailsForTransfIn ;
	xmlHttp2.open("GET",pub_url+'xml.php?RequestType=LoadGPDetailsGridShow&year='+ year +'&style='+ style +'&TrnfInNote='+ TrnfInNote ,true);
	xmlHttp2.send(null);
}

//Loading Events for Customer LeadTime
function HandleDetailsForTransfIn()
{
	if(xmlHttp2.readyState == 4) 
    {
        if(xmlHttp2.status == 200) 
        { 
	//	alert(xmlHttp2.responseText);
			//var XMLEventID = xmlHttp.responseXML.getElementsByTagName("ID");

			var XMLdate = xmlHttp2.responseXML.getElementsByTagName("date");
			var XMLfactory = xmlHttp2.responseXML.getElementsByTagName("factory");
			var XMLpONo = xmlHttp2.responseXML.getElementsByTagName("pONo");
			var XMLStyleID = xmlHttp2.responseXML.getElementsByTagName("StyleID");
			var XMLGpNo = xmlHttp2.responseXML.getElementsByTagName("GpNo");
			
			var tableText = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"tblevents\" border=\"0\">"+
                                "<tr>"+
                                  "<td width=\"10%\" height=\"18\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Note No</td>"+
                                  "<td width=\"10%\" height=\"18\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Date</td>"+
                                  "<td width=\"40%\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Source Factory</td>"+
                                  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"mainHeading2\">PO No </td>"+
                                  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Style No </td>"+
                                  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"mainHeading2\">Gate Pass </td>"+
                                  "<td width=\"10%\" bgcolor=\"#498CC2\" class=\"mainHeading2\">status</td>"+
                                "</tr>";
								
			 for ( var loop = 0; loop < XMLGpNo.length; loop ++)
			 {
				tableText +=" <tr>" +
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLdate[loop].childNodes[0].nodeValue + "\" ></td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLdate[loop].childNodes[0].nodeValue + "\" > "+ XMLdate[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLfactory[loop].childNodes[0].nodeValue + "\" > "+ XMLfactory[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLpONo[loop].childNodes[0].nodeValue + "\" > "+ XMLpONo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLStyleID[loop].childNodes[0].nodeValue + "\" > "+ XMLStyleID[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLGpNo[loop].childNodes[0].nodeValue + "\" > "+ XMLGpNo[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntMid\" align=\"center\" id=\"" + XMLGpNo[loop].childNodes[0].nodeValue + "\" ></td>"+
							
							" </tr>";
							
			 }
			tableText += "</table>";
		//	alert(tableText)
			document.getElementById('divcons').innerHTML=tableText;
		}		
	}
}
//---------------------------------------------------------------
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
//---------------------------------------------
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

//--------------------------
function ValidateHeaderDets()
{
	if (document.getElementById('cboPONo').value == "" )	
	{
		alert("Please select a PO No ");
		document.getElementById('cboPONo').focus();
		return false;
	}
	else if (document.getElementById('cboStyle').value == "" )	
	{
		alert("Please select a Style ");
		document.getElementById('cboStyle').focus();
		return false;
	}
	else if (document.getElementById('cboTrnfInNote').value == "" )	
	{
		alert("Please selecta Transfer In Note ");
		document.getElementById('cboTrnfInNote').focus();
		return false;
	}
	else{
		return true;
	}
}


//-------------------------------------------------------------------------------------------------------------------------------------

