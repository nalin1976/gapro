var xmlHttp;
var pub_url = "/gapro/washing/addins/wMachine/";

//Insert & Update Data (Save Data)
function butCommandvMach(strCommand)
{
	if(trim(document.getElementById('frmWmachine_txtDes').value)=="")
	{
		alert("Please enter Machine name");
		document.getElementById("frmWmachine_txtDes").focus();
		return false;
	}
	else if(trim(document.getElementById('frmWmachine_cboWmachineType').value)=="")
	{
		alert("Please select Machine Type");
		document.getElementById("frmWmachine_cboWmachineType").focus();
		return false;
	}
	

	var x_id = document.getElementById("frmWmachine_cboWmachine").value;
	var x_name = document.getElementById("frmWmachine_txtDes").value;

	var x_find = checkInField('was_machine','strMachineName',x_name,'intMachineId',x_id);
		if(x_find)
		{
			alert(x_name+ " is already exist.");	
			document.getElementById("frmWmachine_txtDes").focus();
			return;
		}	

{
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
  	if(document.getElementById('frmWmachine_cboWmachine').value=="")
	strCommand="New";
		
  	
	var url= "/gapro/washing/addins/wMachine/"+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Save"){ 
	    url=url+"&strMachID="+document.getElementById("frmWmachine_cboWmachine").value;
		url=url+"&strDes="+URLEncode(document.getElementById("frmWmachine_txtDes").value);
		url=url+"&strMachType="+document.getElementById("frmWmachine_cboWmachineType").value;
		url=url+"&intmachineCapacity="+document.getElementById('was_machineCapacity').value;

	}
	else
	{	
		url=url+"&strDes="+URLEncode(document.getElementById("frmWmachine_txtDes").value);
		url=url+"&strMachType="+document.getElementById("frmWmachine_cboWmachineType").value;
		url=url+"&intmachineCapacity="+document.getElementById('was_machineCapacity').value;
	
	}

	if(document.getElementById("frmWmachine_chkActive").checked==true)
	{
		var intStatus = 1;	
	}
	else
	{
		var intStatus = 0;
	}
	
	url=url+"&intStatus="+intStatus;

	xmlHttp.onreadystatechange=stateChangedwMach;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}
} 

function stateChangedwMach() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	alert(xmlHttp.responseText);
	ClearFormwMachine();
 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 //setTimeout("location.reload(true);",1000);
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
	

function DeleteDatawMach(strCommand)
{
		
	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  } 
	  
	var url="/gapro/washing/addins/wMachine/"+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&strMachID="+document.getElementById("frmWmachine_cboWmachine").value;
	}

	xmlHttp.onreadystatechange=stateChangedwMach;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
	
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	function ClearFormwMachine()
	{ 
		document.frmWmachine.reset();
		document.getElementById("frmWmachine_txtDes").focus();
		document.getElementById("frmWmachine_cboWmachineType").options[0].text="";
		document.getElementById("frmWmachine_cboWmachineType").options[0].value="";
		loadCombo('SELECT intMachineId,strMachineName FROM was_machine order by strMachineName ','frmWmachine_cboWmachine');
				
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
function getWMachDetails()
	{   
	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		if(document.getElementById('frmWmachine_cboWmachine').value=='')
		{
			ClearFormwMachine();
		} 
		else{

			var wMachload = document.getElementById('frmWmachine_cboWmachine').value;
			createXMLHttpRequest();
			xmlHttp.onreadystatechange = ShowwMachDetails;
			xmlHttp.open("GET", "/gapro/washing/addins/wMachine/"+'wMachmiddle.php?wMachload=' + wMachload, true);
			xmlHttp.send(null); 
		}
	}

	function ShowwMachDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{		
		var XMLstrMachineName = xmlHttp.responseXML.getElementsByTagName("strMachineName");
		document.getElementById('frmWmachine_txtDes').value = XMLstrMachineName[0].childNodes[0].nodeValue;	
		var XMLintMachineType = xmlHttp.responseXML.getElementsByTagName("intMachineType");
		document.getElementById('frmWmachine_cboWmachineType').value = XMLintMachineType[0].childNodes[0].nodeValue;
		/*var XMLstrMachineType = xmlHttp.responseXML.getElementsByTagName("strMachineType");
		document.getElementById('frmWmachine_cboWmachineType').options[0].text = XMLstrMachineType[0].childNodes[0].nodeValue;*/
		var XMLintMachineCapacity = xmlHttp.responseXML.getElementsByTagName("Capacity");
		document.getElementById('was_machineCapacity').value = XMLintMachineCapacity[0].childNodes[0].nodeValue;
				
				var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");

				if(XMLStatus[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("frmWmachine_chkActive").checked=true;	
				}
				else
				{
					document.getElementById("frmWmachine_chkActive").checked=false;	
				}			
				
			}
		}
	}
	
	
	function ConfirmDeletewMach(strCommand)
	{
		if(document.getElementById('frmWmachine_cboWmachine').value=="")
		{
			alert("Please select Dry Process");
		}
		else
		{
			var sname = document.getElementById("frmWmachine_cboWmachine").options[document.getElementById('frmWmachine_cboWmachine').selectedIndex].text;
			//alert(sname);
			var r=confirm("Are you sure you want to delete " + sname +" ?");
			if (r==true)		
				DeleteDatawMach(strCommand);
		}
		
			
	}

function checkvalue()
	{
	if(document.getElementById('seasons_txtcode').value!="")
	document.getElementById("seasons_txtremarks").focus();
	}
	

function closePopUpArea(id)
{
	try
	{
		var box = document.getElementById('popupLayer'+id);
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

function	showMachTypePopUp()
{
	var url  = "../machineType/machType.php?";
	inc('../machineType/Button.js');
	var W	= 545;
	var H	= 283;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeMachTypePopUp";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete);	
}
	
function closeMachTypePopUp(id)
{
	//obj.parentNode.removeChild(obj);
	//closeWindowtax();
	closePopUpArea(id);
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = LoadMachTypeRequest;
	xmlHttp.open("GET", '/gapro/washing/addins/wMachine/Button.php?q=LoadMachType', true);
   	xmlHttp.send(null);
}
	function LoadMachTypeRequest()
	{
		if(xmlHttp.readyState==4 && xmlHttp.status==200)
		{
			var XMLText = xmlHttp.responseText;			
		if(document.getElementById('frmWmachine_cboWmachineType').options[document.getElementById('frmWmachine_cboWmachineType').selectedIndex].text !="" && document.getElementById('frmWmachine_cboWmachineType').options[document.getElementById('frmWmachine_cboWmachineType').selectedIndex].value !=""){
	document.getElementById('frmWmachine_cboWmachineType').innerHTML=XMLText;
	}
			
			
		}
	}



function closeWindowtax()
{
	try
	{
		var box = document.getElementById('popupbox');
		box.parentNode.removeChild(box);
		loca = 0;
	}
	catch(err)
	{        
	}	
}

	
		//--------------------------------------report------------------------------------------
	
	function loadReportwMachine(){ 
	    var cboWmachine = document.getElementById('frmWmachine_cboWmachine').value;
		window.open("/gapro/washing/addins/wMachine/"+"wMachreport.php?cboSeasons=" + cboWmachine,'new'); 
   }
   
   	function loadReportmType(){ 
	    var cboMachType = document.getElementById('frmMachType_cboMachType').value;
		window.open("/gapro/washing/addins/machineType/"+"machTypereport.php?cboMachType=" + cboMachType,'new'); 
   }
   
   
   function checkfirstDecimal(obj){
	var d=obj.value.trim().charAt(0);	
	if(d=='.')
		obj.value=0;	
}

function checkLastDecimal(obj){
	var len=obj.value.trim().length;
	if(obj.value.trim().charAt(len-1)=='.')
			obj.value=obj.value.trim().substr(0,len-1);
}

function checkDecimals(obj){
	var d=obj.value.trim();	
	if(d.indexOf('.') > -1){
		//var c=d.charAt(d.indexOf('.'));
		obj.value=d.replace(/\./g,' ');
		obj.value=obj.value.trim();
	}
}