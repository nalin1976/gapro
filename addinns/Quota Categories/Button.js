
var xmlHttp;


//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	
//	isValidData();	
if(document.getElementById("cboquota").value=="" & document.getElementById("txtid").value=="")
		{
			alert("Please Enter Category ID");	
			document.getElementById("txtid").focus();
			return false;
		}
		
		else
		{
			
		xmlHttp=GetXmlHttpObject();
		
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
  } 
  		
		if(document.getElementById("cboquota").value=="")
		strCommand="New";
        var url="Button.php";
        url=url+"?q="+strCommand;

	if(strCommand=="Save"){ 
	
		
		url=url+"&strCategoryID="+document.getElementById("txtid").value;
		url=url+"&strDescription="+document.getElementById("txtdescription").value;
		url=url+"&strUnit="+document.getElementById("txtunit").value;
		url=url+"&dblPrice="+document.getElementById("txtprice").value;
		url=url+"&intStatus="+document.getElementById("cboquota").value;
	    //setTimeout("location.reload(true);",1000);
	}
	else
	{
		url=url+"&strCategoryID="+document.getElementById("txtid").value;
		url=url+"&strDescription="+document.getElementById("txtdescription").value;
		url=url+"&strUnit="+document.getElementById("txtunit").value;
		url=url+"&dblPrice="+document.getElementById("txtprice").value;
		//url=url+"&intStatus="+document.getElementById("cboquota").value;
		
	}



	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}

}


//New
//function Newdata(strCommand)
//{
//		
//xmlHttp=GetXmlHttpObject();
//
//if (xmlHttp==null)
//  {
//  alert ("Browser does not support HTTP Request");
//  return;
//  } 
//  
//	var url="Button.php";
//	url=url+"?q="+strCommand;
//
//	if(strCommand=="New"){ 		
//		url=url+"&strCategoryID="+document.getElementById("txtid").value;
//		url=url+"&strDescription="+document.getElementById("txtdescription").value;
//		url=url+"&strUnit="+document.getElementById("txtunit").value;
//		url=url+"&dblPrice="+document.getElementById("txtprice").value;
//		
//		
//	//setTimeout("location.reload(true);",1000);
//	}
//
//	xmlHttp.onreadystatechange=stateChanged;	
//	xmlHttp.open("GET",url,true);
//	xmlHttp.send(null);
//	
//	
//	
//}


function stateChanged() 
{ 	
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 setTimeout("location.reload(true);",1000);
 } 
}



function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
	
//delete data
function DeleteData(strCommand)
{
		
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
	var url="Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&strCategoryID="+document.getElementById("txtid").value;
		
	setTimeout("location.reload(true);",1000);
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	ClearForm();
	
	
}
	
	//function backtopage()
//	{
//		window.location.href="main.php";
//	}
	
	function ClearForm()
	{	
		/*document.getElementById("txtHint").innerHTML="";
		document.getElementById("txtDepCode").value = "";
		document.getElementById("txtDepartment").value = "";
		document.getElementById("txtRemarks").value = "";*/
setTimeout("location.reload(true);",1000);
		
	}

//load data
function createXMLHttpRequest() 
	{
		if (window.ActiveXObject) 
		{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if (window.XMLHttpRequest) 
		{
			xmlHttp = new XMLHttpRequest();
		}
	}

function getquotaDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboquota').value=='')
	{
		setTimeout("location.reload(true);",0);
	}
	
	
		var QuotaID = document.getElementById('cboquota').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowquotaDetails;
		xmlHttp.open("GET", 'quotamiddle.php?QuotaID=' + QuotaID, true);
		xmlHttp.send(null); 
		
		
	}


function ShowquotaDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			    var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CategoryID");
				document.getElementById('txtid').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Description");
				document.getElementById('txtdescription').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Unit");
				document.getElementById('txtunit').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Price");
				document.getElementById('txtprice').value = XMLLoad[0].childNodes[0].nodeValue;	
				
				
			}
		}
	}
	
function ConfirmDelete(strCommand)
	{
		if(document.getElementById('txtid').value=="")
		{
			alert("Please Enter Category ID");
		}
		else
		{
			var r=confirm("Are You Sure Delete?");
			if (r==true)		
				DeleteData(strCommand);
				
		}
		
			
	}
	
	
//	function isValidData()
//	{
//		if(document.getElementById("cboquota").value=="" & document.getElementById("txtid").value=="")
//		{
//			alert("Please Enter Category ID");	
//			document.getElementById("txtid").focus();
//			return false;
//		}
//		else
//		{
//			return true;
//		}
//		
//	}
	/*	
		if(document.getElementById('txtid').value=="")
		{
			alert("Please Enter Category ID");	
			return false;
		}
         
		 else if(document.getElementById('txtdescription').value=="")
        {
			alert("Please Enter Description");
			
			}
			
		 else if(document.getElementById('txtunit').value=="")
		 {
			 alert("Please Enter Unit");
			 
			 }
			 
			 
		 else if(document.getElementById('txtprice').value=="")
		 {
			 alert("Please Enter Price");
			 
			 }
			 
		else
		return true;
	}*/
//document.getElementById("cboCustomer").value!=""	
function A()
{
	if(document.getElementById('txtunit').value!="")
	document.getElementById("txtdescription").focus();
	}