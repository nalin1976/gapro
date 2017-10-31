// JavaScript Document

///Edited by Bhagya...........


function checkEnterKey(e)
{
 // Internet Explorer
var press = e.keyCode;

if(press== 13)
	validateData();
else
	return false;
}


function validateData()
{
	var id=document.getElementById('txtDesc').value;
	
	if(id=='')
		alert("Please enter data to *Description");
	else
		saveData();	
}


function saveData()
{
	var description=document.getElementById('txtDesc').value;
	
	var gridLength=document.getElementById('tbl_measurementDet').rows.length;
	
	var status = 1;
	if(!document.getElementById('chkStatus').checked)
		status = 0;
	
	var id;
	id=document.getElementById('txtId').value;
	if(id=='')
	{
    	id=Number(gridLength)+1;
	}
	var url1="measurementPoint-db-get.php?requestType=saveData&id="+id+"&description="+description+"&status="+status;;
	var xmlhttp_obj1   = $.ajax({url:url1,async:false})
	var response1      = xmlhttp_obj1.responseText;
	
	alert(response1);
	
	reloadPage();
	
}

function reloadPage()
  {
  window.location.reload()
  }
  

function deleteRow(id)
{
	var r=confirm("Are you sure you want to delete \""+id+"\" ?");
		if (r==true)
		{
		var url = "measurementPoint-db-get.php?requestType=delete&id="+id;
		var objHttp = $.ajax({url:url,async:false});
		alert(objHttp.responseText);
		reloadPage();
		}
		else
		{
			document.getElementById('txtDesc').focus();
		}
}

function editRow(id,description)
{
	document.getElementById('txtDesc').focus();
	document.getElementById('txtId').value=id;
	document.getElementById('txtDesc').value=description;
}
