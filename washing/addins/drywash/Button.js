var xmlHttp;
var pub_url = "/gaprohela/washing/addins/drywash/";

function butCommand(strCommand)
{
	if(trim(document.getElementById('dryprocess_txtcode').value)=="")
	{
		alert("Please enter \"Process Code\".");
		document.getElementById("dryprocess_txtcode").select();
		return false;
	}
	else if(trim(document.getElementById('dryprocess_txtDes').value)=="")
	{
		alert("Please enter \"Description\".");
		document.getElementById("dryprocess_txtDes").select();
		return false;
	}

	var x_id = document.getElementById("dryprocess_cboDryProcess").value;
	var x_name = document.getElementById("dryprocess_txtcode").value;

	var x_find = checkInField('was_dryprocess','strDryProCode',x_name,'intSerialNo',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("dryprocess_txtcode").select();
			return;
		}	


	var x_id = document.getElementById("dryprocess_cboDryProcess").value;
	var x_name = document.getElementById("dryprocess_txtDes").value;
	
	var x_find = checkInField('was_dryprocess','strDescription',x_name,'intSerialNo',x_id);
		if(x_find)
		{
			alert("\""+x_name+"\" is already exist.");	
			document.getElementById("dryprocess_txtDes").select();
			return;
		}	
//{
xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return;
	} 
  
  	if(document.getElementById('dryprocess_cboDryProcess').value=="")
	strCommand="New";
  	
	var url= pub_url+"Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Save"){ 
	    url=url+"&strDryID="+document.getElementById("dryprocess_cboDryProcess").value;
		url=url+"&strDryCode="+document.getElementById("dryprocess_txtcode").value;
		url=url+"&strDes="+URLEncode(document.getElementById("dryprocess_txtDes").value);
		url=url+"&Category="+URLEncode(document.getElementById("cboCategory").value);
		url=url+"&FSCategory="+URLEncode(document.getElementById("cboFScategory").value);
	}
	else
	{	
	
		url=url+"&strDryCode="+document.getElementById("dryprocess_txtcode").value;
		url=url+"&strDes="+URLEncode(document.getElementById("dryprocess_txtDes").value);
		url=url+"&Category="+URLEncode(document.getElementById("cboCategory").value);
		url=url+"&FSCategory="+URLEncode(document.getElementById("cboFScategory").value);
		
	}

	if(document.getElementById("dryprocess_chkActive").checked==true)
		var intStatus = 1;	
	else
		var intStatus = 0;
	
	url=url+"&intStatus="+intStatus;

	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
//}
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	 { 
	  saveDetails();  
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
		url=url+"&strDryID="+document.getElementById("dryprocess_cboDryProcess").value;
	}

	//xmlHttp.onreadystatechange=stateChanged;	
	//xmlHttp.open("GET",url,true);
	//xmlHttp.send(null);
}
	
function ClearForm()
{ 	
	document.frmDryProcess.reset();
	loadCombo('SELECT intSerialNo,strDescription FROM was_dryprocess order by strDescription ','dryprocess_cboDryProcess');
	document.getElementById('dryprocess_txtcode').focus();
	removeExistingRowValues();
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
function getDryDetails()
{   

	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('dryprocess_cboDryProcess').value=='')
	{
		ClearForm();
	} 
	else
	{
		var Dryprocess = document.getElementById('dryprocess_cboDryProcess').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowDryDetails;
		xmlHttp.open("GET", pub_url+'Drymiddle.php?Dryload=load&Dryprocess=' + Dryprocess, true);
		xmlHttp.send(null); 
	}
	if(document.getElementById('cboCategory').value == 'MP')
	{
	getLastNo();
	}
}
function getLastNo()
{
	var tbltermsCondition=document.getElementById('tbltermsCondition');
	var Dryload = document.getElementById('dryprocess_cboDryProcess').value;
	if(Dryload>0)
	{
		var url = 'Button.php?q=loadLastNo&Dryload='+Dryload;
		var htmlobj = $.ajax({url:url,async:false});
		if(htmlobj.responseText!='')
		{
			if (tbltermsCondition.rows.length>2)
			{
				tbltermsCondition.rows[2].cells[0].childNodes[0].value= htmlobj.responseText;
			}
			
		}
		else 
		{
			tbltermsCondition.rows[2].cells[0].childNodes[0].value=1;
		}
	}
}

function ShowDryDetails()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{	
			var XMLstrDryProCode = xmlHttp.responseXML.getElementsByTagName("strDryProCode");
			document.getElementById('dryprocess_txtcode').value = XMLstrDryProCode[0].childNodes[0].nodeValue;	
			var XMLstrDescription = xmlHttp.responseXML.getElementsByTagName("strDescription");
			document.getElementById('dryprocess_txtDes').value = XMLstrDescription[0].childNodes[0].nodeValue;
			var XMLCategory = xmlHttp.responseXML.getElementsByTagName("Category");
			document.getElementById('cboCategory').value = XMLCategory[0].childNodes[0].nodeValue;
			var XMLFSCategory = xmlHttp.responseXML.getElementsByTagName("FSCategory")[0].childNodes[0].nodeValue;
			if(XMLFSCategory != '')
				document.getElementById('cboFScategory').value = XMLFSCategory;
			else
				document.getElementById('cboFScategory').value  = 'Null';
			
			var XMLStatus = xmlHttp.responseXML.getElementsByTagName("Status");

			if(XMLStatus[0].childNodes[0].nodeValue==1)
				document.getElementById("dryprocess_chkActive").checked=true;	
			else
				document.getElementById("dryprocess_chkActive").checked=false;	
				
			var XMLstrCondition = xmlHttp.responseXML.getElementsByTagName("strCondition");
			document.getElementById('tbltermsCondition').value = XMLstrCondition[0].childNodes[0].nodeValue;
		}
	}
}
//-------------------------------------data saving------------------------------------------//
	
function ConfirmDelete(strCommand)
{
	if(document.getElementById('dryprocess_cboDryProcess').value=="")
	{
		alert("Please select \"Process\".");
		document.getElementById('dryprocess_cboDryProcess').focus();
	}
	else
	{
		var sname = document.getElementById("dryprocess_cboDryProcess").options[document.getElementById('dryprocess_cboDryProcess').selectedIndex].text;
		var r=confirm("Are you sure you want to delete \""+ sname + "\" ?");
		if (r==true)		
			DeleteData(strCommand);
	}
}

//------------------------------------deleteing------------------------------------------------//

function checkvalue()
{
	if(document.getElementById('seasons_txtcode').value!="")
	document.getElementById("seasons_txtremarks").focus();
}
	
function loadReport()
{ 
	var cboSeasons = document.getElementById('dryprocess_cboDryProcess').value;
	window.open(pub_url+"drywashreport.php?cboSeasons=" + cboSeasons,'new'); 
}
function Loadtxtarea(cmbVal)
{	
	$("#dryprocess_cboDryProcess").val('');
	$("#dryprocess_txtcode").val('');
	$("#dryprocess_txtDes").val('');
	$("#cboFScategory").val('');
	$("#dryprocess_chkActive:checked").true;
	//$("#tbltermsCondition1").show('hidden');

	/*document.getElementById('dryprocess_cboDryProcess').value = '';
	document.getElementById('dryprocess_txtcode').value = '';
	document.getElementById('dryprocess_txtDes').value = '';
	document.getElementById('cboFScategory').value = '';
	document.getElementById('dryprocess_chkActive').checked = true;

	
	document.getElementById("tbltermsCondition").style.visibility ='hidden';*/

	
	if(cmbVal =='DP')
	{
		document.getElementById("tbltermsCondition1").style.display="none";
	
	}
	else if(cmbVal =='SP')
	{
		document.getElementById("tbltermsCondition1").style.display="none";
	}
	else if(cmbVal =='OP')
	{
		document.getElementById("tbltermsCondition1").style.display="none";
	}
	else if(cmbVal =='MP')
	{
		document.getElementById("tbltermsCondition1").style.display="inline";
		loadMainProcess();
	}
	
}

//-------------------------this loads only main processes------------------------------------//
function loadMainProcess(){
var process = document.getElementById('cboCategory').value;	

 if(process == 'MP'){	
 loadCombo("SELECT intSerialNo,strDescription FROM was_dryprocess where strCategory = 'MP' order by strDescription ","dryprocess_cboDryProcess");
addFirstRow();
 }else{
 loadCombo("SELECT intSerialNo,strDescription FROM was_dryprocess  order by strDescription ","dryprocess_cboDryProcess");
 }
 
}

//-------------------------------------------------------------------------------------------------//
function removeExistingValues()
{
	var tbltermsCondition = document.getElementById('tbltermsCondition');
	var i = 0;
	
	for(i=tbltermsCondition.rows.length; i>2; i--)
	{
		tbltermsCondition.deleteRow(i-1);
	}	
}
//--------------------------------add new row--------------------------------//

function addFirstRow()
{
	var tbltermsCondition=document.getElementById('tbltermsCondition');
	if(document.getElementById('cboCategory').value=='MP')
	{
		removeExistingValues();
		var lastRow = tbltermsCondition.rows.length;
		var row = tbltermsCondition.insertRow(lastRow);
		//var serial = tbltermsCondition.rows[lastRow-1].cells[0].childNodes[0].value;
		var x=1 ;
		var cell = row.insertCell(0);
		cell.innerHTML = "<input type=\"text\" readonly=\"readonly\" name=\"txtNo\" id=\"txtNo\" class=\"textbox\" style=\"width:15px\" value=\""+(x)+"\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.innerHTML = "<input type=\"text\" name=\"txtDes\" id=\"txtDes\" class=\"textbox\" style=\"width:500px; \" onkeypress=\"addNewRow(event);\">";

	}
}
//-------------------------------------add new row--------------------------------//

function addNewRow(html)
{	if(html.which==0)
	{
	var serialNo = document.getElementById("txtNo").value;
	var description= document.getElementById("txtDes").value;
	
	var tbltermsCondition=document.getElementById('tbltermsCondition');
	
	for(var x=0 ; x<serialNo.length; x++)
	{
		var lastRow = tbltermsCondition.rows.length;
		var row = tbltermsCondition.insertRow(lastRow);
		var serial = tbltermsCondition.rows[lastRow-1].cells[0].childNodes[0].value;
		
		var cell = row.insertCell(0);
		cell.innerHTML = "<input type=\"text\" readonly=\"readonly\" name=\"txtNo\" id=\"txtNo\" class=\"textbox\" style=\"width:15px\" value=\""+(parseInt(serial)+1)+"\">";
		
		var cell = row.insertCell(1);
		cell.className ="normalfnt";
		cell.innerHTML = "<input type=\"text\" name=\"txtDes\" id=\"txtDes\" class=\"textbox\" style=\"width:500px; \" onkeypress=\"addNewRow(event);\">";
	}
	}
	
}
//-------------------------------Save terms and condition-------------------------------------//
function savetermsCondition()
{
	var tbltermsCondition=document.getElementById('tbltermsCondition');
	var dryprocess_cboDryProcess = document.getElementById('dryprocess_cboDryProcess').value;
	
		for(var n = 2; n < tbltermsCondition.rows.length; n++ )
		{	
			var serialNo    = tbltermsCondition.rows[n].cells[0].childNodes[0].value;
			var description   =  tbltermsCondition.rows[n].cells[1].childNodes[0].value;
			
			var url = 'Button.php?q=New&dryprocess_cboDryProcess='+dryprocess_cboDryProcess+'&serialNo='+serialNo+'&description='+description;
	
	html  =$.ajax({url:url,async:false});
		}
}

//--------------------------Load Conditions Details---------------------------------//
function loadConditionDetails()
{
	var  dryprocess_cboDryProcess = document.getElementById('dryprocess_cboDryProcess').value;
	var url = 'Drymiddle.php?Dryload=LoadConditionDetails&dryprocess_cboDryProcess=' +dryprocess_cboDryProcess;
	var html = $.ajax({url:url,async:false});
	
	var count = 1;
	
	if(dryprocess_cboDryProcess =='')
	{
		ClearForm();
	}
	else
	{
		removeExistingRowValues();
		
		var tbltermsCondition=document.getElementById('tbltermsCondition');
		var XMLserialNo    =  html.responseXML.getElementsByTagName("intTermId");
	    var XMLdescription = html.responseXML.getElementsByTagName("strDescription");
		
		for(var x=0; x<XMLserialNo.length; x++)
		{ 
			var newRow = tbltermsCondition.insertRow(x+2);
			
			    var serialNo        = tbltermsCondition.rows[x+2].insertCell(0);
				serialNo.class      ="normalfntMid";
				serialNo.align      ="center";
				serialNo.innerHTML  = "<input type=\"text\" align=\"center\"  name=\"txtNo\" id=\"txtNo\" class=\"txtbox\" style=\"text-align:center;width:15px;\" value=\""+ XMLserialNo[x].childNodes[0].nodeValue+"\" />";
				
				count = Number(XMLserialNo[x].childNodes[0].nodeValue)+1;
				var description        = tbltermsCondition.rows[x+2].insertCell(1);
				description.class      ="normalfntMid";
				description.align      ="center";
				description.innerHTML  = "<input type=\"text\" name=\"txtDes\" id=\"txtDes\" align=\"center\" onkeypress='addNewRow(event);' class=\"txtbox\" style=\"text-align:left;width:500px;\" value=\""+ XMLdescription[x].childNodes[0].nodeValue+"\" />";
				
		}
	if(XMLserialNo.length < 1){
		
		var newRow = tbltermsCondition.insertRow(XMLserialNo.length+2);
			
			    var serialNo        = tbltermsCondition.rows[XMLserialNo.length+2].insertCell(0);
				serialNo.class      = "normalfntMid";
				serialNo.align      = "center";
				serialNo.innerHTML  = "<input type=\"text\" name=\"txtNo\" id=\"txtNo\" align=\"center\" class=\"txtbox\" style=\"text-align:center;width:15px;\" value=\""+ (count)+"\" />";
				
				var description        = tbltermsCondition.rows[XMLserialNo.length+2].insertCell(1);
				description.class      ="normalfntMid";
				description.align      ="center";
				description.innerHTML  = "<input type=\"text\" name=\"txtDes\" id=\"txtDes\" align=\"center\" class=\"txtbox\" style=\"text-align:left;width:500px;\" onkeypress=\"addNewRow(event);\"/>";
	}
		
	}
	
}

function removeExistingRowValues()
{
	var tbltermsCondition=document.getElementById('tbltermsCondition');
	var i = 0;
	
	for(i=tbltermsCondition.rows.length; i>2; i--)
	{
		tbltermsCondition.deleteRow(i-1);
	}
}

//----------------------------------Update Terms and Conditions -------------------------//

function updateHeader()
{
	var dryprocess_cboDryProcess=document.getElementById('dryprocess_cboDryProcess').value;
	var dryprocess_txtcode=document.getElementById('dryprocess_txtcode').value;
	var dryprocess_txtDes = document.getElementById('dryprocess_txtDes').value;
	
	var url = 'Button.php?q=updateHeader&dryprocess_txtcode='+dryprocess_txtcode+'&dryprocess_txtDes='+dryprocess_txtDes+                  '&dryprocess_cboDryProcess='+dryprocess_cboDryProcess;
	html  =$.ajax({url:url,async:false});
}

function updatetermsCondition()
{
	var tblCondition=document.getElementById('tbltermsCondition');
	var cboDryProcess = document.getElementById('dryprocess_cboDryProcess').value;
	
		for(var y = 2; y < tblCondition.rows.length; y++ )
		{	
		
			var serialno    = tblCondition.rows[y].cells[0].childNodes[0].value;
			var condition   =  tblCondition.rows[y].cells[1].childNodes[0].value;
			//alert(condition);
			var url = 'Button.php?q=Save&cboDryProcess='+cboDryProcess+'&serialno='+serialno+'&condition='+condition;
	
	html  =$.ajax({url:url,async:false});
		}
}

//-------------------------------------------------------------------------------------------

function deleteBeforeSave(processID){

	//var dryprocess_cboDryProcess=document.getElementById('dryprocess_cboDryProcess').value;
	//var url = 'Button.php?q=deleteBeforeSave&dryprocess_cboDryProcess='+dryprocess_cboDryProcess;
	//html  =$.ajax({url:url,async:false});
	//if(html.responseText == '1'){
	 //saveDetails(processID);		
	//}
}

//--------------------------------------------------------------------------------------------

function saveDetails(){
	
	if(document.getElementById('dryprocess_cboDryProcess').value == ''){
	var url = 'Drymiddle.php?q=loadProcessId';
	html  =$.ajax({url:url,async:false});
	
	var XMLintSerialNo = html.responseXML.getElementsByTagName("intSerialNo");
	var dryprocess_cboDryProcess =  XMLintSerialNo[0].childNodes[0].nodeValue;	
	}else{
	var dryprocess_cboDryProcess=document.getElementById('dryprocess_cboDryProcess').value;
	}

	
	var url = 'Button.php?q=deleteBeforeSave&dryprocess_cboDryProcess='+dryprocess_cboDryProcess;
	html  =$.ajax({url:url,async:false});

	
 	var tblCondition=document.getElementById('tbltermsCondition');

		for(var y = 2; y < tblCondition.rows.length; y++ )
		{			
		 var serialno    = tblCondition.rows[y].cells[0].childNodes[0].value;
		 var condition   =  tblCondition.rows[y].cells[1].childNodes[0].value;

		 var url = 'Button.php?q=saveDetails&cboDryProcess='+dryprocess_cboDryProcess+'&serialno='+serialno+'&condition='+condition;
		 html  =$.ajax({url:url,async:false});
		}
		alert("Saved Successfully");
		
		var tblCondition=document.getElementById('tbltermsCondition');
			var tblTable    = 	document.getElementById("tbltermsCondition");

			var binCount	=	tblTable.rows.length;
			for(var loop=2;loop<binCount;loop++)
			{
					tblTable.deleteRow(loop);
					binCount--;
					loop--;
			}
		document.getElementById('cboCategory').value = "";
		document.getElementById('dryprocess_cboDryProcess').value = "";
		document.getElementById('dryprocess_txtcode').value = "";
		document.getElementById('dryprocess_txtDes').value = "";
}