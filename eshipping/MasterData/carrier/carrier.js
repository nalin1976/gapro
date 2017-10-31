// JavaScript Document


function validateData()
{
	if(document.getElementById('txtCarrier').value=='')
		alert("Please Enter Carrier Name");
	else if(document.getElementById('txtDescription').value=='')
		alert("Please Enter Description");
	else
		saveData();
}

function saveData()
{
	var carrierId		=	document.getElementById('cboCarrier').value;
	var carrierName	=	document.getElementById('txtCarrier').value;
	var description		=	document.getElementById('txtDescription').value;
	
	var exist=0;
	
	if(carrierId==0)
	{
		var url1 ="carrier-db.php?id=checkCarrierName";
			url1+="&carrierName="+carrierName;
		var html_obj1	  = $.ajax({url:url1,async:false});
		exist=html_obj1.responseText;
	}
	
	if(exist==0)
	{
	var url ="carrier-db.php?id=saveData";
		url+="&carrierId="+carrierId;
		url+="&carrierName="+carrierName;
		url+="&description="+description;
		
	var html_obj	  = $.ajax({url:url,async:false});
	
	alert(html_obj.responseText);
	clearForm();
	}
	else
		alert("Carrier Exists.Please Specify a different name");
}

function loadCarrierData(carrierId)
{
	if(carrierId!=0)
	{
		var url ="carrier-db.php?id=loadData";
		url+="&carrierId="+carrierId;
		
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		
		var XMLCarrierName  	  = xmlhttp_obj.responseXML.getElementsByTagName("CarrierName");
		var XMLDescription  	  = xmlhttp_obj.responseXML.getElementsByTagName("Description");
		
		//alert(xmlhttp_obj.responseText);
		
		document.getElementById('txtCarrier').value=XMLCarrierName[0].childNodes[0].nodeValue;
		document.getElementById('txtDescription').value=XMLDescription[0].childNodes[0].nodeValue;
	}
	else
	{
		document.getElementById('txtCarrier').value='';
		document.getElementById('txtDescription').value='';

	}
}

function clearForm()
{
	window.location.reload();
}

function deleteData()
{
	var carrierId		=	document.getElementById('cboCarrier').value;
	if(carrierId>0)
	{
		var url ="carrier-db.php?id=deleteData";
		    url+="&carrierId="+carrierId;
		
		var html_obj	  = $.ajax({url:url,async:false});
		
		alert(html_obj.responseText);
		clearForm();
	}
	else
		alert("Please select a carrier to delete");
}

