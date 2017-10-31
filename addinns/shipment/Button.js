var xmlHttp;
var pub_smodePath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url	= pub_smodePath+"/addinns/shipment/";
//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(trim(document.getElementById('shipmentmode_txtshipmentcode').value)=="")
	{
		alert("Please enter \"Shipment Code\".");
		document.getElementById("shipmentmode_txtshipmentcode").select();
		return false;
	}
	
	else if(trim(document.getElementById('shipmentmode_txtshipmentmode').value)=="")
	{
		alert("Please enter \"Shipment Mode\".");	
		document.getElementById("shipmentmode_txtshipmentmode").select();
		return false;
	}
	else if(isNumeric(trim(document.getElementById('shipmentmode_txtshipmentmode').value)))
	{
		alert("Shipment Mode must be an \"Alphanumeric\" value.");
		document.getElementById("shipmentmode_txtshipmentmode").select();
		return false;
	}
	else if(!ValidateSave())
	{
		return;
	}
	else
	{
	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
	  
	  if(document.getElementById('shipmentmode_cboshipment').value=="")
	  strCommand="New";
	  
		var url=pub_url+"Button.php";
		url=url+"?q="+strCommand;
	
		if(strCommand=="Save"){ 
			
			url=url+"&cboshipment="+document.getElementById("shipmentmode_cboshipment").value;
			url=url+"&strCode="+document.getElementById("shipmentmode_txtshipmentcode").value.trim();
			url=url+"&strDescription="+URLEncode(document.getElementById("shipmentmode_txtshipmentmode").value.trim());		
		}
		else
		{
			url=url+"&strCode="+document.getElementById("shipmentmode_txtshipmentcode").value.trim();
			url=url+"&cboshipment="+document.getElementById("shipmentmode_cboshipment").value;
			url=url+"&strDescription="+URLEncode(document.getElementById("shipmentmode_txtshipmentmode").value.trim());
		}
	
		if(document.getElementById("shipmentmode_chkActive").checked==true)
			var intStatus = 1;	
		else
			var intStatus = 0;
		
		url=url+"&intStatus="+intStatus; 
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		alert(xmlHttp.responseText);
		ClearForm();
	} 
}

function ClearShipModeForm()
{   	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ClearShipModeForm1;
	xmlHttp.open("GET", pub_url+'Button.php?q=loadshipModes', true);
	xmlHttp.send(null);  	
}
	
function ClearShipModeForm1()
{	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("shipmentmode_cboshipment").innerHTML  = xmlHttp.responseText;			
		}
	}	
}

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
	

function DeleteData(strCommand)
{		
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
	var url=pub_url+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&cboshipment="+document.getElementById("shipmentmode_cboshipment").value;
		
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
	
function ClearForm()
{	
	document.frmshipmentMode.reset();
	loadCombo('SELECT intShipmentModeId,strDescription FROM shipmentmode order by strDescription','shipmentmode_cboshipment');
	document.getElementById("shipmentmode_txtshipmentcode").focus();
}

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

	//Loding Data
function getshipmentDetails()
{	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('shipmentmode_cboshipment').value.trim()=='')
	{
		ClearForm();
		return false;
	} 

	var shipmentload = document.getElementById('shipmentmode_cboshipment').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ShowshipmentDetails;
	xmlHttp.open("GET", pub_url+'shipmentmiddle.php?shipmentload=' + shipmentload, true);
	xmlHttp.send(null);		
}

function ShowshipmentDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Description");
			document.getElementById('shipmentmode_txtshipmentmode').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCode");
			document.getElementById('shipmentmode_txtshipmentcode').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("shipmentmode_chkActive").checked=true;	
			else
				document.getElementById("shipmentmode_chkActive").checked=false;	
		}
	}
}	
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('shipmentmode_cboshipment').value=="")
	{
		alert("Please select the \"Shipment Mode\".");
		document.getElementById('shipmentmode_cboshipment').focus();
	}
	else
	{
		var sname = document.getElementById("shipmentmode_cboshipment").options[document.getElementById('shipmentmode_cboshipment').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ sname+" \" ?");
		if (r==true)		
			DeleteData(strCommand);
	}
}

function loadReport()
{ 
    var cboshipment = document.getElementById('shipmentmode_cboshipment').value;
	window.open(pub_url+"ShipmentModeReport.php?cboshipment=" + cboshipment,'frmshipmentMode'); 
}
   
function ValidateSave()
{	
	var x_id = document.getElementById("shipmentmode_cboshipment").value;
	var x_name = document.getElementById("shipmentmode_txtshipmentmode").value.trim();
	var x_code = document.getElementById("shipmentmode_txtshipmentcode").value.trim();
	var x_find = checkInField('shipmentmode','strDescription',x_name,'intShipmentModeId',x_id);
	if(x_find)
	{
		alert(" \""+x_name+ " \" is already exist.");	
		document.getElementById("shipmentmode_txtshipmentmode").select();
		return false;
	}
	
	var x_find = checkInField('shipmentmode','strCode',x_code,'intShipmentModeId',x_id);
	if(x_find)
	{
		alert(" \""+x_code+ " \" is already exist.");	
		document.getElementById("shipmentmode_txtshipmentcode").select();
		return false;
	}
	return true;
}