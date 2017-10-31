// JavaScript Document

function ReloadPage()
{
	document.forms["frmNGList"].submit();
}

function checkOK()
{
	if(document.getElementById('chkdate').checked)
	{
		document.getElementById('txtDatefrom').disabled = false;
		document.getElementById('txtDateTo').disabled   = false;
		document.getElementById('txtCheck').value       = "checked";
	}
	else
	{
		document.getElementById('txtDatefrom').disabled = true;
		document.getElementById('txtDateTo').disabled   = true;
		document.getElementById('txtCheck').value       = "";
		
	}
}

function submitForm()
{
	document.forms["frmNGList"].submit();
}

function saveFabricDue()
{
	var tblmain = document.getElementById('tblIssueDetails');
	
	for(x=1;x<tblmain.rows.length;x++)
	{
		var fab     = tblmain.rows[x].cells[7].childNodes[0].value;
		var styleid = tblmain.rows[x].cells[7].childNodes[0].id;
		var duedate = tblmain.rows[x].cells[9].childNodes[0].value;
		
		var url = "sampleScheduleXML.php?RequestType=save&fab="+fab+"&styleid="+styleid+"&duedate="+duedate;
		$.ajax({url:url,async:false});
	}
	
	alert("Data Saved Successfully !");
	window.location.reload();
}