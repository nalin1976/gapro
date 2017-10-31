// JavaScript Document
function SaveCuttingValue()
{
	document.getElementById("butSave").style.display="none";
	showPleaseWait();
	var factoryId 	= $('#cboFactory').val();
	var cutting 	= parseFloat($('#txtCutting').val());
	var sewing 		= parseFloat($('#txtSewing').val());
	var finishing 	= parseFloat($('#txtFinishing').val());
	var packing	 	= parseFloat($('#txtPacking').val());
	
	if(!validateSave(factoryId,cutting,sewing,finishing,packing))
		return;
		
	var url = 'cuttingvalueXML.php?Request=SaveCuttingValue&factoryId='+factoryId+'&cutting='+cutting+'&sewing='+sewing+'&finishing='+finishing+'&packing='+packing;
	htmlobj = $.ajax({url:url,async:false});
	
	if(htmlobj.responseText=="Saved")
	{
		
		alert("Saved successfully.");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();

	}
	else if(htmlobj.responseText=="Updated")
	{
		alert("Updated successfully.");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
	}
	else if(htmlobj.responseText=="Error")
	{
		alert("Error in saving");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
	}
}
function validateSave(factoryId,cutting,sewing,finishing,packing)
{
	
	if(factoryId=="")
	{
		alert("Please select a factory.");
		document.getElementById('cboFactory').focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(cutting=="")
	{
		alert("Please enter cutting percentage.");
		document.getElementById('txtCutting').focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(sewing=="")
	{
		alert("Please enter sewing percentage.");
		document.getElementById('txtSewing').focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(finishing=="")
	{
		alert("Please enter finishing percentage.");
		document.getElementById('txtFinishing').focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	if(packing=="")
	{
		alert("Please enter packing percentage.");
		document.getElementById('txtPacking').focus();
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	var totPercentage = (cutting+sewing+finishing+packing);
	
	if(totPercentage!=100)
	{	
		alert("Total percentage must be equal to 100%.");
		document.getElementById("butSave").style.display="inline";
		hidePleaseWait();
		return false;
	}
	return true;
}
function getDetails(factoryId)
{
	
	var url = 'cuttingvalueXML.php?Request=getDetails&factoryId='+factoryId;
	htmlobj = $.ajax({url:url,async:false});
	clearAllData();
	var XMLCutting			= htmlobj.responseXML.getElementsByTagName("Cutting");
	var XMLSewing			= htmlobj.responseXML.getElementsByTagName("Sewing");
	var XMLFinishing		= htmlobj.responseXML.getElementsByTagName("Finishing");
	var XMLPacking			= htmlobj.responseXML.getElementsByTagName("Packing");
	var XMLstatus			= htmlobj.responseXML.getElementsByTagName("status");

	if(XMLstatus[0].childNodes[0].nodeValue =="False")
	{
		return;
	}
	document.getElementById('txtCutting').value 		= XMLCutting[0].childNodes[0].nodeValue;
	document.getElementById('txtSewing').value 			= XMLSewing[0].childNodes[0].nodeValue;
	document.getElementById('txtFinishing').value 		= XMLFinishing[0].childNodes[0].nodeValue;
	document.getElementById('txtPacking').value 		= XMLPacking[0].childNodes[0].nodeValue;
}
function deleteData()
{
	document.getElementById("butDelete").style.display="none";
	showPleaseWait();
	if(document.getElementById("cboFactory").value=="")
	{
		alert("Please select a factory.");
		document.getElementById("cboFactory").focus();
		document.getElementById("butDelete").style.display="inline";
		hidePleaseWait();
		return;
	}
	
	var ans=confirm("Are you sure you want to  delete ?");
	if (ans)
	{
		var facId = $('#cboFactory').val();
		var url   = 'cuttingvalueXML.php?Request=deleteData&facId='+facId;
		htmlobj   = $.ajax({url:url,async:false});
		
		if(htmlobj.responseText=="Deleted")
		{
			alert("Delete successfully.");
			document.getElementById("butDelete").style.display="inline";
			ClearForm();
			hidePleaseWait();
		}
		else
		{
			alert("Error in deleting.");
			document.getElementById("butDelete").style.display="inline";
			hidePleaseWait();
		}
	}
	else
	{
		document.getElementById("butDelete").style.display="inline";
		hidePleaseWait();
		return;
	}
}
function clearAllData()
{
	document.getElementById("txtCutting").value="";
	document.getElementById("txtSewing").value="";
	document.getElementById("txtFinishing").value="";
	document.getElementById("txtPacking").value="";
}
function ClearForm()
{
	document.cuttingValueForm.reset();
}