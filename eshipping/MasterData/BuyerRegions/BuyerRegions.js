// JavaScript Document

function validateData()
{
	if(document.getElementById('txtDescription').value=="")
	{
		alert("Please insert \" Description \" ");
	}
	else 
	{
	savedata()
	}
	
}

function savedata()
{
	var cboSearch=document.getElementById('cboSearch').value;
	var txtDescription=document.getElementById('txtDescription').value;
	
	var url ="BuyerRegions_db.php?id=saveData";
			url+="&cboSearch="+cboSearch;
			url+="&txtDescription="+txtDescription;
		

			
		var htmlhttp_obj	  = $.ajax({url:url,async:false});
		alert(htmlhttp_obj.responseText);
		
		window.location.href = 'BuyerRegions.php';
}

function getData(obj)
{
	var cboSearch=obj.value;
	//alert(cboSearch);
	if(cboSearch!=="")
	{
		var url ="BuyerRegions_db.php?id=dataRetrive";
			url+="&cboSearch="+cboSearch;
		
		var htmlhttp_obj	  = $.ajax({url:url,async:false});
		//var XMLDescription = htmlhttp_obj.responseXML.getElementsByTagName("Description");
		
	    document.getElementById('txtDescription').value =htmlhttp_obj.responseText;
	}
}

function deleteData()
{

	var cboSearch=document.getElementById('cboSearch').value;
	if(cboSearch!=="")
	
	var url ="BuyerRegions_db.php?id=delete";
			url+="&cboSearch="+cboSearch;
			
	
			
		var htmlhttp_obj	  = $.ajax({url:url,async:false});
		alert(htmlhttp_obj.responseText);
		
		window.location.href = 'BuyerRegions.php';
		
}

function ClearForm()
{
		var cboSearch=document.getElementById('cboSearch').value="";
		var txtDescription=document.getElementById('txtDescription').value="";
		
		window.location.href = 'BuyerRegions.php';
}


