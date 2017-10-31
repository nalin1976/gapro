//*********************************************java Script Document*********************************************************//
function qualityValidation()
{
	if(document.getElementById('txtQualityCd').value =="")
	{
		alert('Please enter "Quality Code".');
		document.getElementById("txtQualityCd").select();
		return false;
	}
	else if(document.getElementById('txtQuality').value=="")
	{
		alert('Please enter "Quality Name".');
		document.getElementById("txtQuality").select();
		return false;
	}
	else if(isNumeric(document.getElementById('txtQuality').value))
	{
		alert("Quality Name must be an \"Alphanumeric\" value.");
		document.getElementById("txtQuality").select();
		return false;
	}

	var cboQuality = document.getElementById("cboQuality").value;
	var txtName    = document.getElementById("txtQualityCd").value;

	var qualityfind = checkInField('quality','strQualityCode',txtName,'intQualityId',cboQuality);
	if(qualityfind)
	{
		alert('"'+txtName+ "\" is already exist.");	
		document.getElementById("txtQualityCd").select();
		return;
	}

	var cboQuality = document.getElementById("cboQuality").value;
	var txtName    = document.getElementById("txtQuality").value;
	
	var qualityfind = checkInField('quality','strQuality',txtName,'intQualityId',cboQuality);
	if(qualityfind)
	{
		alert('"'+txtName+ "\" is already exist.");	
		document.getElementById("txtQuality").select();
		return;
	}
	saveQualityDetails();
}
//********************************************************************************************************************
function saveQualityDetails()
{
	if(document.getElementById('cboQuality').value == "")
	{
	var qualitycd    = document.getElementById('txtQualityCd').value;
	var quality      = document.getElementById('txtQuality').value;
	var qualityRmrks = document.getElementById('txtRemarks').value;
	var qualityActve = document.getElementById('chkActive').checked;
	//alert (qualityActve);
	if(qualityActve ==true)
		var intStatus = 1
	else
		var intStatus = 0
	
var url = 'QualityButton.php?requestType=saveQualityDetails&qualitycd=' +qualitycd+ '&quality=' +quality+ '&qualityRmrks=' +qualityRmrks+ '&intStatus=' +intStatus;			
			 html =$.ajax({url:url,async:false});
			 
			 var intNo =html.responseText;
	
	if(intNo==1)
		{
				alert("Quality Details Successfully Saved.");	
		}
		else
			{
				alert("Quality Details Saving Error !")
			}
	ClearForm();
	document.getElementById('txtQualityCd').focus;
	}
	else
	{
	var cboQuality   = document.getElementById('cboQuality').value;
	var qualitycd    = document.getElementById('txtQualityCd').value;
	var quality      = document.getElementById('txtQuality').value;
	var qualityRmrks = document.getElementById('txtRemarks').value;
	var qualityActve = document.getElementById('chkActive').checked;
	//alert (qualityActve);
	if(qualityActve ==true)
		var intStatus = 1
	else
		var intStatus = 0
	
var url = 'QualityButton.php?requestType=updateQualityDetails&cboQuality=' +cboQuality+ '&qualitycd=' +qualitycd+ '&quality=' +quality+ '&qualityRmrks=' +qualityRmrks + '&intStatus=' +intStatus;			
			 html =$.ajax({url:url,async:false});
			 
			 var intNo =html.responseText;
	
	if(intNo==1)
		{
				alert("Quality Details Updated Successfully.");	
		}
		else
			{
				alert("Quality Details Saving Error !")
			}
	ClearForm();
	document.getElementById('txtQualityCd').focus;
	}
}
//**************************************************************************************************************************	
function ClearForm()
{
	window.location.reload();
}
//**************************************************************************************************************************
function ShowQualityDetails()
{
	var cboQuality   = document.getElementById('cboQuality').value;
	
	if(cboQuality=="")
	{
		ClearForm();	
	}
	else
	{
	var url         = 'Qualitymiddle.php?requestType=ShowQualityDetails&cboQuality=' +cboQuality;
	var html     	=$.ajax({url:url,async:false});
	
		var XMLQualityCode       = html.responseXML.getElementsByTagName("QualityCode")[0].childNodes[0].nodeValue;
		var XMLQuality           = html.responseXML.getElementsByTagName("Quality")[0].childNodes[0].nodeValue;
		var XMLQualityRemarks    = html.responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
		var XMLQualityActve      = html.responseXML.getElementsByTagName("Status")[0].childNodes[0].nodeValue;
		
		document.getElementById('txtQualityCd').value= XMLQualityCode; 
		document.getElementById('txtQuality').value  = XMLQuality;
		document.getElementById('txtRemarks').value  = XMLQualityRemarks;
		if(XMLQualityActve==1)
				document.getElementById("chkActive").checked=true;	
			else
				document.getElementById("chkActive").checked=false;		
	}
}
//***************************************************************************************************************************	
function ConfirmDelete()
{
	if(document.getElementById('cboQuality').value=="")
	{
		alert("Please select Quality");
	}
	else
	{
		var quality = document.getElementById("cboQuality").options[document.getElementById('cboQuality').selectedIndex].text;
		var r=confirm('Are you sure you want to delete \n "' + quality +'" ?');
		if (r==true)		
			DeleteData();
	}		
}
//***************************************************************************************************************************

function DeleteData()
{
	var cboQuality   = document.getElementById('cboQuality').value;
	{
		if(cboQuality != "")
		{
			var url         = 'QualityButton.php?requestType=DeleteData&cboQuality=' +cboQuality;
			 html =$.ajax({url:url,async:false});
			 
			 var intNo =html.responseText;
	if(intNo==1)
		{
				alert("Quality Details Deleted Successfully.");	
		}
		else
			{
				alert("Quality Details Deleting Error !")
			}
	ClearForm();
	document.getElementById('txtQualityCd').focus;	
		}
	}
}

//***************************************************************************************************************************
function loadReport()
{ 
	var cboQuality   = document.getElementById('cboQuality').value;
	window.open("QualityReport.php?cboQuality=" + cboQuality); 
}