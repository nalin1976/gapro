// JavaScript Document

function validateData()
{
	if(document.getElementById('chkCDN').checked==false && document.getElementById('chkPre').checked==false)
		alert("Please Select a Invoice Type");
	else if(document.getElementById('chkCDN').checked==true && document.getElementById('txtCdnInvNo').value=='')
		alert("Please Enter CDN Invoice No");
	else if(document.getElementById('chkPre').checked==true && document.getElementById('txtPreInvNo').value=='')
		alert("Please Enter Pre Invoice No");
	else
		loadData();
		
}

function loadData()
{
	if(document.getElementById('chkCDN').checked==true)
	{
		var url					='searchCDNDB.php?request=loadCDN&invoiceNo='+document.getElementById('txtCdnInvNo').value;
		var xml_http_obj	=$.ajax({url:url,async:false});
		window.open("../cdn.php?invoiceNo="+xml_http_obj.responseText+"&type=cdn","cdn");
	}
	else
	window.open("../cdn.php?invoiceNo="+document.getElementById('txtPreInvNo').value+"&type=pre","cdn");
}