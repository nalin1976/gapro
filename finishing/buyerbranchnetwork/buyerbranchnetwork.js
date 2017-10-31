// JavaScript Document

function SaveBuyerBranchData()
{
	document.getElementById("Save").style.display="none";
	showPleaseWait();
	if(!validateData())
	return;
	var branchID	 = $('#cboSearch').val();
	var BName	 	 = $('#txtBranchName').val();
	var Buyer 	 	 = $('#cboBuyer').val();
	var Country		 = $('#cboCountry').val();
	var CAddress1	 = $('#txtAddress1').val();
	var CAddress2	 = $('#txtAddress2').val();
	var CAddress3	 = $('#txtAddress3').val();
	var telNo		 = $('#txtTelNo').val();
	var FaxNo		 = $('#txtFaxNo').val();
	var Email		 = $('#txtEmail').val();
	var CPerson		 = $('#txtCotactPerson').val();
	var Remarks		 = $('#txtRemarks').val();
	
	var url = 'buyerbranchnetworkdb.php?Request=SaveData&BName='+URLEncode(BName)+ '&Buyer=' +Buyer+ '&Country=' +Country+'&CAddress1='+URLEncode(CAddress1)+ '&CAddress2=' +URLEncode(CAddress2)+ '&CAddress3=' +URLEncode(CAddress3)+'&telNo='+URLEncode(telNo)+ '&FaxNo=' +URLEncode(FaxNo)+ '&Email=' +URLEncode(Email)+ '&CPerson=' +URLEncode(CPerson)+ '&Remarks=' +URLEncode(Remarks)+ '&branchID=' +branchID;
	xml_http_obj=$.ajax({url:url,async:false});
	
	if(xml_http_obj.responseText=="Saved")
	{
		
		alert("saved successfully.")
		document.getElementById("Save").style.display="inline";
		window.location.href='buyerbranchnetwork.php';
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="Updated")
	{
		alert("updated successfully.");
		document.getElementById("Save").style.display="inline";
		window.location.href='buyerbranchnetwork.php';
		
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="cant")
	{
		alert("Branch name already exist..");
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		document.getElementById('txtBranchName').focus();
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
	if(document.getElementById('txtBranchName').value == "" )
	{
		alert("Please enter Branch Name.");
		document.getElementById('txtBranchName').focus();
		document.getElementById("Save").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(document.getElementById('cboBuyer').value=="" )
	{
		alert("Please select a Buyer.");
		document.getElementById('cboBuyer').focus();
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
function setData(branchId)
{
	var branchID = branchId;
	var url = 'buyerbranchnetworkdb.php?Request=GetData&branchID='+branchID;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLBranchName		= htmlobj.responseXML.getElementsByTagName("strBranchName");
	var XMLMotherCompany	= htmlobj.responseXML.getElementsByTagName("intMotherCompany");
	var XMLCountryId		= htmlobj.responseXML.getElementsByTagName("intCountryId");
	var XMLAddress1			= htmlobj.responseXML.getElementsByTagName("Address1");
	var XMLAddress2			= htmlobj.responseXML.getElementsByTagName("Address2");
	var XMLAddress3			= htmlobj.responseXML.getElementsByTagName("Address3");
	var XMLstrTel			= htmlobj.responseXML.getElementsByTagName("strTel");
	var XMLstrFax			= htmlobj.responseXML.getElementsByTagName("strFax");
	var XMLstrEmail			= htmlobj.responseXML.getElementsByTagName("strEmail");
	var XMLAgentName		= htmlobj.responseXML.getElementsByTagName("strAgentName");
	var XMLstrRemarks		= htmlobj.responseXML.getElementsByTagName("strRemarks");
	
	document.getElementById('txtBranchName').value 			= XMLBranchName[0].childNodes[0].nodeValue;
	document.getElementById('cboBuyer').value 				= XMLMotherCompany[0].childNodes[0].nodeValue;
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
	document.branchNetwork.reset();
}
function deleteData()
{
	document.getElementById("Delete").style.display="none";
	showPleaseWait();
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select a Branch.")
		document.getElementById("Delete").style.display="inline";
		document.getElementById('cboSearch').focus();
		hidePleaseWait();
		return;
	}
	var branchID = $('#cboSearch').val();
	var bname=	document.getElementById("cboSearch").options[document.getElementById("cboSearch").selectedIndex].text;
	var ans=confirm("Are you sure you want to  delete '" +bname+ "' ?");
	if (ans)
	{
		var url = 'buyerbranchnetworkdb.php?Request=deleteData&branchID='+branchID;
		xml_http_obj=$.ajax({url:url,async:false});
		if(xml_http_obj.responseText=="Deleted")
		{
			alert("Deleted successfully");
			document.getElementById("Delete").style.display="inline";
			window.location.href='buyerbranchnetwork.php';
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