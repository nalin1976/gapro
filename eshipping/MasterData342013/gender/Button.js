
var xmlHttp;


//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
//if (isValidData())
//{
	
	             if(document.getElementById('txtGenderCode').value=="")
				 {
					 alert("Please Enter Gender !");
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
				  
				 
            if(document.getElementById("cboGenderList").value=="")
			{
				strCommand="New";
			
			}
		
			
			var url="Button.php";
			url=url+"?q="+strCommand;
			
					url=url+"&strGenderCode="+document.getElementById("txtGenderCode").value;	
					url=url+"&id="+document.getElementById("cboGenderList").value;	
                 
				

	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

//}
} 
}

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 {
	 	//alert("sdsd"); 
 alert(xmlHttp.responseText);
 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
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
		url=url+"&strGenderCode="+document.getElementById("txtGenderCode").value;
		url=url+"&id="+document.getElementById("cboGenderList").value;	
		//setTimeout("location.reload(true);",100);
		
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//ClearForm();
	
	
}
	
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	
	function ClearForm()
	{	
		//document.getElementById("txtHint").innerHTML="";
//		document.getElementById("txtCountryCode").value = "";
//		document.getElementById("txtCountry").value = "";
       setTimeout("location.reload(true);",100);
		
	}
	
		function backtopage()
	{
		window.location.href="main.php";
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

function getCountryDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboGenderList').value=="")
	{

			 setTimeout("location.reload(true);",100);
			 //alert("alert");
	}
	
	
		var GenderID = document.getElementById('cboGenderList').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowCountryDetails;
		xmlHttp.open("GET", 'gendermiddle.php?GenderID='+GenderID, true);
		xmlHttp.send(null);  
	
	}

function ShowCountryDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			    var XMLLoad = xmlHttp.responseXML.getElementsByTagName("GenderName");
				document.getElementById('txtGenderCode').value = XMLLoad[0].childNodes[0].nodeValue;
				
			}
		}
	}
	
function ConfirmDelete(strCommand)
	{
		if(document.getElementById('cboGenderList').value=="")
		{
			alert("Please select a Gender !");
		}
		else
		{
			var r=confirm("Are You Sure Delete?");
			if (r==true)		
				DeleteData(strCommand);
				
		}
		
			
	}
	
	function checkvalue()
	{
	if(document.getElementById('txtGenderCode').value="")
	{
		
	return false;
	}
	
	
//	function isValidData()
//	{
//		if(document.getElementById('txtCountryCode').value=="")
//		{
//			alert("Please Enter CountryCode");	
//			return false;
//		}
//
	else
	return true;
	}
	
	