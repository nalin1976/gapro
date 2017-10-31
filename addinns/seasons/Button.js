var xmlHttp;
var pub_seasonPath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_url = pub_seasonPath+"/addinns/seasons/";

//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(trim(document.getElementById('seasons_txtcode').value)=="")
	{
		alert('Please enter "Season Code".');
		document.getElementById("seasons_txtcode").select();
		return false;
	}
	else if(trim(document.getElementById('seasons_txtseason').value)=="")
	{
		alert('Please enter "Season Name".');
		document.getElementById("seasons_txtseason").select();
		return false;
	}
	else if(isNumeric(trim(document.getElementById('seasons_txtseason').value)))
	{
		alert("Season Name must be an \"Alphanumeric\" value.");
		document.getElementById("seasons_txtseason").select();
		return false;
	}

	var x_id = document.getElementById("seasons_cboSeasons").value;
	var x_name = document.getElementById("seasons_txtcode").value;

	var x_find = checkInField('seasons','strSeasonCode',x_name,'intSeasonId',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("seasons_txtcode").select();
		return;
	}

	var x_id = document.getElementById("seasons_cboSeasons").value;
	var x_name = document.getElementById("seasons_txtseason").value;
	
	var x_find = checkInField('seasons','strSeason',x_name,'intSeasonId',x_id);
	if(x_find)
	{
		alert('"'+x_name+ "\" is already exist.");	
		document.getElementById("seasons_txtseason").select();
		return;
	}
{
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
  	if(document.getElementById('seasons_cboSeasons').value=="")
	strCommand="New";
		
  	
	var url= pub_url+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Save"){ 	
		url=url+"&strSeasonID="+document.getElementById("seasons_cboSeasons").value;
		url=url+"&strSeasonCode="+URLEncode(document.getElementById("seasons_txtcode").value.trim());
		url=url+"&strSeason="+URLEncode(document.getElementById("seasons_txtseason").value.trim());
		url=url+"&strRemarks="+URLEncode(document.getElementById("seasons_txtremarks").value.trim());
	}
	else
	{	
		url=url+"&strSeasonCode="+URLEncode(document.getElementById("seasons_txtcode").value.trim());
		url=url+"&strSeason="+URLEncode(document.getElementById("seasons_txtseason").value.trim());
		url=url+"&strRemarks="+URLEncode(document.getElementById("seasons_txtremarks").value.trim());	
	}

	if(document.getElementById("seasons_chkActive").checked==true)
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
	

function DeleteData(strCommand)
{		
	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
	  
	var url=pub_url+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&strSeasonID="+document.getElementById("seasons_cboSeasons").value;
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
	
function ClearForm()
{ 
	document.frmSeason.reset();
	loadCombo('SELECT intSeasonId,strSeason FROM seasons order by strSeason ','seasons_cboSeasons');
	document.getElementById('seasons_txtcode').focus();
}
	
function ClearForm1()
{	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("seasons_cboSeasons").innerHTML  = xmlHttp.responseText;			
		}
	}	
   ClearForm2();	
}
	
function ClearForm2()
{	
	document.getElementById("seasons_txtHint").innerHTML="";
	document.getElementById("seasons_txtcode").value = "";
	document.getElementById("seasons_txtseason").value = "";
	document.getElementById("seasons_txtremarks").value = "";
	document.getElementById("seasons_chkActive").checked=true;		
	document.getElementById('seasons_txtcode').focus();
}
	
function backtopage()
{
	window.location.href="main.php";
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

	//Loding Data
function getSeasonsDetails()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('seasons_cboSeasons').value=='')
	{
		ClearForm();
	} 
	else{
		var Seasonload = document.getElementById('seasons_cboSeasons').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowSeasonsDetails;
		xmlHttp.open("GET", pub_url+'Seasonsmiddle.php?Seasonload=' + Seasonload, true);
		xmlHttp.send(null); 
	}
}

function ShowSeasonsDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SeasonCode");
			document.getElementById('seasons_txtcode').value = XMLAddress1[0].childNodes[0].nodeValue;	
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SeasonName");
			document.getElementById('seasons_txtseason').value = XMLAddress1[0].childNodes[0].nodeValue;
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Remarks");
			document.getElementById('seasons_txtremarks').value = XMLAddress1[0].childNodes[0].nodeValue;
			
			var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");

			if(XMLAddress1[0].childNodes[0].nodeValue==1)
				document.getElementById("seasons_chkActive").checked=true;	
			else
				document.getElementById("seasons_chkActive").checked=false;			
		}
	}
}	
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('seasons_cboSeasons').value=="")
	{
		alert("Please select Season");
	}
	else
	{
		var sname = document.getElementById("seasons_cboSeasons").options[document.getElementById('seasons_cboSeasons').selectedIndex].text;
		var r=confirm('Are you sure you want to delete \n "' + sname +'" ?');
		if (r==true)		
			DeleteData(strCommand);
	}		
}

function checkvalue()
{
	if(document.getElementById('seasons_txtcode').value!="")
	document.getElementById("seasons_txtremarks").focus();
}

function loadReport()
{ 
	var cboSeasons = document.getElementById('seasons_cboSeasons').value;
	window.open(pub_url+"SeasonsReport.php?cboSeasons=" + cboSeasons,'new'); 
}