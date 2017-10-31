
var xmlHttp;


//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
//if (isValidData())
           if(document.getElementById('txtCurrency').value=="")
		{
			alert("Please Enter Currency");	
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
		  
		 if(document.getElementById('cboCurr').value=="")
		 strCommand="New";
		
		 
		var url="Button.php";
		url=url+"?q="+strCommand;
			
				if(strCommand=="Save"){ 
					
					url=url+"&strCurrency="+document.getElementById("txtCurrency").value;
					url=url+"&strTitle="+document.getElementById("txtTitle").value;
					url=url+"&dblRate="+document.getElementById("txtRate").value;	
					url=url+"&strFraction="+document.getElementById("txtFraction").value;
					setTimeout("location.reload(true);",1000);
				}
				else
				{   
					url=url+"&strCurrency="+document.getElementById("txtCurrency").value;
					url=url+"&strTitle="+document.getElementById("txtTitle").value;
					url=url+"&dblRate="+document.getElementById("txtRate").value;
					url=url+"&strFraction="+document.getElementById("txtFraction").value;
					
					}


	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

 }
} 

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
		url=url+"&strCurrency="+document.getElementById("txtCurrency").value;
		setTimeout("location.reload(true);",1000);
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	ClearForm();
	
	
}
	
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	
	function ClearForm()
	{	
/*		document.getElementById("txtHint").innerHTML="";
		document.getElementById("txtCurrency").value = "";
		document.getElementById("txtTitle").value = "";
		document.getElementById("txtRate").value = "";*/
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

function getCurrencyDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cboCurr').value=='')
	{
		setTimeout("location.reload(true);",0);
	}
	
	
		var CurrencyID = document.getElementById('cboCurr').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange =  ShowCurrencyDetails;
		xmlHttp.open("GET", 'Currencymiddle.php?CurrencyID=' + CurrencyID, true);
		xmlHttp.send(null); 
		
	}

function ShowCurrencyDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			    var XMLLoad = xmlHttp.responseXML.getElementsByTagName("CurrencyName");
				document.getElementById('txtCurrency').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Title");
				document.getElementById('txtTitle').value = XMLLoad[0].childNodes[0].nodeValue;	
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Rate");
				document.getElementById('txtRate').value = XMLLoad[0].childNodes[0].nodeValue;	
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("FractionalUnit");
				document.getElementById('txtFraction').value = XMLLoad[0].childNodes[0].nodeValue;					
				
			}
		}
	}
	
function ConfirmDelete(strCommand)
	{
		if(document.getElementById('txtCurrency').value=="")
		{
			alert("Please Enter Currency");
		}
		else
		{
			var r=confirm("Are You Sure Delete?");
			if (r==true)		
				DeleteData(strCommand);
				
		}
		
			
	}
	
	
	function isValidData()
	{
		if(document.getElementById('txtCurrency').value=="")
		{
			alert("Please Enter Currency");	
			return false;
		}

		else
		return true;
	}
	
	