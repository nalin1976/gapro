<?php 
session_start();include "authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;
var PoNo = '<?php echo $_GET["pono"]; ?>';
var poYear = '<?php echo $_GET["year"]; ?>';

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
				alert("PO quantities are OK. You can continue this for confirmation.");					
			}
			else
			{
				alert(XMLmessage[0].childNodes[0].nodeValue);
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
				if(document.getElementById('normalreport').checked)
				location = "reportpurchase.php?pono="+ PoNo + "&year=" + poYear;
				else
				location = "reportpurchaseOther.php?pono="+ PoNo + "&year=" + poYear;
			}
		}
	}
	
}



</script>
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>


<body>

<table width="800" border="0" align="center" cellpadding="0" celspacing="0">
  <tr>
    <td colspan="4">
		<table width="100%">
		<tr>
		<td colspan="3"> <?php include "reportpurchase.php" ?></td>		
		</tr>
			<tr bgcolor="#d6e7f5">
				<td colspan="3"><div align="right"><img src="images/allcompleted.png" class="mouseover" onclick="ApprovePO();" alt="view" /></div></td>
			</tr>
		</table>    
    </td>
  </tr>
</table>
</body>
</html>
