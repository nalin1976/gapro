var xmlHttp = [];

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
	setTimeout("location.reload(true);",0);
	return true;
}

function GetDetails()
{
	var SearchID	= document.getElementById('cboSearch').value;
	if(SearchID)
	{
	
		createNewXMLHttpRequest(0);	
		xmlHttp[0].onreadystatechange = GetDetailsRequest;
		xmlHttp[0].open("GET" ,'packagetypemiddle.php?request=GetDetails&SearchID=' +SearchID ,true);
		xmlHttp[0].send(null);
	}
	else
	{
		ClearForm();
	}
	
}

function GetDetailsRequest()
	{
		if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200)
		{
			var XMLCode	= xmlHttp[0].responseXML.getElementsByTagName("packagecode")[0].childNodes[0].nodeValue;
			document.getElementById('txtPackageCode').value = XMLCode;
				
			var XMLName	= xmlHttp[0].responseXML.getElementsByTagName("packagename")[0].childNodes[0].nodeValue;
			document.getElementById('txtPackageName').value = XMLName;
			
		}
	}

	function ClearForm()
{

	document.getElementById("txtPackageCode").value = "";
	document.getElementById("txtPackageName").value = "";
	document.getElementById("cboSearch").value="";
}
	
	
	function doInsert(req)
{	

		
		var update		= req;
		var SearchID	= document.getElementById("cboSearch").value;
		var packagecode	= document.getElementById("txtPackageCode").value;
		var packagename	= document.getElementById("txtPackageName").value;
		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);		
							
				}
		
		}
		
		xmlHttp[0].open("GET",'packagetypedb.php?SearchID='+SearchID + '&packagecode=' +URLEncode(packagecode) + '&request=' + update +'&packagename=' +URLEncode(packagename), true);
		xmlHttp[0].send(null);	
}
	
	
	
	function validateForm()
	{
	
	
		if(document.getElementById("txtPackageCode").value == "" )
			{
			alert("Please enter a Package Code.");
			document.getElementById("txtPackageCode").focus();
			return false;
			}
			
		 if(document.getElementById("txtPackageName").value=="" )
			{
			alert("Please enter a Package Name.");
			document.getElementById("txtPackageName").focus();
			return false;
			}
			else
			{
				return true;
			}
	}
	
	
	
	function deleteData()
{
 	{ 
 	if(document.getElementById("cboSearch").value!="")
 		{
			var ptype=	document.getElementById("cboSearch").options[document.getElementById("cboSearch").selectedIndex].text;
			var deleted = confirm("Are you sure you want to  delete '" +ptype+ "' ?");
 		
			if (deleted)		
			{
				var request="delete";
				var Ptype=	document.getElementById("cboSearch").value;
				createNewXMLHttpRequest(0);
				xmlHttp[0].onreadystatechange=function()
				{
					if(xmlHttp[0].readyState == 4)
						{
							setTimeout("location.reload(true);",100);			
							alert(xmlHttp[0].responseText);	
						}
				}		
				xmlHttp[0].open("GET",'packagetypedb.php?request=delete&ID=' + Ptype , true);
				xmlHttp[0].send(null);	
			}	
		}
		else
		{
			alert("Please select a Package type.");
		}
	}		
 
}



function SaveData()
	{
		if(validateForm())
		{
			validatebd();
		}
		else
		{
			
			return false;	
		}
	}
	
	
	
	function validatebd()
{		
	var SearchID=	document.getElementById("cboSearch").value;
	var packagecode =	document.getElementById("txtPackageCode").value;
	
	if (SearchID)
		{	
			
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=checkAvailability;
			xmlHttp[0].open("GET",'packagetypemiddle.php?request=checkdb&SearchID=' + SearchID + '&packagecode=' + URLEncode(packagecode) ,true);
			xmlHttp[0].send(null);
			
		}
		
	else
		{
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=checkAvailability;
			xmlHttp[0].open("GET",'packagetypemiddle.php?request=checkdb&packagecode='  + URLEncode(packagecode)  ,true);
			xmlHttp[0].send(null);
		}

}


function checkAvailability()
{	
	if(xmlHttp[0].readyState == 4) 
	{
        if(xmlHttp[0].status == 200) 
        	{
				 var res= xmlHttp[0].responseText;
				 if (res=="cant")
				 	{
						alert("Sorry! Package code already exist. ")				 	
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
