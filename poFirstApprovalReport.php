<?php 
session_start();
include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Purchase Order First Approve Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;
var PoNo = '<?php echo $_GET["pono"]; ?>';
var poYear = '<?php echo $_GET["year"]; ?>';
var reportType = '<?php echo $_GET["reportType"]; ?>';
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

function FirstApprovePO()
{

	ConfirmValidationFirstApprove(PoNo,poYear);
}

function ConfirmValidationFirstApprove(pono,year)
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = HandleConfirmValidationFapproval;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=ConfirmValidation&pono=' + pono + '&year=' + year, true);
   xmlHttp.send(null);
}

function HandleConfirmValidationFapproval()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {  		
			var XMLResult =xmlHttp.responseXML.getElementsByTagName("Result");
			var XMLmessage=xmlHttp.responseXML.getElementsByTagName("Body");
			if (XMLResult[0].childNodes[0].nodeValue == "true")
			{				
				//changeMatRatio(PoNo,poYear);	
				changeStateFirstApproval();				
			}
			else
			{
				alert(XMLmessage[0].childNodes[0].nodeValue);
				return false;
			}
		}
		
	}
}

/*function changeMatRatio(pono,year)
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
	
}*/

function changeStateFirstApproval()
{
	createXMLHttpRequest();
	xmlHttp.onreadystatechange = handleConfirmFApproval;
	xmlHttp.open("GET", 'POMiddle.php?RequestType=confirmfirstApprove&pono='+PoNo + '&year=' + poYear, true);	
	xmlHttp.send(null); 
}
function handleConfirmFApproval()
{
	if(xmlHttp.readyState == 4) 
    {
        if(xmlHttp.status == 200) 
        {
			var state=xmlHttp.responseXML.getElementsByTagName("State")[0].childNodes[0].nodeValue;
			var status = 0;
			if(state=="TRUE")
			{
				/*if(document.getElementById('normalreport').checked)
				location = "reportpurchase.php?pono="+ PoNo + "&year=" + poYear;
				else
				location = "reportpurchaseOther.php?pono="+ PoNo + "&year=" + poYear;*/
				status = 2;
				//window.open("approvePOresult.php?status=" + status);
				location="approvePOresult.php?status="+ status;	
			}
			else
			{
				//window.open("approvePOresult.php?status=" + status);
			location="approvePOresult.php?status="+ status;	
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

function rejectPO()
{
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
	
	location="poFirstApprovalReport.php?reportType="+ reportType+"&pono="+PoNo+"&year="+poYear;
	
}

function openotherReport()
{
	var reportType = '';
	
	location="poFirstApprovalReport.php?reportType="+ reportType+"&pono="+PoNo+"&year="+poYear;	
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
                        <td><div align="right"><img src="images/approve.png" class="mouseover" onclick="FirstApprovePO();" alt="view" id="butApprove"/><img src="images/reject.png" onclick="rejectPO();"/></div></td>
                      </tr>
                    </table>
                </div>
            </td></tr>
		</table>    
    </td>
  </tr>
</table>

</body>
</html>

