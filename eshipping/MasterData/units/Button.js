var xmlHttp;


//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
     	if(document.getElementById('txtunit').value=="")
		{
			alert("Please Enter Unit");	
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
		  
		  if(document.getElementById('cbounit').value=="")
		  strCommand="New";
		  
		var url="Button.php";
		url=url+"?q="+strCommand;
		
			if(strCommand=="Save")
			{ 
				url=url+"&strUnit="+document.getElementById("txtunit").value;
				url=url+"&strTitle="+document.getElementById("txtunit3").value;
				url=url+"&intPcsForUnit="+document.getElementById("txtunit2").value;		
				setTimeout("location.reload(true);",1000);
			}
			else
			{
				url=url+"&strUnit="+document.getElementById("txtunit").value;
				url=url+"&strTitle="+document.getElementById("txtunit3").value;
				url=url+"&intPcsForUnit="+document.getElementById("txtunit2").value;	
				
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
		url=url+"&strUnit="+document.getElementById("txtunit").value;
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
		/*document.getElementById("txtHint").innerHTML="";
		document.getElementById("txtunit").value = "";
		document.getElementById("txtunit3").value = "";
		document.getElementById("txtunit2").value = "";
*/
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

function getUnitsDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cbounit').value=='')
	{
		setTimeout("location.reload(true);",0);
	}   
	
	
		var UnitsID = document.getElementById('cbounit').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange =  ShowUnitDetails;
		xmlHttp.open("GET", 'Unitsmiddle.php?UnitsID=' + UnitsID, true);
		xmlHttp.send(null); 
		
	}

function ShowUnitDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			    var XMLLoad = xmlHttp.responseXML.getElementsByTagName("UnitName");
				document.getElementById('txtunit').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Title");
				document.getElementById('txtunit3').value = XMLLoad[0].childNodes[0].nodeValue;	
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("PcsForUnit");
				document.getElementById('txtunit2').value = XMLLoad[0].childNodes[0].nodeValue;	
				
				
			}
		}
	}
	
function ConfirmDelete(strCommand)
	{
		if(document.getElementById('txtunit').value=="")
		{
			alert("Please Enter Unit");
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
	if(document.getElementById('txtunit').value!="")
	document.getElementById("txtunit3").focus();
	}	