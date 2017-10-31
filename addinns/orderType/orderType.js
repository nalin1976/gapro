function GetOrderType(obj)
{
	if(obj.value=="")
	{
		ClearForm();
		return;
	}
	var url  = 'orderTypexml.php?RequestType=URLGetOrderType';
		url += '&OrderTypeId='+obj.value;
	var htmlobj=$.ajax({url:url,async:false});
	var XMLDescription = htmlobj.responseXML.getElementsByTagName("Description");
	document.getElementById('orderType_description').value = XMLDescription[0].childNodes[0].nodeValue;
	var XMLStatus = htmlobj.responseXML.getElementsByTagName("Status");
	document.getElementById('orderType_chkActive').value = (XMLStatus[0].childNodes[0].nodeValue=='1' ? true:false);
}

function SaveOrderType()
{
	if(!Validte_Interface())
		return;
	var url  = 'orderTypexml.php?RequestType=URLSaveOrderType';
		url += '&OrderTypeId='+URLEncode(document.getElementById('orderType_orderId').value.trim());
		url += '&Description='+URLEncode(document.getElementById('orderType_description').value.trim());
		url += '&Status='+(document.getElementById('orderType_chkActive').checked ? 1:0);
	var htmlobj=$.ajax({url:url,async:false});
	alert(htmlobj.responseText);
	ClearForm();
}

function Validte_Interface()
{
	if(document.getElementById('orderType_description').value.trim()=="")
	{
		alert("Please enter 'Description'.");
		document.getElementById('orderType_description').focus();
		return false;
	}
return true;
}

function ClearForm()
{
	document.frmOrderType.reset();
}