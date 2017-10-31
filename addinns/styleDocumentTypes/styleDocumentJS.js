
function RemoveRow(rowIndex)
{
	var tbl = document.getElementById('tblCreditPeriod');
    tbl.deleteRow(rowIndex);
}



function NewCreditPeriod()
{
	var styleId          = document.getElementById("txtstyleid").value;
	var styledescription = document.getElementById('txtstyledescription').value;
	var status = 1;
	if(!document.getElementById('chkStatus').checked)
		status = 0;
	
	if(styledescription=="")
		alert("Enter Description !");
	else
	{
	
		var url = "styleDocumentMiddle.php?RequestType=save"+"&styleId="+styleId+"&styledescription="+styledescription+"&status="+status;
		var res = $.ajax({url:url,async:false});
	
		if(res.responseText=="1")
			alert("Data Saved Successfully !");
		else
			alert("Data Can not Save !");
			
		javascript:location.reload(true);
	}
	
}

function ClearCPForm()
{
	document.frmCreditPeriod.reset();
	//document.getElementById("title_Description").title = "";
	document.getElementById('txtstyledescription').focus();
}

function DeleteStyle(obj)
{
	var styleId = obj.id;
	var url     = "styleDocumentMiddle.php?RequestType=delete"+"&styleId="+styleId;
	var res = $.ajax({url:url,async:false});
	
	if(res.responseText=="1")
			alert("Data Deleted Successfully !");
	else
			alert("Data Can not Delete !");
			
	javascript:location.reload(true);
}

function loadData(obj)
{
	document.getElementById('txtstyleid').value          = obj.id;
	
	var rowInd = obj.parentNode.parentNode.parentNode.rowIndex;
	var desc   = document.getElementById('tblCreditPeriod').rows[rowInd].cells[2].innerHTML;
	document.getElementById('txtstyledescription').value = desc;
	
	var checkCHECKED = document.getElementById('tblCreditPeriod').rows[rowInd].cells[3].childNodes[0].checked;
	if(checkCHECKED)
	{
		document.getElementById('chkStatus').checked=true;
	}
	else
	{
		document.getElementById('chkStatus').checked=false;
	}
}