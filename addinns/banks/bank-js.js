var xmlHttp;
var xmlHttpreq = [];
var pub_bankPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_urlBank = pub_bankPath+"/addinns/banks/";

function clearformbank()
{
	document.frmBanks.reset();
	document.getElementById('bank_txtBankCode').focus();
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
//----------Save Bank details------------------------------------------------------
function bankSave(strCommand)
	{
		if(document.getElementById('bank_txtBankCode').value.trim() =="" )
		{
			alert("Please enter a  \"Bank Code\".");	
			document.getElementById('bank_txtBankCode').select();
			return false;
		}
		else if(document.getElementById('bank_txtBankName').value.trim() =="" )
		{	alert("Please enter a  \"Bank Name\".");	
			document.getElementById('bank_txtBankName').select();			
			return false;
		}
		else if(isNumeric(trim(document.getElementById('bank_txtBankName').value)))
		{
			alert("Bank Name must be an \"Alphanumeric\" value.");
			document.getElementById('bank_txtBankName').select();
			return false;
		}
		var x_id = document.getElementById("bank_cboBank").value
		var x_name = document.getElementById("bank_txtBankCode").value
	
		var x_find = checkInField('bank','strBankCode',x_name,'intBankId',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("bank_txtBankCode").select();
			return false;
		}	
		var id = document.getElementById("bank_cboBank").value
		var name = document.getElementById("bank_txtBankName").value
	
		var x_find = checkInField('bank','strBankName',name,'intBankId',id);
		if(x_find)
		{
			alert("\""+name+"\" is already exist.");	
			document.getElementById("bank_txtBankName").select();
			return false;
		}	
		
		if(document.getElementById('bank_cboBank').value=="" )		
			strCommand="New";
		
		xmlHttp=GetXmlHttpObject();
			
		if (xmlHttp==null)
		  {
		  alert ("Browser does not support HTTP Request");
		  return;
		  } 
		  		
				var url=pub_urlBank+"banks-db.php";
				url=url+"?q="+strCommand;
		
		        url=url+"&cboBankID="+URLEncode(document.getElementById("bank_cboBank").value);
				url=url+"&strBankCode="+URLEncode(document.getElementById("bank_txtBankCode").value);
				url=url+"&strName="+URLEncode(document.getElementById("bank_txtBankName").value.trim());
				
				if(document.getElementById("bank_chkActive").checked==true)
				{
					var intStatus = 1;	
				}
				else
				{
					var intStatus = 0;
				}
				
				url=url+"&intStatus="+intStatus; 
		
		
				xmlHttp.onreadystatechange=stateChanged1;
				xmlHttp.open("GET",url,true);
				xmlHttp.send(null);
}

function stateChanged1() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
        { 
	     	alert(xmlHttp.responseText);
			 loadCombo('SELECT intBankId, strBankName FROM bank WHERE intStatus<>10 order by strBankName ASC','bank_cboBank');
		     document.frmBanks.reset();
	    }
	}
}

function getBankDetails()
{   
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('bank_cboBank').value.trim()=='')
	{
		document.frmBanks.reset();
		return false;
	} 
	
	var bankID = document.getElementById('bank_cboBank').value;
	xmlHttp.onreadystatechange = ShowBankDetails;
	xmlHttp.open("GET", pub_urlBank+'bankMiddle.php?bankID=' + bankID, true);
	xmlHttp.send(null); 
}

function ShowBankDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{		
			var XMLBnkCode = xmlHttp.responseXML.getElementsByTagName("BankCode");
			document.getElementById('bank_txtBankCode').value = XMLBnkCode[0].childNodes[0].nodeValue;	
			var XMLBnkName = xmlHttp.responseXML.getElementsByTagName("BankName");
			document.getElementById('bank_txtBankName').value = XMLBnkName[0].childNodes[0].nodeValue;	
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");
					
			if(XMLStatus[0].childNodes[0].nodeValue==1)
				document.getElementById("bank_chkActive").checked=true;	
			else
				document.getElementById("bank_chkActive").checked=false;	
			
			var XMLused = xmlHttp.responseXML.getElementsByTagName("Used");	
			if(XMLused[0].childNodes[0].nodeValue == '1')
				document.getElementById('bank_txtBankCode').disabled=true;
			
			if(XMLused[0].childNodes[0].nodeValue == '0')
				document.getElementById('bank_txtBankCode').disabled=false;
		}
	}
}

function ConfirmDeleteBnk(strCommand)
{
	if(document.getElementById('bank_cboBank').value=="")
	{
		alert("Please select \"Bank\".");
		document.getElementById('bank_cboBank').focus();
	}
	else
	{
		var bnkName = document.getElementById("bank_cboBank").options[document.getElementById('bank_cboBank').selectedIndex].text;
		var r=confirm("Are you sure you want to delete  \""+ bnkName+" \" ?");
		if (r==true)		
			DeleteBnk(strCommand);
	}
}

function DeleteBnk(strCommand)
{		
xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
  
	var url=pub_urlBank+"banks-db.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete")
		url=url+"&cboBankID="+document.getElementById("bank_cboBank").value;		

	xmlHttp.onreadystatechange=stateChanged2;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stateChanged2() 
{ 
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200)
 
        { 
	     	alert(xmlHttp.responseText);
			 loadCombo('SELECT intBankId, strBankName FROM bank WHERE intStatus<>10 order by strBankName ASC','bank_cboBank');
		     document.frmBanks.reset();
	    }
	}
}

function loadBnkReport()
{ 
	var bankID = document.getElementById('bank_cboBank').value;
	window.open(pub_urlBank+"bankReport.php?bankID=" + bankID,'frmBanks'); 
}