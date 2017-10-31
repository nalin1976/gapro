
var xmlHttp;


//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
isValidData();		
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
var url="Button.php";
url=url+"?q="+strCommand;

	if(strCommand=="Save"){ 
		
		url=url+"&strShipmentTermId="+document.getElementById("txtshipment").value;
		url=url+"&strShipmentTerm="+document.getElementById("txtshipmentmode").value;		
	    setTimeout("location.reload(true);",100);
	}



	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);


} 

function stateChanged() 
{ 	
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 setTimeout("location.reload(true);",1000);
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
  
	var url="Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&strShipmentTermId="+document.getElementById("txtshipment").value;
		setTimeout("location.reload(true);",1000);
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	ClearForm();
	
	
}
	
	function backtopage()
	{
		window.location.href="main.php";
	}
	
	function ClearForm()
	{	
		document.getElementById("txtHint").innerHTML="";
		document.getElementById("txtshipment").value = "";
		document.getElementById("txtshipmentmode").value = "";
		
	}

//load data
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
		var Shipmentload = document.getElementById('cboshipment').value;
		if(Shipmentload)
		{
		createXMLHttpRequest();
		xmlHttp.onreadystatechange =  ShowshipmentDetails;
		xmlHttp.open("GET", 'shipment Termmiddle.php?Shipmentload=' + Shipmentload, true);
		xmlHttp.send(null); 
		}
		
	
		else
		{
			ClearForm();
		}
	}
	 

function ShowshipmentDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			   	
			var XMLLoad	= xmlHttp.responseXML.getElementsByTagName("ShipmentTermId")[0].childNodes[0].nodeValue;
			document.getElementById('txtshipment').value = XMLLoad;
				
			var XMLName	= xmlHttp.responseXML.getElementsByTagName("ShipmentTerm")[0].childNodes[0].nodeValue;
			document.getElementById('txtshipmentmode').value = XMLName;
				
				
				
			}
		}
	}
	
function ConfirmDelete(strCommand)
	{
		if(document.getElementById('txtshipment').value=="")
		{
			alert("Please Enter ShipmentTermId");
		}
		else
		{
			var r=confirm("Are You Sure Delete?");
			if (r==true)		
				DeleteData(strCommand);
				
		}
		
			
	}
	
	
	function isValidData()
	{
		if(document.getElementById('txtshipment').value=="")
		{
			alert("Please Enter ShipmentTermId");	
			return false;
		}

		else
		return true;
	}
	
	