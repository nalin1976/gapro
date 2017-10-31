var xmlHttp;

//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(trim(document.getElementById('txtDepCode').value)=="")
	{
		alert("Please enter \"Department Code\".");
		document.getElementById('txtDepCode').focus();
		return false;
	}
	else if(trim(document.getElementById('txtDepartment').value)=="")
	{
	  alert("Please enter \"Department Name\".");
	  document.getElementById('txtDepartment').focus();
	  return false;
	}
	else if(isNumeric(trim(document.getElementById('txtDepartment').value)))
	{
		alert("\"Department Name\" must be an \"Alphanumeric\" value.");
		document.getElementById('txtDepartment').focus();
		return;
	}
	else if(document.getElementById('cmbCompany').value=="")
	{
	  alert("Please select \"Company Name\".");
	  document.getElementById('cmbCompany').focus();
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
		
		if(document.getElementById("cbodepartment").value=="")
		strCommand="New";
		
		
		var url="Button.php";
		url=url+"?q="+strCommand;
		
		if(strCommand=="Save")
		{ 
			url=url+"&cbodepartment="+document.getElementById("cbodepartment").value;
			url=url+"&strDepartmentCode="+URLEncode(document.getElementById("txtDepCode").value);
			url=url+"&strDepartment="+URLEncode(document.getElementById("txtDepartment").value);
			url=url+"&strRemarks="+URLEncode(document.getElementById("txtRemarks").value);	
			url=url+"&intCompany="+document.getElementById("cmbCompany").value;				
		}
		else
		{
			url=url+"&strDepartmentCode="+URLEncode(document.getElementById("txtDepCode").value);
			url=url+"&strDepartment="+URLEncode(document.getElementById("txtDepartment").value);
			url=url+"&strRemarks="+URLEncode(document.getElementById("txtRemarks").value);	
			url=url+"&intCompany="+document.getElementById("cmbCompany").value;	
		}
		
		if(document.getElementById("chkActive").checked==true)
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
		ClearForm();
	}
}

function ClearDepForm()
{   	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ClearDepForm1;
	xmlHttp.open("GET", 'Button.php?q=loadDeps', true);
	xmlHttp.send(null);  	
}
	
function ClearDepForm1()
{	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("cbodepartment").innerHTML  = xmlHttp.responseText;
			document.getElementById('txtDepCode').focus();
		}
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

	if(strCommand=="Delete")	
		url=url+"&cbodepartment="+document.getElementById("cbodepartment").value;	

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}

function ClearForm()
{	
	document.frmDepartment.reset();
	loadCombo('SELECT intDepID,strDepartment FROM department order by strDepartment ASC','cbodepartment');
	document.getElementById('txtDepCode').focus();
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

function getDepartmentDetails()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 	
	var Departmentload = document.getElementById('cbodepartment').value;
	createXMLHttpRequest();
	xmlHttp.onreadystatechange =  ShowDepartmentDetails;
	xmlHttp.open("GET", 'Departmentmiddle.php?Departmentload=' + Departmentload, true);
	xmlHttp.send(null);	
}

function ShowDepartmentDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById('txtDepCode').disabled=false;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("DepCode");
				if(XMLLoad.length<=0)
				{
					ClearForm();
					return;
				}
					
			document.getElementById('txtDepCode').value = XMLLoad[0].childNodes[0].nodeValue;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("DepartmentName");
			document.getElementById('txtDepartment').value = XMLLoad[0].childNodes[0].nodeValue;
			var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Remarks");
			document.getElementById('txtRemarks').value = XMLLoad[0].childNodes[0].nodeValue;
			var XMLCom = xmlHttp.responseXML.getElementsByTagName("Comid");
			document.getElementById('cmbCompany').value = XMLCom[0].childNodes[0].nodeValue;
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
							
			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("chkActive").checked=true;	
			else
				document.getElementById("chkActive").checked=false;	
			
		   var XMLused = xmlHttp.responseXML.getElementsByTagName("used");	
			if(XMLused[0].childNodes[0].nodeValue == '1')
				document.getElementById('txtDepCode').disabled=true;
			
			if(XMLused[0].childNodes[0].nodeValue == '0')
				document.getElementById('txtDepCode').disabled=false;		
		}
	}
}
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('cbodepartment').value=="")
	{
		alert("Please select Department");
	}
	else
	{
		var DeptName = document.getElementById("cbodepartment").options[document.getElementById('cbodepartment').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ DeptName+" \" ?");
		if (r==true)		
			DeleteData(strCommand);		
	}	
}
	
	
function checkvalue()
{
	if(document.getElementById('txtDepCode').value!="")
	document.getElementById("txtRemarks").focus();
}
	
function checkvalue1()
{
	if(document.getElementById('txtDepartment').value!="")
	document.getElementById("txtRemarks").focus();
}

function loadReport()
{ 
	var Comid         = document.getElementById('cmbCompany').value;
	if(Comid == "")
		Comid = "NA";
	var cbodepartment = document.getElementById('cbodepartment').value;	
	window.open("DepartmentsReport.php?cbodepartment=" + cbodepartment+"&intCompayID="+Comid,'frmDepartment'); 
}

function clearFields()
{
	var arrElements=['currency_txtCurrency','currency_txtTitle','currency_txtRate','currency_txtFraction','currency_txtExRate','currency_cboCurr'];
	for(var i=0;i<arrElements.length;i++)
	{
		document.getElementById(arrElements[i]).value="";
	}
}

function ValidateSave()
{	
	var x_id = document.getElementById("cbodepartment").value;
	var x_name = document.getElementById("txtDepCode").value;	
	var x_find = checkInField('department','strDepartmentCode',x_name,'intDepID',x_id);
	if(x_find)
		{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtDepCode").focus();
		return;
	}
	var x_id = document.getElementById("cbodepartment").value;
	var x_name = document.getElementById("txtDepartment").value;	
	var x_find = checkInField('department','strDepartment',x_name,'intDepID',x_id);
	if(x_find)
	{
		alert("\""+x_name+"\" is already exist.");	
		document.getElementById("txtDepartment").focus();
		return;
	}
return true;	
}