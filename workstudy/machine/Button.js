var xmlHttp;
var pub_countryPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_countryUrl = pub_countryPath+"/workstudy/machine/";

//Insert & Update Data (Save Data)
function butCommandC(strCommand)
{ 
	if(!ValidateCountryInterface())
		return;
		
	if(!ValidateCountryBeforeSave())	
		return;

	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	}			  
			 
    if(document.getElementById("machines_cbomachineList").value==""){			
		strCommand="New";
	}
		
	var url=pub_countryUrl+"Button.php";
	url=url+"?q="+strCommand;
	
	if(strCommand=="Save"){ 
		url=url+"&cboMachineList="+document.getElementById("machines_cbomachineList").value;
		url=url+"&cboMachineCode="+URLEncode(document.getElementById("machine_txtMachineCode").value);
		url=url+"&strMachine="+URLEncode(document.getElementById("machine_txtMachine").value);	

	}	
	else
	{  
		url=url+"&cboMachineCode="+URLEncode(document.getElementById("machine_txtMachineCode").value);
		url=url+"&strMachine="+URLEncode(document.getElementById("machine_txtMachine").value);	
	}
	
	if(document.getElementById("machine_chkActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
	
	url=url+"&intStatus="+intStatus; 
	
	xmlHttp.onreadystatechange=countryStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function ValidateCountryInterface()
{
	if(document.getElementById('machine_txtMachineCode').value.trim() == "" )
	{
		alert("Please enter \"Machine Code\".");
		document.getElementById("machine_txtMachineCode").focus();
		return false;
	}
	if(document.getElementById('machine_txtMachine').value.trim() == "" )
	{
		alert("Please enter \"Machine Name\".");
		document.getElementById("machine_txtMachine").focus();
		return false;
	}

return true;
}

function ValidateCountryBeforeSave()
{	
	var x_id = document.getElementById("machines_cbomachineList").value;
	var x_name = document.getElementById("machine_txtMachineCode").value;
	
	var x_find = checkInField('ws_machinetypes','strMachineCode',x_name,'intMachineTypeId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("machine_txtMachineCode").focus();
		return false;
	}
	
	var x_id = document.getElementById("machines_cbomachineList").value;
	var x_name = document.getElementById("machine_txtMachine").value;
	
	var x_find = checkInField('ws_machinetypes','strMachineName',x_name,'intMachineTypeId',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("machine_txtMachine").focus();
		return false;
	}
	
	var x_id 	= document.getElementById("machines_cbomachineList").value;
		return true;

}

function countryStateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		alert(xmlHttp.responseText);
		ClearForm();
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
  
	var url=pub_countryUrl+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete")	
		url=url+"&cboMachineList="+document.getElementById("machines_cbomachineList").value;	

	xmlHttp.onreadystatechange=countryStateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}	

function ClearForm1()
{	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("machines_cbomachineList").innerHTML  = xmlHttp.responseText;
			document.getElementById("machine_txtMachineCode").focus();
		}
	}	
ClearForm2();		
}
	
function ClearForm2()
{	
	document.frmCountries.reset();
}
	
function backtopage()
{
	window.location.href="main.php";
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
	
function ClearForm()
{   	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ClearForm1;
	xmlHttp.open("GET", pub_countryUrl+'Button.php?q=machines', true);
	xmlHttp.send(null);  	
}

function getMachineDetails()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('machines_cbomachineList').value=='')
	{
		ClearForm();
	}
	else
	{	
		var machineID = document.getElementById('machines_cbomachineList').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowCountryDetails;
		xmlHttp.open("GET", pub_countryUrl+'machineMiddle.php?q=machines&machineID=' + machineID, true);
		xmlHttp.send(null);  
	}
}

function ShowCountryDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			document.getElementById('machine_txtMachineCode').disabled=false;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Code");
			document.getElementById('machine_txtMachineCode').value = XMLLoad[0].childNodes[0].nodeValue;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Name");
			document.getElementById('machine_txtMachine').value = XMLLoad[0].childNodes[0].nodeValue;	
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("machine_chkActive").checked=true;	
			else
				document.getElementById("machine_chkActive").checked=false;	
					
		}
	}
}
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('machines_cbomachineList').value=="")
	{
		alert("Please select a \"Country\".");
		document.getElementById('machines_cbomachineList').focus();
		return;
	}	
	else
	{
		var r=confirm("Are you sure you want to delete \""+ document.getElementById('machine_txtMachine').value +"\" ?");
		if (r==true)		
			DeleteData(strCommand);				
	}
}
	
function checkvalue()
{
	if(document.getElementById('machine_txtMachineCode').value!="")
		document.getElementById("machine_txtMachine").focus();
}
//-------------------------------------	report-----------------------------------------------
function loadReport()
{ 
	    var cboMachineList = document.getElementById('machines_cbomachineList').value;
		window.open(pub_countryUrl+"CountryReport.php?cboMachineList=" + cboMachineList,'frmCountries'); 
}
function ClearFormc()
{   	
	document.getElementById("machines_cbomachineList").value = "";
	document.getElementById("machine_txtMachineCode").value = "";
	document.getElementById("machine_txtMachine").value = "";
}