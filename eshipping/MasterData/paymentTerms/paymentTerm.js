// JavaScript Document

var gbl_id=0;
function deleteRow(obj)
{
	var tbl_paymentTerm=document.getElementById('tbl_paymentTerm');
	var rowIndex=obj.id;
	
	var paymentId=tbl_paymentTerm.rows[rowIndex].cells[2].childNodes[0].nodeValue;
	
	var answer = confirm("Do you want to delete?")
	if (answer)
	{
		var url="paymentTerm-db.php?id=deleteRowData";
			url+="&paymentId="+URLEncode(paymentId);
			
		var html_obj	  = $.ajax({url:url,async:false});
		
		if(html_obj.responseText==1)
		{
			alert("Deleted Successfully");
			clearForm();
		}
		else
			alert("Delete Failed");
	}
}


function clearForm()
{
	window.location.reload();
}

function editRow(obj)
{
	var tbl_paymentTerm=document.getElementById('tbl_paymentTerm');
	var rowIndex=obj.id;
	
	gbl_id=tbl_paymentTerm.rows[rowIndex].cells[2].childNodes[0].nodeValue;
	document.getElementById('txtTerms').value=tbl_paymentTerm.rows[rowIndex].cells[3].childNodes[0].nodeValue.trim();
	document.getElementById('txtDescription').value=tbl_paymentTerm.rows[rowIndex].cells[4].childNodes[0].nodeValue.trim();
		
}

function validateData()
{
	if(document.getElementById('txtTerms').value=='')
	{
		alert("Please Enter Term Name");
		document.getElementById('txtTerms').focus();
	}
	else
	{
		var termName=document.getElementById('txtTerms').value;
		var url="paymentTerm-db.php?id=checkAvailbility";
		url+="&termId="+URLEncode(gbl_id);
		url+="&termName="+URLEncode(termName);
		
		var html_obj	  = $.ajax({url:url,async:false});
		//alert(html_obj.responseText);
		if(html_obj.responseText==1)
		{
			alert("Term Exists. Please Enter a different Term");
			document.getElementById('txtTerms').value='';
			document.getElementById('txtTerms').focus();
			
		}
		else
			saveData();
	}
}

function saveData()
{
	var termName=document.getElementById('txtTerms').value;
	var termDesc=document.getElementById('txtDescription').value;
	
	var url="paymentTerm-db.php?id=saveData";
		url+="&termId="+URLEncode(gbl_id);
		url+="&termName="+URLEncode(termName);
		url+="&termDesc="+URLEncode(termDesc);
		
	var html_obj	  = $.ajax({url:url,async:false});
	
	alert(html_obj.responseText);
	clearForm();
}


function focusTextBox()
{
	document.getElementById('txtTerms').focus();
}