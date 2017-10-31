// JavaScript Document
function SaveCostCenterData()
{
	document.getElementById("butSave").style.display="none";
	showPleaseWait();
	if(!validateInterface())
		return;
		
	if(!validateSave())	
		return;
	
	var searchId = $('#cboSearch').val();
	var code  	 = $('#txtCode').val();
	var des	  	 = $('#txtDescription').val();
	var plantId  = $('#cboPlant').val();
	var FacId	 = $('#cboFactory').val();
	
	var url = 'costcenterdb.php?Request=SaveCostCenterData&code='+URLEncode(code)+ '&des=' +URLEncode(des)+ '&plantId=' +plantId+'&FacId='+FacId+ '&searchId=' +searchId;
	xml_http_obj=$.ajax({url:url,async:false});
	
	if(xml_http_obj.responseText=="Saved")
	{
		
		alert("Saved successfully.")
		document.getElementById("butSave").style.display="inline";
		setsaveData();
		ClearForm();
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="Updated")
	{
		alert("Updated successfully.");
		document.getElementById("butSave").style.display="inline";
		setsaveData();
		ClearForm();
		hidePleaseWait();
	}
	else if(xml_http_obj.responseText=="Error")
	{
		alert("Error");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
	}
}
function validateInterface()
{
	if(document.getElementById("txtCode").value=="")
	{
		alert("Please enter \"Account Code\".")
		document.getElementById("txtCode").focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(document.getElementById("txtDescription").value=="")
	{
		alert("Please enter \"Description\".")
		document.getElementById("txtDescription").focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(document.getElementById("cboPlant").value=="")
	{
		alert("Please select \"Plant\".")
		document.getElementById("cboPlant").focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(document.getElementById("cboFactory").value=="")
	{
		alert("Please select \"Factory\".")
		document.getElementById("cboFactory").focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	return true;
}
function validateSave()
{
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("txtCode").value;
	
	var x_find = checkInField('costcenters','strCode',x_name,'intCostCenterId',x_id);
	if(x_find)
	{
		alert("Account Code "+"\""+x_name+"\" is already exist.");	
		document.getElementById("txtCode").focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("txtDescription").value;
	
	var x_find = checkInField('costcenters','strDescription',x_name,'intCostCenterId',x_id);
	if(x_find)
	{
		alert("Description "+"\""+x_name+"\" is already exist.");	
		document.getElementById("txtDescription").focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	return true;
}
function setCostData(searchID)
{
	
	var searchId = searchID;
	if(searchId=="")
	{
		ClearForm();
		return;
	}
	var url = 'costcenterdb.php?Request=setCostData&searchId='+searchId;
	htmlobj=$.ajax({url:url,async:false});
	
	var XMLstrCode			= htmlobj.responseXML.getElementsByTagName("strCode");
	var XMLstrDescription	= htmlobj.responseXML.getElementsByTagName("strDescription");
	var XMLintPlantId		= htmlobj.responseXML.getElementsByTagName("intPlantId");
	var XMLintFactoryId		= htmlobj.responseXML.getElementsByTagName("intFactoryId");
	
	document.getElementById('txtCode').value 			= XMLstrCode[0].childNodes[0].nodeValue;
	document.getElementById('txtDescription').value 	= XMLstrDescription[0].childNodes[0].nodeValue;
	document.getElementById('cboPlant').value 			= XMLintPlantId[0].childNodes[0].nodeValue;
	document.getElementById('cboFactory').value 		= XMLintFactoryId[0].childNodes[0].nodeValue;
	
}
function ClearForm()
{
	document.costCenterForm.reset();
	document.getElementById('txtCode').focus();
}
function deleteData()
{
	document.getElementById("butDelete").style.display="none";
	showPleaseWait();
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select \"Description\".")
		document.getElementById("butDelete").style.display="inline";
		document.getElementById('cboSearch').focus();
		hidePleaseWait();
		return;
	}
	var searchId = $('#cboSearch').val();
	var Sname=	document.getElementById("cboSearch").options[document.getElementById("cboSearch").selectedIndex].text;
	var ans=confirm("Are you sure you want to  delete '" +Sname+ "' ?");
		if (ans)
		{
			var url = 'costcenterdb.php?Request=deleteCostData&searchId='+searchId;
			xml_http_obj=$.ajax({url:url,async:false});
			if(xml_http_obj.responseText=="Deleted")
			{
				alert("Deleted successfully");
				document.getElementById("butDelete").style.display="inline";
				setsaveData();
				ClearForm();
				hidePleaseWait();
			}
			if(xml_http_obj.responseText=="Error")
			{
				alert("Error");
				document.getElementById("butDelete").style.display="inline";
				hidePleaseWait();
			}
		}
		else
		{
			document.getElementById("butDelete").style.display="inline";
			hidePleaseWait();
		}

}
function setsaveData()
{
	var url = 'costcenterdb.php?Request=setsaveData';
	htmlobj=$.ajax({url:url,async:false});
	var XMLItem = htmlobj.responseText;
	document.getElementById('cboSearch').innerHTML = XMLItem;
}