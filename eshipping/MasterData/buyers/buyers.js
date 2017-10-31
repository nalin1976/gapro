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

function getCustomerDetails() 
{	
	var buyer = document.getElementById("cboCustomer").value;
	if (buyer)
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=stateChanged;
		xmlHttp[0].open("GET",'buyersMiddle.php?request=getdata&buyer=' + buyer,true);
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
        		
        		document.getElementById("txtBuyerID").value = xmlHttp[0].responseXML.getElementsByTagName("BuyerId")[0].childNodes[0].nodeValue;
        		var buyername = xmlHttp[0].responseXML.getElementsByTagName("BuyerName")[0].childNodes[0].nodeValue;
        		document.getElementById("txtName").value = buyername	;
        	     		
        		var address1 = xmlHttp[0].responseXML.getElementsByTagName("Address1")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress1").value = address1	;
        		var address2 = xmlHttp[0].responseXML.getElementsByTagName("Address2")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress2").value = address2	;
				var address3 = xmlHttp[0].responseXML.getElementsByTagName("Address3")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAddress3").value = address3	;
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
        		var tino1 = xmlHttp[0].responseXML.getElementsByTagName("TINO")[0].childNodes[0].nodeValue;
        		document.getElementById("txtTIN").value = tino1 ;
				var cp = xmlHttp[0].responseXML.getElementsByTagName("Cp")[0].childNodes[0].nodeValue;
        		document.getElementById("txtCP").value = cp ;
				var masterBuyer = xmlHttp[0].responseXML.getElementsByTagName("MainBuyerId")[0].childNodes[0].nodeValue;
				//alert(masterBuyer);
        		document.getElementById("cboMainBuyer").value = masterBuyer ;
        }
    }
}


function ClearForm()
{

	document.getElementById("txtBuyerID").value = "";
	document.getElementById("txtName").value = "";
	document.getElementById("txtAddress1").value = "";
	document.getElementById("txtAddress2").value = "";
	document.getElementById("txtCountry").value = "";
	document.getElementById("txtPhone").value = "";
	document.getElementById("txtFax").value = "";
	document.getElementById("txtEmail").value = "";
	document.getElementById("txtTIN").value = "" ;
	document.getElementById("txtRemarks").value = "";
	document.getElementById("cboCustomer").value="";
	document.getElementById("txtCP").value="";
	//document.getElementById("cboMasterBuyer").value="";
	document.getElementById("txtAddress3").value="";
}


function doInsert(req)
{
		var update=req;
		var mainBuyerId	= document.getElementById('cboMainBuyer').value;
		var intId=document.getElementById("cboCustomer").value;
		var ID=document.getElementById("txtBuyerID").value;
		var BUYERNAME=	document.getElementById("txtName").value;
		var ADD1=	document.getElementById("txtAddress1").value;
		var ADD2=	document.getElementById("txtAddress2").value;
		var ADD3=	document.getElementById("txtAddress3").value;
		var COUNTRY=	document.getElementById("txtCountry").value;
		var PHONE=	document.getElementById("txtPhone").value;
		var FAX=	document.getElementById("txtFax").value;
		var MAIL=	document.getElementById("txtEmail").value;
		var REMARKS=	document.getElementById("txtRemarks").value;
		var TINO=	document.getElementById("txtTIN").value;
		var CP1=	document.getElementById("txtCP").value;
		//var MASTERBUYER=	document.getElementById("cboMasterBuyer").value;
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
					alert(xmlHttp[0].responseText);
					
					setTimeout("location.reload(true);",100);			
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'editdb.php?BNAME='+URLEncode(BUYERNAME) + '&ID=' +URLEncode(ID) + '&REQUEST=' + update +'&ADD1=' +URLEncode(ADD1) + '&ADD2=' +URLEncode(ADD2)+ '&ADD3=' +URLEncode(ADD3) + '&COUNTRY=' +URLEncode(COUNTRY) +  '&PHONE='+URLEncode(PHONE)+ '&FAX='+FAX+ '&MAIL=' +URLEncode(MAIL)+  '&REMARKS=' +URLEncode(REMARKS)+ '&TINO=' + URLEncode(TINO)+ '&intId=' +URLEncode(intId)+'&CP1='+URLEncode(CP1)+ '&MainBuyerId='+mainBuyerId , true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
		var str=document.getElementById("txtEmail").value;
		if (str!="")
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
			alert("Please enter a name ");
			document.getElementById("txtName").focus();
			return false;
			}
			
		/*
			
		if(document.getElementById("txtAddress2").value=="" )
			{
			alert("Please enter the city.");
			document.getElementById("txtAddress2").focus();
			return false;
			}
			
		if(document.getElementById("txtCountry").value=="" )
			{
			alert("Please enter the Country.");
			document.getElementById("txtCountry").focus();
			return false;
			}*/
			
		if(document.getElementById("txtBuyerID").value=="" )
			{
			alert("Please enter the code.");
			document.getElementById("txtBuyerID").focus();
			return false;
			}
			
		
		/*if(document.getElementById("txtFax").value=="" )
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
			alert("Please enter the bank TINO.");
			document.getElementById("txtTIN").focus();
			return false;
			}
	
		if(document.getElementById("txtRemarks").value=="" )
			{
			alert("Please enter the remarks.");
			document.getElementById("txtRemarks").focus();
			return false;
			}*/
				
		else
			{
		
	
			return true;
			}
	}

	
	
function validatebd()
{		
	var BName=	document.getElementById("txtName").value;
	var BuyerId  =	document.getElementById("cboCustomer").value;
	var BuyerCode=	document.getElementById("txtBuyerID").value;

	if (BuyerCode)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'buyersMiddle.php?request=checkdb&buyerid=' + BuyerId + '&buyername=' + BName+ '&BuyerCode=' + BuyerCode  ,true);
		xmlHttp[0].send(null);
		}
		
	else
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'buyersMiddle.php?request=checkdb&buyername='  + BName  ,true);
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
						alert("Buyer name and code already exist. ")				 	
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
			var bname=	document.getElementById("cboCustomer").options[document.getElementById("cboCustomer").selectedIndex].text;
			var deleted = confirm("Are you sure you want to  delete '" +bname+ "' ?");
 		
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
				xmlHttp[0].open("GET",'editdb.php?REQUEST='  + request + '&ID=' + BCode , true);
				xmlHttp[0].send(null);	
			}	
		}
		else
		{
			alert("Please select a Buyer.");
		}
	}		
 
}