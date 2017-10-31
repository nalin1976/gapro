var xmlHttp = [];
var requestCity = "";

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

function getSuppliersDetails()
{	
	var buyer = document.getElementById("cboCustomer").value;

	if (buyer)
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=stateChanged;
		xmlHttp[0].open("GET",'suppliersmiddle.php?request=getdata&buyer=' + buyer,true);
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
        		//alert(xmlHttp[0].responseText);
        	
        		var buyername = xmlHttp[0].responseXML.getElementsByTagName("BuyerName")[0].childNodes[0].nodeValue;
        		document.getElementById("txtName").value = buyername	;
        		var address1 = xmlHttp[0].responseXML.getElementsByTagName("Address1")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress1").value = address1	;
        		var address2 = xmlHttp[0].responseXML.getElementsByTagName("Address2")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress2").value = address2	;
        		var country = xmlHttp[0].responseXML.getElementsByTagName("Country")[0].childNodes[0].nodeValue;
        		document.getElementById("txtCountry").value = country	;
        		var phone = xmlHttp[0].responseXML.getElementsByTagName("Phone")[0].childNodes[0].nodeValue;
        		document.getElementById("txtTelephone").value = phone;        			
        		var fax = xmlHttp[0].responseXML.getElementsByTagName("Fax")[0].childNodes[0].nodeValue;
        		document.getElementById("txtFax").value = fax	;
        		var email = xmlHttp[0].responseXML.getElementsByTagName("Email")[0].childNodes[0].nodeValue;
        		document.getElementById("txtEmail").value = email;
       	       var city = xmlHttp[0].responseXML.getElementsByTagName("City")[0].childNodes[0].nodeValue;
        		document.getElementById("cboCity").value=city;
        		var remarks1 = xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
				
        		document.getElementById("txtRemarks").value = remarks1;
        		var tino1 = xmlHttp[0].responseXML.getElementsByTagName("TINO")[0].childNodes[0].nodeValue;
        		document.getElementById("txtTIN").value = tino1 ;
				
        }
    }
}


function ClearForm()
{

document.getElementById("txtName").value = "";
document.getElementById("txtAddress1").value = "";
document.getElementById("txtAddress2").value = "";
document.getElementById("txtCountry").value = "";
document.getElementById("txtTelephone").value = "";
document.getElementById("cboCity").value = "";
document.getElementById("txtFax").value = "";
document.getElementById("txtEmail").value = "";
document.getElementById("txtTIN").value = "" ;
document.getElementById("txtRemarks").value = "";
document.getElementById("cboCustomer").value="";
requestCity = "";
}


function doInsert(req)
{
		var update=req;
		var ID=document.getElementById("cboCustomer").value;
		var BUYERNAME=	document.getElementById("txtName").value;
		BUYERNAME=URLDecode(BUYERNAME);
		var ADD1=	document.getElementById("txtAddress1").value;
		ADD1=URLDecode(ADD1);
		var ADD2=	document.getElementById("txtAddress2").value;
		ADD2=URLDecode(ADD2);
		var COUNTRY=	document.getElementById("txtCountry").value;
		var PHONE=	document.getElementById("txtTelephone").value;
		var CITY=	document.getElementById("cboCity").value;
		var FAX=	document.getElementById("txtFax").value;
		var MAIL=	document.getElementById("txtEmail").value;
		var REMARKS=	document.getElementById("txtRemarks").value;
		var TINO=	document.getElementById("txtTIN").value;		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);		
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'supplierseditdb.php?BNAME='+ BUYERNAME + '&ID=' + ID + '&REQUEST=' + update +'&ADD1=' + ADD1 + '&ADD2=' + ADD2 + '&COUNTRY=' + COUNTRY +  '&PHONE=' +PHONE+ '&FAX='+FAX+ '&MAIL=' +MAIL+  '&REMARKS=' + REMARKS + '&TINO=' + TINO + '&CITY=' + CITY , true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
		var str=document.getElementById("txtEmail").value;
		if (str=="")
		{
		validatebd();		
		}			
		else	
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
		/*	
		if(document.getElementById("txtAddress2").value=="" )
			{
			alert("Please enter the city.");
			document.getElementById("txtAddress2").focus();
			return false;
			}*/
			
		if(document.getElementById("txtCountry").value=="" )
			{
			alert("Please enter the country.");
			document.getElementById("txtCountry").focus();
			return false;
			}
		 /*	
		if(document.getElementById("txtTelephone").value =="" )
			{
			alert("Please enter a Phone Number.");
			document.getElementById("txtTelephone").focus();
			return false;
			}*/
			
		if(document.getElementById("cboCity").value=="" )
			{
			alert("Please enter the City.");
			document.getElementById("cboCity").focus();
			return false;
			}
	/*
		if(document.getElementById("txtEmail").value=="" )
			{
			alert("Please enter a valid e-mail address.");
			document.getElementById("txtEmail").focus();
			return false;
			}	
	
			
		if(document.getElementById("txtFax").value=="" )
			{
			alert("Please enter a fax number.");
			document.getElementById("txtFax").focus();
			return false;
			}
		
	
		if(document.getElementById("txtRemarks").value=="" ){
			alert("Please enter the remarks.");
			document.getElementById("txtRemarks").focus();
			return false;
			}	

		if(document.getElementById("txtTIN").value=="" )
			{
			alert("Please enter the bank TINO.");
			document.getElementById("txtTIN").focus();
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
	var BuyerCode =	document.getElementById("cboCustomer").value;
	
	if (BuyerCode)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'suppliersmiddle.php?request=checkdb&buyerid=' + BuyerCode + '&buyername=' + BName  ,true);
		xmlHttp[0].send(null);
		}
		
	else
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'suppliersmiddle.php?request=checkdb&buyername='  + BName  ,true);
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
 	if(document.getElementById("cboCustomer").value!="")
 		{
		var dlbname=	document.getElementById("cboCustomer").options[document.getElementById("cboCustomer").selectedIndex].text;
		var deleted = confirm("Are you sure you want to  delete '" +dlbname+ "' ?");
 		
		if (deleted)		
			{
			var request="delete";
			var BCode=	document.getElementById("cboCustomer").value;
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
			if(xmlHttp[0].readyState == 4)
				{
				setTimeout("location.reload(true);",100);			
				alert(xmlHttp[0].responseText);	
				}
			}
				xmlHttp[0].open("GET",'supplierseditdb.php?REQUEST='  + request + '&ID=' + BCode , true);
				xmlHttp[0].send(null);			
		}		
		
	
		
	}				
}		
 
}


/*
function  getCity()
{
var country=document.getElementById("txtCountry").value;
//alert(country);

createNewXMLHttpRequest(2);
	xmlHttp[2].onreadystatechange=function()
	{
	if(xmlHttp[2].readyState==4)
		{
				
			if(xmlHttp[2].status==200)
		{               
                document.getElementById("cboCity").length = 1;           


			var XMLCityName = xmlHttp[2].responseXML.getElementsByTagName("City");
			var XMLCityCode = xmlHttp[2].responseXML.getElementsByTagName("CityCode");

			for(var loop = 0 ; loop < XMLCityName.length ; loop ++)
			{
				
            var opt = document.createElement("option");
				opt.text =XMLCityName[loop].childNodes[0].nodeValue;
				opt.value =XMLCityCode[loop].childNodes[0].nodeValue;
				document.getElementById("cboCity").options.add(opt);
			
			}
			document.getElementById("cboCity").value = requestCity;
		}

		}	
	}
	xmlHttp[2].open("GET",'suppliersmiddle.php?request=city&COUNTRY=' + country ,true);
	xmlHttp[2].send(null);	 

}

*/