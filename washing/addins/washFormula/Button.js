var xmlHttp;
var pub_url = "/gapro/washing/addins/washFormula/";

//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(trim(document.getElementById('frmWashFormula_txtDes').value)=="")
	{
		alert("Please enter Process");
		document.getElementById("frmWashFormula_txtDes").focus();
		return false;
	}
	if(trim(document.getElementById('pType').value)=="")
	{
		alert("Please select Process Type");
		document.getElementById("pType").focus();
		return false;
	}

	if(document.getElementById('frmWashFormula_cboWFormula').value==""){

	var process = document.getElementById("frmWashFormula_txtDes").value.trim();
	var temp    = document.getElementById("frmWashFormula_temp").value.trim();

	var path = "Button.php?q=checkProcess&process="+process+"&temp="+temp;
	htmlobj=$.ajax({url:path,async:false});
	//alert(htmlobj.responseText);
	if(htmlobj.responseText == 1){
	alert("Process with a same temperature already exists");	
	document.getElementById("frmWashFormula_txtDes").focus();
	return;
	}
}
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
  	if(document.getElementById('frmWashFormula_cboWFormula').value=="")
	strCommand="New";
		
  	var pType   = document.getElementById('pType').value.trim();
	var url= pub_url+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Save"){ 
	    url=url+"&strFormulaID="+document.getElementById("frmWashFormula_cboWFormula").value;
		url=url+"&strDes="+document.getElementById("frmWashFormula_txtDes").value;
		url=url+"&Liqour="+URLEncode(document.getElementById("frmWashFormula_Liqour").value);
		url=url+"&runTime="+URLEncode(document.getElementById("frmWashFormula_runTime").value);
		url=url+"&temperature="+URLEncode(document.getElementById("frmWashFormula_temp").value);
		url=url+"&pType="+pType;

	}
	else
	{	
		url=url+"&strDes="+document.getElementById("frmWashFormula_txtDes").value;
		url=url+"&Liqour="+URLEncode(document.getElementById("frmWashFormula_Liqour").value);
		url=url+"&runTime="+URLEncode(document.getElementById("frmWashFormula_runTime").value);
		url=url+"&temperature="+URLEncode(document.getElementById("frmWashFormula_temp").value);
		url=url+"&pType="+pType;
	}

	if(document.getElementById("frmWashFormula_chkActive").checked==true)
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

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 	alert(xmlHttp.responseText);
	ClearForm();
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
		url=url+"&strFormulaID="+document.getElementById("frmWashFormula_cboWFormula").value;
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
	
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	function ClearForm()
	{ 
		document.frmWashFormula.reset();
		loadCombo('SELECT intSerialNo,strProcessName FROM was_washformula order by strProcessName ','frmWashFormula_cboWFormula');
				document.getElementById('frmWashFormula_txtDes').focus();
		/*xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ClearForm1;
		xmlHttp.open("GET", pub_url+'Button.php?q=seasons', true);
		xmlHttp.send(null);  */	
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
function getWFormulaDetails()
	{   
	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		if(document.getElementById('frmWashFormula_cboWFormula').value=='')
		{
			ClearForm();
		} 
		else{

			var formulaload = document.getElementById('frmWashFormula_cboWFormula').value;
			createXMLHttpRequest();
			xmlHttp.onreadystatechange = ShowFormulaDetails;
			xmlHttp.open("GET", pub_url+'wFormulaMiddle.php?formulaload=' + formulaload, true);
			xmlHttp.send(null); 
		}
	}

	function ShowFormulaDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{			
				var XMLstrProcessName = xmlHttp.responseXML.getElementsByTagName("strProcessName");
				document.getElementById('frmWashFormula_txtDes').value = XMLstrProcessName[0].childNodes[0].nodeValue;
				var XMLdblLiqour = xmlHttp.responseXML.getElementsByTagName("dblLiqour");
				document.getElementById('frmWashFormula_Liqour').value = XMLdblLiqour[0].childNodes[0].nodeValue;
				var XMLdblTime = xmlHttp.responseXML.getElementsByTagName("dblTime");
				document.getElementById('frmWashFormula_runTime').value = XMLdblTime[0].childNodes[0].nodeValue;
				var XMLdblTemp = xmlHttp.responseXML.getElementsByTagName("dblTemp");
				document.getElementById('frmWashFormula_temp').value = XMLdblTemp[0].childNodes[0].nodeValue;
				var XMLProcType = xmlHttp.responseXML.getElementsByTagName("ProcType");
				document.getElementById('pType').value = XMLProcType[0].childNodes[0].nodeValue;
				
				
				var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");

				if(XMLStatus[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("frmWashFormula_chkActive").checked=true;	
				}
				else
				{
					document.getElementById("frmWashFormula_chkActive").checked=false;	
				}			
				
			}
		}
	}
	
	
	function ConfirmDelete(strCommand)
	{
		if(document.getElementById('frmWashFormula_cboWFormula').value=="")
		{
			alert("Please select Process");
		}
		else
		{
			var sname = document.getElementById("frmWashFormula_cboWFormula").options[document.getElementById('frmWashFormula_cboWFormula').selectedIndex].text;
			//alert(sname);
			var r=confirm("Are you sure you want to delete " + sname +" ?");
			if (r==true)		
				DeleteData(strCommand);
		}
		
			
	}

function checkvalue()
	{
	if(document.getElementById('seasons_txtcode').value!="")
	document.getElementById("seasons_txtremarks").focus();
	}
	
		//--------------------------------------report------------------------------------------
	
	function loadReport(){ 
	    var cboSeasons = document.getElementById('dryprocess_cboDryProcess').value;
		window.open(pub_url+"drywashreport.php?cboSeasons=" + cboSeasons,'new'); 
   }