var xmlHttpreq = [];
var xmlHttp;
var pub_url = "/gapro/production/finishGDRecieveListing/";

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

	xmlHttpreq[0].open("GET",pub_url+'finishGoodRcv_xml.php?RequestType=loadStyle&factoryID='+ factoryID ,true);
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
	if(style=='cboPo'){
		document.getElementById('cboStyle').value=document.getElementById('cboPo').value;
		//document.getElementById('cboStyle').onchange();
	}
	else{
		document.getElementById('cboPo').value=document.getElementById('cboStyle').value;
	}
	/*xmlHttp2=GetXmlHttpObject();
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
	var GPNo=document.getElementById('cboGPNo').value.trim();
	createNewXMLHttpRequest(1);
	xmlHttpreq[1].onreadystatechange = HandleLoadGrid ;
	xmlHttpreq[1].open("GET",pub_url+'finishGoodRcv_xml.php?RequestType=LoadGrid&factoryID='+ factoryID + '&styleNo='+ styleNo + '&dateFrom='+ dateFrom + '&dateTo='+ dateTo+'&GPNo='+GPNo ,true);
	xmlHttpreq[1].send(null);
	}*/
}
//------------------------------------
/*function HandleLoadGrid()
{
	if(xmlHttpreq[1].readyState == 4) 
    {
        if(xmlHttpreq[1].status == 200) 
        { 

	//	alert(xmlHttpreq[1].responseText);

			var XMLSerial = xmlHttpreq[1].responseXML.getElementsByTagName("Serial");
			var XMLYear = xmlHttpreq[1].responseXML.getElementsByTagName("Year");
			var XMLdtmDate = xmlHttpreq[1].responseXML.getElementsByTagName("date");
			var XMLTotQty = xmlHttpreq[1].responseXML.getElementsByTagName("TotQty");
			
			var tableText = "<table width=\"750\" border=\"0\" class=\"main_border_line\" id=\"tableGatePass\">"+
								"<tr>"+
								"<td height=\"20\" colspan=\"7\" class=\"sub_containers\">Gate Pass</td>"+
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
							" <td class=\"normalfntMid\" id=\"" + XMLSerial[loop].childNodes[0].nodeValue + "\" ><a target=\"_blank\" class=\"non-html pdf\" href=\"../finishGoodsReceive/finishGoodsReceive.php?SerialNumber="+XMLSerial[loop].childNodes[0].nodeValue+"&amp;intYear="+XMLYear[loop].childNodes[0].nodeValue+"&amp;id=1\">"+XMLYear[loop].childNodes[0].nodeValue+"/"+XMLSerial[loop].childNodes[0].nodeValue+"</a></td>"+
							" <td class=\"normalfntMid\" id=\"" + XMLdtmDate[loop].childNodes[0].nodeValue + "\" > "+ XMLdtmDate[loop].childNodes[0].nodeValue +"</td>"+
							" <td class=\"normalfntRite\" id=\"" + XMLTotQty[loop].childNodes[0].nodeValue + "\" > "+ XMLTotQty[loop].childNodes[0].nodeValue +"&nbsp;</td>"+
							
							" <td class=\"normalfntMid\" id=\"\" ><img src=\"../../images/view2.png\" height=\"18\" border=\"0\" onclick='loadData("+XMLSerial[loop].childNodes[0].nodeValue+","+XMLYear[loop].childNodes[0].nodeValue+")'\"/></td>"+
							" <td class=\"normalfntMid\" id=\"\" ><img src=\"../../images/report.png\" height=\"18\" border=\"0\" onclick='loadReport("+XMLSerial[loop].childNodes[0].nodeValue+","+XMLYear[loop].childNodes[0].nodeValue+")'/></td>"+
							" </tr>";
							
							
			 }
			tableText += "</table>";
		//	alert(tableText)
			document.getElementById('divcons').innerHTML=tableText;  
	//		document.getElementById('txtBundles').value= XMLSize.length;  
	//		getTotQty();

		}		
	}
}*/

function loadData(sNo,sYear){
	window.open("../finishGoodsReceive/finishGoodsReceive.php?SerialNumber="+sNo+"&intYear="+sYear+"&id=1",'WashReceive');
}
function loadReport(sNo,sYear){
	window.open("../finishGoodsReceive/rptFinishGoodsReceive.php?SerialNumber="+sNo+"&intYear="+sYear+"&id=1",'WashReceive');
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


function selectStyle(obj){
	var path="finishGoodRcv_xml.php?RequestType=loadStyleNo&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var sNo=htmlobj.responseXML.getElementsByTagName("sNo");
	if(sNo.length>0)
		document.getElementById('cboStyle').value= sNo[0].childNodes[0].nodeValue;
	else
		document.getElementById('cboStyle').value='';
}

function selectPo(obj){
	var path="finishGoodRcv_xml.php?RequestType=loadPoNo&po="+obj.value.trim();
	htmlobj=$.ajax({url:path,async:false});
	var sNo=htmlobj.responseXML.getElementsByTagName("sNo");
	if(sNo.length>0)
		document.getElementById('cboPo').value= sNo[0].childNodes[0].nodeValue;
	else
		document.getElementById('cboPo').value='';
}

function clearForm(){
	document.getElementById('cboPo').value='';
	document.getElementById('cboStyle').value='';
	document.getElementById('txtDateFrom').value='';
	document.getElementById('txtDateTo').value='';
	document.getElementById('cboGPNo').value='';
}