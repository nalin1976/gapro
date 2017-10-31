
var xmlHttp;
var pub_memColor ='';
var pub_obj ;
//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	  if(document.getElementById('txtfrom').value=="")
		{
			alert("Please Enter From Value");	
			return false;
		}
		else if(document.getElementById('txtto').value=="")
        {
			alert("Please Enter To Value");
			return false;
		}
			
		 else if(document.getElementById('txtpre').value=="")
		 {
			 alert("Please Enter Percentage");
			 return false;
		 }
		 else
		 {
			 xmlHttp=GetXmlHttpObject();
			
			if (xmlHttp==null)
			  {
			  alert ("Browser does not support HTTP Request");
			  return;
			  } 
			  
			  if(document.getElementById('cbogrn').value=="")
			  strCommand="New";
			  
			  var url="Button.php";
			  url=url+"?q="+strCommand;
					
			  if(strCommand=="Save")
			  { 
				
					
					
					url=url+"&intFrom="+document.getElementById("txtfrom").value;
					url=url+"&strTo="+document.getElementById("txtto").value;
					url=url+"&dblPercentage="+document.getElementById("txtpre").value;
					url=url+"&intNo="+document.getElementById("cbogrn").value;
					
				//	setTimeout("location.reload(true);",1000);
				}
				else
				{   
				    url=url+"&intFrom="+document.getElementById("txtfrom").value;
					url=url+"&strTo="+document.getElementById("txtto").value;
					url=url+"&dblPercentage="+document.getElementById("txtpre").value;
					//url=url+"&intNo="+document.getElementById("cbogrn").value;
					
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
 //document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 //setTimeout("location.reload(true);",1000);
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

	if(strCommand=="Delete"){ 		
		url=url+"&intNo="+document.getElementById("cbogrn").value;
		
		//setTimeout("location.reload(true);",1000);
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
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		} 
		
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ClearForm1;
		xmlHttp.open("GET", 'Button.php?q=GrnExcess', true);
		xmlHttp.send(null);  	
}

	function ClearForm1()
	{	
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{
				document.getElementById("cbogrn").innerHTML  = xmlHttp.responseText;
				
			}
		}		
		
	   ClearFields();
		
	}
	
	function ClearFields()
	{	
		document.getElementById("txtHint").innerHTML="";
		document.getElementById("cbogrn").value = "";
		document.getElementById("txtfrom").value = "";
		document.getElementById("txtto").value = "";
		document.getElementById("txtpre").value = "";
		document.getElementById("txtfrom").focus();
		//setTimeout("location.reload(true);",1000);
		
	}

//load data
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

function getgrnDetails()
	{   
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	if(document.getElementById('cbogrn').value=='')
	{
		setTimeout("location.reload(true);",0);
	}
	
	
		var GRNNo = document.getElementById('cbogrn').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowGRNDetails;
		xmlHttp.open("GET", 'grnmiddle.php?GRNNo=' + GRNNo, true);
		xmlHttp.send(null); 
		
		
	}


function ShowGRNDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			    var XMLLoad = xmlHttp.responseXML.getElementsByTagName("From");
				document.getElementById('txtfrom').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("To");
				document.getElementById('txtto').value = XMLLoad[0].childNodes[0].nodeValue;
				var XMLLoad = xmlHttp.responseXML.getElementsByTagName("Percentage");
				document.getElementById('txtpre').value = XMLLoad[0].childNodes[0].nodeValue;	
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Status");
								
				if(XMLAddress1[0].childNodes[0].nodeValue==1)
				{
					document.getElementById("chkActive").checked=true;	
				}
				else
				{
					document.getElementById("chkActive").checked=false;	
				}
				
			}
		}
	}
	
function ConfirmDelete(strCommand)
	{
		if(document.getElementById('cbogrn').value=="")
		{
			alert("Please Enter GRN");
		}
		else
		{
			var r=confirm("Are You Sure Delete?");
			if (r==true)		
				DeleteData(strCommand);
				
		}
		
			
	}
	
	
	function isValidData()
	{
		if(document.getElementById('txtfrom').value=="")
		{
			alert("Please Enter From Value");	
			return false;
		}
         
		 else if(document.getElementById('txtto').value=="")
        {
			alert("Please Enter To Value");
			
			}
			
		 else if(document.getElementById('txtpre').value=="")
		 {
			 alert("Please Enter Percentage");
			 
			 }
			 
		else
		return true;
	}
	
	function clickGrid(obj)
	{
		
		//obj.bgColor = "#FEDAFD";
		//pub_obj.bgColor = pub_memColor;
		document.getElementById("cbogrn").value = obj.id;	
		document.getElementById("cbogrn").onchange();
	}
	
			
	//--------------------------------------report------------------------------------------
	
	function loadReport(){ 
	    var cbogrn = document.getElementById('cbogrn').value;
		window.open("GrnExQtyReport.php?cbogrn=" + cbogrn); 
   }