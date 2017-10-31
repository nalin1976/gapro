var xmlHttp =[]; 
var xmlHttp1=[];
function createXMLHttpRequest() 
{
	try
	 {	 
	 xmlHttp=new XMLHttpRequest();
	 }
	catch(e)
	 {  
	 try
		  {
		  	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch(e)
		  {
		  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	}
}

function createXMLHttpRequest1(index) 
{
	try
	 {
	  xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch(e)
	 {
		 
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch(e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
function butCommand(strCommand)
{   	  
	if(trim(document.getElementById('txtGarmentName').value)=="")
	{
		alert("Please enter \"Garment Name\".");
		document.getElementById('txtGarmentName').select();
		return ;
	}
	else if(trim(document.getElementById('cboDescrtiption').value)=="")
	{
		alert("Please enter \"Description\".");
		document.getElementById('cboDescrtiption').select();
		return false;
	}	
	else if(isNumeric(trim(document.getElementById('txtGarmentName').value)))
	{
		alert("Name must be an \"Alphanumeric\" value.");
		document.getElementById('txtGarmentName').select();
		return;
	}
		else if(!ValidateSave())
	{
		return;
	}
	else
	{		
		xmlHttp=GetXmlHttpObject(); 
		
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request");
			return;
		} 
		
		if(document.getElementById("cboSearch").value=="")
			strCommand="New";
			
		var url="garment.php";
		url=url+"?q="+strCommand; 
		
		if(strCommand=="Save")
		{
			url=url+"&cboSearch="+document.getElementById("cboSearch").value;			
			url=url+"&cboDescrtiption="+document.getElementById("cboDescrtiption").value;
			url=url+"&txtGarmentName="+document.getElementById("txtGarmentName").value;
		}
		else
		{
			url=url+"&cboDescrtiption="+document.getElementById("cboDescrtiption").value;
			url=url+"&txtGarmentName="+document.getElementById("txtGarmentName").value;
		}
		if(document.getElementById("chkActive").checked==true)
		{	
			var intStatus = 1;	
		}
		else
		{
			var intStatus = 0;
		}
		
		url=url+"&intStatus="+intStatus;		
		xmlHttp.onreadystatechange=stateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
} 

function stateChanged() 
{ 	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		alert(xmlHttp.responseText);	  
		ClearForm();	
	}
}

function GetXmlHttpObject()  
{
var xmlHttp=null;
	try
	{
		xmlHttp=new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
return xmlHttp;
}
 
function DeleteData(strCommand)
{
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
	var url="garment.php";
	url=url+"?q="+strCommand;
	if(strCommand=="Delete")
	{ 		
	url=url+"&cboSearch="+document.getElementById("cboSearch").value;
	}   
	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 
	
function garmenttypeForm1()
{	
 if(xmlHttp.readyState == 4) 
   { 
 if(xmlHttp.status == 200) 
	 {
     document.getElementById("cboSearch").innerHTML=xmlHttp.responseText;
	 document.getElementById('cboDescrtiption').focus();
	  }
   }		 
}

function ClearForm()
{	
	document.frmGarmenttype.reset();
	loadCombo('SELECT intGamtID,strGarmentName FROM was_garmenttype order by strGarmentName ASC','cboSearch');
	document.getElementById('txtGarmentName').select();
 }
	
function getgarmenttypeDetails()
{ 
    xmlHttp=GetXmlHttpObject();
	if(xmlHttp==null)
	  {
	  alert("Browser does not support HTTP Request");
	  return;
	 } 	
	var garmenttypeload=document.getElementById('cboSearch').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange=LoadDetailsRequest;
	xmlHttp.open("GET",'garmenttypemiddle.php?garmenttypeload='+garmenttypeload,true);
	xmlHttp.send(null); 		
}

function ConfirmDelete(strCommand)
{
	if(document.getElementById('cboSearch').value=="")
	{
		alert("Please select \"Garment Type\".");
		document.getElementById('cboSearch').focus();
	}
	else
	{
		var Search =document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
		var r=confirm("Are you sure you want to delete \""+Search+"\" ?");
	if(r==true)		
		DeleteData(strCommand);
	}
}	
		
function checkvalue()
{
	if(document.getElementById('cboDescrtiption').value!="")
	document.getElementById("txtGarmentName").focus();
}
			
function CleargarmenttypeForm()
{   	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  } 		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange=CleargarmenttypeForm;
	 	xmlHttp.open("GET",'garment.php?q=+obj', true);
		xmlHttp.send(null);  	
}	 
	 
function loadDetails(obj)
{	
	if(obj.value.trim()=="")
	{
	 	document.frmGarmenttype.reset();
		return;
	}
	
	 var url="garmenttypemiddle.php?req=loadgarment&data="+obj.value;
     createXMLHttpRequest1(0);
	 xmlHttp1[0].onreadystatechange=loadRequest;
	 xmlHttp1[0].index=obj;
	 xmlHttp1[0].open("GET",url,true);
	 xmlHttp1[0].send(null);	
}
	  
function loadRequest()
{
	if(xmlHttp1[0].readyState==4 && xmlHttp1[0].status==200)
	{	
		var XMLDescrtiption=xmlHttp1[0].responseXML.getElementsByTagName("Descrtiption");
		var XMLGarmentName=xmlHttp1[0].responseXML.getElementsByTagName('GarmentName');
		var XMLStatus=xmlHttp1[0].responseXML.getElementsByTagName("Status");			
		
		document.getElementById('cboDescrtiption').value=XMLDescrtiption[0].childNodes[0].nodeValue;
		document.getElementById('txtGarmentName').value=XMLGarmentName[0].childNodes[0].nodeValue;	
		
		if(XMLStatus[0].childNodes[0].nodeValue==1)
			document.getElementById("chkActive").checked=true;	
		else
			document.getElementById("chkActive").checked=false;	
	}
}

function ValidateInterface()
{
	    if(trim(document.getElementById('cboDescrtiption').value)=="")
	    {
		alert("Please select \"Descrtiption\".");
		document.getElementById('cboDescrtiption').focus();
		return false;		
	    }
	    return true;
}

function ViewGarmenttypereport()
{ 
	    var cboSearch=document.getElementById('cboSearch').value;
		window.open("garmenttypereport.php?",'frmwas_garmenttype'); 
}

function ClearFormc()
{   	
 	    document.getElementById("cboSearch").value = "";
		document.getElementById("cboDescrtiption").value = "";	
}

function ValidateSave()
{	
var x_id=document.getElementById("cboSearch").value;
var x_name=document.getElementById("txtGarmentName").value;		
var x_find=checkInField('was_garmenttype','strGarmentName',x_name,'intGamtID',x_id);
	
	if(x_find)
	{
		alert("\""+x_name +"\" is already exist.");	
		document.getElementById("txtGarmentName").select();
		return false;
	}
return true;	
}