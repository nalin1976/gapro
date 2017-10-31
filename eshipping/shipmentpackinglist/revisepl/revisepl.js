// JavaScript Document
function ClearForm()
{
	document.frmRevisePL.reset();
}
function saveRevise()
{
	if(document.getElementById("cboPLNo").value=="")
	{
		alert("Please select a PL No.");
		document.getElementById("cboPLNo").focus();
		return;
	}
	if(document.getElementById("txtareaReason").value=="")
	{
		alert("Please enter a reason.");
		document.getElementById("txtareaReason").focus();
		return;
	}
	var PLNo   = $('#cboPLNo').val();
	var reason = $('#txtareaReason').val();
	var date   = $('#txtDate').val();
	
	var url 	='revisepldb.php?request=saveRevise&PLNo='+PLNo+'&reason='+URLEncode(reason)+'&date='+date;
	var htmlobj = $.ajax({url:url,async:false});
	if(htmlobj.responseText=="revised")
	{
		alert("Revise successfully.");
		loadCombo('select strPLNo,strPLNo from shipmentplheader where intConfirmaed=1 order by strPLNo;','cboPLNo');
		ClearForm();
	}
	else
	{
		alert("Error in revising.");
		return;
	}
}