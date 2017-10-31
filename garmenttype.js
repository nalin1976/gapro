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
	 if(trim(document.getElementById('cboDescrtiption').value)=="")
		{
			alert("Please select \"Descrtiption\".");
			document.getElementById('cboDescrtiption').focus();
			return false;
		}
		
        else if(trim(document.getElementById('txtGarmentName').value)=="")
		{
			alert("Please enter \"GarmentName\".");
			document.getElementById('txtGarmentName').focus();
			return ;
		}
		else if(isNumeric(trim(document.getElementById('txtGarmentName').value)))
		{
			alert("GarmentName must be an \"Alphanumeric\" value.");
			document.getElementById('txtGarmentName').focus();
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
		
       var url="garment.php";
	   url=url+"?q="+strCommand;
	   
	      

        if(strCommand=="Save")
		    {
			url=url+"&cboSearch="+document.getElementById("cboSearch").value;			
			url=url+"&cboDescrtiption="+document.getElementById("cboDescrtiption").value;
			url=url+"&txtGarmentName="+document.getElementById("txtGarmentName").value;
			
			}
			else
			{
			url=url+"&cboDescrtiption="+document.getElementById("cboDescrtiption").value;
			url=url+"&txtGarmentName="+URLEncode(document.getElementById("txtGarmentName").value);
			
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
		   
			
      function CleargarmenttypeForm()
	{   	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ClearoperatorForm;
	 	xmlHttp.open("GET", 'garment.php?q=+obj', true);
		xmlHttp.send(null);  	
	}	 
					 
	function CleargarmenttypeForm1()
	{	
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{
				document.getElementById("cboDescrtiption").innerHTML  = xmlHttp.responseText;
	        	document.getElementById('txtGarmentName').focus();
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
  
	var url="garment.php";
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
	document.frmGarmenttype.reset();
	loadCombo('SELECT intGamtID ,strGarmentName FROM was_garmenttype WHERE intStatus <> 10 order by strGarmentName ASC','cboSearch');
	document.getElementById('cboDescrtiption').focus();
}
	

	
	function getgarmenttypeDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 	
	
	
	var Garmenttypeload = document.getElementById('cboSearch').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange =  LoadDetailsRequest;
		xmlHttp.open("GET", 'garmenttypemiddle.php?Garmenttypeload=' + Garmenttypeload, true);
		xmlHttp.send(null); 
		
	}

 
	function ConfirmDelete(strCommand)

	{
		if(document.getElementById('cboSearch').value=="")
		{
			alert("Please select \"garment name\".");
		}
		else
		{
			var garmentName = document.getElementById("cboSearch").options[document.getElementById('cboSearch').selectedIndex].text;
			var r=confirm("Are you sure you want to delete " +garmentName+" ?");
			if (r==true)		
				DeleteData(strCommand);
			}
	
		}

	 function checkvalue()
	{
	if(document.getElementById('txtGarmentName').value!="")
	
	
			
	function CleargarmenttypeForm()		
     {
	document.frmgarmenttype.reset();
     }

function LoadDetails(obj)
{	
	createXMLHttpRequest(0);
	xmlHttp[0].onreadystatechange =LoadDetailsRequest;
	xmlHttp[0].open("GET", 'garmenttypemiddle.php?GarmenttypeCode=' +obj.value, true);
	xmlHttp[0].send(null);
}
	  
function LoadDetailsRequest()
{
	if(xmlHttp[0].readyState == 4 && xmlHttp[0].status == 200) 
	{		
		var XMLDescrtiption= xmlHttp[0].responseXML.getElementsByTagName('Descrtiption');
		var XMLGarmentName = xmlHttp[0].responseXML.getElementsByTagName('GarmentName');
		var XMLStatus = xmlHttp[0].responseXML.getElementsByTagName("Status");
		
		if(XMLDescrtiption.length<=0){
			ClearForm();
			return;
		}
		
		document.getElementById('cboDescrtiption').value =XMLDescrtiption[0].childNodes[0].nodeValue;
		document.getElementById('txtGarmentName').value =XMLGarmentName[0].childNodes[0].nodeValue;
			
		if(XMLStatus[0].childNodes[0].nodeValue==1)
			document.getElementById("chkActive").checked=true;	
		else
			document.getElementById("chkActive").checked=false;
	}
}
			
					
 
     function ValidateInterface()
       {
	    if(trim(document.getElementById('cboDescrtiption').value)=="")
	  {
		alert("Please select Descrtiption.");
		document.getElementById('cboDescrtiption').focus();
		return false;
		
	}
	 return true ;
}

function ViewOperatorReport(){ 
	    var cboSearch = document.getElementById('cboSearch').value;
		window.open("garmenttypereport.php?",'frmwas_garmenttype'); 
		}
function ClearFormc()
	{   	
		document.getElementById("cboSearch").value = "";
		document.getElementById("cboDescrtiption").value = "";
		
	}
     
function ValidateSave()
{	
	var x_id = document.getElementById("cboSearch").value;
	var x_name = document.getElementById("txtGarmentName").value;
		
	var x_find = checkInField('was_garmenttype','txtGarmentName',x_name,'intGamtID',x_id);
	
	if(x_find)
	{
		alert(x_name+"is already exist.");	
		document.getElementById("txtGarmentName").focus();
		return;
	}
return true;	
}
}
