<?php
$backwardseperator = "";
session_start();
include("Connector.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="javascript/calendar/theme.css" />
</head>

<body>
<table width="504" height="150" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr class="mainHeading">
    <td height="25" colspan="2" >&nbsp;Copy Instructions </td>
    <td align="center"><img src="images/cross.png" alt="1" width="17" height="17"  class="mouseover" onclick="ClosePoPopUp('popupLayer1')"/></td>
  </tr>
  <tr>
    <td height="25" class="normalfnt">&nbsp;PO No</td>
    <td class="normalfnt" >
		<input name="txtInPopPoNo"  class="txtbox" id="txtInPopPoNo" style="width:120px" onKeyPress="LoadPoInstruction(this,event);" onblur="LoadPoInstructionOnBlur(this)">	</td>
    <td width="46">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td ><textarea class="normalfnt" name="txtPopUpIntro" style=" height:100px; width:407px;"id="txtPopUpIntro"></textarea></td>
    <td align="center" valign="middle"><img src="images/do_copy.png" alt="1" class="mouseover" width="32" height="31" onclick="CopyIntroToMain(this)" /></td>
  </tr>
  <tr>
    <td width="48">
    <div align="right"></div></td>
    <td width="410">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
