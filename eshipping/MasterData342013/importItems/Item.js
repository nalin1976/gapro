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

function getItemDetails() 
{	
	var Item=document.getElementById("cboItem").value;
	if (Item)
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=stateChanged;
		xmlHttp[0].open("GET",'itemmiddle.php?request=getdata&Item=' + Item,true);
		xmlHttp[0].send(null);	
		}
	else
		{
		ClearForm();
		}
}

function stateChanged() 
{ 
	if(xmlHttp[0].readyState == 4) 
    {
        if(xmlHttp[0].status == 200) 
        {  
        		
        //	alert(xmlHttp[0].responseText);
        		
        		var itemname = xmlHttp[0].responseXML.getElementsByTagName("ItemName")[0].childNodes[0].nodeValue;
        		document.getElementById("txtName").value = itemname;
        		var unit = xmlHttp[0].responseXML.getElementsByTagName("Unit")[0].childNodes[0].nodeValue;
        		document.getElementById("cboUnit").value = unit	;
        		
        		var commoditycode = xmlHttp[0].responseXML.getElementsByTagName("Commoditycode")[0].childNodes[0].nodeValue;
        		document.getElementById("cboCommodity").value = commoditycode;
        		 			
        		var rmarks = xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRemarks").value = rmarks	;
        		
        }
    }
}


function ClearForm()
{

document.getElementById("cboItem").value = "";
document.getElementById("txtName").value = "";
document.getElementById("cboUnit").value = "";
document.getElementById("cboCommodity").value = "";
document.getElementById("txtRemarks").value ="";

}


function doInsert(req)
{
		var update=req;
		var CODE=document.getElementById("cboItem").value;
		var ITEMNAME=	document.getElementById("txtName").value;
		var UNIT=	document.getElementById("cboUnit").value;
		var COMMODITY=	document.getElementById("cboCommodity").value;
		var REMARKS=	document.getElementById("txtRemarks").value;
		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);				
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'itemeditdb.php?ITEMNAME='+ ITEMNAME + '&CODE=' + CODE + '&REQUEST=' + update +'&UNIT=' + UNIT + '&COMMODITY=' + COMMODITY +  '&REMARKS=' +REMARKS , true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
			
			validatebd();
		
	}	
}


function validateForm()
	{
			
		if(document.getElementById("txtName").value=="" )
			{
			alert("Please enter the item description. ");
			document.getElementById("txtName").focus();
			return false;
			}
			
		if(document.getElementById("cboUnit").value =="" )
			{
			alert("Please select a unit.");
			return false;
			}
			
		/*if(document.getElementById("cboCommodity").value=="" )
			{
			alert("Please select a commodity code.");
			return false;
			}*/
					
		else
			{
		
	
			return true;
			}
	}

	
	
function validatebd()
{		
	var itemname=	document.getElementById("txtName").value;
	var itemcode =	document.getElementById("cboItem").value;
	if (itemcode)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'itemmiddle.php?request=checkdb&CODE=' + itemcode + '&ITEMNAME=' + itemname  ,true);
		xmlHttp[0].send(null);
		}
		
	else
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'itemmiddle.php?request=checkdb&ITEMNAME='  + itemname  ,true);
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
						alert("Sorry! Name already exist. ")				 	
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
 		if(document.getElementById("cboItem").value!="")
 		{
			var bname=	document.getElementById("cboItem").options[document.getElementById("cboItem").selectedIndex].text;
			var deleted = confirm("Are you sure you want to  delete '" +bname+ "' ?");
 		
			if (deleted)		
			{
				var request="delete";
				var itemcode=	document.getElementById("cboItem").value;
				createNewXMLHttpRequest(0);
				xmlHttp[0].onreadystatechange=function()
				{
					if(xmlHttp[0].readyState == 4)
					{
						setTimeout("location.reload(true);",100);			
						alert(xmlHttp[0].responseText);	
					}
				}		
				xmlHttp[0].open("GET",'itemeditdb.php?REQUEST='  + request + '&CODE=' + itemcode , true);
				xmlHttp[0].send(null);	
			}	
			
		}
		else
		{
			alert("Please select a item. ");
		}
	}		
 
}