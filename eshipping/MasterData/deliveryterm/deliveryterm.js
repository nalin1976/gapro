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
		xmlHttp[0].open("GET" ,'deliverytermmiddle.php?request=GetDetails&SearchID=' +SearchID ,true);
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
			var XMLCode	= xmlHttp[0].responseXML.getElementsByTagName("deliverycode")[0].childNodes[0].nodeValue;
			document.getElementById('txtDeliveryCode').value = XMLCode;
				
			var XMLName	= xmlHttp[0].responseXML.getElementsByTagName("deliveryname")[0].childNodes[0].nodeValue;
			document.getElementById('txtDeliveryName').value = XMLName;
			
		}
	}

function ClearForm()
{

	document.getElementById("txtDeliveryCode").value = "";
	document.getElementById("txtDeliveryName").value = "";
	document.getElementById("cboSearch").value="";
}


function doInsert(req)
{	

		
		var update	= req;
		var SearchID		= document.getElementById("cboSearch").value;
		var deliverycode	= document.getElementById("txtDeliveryCode").value;
		var deliveryname	= document.getElementById("txtDeliveryName").value;
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);		
							
				}
		
		}
		
		xmlHttp[0].open("GET",'deliverytermdb.php?SearchID='+URLEncode(SearchID) + '&deliverycode=' +URLEncode(deliverycode) + '&request=' + update +'&deliveryname=' +URLEncode(deliveryname), true);
		xmlHttp[0].send(null);	
}
		
	
	function deleteData()
	{
		
		var dcode=	document.getElementById("cboSearch").value;	
		
		if(dcode!="")
		{
			var dname= document.getElementById("cboSearch").options[document.getElementById("cboSearch").selectedIndex].text;		
			var dcod=confirm("Are you sure you want to delete '" +dname+ "'?");	
				
				if (dcod)
				{
					createNewXMLHttpRequest(0);
					xmlHttp[0].onreadystatechange=function()
					{
						if(xmlHttp[0].readyState==4)
						{
							alert(xmlHttp[0].responseText);	
							setTimeout("location.reload(true);",100);						
						}
											
					}
					xmlHttp[0].open("GET",'deliverytermdb.php?request=deletedata&SearchID=' + dcode ,true);
					xmlHttp[0].send(null);	
					
				}		
		
		}	
		else
		{
			alert("Please select a Delivery Term.");
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
	
	
	function validateForm()
	{
	
	
		if(document.getElementById("txtDeliveryCode").value == "" )
			{
			alert("Please enter a Delivery Code.");
			document.getElementById("txtDeliveryCode").focus();
			return false;
			}
			
		 if(document.getElementById("txtDeliveryName").value=="" )
			{
			alert("Please enter a Delivery Name.");
			document.getElementById("txtDeliveryName").focus();
			return false;
			}
			else
			{
				return true;
			}
	}

	
	
	function validatebd()
{		
	var SearchID=	document.getElementById("cboSearch").value;
	var deliverycode =	document.getElementById("txtDeliveryCode").value;
	
	if (SearchID)
		{	
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=checkAvailability;
			xmlHttp[0].open("GET",'deliverytermmiddle.php?request=checkdb&SearchID=' + SearchID + '&deliverycode=' + URLEncode(deliverycode) ,true);
			xmlHttp[0].send(null);
		}
		
	else
		{
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=checkAvailability;
			xmlHttp[0].open("GET",'deliverytermmiddle.php?request=checkdb&deliverycode='  + URLEncode(deliverycode)  ,true);
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
						alert("Sorry! Delivery code already exist. ")				 	
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

	
	
