<?php
$backwardseperator = "../../";
session_start();
include("../../Connector.php");
$iouno=$_GET[iouno];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../javascript/calendar/theme.css" />
</head>

<body>
<table width="320" height="150" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="bcgcolor-row">
    <td height="24" colspan="4"  class="normaltxtmidb2L"> &nbsp; Confirmation Window </td>
    <td width="20"  align="left"><img src="../../images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="closeWindow()"/></td>
  </tr>
  <tr>
    <td height="35" colspan="5"><div align="center" class="normalfnth2Bm">Reasons For the Cancellation of IOU No : <?php echo "\t".$iouno;?></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><textarea name="txtReason"  style=" height:100px; width:200px; " id="txtReason">No need to concern.</textarea></td>
    <td ><div align="center"><img src="../../images/do_copy.png" alt="1" class="mouseover" width="32" height="31" onclick="docancel();" /></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="29">
    <div align="right"></div></td>
    <td width="201">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="66">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
