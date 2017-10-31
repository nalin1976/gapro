<?php 
session_start();
include "../../authentication.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<script src="generalPo-java.js" type="text/javascript"></script>
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
		<td colspan="4"></td>		
		</tr>
			<tr bgcolor="#d6e7f5">
				<td width="35%" class="normalfntLeftTABNoBorder">&nbsp;</td>
				<td width="15%" class="normalfntLeftTABNoBorder"><img src="../../images/approve.png" class="mouseover" onclick="ApproveGenPo();" alt="view" /></td>
				<td width="15%" class="normalfntLeftTABNoBorder"><img src="../../images/reject.png" alt="reject"   /></td>
				<td width="35%">&nbsp;</td>
			</tr>
		</table>    
    </td>
  </tr>
</table>
<script type="text/javascript">
var xmlHttp=[];

function createXMLHttpRequest(index){
    if (window.ActiveXObject) 
    {
        xmlHttp[index] = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (window.XMLHttpRequest) 
    {
        xmlHttp[index] = new XMLHttpRequest();
    }
}
function ApproveGenPo(){
	var genpono =<?php echo $_GET["bulkPoNo"];?>;
	var genyear =<?php echo $_GET["intYear"];?>;
	
	createXMLHttpRequest(1);
	xmlHttp[1].onreadystatechange = saveBulPoConfirm;		
	xmlHttp[1].open("GET",'generalPo-db.php?id=confirmBulkPo&intGenPONo=' +genpono+ '&intYear=' +genyear,true);
	xmlHttp[1].send(null);
}
function saveBulPoConfirm()
{
		if( xmlHttp[1].readyState == 4 && xmlHttp[1].status == 200 ) 
		{
			var intConfirm = xmlHttp[1].responseText;
			if(intConfirm)				
				setTimeout("location.reload(true);",0);
			else
				alert("Error \nGeneral Po is not confirmed");
		}
}
</script>
</body>
</html>
