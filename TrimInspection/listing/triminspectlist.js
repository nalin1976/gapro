function SubmitForm() 
{
	document.frmTrimInspectList.submit();
}

function ViewReport()
{
	var notInspect 	= document.getElementById('chkNotInspect').checked;
	var orderNo 	= document.getElementById('cboOrderNo').value;
	var grnNo 		= document.getElementById('cboGrnNo').value;
	window.open("rpttriminspectlist.php?NotInspect="+notInspect+ '&OrderNo='+orderNo+ '&GrnNo='+grnNo,'rpttriminspectlist.php');
}

function LoadGrnNo()
{
	var StyleId = document.getElementById('cboOrderNo').value;
	
	var url  = "../TrimInspactionGrnWiseXml.php?RequestType=URLLoadGRNNo";
 		url += "&StyleId="+StyleId;
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById('cboGrnNo').innerHTML = htmlobj.responseText;
	
}