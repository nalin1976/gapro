var xmlHttp;
var pub_countryPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_countryUrl = pub_countryPath+"/addinns/country/";

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
				 
    if(document.getElementById("countries_cboCountryList").value=="")			
		strCommand="New";
			
	var url=pub_countryUrl+"Button.php";
	url=url+"?q="+strCommand;
	
	if(strCommand=="Save"){ 
		url=url+"&cboCountryList="+document.getElementById("countries_cboCountryList").value;
		url=url+"&strCountryCode="+URLEncode(document.getElementById("countries_txtCountryCode").value);
		url=url+"&strCountry="+URLEncode(document.getElementById("countries_txtCountry").value);	
		url=url+"&strZipCode="+URLEncode(document.getElementById("countries_txtZipCode").value);
	}	
	else
	{  
		url=url+"&strCountryCode="+URLEncode(document.getElementById("countries_txtCountryCode").value);
		url=url+"&strCountry="+URLEncode(document.getElementById("countries_txtCountry").value);	
		url=url+"&strZipCode="+URLEncode(document.getElementById("countries_txtZipCode").value);
	}
	
	if(document.getElementById("countries_chkActive").checked==true)
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
	if(document.getElementById('countries_txtCountryCode').value.trim() == "" )
	{
		alert("Please enter \"Country Code\".");
		document.getElementById("countries_txtCountryCode").focus();
		return false;
	}
	if(document.getElementById('countries_txtCountry').value.trim() == "" )
	{
		alert("Please enter \"Country Name\".");
		document.getElementById("countries_txtCountry").focus();
		return false;
	}
	else if(isNumeric(document.getElementById('countries_txtCountry').value)){
		alert("Country Name must be an \"Alphanumeric \" value.");
		document.getElementById('countries_txtCountry').focus();
		return;
	}
return true;
}

function ValidateCountryBeforeSave()
{	
	var x_id = document.getElementById("countries_cboCountryList").value;
	var x_name = document.getElementById("countries_txtCountryCode").value;
	
	var x_find = checkInField('country','strCountryCode',x_name,'intConID',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("countries_txtCountryCode").focus();
		return false;
	}
	
	var x_id = document.getElementById("countries_cboCountryList").value;
	var x_name = document.getElementById("countries_txtCountry").value;
	
	var x_find = checkInField('country','strCountry',x_name,'intConID',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("countries_txtCountry").focus();
		return false;
	}
	
	var x_id 	= document.getElementById("countries_cboCountryList").value;
	var x_name 	= trim(document.getElementById("countries_txtZipCode").value);
	
	if(x_name!='')
	{
		var x_find = checkInField('country','strZipCode',x_name,'intConID',x_id);
		if(x_find )
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("countries_txtZipCode").focus();
			return false;
		}
	}
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
		url=url+"&cboCountryList="+document.getElementById("countries_cboCountryList").value;	

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
			document.getElementById("countries_cboCountryList").innerHTML  = xmlHttp.responseText;
			document.getElementById("countries_txtCountryCode").focus();
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
	xmlHttp.open("GET", pub_countryUrl+'Button.php?q=countries', true);
	xmlHttp.send(null);  	
}

function getCountryDetails()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('countries_cboCountryList').value=='')
	{
		ClearForm();
	}
	else
	{	
		var CountryID = document.getElementById('countries_cboCountryList').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowCountryDetails;
		xmlHttp.open("GET", pub_countryUrl+'Countrymiddle.php?q=country&CountryID=' + CountryID, true);
		xmlHttp.send(null);  
	}
}

function ShowCountryDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			document.getElementById('countries_txtCountryCode').disabled=false;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CountryCode");
			document.getElementById('countries_txtCountryCode').value = XMLLoad[0].childNodes[0].nodeValue;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CountryName");
			document.getElementById('countries_txtCountry').value = XMLLoad[0].childNodes[0].nodeValue;	
			var XMLZipCode = xmlHttp.responseXML.getElementsByTagName("zipCode");
			document.getElementById('countries_txtZipCode').value = XMLZipCode[0].childNodes[0].nodeValue;	
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("countries_chkActive").checked=true;	
			else
				document.getElementById("countries_chkActive").checked=false;	
			
		   	var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
		   
		   
		   	if(XMLused[0].childNodes[0].nodeValue == '1')
				document.getElementById('countries_txtCountryCode').disabled=true;
		   
		   	if(XMLused[0].childNodes[0].nodeValue == '0')
		   		document.getElementById('countries_txtCountryCode').disabled=false;			
		}
	}
}
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('countries_cboCountryList').value=="")
	{
		alert("Please select a \"Country\".");
		document.getElementById('countries_cboCountryList').focus();
		return;
	}	
	else
	{
		var r=confirm("Are you sure you want to delete \""+ document.getElementById('countries_txtCountry').value +"\" ?");
		if (r==true)		
			DeleteData(strCommand);				
	}
}
	
function checkvalue()
{
	if(document.getElementById('countries_txtCountryCode').value!="")
		document.getElementById("countries_txtCountry").focus();
}
//-------------------------------------	report-----------------------------------------------
function loadReport()
{ 
	    var cboCountryList = document.getElementById('countries_cboCountryList').value;
		window.open(pub_countryUrl+"CountryReport.php?cboCountryList=" + cboCountryList,'frmCountries'); 
}
function ClearFormc()
{   	
	document.getElementById("countries_cboCountryList").value = "";
	document.getElementById("countries_txtCountryCode").value = "";
	document.getElementById("countries_txtCountry").value = "";
}