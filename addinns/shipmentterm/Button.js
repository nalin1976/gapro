var pub_stermPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url = pub_stermPath+"/addinns/shipmentterm/"
var xmlHttp;

//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(trim(document.getElementById('shipmentTerm_txtshipmentcode').value)=="")
	{
		alert("Please enter  \"Shipment Code\".");	
		document.getElementById('shipmentTerm_txtshipmentcode').select();
		return false;
	}
	else if(trim(document.getElementById('shipmentTerm_txtshipmentmode').value)=="")
	{
		alert("Please enter  \"Shipment Term\".");	
		document.getElementById('shipmentTerm_txtshipmentmode').select();
		return false;
	}	
	else if(isNumeric(trim(document.getElementById('shipmentTerm_txtshipmentmode').value)))
	{
		alert("Shipment Term must be an \"Alphanumeric\" value.");
		document.getElementById('shipmentTerm_txtshipmentmode').select();
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
  		if(document.getElementById("shipmentTerm_cboshipment").value=="")			
		strCommand="New";
			
		var url=pub_url+"Button.php";
		url=url+"?q="+strCommand;

		if(strCommand=="Save")
		{ 		
			url+="&shipmentTerm_cboshipment="+document.getElementById("shipmentTerm_cboshipment").value;			
			url+="&strShipmentTerm="+URLEncode(document.getElementById("shipmentTerm_txtshipmentmode").value.trim());	
			url+="&strShipmentCode="+URLEncode(document.getElementById('shipmentTerm_txtshipmentcode').value.trim());
		}
		else
		{
			url+="&shipmentTerm_cboshipment="+document.getElementById("shipmentTerm_cboshipment").value;
			url+="&strShipmentTerm="+URLEncode(document.getElementById("shipmentTerm_txtshipmentmode").value.trim());	
			url+="&strShipmentCode="+URLEncode(document.getElementById('shipmentTerm_txtshipmentcode').value.trim());
		}
		
		if(document.getElementById("shipmentTerm_chkActive").checked==true)
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
		document.getElementById("shipmentTerm_cboshipment").value="";	
		document.getElementById("shipmentTerm_cboshipment").text="";	
		document.getElementById("shipmentTerm_txtshipmentmode").value="";	
		ClearShipTermForm();
	} 
}

function ClearShipTermForm()
{	
	document.frmshipmentTerm.reset();
	loadCombo('SELECT strShipmentTermId,strShipmentTerm FROM shipmentterms  order by strShipmentTerm','shipmentTerm_cboshipment');
	document.getElementById('shipmentTerm_txtshipmentcode').focus();
}
	
function ClearShipTermForm1()
{	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("shipmentTerm_cboshipment").innerHTML  = xmlHttp.responseText;
			document.getElementById('shipmentTerm_txtshipmentmode').focus();
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
	
//delete data
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

	if(strCommand=="Delete") 		
		url=url+"&shipmentTerm_cboshipment="+document.getElementById("shipmentTerm_cboshipment").value;

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
	
function ClearForm()
{
	document.frmshipmentTerm.reset();
	loadCombo('SELECT strShipmentTermId,strShipmentTerm FROM shipmentterms  order by strShipmentTerm','shipmentTerm_cboshipment');
	document.getElementById('shipmentTerm_txtshipmentcode').focus();
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

function getshipmentDetails()
{    
	var Shipmentload = document.getElementById('shipmentTerm_cboshipment').value;
	if(Shipmentload.trim()=="")
		return false;

	createXMLHttpRequest();
	xmlHttp.onreadystatechange =  ShowshipmentDetails;
	xmlHttp.open("GET", pub_url+'shipmentTermmiddle.php?Shipmentload=' + Shipmentload, true);
	xmlHttp.send(null);	
}

function ShowshipmentDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("ShipmentTerm");
			document.getElementById('shipmentTerm_txtshipmentmode').value = XMLLoad[0].childNodes[0].nodeValue;			
			var XMLShipmentCode = xmlHttp.responseXML.getElementsByTagName("ShipmentCode");
			document.getElementById('shipmentTerm_txtshipmentcode').value = XMLShipmentCode[0].childNodes[0].nodeValue;			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("shipmentTerm_chkActive").checked=true;	
			else
				document.getElementById("shipmentTerm_chkActive").checked=false;	
		}
	}
}
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('shipmentTerm_cboshipment').value=="")
	{
		alert("Please select  \"Shipment Term \".");
	}
	else
	{
		var sname = document.getElementById("shipmentTerm_cboshipment").options[document.getElementById('shipmentTerm_cboshipment').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ sname+" \" ?");
		if (r==true)		
			DeleteData(strCommand);			
	}		
}

function loadReport()
{ 
	var shipmentTerm_cboshipment = document.getElementById('shipmentTerm_cboshipment').value;
	window.open(pub_url+"ShipmentTermsReport.php?shipmentTerm_cboshipment=" + shipmentTerm_cboshipment,'new'); 
}	
	
function ValidateSave()
{	
	var x_id = document.getElementById("shipmentTerm_cboshipment").value
	var x_name = document.getElementById("shipmentTerm_txtshipmentmode").value
	var x_code = document.getElementById("shipmentTerm_txtshipmentcode").value
	
	var x_find = checkInField('shipmentterms','strShipmentTerm',x_name,'strShipmentTermId',x_id);
	if(x_find)
	{
		alert(" \""+x_name+ " \" is already exist.");	
		document.getElementById("shipmentTerm_txtshipmentmode").focus();
		return false;
	}
	
	var x_find = checkInField('shipmentterms','strCode',x_code,'strShipmentTermId',x_id);
	if(x_find)
	{
		alert(" \""+x_code+ " \" is already exist.");	
		document.getElementById("shipmentTerm_txtshipmentcode").focus();
		return false;
	}
	return true;	
}