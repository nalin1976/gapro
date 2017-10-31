var xmlHttp = [];

//<script ="../Bank/bank.js">

function createNewXMLHttpRequest(index) 
{
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}


function ClearForm()
{

document.getElementById("txtSerial").value = "";
document.getElementById("txtCMBFloor").value = "";
document.getElementById("txtCMBCeiling").value = "";
document.getElementById("txtAmount").value = "";


}


function doInsert(req)
{
		var update=req;
		var serial=document.getElementById("txtSerial").value;
		var CMBFloor=document.getElementById("txtCMBFloor").value ;
		var CMBCeiling=document.getElementById("txtCMBCeiling").value;
		var Amount=document.getElementById("txtAmount").value;
		
		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				//setTimeout("location.reload(true);",100);				
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'charges.php?SERIAL='+ serial + '&CMBFloor='  +CMBFloor+ '&REQUEST=' + update + '&CMBCeiling=' + CMBCeiling + '&Amount=' + Amount  , true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
			alert("validated");
			validatebd();
		
	}	
}


function validateForm()
	{
			
		if(document.getElementById("txtSerial").value =="" )
			{
			alert("Please enter a serial number. ");
			document.getElementById("txtSerial").focus();
			return false;
			}
			
		if(document.getElementById("txtCMBFloor").value =="" )
			{
			alert("Please enter CMB Floor.");
			document.getElementById("txtCMBFloor").focus()
			return false;
			}
			
		if(document.getElementById("txtCMBCeiling").value =="" )
					{
			alert("Please enter CMB Ceiling.");
			document.getElementById("txtCMBCeiling").focus()
			return false;
			}
		
		if(document.getElementById("txtAmount").value =="" )
			{
			alert("Please enter amount.");
			document.getElementById("txtAmount").focus()
			return false;
			}
		
				
		else
			{
		
	
			return true;
			}
	}

	
	
function validatebd()
{		
	var serial=	document.getElementById("txtSerial").value;
	
	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'chargesmiddle.php?request=checkdb&SERIAL=' + serial   ,true);
		xmlHttp[0].send(null);

		
	

}


function checkAvailability()
{
	if(xmlHttp[0].readyState == 4) 
	{
        if(xmlHttp[0].status == 200) 
        	{	alert(xmlHttp[0].responseText);
				 var res= xmlHttp[0].responseText;
				 if (res=="cant")
				 	{
						alert("Sorry! Record already exist. ")				 	
				 	}
				    
				if (res=="update")
				 	{
						var ans=confirm("Record already exist, do you want to Update?");
						if (ans)
						{
							var req="update";
							doInsert(req);
						}
						 	
				 	}
				 	
				if (res=="insert")
				 	{	
				 		var req="insert";
						doInsert(req);					 	
				 	}  
				    	  
				 		
      	}
    }	
}



function deleteData()
{
 	{ 
 	if(document.getElementById("txtSerial").value!="")
 		{
		var serial=	document.getElementById("txtSerial").value;
		var deleted = confirm("Are you sure you want to  delete THIS ecord?" );
 		
		if (deleted)		
			{
			var request="delete";
			
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				setTimeout("location.reload(true);",100);			
				alert(xmlHttp[0].responseText);	
				}
			}		
				xmlHttp[0].open("GET",'charges.php?REQUEST=' + request +  '&SERIAL=' + serial , true);
				xmlHttp[0].send(null);	
		}	
			
		
	
		
	}				
}		
 
}