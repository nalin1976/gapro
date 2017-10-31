var xmlHttp;
var xmlHttp1;
var pub_currencyPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url	= pub_currencyPath+"/addinns/currency/";

//Insert & Update Data (Save Data)
function butCommand_currency(strCommand)
{
//if (isValidData())
		 if(document.getElementById('currency_txtCurrency').disabled==true)
		 	return false;
		if(document.getElementById('currency_cboCountry').value == null || document.getElementById('currency_cboCountry').value == "" )
		{
			alert("Please select the \"Country\".");
			document.getElementById("currency_cboCountry").focus();
			return false;
		}
        if(trim(document.getElementById('currency_txtCurrency').value)=="")
		{
			alert("Please enter \"Currency\".");	
			document.getElementById('currency_txtCurrency').focus();
			return false;
		}
		else if(isNumeric(document.getElementById('currency_txtCurrency').value)){
			alert("Currency Code must be an \"Alphanumeric\" value.");
			document.getElementById('currency_txtCurrency').focus();
			return;
		}
		else if(trim(document.getElementById('currency_txtTitle').value)=="")
		{
			alert("Please enter \"Tilte\".");
			document.getElementById('currency_txtTitle').focus();
			return false;
		}
		else if(isNumeric(document.getElementById('currency_txtTitle').value)){
			alert("Currency Title must be an \"Alphanumeric\" value.");
			document.getElementById('currency_txtTitle').focus();
			return;
		}
		/*else if(trim(document.getElementById('currency_txtRate').value)=="")
		{
			alert("Please enter \"Rate\".");	
				document.getElementById('currency_txtRate').focus();
			return false;
		}*/
		else if(trim(document.getElementById('currency_txtFraction').value)=="")
		{
			alert("Please enter \"Fractional Unit\".");	
				document.getElementById('currency_txtFraction').focus();
			return false;
		}
		else if(isNumeric(document.getElementById('currency_txtFraction').value)){
			alert("Fractional Unit must be an \"Alphanumeric\" value.");
			document.getElementById('currency_txtFraction').focus();
			return;
		}/*
		else if(trim(document.getElementById('currency_txtExRate').value)=="")
		{
			alert("Please enter Exchange Rate");
				document.getElementById('currency_txtExRate').focus();
			return false;
		}*/
		else if(!ValidateBeforeSave())
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
		  
		 if(document.getElementById('currency_cboCurr').value=="")
		 	strCommand="New";
		else	
			strCommand="Save";
		 
		var url=pub_url+"Button.php";
		url=url+"?q="+strCommand;
			
				if(strCommand=="Save")
				{ 
					url=url+"&cboCurr="+document.getElementById("currency_cboCurr").value;
					url=url+"&strCurrency="+URLEncode(document.getElementById("currency_txtCurrency").value);
					url=url+"&strTitle="+URLEncode(document.getElementById("currency_txtTitle").value);
					//url=url+"&dblRate="+document.getElementById("currency_txtRate").value;	
					url=url+"&strFraction="+URLEncode(document.getElementById("currency_txtFraction").value);
					url=url+"&intConID="+document.getElementById("currency_cboCountry").value;
					//url=url+"&txtExRate="+document.getElementById("currency_txtExRate").value;	
				}
				else
				{   
					url=url+"&cboCurr="+document.getElementById("currency_cboCurr").value;
					url=url+"&strCurrency="+URLEncode(document.getElementById("currency_txtCurrency").value);
					url=url+"&strTitle="+URLEncode(document.getElementById("currency_txtTitle").value);
					//url=url+"&dblRate="+document.getElementById("currency_txtRate").value;
					url=url+"&strFraction="+URLEncode(document.getElementById("currency_txtFraction").value);
					url=url+"&intConID="+document.getElementById("currency_cboCountry").value;
					//url=url+"&txtExRate="+document.getElementById("currency_txtExRate").value;	
				}
		if(document.getElementById("currency_chkActive").checked==true)
		{
			var intStatus = 1;	
		}
		else
		{
			var intStatus = 0;
		}
		
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
		clearForm();
	} 
}

function clearForm()
{	
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		 return;
	}	

	xmlHttp1.onreadystatechange = clearFormRes;
	xmlHttp1.open("GET", pub_url+'Button.php?q=clearReq', true);
	xmlHttp1.send(null);  
}
	
function clearFormRes()
{
	if(xmlHttp1.readyState == 4) 
	{
		if(xmlHttp1.status == 200) 
		{
			//alert(xmlHttp1.responseText);
			document.getElementById("currency_cboCurr").innerHTML  = xmlHttp1.responseText;
		}
	}
		//clearFields();
		document.frmCurrencyType.reset();
}

function clearFields()
{
		document.getElementById('currency_txtCurrency').disabled=false;
		document.getElementById('currency_txtTitle').disabled=false;
		//document.getElementById('currency_txtRate').disabled=false;
		document.getElementById('currency_txtFraction').disabled=false;
		document.getElementById('currency_chkActive').disabled=false;
		document.getElementById('currency_cboCountry').disabled=false;
		document.getElementById('currency_cboCountry').style.backgroundColor = '#ffffff'; 	
		document.getElementById('currency_txtCurrency').style.backgroundColor = '#ffffff'; 					
		document.getElementById('currency_txtTitle').style.backgroundColor = '#ffffff'; 
		//document.getElementById('currency_txtRate').style.backgroundColor = '#ffffff'; 
		document.getElementById('currency_txtFraction').style.backgroundColor = '#ffffff'; 
		document.getElementById('currency_chkActive').style.backgroundColor = '#ffffff'; 
		document.getElementById('currency_cboCurr').value="";
		document.getElementById('currency_txtCurrency').value="";
		document.getElementById('currency_txtTitle').value="";
		//document.getElementById('currency_txtRate').disabled=false;
		document.getElementById('currency_txtFraction').value="";
		document.getElementById('currency_chkActive').value="";
		document.getElementById('currency_cboCountry').value="";
		document.getElementById('currency_cboCountry').focus();
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
function DeleteDataCurrency(strCommand)
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
		url=url+"&cboCurr="+document.getElementById("currency_cboCurr").value;
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	clearForm();
	
	
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

function getCurrencyDetails()
{   

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
{
  alert ("Browser does not support HTTP Request");
  return;
} 
if(document.getElementById('currency_cboCurr').value.trim()=='')
{
	clearFields();
	return false;
}

	var CurrencyID = document.getElementById('currency_cboCurr').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange =  ShowCurrencyDetails;
	xmlHttp.open("GET", pub_url+'Currencymiddle.php?CurrencyID=' + CurrencyID, true);
	xmlHttp.send(null); 
	
}

function ShowCurrencyDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
		
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CurrencyName");
			document.getElementById('currency_txtCurrency').value = XMLLoad[0].childNodes[0].nodeValue;
			
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Title");
			document.getElementById('currency_txtTitle').value = XMLLoad[0].childNodes[0].nodeValue;	
			//var XMLdblExRate = xmlHttp.responseXML.getElementsByTagName("dblExRate");
			//document.getElementById('currency_txtExRate').value = XMLdblExRate[0].childNodes[0].nodeValue;	
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Rate");
		//	document.getElementById('currency_txtRate').value = XMLLoad[0].childNodes[0].nodeValue;	
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("FractionalUnit");
			document.getElementById('currency_txtFraction').value = XMLLoad[0].childNodes[0].nodeValue;		
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Country");
			document.getElementById('currency_cboCountry').value = XMLLoad[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
											
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
			{
				document.getElementById("currency_chkActive").checked=true;	
			}
			else
			{
				document.getElementById("currency_chkActive").checked=false;	
			}
			
			var XMLdblRate = xmlHttp.responseXML.getElementsByTagName("dblRate");
			
			if(XMLdblRate[0].childNodes[0].nodeValue==1)
			{
				document.getElementById('currency_txtCurrency').disabled="disabled";
				document.getElementById('currency_txtTitle').disabled="disabled";
				//document.getElementById('currency_txtRate').disabled="disabled";
				document.getElementById('currency_txtFraction').disabled="disabled";
				document.getElementById('currency_chkActive').disabled="disabled";
				document.getElementById('currency_cboCountry').disabled="disabled";
				document.getElementById('currency_cboCountry').style.backgroundColor = '#cccccc'; 	
				document.getElementById('currency_txtCurrency').style.backgroundColor = '#cccccc'; 					
				document.getElementById('currency_txtTitle').style.backgroundColor = '#cccccc'; 
				//document.getElementById('currency_txtRate').style.backgroundColor = '#cccccc'; 
				document.getElementById('currency_txtFraction').style.backgroundColor = '#cccccc'; 
				document.getElementById('currency_chkActive').style.backgroundColor = '#cccccc'; 
			}
			else{					
				document.getElementById('currency_txtCurrency').disabled=false;
				document.getElementById('currency_txtTitle').disabled=false;
				//document.getElementById('currency_txtRate').disabled=false;
				document.getElementById('currency_txtFraction').disabled=false;
				document.getElementById('currency_chkActive').disabled=false;
				document.getElementById('currency_cboCountry').disabled=false;
				document.getElementById('currency_cboCountry').style.backgroundColor = '#ffffff'; 	
				document.getElementById('currency_txtCurrency').style.backgroundColor = '#ffffff'; 					
				document.getElementById('currency_txtTitle').style.backgroundColor = '#ffffff'; 
				//document.getElementById('currency_txtRate').style.backgroundColor = '#ffffff'; 
				document.getElementById('currency_txtFraction').style.backgroundColor = '#ffffff'; 
				document.getElementById('currency_chkActive').style.backgroundColor = '#ffffff'; 
			}
			
		}
	}
}
	
function ConfirmDeleteCurrency(strCommand)
{
	if(document.getElementById('currency_txtCurrency').disabled==true)
		return false;
	var currenyTitle = document.getElementById('currency_cboCurr').value;
	if(currenyTitle=="")
	{
		alert("Please enter \"Currency\".");
		document.getElementById('currency_cboCurr').focus();
	}
	else
	{
		var r=confirm("Are you sure you want to delete \""+document.getElementById('currency_txtCurrency').value+"\"?");
		if (r==true)		
			DeleteDataCurrency(strCommand);
	}
}
	
	
	function isValidData()
	{
		if(document.getElementById('currency_txtCurrency').value=="")
		{
			alert("Please enter Currency");	
			return false;
		}

		else
		return true;
	}
	
		//--------------------------------------report------------------------------------------
	
function loadReportCurrency()
{ 
	    var cboCountryList = document.getElementById('currency_cboCurr').value;
		
		window.open(pub_url+"CurrencyReport.php?cboCountryList=" + cboCountryList,'new'); 
}
	
function ValidateBeforeSave()
{	
	var x_id = document.getElementById("currency_cboCurr").value
	var x_name = document.getElementById("currency_txtCurrency").value
	
	var x_find = checkInField('currencytypes','strCurrency',x_name,'intCurID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("currency_txtCurrency").focus();
		return false;
	}
	
	var x_id = document.getElementById("currency_cboCurr").value
	var x_name = document.getElementById("currency_txtTitle").value
	
	var x_find = checkInField('currencytypes','strTitle',x_name,'intCurID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("currency_txtTitle").focus();
		return false;
	}
	return true;
}

function	showCountryPopUp()
{
	
	var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 30;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUp";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
	/*
    var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 30;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUp";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete);
	*/
}
	
function closeCountryModePopUp(id)
{

	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	
/*	closePopUpArea(id);
	
	var urlDetails="Button.php?q=LoadCountryMode";
	htmlobj=$.ajax({url:urlDetails,async:false});
	document.getElementById('currency_cboCountry').innerHTML=htmlobj.responseText;*/
	
	closePopUpArea(id);
	
	var sql = "SELECT intConID,strCountry FROM country WHERE intStatus <>10 order by strCountry";
	var control = "currency_cboCountry";
	loadCombo(sql,control);

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