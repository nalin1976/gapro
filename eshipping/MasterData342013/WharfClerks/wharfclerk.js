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

function getClerkDetail()
{	
	var clerk = document.getElementById("cboClerk").value;

	if (clerk)
		{

		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=stateChanged;
		xmlHttp[0].open("GET",'clerkmiddle.php?request=getdata&buyer=' + clerk,true);
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
        		var remarks1 = xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRemarks").value = remarks1;
        		var tinno = xmlHttp[0].responseXML.getElementsByTagName("Tino")[0].childNodes[0].nodeValue;
        		document.getElementById("txtTIN").value = tinno;
				var wIdNo = xmlHttp[0].responseXML.getElementsByTagName("wIdNo")[0].childNodes[0].nodeValue;
        		document.getElementById("txtIdnumber").value = wIdNo;
        		
        		
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
document.getElementById("txtRemarks").value = "";
document.getElementById("txtTIN").value = "";
document.getElementById("cboClerk").value="";
document.getElementById("txtIdnumber").value="";
}


function doInsert(req)
{	
		var update=req;
		var ID=document.getElementById("cboClerk").value;
		var BUYERNAME=	document.getElementById("txtName").value;
		var ADD1=	document.getElementById("txtAddress1").value;
		var ADD2=	document.getElementById("txtAddress2").value;
		var COUNTRY=	document.getElementById("txtCountry").value;
		var PHONE=	document.getElementById("txtPhone").value;
		var TIN=	document.getElementById("txtTIN").value;
		var FAX=	document.getElementById("txtFax").value;
		var MAIL=	document.getElementById("txtEmail").value;
		var REMARKS=	document.getElementById("txtRemarks").value;
		var widno=	document.getElementById("txtIdnumber").value;
			
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);				
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'clerkeditdb.php?BNAME='+ BUYERNAME + '&ID=' + ID + '&REQUEST=' + update +'&ADD1=' + ADD1 + '&ADD2=' + ADD2 + '&COUNTRY=' + COUNTRY +  '&PHONE=' +PHONE+ '&FAX='+FAX+ '&MAIL=' +MAIL+  '&REMARKS=' + REMARKS + '&TIN=' + TIN + '&widno=' + widno, true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
		var str=document.getElementById("txtEmail").value;
		if(document.getElementById("txtEmail").value!="")
		{
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
		else
			validatebd();
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
		/*	
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
			
			
		if(document.getElementById("txtPhone").value =="" )
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
	
	
		if(document.getElementById("txtTIN").value=="" )
			{
			alert("Please enter the TIN number.");
			document.getElementById("txtTIN").focus();
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
	var BuyerCode =	document.getElementById("cboClerk").value;
	
	if (BuyerCode)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'clerkmiddle.php?request=checkdb&buyerid=' + BuyerCode + '&buyername=' + BName  ,true);
		xmlHttp[0].send(null);
		}
		
	else
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'clerkmiddle.php?request=checkdb&buyername='  + BName  ,true);
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
 	if(document.getElementById("cboClerk").value!="")
 		{
		var dclerk=	document.getElementById("cboClerk").options[document.getElementById("cboClerk").selectedIndex].text;
		var deleted = confirm("Are you sure you want to  delete '" +dclerk+ "' ?");
 		
		if (deleted)		
			{
			var request="delete";
			var BCode=	document.getElementById("cboClerk").value;
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				setTimeout("location.reload(true);",100);			
				alert(xmlHttp[0].responseText);	
				}
			}
				xmlHttp[0].open("GET",'clerkeditdb.php?REQUEST='  + request + '&ID=' + BCode , true);
				xmlHttp[0].send(null);			
		}		
		
	
		
	}				
}		
 
}

