var xmlHttp;
var pub_bankPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url	= pub_bankPath+"/addinns/buyers/";
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
//-----------------------------------------------------------------------------

function getCustomerDetails()
{
	if(document.getElementById('divlistORDetails').style.visibility == "visible"){
		document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
		document.frmBuyers.radioListORdetails[0].checked = false;
		document.frmBuyers.radioListORdetails[1].checked = false;
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboAddinsCustomer').value=='')
	{
		ClearBuyerForm();
		return false;
	}
		var url=pub_url+"SearchData.php";
		url=url+"?RequestType=SearchBuyers&BuyerName="+document.getElementById('cboAddinsCustomer').value;	
		var xmlHttp     	=$.ajax({url:url,async:false});
	//alert(html.responseText);
	//document.getElementById('txtAddinsBuyerCode').disabled=false;
			//var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("buyerCode");	
			//if(XMLAddress1.length<=0)
				//return;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("buyerCode");	
			//alert(XMLAddress1[0].childNodes[0].nodeValue);
			document.getElementById('txtAddinsBuyerCode').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strName");				
			document.getElementById('txtAddinsName').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAddress1");				
			document.getElementById('txtAddinsAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;		
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAddress2");
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strStreet");
			document.getElementById('txtAddinsStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCity");
			document.getElementById('txtAddinsCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCountry");
			document.getElementById('cboAddinsCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strPhone");
			document.getElementById('txtAddinsPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strEmail");
			document.getElementById('txtAddinsEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strWeb");
			document.getElementById('txtAddinsWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strRemarks");
			document.getElementById('txtAddinsRemarks').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAgent");
			document.getElementById('txtAddinsAgent').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strState");
			document.getElementById('txtAddinsState').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strZipCode");
			document.getElementById('txtAddinsZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strFax");
			document.getElementById('txtAddinsFax').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("chkAddinsActive").checked=true;	
			else
				document.getElementById("chkAddinsActive").checked=false;	
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strDtFormat");
			document.getElementById('cboAddinsDtFromat').value = XMLAddress1[0].childNodes[0].nodeValue;
		
		var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
		if(XMLused[0].childNodes[0].nodeValue == '1')
			document.getElementById('txtAddinsBuyerCode').disabled=true;
		
		if(XMLused[0].childNodes[0].nodeValue == '0')
			document.getElementById('txtAddinsBuyerCode').disabled=false;	
		
		var XMLActualFOB = xmlHttp.responseXML.getElementsByTagName("actualFOB");
			document.getElementById('cboActualFOB').value = XMLActualFOB[0].childNodes[0].nodeValue;	
		document.getElementById('cboPayTerm').value = xmlHttp.responseXML.getElementsByTagName("PayTermId")[0].childNodes[0].nodeValue;
		
		//xmlHttp.onreadystatechange=ShowBuyerDetails;		
		//xmlHttp.open("GET",url,true);		
		//xmlHttp.send(null);
		
}

function GetCountryZipCode(obj)
{
	document.getElementById('txtAddinsZipCode').value = "";
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = GetCountryZipCodeRequest;
	xmlHttp.open("GET", pub_url+"SearchData.php?RequestType=GetCountryZipCode&countryId=" +obj, true);
   	xmlHttp.send(null);
}
function GetCountryZipCodeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('txtAddinsZipCode').value = XMLText;
	}
}

function GetpopZipCode(obj)
{
	document.getElementById('txtBOZipCode').value = "";
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = GetpopZipCodeRequest;
	xmlHttp.open("GET", pub_url+"SearchData.php?RequestType=GetCountryZipCode&countryId=" +obj, true);
   	xmlHttp.send(null);
}
function GetpopZipCodeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('txtBOZipCode').value = XMLText;
	}
}

function ShowBuyerDetails()
{			
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			document.getElementById('txtAddinsBuyerCode').disabled=false;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("buyerCode");	
			if(XMLAddress1.length<=0)
				return;
			document.getElementById('txtAddinsBuyerCode').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strName");				
			document.getElementById('txtAddinsName').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAddress1");				
			document.getElementById('txtAddinsAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;		
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAddress2");
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strStreet");
			document.getElementById('txtAddinsStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCity");
			document.getElementById('txtAddinsCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCountry");
			document.getElementById('cboAddinsCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strPhone");
			document.getElementById('txtAddinsPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strEmail");
			document.getElementById('txtAddinsEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strWeb");
			document.getElementById('txtAddinsWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strRemarks");
			document.getElementById('txtAddinsRemarks').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAgent");
			document.getElementById('txtAddinsAgent').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strState");
			document.getElementById('txtAddinsState').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strZipCode");
			document.getElementById('txtAddinsZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strFax");
			document.getElementById('txtAddinsFax').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("chkAddinsActive").checked=true;	
			else
				document.getElementById("chkAddinsActive").checked=false;	
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strDtFormat");
			document.getElementById('cboAddinsDtFromat').value = XMLAddress1[0].childNodes[0].nodeValue;
		}
		var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
		if(XMLused[0].childNodes[0].nodeValue == '1')
			document.getElementById('txtAddinsBuyerCode').disabled=true;
		
		if(XMLused[0].childNodes[0].nodeValue == '0')
			document.getElementById('txtAddinsBuyerCode').disabled=false;	
		
		var XMLActualFOB = xmlHttp.responseXML.getElementsByTagName("actualFOB");
			document.getElementById('cboActualFOB').value = XMLActualFOB[0].childNodes[0].nodeValue;	
		document.getElementById('cboPayTerm').value = xmlHttp.responseXML.getElementsByTagName("PayTermId")[0].childNodes[0].nodeValue;
			
		
	}

}

//Start 23-04-2010 Buying office 
function GetBuyingOfficeDetails()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboBoName').value=='')
	{
		ClearDetails(0);
		return;
	}
	
		var url=pub_url+"SearchData.php";
		url=url+"?RequestType=SearchBuyingOffice&BuyingOfficeName="+document.getElementById('cboBoName').value;		
		xmlHttp.onreadystatechange=GetBuyingOfficeDetailsRequest;		
		xmlHttp.open("GET",url,true);		
		xmlHttp.send(null);
		
}
function GetBuyingOfficeDetailsRequest()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	   	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strName");				
			document.getElementById('txtBOName').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAddress1");				
			document.getElementById('txtBOAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;		
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strStreet");
			document.getElementById('txtBOStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCity");
			document.getElementById('txtBOCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCountry");
			document.getElementById('cmbCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strPhone");
			document.getElementById('txtBOPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strEmail");
			document.getElementById('txtBOEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strWeb");
			document.getElementById('txtBOWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strRemarks");
			document.getElementById('txtBORemarks').value = XMLAddress1[0].childNodes[0].nodeValue;
		   
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strState");
			document.getElementById('txtBOState').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strZipCode");
			document.getElementById('txtBOZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strFax");
			document.getElementById('txtBOFax').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
			{
				document.getElementById("chkActive").checked=true;	
			}
			else
			{
				document.getElementById("chkActive").checked=false;	
			}
		}
	}
}
	
function ClearDetails(obj)
{
	document.getElementById('txtBOName').value = "";
	document.getElementById('txtBOAddress1').value = "";
	
	document.getElementById('txtBOStreet').value = "";
	document.getElementById('txtBOCity').value = "";
	document.getElementById('cmbCountry').value = "";
	document.getElementById('txtBOPhone').value = "";
	document.getElementById('txtBOEmail').value = "";
	document.getElementById('txtBOWeb').value = "";
	document.getElementById('txtBORemarks').value = "";
	document.getElementById('txtBOState').value = "";
	document.getElementById('txtBOZipCode').value = "";
	document.getElementById('txtBOFax').value = "";
	document.getElementById("chkAddinsActive").checked=true;
	document.getElementById("txtBOName").focus();
	if(obj==1)
		document.getElementById('cboBoName').value = "";
}
//End 23-04-2010 Buying office

//Start 23-04-2010 Buyer Division
function GetBuyerDivisionDetails()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboDivisionName').value=='')
	{
		ClearDivisionDetails(0);
		return;
	}
		var url=pub_url+"SearchData.php";
		url=url+"?RequestType=SearchBuyerDivision&buyerDivisionId="+document.getElementById('cboDivisionName').value;		
		xmlHttp.onreadystatechange=GetBuyerDivisionDetailsRequest;		
		xmlHttp.open("GET",url,true);		
		xmlHttp.send(null);		
}
function GetBuyerDivisionDetailsRequest()
	{
				
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	   	
				var XMLName = xmlHttp.responseXML.getElementsByTagName("Name");				
				document.getElementById('txtBDName').value = XMLName[0].childNodes[0].nodeValue;	
				var XMLRemarks = xmlHttp.responseXML.getElementsByTagName("Remarks");				
				document.getElementById('txtBDRemarks').value = XMLRemarks[0].childNodes[0].nodeValue;				
			}
		}
	}
function ClearDivisionDetails(obj)
{
	document.getElementById('txtBDName').value = "";
	document.getElementById('txtBDRemarks').value = "";
if(obj==1)
	document.getElementById('cboDivisionName').value = "";
}
//End 23-04-2010 Buyer Division