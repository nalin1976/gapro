
var xmlHttp;

function ValidateCompanyInterface()
{
		if(document.getElementById('txtComCode').value.trim() == "" )
		{
			alert("Please enter \"Company Code\".");
			document.getElementById("txtComCode").focus();
			return false;
		}
/*		else if(isNumeric(document.getElementById('txtComCode').value)){
			alert("Company Code must be an \"Alphanumeric\" value.");
			document.getElementById('txtComCode').focus();
			return;
		}*/
		if(document.getElementById('txtName').value.trim() == "" )
		{
			alert("Please enter \"Company Name\".");
			document.getElementById("txtName").focus();
			return false;
		}
		else if(isNumeric(document.getElementById('txtName').value)){
			alert("Company Name must be an \"Alphanumeric\" value.");
			document.getElementById('txtName').focus();
			return;
		}
		else if(document.getElementById('cboCountry').value.trim() == ""){
			alert("Please select \"Country\".");
			document.getElementById("cboCountry").focus();
			return false;
		}
		else if(document.getElementById('txtEMail').value.trim() != "" )
		{
			var email = document.getElementById('txtEMail').value;
			if(!emailValidate(email))
			{
				alert("Please enter valid e-mail address.");
				document.getElementById("txtEMail").focus();
				return false;
			}
		}
		
	return true;
}

function ValidateCompanyBeforeSave()
{	
	var x_id = document.getElementById("cbocompany").value
	var x_name = document.getElementById("txtComCode").value
	
	var x_find = checkInField('companies','strComCode',x_name,'intCompanyID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ '" is already exist.');	
		document.getElementById("txtComCode").focus();
		return false;
	}
	
	var x_id = document.getElementById("cbocompany").value
	var x_name = document.getElementById("txtName").value
	
	var x_find = checkInField('companies','strName',x_name,'intCompanyID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("txtName").focus();
		return false;
	}
	return true;
}
//Insert & Update Data (Save Data)
function butCommand1(strCommand)
{
	if(!ValidateCompanyInterface())
		return;
		
	if(!ValidateCompanyBeforeSave())	
		return;

	xmlHttp = GetXmlHttpObject();	
	if (xmlHttp == null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	  
	if(document.getElementById("cbocompany").value=="")
		strCommand="New";
	  
		var url="Button.php";
		url=url+"?q="+strCommand;
	
		if(strCommand=="Save"){		
			url=url+"&intCompanyID="+document.getElementById("cbocompany").value.trim();
			url=url+"&strCompanyCode="+URLEncode(document.getElementById("txtComCode").value.trim());	
			url=url+"&strName="+URLEncode(document.getElementById("txtName").value.trim());		
			url=url+"&strAddress1="+URLEncode(document.getElementById("txtAddress1").value.trim());		
			url=url+"&strStreet="+URLEncode(document.getElementById("txtStreet").value.trim());		
			url=url+"&strCity="+URLEncode(document.getElementById("txtCity").value.trim());		
			url=url+"&intCountry="+URLEncode(document.getElementById("cboCountry").value.trim());		
			
			url=url+"&strPhone="+URLEncode(document.getElementById("txtPhone").value.trim());		
			url=url+"&strFax="+URLEncode(document.getElementById("txtFax").value.trim());		
			url=url+"&strEMail="+URLEncode(document.getElementById("txtEMail").value.trim());		
			url=url+"&strWeb="+URLEncode(document.getElementById("txtWeb").value.trim());		
			url=url+"&strRemarks="+URLEncode(document.getElementById("txtRemarks").value.trim());		
			url=url+"&strTINNo="+URLEncode(document.getElementById("txtTINNo").value.trim());		
			url=url+"&strRegNo="+URLEncode(document.getElementById("txtRegNo").value.trim());		
			url=url+"&strVatAcNo="+URLEncode(document.getElementById("txtVatAcNo").value.trim());		
			url=url+"&dblVatValue="+URLEncode(document.getElementById("txtVatValue").value.trim());		
			url=url+"&strBOINo="+URLEncode(document.getElementById("txtBOINo").value.trim());	
			url=url+"&strTqbNo="+URLEncode(document.getElementById("txtTqbNo").value.trim());	
			url=url+"&reaFactroyCostPerMin="+URLEncode(document.getElementById("txtFactroyCostPerMin").value.trim());		
			url=url+"&defaultFactory="+document.getElementById("cboDefaultInvoiceTo").value.trim();	
			url=url+"&intManufac="+document.getElementById("cboManufac").value.trim();
			url=url+"&accountNo="+document.getElementById("txtAccountNo").value.trim();
			
		}
		else
		{
			url=url+"&intCompanyID="+document.getElementById("cbocompany").value.trim();
			url=url+"&strCompanyCode="+URLEncode(document.getElementById("txtComCode").value.trim());	
			url=url+"&strName="+URLEncode(document.getElementById("txtName").value.trim());		
			url=url+"&strAddress1="+URLEncode(document.getElementById("txtAddress1").value.trim());		
			url=url+"&strStreet="+URLEncode(document.getElementById("txtStreet").value.trim());		
			url=url+"&strCity="+URLEncode(document.getElementById("txtCity").value.trim());		
			url=url+"&intCountry="+URLEncode(document.getElementById("cboCountry").value.trim());		
			
			url=url+"&strPhone="+URLEncode(document.getElementById("txtPhone").value.trim());		
			url=url+"&strFax="+URLEncode(document.getElementById("txtFax").value.trim());		
			url=url+"&strEMail="+URLEncode(document.getElementById("txtEMail").value.trim());		
			url=url+"&strWeb="+URLEncode(document.getElementById("txtWeb").value.trim());		
			url=url+"&strRemarks="+document.getElementById("txtRemarks").value.trim();		
			url=url+"&strTINNo="+URLEncode(document.getElementById("txtTINNo").value.trim());		
			url=url+"&strRegNo="+URLEncode(document.getElementById("txtRegNo").value.trim());		
			url=url+"&strVatAcNo="+URLEncode(document.getElementById("txtVatAcNo").value.trim());		
			url=url+"&dblVatValue="+URLEncode(document.getElementById("txtVatValue").value.trim());		
			url=url+"&strBOINo="+URLEncode(document.getElementById("txtBOINo").value.trim());
			url=url+"&strTqbNo="+URLEncode(document.getElementById("txtTqbNo").value.trim());
			url=url+"&reaFactroyCostPerMin="+URLEncode(document.getElementById("txtFactroyCostPerMin").value.trim());	
			url=url+"&defaultFactory="+document.getElementById("cboDefaultInvoiceTo").value.trim();	
			url=url+"&intManufac="+document.getElementById("cboManufac").value.trim();
			url=url+"&accountNo="+document.getElementById("txtAccountNo").value.trim();
		}
		
		if(document.getElementById("chkActive").checked==true)
			var intStatus = 1;	
		else
			var intStatus = 0;
		
		url=url+"&intStatus="+intStatus; 
	
		xmlHttp.onreadystatechange=CompanyStateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
} 

function CompanyStateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
 		alert(xmlHttp.responseText); 
		ClearCompanyForm();
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
function DeleteDataCompany(strCommand)
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
		url=url+"&intCompanyID="+document.getElementById("cbocompany").value;		
	}

	xmlHttp.onreadystatechange=CompanyStateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	ClearCompanyForm();
	
	
}
	
function ClearCompanyForm()
{
	document.getElementById('txtComCode').disabled=false;
	document.frmCompanyDetails.reset();
	document.getElementById("txtComCode").focus();
	var sql = "select intCompanyID,strName from companies where intStatus <> 10 order by strName";
	var control = "cbocompany";
	loadCombo(sql,control);
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

function getCompanyDetails()
		{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cbocompany').value.trim()=='')
	{
		//setTimeout("location.reload(true);",0);
		ClearCompanyForm();
	}
	
		var Company = document.getElementById('cbocompany').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowCompanyDetails;
		xmlHttp.open("GET", 'Companymiddle.php?Company='+Company, true);
		
		xmlHttp.send(null);   
	 
		
	}

function ShowCompanyDetails()
{
if(document.getElementById('divlistORDetails').style.visibility == "visible"){
	document.getElementById('divlistORDetails').style.visibility = "hidden";
}
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{  	
			
			  //  var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CompanyID");
				//document.getElementById('txtComID').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CompanyCode");
				document.getElementById('txtComCode').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Name");
				document.getElementById('txtName').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Address1");
				document.getElementById('txtAddress1').value = XMLLoad[0].childNodes[0].nodeValue;
				
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("street");
				document.getElementById('txtStreet').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("city");
				document.getElementById('txtCity').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("country");
				document.getElementById('cboCountry').value = XMLLoad[0].childNodes[0].nodeValue;

				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Phone");
				document.getElementById('txtPhone').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Fax");
				document.getElementById('txtFax').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("EMail");
				document.getElementById('txtEMail').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Web");
				document.getElementById('txtWeb').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Remarks");
				document.getElementById('txtRemarks').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("TINNo");
				document.getElementById('txtTINNo').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("RegNo");
				document.getElementById('txtRegNo').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("VatAcNo");
				document.getElementById('txtVatAcNo').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("VatValue");
				document.getElementById('txtVatValue').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("BOINo");
				document.getElementById('txtBOINo').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("FactroyCostPerMin");
				document.getElementById('txtFactroyCostPerMin').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("TQBNo");
				document.getElementById('txtTqbNo').value = XMLLoad[0].childNodes[0].nodeValue;
				//defaultFactory
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("defaultFactory");
				document.getElementById('cboDefaultInvoiceTo').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Currency");
				
				
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("intManufac");
				document.getElementById('cboManufac').value = XMLLoad[0].childNodes[0].nodeValue;
				
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("accountNo");
				document.getElementById('txtAccountNo').value = XMLLoad[0].childNodes[0].nodeValue;
				
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
								
				if(XMLAddress1[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("chkActive").checked=true;	
				}
				else
				{
					document.getElementById("chkActive").checked=false;	
				}
				
					var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
	if(XMLused[0].childNodes[0].nodeValue == '1'){
	document.getElementById('txtComCode').disabled=true;
	}
	if(XMLused[0].childNodes[0].nodeValue == '0'){
	document.getElementById('txtComCode').disabled=false;
	}
				
			}
		}
	}
	
function ConfirmDeleteCompany(strCommand)
{
	if(document.getElementById('cbocompany').value=="")
	{
		alert("Please select a Company.");
		document.getElementById('cbocompany').focus();
		return;
	}
	else
	{
		var r=confirm("Are you sure you want to delete \""+document.getElementById('txtName').value+"\" ?");
		if (r==true)		
			DeleteDataCompany(strCommand);				
	}			
}
	
function checkvalue()
{
	if(document.getElementById('txtComCode').value!="")
		document.getElementById("txtAddress1").focus();
}

function checkvalue1()
{

}
	
	
function checkDefaultInvoiceStatus(obj)
{
	var compId = document.getElementById('cbocompany').value;

	if(compId != '')
	{
		if(obj.value=='Yes')
		{
			createXMLHttpRequest();
			xmlHttp.onreadystatechange=defaultCompanyRequest;
			var url = "companymiddle2.php?id=checkDefaultCompany&compId="+compId;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);				
		}
	}
}

function defaultCompanyRequest()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{  	
			var text = xmlHttp.responseText;
			if(text>=1)
			{
				alert('A Company is allready selected as a default invoice company. ');	
				document.getElementById('cboDefaultInvoiceTo').value = "No";
			}
		}
	}	
}
//--------------------------------------report---------------------------
function listORDetails()
{
	 document.frmCompanyDetails.radioListORdetails[0].checked = false;
	 document.frmCompanyDetails.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	document.getElementById('divlistORDetails').style.visibility = "visible";
	else
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	 	
}

function loadReportCompany()
{ 
 if(document.frmCompanyDetails.radioListORdetails[0].checked == true)
 {
	var cbocompany = document.getElementById('cbocompany').value;
	var radioListORdetails = document.frmCompanyDetails.radioListORdetails[0].value;
	window.open("ComListReport.php?cbocompany=" + cbocompany,'new2'); 
 }else
 {
	var cbocompany = document.getElementById('cbocompany').value;
	if(cbocompany != ""){
		var radioListORdetails = document.frmCompanyDetails.radioListORdetails[1].value;
		window.open("ComDetailReport.php?cbocompany=" + cbocompany,'new1'); 
	}else{
		alert("Please select a Company");  
	}
 }
 
 if(document.getElementById('divlistORDetails').style.visibility == "visible")
	document.getElementById('divlistORDetails').style.visibility = "hidden";
}

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	Currency	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	loadNewCurruncy2()
{
		
	var url  = "../currency/Currency.php?";
	inc('../currency/Button.js');
	
	//inc('../tax/newMasterData-js.js');
	var W	= 560;
	var H	= 304;
	var closePopUp = "closeCurrencyPopUp";
	CreatePopUp(url,W,H,closePopUp);	
}

function showCountryPopUppp(){
	var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 10;
	var H	= 60;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUp";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function closeCountryModePopUp(id)
{
	var sql = "SELECT intConID,strCountry FROM country WHERE intStatus <>10 order by strCountry";
	var control = "cboCountry";
	loadCombo(sql,control);
	closePopUpArea(id);	
}
	
function closeCurrencyPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	closePopUpArea(id);	
	var urlDetails="Button.php?q=loadCurrency";
	htmlobj=$.ajax({url:urlDetails,async:false});
	//document.getElementById('companyDetails_cboCurr').innerHTML=htmlobj.responseText;	
}

function closeWindowtax()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}
