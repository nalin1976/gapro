// Java Document

function validateData()
{
	if(document.getElementById('txtMainBuyerCode').value.trim()=='')
		alert("Please Enter Main Buyer Code");
	else if(document.getElementById('txtMainBuyerName').value.trim()=='')
		alert("Please Enter Main Buyer Name");
	else if(document.getElementById('txtCreditPeriod').value.trim()=='')
		alert("Please Enter Credit Period");
	else
		saveMainBuyer();
}
function saveMainBuyer()
{
	var mainBuyerId = document.getElementById('cboMainBuyer').value;
	var mainBuyerCode = document.getElementById('txtMainBuyerCode').value;
	var mainBuyerName = document.getElementById('txtMainBuyerName').value;
	
	var mainBuyerAddress1 = document.getElementById('txtMainBuyerAddress1').value;
	//alert(mainBuyerAddress1);
	var mainBuyerAddress2 = document.getElementById('txtMainBuyerAddress2').value;
	var mainBuyerAddress3 = document.getElementById('txtMainBuyerAddress3').value;
	var mainBuyerCountry = document.getElementById('txtMainBuyerCountry').value;
	var mainBuyerCreditPeriod = document.getElementById('txtCreditPeriod').value;
	
	var url  = "mainBuyerDB.php?request=saveData";
		url += "&mainBuyerId="+mainBuyerId;
		url += "&mainBuyerCode="+mainBuyerCode;
		url += "&mainBuyerName="+mainBuyerName;
		url += "&mainBuyerAddress1="+mainBuyerAddress1;
		url += "&mainBuyerAddress2="+mainBuyerAddress2;
		url += "&mainBuyerAddress3="+mainBuyerAddress3;
		url += "&mainBuyerCountry="+mainBuyerCountry;
		url += "&mainBuyerCreditPeriod="+mainBuyerCreditPeriod;
	var http_obj	=$.ajax({url:url,async:false});	
	alert(http_obj.responseText);
}

function getMainBuyer(obj)
{
	if(obj.value!=0)
	{
		var mainBuyerId = document.getElementById('cboMainBuyer').value;
		var url  = "mainBuyerDB.php?request=getData";
			url += "&mainBuyerId="+mainBuyerId;
		var xmlhttp_obj	=$.ajax({url:url,async:false});	
		
		var XMLMainBuyerCode 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerCode");
		var XMLMainBuyerName 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerName");
		
		var XMLMainBuyerAddress1 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerAddress1");
		var XMLMainBuyerAddress2 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerAddress2");
		var XMLMainBuyerAddress3 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerAddress3");
		
		var XMLMainBuyerCountry 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerCountry");
		var XMLMainBuyerCreditPeriod 	  = xmlhttp_obj.responseXML.getElementsByTagName("MainBuyerCreditPeriod");
		
		document.getElementById('txtMainBuyerCode').value = XMLMainBuyerCode[0].childNodes[0].nodeValue;
		document.getElementById('txtMainBuyerName').value = XMLMainBuyerName[0].childNodes[0].nodeValue;
		document.getElementById('txtMainBuyerAddress1').value = XMLMainBuyerAddress1[0].childNodes[0].nodeValue;
		document.getElementById('txtMainBuyerAddress2').value = XMLMainBuyerAddress2[0].childNodes[0].nodeValue;
		document.getElementById('txtMainBuyerAddress3').value = XMLMainBuyerAddress3[0].childNodes[0].nodeValue;
		document.getElementById('txtMainBuyerCountry').value = XMLMainBuyerCountry[0].childNodes[0].nodeValue;
		document.getElementById('txtCreditPeriod').value = XMLMainBuyerCreditPeriod[0].childNodes[0].nodeValue;
		
	}
	else
	{
		ClearForm();
	}
}
function ClearForm()
{
	window.location.reload();
}