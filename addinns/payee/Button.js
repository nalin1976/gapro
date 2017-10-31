var xmlHttp;
var xmlHttp1;

function ValidatePayeeInterface()
{
	if(document.getElementById('payee_txtName').value.trim()=="" )
	{
		alert("Please enter Payee \"Name\".");	
		document.getElementById('payee_txtName').focus();
		return false;
	}	
	else if(isNumeric(document.getElementById('payee_txtName').value)){
		alert('Payee name must be "Alphanumeric" value.');	
		document.getElementById('payee_txtName').focus();
		return false;	
	}
	else if(document.getElementById('payee_txtCountry').value.trim()=="" ){
		alert('Please select the "Country".');	
		document.getElementById('payee_txtCountry').focus();
		return false;	
	}
	else if(document.getElementById('payee_txtEmail').value.trim() != "" )
	{
		var email = document.getElementById('payee_txtEmail').value;
		if(!emailValidate(email))
		{
			alert("Please enter valid e-mail address.");
			document.getElementById("payee_txtEmail").focus();
			return false;
		}
	}
	return true;
}
function ValidatePayeeBeforeSave()
{
	var x_id = document.getElementById("payee_cboCustomer").value
	var x_name = document.getElementById("payee_txtName").value
	
	var x_find = checkInField('payee','strTitle',x_name,'intPayeeID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("payee_txtName").focus();
		return false;
	}
	return true;
}

function butCommand(strCommand)
{ 
	if(!ValidatePayeeInterface())
		return;
	if(!ValidatePayeeBeforeSave())
		return;

xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
	alert ("Browser does not support HTTP Request");
	return;
 } 
		  
if(document.getElementById('payee_cboCustomer').value.trim()=="")
	strCommand="New";
	var url="Button.php";
	url=url+"?q="+strCommand;	
	if(strCommand=="Save")
	{ 
		url+="&intPayeeID="+document.getElementById("payee_cboCustomer").value;				
		url+="&strTitle="+URLEncode(trim(document.getElementById("payee_txtName").value));
		url+="&strAddress1="+URLEncode(trim(document.getElementById("payee_txtAddress1").value));
		url+="&strStreet="+URLEncode(trim(document.getElementById("payee_txtStreet").value));
		url+="&strCity="+URLEncode(trim(document.getElementById("payee_txtCity").value));
		url+="&strState="+URLEncode(trim(document.getElementById("payee_txtState").value));
		url+="&strCountry="+document.getElementById("payee_txtCountry").value;
		url+="&strZipCode="+document.getElementById("payee_txtZipCode").value;
		url+="&strPhone="+URLEncode(trim(document.getElementById("payee_txtPhone").value));
		url+="&strEMail="+URLEncode(trim(document.getElementById("payee_txtEmail").value));
		url+="&strFax="+URLEncode(trim(document.getElementById("payee_txtFax").value));
		url+="&strWeb="+URLEncode(trim(document.getElementById("payee_txtWeb").value));
		url+="&strRemarks="+URLEncode(trim(document.getElementById("payee_txtRemarks").value));
			
	}
	else
	{   
		url+="&strTitle="+URLEncode(trim(document.getElementById("payee_txtName").value));
		url+="&strAddress1="+URLEncode(trim(document.getElementById("payee_txtAddress1").value));
		url+="&strStreet="+URLEncode(trim(document.getElementById("payee_txtStreet").value));
		url+="&strCity="+URLEncode(trim(document.getElementById("payee_txtCity").value));
		url+="&strState="+URLEncode(trim(document.getElementById("payee_txtState").value));
		url+="&strCountry="+document.getElementById("payee_txtCountry").value;
		url+="&strZipCode="+document.getElementById("payee_txtZipCode").value;
		url+="&strPhone="+document.getElementById("payee_txtPhone").value;
		url+="&strEMail="+URLEncode(trim(document.getElementById("payee_txtEmail").value));
		url+="&strFax="+URLEncode(trim(document.getElementById("payee_txtFax").value));
		url+="&strWeb="+URLEncode(trim(document.getElementById("payee_txtWeb").value));
		url+="&strRemarks="+URLEncode(trim(document.getElementById("payee_txtRemarks").value));
	}

	if(document.getElementById("payee_chkActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
	
	url=url+"&intStatus="+intStatus; 
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
		alert(xmlHttp.responseText);
		clearForm();
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
	

function payeeDeleteData(strCommand)
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
		url+="&intPayeeID="+document.getElementById("payee_cboCustomer").value;	
	}

	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
	
function clearForm()
{	
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		 return;
	} 
		
	//createXMLHttpRequest();
	xmlHttp1.onreadystatechange = clearFormRes;
	xmlHttp1.open("GET", 'Button.php?q=clearReq', true);
	xmlHttp1.send(null);  
}
	
function clearFormRes()
{
	if(xmlHttp1.readyState == 4) 
	{
		if(xmlHttp1.status == 200) 
		{
			document.getElementById("payee_cboCustomer").innerHTML  = xmlHttp1.responseText;
	       document.getElementById('payee_txtName').focus();
		}
	}
		clearFields();
}
function clearFields()
{
		document.getElementById("txtHint").innerHTML="";
		document.getElementById("payee_cboCustomer").value = "";
		document.getElementById("payee_txtName").value = "";
		document.getElementById("payee_txtAddress1").value = "";
		//document.getElementById("payee_txtAddress2").value = "";
		document.getElementById("payee_txtStreet").value = "";
		document.getElementById("payee_txtCity").value = "";
		document.getElementById("payee_txtState").value = "";
		document.getElementById("payee_txtCountry").value = "";
		document.getElementById("payee_txtZipCode").value = "";
		document.getElementById("payee_txtPhone").value = "";
		document.getElementById("payee_txtFax").value = "";
		document.getElementById("payee_txtEmail").value = "";
		document.getElementById("payee_txtWeb").value = "";
		document.getElementById("payee_txtRemarks").value = "";	
	       document.getElementById('payee_txtName').focus();
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
function getPayeeDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('payee_cboCustomer').value=='')
	{
		clearFields();
	}
		
		var PayeeID = document.getElementById('payee_cboCustomer').value;
		if(PayeeID.trim()=="")
		{
			return false;
		}
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowpayeeDetails;
		xmlHttp.open("GET", "payeemiddle.php?PayeeID="+PayeeID, true);
		
		xmlHttp.send(null);   
		
	}

	function ShowpayeeDetails()
	{
	if(document.getElementById('divlistORDetails').style.visibility == "visible"){
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
	 document.frmpayee.radioListORdetails[0].checked = false;
	 document.frmpayee.radioListORdetails[1].checked = false;	
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{   var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Name");
				document.getElementById('payee_txtName').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address1");
				document.getElementById('payee_txtAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;	
				//var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address2");
				//document.getElementById('payee_txtAddress2').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Street");
				document.getElementById('payee_txtStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("City");
				document.getElementById('payee_txtCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("State");
				document.getElementById('payee_txtState').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Country");
				document.getElementById('payee_txtCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ZipCode");
				document.getElementById('payee_txtZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Phone");
				document.getElementById('payee_txtPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMail");
				document.getElementById('payee_txtEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Fax");
				document.getElementById('payee_txtFax').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Web");
				document.getElementById('payee_txtWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Remarks");
				document.getElementById('payee_txtRemarks').value = XMLAddress1[0].childNodes[0].nodeValue;
			
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
								
				if(XMLAddress1[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("payee_chkActive").checked=true;	
				}
				else
				{
					document.getElementById("payee_chkActive").checked=false;	
				}		
			
			
				/*var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Name");
				document.getElementById('txtName').value = XMLAddress1[0].childNodes[0].nodeValue;
				
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address1");
				document.getElementById('txtAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address2");
				document.getElementById('txtAddress2').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Street");
				document.getElementById('txtStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("City");
				document.getElementById('txtCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("State");
				document.getElementById('txtState').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Country");
				document.getElementById('txtCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ZipCode");
				document.getElementById('txtZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Phone");
				document.getElementById('txtPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMail");
				document.getElementById('txtEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Fax");
				document.getElementById('txtFax').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Web");
				document.getElementById('txtWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Remarks");
				document.getElementById('txtRemarks').value = XMLAddress1[0].childNodes[0].nodeValue;*/
			}
		}
	}


	
	function payeeConfirmDelete(strCommand)
	{
		if(document.getElementById('payee_cboCustomer').value.trim()=="")
		{
			alert("Please select the Payee.");
			document.getElementById('payee_cboCustomer').focus();
		}
		else
		{
			var payee_txtName = document.getElementById("payee_txtName").value;
			var r=confirm("Are you sure you want to delete \""+payee_txtName+"\".");
			if (r==true)		
				payeeDeleteData(strCommand);
		}
	}
	/*function tblClear()
	{
        document.getElementById("tblMain").reset();
		for(i=0; i<frm_elements.length; i++)
		{
			field_type = frm_elements[i].type.toLowerCase();
			
			switch(field_type) {
			
			case "text":
			case "password":
			case "textarea":
			case "hidden":
			
			elements[i].value = "";
			break;
			
			case "radio":
			case "checkbox":
			
			if (elements[i].checked) {
			
			elements[i].checked = false;
			
			}
			break;
			
			case "select-one":
			case "select-multi":
			
			elements[i].selectedIndex = -1;
			break;
			
			default:
			break;
			
			}
			
			} 
	}*/
	
	function isValidData()
	{
		if(document.getElementById('payee_txtName').value.trim()=="" )
		{
			alert("Please enter Payee Name");	
			return false;
		}
		
		else if(!isValidEmail(document.getElementById('payee_txtEmail').value))
		{
			alert("Please enter Valid Email");	
			return false;			
		}
		else
		return true;
	}
	
	
	
	function isValidEmail(emailaddress)

        {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailaddress))
            {       
                   
                   return true;
                   
                   
             }                     
            return false;
        }   
		
		//----------------------------------------------REPORT--------------------------------------------------

function listORDetails()
{
	 document.frmpayee.radioListORdetails[0].checked = false;
	 document.frmpayee.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	document.getElementById('divlistORDetails').style.visibility = "visible";
	else
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	 	
}

function payeeloadReport(){ 
 if(document.frmpayee.radioListORdetails[0].checked == true){
	    var cboCustomer = document.getElementById('payee_cboCustomer').value;
	    var radioListORdetails = document.frmpayee.radioListORdetails[0].value;
		window.open("PayeeReportList.php?cboCustomer=" + cboCustomer,"New1"); 
		document.getElementById('divlistORDetails').style.visibility = "hidden";
 }else{
	  var cboCustomer = document.getElementById('payee_cboCustomer').value;
	  if(cboCustomer != ""){
	  var radioListORdetails = document.frmpayee.radioListORdetails[1].value;
      window.open("PayeeReportDetails.php?cboCustomer=" + cboCustomer,'New2'); 
	  document.getElementById('divlistORDetails').style.visibility = "hidden";
	  }else{
		alert("Please select a payee");  
	  }
 }
}

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	country	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function showCountryPopUp()
{
	var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 0;
	var H	= 0;
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
	//obj.parentNode.removeChild(obj);
	closePopUpArea(id);
	var sql = "SELECT intConID,strCountry FROM country WHERE intStatus =1 order by strCountry";
	var control = "payee_txtCountry";
	loadCombo(sql,control);
	document.getElementById('payee_txtZipCode').value = '';

}
	function LoadCountryModeRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('payee_txtCountry').innerHTML = XMLText;
		}
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

function LoadPayeeZipCode(obj)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadPayeeZipCodeRequest;
	xmlHttp.open("GET", 'Button.php?q=LoadPayeeZipCode&countryId=' +obj, true);
   	xmlHttp.send(null);
}
function LoadPayeeZipCodeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('payee_txtZipCode').value = XMLText;
	}
}