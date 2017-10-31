var xmlHttp;
var pub_itemPerchasePath 	= document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_urlItemPerchase 	= pub_itemPerchasePath+"/addinns/itempurchase/";

//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	var Type="";
	if(trim(document.getElementById('origin_txtorigin').value)=="")
	{
		alert("Please enter Origin Type.");	
		document.getElementById('origin_txtorigin').focus();
		return false;
	}
	else if(isNumeric(trim(document.getElementById('origin_txtorigin').value)))
	{
		alert("Origin must be an Alfanumeric value.");
		document.getElementById('origin_txtorigin').focus();
		return false;
	}	
	else if(document.getElementById("rdolocal").checked==false & document.getElementById("rdoforign").checked==false)
	{
		alert("Please Select Local or Foreign");
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
  		
		if(document.getElementById("origin_cboorigin").value=="")
			strCommand="New";
		
		var url=pub_urlItemPerchase+"/Button.php";
		url=url+"?q="+strCommand;

		if(strCommand=="Save")
		{
			url=url+"&intOriginNo="+document.getElementById("origin_cboorigin").value;
			url=url+"&strOriginType="+URLEncode(document.getElementById("origin_txtorigin").value);
			url=url+"&OriginDescription="+URLEncode(document.getElementById("txtDescription").value);
			
			if(document.getElementById("chkActive").checked==true)
				var intStatus = 1;	
			else
				var intStatus = 0;
		
			url=url+"&intStatus="+intStatus; 
			
			if(document.getElementById("rdolocal").checked==true)
				Type=1;
			else
				Type=0;			
			url=url+"&Type="+Type;			
			
		}
		else
		{
			url=url+"&intOriginNo="+document.getElementById("origin_cboorigin").value;
			url=url+"&strOriginType="+URLEncode(document.getElementById("origin_txtorigin").value);
			url=url+"&OriginDescription="+URLEncode(document.getElementById("txtDescription").value);
			
		if(document.getElementById("chkActive").checked==true)
			var intStatus = 1;	
		else
			var intStatus = 0;
		
		url=url+"&intStatus="+intStatus; 
			
		if(document.getElementById("rdolocal").checked==true)
			Type=1;
		else
			Type=0;
			
		url=url+"&Type="+Type;
		}		
	}
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);	
} 

function stateChanged() 
{ 	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	 	alert(xmlHttp.responseText);
		ClearForm();
	} 
}

function ClearOriginForm()
{   	
	var url = pub_urlItemPerchase+'/Button.php?q=origins';
	htmlobj=$.ajax({url:url,async:false});
	document.getElementById("origin_cboorigin").innerHTML  = htmlobj.responseText;
	ClearForm();
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
  
	var url= pub_urlItemPerchase+"/Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete")	
		url=url+"&intOriginNo="+document.getElementById("origin_cboorigin").value;
		
	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	ClearForm();
}

function ClearForm()
{	
	document.frmorigin.reset();
	loadCombo('SELECT intOriginNo,strOriginType FROM itempurchasetype  ORDER BY strOriginType ASC','origin_cboorigin');
	document.getElementById("origin_txtorigin").focus();
	document.getElementById("origin_txtorigin").disabled=false;
}

function getoriginDetails()
{	
	var OriginID = document.getElementById('origin_cboorigin').value;
	if(OriginID==""){
		document.getElementById('origin_txtorigin').value="";return false;}

	var url = pub_urlItemPerchase+'/itempurchasemiddle.php?OriginID='+OriginID;
	htmlobj=$.ajax({url:url,async:false});
	ShoworiginDetails(htmlobj);	
}

function ShoworiginDetails(htmlobj)
{
	document.getElementById('origin_txtorigin').disabled=false;
	var XMLLoad = htmlobj.responseXML.getElementsByTagName("OriginType");
	var XMLintType = htmlobj.responseXML.getElementsByTagName("intType");
	var intType = XMLintType[0].childNodes[0].nodeValue;
	var XMLOriginDescription = htmlobj.responseXML.getElementsByTagName("originDescription");
	
	if (intType == '1')
		document.frmorigin.radiobutton[0].checked = true;	
	else
		document.frmorigin.radiobutton[1].checked = true;	
	
	document.getElementById('origin_txtorigin').value = XMLLoad[0].childNodes[0].nodeValue;
	document.getElementById('txtDescription').value = XMLOriginDescription[0].childNodes[0].nodeValue;	
	
	var XMLStatus = htmlobj.responseXML.getElementsByTagName("intStatus");					
	if(XMLStatus[0].childNodes[0].nodeValue==1)
		document.getElementById("chkActive").checked=true;	
	else
		document.getElementById("chkActive").checked=false;	
	
	var XMLused = htmlobj.responseXML.getElementsByTagName("used");	   
	   
	if(XMLused[0].childNodes[0].nodeValue == '1')
		document.getElementById('origin_txtorigin').disabled=true;
			   
	if(XMLused[0].childNodes[0].nodeValue == '0')
		document.getElementById('origin_txtorigin').disabled=false;
}
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('origin_cboorigin').value=="")
	{
		alert("Please select the Origin.");
		document.getElementById('origin_cboorigin').focus();
		return;
	}
	else
	{
		var sname = document.getElementById("origin_cboorigin").options[document.getElementById('origin_cboorigin').selectedIndex].text;
		var r=confirm('Are you sure you want to delete \n"'+ sname+'"\ ?');
		if (r==true)		
			DeleteData(strCommand);
	}
}

function loadReport()
{ 
	window.open(pub_urlItemPerchase+"/ItemPurchaseReport.php",'new'); 
}
	
function ValidateSave()
{	
	var x_id = document.getElementById("origin_cboorigin").value;
	var x_name = document.getElementById("origin_txtorigin").value;
	var x_find = checkInField('itempurchasetype','strOriginType',x_name,'intOriginNo',x_id);
	if(x_find)
	{
		alert('"'+x_name+ '" is already exist.');	
		document.getElementById("origin_txtorigin").focus();
		return false;
	}
	return true;
}