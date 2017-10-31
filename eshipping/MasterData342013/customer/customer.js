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

function getCompanyDetails()
{	
	var company = document.getElementById("cboCompany").value;
	
	
	if (company)
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=stateChanged;
		xmlHttp[0].open("GET",'customermiddle.php?request=getdata&COMPANYID=' + company,true);
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
			var companyid = xmlHttp[0].responseXML.getElementsByTagName("CompanyId")[0].childNodes[0].nodeValue;
        		document.getElementById("cboCompany").value = companyname	;
	       	var companyname = xmlHttp[0].responseXML.getElementsByTagName("companyname")[0].childNodes[0].nodeValue;
        		document.getElementById("txtCompanyName").value = companyname	;
        	var mlocation = xmlHttp[0].responseXML.getElementsByTagName("Mlocation")[0].childNodes[0].nodeValue;
        		document.getElementById("txtMLocation").value = mlocation	;        		
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
        		var remarks = xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRemarks").value = remarks;
        		var tino= xmlHttp[0].responseXML.getElementsByTagName("TINO")[0].childNodes[0].nodeValue;
        		document.getElementById("txtTin").value = tino ;
        		var vender = xmlHttp[0].responseXML.getElementsByTagName("VendorCode")[0].childNodes[0].nodeValue;
        		document.getElementById("txtVender").value =vender;
        		var MIDCode = xmlHttp[0].responseXML.getElementsByTagName("MIDCode")[0].childNodes[0].nodeValue;
        		document.getElementById("txtMid").value = MIDCode ;
        		var Sequenceno = xmlHttp[0].responseXML.getElementsByTagName("Sequenceno")[0].childNodes[0].nodeValue;
        		document.getElementById("txtSequence").value = Sequenceno ;
        		var Location = xmlHttp[0].responseXML.getElementsByTagName("Location")[0].childNodes[0].nodeValue;
        		document.getElementById("txtLocation").value = Location ;
        		var Tbq = xmlHttp[0].responseXML.getElementsByTagName("TQBNo")[0].childNodes[0].nodeValue;
        		document.getElementById("txtTbq").value = Tbq ;
     			var PPCCode = xmlHttp[0].responseXML.getElementsByTagName("PPCCode")[0].childNodes[0].nodeValue;
        		document.getElementById("txtPpc").value = PPCCode ;
        		var ExportRegNo = xmlHttp[0].responseXML.getElementsByTagName("ExportRegNo")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRegistration").value = ExportRegNo ;
        		var RefNo = xmlHttp[0].responseXML.getElementsByTagName("RefNo")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRefno").value = RefNo ;
     			var AuthorizedPerson = xmlHttp[0].responseXML.getElementsByTagName("AuthorizedPerson")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAuthorize").value = AuthorizedPerson ;
     			document.getElementById("txtLicence").value= xmlHttp[0].responseXML.getElementsByTagName("LicenceNo")[0].childNodes[0].nodeValue;
				document.getElementById("txtFacCode").value= xmlHttp[0].responseXML.getElementsByTagName("FacCode")[0].childNodes[0].nodeValue;  
     	
     	
     			
     
        }
    }
}


function ClearForm()
{
document.getElementById("txtCompanyName").value = "";
document.getElementById("txtMLocation").value = "";
document.getElementById("txtAddress1").value = "";
document.getElementById("txtAddress2").value = "";
document.getElementById("txtCountry").value = "";
document.getElementById("txtPhone").value = "";
document.getElementById("txtFax").value = "";
document.getElementById("txtEmail").value = "";
document.getElementById("txtTin").value = "" ;
document.getElementById("txtRemarks").value = "";
document.getElementById("cboCompany").value="";
document.getElementById("txtTbq").value ="";
document.getElementById("txtAuthorize").value ="";
document.getElementById("txtPpc").value = "" ;
document.getElementById("txtLocation").value = "" ;
document.getElementById("txtMid").value = "" ;
document.getElementById("txtVender").value ="";
document.getElementById("txtRefno").value = "" ;
document.getElementById("txtRegistration").value = "" ;
document.getElementById("txtSequence").value ="";
document.getElementById("txtLicence").value ="";
document.getElementById("txtFacCode").value ="";
}


function doInsert(req)
{
	
	var update=req;
	var id= document.getElementById("cboCompany").value; 
	var company=document.getElementById("txtCompanyName").value ;
	var Mlocation=document.getElementById("txtMLocation").value ;
	var address1=document.getElementById("txtAddress1").value ;
	var address2= document.getElementById("txtAddress2").value ;
	var country=document.getElementById("txtCountry").value ;
	var phone=document.getElementById("txtPhone").value ;
	var fax=document.getElementById("txtFax").value ;
	var email=document.getElementById("txtEmail").value ;
	var tin=document.getElementById("txtTin").value  ;
	var remarks=document.getElementById("txtRemarks").value ;
	var companyid=document.getElementById("cboCompany").value;
	var tbq=document.getElementById("txtTbq").value ;
	var authorize=document.getElementById("txtAuthorize").value;
	var Ppc=document.getElementById("txtPpc").value  ;
	var location=document.getElementById("txtLocation").value ;
	var mid=document.getElementById("txtMid").value  ;
	var vender=document.getElementById("txtVender").value;
	var REFNO=document.getElementById("txtRefno").value  ;
	var registration=document.getElementById("txtRegistration").value  ;
	var sequence=document.getElementById("txtSequence").value ;
	var licence=document.getElementById("txtLicence").value ;
	var facCode=document.getElementById('txtFacCode').value;
	createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function()
		{
			if(xmlHttp[0].readyState == 4)
				{
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);				
				}
		
		}		
		
		
		xmlHttp[0].open("GET",'customereditdb.php?COMPANY='+URLEncode(company) +'&mlocation='+URLEncode(Mlocation)+ '&address1=' +URLEncode(address1)+ '&address2='+URLEncode(address2)+ '&REQUEST=' + update + '&COUNTRY=' +URLEncode(country) +  '&PHONE=' + phone + '&FAX='+ fax + 
		'&MAIL=' +URLEncode(email)+  '&REMARKS=' +URLEncode(remarks)+ '&TINO=' + tin + '&TBQ=' +URLEncode(tbq)+ '&AUTHORIZE=' +URLEncode(authorize)+ '&PPC=' +URLEncode(Ppc)+ '&LOCATION=' +URLEncode(location)+ '&MID=' +URLEncode(mid)+ '&VENDER=' +URLEncode(vender)+ '&REFNO=' +URLEncode(REFNO)+ '&REG=' +URLEncode(registration)+ '&SEQENCE=' +URLEncode( sequence) + '&ID=' +URLEncode(id)+ '&licence=' +URLEncode(licence)+ '&facCode=' +URLEncode(facCode)  , true);
		xmlHttp[0].send(null);	
}


function saveData()
{
	
	if(validateForm())
		
	{	
		var str=document.getElementById("txtEmail").value;
		if(str!="")
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
	
	
		if(document.getElementById("txtCompanyName").value == "" )
			{
			alert("Please enter a company name.");
			document.getElementById("txtCompanyName").focus();
			return false;
			}
			
			if(document.getElementById("txtMLocation").value=="" )
			{
			alert("Please enter a Location.");
			document.getElementById("txtMLocation").focus();
			return false;
			}
			
		 if(document.getElementById("txtAddress1").value=="" )
			{
			alert("Please enter the address.");
			document.getElementById("txtAddress1").focus();
			return false;
			}
			
				
	 	if(document.getElementById("txtCountry").value=="" )
			{
			alert("Please enter the Country.");
			document.getElementById("txtCountry").focus();
			return false;
			}
			
		
		/*	
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
			
		if(document.getElementById("txtVender").value=="" )
			{
			alert("Please enter a the vender.");
			document.getElementById("txtVender").focus();
			return false;
			}
		*/	
				
		if(document.getElementById("txtTin").value=="" )
			{
			alert("Please enter a the TIN no.");
			document.getElementById("txtTin").focus();
			return false;
			}
		/*
		if(document.getElementById("txtMid").value=="" )
			{
			alert("Please enter a the MID code.");
			document.getElementById("txtMid").focus();
			return false;
			}
			
		if(document.getElementById("txtSequence").value=="" )
			{
			alert("Please enter a the Sequence no.");
			document.getElementById("txtSequence").focus();
			return false;
			}
				
		if(document.getElementById("txtLocation").value=="" )
			{
			alert("Please enter the  Location.");
			document.getElementById("txtLocation").focus();
			return false;
			}
		
		if(document.getElementById("txtTbq").value=="" )
			{
			alert("Please enter the TQB.");
			document.getElementById("txtTbq").focus();
			return false;
			}
			
		if(document.getElementById("txtTbq").value=="" )
			{
			alert("Please enter the TQB.");
			document.getElementById("txtTbq").focus();
			return false;
			}
			
		if(document.getElementById("txtPpc").value=="" )
			{
			alert("Please enter the PPCcode.");
			document.getElementById("txtPpc").focus();
			return false;
			}		
		/*		
		if(document.getElementById("txtRegistration").value=="" )
			{
			alert("Please enter the Registration no.");
			document.getElementById("txtRegistration").focus();
			return false;
			}	
	
		if(document.getElementById("txtRefno").value=="" )
			{
			alert("Please enter the Ref no.");
			document.getElementById("txtRefno").focus();
			return false;
			}	
			
	
		if(document.getElementById("txtRemarks").value=="" )
			{
			alert("Please enter the remarks.");
			document.getElementById("txtRemarks").focus();
			return false;
			}
			
		if(document.getElementById("txtAuthorize").value=="" )
			{
			alert("Please enter the authorized person.");
			document.getElementById("txtAuthorize").focus();
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
	var companyname =	document.getElementById("txtCompanyName").value;
	var companycode =	document.getElementById("cboCompany").value;
	var location	=	document.getElementById("txtMLocation").value;
	if (companycode)
		{	
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'customermiddle.php?request=checkdb&COMPANYID=' +URLEncode(companycode) +'&location=' +URLEncode(location)  ,true);
		xmlHttp[0].send(null);
		}
		
	else
		{
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'customermiddle.php?request=checkdb&location='  + URLEncode(location) ,true);
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
						alert("Sorry! location already exist. ")				 	
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
 	if(document.getElementById("cboCompany").value!="")
 		{
			var dcompany=	document.getElementById("cboCompany").options[document.getElementById("cboCompany").selectedIndex].text;
			var deleted = confirm("Are you sure you want to  delete '" +dcompany+ "' ?");
 		
		if (deleted)		
		{
			var request="delete";
			var companyid=	document.getElementById("cboCompany").value;
			createNewXMLHttpRequest(0);
			xmlHttp[0].onreadystatechange=function()
			{
				if(xmlHttp[0].readyState == 4)
					{
						setTimeout("location.reload(true);",100);			
						alert(xmlHttp[0].responseText);	
					}
			}	
			
			xmlHttp[0].open("GET",'customereditdb.php?REQUEST='  + request + '&ID=' + companyid , true);
			xmlHttp[0].send(null);		
		}		
		
	
		
	}
	else
	{
		alert("Please select a Customer.");
	}
}		
 
}