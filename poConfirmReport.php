<?php 
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="javascript/script.js"></script>
<script type="text/javascript" >
var xmlHttp;
var PoNo = '<?php echo $_GET["pono"]; ?>';
var poYear = '<?php echo $_GET["year"]; ?>';
var reportType = '<?php echo $_GET["reportType"]; ?>';
var intprintState = 1;
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

function ApprovePO()
{
document.getElementById('rptButton').style.display = 'none';
showBackGroundBalck();
	var msgResult = confirm('If you are taking printout at this moment press "OK" other wise press "CANCEL"  ');
	if(!msgResult)
		intprintState = 0;
	ConfirmValidation(PoNo,poYear);
}

function ConfirmValidation(pono,year)
{
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleConfirmValidation;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=ConfirmValidation&pono=' + pono + '&year=' + year, true);
   xmlHttp.send(null);
}

function HandleConfirmValidation()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  		
			var XMLResult =xmlHttp.responseXML.getElementsByTagName("Result");
			var XMLmessage=xmlHttp.responseXML.getElementsByTagName("Body");
			if (XMLResult[0].childNodes[0].nodeValue == "true")
			{				
				changeMatRatio(PoNo,poYear);					
			}
			else
			{
				alert(XMLmessage[0].childNodes[0].nodeValue);
				hideBackGroundBalck();
				return false;
			}
		}
		
	}
}

function changeMatRatio(pono,year)
{
	
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handleMatratio;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=changeMatRatio&pono=' + pono + '&year=' + year, true);
   xmlHttp.send(null);  			

}
function handleMatratio()
{
if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  
		var state=xmlHttp.responseXML.getElementsByTagName("State")[0].childNodes[0].nodeValue;
		if(state=="TRUE")
		{
		changeState();	
		}
		}
	}
	
}

function changeState()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handleConfirm;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=confirm&pono='+PoNo + '&year=' + poYear, true);	
	xmlHttp.send(null); 
}
function handleConfirm()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var state=xmlHttp.responseXML.getElementsByTagName("State")[0].childNodes[0].nodeValue;
			
			if(state=="TRUE")
			{
				hideBackGroundBalck();
				
				if(document.getElementById('normalreport').checked)				   
				location = "oritpurchasenormal.php?pono="+ PoNo + "&year=" + poYear + "&printState=" + intprintState;
				else
				location = "reportpurchase.php?pono="+ PoNo + "&year=" + poYear + "&printState=" + intprintState;				
				
				window.opener.location.reload();
			}
		}
	}
	
}

function validatePOStatus()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleConfirmValidationStaus;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=ConfirmValidationPOStatus&pono=' + PoNo + '&year=' + poYear, true);
   xmlHttp.send(null);
}

function HandleConfirmValidationStaus()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var state=xmlHttp.responseXML.getElementsByTagName("status")[0].childNodes[0].nodeValue;
			
			if(state == '10')
			{
			
				document.getElementById("rptButton").style.visibility	=	"hidden";
			}
		}
	}
}

function rejectFistAppPO()
{
document.getElementById('rptButton').style.display = 'none';
showBackGroundBalck();
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleRejectedPOStaus;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=RejectSendToApprovePO&pono=' + PoNo + '&year=' + poYear, true);
   xmlHttp.send(null);
}

function HandleRejectedPOStaus()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var state=xmlHttp.responseXML.getElementsByTagName("status")[0].childNodes[0].nodeValue;
						
			if(state==1)
			{
				
				status = 1;
				hideBackGroundBalck();
				location="approvePOresult.php?status="+ status;	
			}
			/*else
			{
				
			location="approvePOresult.php?status="+ status;	
			}*/
		}
	}
	
}

function openNormalReport()
{
	var reportType = 'normal';
	
	location="poConfirmReport.php?reportType="+ reportType+"&pono="+PoNo+"&year="+poYear;
	
}

function openotherReport()
{
	var reportType = '';
	
	location="poConfirmReport.php?reportType="+ reportType+"&pono="+PoNo+"&year="+poYear;	
}

</script>
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>


<body onload="validatePOStatus();">

<table width="800" border="0" align="center" cellpadding="0" celspacing="0">
  <tr>
    <td colspan="4">
		<table width="100%">
		<tr>
		<td colspan="3"> <?php 
		if($_GET["reportType"] == 'normal')
			include "oritreportpurchase.php";
		else	
			include "reportpurchase.php" ?></td>		
		</tr>
			<!--<tr bgcolor="#d6e7f5" id="approveTr">
				<td class="normalfntLeftTABNoBorder"><input type="radio" checked id="normalreport" name="report"> Normal Report</td>
				<td class="normalfntLeftTABNoBorder"><input type="radio" id="otherreport" name="report"> Other Report</td>
				<td><div align="right"><img src="images/approve.png" class="mouseover" onclick="ApprovePO();" alt="view" id="butApprove"/></div></td>
			</tr>-->
            <tr><td colspan="3">
            	<div id="rptButton">
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr bgcolor="#d6e7f5">
                        <td class="normalfntLeftTABNoBorder">&nbsp;<input type="radio" <?php if($_GET["reportType"] == '') {?> checked="checked" <?php } ?> id="otherreport" name="report" onclick="openotherReport();"> Normal Report</td>
                         <td class="normalfntLeftTABNoBorder"><input type="radio" <?php if($_GET["reportType"] == 'normal') {?> checked="checked" <?php } ?> id="normalreport" name="report" onclick="openNormalReport();"> 
                         Other  Report</td>
                         <td><div align="right"><img src="images/approve.png" class="mouseover" onclick="ApprovePO();" alt="view" id="butApprove"/><img src="images/reject.png" onclick="rejectFistAppPO();"/></div></td>
                      </tr>
                    </table>
                </div>
            </td></tr>
		</table>    
    </td>
  </tr>
</table>
<script typr="text/javascript">

</script>
</body>
</html>
