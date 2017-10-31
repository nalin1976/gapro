var xmlHttp;


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

function ValidateSupplierInterface()
{
	if(document.getElementById('txtSupplierCode').value.trim() == "" )
	{
		alert("Please enter \"Supplier Code\".");
		document.getElementById("txtSupplierCode").focus();
		document.getElementById("txtSupplierCode").select();
		return false;
	}
	else if(document.getElementById('txtcompany').value.trim() == "" )
	{
		alert("Please enter \"Company\".");
		document.getElementById("txtcompany").focus();
		document.getElementById("txtcompany").select();
		return false;
	}
	else if(isNumeric(document.getElementById('txtcompany').value)){
		alert("Company Name must be an \"Alfanumeric\" value.");
		document.getElementById('txtcompany').focus();
		document.getElementById("txtcompany").select();
		return;
	}
	else if(document.getElementById('cbocurrency').value.trim() == 0 )
	{
		alert("Please select \"Currency\".");
		document.getElementById("cbocurrency").focus();
		return false;
	}
	else if(document.getElementById('cboorigin').value.trim() == 0 )
	{
		alert("Please select \"Origin\".");
		document.getElementById("cboorigin").focus();
		return false;
	} 
	else if(document.getElementById('cboCountry').value.trim() == 0 )
	{
		alert("Please select \"Country\".");
		document.getElementById("cboCountry").focus();
		return false;
	} 
	else if(document.getElementById('txtemail').value.trim() != "" )
	{
		var email = document.getElementById('txtemail').value;
		if(!emailValidate(email))
		{
			alert("Please enter valid e-mail address.");
			document.getElementById("txtemail").focus();
			document.getElementById("txtemail").select();
			return false;
		}
	}
	if(document.getElementById('chkvat').checked==true )
	{
		if(document.getElementById("txtSVATNo").value=="")
		{
			alert("Please enter SAVT No.");
			document.getElementById("txtSVATNo").focus();
			return false;
		}	
	}
	
return true;
}
function handleSVATNo()
{
	
	
	if(document.getElementById("chkvat").checked==true)
	{
		document.getElementById("txtSVATNo").disabled=false;
	}
	else
	{
		document.getElementById("txtSVATNo").disabled=true;
		document.getElementById("txtSVATNo").value="";
	}
}

function ValidateSupplierBeforeSave()
{	
	var x_id = document.getElementById("cbosearch").value
	var x_name = document.getElementById("txtSupplierCode").value
	
	var x_find = checkInField('suppliers','strSupplierCode',x_name,'strSupplierID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("txtSupplierCode").focus();
		return false;
	}
	
	var x_id = document.getElementById("cbosearch").value
	var x_name = document.getElementById("txtcompany").value
	
	var x_find = checkInField('suppliers','strTitle',x_name,'strSupplierID',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("txtcompany").focus();
		return false;
	}
	return true;
}

//Insert & Update Data (Save Data)
function SupplierButCommand(strCommand)
{	
	if(!ValidateSupplierInterface())
	return;
		
	if(!ValidateSupplierBeforeSave())	
		return;
		
	if(document.getElementById('chksupplier').checked == true){
		if(document.getElementById('txtUsrName').value==""){
			alert("Please select the Approved Supplier");	
			return false;		
		}
	}
		
	if(trim(document.getElementById('txtcompany').value)=="")
	{
		alert("Please Enter Company Name");
		return false;			
	}
	else if(document.getElementById('cbocurrency').value=="")
	{
		alert("Please select currency");	
		return false;			
	}	
	else if(document.getElementById('cboorigin').value=="")
	{
		alert("Please select origin");	
		return false;			
	}
	else if(trim(document.getElementById('txtsupplier').value)=="")
	{
		alert("Please enter valid supplier status");	
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
		   
		if(document.getElementById('cbosearch').value=="" ){
		 	strCommand="New";
		}
		
		var url="Button.php";
	    url=url+"?q="+strCommand;
		
			 
	    if(strCommand=="Save")
		{ 
		url+="&supplierCode="+URLEncode(trim(document.getElementById("txtSupplierCode").value));
		url+="&SupplierID="+document.getElementById("cbosearch").value;
		url+="&ComName="+URLEncode(trim(document.getElementById("txtcompany").value));
		url+="&VatReNo="+URLEncode(trim(document.getElementById("txtvatrn").value));
		url+="&Address1="+URLEncode(trim(document.getElementById("txtaddress1").value));
		url+="&Option1="+URLEncode(trim(document.getElementById("txtOption1").value));
		url+="&Option2="+URLEncode(trim(document.getElementById("txtOption2").value));
		url+="&Option3="+URLEncode(trim(document.getElementById("txtOption3").value));
		url+="&ContactPerson="+URLEncode(trim(document.getElementById("txtContactPerson").value));
		url+="&street="+URLEncode(trim(document.getElementById("txtstreet").value));
		url+="&City="+URLEncode(trim(document.getElementById("txtCity").value));
		url+="&State="+URLEncode(trim(document.getElementById("txtState").value));
		url+="&Country="+document.getElementById("cboCountry").value;
		url+="&ZipCode="+URLEncode(trim(document.getElementById("txtZipCode").value));
		url+="&Phone="+URLEncode(trim(document.getElementById("txtPhone").value));
		url+="&Fax="+URLEncode(trim(document.getElementById("txtFax").value));
		url+="&email="+URLEncode(trim(document.getElementById("txtemail").value));
		url+="&Web="+URLEncode(trim(document.getElementById("txtweb").value));
		url+="&Remarks="+URLEncode(trim(document.getElementById("txtremarks").value));
		url+="&Keyitems="+URLEncode(trim(document.getElementById("txtkeyitms").value)); 
		url+="&Currcncy="+document.getElementById("cbocurrency").value;
		url+="&Origin="+document.getElementById("cboorigin").value;
		url+="&Taxtype="+document.getElementById("cbotax").value;
		url+="&Creditperi="+document.getElementById("cbocredit").value;
		url+="&intShipmentModeId="+document.getElementById("cboshipment").value;
		url+="&strShipmentTermId="+document.getElementById("cboshipmentTerm").value;
		url+="&strPayModeId="+document.getElementById("cbopaymode").value;
		url+="&strPayTermId="+document.getElementById("cbopayterms").value;
		url+="&cboSupApp="+document.getElementById("cboSupApp").value;
		url+="&txtApprComments="+URLEncode(trim(document.getElementById("txtApprComments").value));
		url+="&VATNo="+URLEncode(trim(document.getElementById("txtVATNo").value));
		url+="&fabRefNo="+URLEncode(trim(document.getElementById("txtAddinsFabRefNo").value));
		url +="&accPaccID="+URLEncode(trim(document.getElementById("txtaccPaccId").value));
		url +="&SVATNo="+URLEncode(trim(document.getElementById("txtSVATNo").value));
		
		if(document.getElementById('txtsupplier').value == '10'){
			var txtReason = document.getElementById('txtReason').value;
			if(txtReason == ""){
				alert("Please enter a Reason");
				document.getElementById('txtReason').focus();
				return false;
			}else{
			 	url+="&txtReason="+URLEncode(trim(document.getElementById("txtReason").value));	
			}
		}else{
			url+="&txtReason="+"";	
		}
		
		if(document.getElementById("chktax").checked==true)
		{
			var taxenable = 1;	
		}
		else
		{
			var taxenable = 0;
		}
		
	   if(document.getElementById("chkcredit").checked==true)
		{
			var creditallowed = 1;	
		}
		else
		{
			var creditallowed = 0;
		}
		
		if(document.getElementById("chkvat").checked==true)
		{
			var vatsuspended = 1;	
		}
		else
		{
			var vatsuspended = 0;
		}
		
		if(document.getElementById("chksupplier").checked==true)
		{
			var supplierappo = 1;	
		}
		else
		{
			var supplierappo = 0;
		}
        
		var entryNoRequire = ((document.getElementById('chkEntryNoRequire').checked) ? 1:0);
		
		var SupplierStatus = trim(document.getElementById("txtsupplier").value);
		if(SupplierStatus>10)
		{
		alert("Please enter valid supplier status");
		return false;
		}
		url+="&taxenable="+taxenable+"&creditallowed="+creditallowed+"&vatsuspended="+vatsuspended+"&SupplierStatus="+SupplierStatus+"&supplierappo="+supplierappo+"&EntryNoRequire="+entryNoRequire;
		}
		else
		{ 
				
		url+="&supplierCode="+URLEncode(trim(document.getElementById("txtSupplierCode").value));
		url+="&SupplierID="+document.getElementById("cbosearch").value;
		url+="&ComName="+URLEncode(trim(document.getElementById("txtcompany").value));
		url+="&VatReNo="+URLEncode(trim(document.getElementById("txtvatrn").value));
		url+="&Address1="+URLEncode(trim(document.getElementById("txtaddress1").value));
	    url+="&Option1="+URLEncode(trim(document.getElementById("txtOption1").value));
		url+="&Option2="+URLEncode(trim(document.getElementById("txtOption2").value));
		url+="&Option3="+URLEncode(trim(document.getElementById("txtOption3").value));
		url+="&ContactPerson="+URLEncode(trim(document.getElementById("txtContactPerson").value));
		url+="&street="+URLEncode(trim(document.getElementById("txtstreet").value));
		url+="&City="+URLEncode(trim(document.getElementById("txtCity").value));
		url+="&State="+URLEncode(trim(document.getElementById("txtState").value));
		url+="&Country="+document.getElementById("cboCountry").value;
		url+="&ZipCode="+URLEncode(trim(document.getElementById("txtZipCode").value));
		url+="&Phone="+URLEncode(trim(document.getElementById("txtPhone").value));
		url+="&Fax="+URLEncode(trim(document.getElementById("txtFax").value));
		url+="&email="+URLEncode(trim(document.getElementById("txtemail").value));
		url+="&Web="+URLEncode(trim(document.getElementById("txtweb").value));
		url+="&Remarks="+URLEncode(trim(document.getElementById("txtremarks").value));
		url+="&Keyitems="+URLEncode(trim(document.getElementById("txtkeyitms").value)); 
		url+="&Currcncy="+document.getElementById("cbocurrency").value;
		url+="&Origin="+document.getElementById("cboorigin").value;
		url+="&Taxtype="+document.getElementById("cbotax").value;
		url+="&Creditperi="+document.getElementById("cbocredit").value;
		url+="&intShipmentModeId="+document.getElementById("cboshipment").value;
		url+="&strShipmentTermId="+document.getElementById("cboshipmentTerm").value;
		url+="&strPayModeId="+document.getElementById("cbopaymode").value;
		url+="&strPayTermId="+document.getElementById("cbopayterms").value;
		url+="&cboSupApp="+document.getElementById("cboSupApp").value;
		url+="&txtApprComments="+URLEncode(trim(document.getElementById("txtApprComments").value));
		url+="&VATNo="+URLEncode(trim(document.getElementById("txtVATNo").value));
		url+="&fabRefNo="+URLEncode(trim(document.getElementById("txtAddinsFabRefNo").value));
		url +="&accPaccID="+URLEncode(trim(document.getElementById("txtaccPaccId").value));
		url +="&SVATNo="+URLEncode(trim(document.getElementById("txtSVATNo").value));
		
		
		   if(trim(document.getElementById('txtsupplier').value) == '10'){
			var txtReason = trim(document.getElementById('txtReason').value);
			if(txtReason == ""){
				alert("Please Enter a Reason");
				document.getElementById('txtReason').focus();
				return false;
			}else{
			 url+="&txtReason="+trim(document.getElementById("txtReason").value);	
			}
		}else{
			url+="&txtReason="+"";	
		}
		
	    if(document.getElementById("chktax").checked==true)
		{
			var taxenable = 1;	
		}
		else
		{
			var taxenable = 0;
		}
		
	   if(document.getElementById("chkcredit").checked==true)
		{
			var creditallowed = 1;	
		}
		else
		{
			var creditallowed = 0;
			url+="&Creditperi="+ null;
		}
		
		if(document.getElementById("chkvat").checked==true)
		{
			var vatsuspended = 1;	
		}
		else
		{
			var vatsuspended = 0;
		}
		
		if(document.getElementById("chksupplier").checked==true)
		{
			var supplierappo = 1;	
		}
		else
		{
			var supplierappo = 0;
		}
        var entryNoRequire = ((document.getElementById('chkEntryNoRequire').checked) ? 1:0);
		var SupplierStatus = trim(document.getElementById("txtsupplier").value);
		if(SupplierStatus>10)
		{
		alert("Please enter valid supplier status");
		return false;
		}
		url+="&taxenable="+taxenable+"&creditallowed="+creditallowed+"&vatsuspended="+vatsuspended+"&SupplierStatus="+SupplierStatus+"&supplierappo="+supplierappo+"&EntryNoRequire="+entryNoRequire; 	
		}
//--Display the feild which are not filled by the user
var err;
err = "";
		if(trim(document.getElementById('txtvatrn').value)=="")
		{
			 err = "VAT Reg No" + '\n';
		}
					
		if (trim(document.getElementById('txtaddress1').value)=="")
		{
			 err = err + "Address" + '\n';
		}
		
		if(trim(document.getElementById('txtstreet').value)=="")
		{
			 err = err + "Street" + '\n';
		}	
		
		if(trim(document.getElementById('txtCity').value)=="")
		{
			err = err + "City" + '\n';
		}
		
		if(trim(document.getElementById('txtState').value)=="")
		{
			 err = err + "State" + '\n';
		}
		
		if(trim(document.getElementById('cboCountry').value)=="")
		{
			  err = err + "Country" + '\n';
		}	
		
		if(trim(document.getElementById('txtPhone').value)=="")
		{
			 err = err + "Phone Number" + '\n';
		}
		
		if(trim(document.getElementById('txtFax').value)=="")
		{
			 err = err + "Fax Number" + '\n';
		}
		
		if(trim(document.getElementById('txtemail').value)=="")
		{
			 err = err + "Email Address" + '\n';
		}
		
		if(trim(document.getElementById('txtweb').value)=="")
		{
			 err = err + "Web Address" + '\n';
			 
		}		
		if (trim(document.getElementById('txtkeyitms').value)=="")
		{
			  err = err + "Key Items" + '\n';
		}
		
		if (document.getElementById('cbotax').value=="")
		{
			 
			 err = err + "Tax Type" + '\n';
		}
		
		if (document.getElementById('cbocredit').value=="")
		{
			 err = err + "Credit Type" + '\n';
			url+="&Creditperi="+ 0; 
		}		

//alert(result);
	if (err != "")
	{
	var ans = confirm("Following fields are not filled. Do you want to continue without fill these feilds? " + '\n' +err);
		if (ans == true)
		{
			
		xmlHttp.onreadystatechange=stateChangedS;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		}
		else
		{
		
		
		}
		
	}
	else
	{
		xmlHttp.onreadystatechange=stateChangedS;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}

} 
}

function stateChangedS() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
 		alert(xmlHttp.responseText);
	    ClearSupplierForm();
	 } 
}
	

function supplier_DeleteData(strCommand)
{		
	var url	 = "Button.php";
		url += "?q="+strCommand;
	
	if(strCommand=="Delete")	
		url=url+"&ComName="+URLEncode(trim(document.getElementById("cbosearch").value));

	var htmlobj=$.ajax({url:url,async:false});
	supplier_delete_stateChanged(htmlobj);
}

function supplier_delete_stateChanged(xmlHttp)
{
	alert(xmlHttp.responseText);
	setTimeout("location.reload(true);",0);
}

function ClearForm()
{	
  setTimeout("location.reload(true);",0);
}

function getSuppliesDetails()
{   
	if(document.getElementById('cbosearch').value=='')
		setTimeout("location.reload(true);",0);
	
	var LoadSupplier = document.getElementById('cbosearch').value;
	
	var url = "Suppliesmiddle.php?LoadSupplier="+LoadSupplier;
	var htmlobj=$.ajax({url:url,async:false});
	ShowSuppliesDetails(htmlobj);		
}

function ShowSuppliesDetails(xmlHttp)
{
document.getElementById('txtSupplierCode').disabled=false;
document.getElementById('txtReason').value = "";
document.getElementById('cboSupApp').value = "";
document.getElementById('cboSupApp').text = "";
document.getElementById('chksupplier').checked = false;

if(document.getElementById('divlistORDetails').style.visibility == "visible")	
	document.getElementById('divlistORDetails').style.visibility = "hidden";

document.frmSupplies.radioListORdetails[0].checked = false;
document.frmSupplies.radioListORdetails[1].checked = false;

	var XMLSupplierCode = xmlHttp.responseXML.getElementsByTagName("SupplierCode");
	document.getElementById('txtSupplierCode').value = XMLSupplierCode[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Title");
	document.getElementById('txtcompany').value = XMLAddress1[0].childNodes[0].nodeValue;	
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("VatRegNo");
	document.getElementById('txtvatrn').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address1");
	document.getElementById('txtaddress1').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Address2");
	var XMLstrOption1 = xmlHttp.responseXML.getElementsByTagName("strOption1");
	document.getElementById('txtOption1').value = XMLstrOption1[0].childNodes[0].nodeValue;
	
	var XMLstrOption2 = xmlHttp.responseXML.getElementsByTagName("strOption2");
	document.getElementById('txtOption2').value = XMLstrOption2[0].childNodes[0].nodeValue;
	
	var XMLstrOption3 = xmlHttp.responseXML.getElementsByTagName("strOption3");
	document.getElementById('txtOption3').value = XMLstrOption3[0].childNodes[0].nodeValue;
	
	var XMLContactPerson = xmlHttp.responseXML.getElementsByTagName("strContactPerson");
	document.getElementById('txtContactPerson').value = XMLContactPerson[0].childNodes[0].nodeValue;
	
	var XMLReason= xmlHttp.responseXML.getElementsByTagName("strReason");
	if(XMLReason[0].childNodes[0].nodeValue != "")
	{
		document.getElementById('reasonBlacklistreason').style.display = "block";		
		document.getElementById('txtReason').value = XMLReason[0].childNodes[0].nodeValue;
	}
	else
		document.getElementById('reasonBlacklistreason').style.display = "none";
	
	var XMLcboSupApp= xmlHttp.responseXML.getElementsByTagName("cboSupApp");
	
	if(XMLcboSupApp[0].childNodes[0].nodeValue != "")
	{
		document.getElementById('ss').style.display    = "block";	
		document.getElementById('chksupplier').checked = true;				
		document.getElementById('cboSupApp').value = XMLcboSupApp[0].childNodes[0].nodeValue;
		var XMLAppComments = xmlHttp.responseXML.getElementsByTagName("strAppComments");
		document.getElementById('txtApprComments').value = XMLAppComments[0].childNodes[0].nodeValue;
	}
	else
	{
		document.getElementById('ss').style.display    = "none";
		document.getElementById('chksupplier').checked = false;
	}


	var XMLKeyItems = xmlHttp.responseXML.getElementsByTagName("strKeyitems");
	document.getElementById('txtkeyitms').value = XMLKeyItems[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Street");
	document.getElementById('txtstreet').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("City");
	document.getElementById('txtCity').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("State");
	document.getElementById('txtState').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Country");
	document.getElementById('cboCountry').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ZipCode");
	document.getElementById('txtZipCode').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Phone");
	document.getElementById('txtPhone').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Fax");
	document.getElementById('txtFax').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("EMail");
	document.getElementById('txtemail').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Web");
	document.getElementById('txtweb').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Remarks");
	document.getElementById('txtremarks').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SupplierStatus");
	document.getElementById('txtsupplier').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Currency");
	document.getElementById('cbocurrency').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Origin");
	document.getElementById('cboorigin').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TaxTypeID");
	document.getElementById('cbotax').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CreditPeriod");
	document.getElementById('cbocredit').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("TaxEnablednew")[0].childNodes[0].nodeValue;
	document.getElementById('chktax').checked =XMLAddress1=="TRUE" ? true : false;
	EnableTaxCombo();
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CreditAllowednew")[0].childNodes[0].nodeValue;
	document.getElementById('chkcredit').checked =XMLAddress1=="TRUE" ? true : false;
	EnableCreditPeriodCombo();
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("VATSuspendednew")[0].childNodes[0].nodeValue;
	document.getElementById('chkvat').checked =XMLAddress1=="TRUE" ? true : false;
	document.getElementById('txtSVATNo').disabled =XMLAddress1=="TRUE" ? false : true;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Approvednew")[0].childNodes[0].nodeValue;
	document.getElementById('chksupplier').checked =XMLAddress1=="TRUE" ? true : false;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("intShipmentModeId");
	document.getElementById('cboshipment').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strShipmentTermId");
	document.getElementById('cboshipmentTerm').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strPayModeId");
	document.getElementById('cbopaymode').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("strPayTermId");
	document.getElementById('cbopayterms').value = XMLAddress1[0].childNodes[0].nodeValue;
	
	var XMLSVATNo = xmlHttp.responseXML.getElementsByTagName("SVATNo");
	document.getElementById('txtSVATNo').value = XMLSVATNo[0].childNodes[0].nodeValue;
	
	var XMLFabricRefNo = xmlHttp.responseXML.getElementsByTagName("FabricRefNo");
	document.getElementById("txtAddinsFabRefNo").value = XMLFabricRefNo[0].childNodes[0].nodeValue;
	
	var XMLAccPaccId = xmlHttp.responseXML.getElementsByTagName("AccPaccID");
	document.getElementById("txtaccPaccId").value = XMLAccPaccId[0].childNodes[0].nodeValue;
	
	var XMLVATNo = xmlHttp.responseXML.getElementsByTagName("VATNo");
	document.getElementById("txtVATNo").value = XMLVATNo[0].childNodes[0].nodeValue;
	
	var XMLEntryNoRequire = xmlHttp.responseXML.getElementsByTagName("EntryNoRequire");
	document.getElementById('chkEntryNoRequire').checked = XMLEntryNoRequire[0].childNodes[0].nodeValue=="1" ? true : false;
	
	var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
	if(XMLused[0].childNodes[0].nodeValue == '1')
		document.getElementById('txtSupplierCode').disabled=true;
	
	if(XMLused[0].childNodes[0].nodeValue == '0')
		document.getElementById('txtSupplierCode').disabled=false;	
}
	
function supplier_ConfirmDelete(strCommand)
{
	var SupplierId	= document.getElementById('cbosearch').value;
	if(trim(SupplierId)=="")
	{
		alert("Please select the Supplier");
		document.getElementById('cbosearch').focus();
	}
	else
	{
		var r=confirm("Are you sure you want to delete \""+document.getElementById('txtcompany').value+"\"?");
		if (r==true)
			supplier_DeleteData(strCommand);
	}		
}

function Blacklistreason(obj)
{
	if(!ValidateRange(obj))
	{
		return;
	}
	var txtsupplier = trim(document.getElementById('txtsupplier').value);
	
	if(txtsupplier == '10')
	{		 
		document.getElementById('reasonBlacklistreason').style.display    = "block";	
		document.getElementById('txtReason').focus();
		document.getElementById('chksupplier').checked = false;
	 
	}
	else
	{
		document.getElementById('reasonBlacklistreason').style.display    = "none";	
		document.getElementById('txtReason').value = "";
	}
}

function supplierApproved()
{
	if(document.getElementById('txtsupplier').value.trim()=='10')
	{
		alert("Sorry, you cannot approved Black Listed Supplier.");
		document.getElementById('chksupplier').checked =false;
		return;
	}
	if(document.getElementById('chksupplier').checked == true)
		document.getElementById('ss').style.display = "inline";	
	else
		document.getElementById('ss').style.display = "none";
}

function ValidateRange(obj)
{
	if(obj>10)
	{
		alert("Supplier Status should be between 1-10");
		document.getElementById('txtsupplier').value = 10;
		document.getElementById('txtsupplier').focus();
		return false;
	}
return true;
}

function SupplierlistORDetails()
{
	document.frmSupplies.radioListORdetails[0].checked = false;
	document.frmSupplies.radioListORdetails[1].checked = false;
	if(document.getElementById('divlistORDetails').style.visibility == "hidden")
		document.getElementById('divlistORDetails').style.visibility = "visible";
	else
		document.getElementById('divlistORDetails').style.visibility = "hidden";	 	
}

function loadSupplierReport()
{ 
	if(document.frmSupplies.radioListORdetails[0].checked == true)
	{
		var cbosearch = document.getElementById('cbosearch').value;
		var radioListORdetails = document.frmSupplies.radioListORdetails[0].value;
		window.open("SuppliersReportList.php?cbosearch=" + cbosearch,'newRep1'); 
		document.getElementById('divlistORDetails').style.visibility = "hidden";
	}
	else
	{
		var cbosearch = document.getElementById('cbosearch').value;
		if(cbosearch != "")
		{
			var radioListORdetails = document.frmSupplies.radioListORdetails[1].value;
			window.open("SuppliersReportDetails.php?cbosearch=" + cbosearch,'newRep2'); 
			document.getElementById('divlistORDetails').style.visibility = "hidden";
		}
		else
			alert("Please Select a Supplier");  
	}
}

function openr(file)
{ 
	if(file=='currency')
	window.open("../currency/Currency.php");
	if(file=='shipment')
	window.open("../shipment/shipment.php");
	if(file=='shipmentTerms')
	window.open("../shipmentterm/shipmentTerm.php");
	if(file=='payMode')
	window.open("../PayMode/PayMode.php");
	if(file=='payTerms')
	window.open("../PayTerm/PayTerm.php");
	if(file=='taxType')
	window.open("../tax/taxType.php");
	if(file=='creditPeriod')
	window.open("../CreditPeriod/CreditPeriodEntry.php");
}

function getRefresh(str1,str2,str3,str4,str5,str6,str7,div1,div2,div3,div4,div5,div6,div7,file)
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url=file;
	url=url+"?q="+document.getElementById(str1).value+"*"+"1";
	url=url+"&sid="+Math.random();
	xmlhttp.divname = div1;
	xmlhttp.onreadystatechange=stateChangedDiv;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
	
	//------------------------------------
	xmlhttp2=GetXmlHttpObject();
	if (xmlhttp2==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url2=file;
	url2=url2+"?q="+document.getElementById(str2).value+"*"+"2";
	url2=url2+"&sid="+Math.random();
	xmlhttp2.divname = div2;
	xmlhttp2.onreadystatechange=stateChangedDiv2;
	xmlhttp2.open("GET",url2,true);
	xmlhttp2.send(null);
	
	//------------------------------------
	xmlhttp3=GetXmlHttpObject();
	if (xmlhttp3==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url3=file;
	url3=url3+"?q="+document.getElementById(str3).value+"*"+"3";
	url3=url3+"&sid="+Math.random();
	xmlhttp3.divname = div3;
	xmlhttp3.onreadystatechange=stateChangedDiv3;
	xmlhttp3.open("GET",url3,true);
	xmlhttp3.send(null);
	
	//------------------------------------
	xmlhttp4=GetXmlHttpObject();
	if (xmlhttp4==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url4=file;
	url4=url4+"?q="+document.getElementById(str4).value+"*"+"4";
	url4=url4+"&sid="+Math.random();
	xmlhttp4.divname = div4;
	xmlhttp4.onreadystatechange=stateChangedDiv4;
	xmlhttp4.open("GET",url4,true);
	xmlhttp4.send(null);
	
	//------------------------------------
	xmlhttp5=GetXmlHttpObject();
	if (xmlhttp5==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url5=file;
	url5=url5+"?q="+document.getElementById(str5).value+"*"+"5";
	url5=url5+"&sid="+Math.random();
	xmlhttp5.divname = div5;
	xmlhttp5.onreadystatechange=stateChangedDiv5;
	xmlhttp5.open("GET",url5,true);
	xmlhttp5.send(null);
	
	//------------------------------------
	xmlhttp6=GetXmlHttpObject();
	if (xmlhttp6==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url6=file;
	url6=url6+"?q="+document.getElementById(str6).value+"*"+"6";
	url6=url6+"&sid="+Math.random();
	xmlhttp6.divname = div6;
	xmlhttp6.onreadystatechange=stateChangedDiv6;
	xmlhttp6.open("GET",url6,true);
	xmlhttp6.send(null);

	//------------------------------------
	xmlhttp7=GetXmlHttpObject();
	if (xmlhttp7==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url7=file;
	url7=url7+"?q="+document.getElementById(str7).value+"*"+"7";
	url7=url7+"&sid="+Math.random();
	xmlhttp7.divname = div7;
	xmlhttp7.onreadystatechange=stateChangedDiv7;
	xmlhttp7.open("GET",url7,true);
	xmlhttp7.send(null);
	
}
//....................................................................
function stateChangedDiv()
{
if (xmlhttp.readyState==4)
{
document.getElementById(xmlhttp.divname).innerHTML=xmlhttp.responseText;
}
}



//....................................................................
function stateChangedDiv2()
{
if (xmlhttp.readyState==4)
{
document.getElementById(xmlhttp2.divname).innerHTML=xmlhttp2.responseText;
}
}
//.................................................................
function stateChangedDiv3()
{
if (xmlhttp.readyState==4)
{
document.getElementById(xmlhttp3.divname).innerHTML=xmlhttp3.responseText;
}
}


//.................................................................
function stateChangedDiv4()
{
if (xmlhttp4.readyState==4)
{
document.getElementById(xmlhttp4.divname).innerHTML=xmlhttp4.responseText;
}
}

//.................................................................
function stateChangedDiv5()
{
if (xmlhttp5.readyState==4)
{
document.getElementById(xmlhttp5.divname).innerHTML=xmlhttp5.responseText;
}
}

//.................................................................
function stateChangedDiv6()
{
if (xmlhttp6.readyState==4)
{
document.getElementById(xmlhttp6.divname).innerHTML=xmlhttp6.responseText;
}
}

//.................................................................
function stateChangedDiv7()
{
if (xmlhttp7.readyState==4)
{
document.getElementById(xmlhttp7.divname).innerHTML=xmlhttp7.responseText;
}
}


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ currency types @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function openPopUpTaxType()
{
	/*
	var url  = "../tax/taxType.php?";
	inc('../tax/taxjs.js');
	//inc('../tax/newMasterData-js.js');
	var W	= 557;
	var H	= 319;
	var closePopUp = "closeTaxTypePopUp";
	CreatePopUp(url,W,H,closePopUp);
	*/
	var url  = "../tax/taxType.php?";
	inc('../tax/taxjs.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closeTaxTypePopUp";
	var tdPopUpClose = "taxTypes_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeTaxTypePopUp(id)
{
	//obj.parentNode.removeChild(obj);
	closePopUpArea(id);
	var sql = "SELECT strTaxTypeID,strTaxType FROM taxtypes WHERE intStatus='1' order by strTaxType;";
	var control = "cbotax";
	loadCombo(sql,control);
}
	function LoadTaxTypesRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			//alert(xmlHttp.responseText);
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cbotax').innerHTML = XMLText;
		}
	}
	
//@@@@@@@@@@@@@@@@@@@@@@@@@@@	Currency	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	loadNewCurruncy2()
{
		var url  = "../currency/Currency.php?";
	inc('../currency/Button.js');
	//inc('../tax/newMasterData-js.js');
	var W	= 0;
	var H	= 242;
	var closePopUp = "closeCurrencyPopUp";

	var tdHeader = "tdHeader";
	var tdDelete = "tdDelete";

    var tdPopUpClose = "currency_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}
	
function closeCurrencyPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCurrencyRequest;
	xmlHttp.open("GET", 'xml.php?id=loadCurrency', true);
   	xmlHttp.send(null);
}
	function LoadCurrencyRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cbocurrency').innerHTML = XMLText;
		}
	}
//@@@@@@@@@@@@@@@@@@@@@@@@@@@	Country	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function loadNewCountry2()
{
		var url  = "../country/Countries.php?";
	inc('../country/Button.js');
	//inc('../tax/newMasterData-js.js');
	var W	= 1000;
	var H	= 308;
	var closePopUp = "closeCountryPopUp";
	CreatePopUp(url,W,H,closePopUp);	
}
	
function closeCountryPopUp()
{
	//obj.parentNode.removeChild(obj);
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCurrencyRequest;
	xmlHttp.open("GET", 'xml.php?id=loadCountry', true);
   	xmlHttp.send(null);
}
	function LoadCurrencyRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cboCountry').innerHTML = XMLText;
		}
	}
	

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	shipment mode	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showPopUpShipmentMode()
{
	/*
		var url  = "../shipment/shipment.php?";
	inc('../shipment/Button.js');
	//inc('../tax/newMasterData-js.js');
	var W	= 556;
	var H	= 218;
	var closePopUp = "closeShipmentModePopUp";
	CreatePopUp(url,W,H,closePopUp);
	*/
		var url  = "../shipment/shipment.php?";
		//var url  = "../country/countries_popup.php?";
	inc('../shipment/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeShipmentModePopUp";
	var tdPopUpClose = "shipmentMode_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function showOrigin()
{
	/*
	var url  = "../itempurchase/itempurchase.php?";
	inc('../itempurchase/Button.js');
	//inc('../tax/newMasterData-js.js');
	var W	= 556;
	var H	= 259;
	var closePopUp = "closeOriginPopUp";
	CreatePopUp(url,W,H,closePopUp);	
	*/
	var url  = "../itempurchase/itempurchase.php?";
		//var url  = "../country/countries_popup.php?";
	inc('../itempurchase/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeOriginPopUp";
	var tdPopUpClose = "originTypes_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

	
function closeOriginPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	/*
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = loadOriginRequest;
	xmlHttp.open("GET", 'xml.php?id=loadOrigin', true);
   	xmlHttp.send(null);
	*/
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = loadOriginRequest;
	xmlHttp.open("GET", 'xml.php?id=loadOrigin', true);
   	xmlHttp.send(null);
}

	function loadOriginRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cboorigin').innerHTML = XMLText;
		}
	}
	
function closeShipmentModePopUp(id)
{
	//obj.parentNode.removeChild(obj);
	/*
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadShipmentModeRequest;
	xmlHttp.open("GET", 'xml.php?id=loadShipmentMode', true);
   	xmlHttp.send(null);
	*/
	
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadShipmentModeRequest;
	xmlHttp.open("GET", 'xml.php?id=loadShipmentMode', true);
   	xmlHttp.send(null);
}
	function LoadShipmentModeRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cboshipment').innerHTML = XMLText;
		}
	}
	

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	showPayModePopUp	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showPayModePopUp()
{
	var url  = "../PayMode/PayMode.php?";
		//var url  = "../country/countries_popup.php?";
	inc('../PayMode/PayModeJS.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closePaymentModePopUp";
	var tdPopUpClose = "paymentMode_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}
	
function closePaymentModePopUp(id)
{
	//obj.parentNode.removeChild(obj);
	/*
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadPaymentModeRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadPaymentMode', true);
   	xmlHttp.send(null);
	*/
	
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadPaymentModeRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadPaymentMode', true);
   	xmlHttp.send(null);
}
	function LoadPaymentModeRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cbopaymode').innerHTML = XMLText;
		}
	}
//showPayModePopUp

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	country	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showCountryPopUpInSupplier()
{
		var url  = "../country/countries.php?";
		//var url  = "../country/countries_popup.php?";
	inc('../country/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeCountryModePopUpInSupplier";
	var tdPopUpClose = "country_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);	
}
	
function closeCountryModePopUpInSupplier(id)
{
	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCountryModeRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadCountryMode', true);
   	xmlHttp.send(null);
}
	function LoadCountryModeRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
			document.getElementById('cboCountry').innerHTML = XMLText;
			document.getElementById('txtZipCode').value = "";
		}
	}
	


//@@@@@@@@@@@@@@@@@@@@@@@@@@@	shipment term	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showShipmentTrmPopUp()
{
	/*
	var url  = "../shipmentterm/shipmentTerm.php?";
	inc('../shipmentterm/Button.js');
	var W	= 512;
	var H	= 218;
	var closePopUp = "closeShipmentTermPopUp";
	CreatePopUp(url,W,H,closePopUp);	
	*/
	var url  = "../shipmentterm/shipmentTerm.php?";
		//var url  = "../country/countries_popup.php?";
	inc('../shipmentterm/Button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "tdHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeShipmentTermPopUp";
	var tdPopUpClose = "shipmentTerms_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}
	
function closeShipmentTermPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	/*
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadShipmentTermRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadShipmentTerm', true);
   	xmlHttp.send(null);
	*/
	
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadShipmentTermRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadShipmentTerm', true);
   	xmlHttp.send(null);
}

function LoadShipmentTermRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('cboshipmentTerm').innerHTML = XMLText;
	}
}

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	Pay term	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showPayTrmPopUp()
{
	/*
	var url  = "../PayTerm/PayTerm.php?";
	inc('../PayTerm/PayTermJS.js');
	var W	= 690;
	var H	= 324;
	var closePopUp = "closePayTermPopUp";
	CreatePopUp(url,W,H,closePopUp);	
	*/
	
	
		var url  = "../PayTerm/PayTerm.php?";
		//var url  = "../country/countries_popup.php?";
	inc('../PayTerm/PayTermJS.js');
	var W	= 350;
	var H	= 100;
	var tdHeader = "tdHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closePayTermPopUp";
	var tdPopUpClose = "paymentTerm_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}
	
function closePayTermPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	/*
	closeWindowtax();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadpayTermRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadPayTerm', true);
   	xmlHttp.send(null);
	*/
    closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadpayTermRequest;
	xmlHttp.open("GET", 'xml.php?id=LoadPayTerm', true);
   	xmlHttp.send(null);
}

function LoadpayTermRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('cbopayterms').innerHTML = XMLText;
	}
}

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	Credit Period	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showCreditPPopUp()
{
	/*
	var url  = "../CreditPeriod/CreditPeriodEntry.php?";
	inc('../CreditPeriod/CreditPeriodJS.js');
	var W	= 530;
	var H	= 333;
	var closePopUp = "closeCreditPeriodPopUp";
	CreatePopUp(url,W,H,closePopUp);	
	*/
	var url  = "../CreditPeriod/CreditPeriodEntry.php?";
	inc('../CreditPeriod/CreditPeriodJS.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "tdDelete";
	var closePopUp = "closeCreditPeriodPopUp";
	var tdPopUpClose = "creditperiod_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}
	
function closeCreditPeriodPopUp(id)
{
	//obj.parentNode.removeChild(obj);
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadpayTermRequestttt;
	xmlHttp.open("GET", 'xml.php?id=LoadCreditPeriod', true);
   	xmlHttp.send(null);
}

function LoadpayTermRequestttt()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('cbocredit').innerHTML = XMLText;
	}
}
//showPayModePopUp
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

//@@@@@@@@@@@@@@@@@@@@@@@@@@@	Currency	@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function	showCountryPopUppp()
{
		var url  = "../currency/currency.php?";
	inc('../currency/Button.js');
	var W	= 520;
	var H	= 270;
	var closePopUp = "closeCurrencyPopUp";
	CreatePopUp(url,W,H,closePopUp);	
}
	
function closeCurrencyPopUp_old()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadCurrencyRequest;
	xmlHttp.open("GET", 'xml.php?id=loadCurrency', true);
   	xmlHttp.send(null);
}

function LoadCurrencyRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('cbocurrency').innerHTML = XMLText;
	}
}
	
function ClearSupplierForm()
{
	document.getElementById('txtSupplierCode').disabled=false;
	document.frmSupplies.reset();
	var sql = "SELECT strSupplierID,strTitle FROM suppliers WHERE intStatus='1' order by strTitle;";
	var control = "cbosearch";
	loadCombo(sql,control);
	document.getElementById('txtSupplierCode').focus();
}

function ShowStyleLoader()
{
	if (document.getElementById('txtSupplierCode').value == null || document.getElementById('txtSupplierCode').value == "")
	{
		alert("Please enter the \"Supplier Code\".");	
		document.getElementById('txtSupplierCode').focus();
		return ;
	}
	
	var supplierCode = document.getElementById('txtSupplierCode').value;
	var	popwindow= window.open ("supplieruploader.php?SupplierCode=" + supplierCode, "Supplier Uploader","location=1,status=1,scrollbars=1,width=450,height=300");
	popwindow.moveTo(((screen.width - 450)/2),((screen.height - 160)/2));
	popwindow.focus();	
}

function RemoveFile(obj,url)
{
	if(confirm('Are you sure you want to remove this item?'))
	{		
		var td = obj.parentNode;
		var tro = td.parentNode;
		tro.parentNode.removeChild(tro);		
		
		createXMLHttpRequest();
		xmlHttp.open("GET", 'xml.php?id=RemoveFile&url='+url, true);
		xmlHttp.send(null);
	}
}

function GetCountryZipCode(obj)
{
	document.getElementById('txtZipCode').value = "";
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = GetCountryZipCodeRequest;
	xmlHttp.open("GET", 'xml.php?id=GetCountryZipCode&countryId=' +obj, true);
   	xmlHttp.send(null);
}

function GetCountryZipCodeRequest()
{
	if(xmlHttp.readyState==4 && xmlHttp.status==200)
	{
		var XMLText = xmlHttp.responseText;			
		document.getElementById('txtZipCode').value = XMLText;
	}
}

function EnableTaxCombo()
{
	if(document.getElementById('chktax').checked)
	{
		document.getElementById('cbotax').disabled = false;
		document.getElementById('imgAddTax').style.visibility = "visible";
	}
	else
	{
		document.getElementById('cbotax').value = "";
		document.getElementById('cbotax').disabled = true;
		document.getElementById('imgAddTax').style.visibility = "hidden";
	}
}

function EnableCreditPeriodCombo()
{
	if(document.getElementById('chkcredit').checked)
	{
		document.getElementById('cbocredit').disabled = false;
		document.getElementById('imgAddCreditPeriod').style.visibility = "visible";
	}
	else
	{
		document.getElementById('cbocredit').disabled = true;
		document.getElementById('cbocredit').value = "";
		document.getElementById('imgAddCreditPeriod').style.visibility = "hidden";
	}
}
