var xmlHttp;
var pub_chequePath = document.location.protocol+'//'+document.location.hostname+'/'+document.location.pathname.split("/")[1];
var pub_countryUrlChkInfo = pub_chequePath+"/addinns/chequeInfo/";
var xmlHttp1 = [];

//-----------hem-------------------------------------
function createXMLHttpRequest1(index) 
{
	try
	 {
	 // Firefox, Opera 8.0+, Safari
	 xmlHttp1[index]=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
		 try
		  {
		  	xmlHttp1[index]=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		 catch (e)
		  {
		  	xmlHttp1[index]=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
}
//----------hem----------------------------------------------------------

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
//---------------------hem------------------------------------------------

//Insert & Update Data (Save Data)
function butCommandC(strCommand)
{
	if(!ValidateChequeInterface())
	return;
		

	xmlHttp=GetXmlHttpObject();
	
	if (xmlHttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }			  
				 
    if(document.getElementById("frmChequeInfo_cbofrmChequeInfoList").value=="")			
		strCommand="New";
	
		var url=pub_countryUrlChkInfo+"Button.php";
		url=url+"?q="+strCommand;
	
		url=url+"&cbofrmChequeInfoList="+document.getElementById("frmChequeInfo_cbofrmChequeInfoList").value;
		url=url+"&txtChequeBookName="+URLEncode(document.getElementById("frmChequeInfo_txtChequeBookName").value);
		url=url+"&cboBankName="+URLEncode(document.getElementById("frmChequeInfo_cboBankName").value);	
		url=url+"&cboBranchName="+URLEncode(document.getElementById("frmChequeInfo_cboBranchCode").value);	
		url=url+"&txtStartNo="+URLEncode(document.getElementById("frmChequeInfo_txtStartNo").value);	
		url=url+"&txtEndNo="+URLEncode(document.getElementById("frmChequeInfo_txtEndNo").value);	
		
		if(document.getElementById("frmChequeInfo_chkActive").checked==true)
			var intStatus = 1;
		else		
			var intStatus = 0;		
		
		url=url+"&intStatus="+intStatus;	
		xmlHttp.onreadystatechange=chequeInfoStateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
//-------------hem------------------------------
function ValidateChequeInterface()
{
	if(document.getElementById('frmChequeInfo_txtChequeBookName').value.trim() == "" )
	{
		alert("Please enter \"Cheque-book Name.\"");
		document.getElementById("frmChequeInfo_txtChequeBookName").focus();
		return false;
	}
	var id = document.getElementById("frmChequeInfo_cbofrmChequeInfoList").value
	var name = document.getElementById("frmChequeInfo_txtChequeBookName").value

	var x_find = checkInField('bankchequeinfo','strName',name,'intId',id);
	if(x_find)
	{
		alert("\""+name+"\" is already exist.");	
		document.getElementById("frmChequeInfo_txtChequeBookName").focus();
		return false;
	}	
	if(document.getElementById('frmChequeInfo_cboBankName').value.trim() == "" )
	{
		alert("Please select \"Bank.\"");
		document.getElementById("frmChequeInfo_cboBankName").focus();
		return false;
	}
	
	if(document.getElementById('frmChequeInfo_cboBranchCode').value.trim() == "" )
	{
		alert("Please select \"Branch.\"");
		document.getElementById("frmChequeInfo_cboBranchCode").focus();
		return false;
	}
	
	if(document.getElementById('frmChequeInfo_txtStartNo').value.trim() == "" )
	{
		alert("Please enter \"Start No.\"");
		document.getElementById("frmChequeInfo_txtStartNo").focus();
		return false;
	}
	if(document.getElementById('frmChequeInfo_txtEndNo').value.trim() == "" )
	{
		alert("Please enter \"End No.\"");
		document.getElementById("frmChequeInfo_txtEndNo").focus();
		return false;
	}
	return true;
}

function chequeInfoStateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 	{ 
		alert(xmlHttp.responseText);
		loadCombo('SELECT intId, strName FROM bankchequeinfo WHERE intStatus<>10 order by strName ASC','frmChequeInfo_cbofrmChequeInfoList');
		document.frmChequeInfo.reset();
		document.getElementById('frmChequeInfo_cboBranchCode').innerHTML = "";	
 	} 
}

function cheque_DeleteData(strCommand)
{
		
xmlHttp=GetXmlHttpObject();

if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  } 
  
	var url=pub_countryUrlChkInfo+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&cbofrmChequeInfoList="+document.getElementById("frmChequeInfo_cbofrmChequeInfoList").value;
	}

	xmlHttp.onreadystatechange=chequeInfoStateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function ClearForm1()
{	
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{
			document.getElementById("frmChequeInfo_cbofrmChequeInfoList").innerHTML  = xmlHttp.responseText;
			document.getElementById("frmChequeInfo_txtChequeBookName").focus();
		}
	}	
   ClearForm2();	
}

function ClearForm2()
{	
	document.frmChequeInfo.reset();
	document.getElementById('frmChequeInfo_cboBranchCode').innerHTML = "";	
	document.getElementById("frmChequeInfo_txtChequeBookName").focus();
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

function ClearForm()
{  
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = ClearForm1;
	xmlHttp.open("GET", pub_countryUrlChkInfo+'Button.php?q=cheques', true);
	xmlHttp.send(null);  	
}

function getChequeDetails()
{
	if(document.getElementById('frmChequeInfo_cbofrmChequeInfoList').value=='')
	{
         document.frmChequeInfo.reset();
		 document.getElementById('frmChequeInfo_cboBranchCode').innerHTML = "";	
	}
	else
	{	
		var ChequeID = document.getElementById('frmChequeInfo_cbofrmChequeInfoList').value;
		var url = pub_countryUrlChkInfo+'chequeinfomiddle.php?q=cheque&ChequeID=' + ChequeID;
		htmlobj=$.ajax({url:url,async:false}); 
		ShowChequeDetails(htmlobj);
	}	
}

function ShowChequeDetails(htmlobj)
{
	var XMLstrName 		= htmlobj.responseXML.getElementsByTagName("strName");
		document.getElementById('frmChequeInfo_txtChequeBookName').value 	= XMLstrName[0].childNodes[0].nodeValue;
	var XMLbankName 	= htmlobj.responseXML.getElementsByTagName("bank");
		document.getElementById('frmChequeInfo_cboBankName').value 			= XMLbankName[0].childNodes[0].nodeValue;	
	var XMLbranchName 	= htmlobj.responseXML.getElementsByTagName("branch");
		document.getElementById('frmChequeInfo_cboBranchCode').innerHTML 	= "";	
		document.getElementById('frmChequeInfo_cboBranchCode').innerHTML 	= XMLbranchName[0].childNodes[0].nodeValue;	
	var XMLintStartNo 	= htmlobj.responseXML.getElementsByTagName("intStartNo");
		document.getElementById('frmChequeInfo_txtStartNo').value 			= XMLintStartNo[0].childNodes[0].nodeValue;	
	var XMLintEndNo 	= htmlobj.responseXML.getElementsByTagName("intEndNo");
		document.getElementById('frmChequeInfo_txtEndNo').value 			= XMLintEndNo[0].childNodes[0].nodeValue;	
	
	var XMLStatus = htmlobj.responseXML.getElementsByTagName("status");
	if(XMLStatus[0].childNodes[0].nodeValue==1)
		document.getElementById("frmChequeInfo_chkActive").checked=true;	
	else
		document.getElementById("frmChequeInfo_chkActive").checked=false;	
	
	var XMLused = htmlobj.responseXML.getElementsByTagName("used");	
	if(XMLused[0].childNodes[0].nodeValue == '1')
		document.getElementById('frmChequeInfo_txtChequeBookName').disabled=true;
	if(XMLused[0].childNodes[0].nodeValue == '0')
	   	document.getElementById('frmChequeInfo_txtChequeBookName').disabled=false;		
}

function loadBankandBranch(bank)
{	
    if(bank != "")
	{
		var bank = document.getElementById("frmChequeInfo_cboBankName").value;
		createXMLHttpRequest1(0);
		xmlHttp1[0].onreadystatechange = HandleLoadBranch ;
		xmlHttp1[0].open("GET",pub_countryUrlChkInfo+'chequeinfomiddle.php?q=loadBankandBranch&bank='+ bank ,true);
		xmlHttp1[0].send(null);
	}
}

function HandleLoadBranch()
{
	if(xmlHttp1[0].readyState == 4) 
	{
		if(xmlHttp1[0].status == 200) 
		{
			var XMLstrBranches = xmlHttp1[0].responseXML.getElementsByTagName("branches");
			document.getElementById('frmChequeInfo_cboBranchCode').innerHTML = XMLstrBranches[0].childNodes[0].nodeValue;
		}
	}		
}

function cheque_ConfirmDelete(strCommand)
{
	if(document.getElementById('frmChequeInfo_cbofrmChequeInfoList').value=="")
	{
		alert("Please select a Cheque-book");
		document.getElementById('frmChequeInfo_cbofrmChequeInfoList').focus();
		return;
	}
	
	else
	{
		var r=confirm("Are you sure you want to delete \""+ document.getElementById('frmChequeInfo_txtChequeBookName').value +"\" ?");
		if (r==true)		
			cheque_DeleteData(strCommand);				
	}
}

function checkvalue()
{
	if(document.getElementById('countries_txtCountryCode').value!="")
	document.getElementById("countries_txtCountry").focus();
}

function ClearFormc()
{   	
	document.getElementById("countries_cboCountryList").value = "";
	document.getElementById("countries_txtCountryCode").value = "";
	document.getElementById("countries_txtCountry").value = "";
}
	
function loadCIReport()
{ 
	window.open("chequeinfoReport.php?",'cif'); 
}

function popupChequeBank()
{
	var url  = "../banks/banks.php?";
	inc('../banks/banks-js.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_coHeader";
	var tdDelete = "td_coDelete";
	var closePopUp = "closeBankModePopUpInCheque";
	var tdPopUpClose = "banks_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeBankModePopUpInCheque(id)
{
	closePopUpArea(id);	
	var sql = 'SELECT intBankId, strBankName FROM bank WHERE intStatus<>10 order by strBankName asc';
	loadCombo(sql,'frmChequeInfo_cboBankName');
}

function LoadBankModeRequest()
{
	if(xmlHttp1[4].readyState==4 && xmlHttp1[4].status==200)
	{
			var XMLText = xmlHttp1[4].responseText;			
			document.getElementById('frmChequeInfo_cboBankName').innerHTML = XMLText;
			
			var intBankId = document.getElementById('frmChequeInfo_cboBankName').value;
	
	var sql = 'SELECT intBranchId, strName FROM branch WHERE intBankId='+intBankId+' and intStatus=1 order by strName';
	loadCombo(sql,'frmChequeInfo_cboBranchCode');
	}
}

function popupChequeBranch()
{
	var url  = "../branch/branch.php?";
	inc('../branch/button.js');
	var W	= 0;
	var H	= 0;
	var tdHeader = "td_brnchHeader";
	var tdDelete = "td_coDeleteBranch";
	var closePopUp = "closeBranchModePopUpInCheque";
	var tdPopUpClose = "branch_popup_close_button";
	CreatePopUp2(url,W,H,closePopUp,tdHeader,tdDelete,tdPopUpClose);
}

function closeBranchModePopUpInCheque(id)
{
	closePopUpArea(id);	
	var intBankId = document.getElementById('frmChequeInfo_cboBankName').value;	
	var sql = 'SELECT intBranchId, strName FROM branch WHERE intBankId='+intBankId+' and intStatus=1 order by strName';
	loadCombo(sql,'frmChequeInfo_cboBranchCode');
}

function LoadBranchModeRequest()
{
	if(xmlHttp1[5].readyState==4 && xmlHttp1[5].status==200)
	{
		var XMLText = xmlHttp1[5].responseText;			
		document.getElementById('frmChequeInfo_cboBranchCode').innerHTML = XMLText;
	}
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