// JavaScript Document

function validateData()
{
	if(document.getElementById('txtContainer').value=='')
		alert("Please Enter Container Name");
	else if(document.getElementById('txtDescription').value=='')
		alert("please Enter Description");
	else if(document.getElementById('txtMeasurement').value=='')
		alert("Please Enter Measurement");
	else
		saveData();
}

function saveData()
{
	var containerId		=	document.getElementById('cboContainer').value;
	var containerName	=	document.getElementById('txtContainer').value;
	var description		=	document.getElementById('txtDescription').value;
	var measurement		=	document.getElementById('txtMeasurement').value;
	var exist=0;
	
	if(containerId==0)
	{
		var url1 ="container-db.php?id=checkContainerName";
			url1+="&containerName="+containerName;
		var html_obj1	  = $.ajax({url:url1,async:false});
		exist=html_obj1.responseText;
	}
	
	if(exist==0)
	{
	var url ="container-db.php?id=saveData";
		url+="&containerId="+containerId;
		url+="&containerName="+URLEncode(containerName);
		url+="&description="+URLEncode(description);
		url+="&measurement="+URLEncode(measurement);
		
	var html_obj	  = $.ajax({url:url,async:false});
	
	alert(html_obj.responseText);
	clearForm();
	}
	else
		alert("Container Exists.Please Specify a different name");
}

function loadContainerData(containerId)
{
	if(containerId!=0)
	{
		var url ="container-db.php?id=loadData";
		url+="&containerId="+containerId;
		
		var xmlhttp_obj	  = $.ajax({url:url,async:false});
		
		var XMLContainerName  	  = xmlhttp_obj.responseXML.getElementsByTagName("ContainerName");
		var XMLDescription  	  = xmlhttp_obj.responseXML.getElementsByTagName("Description");
		var XMLMeasurement 	      = xmlhttp_obj.responseXML.getElementsByTagName("Measurement");
		
		//alert(xmlhttp_obj.responseText);
		
		document.getElementById('txtContainer').value=XMLContainerName[0].childNodes[0].nodeValue;
		document.getElementById('txtDescription').value=XMLDescription[0].childNodes[0].nodeValue;
		document.getElementById('txtMeasurement').value=XMLMeasurement[0].childNodes[0].nodeValue;
	}
	else
	{
		document.getElementById('txtContainer').value='';
		document.getElementById('txtDescription').value='';
		document.getElementById('txtMeasurement').value='';

	}
}

function clearForm()
{
	window.location.reload();
}

function deleteData()
{
	var containerId		=	document.getElementById('cboContainer').value;
	if(containerId>0)
	{
		var url ="container-db.php?id=deleteData";
		    url+="&containerId="+containerId;
		
		var html_obj	  = $.ajax({url:url,async:false});
		
		alert(html_obj.responseText);
		clearForm();
	}
	else
		alert("Please select a container to delete");
}

