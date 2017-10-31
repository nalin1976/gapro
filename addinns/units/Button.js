var xmlHttp;
var xmlHttp1;
     
//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(document.getElementById('units_txtunit').value.trim()=="")
	{
		alert("Please enter \"Unit\".");	
		document.getElementById('units_txtunit').select();
		return false;
	}
	else if(isNumeric(document.getElementById('units_txtunit').value.trim()))
	{
		alert("Please enter \"alphanumeric\" value.");
		document.getElementById('units_txtunit').select();
		return false;
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
		  
		if(document.getElementById('units_cbounit').value.trim()=="")
			strCommand="New";
		  
		var url="Button.php";
		url=url+"?q="+strCommand;
		
		if(strCommand=="Save")
		{ 
			url=url+"&cboUnit="+document.getElementById("units_cbounit").value;
			url=url+"&strUnit="+URLEncode(document.getElementById("units_txtunit").value.trim());
			url=url+"&strTitle="+URLEncode(document.getElementById("units_txtunit3").value.trim());
			url=url+"&intPcsForUnit="+URLEncode(document.getElementById("units_txtunit2").value);		
		}
		else
		{
			url=url+"&strUnit="+URLEncode(document.getElementById("units_txtunit").value.trim());
			url=url+"&strTitle="+URLEncode(document.getElementById("units_txtunit3").value.trim());
			url=url+"&intPcsForUnit="+URLEncode(document.getElementById("units_txtunit2").value);	
		}
		
		if(document.getElementById("units_chkActive").checked==true)
			var intStatus = 1;	
		else
			var intStatus = 0;
		
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
		clearForm();
	} 
}

function clearForm()
{	
	document.frmUnits.reset();
	loadCombo('SELECT intUnitID,strUnit FROM units order by strUnit','units_cbounit');
	document.getElementById("units_txtunit").focus();
	document.getElementById("units_txtunit").disabled=false;
}
	
function clearFormRes()
{
	if(xmlHttp1.readyState == 4) 
	{
		if(xmlHttp1.status == 200) 
		{
			document.getElementById("units_cbounit").innerHTML  = xmlHttp1.responseText;
			clearFields();
		}
	}
}

function clearFields()
{
	document.frmUnits.reset();
	loadCombo('SELECT intUnitID,strUnit FROM units order by strUnit ','units_cbounit');
	document.getElementById('units_txtunit').focus();
	document.getElementById("units_txtunit").disabled=false;
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

	if(strCommand=="Delete")
		url=url+"&strUnit="+document.getElementById("units_cbounit").value;	

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function ClearForm()
{
	clearFields();
}

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
	if(document.getElementById('units_cbounit').value.trim()=='')
	{
		clearFields();
		return false;
	}   
	var UnitsID = document.getElementById('units_cbounit').value;
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
			document.getElementById('units_txtunit').disabled=false;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("UnitName");
			document.getElementById('units_txtunit').value = XMLLoad[0].childNodes[0].nodeValue;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Title");
			document.getElementById('units_txtunit3').value = XMLLoad[0].childNodes[0].nodeValue;	
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("PcsForUnit");
			document.getElementById('units_txtunit2').value = XMLLoad[0].childNodes[0].nodeValue;	
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("units_chkActive").checked=true;	
			else
				document.getElementById("units_chkActive").checked=false;	
			
		   	var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
		   	if(XMLused[0].childNodes[0].nodeValue == '1')
		  	 	document.getElementById('units_txtunit').disabled=true;
		   
		   	if(XMLused[0].childNodes[0].nodeValue == '0')
				document.getElementById('units_txtunit').disabled=false;		   
		}
	}
}
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('units_cbounit').value=="")
	{
		alert("Please select Unit");
	}
	else
	{
		var unitName = document.getElementById("units_cbounit").options[document.getElementById('units_cbounit').selectedIndex].text;
		var r=confirm("Are you sure you want to delete \""+ unitName+ "\"?");
		if (r==true)		
			DeleteData(strCommand);
	}
}
	
function checkvalue()
{
	if(document.getElementById('units_txtunit').value!="")
	document.getElementById("units_txtunit3").focus();
}	

function loadReport()
{ 
	window.open("UnitsReport.php?cboSeasons"); 
}
   
function ValidateSave()
{	
	var x_id = document.getElementById("units_cbounit").value;
	var x_name = document.getElementById("units_txtunit").value;
	
	var x_find = checkInField('units','strUnit',x_name,'intUnitID',x_id);
	if(x_find)
	{
		alert("\""+x_name+ "\" is already exist.");	
		document.getElementById("units_txtunit").focus();
		return;
	}	
	return true;
}