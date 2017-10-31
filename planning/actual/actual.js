var xmlHttp;


//Insert & Update Data (Save Data)
function butCommand(strCommand)
{
	if(document.getElementById('txtValidFrom').value=="")
	{
		alert("Please Select the Date");
		return false;
	}
	else if(document.getElementById('actual_time1').value=="")
	{
		alert("Please Select the Start Time");
		return false;
	}
	else if(document.getElementById('actual_time2').value=="")
	{
		alert("Please Select the End Time");
		return false;
	}
	
	var start =document.getElementById('actual_time1').value;
	var end =document.getElementById('actual_time2').value;
	var dtStart = new Date("1/1/2007 " + start);
	var dtEnd = new Date("1/1/2007 " + end);
	difference_in_milliseconds = dtEnd - dtStart;
	if (difference_in_milliseconds < 0)
	{
		  alert("End time must be greater than Start time");
		  return false;
	}
	
	else if(document.getElementById('actual_cboTeam').value=="")
	{
		alert("Please Select the Team");
		return false;
	}
	else if(document.getElementById('actual_cboStyle').value=="")
	{
		alert("Please Select the Style");
		return false;
	}
	else if(document.getElementById('actual_cboStripe').value=="")
	{
		alert("Please Select the Stripe");
		return false;
	}
	else if(document.getElementById('actual_txtProducedQty').value=="")
	{
		alert("Please Enter the Produced Quantity");
		return false;
	}
	/*
	xmlHttp=GetXmlHttpObject();

	if (xmlHttp==null)
	{
	alert ("Browser does not support HTTP Request");
	return;
	} 
  	*/
	var urlDetails="actualmiddle.php";
	urlDetails=urlDetails+"?id=Save";
	
	urlDetails=urlDetails+"&date="+document.getElementById("txtValidFrom").value;
	urlDetails=urlDetails+"&startTime="+document.getElementById("actual_time1").value;
	urlDetails=urlDetails+"&endTime="+document.getElementById("actual_time2").value;
	urlDetails=urlDetails+"&intTeamNo="+document.getElementById("actual_cboTeam").value;
	urlDetails=urlDetails+"&strStyleID="+document.getElementById("actual_cboStyle").value;
	urlDetails=urlDetails+"&intStripeID="+document.getElementById("actual_cboStripe").value;
	urlDetails=urlDetails+"&dblProducedQty="+document.getElementById("actual_txtProducedQty").value;
	urlDetails=urlDetails+"&dblSMV="+document.getElementById("actual_txtSMV").value;
	urlDetails=urlDetails+"&intWorkers="+document.getElementById("actual_txtWorkers").value;
	urlDetails=urlDetails+"&intWorkingMins="+document.getElementById("actual_txtWorkingMins").value;
	
	
	/*
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
	xmlHttp.send(null);*/
	
	//var urlDetails='actualmiddle.php?id=loadStyle&team='+team+'&company='+company;
		
	(function($) { 
		htmlobj=$.ajax({url:urlDetails,async:false});
		alert(htmlobj.responseText);
	})(jQuery);
} 
/*
function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
 setTimeout("location.reload(true);",1000);
 } 
}
*/



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
  
	var url="Button.php";
	url=url+"?q="+strCommand;

	if(strCommand=="Delete"){ 		
		url=url+"&strSeasonID="+document.getElementById("cboSeasons").value;
	}

	xmlHttp.onreadystatechange=stateChanged;	
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	ClearForm();
	
}
	
//	function backtopage()
//	{
//		window.location.href="main.php";
//	}
	
	function ClearForm()
	{	
		document.getElementById("txtValidFrom").value="";
		document.getElementById("actual_time1").value="00";
		document.getElementById("actual_time2").value="00";
		document.getElementById("actual_time1Min").value="00";
		document.getElementById("actual_time2Min").value="00";
		
		document.forms[0].actual_cboTeam[0].value == ""
		document.forms[0].actual_cboTeam[0].selected = true;
		
		clearCombo('actual_cboStyle');
		clearCombo('actual_cboStripe');
		
		
		document.getElementById("actual_txtProducedQty").value="";
		document.getElementById("actual_txtSMV").value="";
		document.getElementById("actual_txtWorkers").value="";
		document.getElementById("actual_txtWorkingMins").value="";
		document.getElementById("txt_leftQty").value="";
		//	setTimeout("location.reload(true);",1000);
		
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
	if(document.getElementById('cboSeasons').value=='')
	{
		setTimeout("location.reload(true);",0);
	} 
	
	
	
		var Seasonload = document.getElementById('cboSeasons').value;
		createXMLHttpRequest();
		xmlHttp.onreadystatechange = ShowSeasonsDetails;
		xmlHttp.open("GET", 'Seasonsmiddle.php?id=Season&Seasonload=' + Seasonload, true);
		xmlHttp.send(null); 
		
	}

	function ShowSeasonsDetails()
	{
		if(xmlHttp.readyState == 4) 
		{
			if(xmlHttp.status == 200) 
			{	
			
			 //   var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SeasonId");	
			//	document.getElementById('txtseasonid').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SeasonCode");
				document.getElementById('txtcode').value = XMLAddress1[0].childNodes[0].nodeValue;	
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("SeasonName");
				document.getElementById('txtseason').value = XMLAddress1[0].childNodes[0].nodeValue;
				var XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Remarks");
				document.getElementById('txtremarks').value = XMLAddress1[0].childNodes[0].nodeValue;
				
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
		if(document.getElementById('cboSeasons').value=="")
		{
			alert("Please Enter SeasonID");
		}
		else
		{
			var r=confirm("Are You Sure Delete?");
			if (r==true)		
				DeleteData(strCommand);
		}
		
			
	}

function checkvalue()
	{
	if(document.getElementById('txtcode').value!="")
	document.getElementById("txtremarks").focus();
	}
	
		//--------------------------------------report------------------------------------------
	
	function loadReport(){ 
	    var cboSeasons = document.getElementById('cboSeasons').value;
		window.open("SeasonsReport.php?cboSeasons=" + cboSeasons); 
   }
   
   function loadStyle()
	{	
		var team = document.getElementById("actual_cboTeam").value;
		//alert(team);
		var urlDetails='actualmiddle.php?id=loadStyle&team='+team;
		
		var htmlobj=$.ajax({url:urlDetails,async:false});
		//alert(htmlobj.responseText);
		document.getElementById("actual_cboStyle").innerHTML=htmlobj.responseText;
		 
	}
	
	 function loadStripe()
	{	
		var team = document.getElementById("actual_cboTeam").value;
		var style = document.getElementById("actual_cboStyle").value;
		
		var urlDetails='actualmiddle.php?id=loadStripe&team='+team+'&style='+style;
		
		
		htmlobj=$.ajax({url:urlDetails,async:false});
		document.getElementById("actual_cboStripe").innerHTML=htmlobj.responseText;
		
	}
	
	
	function loadStripeRequest()
	{
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200 ) 
		{
			document.getElementById("actual_cboStripe").innerHTML=xmlHttp.responseText;			
		}
	}
	
	function loadFullQuantity()
	{
		var stripNo=$("#actual_cboStripe :selected").text();
		
		var url='actualmiddle.php?id=loadFullQuantity&stripNo='+stripNo;
		htmlobj=$.ajax({url:url,async:false});
		//alert(htmlobj.responseText);
		document.getElementById("txt_leftQty").value=htmlobj.responseText;
	}
	
	function clearCombo(name)
	{
		var index = document.getElementById(name).options.length;
		while(document.getElementById(name).options.length > 0) 
		{
			index --;
			document.getElementById(name).options[index] = null;
		}
	}
	
	function validateData()
	{
		var team=$("#actual_cboTeam :selected").text();
		var style=$("#actual_cboStyle :selected").text();
		var stripNo=$("#actual_cboStripe :selected").text();
		
		var sHours=document.getElementById('actual_time1').value;
		
		var sMinutes=document.getElementById('actual_time1Min').value;
		
		var eHours=document.getElementById('actual_time2').value;
		var eMinutes=document.getElementById('actual_time2Min').value;
		
		if(document.getElementById('txtValidFrom').value=='')
			alert("Please Enter Date");
		else if(sHours==00 )
			alert("Start Time Hours can't be zero");
		else if(eHours==00)
			alert("End Time Hours can't be Zero");
		else if(parseFloat(sHours)>parseFloat(eHours))
		{
			alert("Start Time should be less than End Time");
			document.getElementById('actual_time1').value="00";
			document.getElementById('actual_time1Min').value="00";
			document.getElementById('actual_time2').value="00";
			document.getElementById('actual_time2Min').value="00";
		}
		else if(parseFloat(sHours)>24 || parseFloat(eHours)>24)
		{
			alert("Please Enter a valid Time");
			document.getElementById('actual_time1').value="00";
			document.getElementById('actual_time1Min').value="00";
			document.getElementById('actual_time2').value="00";
			document.getElementById('actual_time2Min').value="00";
		}
		else if(parseFloat(sHours)==parseFloat(eHours))
		{
			if(parseFloat(sMinutes)>parseFloat(eMinutes))
				alert("Start Time should be less than End Time");
			document.getElementById('actual_time1').value="00";
			document.getElementById('actual_time1Min').value="00";
			document.getElementById('actual_time2').value="00";
			document.getElementById('actual_time2Min').value="00";
		}
		else if(team=='')
			alert("Please Select a Team");
		else if(style=='')
			alert("Please Select a Style");
		else if(stripNo=='')
			alert("Please Select a Strip");
		else if(document.getElementById('actual_txtProducedQty').value=='')
			alert("Please Enter Produced Qty");
		else if(document.getElementById('actual_txtSMV').value=='')
			alert("Please Enter SMV");
		else if(document.getElementById('actual_txtWorkers').value=='')
			alert("Please Enter No: of Workers");
		else if(document.getElementById('actual_txtWorkingMins').value=='')
			alert("Please Enter No: of Working minutes");
		else if(parseFloat(document.getElementById('actual_txtProducedQty').value)>parseFloat(document.getElementById("txt_leftQty").value))
		{
			alert("Specified qty is too large!!");
			document.getElementById('actual_txtProducedQty').value='';
		}
		else
			saveData();
		
	}
	
	function saveData()
	{
		var date=document.getElementById("txtValidFrom").value;
		var sHours=document.getElementById("actual_time1").value;
		//alert(sHours);
		var eHours=document.getElementById("actual_time2").value;
		var sMinutes=document.getElementById("actual_time1Min").value;
		var eMinutes=document.getElementById("actual_time2Min").value;
		
		var startTime=sHours+':'+sMinutes+':00';
		var endtime=eHours+":"+eMinutes+':00';
		
		//alert(startTime);
		
		var teamNo=document.getElementById('actual_cboTeam').value;
		//alert(teamNo);
		var style=document.getElementById('actual_cboStyle').value;
		//alert(style);
		var stripNo=document.getElementById('actual_cboStripe').value;
		//alert(stripNo);
		
		var producedQty=document.getElementById("actual_txtProducedQty").value;
		var smv=document.getElementById("actual_txtSMV").value;
		var noOfWorkers=document.getElementById("actual_txtWorkers").value;
		var workingMinutes=document.getElementById("actual_txtWorkingMins").value;
		
		var url1='actualmiddle.php?id=saveToActProduction';
		url1	+= "&date="+date;
		url1    +="&startTime="+startTime;
		url1	+= "&endtime="+endtime;
		url1	+= "&intTeamNo="+teamNo;
		url1	+= "&strStyleId="+style;
		url1	+= "&intStripeId="+stripNo;
		url1    +="&dblProducedQty="+producedQty;
		url1	+= "&dblSMV="+smv;
		url1	+= "&intWorkers="+noOfWorkers;
		url1	+= "&intWorkingMins="+workingMinutes;
		
		htmlobj1=$.ajax({url:url1,async:false});
		
		var url='actualmiddle.php?id=updateStripActQty&stripNo='+stripNo+'&producedQty='+producedQty;
		
		htmlobj=$.ajax({url:url,async:false});
		
		if(htmlobj.responseText==1)
			alert("Data Saved Successfully");
		ClearForm();
	}
	
	
	
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
	}
	
	function checkTime(obj)
	{
		if(obj.value.length==1)
			obj.value="0"+obj.value;
	}