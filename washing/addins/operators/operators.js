var xmlHttp = []; 

function createXMLHttpRequest(index) 
{
	if (window.ActiveXObject) 
	{
		xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp[index] = new XMLHttpRequest();
	}
}
	
function butCommand(strCommand)

{   	  
	 if(trim(document.getElementById('cboMachineName').value)=="")
		{
			alert("Please select \"Machine Name\".");
			document.getElementById('cboMachineName').focus();
			return false;
		}
		else if(trim(document.getElementById('cboShitf').value)=="" )
		{
			alert("Please select \"Shift\".");
			document.getElementById('cboShitf').focus();
			return ;
		}
        else if(trim(document.getElementById('txtName').value)=="")
		{
			alert("Please enter \"Name\".");
			document.getElementById('txtName').focus();
			return ;
		}
		else if(isNumeric(trim(document.getElementById('txtName').value)))
		{
			alert("Name must be an \"Alphanumeric\" value.");
			document.getElementById('txtName').focus();
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
		
       var url="operato.php";
	   url=url+"?q="+strCommand;
	   
	   
 
        if(strCommand=="Save")
		    {
			url=url+"&cboSearch="+document.getElementById("cboSearch").value;			
			url=url+"&cboMachineName="+document.getElementById("cboMachineName").value;
			url=url+"&cboShitf="+document.getElementById("cboShitf").value;
			url=url+"&txtName="+document.getElementById("txtName").value;
			url=url+"&txtRemarks="+document.getElementById("txtRemarks").value;
			}
			else
			{
			url=url+"&cboMachineName="+document.getElementById("cboMachineName").value;
			url=url+"&cboShitf="+URLEncode(document.getElementById("cboShitf").value);
			url=url+"&txtName="+URLEncode(document.getElementById("txtName").value);
			url=url+"&txtRemarks="+URLEncode(document.getElementById("txtRemarks").value);
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
		   
			
      function ClearoperatorForm()
	{   	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ClearoperatorForm;
	 	xmlHttp.open("GET", 'operato.php?q=+obj', true);
		xmlHttp.send(null);  	
	}	 
					 
	function ClearoperatorsForm1()
	{	
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{
				document.getElementById("cboMachineName").innerHTML  = xmlHttp.responseText;
	        	document.getElementById('cboShitf').focus();
			}
		 }		 
			 
	 }		 
				 
	function GetXmlHttpObject()
     {
      var xmlHttp=null;
        try
     {

   xmlHttp=new XMLHttpRequest();
    }
   catch (e)
    {
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
  
	var url="operato.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
	url=url+"&cboSearch="+document.getElementById("cboSearch").value;
	}
   
	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	}

function ClearForm()
{	
	document.frmOperators.reset();
	loadCombo('SELECT intOperatorId,strName  FROM was_operators where intStatus <>10 order by  strName  ASC','cboSearch');
	document.getElementById('cboMachineName').focus();
}
	

	
function getoperatorsDetails()
{   
	var Opratorsload = document.getElementById('cboSearch').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange =  LoadDetailsRequest;
		xmlHttp.open("GET", 'operatoprsmiddle.php?Opratorsload=' + Opratorsload, true);
		xmlHttp.send(null); 
		
}

 
	function ConfirmDelete(strCommand)

	{
		if(document.getElementById('cboSearch').value=="")
		{
			alert("Please select \"operator name\".");
		}
		else
		{
			var operatorName = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
			var r=confirm("Are you sure you want to delete " +operatorName+" ?");
			if (r==true)		
				DeleteData(strCommand);
			}
	
		}

	 function checkvalue()
	{
	if(document.getElementById('txtName').value!="")
	document.getElementById("textRemarks").focus();
	}
			
	function ClearoperatorsForm()		
     {
	document.frmOperators.reset();
     }

function LoadDetails(obj)
{	
	htmlObj=$.ajax({url:'operatorsmiddle.php?OperatorCode=' +obj.value,async:false});

	
	var XMLMachine = htmlObj.responseXML.getElementsByTagName('MachineName');
		var XMLShift = htmlObj.responseXML.getElementsByTagName('Shift');
		var XMLName = htmlObj.responseXML.getElementsByTagName('Name');
		var XMLRemarks = htmlObj.responseXML.getElementsByTagName('Remarks');
		var XMLStatus = htmlObj.responseXML.getElementsByTagName("Status");
		var XMLSection=htmlObj.responseXML.getElementsByTagName("Section");
		var XMLEpfNo=htmlObj.responseXML.getElementsByTagName("EpfNo");
		
		if(XMLMachine.length<=0){
			ClearForm();
			return;
		}
		
		document.getElementById('cboMachineName').value = XMLMachine[0].childNodes[0].nodeValue;
		document.getElementById('cboShitf').value = XMLShift[0].childNodes[0].nodeValue;
		document.getElementById('txtName').value = XMLName[0].childNodes[0].nodeValue;
		document.getElementById('txtRemarks').value = XMLRemarks[0].childNodes[0].nodeValue;		
		document.getElementById('cboSection').value = XMLSection[0].childNodes[0].nodeValue;
		document.getElementById('txtEpfNo').value = XMLEpfNo[0].childNodes[0].nodeValue;
		
		if(XMLSection[0].childNodes[0].nodeValue==2){
			document.getElementById('cboMachineName').disabled=true;
		}
		else{
			document.getElementById('cboMachineName').disabled=false;
		}
		if(XMLStatus[0].childNodes[0].nodeValue==1)
			document.getElementById("chkActive").checked=true;	
		else
			document.getElementById("chkActive").checked=false;	
}
	  
		
 
     function ValidateInterface()
       {
	    if(trim(document.getElementById('cboMachineName').value)=="")
	  {
		alert("Please select Machine Name.");
		document.getElementById('cboMachineName').focus();
		return false;
		
	}
	 return true ;
}

function ViewOperatorReport(){ 
	    var cboSearch = document.getElementById('cboSearch').value;
		window.open("operatorsreport.php?",'frmwas_operators'); 
		}
function ClearFormc()
	{   	
		document.getElementById("cboSearch").value = "";
		document.getElementById("cboMachineName").value = "";
		document.getElementById("cboShitf").value = "";
	}
     
function ValidateSave()
{	
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("txtName").value;
		
	var x_find = checkInField('was_operators','strName',x_name,'intOperatorId',x_id);
	
	if(x_find)
	{
		alert(x_name+"is already exist.");	
		document.getElementById("txtName").focus();
		return;
	}
return true;	
}

function selectOpatatorType(obj){
	if(obj.value.trim()==""){
		document.getElementById("cboMachineName").disabled=false;
		return false;
	}
	else
		if(obj.value.trim()==2)
		{
			document.getElementById("cboMachineName").disabled=true;
			document.getElementById("cboMachineName").value='';
		}	
		else{
			document.getElementById("cboMachineName").disabled=false;
			document.getElementById("cboMachineName").value='';
		}
}

function optSave(obj){
	if(!formValidation()){
		return false;	
	}
	
	var Search=document.getElementById('cboSearch').value.trim();
	var Section=document.getElementById('cboSection').value.trim();
	var MachineName=document.getElementById('cboMachineName').value.trim();
	var Shift=document.getElementById('cboShitf').value.trim();
	var EpfNo=document.getElementById('txtEpfNo').value.trim();
	var Name=document.getElementById('txtName').value.trim();
	var Remarks=document.getElementById('txtRemarks').value.trim();
	var intStatus;
	if(document.getElementById("chkActive").checked==true)
		{
			 intStatus = 1;	
		}
		else
		{
			 intStatus = 0;
		}
	var path="operator_db.php?req=";
	var op='';
	if (Search==""){
		op="saveDet";
	}
	else{
		op="updateDet&Search="+Search;
	}
	path+=op+"&Section="+Section+"&MachineName="+MachineName+"&Shift="+Shift+"&EpfNo="+EpfNo+"&Name="+Name+"&Remarks="+Remarks+"&intStatus="+intStatus;
	htmlObj=$.ajax({url:path,async:false});
	alert(htmlObj.responseText);
	loadCombo('SELECT intOperatorId,strName  FROM was_operators where intStatus <>10 order by  strName  ASC','cboSearch');
	return false;
}

function formValidation(){
	if(document.getElementById('cboSection').value.trim()==''){
		alert("Please select the 'Section'.");
		document.getElementById('cboSection').focus();
		return false;
	}
	if(!document.getElementById('cboMachineName').disabled){
		if(document.getElementById('cboMachineName').value.trim()==''){
			alert("Please select the 'Machine Name'.");
			document.getElementById('cboMachineName').focus();
			return false;
		}
	}
	if(document.getElementById('cboShitf').value.trim()==''){
		alert("Please select the 'Shift'.");
		document.getElementById('cboShitf').focus();
		return false;
	}
	if(document.getElementById('txtEpfNo').value.trim()==''){
		alert("Please enter 'EPF No'.");
		document.getElementById('txtEpfNo').focus();
		return false;
	}
	if(document.getElementById('txtName').value.trim()	==''){
		alert("Please enter 'Employee Name'.");
		document.getElementById('txtName').focus();
		return false;
	}
	return true;
}