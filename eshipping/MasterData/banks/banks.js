var xmlHttp = [];
createNewXMLHttpRequest(0);

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

function LoadBankData()
{
	var bankCode = document.getElementById("cboBankName").value;
	if(bankCode=="")
	{Clear();}
	else
	{
	//createNewXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange=stateChanged;
	xmlHttp[0].open("GET",'banksMiddle.php?request=getData&bankCode=' + bankCode,true);
	xmlHttp[0].send(null);	
	}
}

function stateChanged() 
{ 
	if(xmlHttp[0].readyState == 4) 
    {
        if(xmlHttp[0].status == 200) 
        {  
        		//alert("Data already exist");
        		var bankName = xmlHttp[0].responseXML.getElementsByTagName("BankName")[0].childNodes[0].nodeValue;
        		document.getElementById("txtName").value = bankName;
        		var bankCode = xmlHttp[0].responseXML.getElementsByTagName("BankCode")[0].childNodes[0].nodeValue;
        		document.getElementById("txtBankCode").value = bankCode;
				
				var swiftCode = xmlHttp[0].responseXML.getElementsByTagName("SwiftCode")[0].childNodes[0].nodeValue;
        		document.getElementById("txtSwift").value = swiftCode;
				
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
        		document.getElementById("txtEMail").value = email	;
        		var contact = xmlHttp[0].responseXML.getElementsByTagName("ContactP")[0].childNodes[0].nodeValue;
        		document.getElementById("txtContactPerson").value = contact	;
        		var refno1 = xmlHttp[0].responseXML.getElementsByTagName("RefNo")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRefNo").value = refno1;
				var accName = xmlHttp[0].responseXML.getElementsByTagName("AccName")[0].childNodes[0].nodeValue;
        		document.getElementById("txtAccName").value = accName;
        		var remarks = xmlHttp[0].responseXML.getElementsByTagName("Remarks")[0].childNodes[0].nodeValue;
        		document.getElementById("txtRemarks").value = remarks;
        }
    }
}



function doInsert(req)
{
//var bname= document.getElementById("txtName").value;
	
	//confirm ("Inser ?");
		var update=req;
		var BCode =	document.getElementById("txtBankCode").value;
		var BName=	document.getElementById("txtName").value;
		var SCode=  document.getElementById("txtSwift").value;
		var ADD1=	document.getElementById("txtAddress1").value;
		var ADD2=	document.getElementById("txtAddress2").value;
		var COUNTRY=	document.getElementById("txtCountry").value;
		var PHONE=	document.getElementById("txtPhone").value;
		var FAX=	document.getElementById("txtFax").value;
		var MAIL=	document.getElementById("txtEMail").value;
		var CONTACTPERSON=	document.getElementById("txtContactPerson").value;
		var REFNO=	document.getElementById("txtRefNo").value;
		var ACCNAME=	document.getElementById("txtAccName").value;
		var REMARKS=	document.getElementById("txtRemarks").value;
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=function(){
		if(xmlHttp[0].readyState == 4){
				alert(xmlHttp[0].responseText);
				setTimeout("location.reload(true);",100);				
		}
		
		}		
		
		
		xmlHttp[0].open("GET",'insert.php?BNAME='+URLEncode(BName)+ '&REQUEST=' + update +'&BCODE='+URLEncode(BCode) + '&COUNTRY=' +URLEncode(COUNTRY)+ '&SCODE=' +URLEncode(SCode) + '&ADD1=' + URLEncode(ADD1) + '&ADD2=' +URLEncode(ADD2) +  '&PHONE=' +PHONE+ '&FAX='+FAX+ '&MAIL='+URLEncode(MAIL)+ '&CONTACTPERSON=' +URLEncode(CONTACTPERSON)+ '&REFNO=' +URLEncode(REFNO)+ '&ACCNAME=' +URLEncode(ACCNAME)+ '&REMARKS='+URLEncode(REMARKS), true);
		xmlHttp[0].send(null);	
			
	
}


function validatebd()
{
		var BCode =	document.getElementById("txtBankCode").value;
		var BName=	document.getElementById("txtName").value;
		
		createNewXMLHttpRequest(0);
		xmlHttp[0].onreadystatechange=checkAvailability;
		xmlHttp[0].open("GET",'banksMiddle.php?request=checkdb&bankCode=' + BCode + '&bankname=' + BName  ,true);
		xmlHttp[0].send(null);
}

function checkAvailability()
{
	if(xmlHttp[0].readyState == 4) 
   {
        if(xmlHttp[0].status == 200) 
        {
				    
				    //alert(xmlHttp[0].responseText)    		
        		var check=xmlHttp[0].responseXML.getElementsByTagName("Result")[0].childNodes[0].nodeValue;
        		if (check=="True")	
        		{  	      		       	
					var ans=confirm("Data already exist, do you want to update?  ");        		       	
        		 	if(ans)
					{		var req="update";
							doInsert(req);						
					}								
								        		       	
        		}
        		else
        		{       
        			var req="insert";		
					doInsert(req);        		
        		
        		      	
        		}	 
        		
        		
        }
   }  
}





function saveData()
{
	if(validateForm())
	{
	if(validatebankcode(document.getElementById("txtBankCode").value))	
	{	
		var str=document.getElementById("txtEMail").value;
		if(str!=""){
			if (echeck(str)){	
				validatebd();
				}
			
			else{
				document.getElementById("txtEMail").focus;
				}
		}
		else
		validatebd();
	}
	else
	alert("Bankcode should be like 0000000.00000");
	}
}

function validateForm()
{
	if(document.getElementById("txtBankCode").value=="" )
	{
		alert("Please enter the bankcode.");
		document.getElementById("txtBankCode").focus();
		return false;
	}
	if(document.getElementById("txtName").value=="" ){
		alert("Please enter the bank name. ");
		document.getElementById("txtName").focus();
		return false;
	}
	if(document.getElementById("txtSwift").value=="" )
	{
		alert("Please enter the Swift Code.");
		document.getElementById("txtSwift").focus();
		return false;
	}
	
	/*if(document.getElementById("txtAddress1").value=="" ){
		alert("Please enter the address.");
		document.getElementById("txtAddress1").focus();
		return false;
	}
	if(document.getElementById("txtAddress2").value=="" ){
		alert("Please enter the city.");
		document.getElementById("txtAddress2").focus();
		return false;
	}
	if(document.getElementById("txtCountry").value=="" ){
		alert("Please enter the country.");
		document.getElementById("txtCountry").focus();
		return false;
	}
	if(document.getElementById("txtPhone").value=="" ){
		alert("Please enter a phone umber.");BName
		document.getElementById("txtPhone").focus();
		return false;
	}
	if(document.getElementById("txtFax").value=="" ){
		alert("Please enter fax number.");
		document.getElementById("txtFax").focus();
		return false;
	}
	
	if(document.getElementById("txtEMail").value=="" ){
		alert("Please enter a valid E-mail address.");
		document.getElementById("txtEMail").focus();
		
		
			return false;
	}
	
	if(document.getElementById("txtRefNo").value=="" ){
		alert("Please enter the RefNo.");
		document.getElementById("txtRefNo").focus();
		return false;
	}	

	if(document.getElementById("txtContactPerson").value=="" ){
		alert("Please enter the contact person.");
		document.getElementById("txtContactPerson").focus();
		return false;
	}
	
	if(document.getElementById("txtRemarks").value=="" ){
		alert("Please enter the remarks.");
		document.getElementById("txtRemarks").focus();
		return false;
	}*/
	else{
		
	//alert("true");
			return true;
	}
	}
	
	
	function Clear()
	{	
	
	
	document.getElementById("txtBankCode").value="";
	document.getElementById("txtName").value="";
	document.getElementById("txtAddress1").value="";
	document.getElementById("txtAddress2").value="";
	document.getElementById("txtCountry").value="";
	document.getElementById("txtPhone").value="";
	document.getElementById("txtFax").value="";
	document.getElementById("txtContactPerson").value="";
	document.getElementById("txtRefNo").value="";
	document.getElementById("txtRemarks").value="";
	document.getElementById("txtEMail").value="";
	document.getElementById("cboBankName").value="";
	}
	
	
	
	

	function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Incorrect Email Address")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Incorrect Email Address")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Incorrect Email Address")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Incorrect Email Address")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Incorrect Email Address")
		    return false
		 }
if(xmlHttp[0].readyState == 4)
		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Incorrect Email Address")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Incorrect Email Address")
		    return false
		 }

 		 return true					
	}
	
	
	function deletedata()
	{ 
	
		if(document.getElementById("txtBankCode").value!="")
		{
			
			var bname=	document.getElementById("txtName").value;
			var delete1 = confirm("Are you sure you want to  delete '" +bname+ "' ?");
 
			if (delete1)		
			{
				var request="delete";
				var BCode=	document.getElementById("txtBankCode").value;
				xmlHttp[0].onreadystatechange=function()
				{
					if(xmlHttp[0].readyState == 4)
					{
						setTimeout("location.reload(true);",100);			
						alert(xmlHttp[0].responseText);	
				
					}		
				}
			
		
	
			xmlHttp[0].open("GET",'insert.php?REQUEST='  + request + '&BCODE=' + BCode , true);
			xmlHttp[0].send(null);	
			}
		}
		else
		{
			alert("Please select a Bank Name.");
		}
			
}

function validatebankcode(bnkcode)
{
	
	//var objRegExp = "^\d{4}.\d{3}$";
   	//return objRegExp.test(checkpc);
	var objRegExp  =/^\d{4}\.\d{3}$/;

  //check for valid us phone with or without space between
  //area code
  return objRegExp.test(checkpc);
	
}

function validatebankcode(checkpc)
{
	//var objRegExp = "^\d{4}.\d{3}$";
   	//return objRegExp.test(checkpc);
	var objRegExp  =/^\d{1,10}\.\d{1,10}$/;

  //check for valid us phone with or without space between
  //area code
  return objRegExp.test(checkpc);
}