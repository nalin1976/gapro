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

function getForwadersDetails()
{	
	var buyer = document.getElementById("cboForwader").value;

	if (buyer)
		{

		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=stateChanged;
		xmlHttp[0].open("GET",'forwadersmiddle.php?request=getdata&buyer=' + buyer,true);
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
        		var Forwader = xmlHttp[0].responseXML.getElementsByTagName("Forwader")[0].childNodes[0].nodeValue;
        		document.getElementById("txtName").value = Forwader	;
        		var address1 = xmlHttp[0].responseXML.getElementsByTagName("Address1")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress1").value = address1	;
        		var address2 = xmlHttp[0].responseXML.getElementsByTagName("Address2")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress2").value = address2	;
        		var country = xmlHttp[0].responseXML.getElementsByTagName("Country")[0].childNodes[0].nodeValue;
        		document.getElementById("txtCountry").value = country	;
        		var phone = xmlHttp[0].responseXML.getElementsByTagName("Phone")[0].childNodes[0].nodeValue;
        		document.getElementById("txtPhone").value = phone;        			
        		var fax = xmlHttp[0].responseXML.getElementsByTagName("Fax")[0].childNodes[0].nodeValue;
        		document.getElementById("txtFax").value = fax	;
        		var email = xmlHttp[0].responseXML.getElementsByTagName("Email")[0].childNodes[0].nodeValue;
        		document.getElementById("txtEmail").value = email;
        		var charg = xmlHttp[0].responseXML.getElementsByTagName("Charg")[0].childNodes[0].nodeValue;
        		document.getElementById("txtCharg").value = charg;
       			var remarks1 = xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRemarks").value = remarks1;
        		
        }
    }
}


function ClearForm()
{

document.getElementById("txtName").value = "";
document.getElementById("txtAddress1").value = "";
document.getElementById("txtAddress2").value = "";
document.getElementById("txtCountry").value = "";
document.getElementById("txtPhone").value = "";
document.getElementById("txtFax").value = "";
document.getElementById("txtEmail").value = "";
document.getElementById("txtCharg").value = 
document.getElementById("txtRemarks").value = "";
document.getElementById("cboForwader").value="";
}


function doInsert(req)
{
		var update=req;
		var ID=document.getElementById("cboForwader").value;
		var BUYERNAME=	document.getElementById("txtName").value;
		var ADD1=	document.getElementById("txtAddress1").value;
		var ADD2=	document.getElementById("txtAddress2").value;
		var COUNTRY=	document.getElementById("txtCountry").value;
		var PHONE=	document.getElementById("txtPhone").value;
		var CHARG=	document.getElementById("txtCharg").value;
		var FAX=	document.getElementById("txtFax").value;
		var MAIL=	document.getElementById("txtEmail").value;
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
		
		
		xmlHttp[0].open("GET",'forwaderseditdb.php?BNAME='+ URLEncode(BUYERNAME) + '&ID=' + URLEncode(ID) + '&REQUEST=' + URLEncode(update) +'&ADD1=' + URLEncode(ADD1) + '&ADD2=' + URLEncode(ADD2) + '&COUNTRY=' + URLEncode(COUNTRY) +  '&PHONE=' +URLEncode(PHONE)+ '&FAX='+URLEncode(FAX)+ '&MAIL=' +URLEncode(MAIL)+  '&REMARKS=' + URLEncode(REMARKS) + '&CHARG=' + URLEncode(CHARG) , true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
		var str=document.getElementById("txtEmail").value;
		if (checkemail(str))
		{
			
			validatebd();
		}
		else
		{
			alert ("Incorrect email address");
			document.getElementById("txtEmail").focus;
		}
	}	
}


function validateForm()
	{
			
		if(document.getElementById("txtName").value=="" )
			{
			alert("Please enter a supplier name. ");
			document.getElementById("txtName").focus();
			return false;
			}
			
		if(document.getElementById("txtAddress1").value=="" )
			{
			alert("Please enter the address.");
			document.getElementById("txtAddress1").focus();
			return false;
			}
			
		if(document.getElementById("txtAddress2").value=="" )
			{
			alert("Please enter the City.");
			document.getElementById("txtAddress2").focus();
			return false;
			}
			
		if(document.getElementById("txtCountry").value=="" )
			{
			alert("Please enter the Country.");
			document.getElementById("txtCountry").focus();
			return false;
			}
			
			
		/*if(document.getElementById("txtPhone").value =="" )
			{
			alert("Please enter a Phone Number.");
			document.getElementById("txtPhone").focus();
			return false;
			}
					
		if(document.getElementById("txtFax").value=="" )
			{
			alert("Please enter a fax number.");
			document.getElementById("txtFax").focus();
			return false;
			}
			
		if(document.getElementById("txtCharg").value=="" )
			{
			alert("Please enter the do charges.");
			document.getElementById("txtCharg").focus();
			return false;
			}
		
		if(document.getElementById("txtEmail").value=="" )
			{
			alert("Please enter a valid e-mail address.");
			document.getElementById("txtEmail").focus();
			return false;
			}	
		
	
		if(document.getElementById("txtRemarks").value=="" ){
			alert("Please enter the remarks.");
			document.getElementById("txtRemarks").focus();
			return false;
			}	
	
	
		if(document.getElementById("txtRemarks").value=="" )
			{
			alert("Please enter the remarks.");
			document.getElementById("txtRemarks").focus();
			return false;
			}
				*/
		else
			{
		
	
			return true;
			}
	}

	
	
function validatebd()
{		
	var BName=	document.getElementById("txtName").value;
	var BuyerCode =	document.getElementById("cboForwader").value;
	
	if (BuyerCode)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'forwadersmiddle.php?request=checkdb&buyerid=' + URLEncode(BuyerCode) + '&buyername=' + URLEncode(BName)  ,true);
		xmlHttp[0].send(null);
		}
		
	else
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'forwadersmiddle.php?request=checkdb&buyername='  + URLEncode(BName)  ,true);
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
 	if(document.getElementById("cboForwader").value!="")
 		{
			var dlbname=	document.getElementById("cboForwader").options[document.getElementById("cboForwader").selectedIndex].text;
			var deleted = confirm("Are you sure you want to  delete '" +dlbname+ "' ?");
 		
			if (deleted)		
			{
					var request="delete";
					var BCode=	document.getElementById("cboForwader").value;
					createNewXMLHttpRequest(0);
					xmlHttp[0].onreadystatechange=function()
				{
				if(xmlHttp[0].readyState == 4)
					{
						setTimeout("location.reload(true);",100);			
						alert(xmlHttp[0].responseText);	
					}
				}
				xmlHttp[0].open("GET",'forwaderseditdb.php?REQUEST='  + request + '&ID=' + URLEncode(BCode) , true);
				xmlHttp[0].send(null);			
			}		
		}
		else
		{
			alert("Please select a Forwader Id.");
		}
	}		
 
}

