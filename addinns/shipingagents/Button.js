var xmlHttp;
var xmlHttp1;

//Insert & Update Data (Save Data)
function butCommand(strCommand)
	{        
		   if(document.getElementById('shipingagents_txtName').value.trim()=="" )
			{
				alert("Please Enter Agent Name");	
				return false;
			}
			else
			{
	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	  
	  if(document.getElementById('shipingagents_cboCustomer').value.trim()=="")
	  strCommand="New";
	  
	        var url="Button.php";
			url=url+"?q="+strCommand;
			
	if(strCommand=="Save"){ 
			
			url+="&intAgentId="+document.getElementById("shipingagents_cboCustomer").value;		
			url+="&strName="+document.getElementById("shipingagents_txtName").value;
			url+="&strAddress1="+document.getElementById("shipingagents_txtAddress1").value;
			url+="&strAddress2="+document.getElementById("shipingagents_txtAddress2").value;
			url+="&strStreet="+document.getElementById("shipingagents_txtStreet").value;
			url+="&strCity="+document.getElementById("shipingagents_txtCity").value;
			url+="&strState="+document.getElementById("shipingagents_txtState").value;
			url+="&strCountry="+document.getElementById("shipingagents_txtCountry").value;
			url+="&strZipCode="+document.getElementById("shipingagents_txtZipCode").value;
			url+="&strPhone="+document.getElementById("shipingagents_txtPhone").value;
			url+="&strEMail="+document.getElementById("shipingagents_txtEmail").value;
			url+="&strFax="+document.getElementById("shipingagents_txtFax").value;
			url+="&strWeb="+document.getElementById("shipingagents_txtWeb").value;
			url+="&strContactPerson="+document.getElementById("shipingagents_txtcontactper").value;
			url+="&strRemarks="+document.getElementById("shipingagents_txtRemarks").value;
			//setTimeout("location.reload(true);",1000);
			
			
		}
		else
		{   url+="&intAgentId="+document.getElementById("shipingagents_cboCustomer").value;		
			url+="&strName="+document.getElementById("shipingagents_txtName").value;
			url+="&strAddress1="+document.getElementById("shipingagents_txtAddress1").value;
			url+="&strAddress2="+document.getElementById("shipingagents_txtAddress2").value;
			url+="&strStreet="+document.getElementById("shipingagents_txtStreet").value;
			url+="&strCity="+document.getElementById("shipingagents_txtCity").value;
			url+="&strState="+document.getElementById("shipingagents_txtState").value;
			url+="&strCountry="+document.getElementById("shipingagents_txtCountry").value;
			url+="&strZipCode="+document.getElementById("shipingagents_txtZipCode").value;
			url+="&strPhone="+document.getElementById("shipingagents_txtPhone").value;
			url+="&strEMail="+document.getElementById("shipingagents_txtEmail").value;
			url+="&strFax="+document.getElementById("shipingagents_txtFax").value;
			url+="&strWeb="+document.getElementById("shipingagents_txtWeb").value;
			url+="&strContactPerson="+document.getElementById("shipingagents_txtcontactper").value;
			url+="&strRemarks="+document.getElementById("shipingagents_txtRemarks").value;
			
			}

	if(document.getElementById("shipingagents_chkActive").checked==true)
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
 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 //setTimeout("location.reload(true);",1000);
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
			document.getElementById("shipingagents_cboCustomer").innerHTML  = xmlHttp1.responseText;
		}
	}
		clearFields();
}

function clearFields()
{
	document.getElementById("txtHint").innerHTML="";
	document.getElementById("shipingagents_cboCustomer").value = "";
	document.getElementById("shipingagents_txtName").value = "";
	document.getElementById("shipingagents_txtAddress1").value = "";
	document.getElementById("shipingagents_txtAddress2").value = "";
	document.getElementById("shipingagents_txtStreet").value = "";
	document.getElementById("shipingagents_txtCity").value = "";
	document.getElementById("shipingagents_txtState").value = "";
	document.getElementById("shipingagents_txtCountry").value = "";
	document.getElementById("shipingagents_txtPhone").value = "";
	document.getElementById("shipingagents_txtFax").value = "";
	document.getElementById("shipingagents_txtZipCode").value = "";
	document.getElementById("shipingagents_txtEmail").value = "";
	document.getElementById("shipingagents_txtWeb").value = "";
	document.getElementById("shipingagents_txtcontactper").value = "";
	document.getElementById("shipingagents_txtRemarks").value = "";
	document.getElementById("shipingagents_txtName").focus();
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
  
	var url="Button.php";
	url=url+"?q="+strCommand;
	
	if(strCommand=="Delete"){ 		
		url+="&intAgentId="+document.getElementById("shipingagents_cboCustomer").value;
		//setTimeout("location.reload(true);",1000);
		
	}

	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	ClearForm();
	
}
	
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	
	function ClearForm()
	{	
/*		document.getElementById("txtHint").innerHTML="";
		document.getElementById("txtBankCode").value = "";
		document.getElementById("txtName").value = "";
		document.getElementById("txtAddress1").value = "";
		document.getElementById("txtAddress2").value = "";
		document.getElementById("txtCountry").value = "";
		document.getElementById("txtPhone").value = "";
		document.getElementById("txtFax").value = "";
		document.getElementById("txtEMail").value = "";
		document.getElementById("txtRefNo").value = "";
		document.getElementById("txtContactPerson").value = "";
		document.getElementById("txtRemarks").value = "";	*/
		//setTimeout("location.reload(true);",1000);
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
function getAgentDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('shipingagents_cboCustomer').value=='')
	{
		clearFields();
		return false;
	}
		
		var AgentId = document.getElementById('shipingagents_cboCustomer').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowAgentDetails;
		xmlHttp.open("GET", "shipingagentsmiddle.php?AgentId="+AgentId, true);
		
		xmlHttp.send(null);   
		
	}

	function ShowAgentDetails()
	{
	if(document.getElementById('divlistORDetails').style.visibility == "visible"){
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
	 document.frmshipingag.radioListORdetails[0].checked = false;
	 document.frmshipingag.radioListORdetails[1].checked = false;
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Name");
				document.getElementById('shipingagents_txtName').value = XMLAddress1[0].childNodes[0].nodeValue;	
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address1");
				document.getElementById('shipingagents_txtAddress1').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address2");
				document.getElementById('shipingagents_txtAddress2').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Street");
				document.getElementById('shipingagents_txtStreet').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("City");
				document.getElementById('shipingagents_txtCity').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("State");
				document.getElementById('shipingagents_txtState').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Country");
				document.getElementById('shipingagents_txtCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ZipCode");
				document.getElementById('shipingagents_txtZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Phone");
				document.getElementById('shipingagents_txtPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
			    var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMail");
				document.getElementById('shipingagents_txtEmail').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Fax");
				document.getElementById('shipingagents_txtFax').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Web");
				document.getElementById('shipingagents_txtWeb').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ContactPerson");
				document.getElementById('shipingagents_txtcontactper').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Remarks");
				document.getElementById('shipingagents_txtRemarks').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
								
				if(XMLAddress1[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("shipingagents_chkActive").checked=true;	
				}
				else
				{
					document.getElementById("shipingagents_chkActive").checked=false;	
				}
		
				
				
			}
		}
	}


	
	function ConfirmDelete(strCommand)
	{
		if(document.getElementById('shipingagents_txtName').value=="")
		{
			alert("Please Enter Agent Name");
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
		if(document.getElementById('shipingagents_txtName').value=="" )
		{
			alert("Please Enter Agent Name");	
			return false;
		}
		
		else if(!isValidEmail(document.getElementById('shipingagents_txtEmail').value))
		{
			alert("Please Enter Valid Email");	
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
	 document.frmshipingag.radioListORdetails[0].checked = false;
	 document.frmshipingag.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
	document.getElementById('divlistORDetails').style.visibility = "visible";
	else
	document.getElementById('divlistORDetails').style.visibility = "hidden";
	 	
}

function loadReport(){ 
 if(document.frmshipingag.radioListORdetails[0].checked == true){
	    var cboCustomer = document.getElementById('shipingagents_cboCustomer').value;
	    var radioListORdetails = document.frmshipingag.radioListORdetails[0].value;
		window.open("ShipAgeReportList.php?cboCustomer=" + cboCustomer); 
 }else{
	  var cboCustomer = document.getElementById('shipingagents_cboCustomer').value;
	  if(cboCustomer != ""){
	  var radioListORdetails = document.frmshipingag.radioListORdetails[1].value;
      window.open("ShipAgeReportDetails.php?cboCustomer=" + cboCustomer); 
	  }else{
		alert("Please Select a Bank");  
	  }
 }
}

//--------hem---------------------
//@@@@@@@@@@@@@@@@@@@@@@@@@@@	country	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showCountryPopUpp()
{
		var url  = "../country/countries.php?";
	inc('../country/Button.js');
	var W	= 520;
	var H	= 270;
	var closePopUp = "closeCountryModePopUp";
	CreatePopUp(url,W,H,closePopUp);	
}
	
function closeCountryModePopUp()
{
	//obj.parentNode.removeChild(obj);
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCountryModeRequest;
	xmlHttp.open("GET", 'button.php?q=LoadCountryMode', true);
   	xmlHttp.send(null);
}
function LoadCountryModeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('shipingagents_txtCountry').innerHTML = XMLText;
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

