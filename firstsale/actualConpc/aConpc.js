function loadStylewiseOrderNo()
{
	var styleNo = $("#cboStyleNo option:selected").text();
	var url  = "aConpcdb.php?RequestType=LoadOrderAndScNo";
		url += "&StyleNo="+URLEncode(styleNo);
		url += "&Status="+11;
		
	htmlobj=$.ajax({url:url,async:false});	
	document.getElementById('cboOrderNo').innerHTML = htmlobj.responseXML.getElementsByTagName("OrderNo")[0].childNodes[0].nodeValue;
	document.getElementById('cboScNo').innerHTML = htmlobj.responseXML.getElementsByTagName("ScNo")[0].childNodes[0].nodeValue;
}

function setSCNo()
{
	document.getElementById('cboScNo').value = document.getElementById('cboOrderNo').value	
}

function setOrderNo()
{
	document.getElementById('cboOrderNo').value = document.getElementById('cboScNo').value		
}

function loadOrderDetails()
{
	var styleId = document.getElementById('cboOrderNo').value;
	var url = "aConpcdb.php?RequestType=loadOrderDetails";
	url += "&orderNo="+styleId;
	htmlobj=$.ajax({url:url,async:false});	
	
	document.getElementById('txtMainFabric').value = htmlobj.responseXML.getElementsByTagName("fabric")[0].childNodes[0].nodeValue;
	document.getElementById('txtpocket').value = htmlobj.responseXML.getElementsByTagName("pocketing")[0].childNodes[0].nodeValue;
	document.getElementById('cboStyleNo').value = htmlobj.responseXML.getElementsByTagName("styleName")[0].childNodes[0].nodeValue;
	var styleName = htmlobj.responseXML.getElementsByTagName("styleName")[0].childNodes[0].nodeValue;
	loadPendingData(styleId);
	loadPreviousStyleData(styleName,styleId);
}

function clearForm()
{
	//$("#frmAcualConpc")[0].reset();
	location = "aConpc.php?";
}

function saveDetails()
{
	if(document.getElementById('cboOrderNo').value == '')
	{
		alert("Please select 'Order No'");
		document.getElementById('cboOrderNo').focus();
		return;
	}
	var url = "aConpcdb.php?RequestType=saveOrderDetails";
	url += "&orderNo="+document.getElementById('cboOrderNo').value;
	url += "&fabConpc="+document.getElementById('txtfabricConpc').value;
	url += "&pocketConpc="+document.getElementById('txtPocketConpc').value;
	url += "&threadConpc="+document.getElementById('txtThreadConpc').value;
	url += "&smv="+document.getElementById('txtSMVrate').value;
	url += "&dryWashPrice="+document.getElementById('txtDryWashPrice').value;
	url += "&wetWashPrice="+document.getElementById('txtWetWashPrice').value;
	
	htmlobj=$.ajax({url:url,async:false});	
	
	if(htmlobj.responseText == 'saved')
	{
		alert('Saved successfully');
		clearForm()	
	}	
	else
		alert('Saved failed');
}

function loadPendingData(styleId)
{
	if(styleId !=0)
	{
		var url = "aConpcdb.php?RequestType=getPendingDetails";
			url += "&styleId="+styleId;
		htmlobj=$.ajax({url:url,async:false});	
		
	document.getElementById('txtMainFabric').value = htmlobj.responseXML.getElementsByTagName("fabric")[0].childNodes[0].nodeValue;
	document.getElementById('txtpocket').value = htmlobj.responseXML.getElementsByTagName("pocketing")[0].childNodes[0].nodeValue;
	document.getElementById('txtfabricConpc').value = htmlobj.responseXML.getElementsByTagName("fabConpc")[0].childNodes[0].nodeValue;
	document.getElementById('txtPocketConpc').value = htmlobj.responseXML.getElementsByTagName("poConpc")[0].childNodes[0].nodeValue;
	document.getElementById('txtThreadConpc').value = htmlobj.responseXML.getElementsByTagName("threadConpc")[0].childNodes[0].nodeValue;
	document.getElementById('txtSMVrate').value = htmlobj.responseXML.getElementsByTagName("smv")[0].childNodes[0].nodeValue;
	document.getElementById('cboOrderNo').value = styleId;
	document.getElementById('txtDryWashPrice').value = htmlobj.responseXML.getElementsByTagName("dryWash")[0].childNodes[0].nodeValue;
	document.getElementById('txtWetWashPrice').value = htmlobj.responseXML.getElementsByTagName("wetWash")[0].childNodes[0].nodeValue;
	document.getElementById('cboStyleNo').value = htmlobj.responseXML.getElementsByTagName("styleNo")[0].childNodes[0].nodeValue;
	document.getElementById('styleDesc').innerHTML = htmlobj.responseXML.getElementsByTagName("styleDescription")[0].childNodes[0].nodeValue;
	}
}

function loadPreviousStyleData(styleName,styleId)
{
	var url = "aConpcdb.php?RequestType=getPrevStyleDetails";
		url += "&styleName="+URLEncode(styleName);
		url += "&styleId="+styleId;
		
		htmlobj=$.ajax({url:url,async:false});
	if(document.getElementById('txtDryWashPrice').value=="")
		document.getElementById('txtDryWashPrice').value = htmlobj.responseXML.getElementsByTagName("dryWash")[0].childNodes[0].nodeValue;
	if(document.getElementById('txtWetWashPrice').value=="")
		document.getElementById('txtWetWashPrice').value = htmlobj.responseXML.getElementsByTagName("wetWash")[0].childNodes[0].nodeValue;
	if(document.getElementById('txtSMVrate').value=="")
		document.getElementById('txtSMVrate').value = htmlobj.responseXML.getElementsByTagName("smv")[0].childNodes[0].nodeValue;
	document.getElementById('cboStyleNo').value = htmlobj.responseXML.getElementsByTagName("styleNo")[0].childNodes[0].nodeValue;
	document.getElementById('styleDesc').innerHTML = htmlobj.responseXML.getElementsByTagName("styleDescription")[0].childNodes[0].nodeValue;
}