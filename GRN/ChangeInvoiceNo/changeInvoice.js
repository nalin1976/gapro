// JavaScript Document
function loadGRNno()
{
	var grnYear = $("#cboGRNyear").val();
	var url = 'changeInvdb.php?RequestType=loadGRN';	
		url += '&grnYear='+grnYear;
		
		htmlobj=$.ajax({url:url,async:false});
				 
		 $("#cboGRNno").html(htmlobj.responseXML.getElementsByTagName("GRNno")[0].childNodes[0].nodeValue);
}

function loadInvoceNo()
{
	var grnYear = $("#cboGRNyear").val();
	var grnNo = $("#cboGRNno").val();
	 $("#txtNewInvNo").val('');
	if(grnNo == '' || grnNo == null)
	{
		 $("#txtoldInvNo").val('');
		
		 return ;
	}
	var url = 'changeInvdb.php?RequestType=getInvNo';	
		url += '&grnYear='+grnYear;
		url += '&grnNo='+grnNo;
		
		htmlobj=$.ajax({url:url,async:false});	
		
		$("#txtoldInvNo").val(htmlobj.responseXML.getElementsByTagName("InvNo")[0].childNodes[0].nodeValue);
}

function updateInvNo()
{
	var grnYear = $("#cboGRNyear").val();
	var grnNo = $("#cboGRNno").val();
	var invNo = $("#txtNewInvNo").val().toUpperCase();
	
	if(grnNo == '' || grnNo == null)
	{
		alert("Please select \"GRN No\"");
		 $("#cboGRNno").focus();
		 return ;
	}
	if(invNo == '')
	{
		alert("Please enter \" New Invoice Number\"");
		 $("#txtNewInvNo").focus();
		 return ;
	}
	var url = 'changeInvdb.php?RequestType=updateInvDetails';	
		url += '&grnYear='+grnYear;
		url += '&grnNo='+grnNo;
		url += '&invNo='+URLEncode(invNo);
		
		htmlobj=$.ajax({url:url,async:false});
		alert(htmlobj.responseXML.getElementsByTagName("InvNoRes")[0].childNodes[0].nodeValue)
}

function clearPage()
{
	document.frmInvNo.reset();	
}