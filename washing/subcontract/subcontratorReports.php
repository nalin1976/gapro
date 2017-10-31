<?php
session_start();
$backwardseperator = "../../";
include "../../Connector.php";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gapro:Washing-</title>
<link href="../../js/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css" />
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="../../javascript/calendar/theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../javascript/script.js"></script>

<script src="subcontractor.js" type="text/javascript"></script>

<script type="text/javascript">
function fromSubmit(){
document.getElementById('frmSubRpt').submit();
}
</script>
</head>

<body>

<table width="100%" border="0" align="center" bgcolor="#FFFFFF">
	<tr>
		<td height="6" colspan="2"></td>
	</tr> 
</table>
<form name="frmSubRpt" id="frmSubRpt" method="GET">
<table width="250" border="0" align="center" class="bcgl1" bgcolor="#FFFFFF">
  <tr>
  	<td class="mainHeading" colspan="3"><div align="center" style="width:200px;float:left;">Sub Contractor Reports </div>
    <div align="right" style="width:20px;float:right;"><img src="../../images/cross.png" onclick="CloseWindowInBC();" /></div></td>
<!--    <td class="mainHeading"></td>-->
  </tr>
  <tr>
  	  <td width="50" class="normalfnt" >&nbsp;</td>
 	  <td width="20" class="normalfnt" ><input type="radio" name="rdoSubContract" checked="checked"/></td>
      <td width="180" class="normalfnt" >Sub Contractor Log</td>
  </tr>
  <tr>
  	  <td class="normalfnt" >&nbsp;</td>
 	  <td class="normalfnt" ><input type="radio" name="rdoSubContract" /></td>
      <td class="normalfnt" >Sub Contractor WIP</td>
  </tr>
  <tr>
  	  <td class="normalfnt" >&nbsp;</td>
 	  <td class="normalfnt" >&nbsp;</td>
      <td class="normalfnt" ><img src="../../images/report.png" onclick="subReports();" /></td>
  </tr>
</table>
</form>
</body>
</html>
