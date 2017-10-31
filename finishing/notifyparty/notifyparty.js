// JavaScript Document
// JavaScript Document

function SaveBuyerBranchData()
{
	document.getElementById("Save").style.display="none";
	showPleaseWait();
	if(!validateData())
	return;
	var notifyID	 = $('#cboSearch').val();
	var NName	 	 = $('#txtNotifyName').val();
	var branchId 	 = $('#cboBranch').val();
	var Country		 = $('#cboCountry').val();
	var CAddress1	 = $('#txtAddress1').val();
	var CAddress2	 = $('#txtAddress2').val();
	var CAddress3	 = $('#txtAddress3').val();
	var telNo		 = $('#txtTelNo').val();
	var FaxNo		 = $('#txtFaxNo').val();
	var Email		 = $('#txtEmail').val();
	var CPerson		 = $('#txtCotactPerson').val();
	var Remarks		 = $('#txtRemarks').val();
	
	var url = 'notifypartydb.php?Request=SaveData&NName='+URLEncode(NName)+ '&branchId=' +branchId+ '&Country=' +Country+'&CAddress1='+URLEncode(CAddress1)+ '&CAddress2=' +URLEncode(CAddress2)+ '&CAddress3=' +URLEncode(CAddress3)+'&telNo='+URLEncode(telNo)+ '&FaxNo=' +URLEncode(FaxNo)+ '&Email=' +URLEncode(Email)+ '&CPerson=' +URLEncode(CPerson)+ '&Remarks=' +URLEncode(Remarks)+ '&notifyID=' +notifyID;
	xml_http_obj=$.ajax({url:url,async:false});
	
	if(xml_http_obj.responseText=="Saved")
	{
		
		alert("saved successfully.")
		document.getElementById("Save").style.display="inline";
		window.location.href='notifyparty.php';
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="Updated")
	{
		alert("updated successfully.");
		document.getElementById("Save").style.display="inline";
		window.location.href='notifyparty.php';
		
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="cant")
	{
		alert("Notify name already exist..");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		document.getElementById('txtNotifyName').focus();
	}
	else
	{
		alert("Error");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
	}	
	
}
function validateData()
{
	if(document.getElementById('txtNotifyName').value == "" )
	{
		alert("Please enter Notify Name.");
		document.getElementById('txtNotifyName').focus();
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(document.getElementById('cboBranch').value=="" )
	{
		alert("Please select a Branch.");
		document.getElementById('cboBranch').focus();
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		return false;
	}
	else if(document.getElementById('cboCountry').value == "" )
	{
		alert("Please select a Country.");
		document.getElementById('cboCountry').focus();
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		return false;
	}
	else if(document.getElementById('txtEmail').value.trim() != "" )
	{
		var email = document.getElementById('txtEmail').value;
		if(!emailValidate(email))
		{
			alert("Please enter valid E-mail Address.");
			document.getElementById("txtEmail").focus();
			document.getElementById("Save").style.display="inline";
			hidePleaseWait();
			return false;
		}
	}
	return true;
}
function setData(notifyId)
{
	var notifyID = notifyId;
	var url = 'notifypartydb.php?Request=GetData&notifyID='+notifyID;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLNotifyName		= htmlobj.responseXML.getElementsByTagName("strNotifyName");
	var XMLBuyerBranchId	= htmlobj.responseXML.getElementsByTagName("intBuyerBranchId");
	var XMLCountryId		= htmlobj.responseXML.getElementsByTagName("intCountryId");
	var XMLAddress1			= htmlobj.responseXML.getElementsByTagName("Address1");
	var XMLAddress2			= htmlobj.responseXML.getElementsByTagName("Address2");
	var XMLAddress3			= htmlobj.responseXML.getElementsByTagName("Address3");
	var XMLstrTel			= htmlobj.responseXML.getElementsByTagName("strTel");
	var XMLstrFax			= htmlobj.responseXML.getElementsByTagName("strFax");
	var XMLstrEmail			= htmlobj.responseXML.getElementsByTagName("strEmail");
	var XMLAgentName		= htmlobj.responseXML.getElementsByTagName("strAgentName");
	var XMLstrRemarks		= htmlobj.responseXML.getElementsByTagName("strRemarks");
	
	document.getElementById('txtNotifyName').value 			= XMLNotifyName[0].childNodes[0].nodeValue;
	document.getElementById('cboBranch').value 				= XMLBuyerBranchId[0].childNodes[0].nodeValue;
	document.getElementById('cboCountry').value 			= XMLCountryId[0].childNodes[0].nodeValue;
	document.getElementById('txtAddress1').value 			= XMLAddress1[0].childNodes[0].nodeValue;
	document.getElementById('txtAddress2').value 			= XMLAddress2[0].childNodes[0].nodeValue;
	document.getElementById('txtAddress3').value 			= XMLAddress3[0].childNodes[0].nodeValue;
	document.getElementById('txtTelNo').value 				= XMLstrTel[0].childNodes[0].nodeValue;
	document.getElementById('txtFaxNo').value 				= XMLstrFax[0].childNodes[0].nodeValue;
	document.getElementById('txtEmail').value 				= XMLstrEmail[0].childNodes[0].nodeValue;
	document.getElementById('txtCotactPerson').value 		= XMLAgentName[0].childNodes[0].nodeValue;
	document.getElementById('txtRemarks').value 			= XMLstrRemarks[0].childNodes[0].nodeValue;
	
}
function ClearForm()
{
	document.notifyParty.reset();
}
function deleteData()
{
	document.getElementById("Delete").style.display="none";
	showPleaseWait();
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select a Notify.")
		document.getElementById("Delete").style.display="inline";
		document.getElementById('cboSearch').focus();
		hidePleaseWait();
		return;
	}
	var notifyID = $('#cboSearch').val();
	var bname=	document.getElementById("cboSearch").options[document.getElementById("cboSearch").selectedIndex].text;
	var ans=confirm("Are you sure you want to  delete '" +bname+ "' ?");
		if (ans)
		{
			var url = 'notifypartydb.php?Request=deleteData&notifyID='+notifyID;
			xml_http_obj=$.ajax({url:url,async:false});
			if(xml_http_obj.responseText=="Deleted")
			{
				alert("Deleted successfully");
				document.getElementById("Delete").style.display="inline";
				window.location.href='notifyparty.php';
				hidePleaseWait();
			}
			if(xml_http_obj.responseText=="Error")
			{
				alert("Error");
				document.getElementById("Delete").style.display="inline";
				hidePleaseWait();
			}
		}
		else
		{
			document.getElementById("Delete").style.display="inline";
			hidePleaseWait();
		}

}