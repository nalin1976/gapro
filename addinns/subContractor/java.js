var xmlHttp;
var xmlHttp1;

function savecontractor(strCommand)
	{
		
		if(document.getElementById("subcontractor_txtName").value.trim() =="")
		{
			alert("Please enter \"Name\".");
			document.getElementById("subcontractor_txtName").focus();
			return false;
		}
		else if (isNumeric(document.getElementById("subcontractor_txtName").value))
		{	document.getElementById("subcontractor_txtName").focus();
			alert("Name must be an \"Alphanumeric \" value.");
			return false;
			}
		
		else	
		{
			
			/////////////////////////////////////////////////////////////////////////////////
			var x_id = document.getElementById("subcontractor_cboSearch").value
			var x_name = document.getElementById("subcontractor_txtName").value
		
			var x_find = checkInField('subcontractors','strName',x_name,'strSubContractorID',x_id);
			if(x_find)
			{
				alert('"'+x_name+'" is already exist.');	
				document.getElementById("subcontractor_txtName").focus();
				return;
			}			 
			/////////////////////////////////////////////////////////////////////////////////////
			
			if (document.getElementById("subcontractor_txtEmail").value.trim()!="")
				{	if(emailValidate(document.getElementById("subcontractor_txtEmail").value)==false){
						document.getElementById("subcontractor_txtEmail").focus();
						alert("Please enter a valid email address");
						return false;}
				}
			xmlHttp=GetXmlHttpObject();
			if (xmlHttp==null)
			{
				alert ("Browser does not support HTTP Request");
				return;
			}
			
			if(trim(document.getElementById("subcontractor_cboSearch").value)=="")
			strCommand="New";
			
			var url="db.php";
			url=url+"?q="+strCommand;
			
			if(strCommand=="Save")
			{
				url=url+"&intID="+URLEncode(document.getElementById("subcontractor_cboSearch").value);
				url=url+"&strName="+URLEncode(document.getElementById("subcontractor_txtName").value);
				url=url+"&strAddress1="+URLEncode(document.getElementById("subcontractor_txtAddress1").value);
				
				url=url+"&strStreet="+URLEncode(document.getElementById("subcontractor_txtStreet").value);
				url=url+"&strCity="+URLEncode(document.getElementById("subcontractor_txtCity").value);
				url=url+"&strCountry="+URLEncode(document.getElementById("subcontractor_txtCountry").value);
				url=url+"&strPhone="+URLEncode(document.getElementById("subcontractor_txtPhone").value);
				url=url+"&strEmail="+URLEncode(document.getElementById("subcontractor_txtEmail").value);
				url=url+"&strWeb="+URLEncode(document.getElementById("subcontractor_txtWeb").value);
				url=url+"&strRemarks="+URLEncode(document.getElementById("subcontractor_txtRemarks").value);
				url=url+"&strState="+URLEncode(document.getElementById("subcontractor_txtState").value);
				url=url+"&strZipCode="+URLEncode(document.getElementById("subcontractor_txtZipCode").value);
				url=url+"&strFax="+URLEncode(document.getElementById("subcontractor_txtFax").value);
				url=url+"&strContPerson="+URLEncode(document.getElementById("subcontractor_txtContactPerson").value);
				url=url+"&strContPhone="+URLEncode(document.getElementById("subcontractor_txtContPhone").value);
				url=url+"&strVatNo="+URLEncode(document.getElementById("subcontractor_txtVatNo").value);
				 //setTimeout("location.reload(true);",1000);
			}
			else
			{
				url=url+"&strName="+URLEncode(document.getElementById("subcontractor_txtName").value);
				url=url+"&strAddress1="+URLEncode(document.getElementById("subcontractor_txtAddress1").value);
				
				url=url+"&strStreet="+URLEncode(document.getElementById("subcontractor_txtStreet").value);
				url=url+"&strCity="+URLEncode(document.getElementById("subcontractor_txtCity").value);
				url=url+"&strCountry="+URLEncode(document.getElementById("subcontractor_txtCountry").value);
				url=url+"&strPhone="+URLEncode(document.getElementById("subcontractor_txtPhone").value);
				url=url+"&strEmail="+URLEncode(document.getElementById("subcontractor_txtEmail").value);
				url=url+"&strWeb="+URLEncode(document.getElementById("subcontractor_txtWeb").value);
				url=url+"&strRemarks="+URLEncode(document.getElementById("subcontractor_txtRemarks").value);
				url=url+"&strState="+URLEncode(document.getElementById("subcontractor_txtState").value);
				url=url+"&strZipCode="+URLEncode(document.getElementById("subcontractor_txtZipCode").value);
				url=url+"&strFax="+URLEncode(document.getElementById("subcontractor_txtFax").value);
				url=url+"&strContPerson="+URLEncode(document.getElementById("subcontractor_txtContactPerson").value);
				url=url+"&strContPhone="+URLEncode(document.getElementById("subcontractor_txtContPhone").value);
				url=url+"&strVatNo="+URLEncode(document.getElementById("subcontractor_txtVatNo").value);
			}
			
			if(document.getElementById("subcontractor_chkActive").checked==true)
			{
				var intStatus = 1;	
			}
			else
			{
				var intStatus = 0;
			}
			
			url=url+"&intStatus="+intStatus; 
			
			xmlHttp.onreadystatechange=stateSCChanged;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
		}
		
	}
	
function stateSCChanged() 
{ 
if (xmlHttp.readyState==4 && xmlHttp.status==200)
 { 
 	//document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
	alert(xmlHttp.responseText);
	loadCombo('SELECT strSubContractorID, strName FROM subcontractors where intStatus<>10 order by strName ASC','subcontractor_cboSearch');
	clearFields();
	//getSubContractors();
 	//clearFormSC();
 } 
}



function clearFormSC()
{	
	xmlHttp1=GetXmlHttpObject();
	if (xmlHttp1==null)
	{
		alert ("Browser does not support HTTP Request");
		 return;
	} 
	xmlHttp1.onreadystatechange = clearFormResSC;
	xmlHttp1.open("GET", 'db.php?q=clearReq', true);
	xmlHttp1.send(null);  
}
function clearFormResSC()
{
	if(xmlHttp1.readyState == 4) 
	{
		if(xmlHttp1.status == 200) 
		{
			document.getElementById("subcontractor_cboSearch").innerHTML  = xmlHttp1.responseText;
		clearFields();
		}
	}
}
function clearFields()
{
/*	document.getElementById("subcontractor_cboSearch").value="";
	document.getElementById("subcontractor_txtName").value="";
	document.getElementById("subcontractor_txtAddress1").value="";
	document.getElementById("subcontractor_txtAddress1").value="";
	document.getElementById("subcontractor_txtAddress2").value="";
	document.getElementById("subcontractor_txtStreet").value="";
	document.getElementById("subcontractor_txtCity").value="";
	document.getElementById("subcontractor_txtCountry").value="";
	document.getElementById("subcontractor_txtPhone").value="";
	document.getElementById("subcontractor_txtEmail").value="";
	document.getElementById("subcontractor_txtWeb").value="";
	document.getElementById("subcontractor_txtRemarks").value="";
	document.getElementById("subcontractor_txtState").value="";
	document.getElementById("subcontractor_txtZipCode").value="";
	document.getElementById("subcontractor_txtFax").value="";
	document.getElementById("subcontractor_txtContactPerson").value="";
	document.getElementById("subcontractor_txtContPhone").value="";
	document.getElementById("subcontractor_txtVatNo").value="";
	document.getElementById("subcontractor_txtName").focus();*/
	document.frmSubContranctors.reset();
	document.getElementById("subcontractor_txtName").focus();
}

function ConformSCDelete(strCommand)
{
	if(document.getElementById("subcontractor_cboSearch").value!="")
	{
		var boolDelete=confirm('Are you sure you want to delete \n"'+document.getElementById("subcontractor_txtName").value+'" ?');
		if (boolDelete==true)
		{
			DeleteSCData(strCommand);
		}
	}
	else
	{
		alert("Please select a \"Subcontractor\".");	
		document.getElementById('subcontractor_cboSearch').focus();
	}
}


function getSubContractors()
{
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
		var url="find.php";
		var subCon=document.getElementById('subcontractor_cboSearch').value;
		if(subCon.trim()=="")
		{
			clearFields();
			return false;
		}
		url=url+"?q="+subCon;
		xmlHttp.onreadystatechange=ShowBuyerDetails;		
		xmlHttp.open("GET",url,true);		
		xmlHttp.send(null);
}

	function ShowBuyerDetails()
	{
	if(document.getElementById('divlistORDetails').style.visibility == "visible"){
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
	 document.frmSubContranctors.radioListORdetails[0].checked = false;
	 document.frmSubContranctors.radioListORdetails[1].checked = false;
				
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{		
				
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strName");				
				document.getElementById('subcontractor_txtName').value = XMLAddress1[0].childNodes[0].nodeValue;	
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strAddress1");				
				document.getElementById('subcontractor_txtAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;		
				
			
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strStreet");
				document.getElementById('subcontractor_txtStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCity");
				document.getElementById('subcontractor_txtCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strCountry");
				document.getElementById('subcontractor_txtCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strPhone");
				document.getElementById('subcontractor_txtPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strEmail");
				document.getElementById('subcontractor_txtEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strWeb");
				document.getElementById('subcontractor_txtWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strRemarks");
				document.getElementById('subcontractor_txtRemarks').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strState");
				document.getElementById('subcontractor_txtState').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strZipCode");
				document.getElementById('subcontractor_txtZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strFax");
				document.getElementById('subcontractor_txtFax').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strContPerson");
				document.getElementById('subcontractor_txtContactPerson').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strContPhone");
				document.getElementById('subcontractor_txtContPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatReg");
				document.getElementById('subcontractor_txtVatNo').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
								
				if(XMLAddress1[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("subcontractor_chkActive").checked=true;	
				}
				else
				{
					document.getElementById("subcontractor_chkActive").checked=false;	
				}
				document.getElementById("txtHint").innerHTML='';
				
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

function clearFormSC()
    {
	 clearFields();
	
	}

function DeleteSCData(strCommand)
{
		
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
	var url="db.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&intID="+document.getElementById("subcontractor_cboSearch").value;
		clearFields();
	}

	xmlHttp.onreadystatechange=stateSCChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	clearFormSC();
	
}

//	function backtopage()
//	{
//		window.location.href="main.php";
//	}

	function checkvalue()
	{
	if(document.getElementById('subcontractor_txtName').value.trim()!="")
	document.getElementById("subcontractor_txtAddress1").focus();
	}
	
	//----------------------------------------------REPORT--------------------------------------------------

function listORDetails()
{
	 document.frmSubContranctors.radioListORdetails[0].checked = false;
	 document.frmSubContranctors.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	document.getElementById('divlistORDetails').style.visibility = "visible";
	else
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	 	
}

function load_SC_Report(){ 
		document.getElementById('divlistORDetails').style.visibility = "hidden";

 if(document.frmSubContranctors.radioListORdetails[0].checked == true){
	    var cboSearch = document.getElementById('subcontractor_cboSearch').value;
	    var radioListORdetails = document.frmSubContranctors.radioListORdetails[0].value;
		window.open("SubConListReport.php?cboSearch=" + cboSearch,"new1"); 
 }else{
	  var cboSearch = document.getElementById('subcontractor_cboSearch').value;
	  if(cboSearch != ""){
	  var radioListORdetails = document.frmSubContranctors.radioListORdetails[1].value;
      window.open("SubConDetailsReport.php?cboSearch=" + cboSearch,"new2"); 
	  }else{
		alert("Please select a Subcontractor.");  
	  }
 }
}
//--------hem---------------------
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
//@@@@@@@@@@@@@@@@@@@@@@@@@@@	country	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showCountryPopUpp()
{
		var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 0;
	var H	= 0;
	var closePopUp = "closeCountryModePopUp";
	var tdPopUpClose = "country_popup_close_button";
	var td_header = "td_coHeader";
	var td_delete = "td_coDelete";
	CreatePopUp2(url,W,H,closePopUp,td_header,td_delete,tdPopUpClose);	
}
	
function closeCountryModePopUp(id)
{
	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCountryModeRequest;
	xmlHttp.open("GET", 'db.php?q=LoadCountryMode', true);
   	xmlHttp.send(null);
}
function LoadCountryModeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('subcontractor_txtCountry').innerHTML = XMLText;
		document.getElementById('subcontractor_txtZipCode').value = '';
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

function GetSubContractZipCode(obj)
{
	document.getElementById('subcontractor_txtZipCode').value = "";
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = GetSubContractZipCodeRequest;
	xmlHttp.open("GET", 'db.php?q=GetCountryZipCode&countryId=' +obj, true);
   	xmlHttp.send(null);
}

function GetSubContractZipCodeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('subcontractor_txtZipCode').value = XMLText;
	}
}
